<?php

/**
 *  bridge phalcon Cache
 */
class CacheBrg
{

    /**
     *  cache
     */
    private static $cache = array();

    /**
     *  session init
     */
    public static function init( $cachePath )
    {
        //self::$cache = $di->getCache();

        // Frontend: 主要負責檢查KEY是否過期
        // 以及 在存儲到backend之前 / 從backend取數據之后執行額外的數據轉換
        $frontCache = new Phalcon\Cache\Frontend\Data(array(
            "lifetime" => Config::get('cache.lifetime')
        ));

        $cache = new CacheBrgFile();
        $cache->init( $cachePath, $frontCache );

        self::$cache = $cache;
    }

    /* --------------------------------------------------------------------------------
        access
    -------------------------------------------------------------------------------- */

    /**
     *  get cache
     */
    public static function get( $key )
    {
        return self::$cache->get( $key );
    }

    /*
    public static function has( $key )
    {
        if ($cache->exists($key) ) {
            return true;
        }
        return false;
    }
    */

    /* --------------------------------------------------------------------------------
        write
    -------------------------------------------------------------------------------- */

    /**
     *  set cache
     */
    public static function set( $key, $value )
    {
        self::$cache->set( $key, $value );
    }

    // public static function forever 無時間限制的快取

    /**
     *  remove cache
     */
    public static function remove( $key )
    {
        self::$cache->remove( $key );
    }

    // public static function removePrefix 移除該值開頭的所有快取

    /**
     *  clean all cache data
     */
    public static function flush()
    {
        self::$cache->flush();
    }

}
