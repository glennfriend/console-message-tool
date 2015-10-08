<?php

/**
 *  請查閱 document
 *
 *      該程式會取得 信件訊息
 *      並將信件設為 已讀
 *
 */
class AccessGmail
{

    /**
     *
     */
    public function perform(array $params)
    {
        $email = $this->getOldest();
        if (!$email) {
            echo "Error" . "\n";
            $this->close();
            exit;
        }

        print_r($email);
        $this->close();
    }

    /**
     *  取得最舊的一封 未讀信件
     *
     *      - 讀取信件後, imap_fetchbody() 會將信件狀態改為 已讀
     *
     *  @see http://tw2.php.net/manual/en/function.imap-search.php
     */
    private function getOldest()
    {
        $inbox = $this->getInbox();
        $emails = imap_search($inbox, 'UNSEEN');

        foreach ($emails as $id) {
            $headerInfo = imap_headerinfo($inbox, $id);
            $info = [
                'subject'    => $headerInfo->subject,
                'from'       => $headerInfo->from,
                'reply_to'   => $headerInfo->reply_to,
                'to'         => $headerInfo->to,
                'date'       => $headerInfo->MailDate,
              //'message_id' => $headerInfo->message_id,
                'service_id' => $id,
                'content'    => quoted_printable_decode(imap_fetchbody($inbox, $id, 1)),
            ];
            break;
        }

        return $info;
    }

    /**
     *  always get one
     */
    private function getInbox()
    {
        static $inbox;
        if ($inbox) {
            return $inbox;
        }

        if (!function_exists('imap_open')) {
            echo "imap_open library not found" . "\n";
            exit;
        }

        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = Config::get('gmail.email');
        $password = Config::get('gmail.password');

        // try to connect
        $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error() );
        return $inbox;
    }

    /**
     *
     */
    private function close()
    {
        $inbox = $this->getInbox();
        // imap_expunge($inbox);
        imap_close($inbox);
    }

}
