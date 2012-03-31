<?php

// Databases
$app['db.config.driver']    = 'pdo_mysql';
$app['db.config.dbname']    = 'silex';
$app['db.config.host']      = '127.0.0.1';
$app['db.config.user']      = 'root';
$app['db.config.password']  = '';

// Debug
$app['debug'] = true;

// Local
$app['locale'] = 'fr';
$app['session.default_locale'] = $app['locale'];
$app['translator.messages'] = array(
    'fr' => __DIR__.'/../resources/locales/fr.yml',
);

// Cache
$app['cache.path'] = __DIR__ . '/../cache';

// Http cache
$app['http_cache.cache_dir'] = $app['cache.path'] . '/http';

// Assetic
$app['assetic.path_to_cache']       = $app['cache.path'] . DIRECTORY_SEPARATOR . 'assetic' ;
$app['assetic.path_to_web']         = __DIR__ . '/../web/assets';

$app['assetic.input.path_to_assets']    = __DIR__ . '/../resources/assets';
$app['assetic.input.path_to_vendor']    = __DIR__ . '/../vendor';
$app['assetic.input.path_to_css']       = array(
    #$app['assetic.input.path_to_assets'] . '/css/*.css',
    $app['assetic.input.path_to_vendor'] . '/ajkochanowicz/kickstrap/extras/h5bp/css/style.css',
    $app['assetic.input.path_to_vendor'] . '/ajkochanowicz/kickstrap/css/bootstrap.css',
    #$app['assetic.input.path_to_vendor'] . '/ajkochanowicz/kickstrap/extras/css/readable.css',
);
$app['assetic.output.path_to_css']      = '/css/styles.css';
$app['assetic.input.path_to_js']        = array(
    $app['assetic.input.path_to_vendor'] . '/ajkochanowicz/kickstrap/extras/h5bp/js/plugins.js',
    $app['assetic.input.path_to_vendor'] . '/ajkochanowicz/kickstrap/extras/h5bp/js/libs/modernizr-2.5.3.min.js',
    $app['assetic.input.path_to_vendor'] . '/ajkochanowicz/kickstrap/extras/h5bp/js/libs/jquery-1.7.1.js',
    $app['assetic.input.path_to_vendor'] . '/ajkochanowicz/kickstrap/js/bootstrap-twipsy.js',
    $app['assetic.input.path_to_vendor'] . '/ajkochanowicz/kickstrap/js/bootstrap-*.js',
    $app['assetic.input.path_to_vendor'] . '/ajkochanowicz/kickstrap/extras/h5bp/js/script.js',
);
$app['assetic.output.path_to_js']       = '/js/scripts.js';

$app['assetic.filter.yui_compressor.path'] = '/usr/share/yui-compressor/yui-compressor.jar';
