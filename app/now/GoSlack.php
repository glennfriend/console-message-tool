<?php

/**
 *  請查閱 document
 *
 *  API 可參考官網, example:
 *
 *      - https://api.slack.com/methods/chat.postMessage
 *
 */
class GoSlack
{

    public function perform(array $params)
    {
        $message  = isset($params['m'])        ? $params['m']        : '';
        $room     = isset($params['room'])     ? $params['room']     : 'test';
        $username = isset($params['username']) ? $params['username'] : 'bot';

        $room = preg_replace('/[^a-zA-Z0-9_\-#]+/', '', $room);
        $token = Config::get('slack.token');

        // $message = preg_replace('/ /', '.', $message );

        try {
            $slack = new Slack($token);
            $slack->call('chat.postMessage', array(
                'channel'   => $room,
                'text'      => $message,
                'username'  => $username,
            ));
        } catch (Exception $e) {
            print_r($e);
            exit;
        }
    }
}




/**
 *  Simple abstraction of Slack API
 *
 *  Uses curl, if not falls back to file_get_contents and HTTP stream.
 *  For all api methods, refer to https://api.slack.com/
 *
 *  @author https://github.com/10w042/slack-api
 */
class Slack
{

    private $api_token;
    private $api_endpoint = 'https://slack.com/api/<method>';

    /**
     * Create a new instance
     * @param string $api_token Your Slack api bearer token
     */
    public function __construct($api_token)
    {
        $this->api_token = $api_token;
    }

    /**
     * Calls an API method. You don't have to pass in the token, it will automatically be included.
     * @param  string  $method  The API method to call.
     * @param  array   $args    An associative array of arguments to pass to the API.
     * @param  integer $timeout Set maximum time the request is allowed to take, in seconds.
     * @return array           The response as an associative array, JSON-decoded.
     */
    public function call($method, $args = array(), $timeout = 10)
    {
        return $this->request($method, $args, $timeout);
    }

    /**
     * Performs the underlying HTTP request.
     * @param  string  $method  The API method to call.
     * @param  array   $args    An associative array of arguments to pass to the API.
     * @param  integer $timeout Set maximum time the request is allowed to take, in seconds.
     * @return array           The response as an associative array, JSON-decoded.
     */
    private function request($method, $args = array(), $timeout = 10)
    {
        $url = str_replace('<method>', $method, $this->api_endpoint);
        $args['token'] = $this->api_token;

        if (function_exists('curl_version')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            $post_data = http_build_query($args);
            $result    = file_get_contents($url, false, stream_context_create(array(
                'http' => array(
                    'protocol_version' => 1.1,
                    'method'           => 'POST',
                    'header'           => "Content-type: application/x-www-form-urlencoded\r\n" .
                                          "Content-length: " . strlen($post_data) . "\r\n" .
                                          "Connection: close\r\n",
                    'content'          => $post_data
                ),
            )));
        }

        return $result ? json_decode($result, true) : false;
    }
}
