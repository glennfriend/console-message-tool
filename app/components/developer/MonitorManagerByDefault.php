<?php

class MonitorManagerByDefault
{

    /**
     *  
     */
    public function sqlQuery( $sql )
    {
        // return;
        LogBrg::monitor( ' - qu - '. $sql );
        // echo '<pre>'. SqlFormatter::format( $sql, false ) ."</pre>\n";
    }

    /**
     *  
     */
    public function executeQuery( $sql )
    {
        // return;
        LogBrg::monitor( ' - ex - '. $sql );
        // echo '<pre>'. SqlFormatter::format( $sql, false ) ."</pre>\n";
    }

}


