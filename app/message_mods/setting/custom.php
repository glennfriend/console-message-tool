<?php

    SessionBrg::init($di);
    CookiesBrg::init($di);

    /**
     *  zend loader
     */
    $zendLoader = function()
    {
        $basePath = Config::get('app.base.path');
        require_once $basePath . '/app/vendors/Zend/Loader/StandardAutoloader.php';
        
        $loader = new Zend\Loader\StandardAutoloader(array(
            'autoregister_zf' => true,
            'namespaces' => array(
                'Ydin'    => $basePath . '/app/vendors/Ydin',
                'Imagine' => $basePath . '/app/vendors/Imagine',
            ),
        ));
        $loader->register();
    };
    $zendLoader();

