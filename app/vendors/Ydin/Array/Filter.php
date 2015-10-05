<?php
/**
 *  Array filter
 *
 *  @category    Ydin
 *  @package     Ydin\Array\Filter
 *  @uses
 */
namespace Ydin\Array;

class Filter
{

    /**
     *  將 一維陣列 中的值都轉為 integer
     *  並且移除重覆的內容, 使得相同的內容只存在一組
     *  key 將轉為流水順序, 從 0 開始重新編整
     *
     *  @param  array $input
     *  @return array
     */
    static public function pureIntegerValue( $input )
    {
        $input = (array) $input;
        
        $array = array();
        foreach( $input as $key => $val ) {
            $array[] = (int) $val;
        }

        return array_values(array_unique($array));
    }

}

