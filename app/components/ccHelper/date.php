<?php

function ccHelper_date( $value, $format='Y-m-d' )
{
    if( $value < 0 ) {
        return '';
    }
    return date($format,$value);
}
