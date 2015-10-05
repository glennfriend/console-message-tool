<?php

/**
 *  monitor application information
 *
 *  example:
 *
 *      MonitorManager::on();
 *      // some code ....
 *      MonitorManager::off();
 *
 *
 */
class MonitorManager
{

    /**
     *  monitor status
     *  @boolean
     */
    static protected $_switch = false;

    /**
     *  monitor start
     */
    public static function on()
    {
        self::$_switch = true;
    }

    /**
     *  monitor end
     */
    public static function off()
    {
        self::$_switch = false;
    }

    /**
     *  除錯模式
     *  @return object or false
     */
    public static function getDebugAdapter()
    {
        /*
        if ( is not developer ) {
            return false;
        }
        */

        if ( !self::$_switch ) {
            return false;
        }

        return new MonitorManagerByDefault();
        // return new MonitorManagerByBrian();
        // return new MonitorManagerByChien();
        // return new MonitorManagerByGlenn();
        // return new MonitorManagerByOtherUser();
    }

    /* ================================================================================
        get information
    ================================================================================ */

    /**
     *  SQL query
     */
    public static function sqlQuery( $sql )
    {
        $adapter = self::getDebugAdapter();
        if ( !$adapter || !method_exists( $adapter, 'sqlQuery') ) {
            return false;
        }
        return $adapter->sqlQuery( $sql );
    }

    /**
     *  SQL execute
     */
    public static function executeQuery( $sql )
    {
        $adapter = self::getDebugAdapter();
        if ( !$adapter || !method_exists( $adapter, 'executeQuery') ) {
            return false;
        }
        return $adapter->executeQuery( $sql );
    }

}
