<?php

/**
 *
 */
function pr( $data, $showName='' )
{
    echo '<pre style="background-color:#def;color:#000;text-align:left;font-size:10px;font-family:dina,GulimChe;">';
    if ( $showName ) {
        echo $showName . ' = ';
    }
    print_r( $data );
    echo "</pre>\n";
}

/**
 *  產生網址, 本是屬於 bridge 的部份
 *  因為使用率極高, 所以設定成 helper function
 */
function url( $route, $params=null )
{
    $url = RegisterManager::get('url');
    if ( is_array($params) ) {
        return $url->get( $route, $params );
    }
    return $url->get( $route );
}

/**
 *  escape 顯示資料, 本是屬於 ccHelper 的部份
 *  因為使用率極高, 所以設定成 helper function
 *
 *  escape output
 *
 *  @link http://www.smarty.net/manual/en/language.modifier.escape.php
 *        escape (Smarty online manual)
 *        by 2012-01-04
 *  @param string
 *  @param html|htmlall|url|quotes|hex|hexentity|javascript
 *  @return string
 *
 */
function escape( $string, $esc_type = "html", $char_set = 'UTF-8' )
{
    switch ($esc_type) {
        case 'html':
            return htmlspecialchars($string, ENT_QUOTES, $char_set);

        case 'htmlall':
            return htmlentities($string, ENT_QUOTES, $char_set);

        case 'url':
            return rawurlencode($string);

        case 'urlpathinfo':
            return str_replace('%2F','/',rawurlencode($string));

        case 'quotes':
            // escape unescaped single quotes
            return preg_replace("%(?<!\\\\)'%", "\\'", $string);

        case 'hex':
            // escape every character into hex
            $return = '';
            for ($x=0; $x < strlen($string); $x++) {
                $return .= '%' . bin2hex($string[$x]);
            }
            return $return;

        case 'hexentity':
            $return = '';
            for ($x=0; $x < strlen($string); $x++) {
                $return .= '&#x' . bin2hex($string[$x]) . ';';
            }
            return $return;

        case 'decentity':
            $return = '';
            for ($x=0; $x < strlen($string); $x++) {
                $return .= '&#' . ord($string[$x]) . ';';
            }
            return $return;

        case 'javascript':
            // escape quotes and backslashes, newlines, etc.
            return strtr($string, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));

        case 'mail':
            // safe way to display e-mail address on a web page
            return str_replace(array('@', '.'),array(' [AT] ', ' [DOT] '), $string);

        case 'nonstd':
           // escape non-standard chars, such as ms document quotes
           $_res = '';
           for($_i = 0, $_len = strlen($string); $_i < $_len; $_i++) {
               $_ord = ord(substr($string, $_i, 1));
               // non-standard char, escape it
               if($_ord >= 126){
                   $_res .= '&#' . $_ord . ';';
               }
               else {
                   $_res .= substr($string, $_i, 1);
               }
           }
           return $_res;

        default:
            return $string;
    }
}

/**
 *  cc ccHelper function call
 *
 *  example:
 *      cc('date',   time()       );
 *      cc('escape', $articleText );
 *
 *  @param helper function name
 *  @param param2
 *  @param param3
 *  @param param4
 *  @param param5
 *  @return maybe have maybe not have
 */
function cc()
{
    $numArgs = func_num_args();
    $args    = func_get_args();
    $func    = $args[0];

    include_once( Config::get('app.base.path') . '/app/components/ccHelper/'. $func .'.php');
    $functionName = 'ccHelper_'. $func;

    switch( $numArgs )
    {
        case 1: return $functionName();                                         exit;
        case 2: return $functionName( $args[1] );                               exit;
        case 3: return $functionName( $args[1], $args[2] );                     exit;
        case 4: return $functionName( $args[1], $args[2], $args[3]);            exit;
        case 5: return $functionName( $args[1], $args[2], $args[3], $args[4] ); exit;
        default:
            return '[cc error]';
    }
}

/**
 *  block
 *  class call
 *
 *  example:
 *      block('Date', time() );
 *      block('Date', time() )->toHtml();
 *
 *  @param helper function name
 *  @param param2
 *  @param param3
 *  @param param4
 *  @param param5
 *  @return maybe have maybe not have
 */
function block( $key )
{
    $numArgs = func_num_args();
    $args    = func_get_args();
    $func    = $args[0];

    if ( $numArgs < 1 ) {
        return '[block error]';
    }

    $className = 'Blocks\\' . trim($args[0]) . '\\Block';
    if ( !class_exists($className) ) {
        // log & message
        $backtrace = debug_backtrace();
        $msg = $backtrace[0]['file'] . ' line '. $backtrace[0]['line'];
        logBrg::error( trim($args[0]) . " block not found in " . $msg);
        return '[block error2]';
    }
    try {
        switch( $numArgs )
        {
            case 1: return new $className();                                         exit;
            case 2: return new $className( $args[1] );                               exit;
            case 3: return new $className( $args[1], $args[2] );                     exit;
            case 4: return new $className( $args[1], $args[2], $args[3] );           exit;
            case 5: return new $className( $args[1], $args[2], $args[3], $args[4] ); exit;
            default:
                return '[block error3]';
        }
    }
    catch( Exception $e ) {
        echo '[block error4]';
        exit;
    }
}


