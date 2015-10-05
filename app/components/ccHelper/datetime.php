<?php

function ccHelper_datetime( $value, $format='Y-m-d H:i:s' )
{
    if( $value < 0 ) {
        return '';
    }
    return date($format,$value);
}
