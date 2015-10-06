<?php

/**
 *  請查閱 document
 *
 *      目前只有 parse to array
 *      其它什麼事都沒有做
 *
 */
class ParseMail
{

    /**
     *  建立 email 資料檔案
     *  另外呼叫其它程式去執行
     *  該發送方式 不需要 等待發送 的 時間
     */
    public function perform(array $params)
    {
        $message = isset($params['m']) ? $params['m'] : '';
        $info = $this->parseMailInfo($message);

        print_r($info); exit;
    }

    public function parseMailInfo($message)
    {
        $parser = new PhpMimeMailParser\Parser();
        $parser->setText($message);

        // print_r($parser->parts); exit;

        $tmp = [
            'body' => $parser->getMessageBody(),
        ];

        $info = [
            'headers'     => $parser->getHeaders(),
          //'attachments' => $parser->getAttachments(), // 附加檔案, 有時間請處理
            'body'        => '',
            'has_mail'    => null,
        ];
        $info['body']       = $this->filterBodyNoise($tmp['body']);
        $info['has_mail']   = $this->validateHasMail($tmp['body']);

        return $info;
    }

    /**
     *  filter body footer message like
     *
     *      Saved 1 message in /root/mbox
     *      Held 0 messages in /var/mail/root
     *
     */
    public function filterBodyNoise($body)
    {
        $lines = explode("\n", trim($body));

        $lastIndex = count($lines) - 1;
        if ($lastIndex <= 0) {
            return $body;
        }
        $content = $lines[$lastIndex];
        if (preg_match('/^Held [0-9]+ message[s]* in /', $content)) {
            unset($lines[$lastIndex]);
        }

        $lastIndex = count($lines) - 1;
        if ($lastIndex <= 0) {
            return $body;
        }
        $content = $lines[$lastIndex];
        if (preg_match('/^Saved [0-9]+ message[s]* in /', $content)) {
            unset($lines[$lastIndex]);
        }

        return trim(join("\n", $lines));
    }

    public function validateHasMail($body)
    {
        if ('No mail for root'==$body) {
            return false;
        }
        return true;
    }
}
