<?php
/**
 *  Client information
 *
 *  @category    Ydin
 *  @package     Ydin\Client
 *  @uses
 */
namespace Ydin;

class Client
{

    /**
     *  取得使用者 ip
     *  PS. 千萬不要嘗試從 X-Forwarded-For 取得
     */
    public static function getIp()
    {
        foreach (array(
                    'HTTP_CLIENT_IP',
                    'HTTP_X_FORWARDED_FOR',
                    'HTTP_X_FORWARDED',
                    'HTTP_X_CLUSTER_CLIENT_IP',
                    'HTTP_FORWARDED_FOR',
                    'HTTP_FORWARDED') as $key) {
            if (array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ((bool) filter_var($ip, FILTER_VALIDATE_IP,
                                    FILTER_FLAG_IPV4 |
                                    FILTER_FLAG_NO_PRIV_RANGE |
                                    FILTER_FLAG_NO_RES_RANGE)) {
                        return $ip;
                    }
                }
            }
        }
        return $_SERVER['REMOTE_ADDR'];
    }

}

