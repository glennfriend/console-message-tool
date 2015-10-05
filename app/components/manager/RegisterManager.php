<?php

/**
 *  Global value registry
 *
 *  只暫存資料在一次的 http request respond
 *
 */
class RegisterManager
{

    /**
     *  @param array $data
     */
    private static $data = array();

    /**
     *  是否已設定資料
     *  @param  string $key
     *  @return boolean
     */
    public static function has( $key )
    {
        if( isset(self::$data[$key]) ) {
            return true;
        }
        return false;
    }

    /**
     *  @param string $key
     */
    public static function get( $key )
    {
        if( isset(self::$data[$key]) ) {
            return self::$data[$key];
        }
    }

    /**
     * @param string $key
     * @param string $value
     */
    public static function set( $key, $value )
    {
        self::$data[$key] = $value;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public static function append( $key, $value )
    {
        $oldValue = self::get($key);
        self::set( $key, $oldValue . $value );
    }


}

