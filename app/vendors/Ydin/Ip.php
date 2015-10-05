<?php
/**
 *  Ip
 *
 *  @category    Ydin
 *  @package     Ydin\Ip
 *  @uses
 */
namespace Ydin;

class Ip
{

    /**
     *  檢查輸入的 ip 是否為 內部 ip
     *
     *      127.0.0.1
     *      10.0.0.0    - 10.255.255.255  (10/8 prefix)
     *      172.16.0.0  - 172.31.255.255  (172.16/12 prefix)
     *      192.168.0.0 - 192.168.255.255 (192.168/16 prefix)
     *
     *      @see http://www.faqs.org/rfcs/rfc1918.html
     */
    public static function isPrivate( $ip )
    {
        $privateList = array(
            '/^0./',
            '/^127.0.0.1/',
            '/^192.168..*/',
            '/^172.((1[6-9])|(2[0-9])|(3[0-1]))..*/',
            '/^10..*/'
        );

        foreach ( $privateList as $private ) {
            if ( preg_match($private, $ip) ) {
                return true;
            }
        }
        return false;
    }


    /**
     *  IP string to integer
     *  not used ip2long
     *
     *  example:
     *      "192.168.0.1"
     *  
     *  @return float 
     */
    public function ipToLong( $ipString )
    {
        $ip = explode('.', $ipString );

        if( !$ip ||
            !isset($ip[0]) ||
            !isset($ip[1]) ||
            !isset($ip[2]) ||
            !isset($ip[3])
        ) {
            return 0;
        }
        return (($ip[0] * 256 + $ip[1]) * 256 + $ip[2]) * 256 + $ip[3];
    }

}
