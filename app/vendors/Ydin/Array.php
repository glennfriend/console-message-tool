<?php

// 未測試, 未使用
exit;

/**
 *  Array library
 *
 *  @category    Ydin
 *  @package     Ydin\Array
 *  @uses
 */
namespace Ydin;

class array
{

    // 未測試, 未使用
    /**
     *  使用 . 符號的方式將陣列由字串的方式來 取得
     *
     *  example:
     *
     *      arrayGet($array, 'vivian')          -> array['vivian'], 若無值, 則傳回 null
     *      arrayGet($array, 'vivian', 'guest') -> array['vivian'], 若無值, 則傳回 'guest' string
     *      arrayGet($array, 'vivian.age')      -> array['vivian']['age']
     *      arrayGet($array, 'vivian.0')        -> array['vivian'][0]
     *
     *  @see    laravel array_get
     *  @param  array   $array
     *  @param  string  $key
     *  @param  any     $default
     *  @return any
     */
    static public function arrayGet( $array, $key, $default=null )
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if ( ! is_array($array) or ! array_key_exists($segment, $array)) {
                return value($default);
            }
            $array = $array[$segment];
        }

        return $array;
    }
    // static public function getLayer( $array, $key, $default=null )
    // {
    //     $key = trim( (string) $key );
    //     $items = explode( '.', $key );
    //     if( !is_array($items) ) {
    //         return $default;
    //     }
    // 
    //     $result = $array;
    //     foreach( $items as $index ) {
    //         if ( !preg_match('/^[a-z0-9\_]+$/i',$index) ) {
    //             return $default;
    //         }
    //         if ( !is_array($result) ) {
    //             return $default;
    //         }
    //         if ( !isset($result[$index]) ) {
    //             return $default;
    //         }
    //         $result = $result[$index];
    //     }
    //     return $result;
    // }


    // 未測試, 未使用
    /**
     *  使用 . 符號的方式將陣列由字串的方式來 設定
     *
     *  example:
     *
     *      arraySet($array, 'user', 'vivian' )
     *      getLayer($array, 'user.age', 12 )
     *
     *  @see    laravel array_set
     *  @param  array   $array
     *  @param  string  $key
     *  @param  any     $default
     *  @return any
     */
    static public function arraySet( &$array, $key, $value )
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);
        while (count($keys) > 1)
        {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if ( ! isset($array[$key]) or ! is_array($array[$key])) {
                $array[$key] = array();
            }
            $array =& $array[$key];
        }

        $array[array_shift($keys)] = $value;
        return $array;
    }

}
