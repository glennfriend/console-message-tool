<?php
/**
 *  該程式會 讀取 特定位置的檔案
 *  解析後, 如果是 email 相關資訊
 *  則發送該內容
 *  發送成功後, 會歸檔, 未真正刪除檔案
 */
define('APP_PORTAL','message');

try {
    require_once dirname(__DIR__).'/init.php';
    $app = $factoryApplication();
} catch( \Phalcon\Exception $e ) {
    echo "PhalconException: ", $e->getMessage();
    echo  $e->getTraceAsString();
    exit;
}

// --------------------------------------------------------------------------------
// process
// --------------------------------------------------------------------------------
toLog("start");
$txt  = getTxt($argv);
$file = getFile($txt);
$info = parseFile($file);
$result = sendEmail( $info->from, $info->to, $info->type, $info->message, $info->footer );
if ( $result ) {
    toLog(" rename");
    removeTxt($txt);
}
toLog(" done\n");
exit;

// --------------------------------------------------------------------------------
//
// --------------------------------------------------------------------------------
function toLog($message)
{
    if (is_object($message) || is_array($message)) {
        $message = print_r($message, true);
    }

    $logFile = Config::get('app.base.path') . '/var/log/go-email.log';
    file_put_contents( $logFile, $message, FILE_APPEND );
}

function getTxt($argv)
{
    if ( !isset($argv) || !isset($argv[1]) ) {
        // 不正確的參數值
        exit;
    }
    $txt = $argv[1];

    // security check
    if ( false !== strpos($txt, '..') ) {
        toLog(" validate fail - {$txt}\n");
        exit;
    }

    // security check
    if (!preg_match('/^[a-z0-9_@\-\.]+$/i', $txt)) {
        toLog(" validate fail - {$txt}\n");
        exit;
    }

    return $txt;
}

function getFile($txt)
{
    $basePath = Config::get('app.base.path');
    $file = "{$basePath}/var/go-email/{$txt}";
    if ( !file_exists($file) ) {
        toLog(" file not found - {$txt}\n");
        exit;
    }
    return $file;
}

function parseFile($file)
{
    $content = file_get_contents($file);
    $info = json_decode($content);
    if ( !$info || !is_object($info) ) {
        // 格式不正確
        toLog(" parse json file fail - {$file}\n");
        exit;
    }
    if (    !isset($info->from    )
         || !isset($info->to      )
         || !isset($info->message ) ) {
        // 格式不正確
        toLog(" lack of information in {$file}\n");
        toLog("content:");
        toLog($info);
        exit;
    }
    return $info;
}

function sendEmail($from, $to, $type, $message, $footer='')
{
    $mail = new PHPMailer;
    $mail->CharSet  = "utf-8";  
    $mail->From     = 'system';
    $mail->FromName = 'Console Message Tool';
    $mail->Subject  = "{$from} to you";
    $mail->Body     = $message . $footer;
    $mail->addAddress($to);
    $mail->isHTML(false);

    if ('html'==$type) {
        $mail->isHTML(true);
    }
    elseif ('pre'==$type) {
        $mail->Body = '<pre>'. $mail->Body . '<pre>';
        $mail->isHTML(true);
    }

    if(!$mail->send()) {
        return false;
    }
    return true;
}

function removeTxt($txt)
{
    $basePath = Config::get('app.base.path');
    $from = getFile($txt);
    $to   = "{$basePath}/var/go-email-done/{$txt}";
    rename($from, $to);
}
