<?php

use GorkaLaucirica\HipchatAPIv2Client\Auth\OAuth2;
use GorkaLaucirica\HipchatAPIv2Client\Client;
use GorkaLaucirica\HipchatAPIv2Client\Model\Message;
use GorkaLaucirica\HipchatAPIv2Client\API\RoomAPI;

/**
 *  請查閱 document
 */
class GoHipchat
{

    public function perform( array $params )
    {
        $msg     = isset($params['m'])       ? $params['m']       : '';
        $room    = isset($params['room'])    ? $params['room']    : '';
        $color   = isset($params['color'])   ? $params['color']   : 'black';
        $bgcolor = isset($params['bgcolor']) ? $params['bgcolor'] : '';
        $content = '<span style="color:'. $color .'">'. $msg .'</span>';

        $room = preg_replace('/[^a-zA-Z0-9_\-]+/', '', $room );

        $key = Config::get('hipchat.key');

        try {
            $auth  = new OAuth2($key);
            $client = new Client($auth);

            $envelope = new Message();
            $envelope->setMessage($content);
            if ( $bgcolor ) {
                $envelope->setColor($bgcolor);
            }

            $roomAPI = new RoomAPI($client);
            $roomAPI->sendRoomNotification($room, $envelope);

        } catch ( Exception $e ) {
            exit;
        }

        /*
            get rooms   - $roomAPI->getRooms(array('max-results' => 30));
        */
    }

}

