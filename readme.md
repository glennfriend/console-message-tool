#document 使用手冊

## send message to "test" channel

```sh
msg test m=test-message
```

## send to Hipchat

```sh
    m (message) :
    room        : hipchat room
    color       : red  or  %23FF0000
    bgcolor     : yellow, green, red, purple, gray, random

msg go-hipchat room=test m=hi
```

## send to Slack

```sh
    m (message) :
    room        : room name
    username    : username

msg go-slack room=#test m="hello world"
```

## send to Email

    - 無等待時間: 發送內容先寫到 txt 檔案, 再利用 linux command  + & 方式發送
    - 所以無法第一時間確認是否成功寄出
    - 內容的時間是建立 message 的時間, 不是寄送時間 (如果是正常發送, 兩者可能無差別)

```sh
    m (message) :
    from        : 寄件者
    to          : 收件者
                  多收件者請用 "," 分隔 -> user1@mail.com,user2@mail.com
    type        : txt, pre, html

msg go-email from=system to=me@gmail.com m=hi
msg go-email from=system to=me@gmail.com m="$(tail -n 20 /var/log/apache2/access.log)" type=pre
```

## read root-mail

    - 將 mail 的內容發送到程式中, 做即時的處理

```sh
    1/* * * * *
        echo '1' | mail -Ni > /tmp/root-mail-first.txt
        msg parse-mail m="$(cat /tmp/root-mail-first.txt)"
```

## send Email to admin - if system info have problem

    - 如果系統訊息發生異常, 會發送電子郵件

```sh
msg check-system-info m="$(/usr/bin/env php /var/www/console-message-tool/app/bin/get-system-info.php)"
```
