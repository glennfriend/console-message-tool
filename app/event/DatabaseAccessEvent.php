<?php

/**
 *  資料庫行 存/取 行為
 */
class DatabaseAccessEvent
{

    public function sql_query_before( $data )
    {
        $adapter = $data['adapter'];
        $select  = $data['select'];

        // sql query log
        $content = $select->getSqlString( $adapter->getPlatform() );
        $content = date("Y-m-d H:i:s") ." - qu - ". $content;
        LogBrg::write( 'sql.log', $content );

        // developer tool
        if ( class_exists('MonitorManager') ) {
            MonitorManager::sqlQuery( $select->getSqlString( $adapter->getPlatform() ) );
        }

    }

    public function sql_execute_before( $data )
    {
        $adapter = $data['adapter'];
        $write   = $data['write'];

        // sql execute log
        $content = $write->getSqlString( $adapter->getPlatform() );
        $content = date("Y-m-d H:i:s") ." - ex - ". $content;
        LogBrg::write( 'sql.log', $content );

        // developer tool
        if ( class_exists('MonitorManager') ) {
            MonitorManager::executeQuery( $write->getSqlString( $adapter->getPlatform() ) );
        }
    }

}
