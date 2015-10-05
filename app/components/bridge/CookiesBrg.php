<?php

class CookiesBrg
{

    /**
     *  store di
     */
    private static $di;

    /**
     *  cookie init
     */
    public static function init( $di )
    {
        $cookie = new Phalcon\Http\Response\Cookies();
        $cookie->useEncryption(false);

        $di->set('cookie', $cookie );
        self::$di = $di;

        self::set(
            session_name(),
            session_id(),
            array(
                'expire' => Config::get('app.login_lifetime')
            )
        );
    }

    /**
     *  get cookie
     */
    public static function get($key)
    {
        $value = self::$id->get('cookie')->get( $key );
        if ( !$value ) {
            return null;
        }
        return $value;
    }

    /**
     *  set cookie
     *
     *  注意 cookie 的特性, 在設定完的那一次, 無法取得該 cookie 值
     *  除非你回寫值到 $_COOKIE 之中
     */
    public static function set($key, $value, $option=array() )
    {

        if ( is_array($option) ) {
            if( isset($option['expire']) ) {
                self::$di->get('cookie')->set( $key, $value, time() + $option['expire'] );
            }
            /*
            elseif( $option['expire'] && $option['path'] ) {
                self::$cookies->set( $key, $value, time() + $option['expire'], $option['path'] );
            }
            elseif( $option['expire'] && $option['path'] && $option['domain'] ) {
                self::$cookies->set( $key, $value, time() + $option['expire'], $option['path'], $option['domain'] );
            }
            */
        }
    }

    /**
     *
     */
    public static function remove($key)
    {
        self::$id->get('cookie')->delete( $key );
    }

}
