<?php

class SessionBrgFile
{
    /**
     *  session
     */
    private $session;

    /**
     *  session init
     */
    public function init( $di )
    {
        session_save_path( Config::get('app.base.path') . '/var/session' );

        $session = new Phalcon\Session\Adapter\Files(array(
            'uniqueId' => Config::get('app.private_dynamic_code')
        ));
        $session->start();

        $di->set('session', $session);
        $this->session = $session;
    }

    /* --------------------------------------------------------------------------------
        access
    -------------------------------------------------------------------------------- */

    /**
     *  get session
     */
    public function get( $key, $defaultValue )
    {
        $val = $this->session->get($key);
        if ( !$val && $defaultValue ) {
            return $defaultValue;
        }
        return $val;
    }

    /* --------------------------------------------------------------------------------
        write
    -------------------------------------------------------------------------------- */

    /**
     *  set
     */
    public function set( $key, $value )
    {
        return $this->session->set( $key, $value );
    }

    /**
     *  remove
     */
    public function remove( $key )
    {
        $this->session->remove( $key );
    }

    /**
     *  destroy all
     */
    public function destroy()
    {
        $this->session->destroy();
    }

}
