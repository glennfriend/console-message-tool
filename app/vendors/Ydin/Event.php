<?php
/**
 *  Event
 *  為了讓系統架構更容易 插入 非主要功能的程式碼
 *  使用該方式來於處理副程式
 *
 *  注意: 不適當的使用, 會使系統變慢
 *
 *  is static class
 *
 *  @version    1.0.0.1
 *  @category   Ydin
 *  @package    Ydin\Event
 *  @uses
 *
 *  @history    1.0.0.0
 *  @history    1.0.0.1 - fix notify(), from include() to include_once()
 *
 */
namespace Ydin;

class Event
{

    /**
     *  event path
     */
    protected static $_path = null;

    /**
     *  event list, class names
     */
    protected static $_event = array();

    /**
     *  init
     *  取得路徑, 登記裡面的 class, 等待其它程式的呼叫
     *
     *  @param $path
     */
    public static function init( $path )
    {
        self::$_path = $path;
    
        // parser event path
        foreach (glob($path."/*.php") as $filename ) {
            $fileInfo = pathinfo($filename);
            self::$_event[] = $fileInfo['filename'];
        }
    }

    /**
     *  呼叫已訂閱的 event 程式
     *
     *  @param string  $method - program name
     *  @param array   $params - program params
     */
    public static function notify( $method, $params )
    {
        $method = trim($method);

        foreach ( self::$_event as $className ) {
            $handler = array( $className, $method );
            include_once( self::$_path .'/'. $className . '.php' );
            if ( !is_callable($handler) ) {
                continue;
            }
            // forward_static_call_array( $handler , $params );

            $class = new $className();
            $class->$method( $params );
        }
    }

}
