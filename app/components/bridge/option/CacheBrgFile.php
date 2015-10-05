<?php
/**
 *  phalcon File Cache
 */
class CacheBrgFile
{

    /**
     *  myself
     */
    private $cache = array();

    /**
     *  init
     */
    public function init( $cachePath, $frontCache )
    {
        $this->cache = new Phalcon\Cache\Backend\File($frontCache, array(
            "cacheDir" => $cachePath.'/'
        ));
    }

    /* --------------------------------------------------------------------------------
        access
    -------------------------------------------------------------------------------- */

    /**
     *  get cache
     */
    public function get( $key )
    {
        return $this->cache->get( $key );
    }


    /* --------------------------------------------------------------------------------
        write
    -------------------------------------------------------------------------------- */

    /**
     *  set cache
     */
    public function set( $key, $value )
    {
        $this->cache->save( $key, $value );
    }

    /**
     *  remove cache
     */
    public function remove( $key )
    {
        $this->cache->delete( $key );
    }

    /**
     *  clean all cache data
     */
    public function flush()
    {
        $keys = $this->cache->queryKeys();
        foreach ( $keys as $key ) {
            $this->cache->delete($key);
        }
    }

}
