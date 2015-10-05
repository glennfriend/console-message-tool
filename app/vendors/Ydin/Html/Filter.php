<?php
/**
 *  Html Filter
 *
 *  @category    Ydin
 *  @package     Ydin\Html\Filter
 *  @uses
 */
namespace Ydin\Html;

class Filter
{

    /**
     *  filter html tags
     *  只去除 html tags, 但是不會清掉裡面的內容
     */
    public static function htmlTags( $html )
    {
        return trim(strip_tags($html));
    }

    /**
     *  filter javascript tags
     *  去掉 javascript tag 以及裡面所有的內容
     */
    public static function javascriptTags( $html )
    {
        // Strip all of the Javascript in script tags out...
        $html = preg_replace('/<script.*?<\/script>/ims',"",$html);

        /** copied from the original function **/
        /*  The following matches any on* events, followed by any amount of space, a
         *  ' or " some script and then the matching ' or " (the \\2 matches the
         *  single or double quote).  Note that this regex is
         *  in single quotes to alleviate the problem of double quoting special
         *  chars, otherwise the backreferenced 2 would be \\\\2
         *  -- which is just silly...
         */
        $html = preg_replace('/on(Load|Click|DblClick|DragStart|KeyDown|KeyPress|KeyUp|MouseDown|MouseMove|MouseOut|MouseOver|SelectStart|Blur|Focus|Scroll|Select|Unload|Change|Submit)\s*=\s*(\'|").*?\\2/smi', "", $html);
        $html = preg_replace('/(\'|")Javascript:.*?\\1/smi','',$html);
        return $html;
    }

}
