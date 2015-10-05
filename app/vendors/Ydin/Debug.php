<?php
/**
 * Debug library
 *
 * @category    Ydin
 * @package     Ydin\Debug
 * @uses
 */
namespace Ydin;

class Debug
{

    /**
     * print pre
     *
     * @param any $content
     */
    public static function pre( $content )
    {
        echo '<pre style="background-color:#def;color:#000;text-align:left;font-size:10px;font-family:dina,GulimChe;">';
      //print_r( $content->debug() );
        print_r($content);
        echo "</pre>\n";
    }

    /**
     * print
     *
     * @param any $content
     */
    public static function preMethods( $content )
    {
        if ( !is_object($content) ) {
            echo "\$$content is not an object ~!<br/>\n";
        }

        $temp_class = get_class($content);
        if (!$temp_class) {
            echo "\$$content is not an class ~!<br/>\n";
        }

        $temp_methods = get_class_methods($temp_class);
        $details  = '';
        $details .= '['.$temp_class.'] totaly has '. count($temp_methods) .' Methods<br/>';
        $temp_vars = get_class_vars($temp_class);
        foreach ($temp_methods as $temp_method) {
            $details .= (' '.$temp_method."() ");
        }
        $details .= '<br/>';
        if (in_array('debug',$temp_methods)) {
            $details .= '<h2>debug() method returns</h2><br/>';
            $temp_data = $content->debug();
            foreach ($temp_data as $_var => $_value) {
                if (!is_array($_value)) $details .= ($_var.' === '.$_value."<br/>");
                else {
                    $details .= $_var ." === array (";
                    foreach ($_value as $t_var => $t_value)
                        $details .= (' ['.$t_var.' = '.$t_value.'] ');
                    $details .= ')';
                }
            }
        }
        if (in_array('getData',$temp_methods)) {
            $details .= '<h2>getData() method returns</h2><br/>';
            $temp_data = $content->getData();
            foreach ($temp_data as $_var => $_value) {
                $details .= ($_var.' === '.$_value."<br/>");
            }
        }
        print_r($details);
    }

    /**
     *  simply backtrace
     *  @return array
     */
    public function backtrace()
    {
        $traces = array();
        foreach( debug_backtrace(false) as $info ) {

            $item = array();
            $item['file'] = $info['file']  .':'. $info['line'];

            if( isset($info['class']) ) {
                $item['class'] = $info['class'] .'->'. $info['function'];
            }
            elseif( isset($info['function']) ) {
                $item['function'] = $info['function'];
            }

            if ( $info['args'] && count($info['args'])>0 ) {
                $item['args'] = array();
                foreach( $info['args'] as $data ) {
                    if ( is_object($data) ) {
                        $item['args'][] = 'class='. get_class($data);
                    }
                    else {
                        $item['args'][] = $data;
                    }
                }
            }
            $traces[] = $item;
        }
        return $traces;
    }



}
