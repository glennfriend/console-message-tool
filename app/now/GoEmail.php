<?php

/**
 *  請查閱 document
 */
class GoEmail
{

    /**
     *  建立 email 資料檔案
     *  另外呼叫其它程式去執行
     *  該發送方式 不需要 等待發送 的 時間
     */
    public function perform( array $params )
    {
        LogBrg::message("GoEmail perform");
        $type    = isset($params['type']) ? $params['type'] : 'txt';
        $from    = isset($params['from']) ? $params['from'] : 'system';
        $to      = isset($params['to'])   ? $params['to']   : '';
        $message = isset($params['m'])    ? $params['m']    : '';

        if (!in_array($type, ['txt', 'pre', 'html']) {
            $type = 'txt';
        }

        $from = preg_replace('/[^a-zA-Z0-9_\-\@\.]+/', '', $from );
        $to   = preg_replace('/[^a-zA-Z0-9_\-\@\.]+/', '', $to   );

        // 建立 email 資料檔案
        $txt = $this->createTxtPathFile($to);
        if (!$this->sendTxt($from, $to, $txt, $type, $message)) {
            LogBrg::message("Error: Create email content fail!");
            exit;
        }

        $php = Config::get('app.php');
        $executeFile = $this->getSendEmailExecuteFile();
        $param = basename($txt);
        $command = "{$php} {$executeFile} {$param} > /dev/null 2>&1 &";

        // execute & debug
        $output=[];
        exec($command,$output[0],$output[1]);
        LogBrg::message("command: ". print_r($command, true));
        LogBrg::message("output: {$output}");
    }

    /**
     *  依據 email 來產生 唯一的 檔案名稱
     */
    private function createTxtPathFile($email)
    {
        $prefix =  preg_replace('/[^a-zA-Z0-9_\@\-]+/', '', $email ) . '-';
        $id = uniqid($prefix) . '.txt';
        $pathFile = Config::get('app.base.path') . '/var/go-email/' . $id;
        return $pathFile;
    }

    /**
     *  發送 email 的執行檔案 位置
     */
    private function getSendEmailExecuteFile()
    {
        return Config::get('app.base.path') . '/app/bin/go-email-by-file.php';
    }

    /**
     *  建立 email 資料檔案
     */
    private function sendTxt($from, $to, $pathFile, $type, $message)
    {
        $mailContentFooter = "\n--------------------\n"
                           . $this->showTime('America/Los_Angeles') . "\n"
                           . $this->showTime('UTC')                 . "\n"
                           . $this->showTime('Asia/Taipei')         . "\n";

        $info = array(
            'type'      => $type,
            'from'      => $from,
            'to'        => $to,
            'message'   => $message,
            'footer'    => $mailContentFooter,
        );

        return file_put_contents( $pathFile, json_encode($info) );
    }

    /**
     *  顯示各時區的時間
     */
    private function showTime($to)
    {
        $timezone = date_default_timezone_get();
        $timeString = date("Y-m-d H:i:s");

        try {
            $convert = new DateTime($timeString, new DateTimeZone($timezone));
            $convert->setTimezone(new DateTimeZone($to));
            return $convert->format('Y-m-d H:i:s') . " ({$to})" ;
        }
        catch (Exception $e) {
            // error
        }
        return 'Error: TimeZone';
    }

    /**
     *  呼叫 curl 之後, 不等待回應
     */
    /*
    private function curl_post_not_wait( $url, Array $post=array() )
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

        curl_setopt($curl, CURLOPT_USERAGENT, 'api');
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

        if ( 'https' == substr($url,0,5) ) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        }

        curl_exec($curl);
        curl_close($curl);
    }
    */

}

