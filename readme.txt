document 使用手冊

    send message to "test" channel

        msg test m=test-message

    send to Hipchat

        c (channel) : go-hipchat
        m (message) :
        room        : hipchat room
        color       : red  or  %23FF0000
        bgcolor     : yellow, green, red, purple, gray, random

        msg go-hipchat room=test m=hi

    send to Email

        - 無等待時間: 發送內容先寫到 txt 檔案, 再利用 linux command  + & 方式發送
        - 所以無法第一時間確認是否成功寄出
        - 內容的時間是建立 message 的時間, 不是寄送時間 (如果是正常發送, 兩者可能無差別)

        msg go-email from=me to=me@gmail.com m=hi
        msg go-email from=me to=me@gmail.com m="$(tail -n 20 /var/log/apache2/access.log)"


    if system info have problem, send email to you

        - 如果訊息發生異常, 會發送電子郵件

        msg check-system-info m="$(php /var/www/console-message-tool/app/bin/get-system-info.php)"

