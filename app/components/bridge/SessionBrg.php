<?php

class SessionBrg
{

    /**
     *  store di
     */
    private static $di;

    /**
     *  session init
     */
    public static function init( $di )
    {
        $session = new SessionBrgFile();
        $session->init( $di );

        self::$di = $di;
    }

    /* --------------------------------------------------------------------------------
        access
    -------------------------------------------------------------------------------- */

    /**
     *  get session by key
     */
    public static function get( $key, $defaultValue=null )
    {
        return self::$di->get('session')->get($key, $defaultValue);
    }

    /* --------------------------------------------------------------------------------
        write
    -------------------------------------------------------------------------------- */

    /**
     *  set
     */
    public static function set( $key, $value )
    {
        return self::$di->get('session')->set( $key, $value );
    }

    /**
     *  remove
     */
    public static function remove( $key )
    {
        self::$di->get('session')->remove( $key );
    }

    /**
     *  destroy all
     */
    public static function destroy()
    {
        self::$di->get('session')->destroy();
    }

}
