<?php
/**
 *  Log Bridge
 */
class LogBrg
{

    /**
     *  dispatcher
     */
    private static $logPath = null;

    /**
     *
     */
    public static function init( $logPath='' )
    {
        if ( $logPath ) {
            self::$logPath = $logPath;
        }
    }

    /**
     *  developer custom log
     */
    public static function custom( $logFile, $content )
    {
        $content = date("Y-m-d H:i:s") .' - ' . $content;
        self::write( $logFile, $content );
    }

    /**
     *  error log
     */
    public static function error( $content )
    {
        $content = $_SERVER['REMOTE_ADDR'] .' - '. date("Y-m-d H:i:s") . ' - '. $content;
        /*
            $content = 'post '.    print_r($_POST, true)    . $content;
            $content = 'session '. print_r($_SESSION, true) . $content;
        */
        self::write( 'error.log', $content );
    }

    /**
     *  access log
     */
    public static function access( $content )
    {
        $content = $_SERVER['REMOTE_ADDR'] .' - '. date("Y-m-d H:i:s") . ' - '. $content;
        self::write( 'access.log', $content );
    }

    /**
     *  frontend log 
     */
    public static function frontend( $controller, $action )
    {
        $content
            = $_SERVER['REMOTE_ADDR']
            .' - '
            . date("Y-m-d H:i:s")
            . ' - '
            . $controller
            . '/'
            . $action
            . ' - '
            . $_SERVER['REQUEST_URI'];

        self::write( 'frontend.log', $content );
    }

    /**
     *  backend log 
     */
    public static function backend()
    {
        $content 
            = $_SERVER['REMOTE_ADDR']
            .' - '
            . date("Y-m-d H:i:s")
            . ' - '
            . $_SERVER['REQUEST_URI'];

        self::write( 'backend.log', $content );
    }

    /**
     *  backend login log
     */
    public static function backendLogin( $content )
    {
        $content
            = $_SERVER['REMOTE_ADDR']
            .' - '
            . date("Y-m-d H:i:s")
            . ' - '
            . $content;

        self::write( 'backend-login.log', $content );
    }

    /**
     *  queue log
     */
    public static function queue( $content )
    {
        $content
            = date("Y-m-d H:i:s")
            . ' - '
            . $content;

        self::write( 'queue.log', $content );
    }

    /**
     *  monitor log
     */
    public static function monitor( $content )
    {
        $content = date("Y-m-d H:i:s") .' - '. $content;
        self::write( 'monitor.log', $content );
    }

    /* --------------------------------------------------------------------------------
        private
    -------------------------------------------------------------------------------- */

    /**
     *  write file
     */
    public static function write( $file, $content )
    {
        if (!preg_match('/^[a-z0-9_\-\.]+$/i', $file)) {
            return;
        }
    
        $filename = self::$logPath .'/'. $file;
        file_put_contents( $filename, $content."\n", FILE_APPEND );
    }

}

