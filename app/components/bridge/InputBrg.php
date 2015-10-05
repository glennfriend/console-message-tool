<?php

class InputBrg
{

    /**
     *  dispatcher
     */
    private static $dispatcher = array();

    /**
     *  request
     */
    private static $request = array();

    /**
     *  request init
     */
    public static function init($di)
    {
        self::$dispatcher = $di->getDispatcher();
        self::$request    = $di->getRequest();
    }

    /**
     *  get filter value
     *  @see http://blog.gslin.org/archives/2013/12/27/4012/filter-input-escape-output/
     */
    /*
    public static function strFilter( $key, $defaultValue=null )
    {
        $value = self::get( $key, $defaultValue );
        $value = iconv('UTF-8', 'UTF-8', $value);
        return trim(strip_tags($value));
    }

    public static function intFilter( $key, $defaultValue=null )
    {
        return intval( self::get( $key, $defaultValue ) );
    }
    */


    /**
     *  get $_POST or $_GET value
     */
    public static function get( $key, $defaultValue=null )
    {
        if ( !self::has($key) ) {
            return $defaultValue;
        }
        return self::post($key) ?: self::query($key);
    }

    /**
     *  has input $_POST or $_GET
     */
    public static function has( $key )
    {
        return self::post(  $key ) ? true :
               self::query( $key ) ? true :
               false;
    }

    /**
     *  get $_GET value
     */
    public static function query( $key, $defaultValue=null )
    {
        return isset($_GET[$key]) ? $_GET[$key] : $defaultValue;
    }

    /**
     *  get $_POST value
     */
    public static function post( $key, $defaultValue=null )
    {
        return isset($_POST[$key]) ? $_POST[$key] : $defaultValue;
    }

    /**
     *  is post
     */
    public static function isPost()
    {
        return self::$request->isPost();
        // return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST' );
    }

    /**
     *  get a post file or all post files
     */
    public static function files( $filename='' )
    {
        if ( $filename && isset($_FILES[$filename]) ) {
            return $_FILES[$filename];
        }
        return $_FILES;
    }



    /**
     *  取得 framework 自己 parse router 格式的值
     */
    public static function getParam( $key )
    {
        return self::$dispatcher->getParam( $key );
    }

    /**
     *  取得 framework 自己 parse router 格式所有的值
     */
    public static function getParams()
    {
        return self::$dispatcher->getParams();
    }


    /**
     *  is ajax
     */
    public static function isAjax()
    {
        return self::$request->isAjax();
        // return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
    }

    /**
     *  is https
     */
    // public static function isHttps()
    // {
    //     return !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'],'off');
    // }


    /**
     *  get post files
     */
    // public static function files( $filename )

    
}
