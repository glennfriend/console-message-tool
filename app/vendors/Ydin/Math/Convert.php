<?php

// 未測試, 未使用
exit;

/**
 *  Math Convert
 *
 *  @category    Ydin
 *  @package     Ydin\Math\Convert
 *  @uses
 */
namespace Ydin\Math;

class Convert
{

    /**
     *  Calculate the human-readable file size (with proper units)
     */
    function size( $bytes )
    {
        $units = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
        return @round($size / pow(1024, ($i = floor(log($bytes, 1024)))), 2).' '.$units[$i];
        
        /*
            $s = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
            $e = floor(log($bytes)/log(1024));
            return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
        */
    }

    

}
