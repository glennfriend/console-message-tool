<?php

/**
 *  設置規定:
 *
 *      所有路徑最後面都不能包含 "/" 符號
 *
 */

return [

    /**
     *  Environment
     *
     *      dev  - 開發者環境
     *      live - 正式環境
     */
    'env' => 'live',

    /**
     *  timezone
     *
     *      +0 => UTC
     *      -7 => America/Los_Angeles
     *      +8 => Asia/Taipei
     */
    'timezone' => 'Asia/Taipei',
    
    /**
     *  base path
     */
    'base' => [
        'path' => '/var/www/console-message-tool',
    ],

    /**
     *  home uri
     */
    'home' => [
        'base_url' => '/message',
    ],

    /**
     *  網站可變動式的加密值
     *  運用於生命週期短, 並且不會儲存起來的情況
     *  修改的時機通常為停機當下
     *
     *  example:
     *      web service encode
     *      cache key encode
     *
     */
    'private_dynamic_code' => 'please-modify-the-value',

    /**
     *  login lifetime
     *      phalcon - 是在 執行時期 運作, 所以重新設定之後, 立即生效
     *      Yii     - 是在 設定時期 運作, 所以重新設定之後, 要先清除所有的 cache 才會生效
     *
     *  2 * 60 * 60 = 2H =  7200
     *  3 * 60 * 60 = 3H = 10800
     *
     */
    'login_lifetime' => 10800,

    /**
     *  呼叫 PHP 的指令
     *  有時候你可能想要使用其它的版本
     *
     *      example
     *          /usr/bin/env php
     *          /root/.phpbrew/php/php-5.5.22/bin/php
     *
     */
    'php' => '/usr/bin/env php',

];
