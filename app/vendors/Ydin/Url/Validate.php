<?php

exit;

/**
 * Url Vlidate
 *
 * @category    Ydin
 * @package     Ydin\Url\Validate
 * @uses
 */
namespace Ydin\Url;

class Validate
{

    /**
     *  is domain
     */
    function domain( $url )
    {
        return (bool) preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url);
    }

    /**
     *  internet file exists
     */
    function exist( $url )
    {
        // $url = 'http://www.domain.com/somefile.jpg';
        $file_headers = @get_headers($url);
        if( $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            return false;
        }
        return true;
    }

}
