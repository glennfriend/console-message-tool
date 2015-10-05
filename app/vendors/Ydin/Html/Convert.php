<?php
/**
 *  Html Convert
 *
 *  @category    Ydin
 *  @package     Ydin\Html\Convert
 *  @uses
 */
namespace Ydin\Html;

class Convert
{
    /**
     *  htmlString The original string with html entities encoded
     *  將已經被編碼過的 unicode 解碼為正常文字碼
     *  
     *  使用時機:
     *      一段被編碼過的內容, 如果要搜尋, 將是不可能的~
     *      所以如果內容想要被搜尋到, 請解碼後存在某個 "專門用於搜尋的欄位"
     *
     *  example:
     *      "&#36935; &#21040;" to "遇 到"
     *
     *  @param html string
     *  @return The decoded html string
     */
    function entitiesDecode( $html )
    {
        return preg_replace_callback(
            '~(&#[0-9a-f]+;)~i',
            function ($matches) {
                return mb_convert_encoding($matches[0], 'UTF-8', 'HTML-ENTITIES');
            },
            $html
        );
    }

}
