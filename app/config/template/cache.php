<?php

return [

    /**
     *  cache key
     */
    'key' => 'please-modify-the-value',
    
    /**
     *  cache lifetime
     *  Yii lifetime 是在設定時期運作, 所以重新設定之後, 要先清除所有的 cache 才會生效
     *
     *  16 * 60 * 60 = 16H = 57600
     *
     */
    'lifetime' => 57600,

];
