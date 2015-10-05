<?php
/**
 *  Client UserAgent information
 *
 *  @version     1.0.0.0
 *  @category    Ydin
 *  @package     Ydin\Client\UserAgent
 *  @uses
 */
namespace Ydin\Client;

class UserAgent
{

    protected static $_store = null;

    /**
     *  set user agent
     */
    public static function init( $userAgent )
    {
        self::$_store = trim($userAgent);
    }

    /**
     *  get all browser info
     *  @return array
     */
    public static function getAll()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $path = "C:\\Windows\\Temp\\";
        } else {
            $path = "/tmp/";
        }

        include_once 'Browscap.php';
        $bc = new \phpbrowscap\Browscap($path);
        if ( !self::$_store ) {
            return (array) $bc->getBrowser();
        }
        return (array) $bc->getBrowser( self::$_store );
    }

    /**
     *  get browser
     *  @return string or null
     */
    public static function getBrowser()
    {
        $info = self::getAll();
        if ( isset($info['Browser']) ) {
            return $info['Browser'];
        }
        return null;
    }

}

