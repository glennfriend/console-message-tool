<?php

/**
 *  取得系統資訊
 *  INI format
 *
 *      php app/bin/get-system-info.php
 *
 */
function perform()
{
    $output  = ";; get-system-info INI format\n\n";
    $output .= "now = \"". getNow() . "\"\n";

    $information = getInformation();
    foreach ( $information as $key => $content ) {

        if (strlen($content) <= 80) {
            $output .= "{$key} = \"{$content}\"\n";
        }
        else {
            $output .= "\n";
            $output .= "{$key} = \"\n";
            $output .= $content;
            $output .= "\n\"\n";
        }

    }

    // debug: parse ini
    // print_r(parse_ini_string($output)); exit;

    echo $output;

}
perform();
exit;


/**
 *  取得所需要的資訊
 */
function getInformation()
{
    $info = [
        'boot_date'     => run('who -b')                        ,  // 這次開機時間
        'last_reboot'   => run('last -3 reboot')                ,  // 最後幾次的重新開機時間
        'w_and_uptime'  => run('w')                             ,  // uptime -> 從上次開機到現在已經運行了多久
        'disk'          => run('df')                            ,
        'port_listen'   => run('netstat -ntlp | grep LISTEN')   ,  // 看 server 開了那些 port
    ];
    // print_r($info); exit;
    return $info;
}

/**
 *  現在時間
 */
function getNow()
{
    $command = <<<EOD
date "+%Y-%m-%d %H:%M:%S"
EOD;
    return run($command);
}

/**
 *
 */
function run( $command )
{
    return trim(shell_exec($command));
}

/**
 *  取得輸出格式
 */
function getOutputType()
{
    global $argv;

    $type = 'txt';
    if ( isset($argv) && isset($argv[1]) ) {
        $type = strtolower(trim($argv[1]));
    }
    return $type;
}
