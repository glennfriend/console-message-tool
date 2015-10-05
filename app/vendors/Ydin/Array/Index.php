<?php

// 未實作
exit;

/**
 *  Array index
 *
 *  @category    Ydin
 *  @package     Ydin\Array\Index
 *  @uses
 */
namespace Ydin\Array;

/*
    代入一個 已經處理好資訊的 二維陣列 index => key, values 
    來搜尋、比對裡面的內容

    example
        Array(
            [0] => Array(
                [name] => Chris
                [age] => 45
            [1] => Array(
                [name] => vivian
                [age] => 18
            [2] => Array(
                [name] => hello kitty
                [age] => 18
            [3] => Array(
                [name] => kevin
                [age]  => 15
        )

    $idx = new Ydin_Array_Index($arr);

    // 完全匹配
    $idx->has('name','kevin');          // true

    // 進階匹配
    $idx->has('name', 'evi', '%');      // true ( find "kevin" ) <-- 糢糊匹配
    $idx->has('age', 30, '>=');
    $idx->has('age', 10, '<');
    $idx->has('name', 'kevin', '===');
    $idx->has('name', 'kevin', 'i');    // 不論大小寫的匹配

    // 取得 完全匹配多筆
    $idx->find('age',18);               // 取得 多個資料陣列????? or 多個索引陣列?????

    // 取得 糢糊匹配多筆
    $idx->find('name','k','%');

    // 取得資料 by index
    $idx->get(3)

        Array(
            [name] => kevin
            [age]  => 15
        );

    // php 5.4 可使用
    $idx->get(3)['age']                 // 15

*/
class Index
{
    /**
     *
     */
    public function __construct( Array $arr )
    {
        $this->data = $arr;
    }

}



/*


    以下為舊式寫法



    代入一個 index => key, values 的二維陣列
    來搜尋、比對裡面的內容

    example
        Array(
            [0] => Array(
                [name] => kevin
                [age]  => 15
            [1] => Array(
                [name] => vivian
                [age] => 18
            [2] => Array(
                [name] => old man
                [age] => 85
            [3] => Array(
                [name] => Chris
                [age] => 45
        )

    $index = new Ydin_Array_Index($arr);

    // 取得第一個匹配的 index 值
    $index->get('name','kevin');            // 0
    $index->findIndex('name','kevin');      // [0]

    // 取得 index=3 的 'name' 欄位值
    $index->getValue(3, 'name');            // Chris
    $index->findValue(3,'name');            // ['Chris']

*/