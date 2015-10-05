<?php

/**
 *  debug mode 行為
 */
class DebugModeEvent
{

    public function init_footer( $data )
    {
        $app = $data['app'];

        if( !SessionBrg::get('is_debug') ) {
            return;
        }

        // enabled debug mode
        error_reporting(E_ALL);
        ini_set('html_errors','On');
        ini_set('display_errors','On');

        // Whoops error handler
        new Whoops\Provider\Phalcon\WhoopsServiceProvider( $app->di );
    }

}
