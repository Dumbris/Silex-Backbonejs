<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormError;


$app->match('/', function() use ($app) {
    return $app['twig']->render('layout.html.twig');
})->bind('homepage');


$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    //Always run javascript 
    return new Response($app['twig']->render('layout.html.twig'), 200);
    //return new Response($message, $code);
});

//Auth
//
$app->before(function (Request $request) use ($app) {
    // redirect the user to the login screen if access to the Resource is protected
    $unAuthUrls = array(
        $app['url_generator']->generate('login'),
        $app['url_generator']->generate('homepage'),
    );

    if (in_array($request->getRequestUri(), $unAuthUrls))
    {
        return;
    }


    if (!$app['session']->get('authToken')) {
        if (0 === strpos($request->headers->get('Accept'), 'application/json')) 
        {
            return new Response('Unauthorized',403);
        } else {
            return new RedirectResponse($app['url_generator']->generate('login'));
        }
    }
});

/* Login */
$app->match('/login', function() use ($app) {

    $constraint = new Assert\Collection(array(
        'email'         => array(
            new Assert\NotBlank(),
            new Assert\Email(),
        ),
        'password'  => new Assert\NotBlank(),
    ));

    $datas = array();

    $builder = $app['form.factory']->createBuilder('form', $datas, array('validation_constraint' => $constraint));

    $form = $builder
        ->add('email', 'email', array('label' => 'Email'))
        ->add('password', 'password', array('label' => 'Password'))
        ->getForm()
        ;

    $ret = null;

    if ('POST' === $app['request']->getMethod()) {
        $form->bindRequest($app['request']);

        if ($form->isValid()) {

            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();

            try {
                if ($email == "test@test.com" && $password == "test") {
                    $app['session']->set('authToken', array(
                        'firstName' => 'Tester',
                        'lastName' => 'Tester',
                        'email' => $email
                    ));

                    //FIXME
                    $app['session']->setFlash('notice', 'You are now connected');
                    //FIXME
                    return $app->redirect($app['url_generator']->generate('homepage'));
                } else {
                    $form->addError(new FormError('Wrong password'));
                }
            } catch(\Exception $ex)
            {
                $form->addError(new FormError($ex->getMessage()));
            }

        }
    }
    
    return $app['twig']->render('login.html.twig', array('form_login' => $form->createView(), 'form_name' => 'Login'));
})->bind('login');

/* Logout */
$app->match('/logout', function() use ($app) {
    $app['session']->clear();

    return $app->redirect($app['url_generator']->generate('homepage'));
})->bind('logout');


return $app;
