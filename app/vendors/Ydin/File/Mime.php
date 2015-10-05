<?php

/**
 *  File Mime
 *
 *  @version     1.0.0.0
 *  @category    Ydin
 *  @package     Ydin\File\Mime
 *  @uses
 */
namespace Ydin\File;

class Mime
{

    /**
     *  get mime by file
     */
    public static function getByFile( $file )
    {
        return finfo_file(
            finfo_open(FILEINFO_MIME_TYPE), $file
        );
    }


    /**
     *  代入 mime 找 extend name
     *  @param string mime
     *  @return string or null
     */
    public static function getExtendByMime( $mime )
    {
        $group = self::getGroup();
        foreach ( $group as $name => $extends ) {
            if ( in_array( $mime, $extends ) ) {
                return $name;
            }
        }
        return null;
    }

    /**
     *  常用格式分類
     */
    public static function getGroup( $group=null )
    {
        $list = array(
            'csv' => array(
                'text/csv',
                'text/comma-separated-values',
                'application/csv-tab-delimited-table',
                'application/vnd.ms-excel',
                'application/octet-stream',
            ),
            'gif' => array(
                'image/gif',
            ),
            'jpg' => array(
                'image/jpeg',
                'image/pjpeg',
            ),
            'png' => array(
                'image/png',
            ),
            'tif' => array(
                'image/tiff',
                'image/x-tiff',
            ),
            'bmp' => array(
                'image/bmp',
                'image/x-windows-bmp',
            ),
            'ico' => array(
                'image/vnd.microsoft.icon',
            ),
            'psd' => array(
                'image/vnd.adobe.photoshop',
            ),
        );

        if ( $group && isset($list[$gruop]) ) {
            return $list[$gruop];
        }
        return $list;
    }

    

}

