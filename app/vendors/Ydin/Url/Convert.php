<?php

// 未測試, 未使用
exit;

/**
 *  Url Convert
 *
 *  @category    Ydin
 *  @package     Ydin\Url\Convert
 *  @uses
 */
namespace Ydin\Url;

class Convert
{

    /**
     *  mailto
     */
    function mailto( $text )
    {
        return ereg_replace("[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,3}","<a href=\"mailto:\\0\">\\0</a>", $text );
    }

    /**
     *  link
     */
    function link( $text )
    {
        $regex = '@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@';
        return preg_replace( $regex, '<a href="$1" target="_blank">$1</a>', $text );
    }

}
