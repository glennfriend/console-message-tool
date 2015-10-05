Message API
    - 沒有建立密碼機制, 只能 localhost only
    - use console
    - 有關於特定資料夾 now 的部份
        - 該程式在 now 的部份, 請自行處理資料, 不會存入資料庫
        - 該程式在其它的部份, 主要只收集資料, 資料運用請自行取用再加工

console 使用方式
    php /var/www/console-message-tool/message.php hello m=hi
    php /var/www/console-message-tool/message.php apache-log m="$(tail /var/log/apache2/access.log)"


※注意! 再次提醒, 本程式為 localhost only
程式主要結構

    message.php => 接收 message 指令

    home/
        單純顯示每一筆 message

    app/now/
        GoEmail.php
        => 有訊息立即被呼叫執行, 所以訊息 "不會" 被存入資料庫
        => 通常用來做資料接口並立即轉發資料
        => 可以用來 filter 特定資料, 縮小目標範圍, 只處理目標資料

    app/shell/
        hello.php
        analysis.php
        => 沒有針對這個目錄或裡面的檔案做任何處理
        => 在 now/ 之外的訊息會累積至資料庫
           通常可以 對一段時間內的資料 做 資料統計, 數量統計
           程式請由 cronjob 呼叫, 或自行執行 "php app/shell/hello.php"

