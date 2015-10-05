<?php

/**
 *  對特定訊息做處理
 *  請查閱 document
 */
class CheckSystemInfo
{

    protected $_alerts = [];

    /**
     *  傳入 ini string
     *  依照一定的格式
     *  對資料處理並發送 email 通知
     */
    public function perform(array $params)
    {
        $message = isset($params['m']) ? $params['m'] : '';
        $items = parse_ini_string($message);
        // debug
        // print_r($items);

        $this->checkDisk($items['disk']);
        $this->checkPortListen($items['port_listen']);

        // safe
        $this->_alerts = array_values(array_filter($this->_alerts));
        if (!$this->_alerts) {
            return;
        }

        // no email to send
        $emails = Config::soft('notify.default', array() );
        if (count($emails)<=0) {
            return;
        }

        $content
            = join("\n", $this->_alerts)
            . "\n\n"
            . $message;

        $this->sendEmail($emails, $this->_alerts[0], $content);

    }

    /*
        Filesystem            1K-blocks      Used  Available Use% Mounted on
        /dev/mapper/training 1914412420 191780420 1625362448  11% /
        none                          4         0          4   0% /sys/fs/cgroup
        udev                    3970944         4    3970940   1% /dev
        tmpfs                    796200      3644     792556   1% /run
        none                       5120         0       5120   0% /run/lock
        none                    3980996         0    3980996   0% /run/shm
        none                     102400         0     102400   0% /run/user
        /dev/sda1                240972     64977     163554  29% /boot
    */
    private function checkDisk($txt)
    {
        $value = null;
        foreach ( $this->squareTextGenerator($txt) as $items ) {
            if (!isset($items[5])) {
                // 錯誤的格式, 略過
                return;
            }
            if ( '/' === trim($items[5]) ) {
                $value = $items[4];
                break;
            }
        }

        // '0%' ~ '100%'
        if ($value) {
            $value = (int) $value;
            if ($value >= 0) {
                $this->_alerts[] = "硬碟容量使用過高, 請注意!";
            }
        }
    }

    /*
        tcp        0      0 0.0.0.0:25              0.0.0.0:*               LISTEN      1205/master
        tcp        0      0 127.0.0.1:3306          0.0.0.0:*               LISTEN      1115/mysqld
        tcp        0      0 0.0.0.0:22              0.0.0.0:*               LISTEN      1013/sshd
        tcp6       0      0 :::25                   :::*                    LISTEN      1205/master
        tcp6       0      0 :::443                  :::*                    LISTEN      1538/apache2
        tcp6       0      0 :::80                   :::*                    LISTEN      1538/apache2
        tcp6       0      0 :::22                   :::*                    LISTEN      1013/sshd
    */
    private function checkPortListen($txt)
    {
        $ports = [];
        foreach ( $this->squareTextGenerator($txt) as $items ) {
            if (!isset($items[3])) {
                continue;
            }
            $items[3] = preg_replace("/[:]+/", ':', $items[3] );
            list($ip, $port) = explode(':', trim($items[3]));
            $ports[$port] = true;
        }

        $messages = [];
        if (!isset($ports[180])) {
            $this->_alerts[] = "apache 80 未開啟";
        }
        if (!isset($ports[13306])) {
            $this->_alerts[] = "mysql 3306 未開啟";
        }
    }

    /**
     *  parse linux 方塊格式文字串 to array
     *
     *      example:
     *          tcp        0      0 127.0.0.1:3306       0.0.0.0:*   LISTEN   1115/mysqld
     *          tcp        0      0 0.0.0.0:22           0.0.0.0:*   LISTEN   1013/sshd
     *          tcp6       0      0 :::443               :::*        LISTEN   1538/apache2
     *          tcp6       0      0 :::80                :::*        LISTEN   1538/apache2
     *          tcp6       0      0 :::22                :::*        LISTEN   1013/sshd
     *
     *      foreach first $data[3] is "127.0.0.1:3306"
     *
     */
    private function squareTextGenerator($text, $cutChar=" ", $newLine="\n")
    {
        $lines = explode($newLine, $text);
        foreach ($lines as $line) {
            if (!trim($line)) {
                continue;
            }
            $line = preg_replace("/[{$cutChar}]+/", $cutChar, $line );
            $items = explode($cutChar, $line);
            yield $items;
        }
    }

    /**
     *
     */
    function sendEmail($emails, $subject, $message)
    {
        $mail = new PHPMailer;
        $mail->CharSet  = "utf-8";
        $mail->From     = 'system';
        $mail->FromName = 'Console Message Tool';
        $mail->Subject  = $subject;
        $mail->Body     = '<pre>' . $message . $this->getFooter() . '<pre>';
        $mail->isHTML(true);
        foreach ($emails as $email) {
            $mail->AddBCC($email);
        }

        if(!$mail->send()) {
            return false;
        }
        return true;
    }

    /**
     *
     */
    private function getFooter()
    {
        return
            "\n--------------------\n"
            . $this->showTime('America/Los_Angeles') . "\n"
            . $this->showTime('UTC')                 . "\n"
            . $this->showTime('Asia/Taipei')         . "\n";
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

}

