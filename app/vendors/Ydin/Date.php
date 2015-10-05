<?php
/**
 * Date
 *
 * @version     1.0.0.0
 * @category    Ydin
 * @package     Ydin\Date
 * @uses
 */
namespace Ydin;

class Date
{

    /**
     * 輸入的日期, 跟現在伺服器的時間相比較, 是否在輸入的 天數 之內
     *
     * @param int $time
     * @param int $day
     * @return boolean
     */
    public static function inDay( $time, $day )
    {
        $diff = time() - ((int) $time);
        if ( $diff < 0 ) {
            // 表示未來的日期
            return true;
        }

        $second = ((int) $day) * 86400;
        if ( $second - $diff > 0 ) {
            return true;
        }
        return false;
    }

}
