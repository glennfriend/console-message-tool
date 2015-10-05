<?php

/**
 *  管理 form 的訊息串
 *  除了管理 form field messages 之外
 *  也包含 存儲/清除 儲存訊息的一組 session 值
 *
 *  Example:
 *
 *      $messages = array();
 *      $messages['name']  = 'name 不正確';
 *      $messages['topic'] = '該欄位必填';
 *      FormMessageManager::setFieldMessages( $messages );
 *
 *      $message = array('password' => 'password 不正確');
 *      FormMessageManager::addFieldMessage( $message );
 *
 *      if ( FormMessageManager::hasError() ) {
 *          FormMessageManager::addErrorResultMessage('Error');
 *      }
 *      else {
 *          FormMessageManager::addSuccessResultMessage('Success');
 *      }
 *
 *
 */
class FormMessageManager
{

    /**
     *  儲存所有的訊息
     */
    protected static $_messages = array();

    /**
     *  設定 多組訊息
     *  @param array
     */
    public static function setFieldMessages( $fieldMessages )
    {
        self::$_messages = $fieldMessages;
    }

    /**
     *  新增 一組訊息
     *  @param array
     */
    public static function addFieldMessage( $fieldMessage )
    {
        if( !is_array($fieldMessage) ) {
            return;
        }
        foreach( $fieldMessage as $field => $value ){}
        self::$_messages[ $field ] = $value;
    }

    /**
     *  取得欄位訊息
     *  @return string or null
     */
    public static function getFieldMessage( $field )
    {
        if( isset(self::$_messages) &&
            isset(self::$_messages[$field])
        ) {
            return self::$_messages[$field];
        }
        return null;
    }

    /**
     *  取得該欄狀態 '' or 'error'
     *
     *  由於 twitter bootstrap 會需要吃 'error' 的文字訊息
     *  所以這是特意提供出來給它用的 文字訊息
     *
     *  @param string - field key
     *  @return string
     */
    public static function getFieldStatus( $field )
    {
        if( isset(self::$_messages) &&
            isset(self::$_messages[$field])
        ) {
            return 'has-error';
        }
        return '';
    }

    /**
     *  該 form 是否有錯誤訊息
     *  只要有一個欄位有錯誤訊息, 就會傳回 true
     *  @return boolean
     */
    public static function hasError()
    {
        if( !is_array(self::$_messages) ) {
            return true;
        }
        if( 0 !== count(self::$_messages) ) {
            return true;
        }
        return false;
    }




    /* ================================================================================
        將臨時訊息儲存於 session 之中, 顯示完之後需要刪除該訊息, 以避免重覆顯示
    ================================================================================ */

    /**
     *  取得 form 操作之後的臨時訊息
     *  該訊息儲存於 session 之中
     *  @return array
     */
    public static function getResultMessages()
    {
        $value = SessionBrg::get('resultMessage');
        if( !$value ) {
            return array();
        }
        return $value;
    }

    /**
     *  append success message
     *  @param string message
     */
    public static function addSuccessResultMessage( $string='' )
    {
        self::_addResultMessage($string, 'success');
    }

    /**
     *  append error message
     *  @param string message
     */
    public static function addErrorResultMessage( $string='' )
    {
        self::_addResultMessage($string, 'error');
    }

    /**
     *  清除臨時訊息, 通常顯示完之後就會馬上清除
     *  該訊息儲存於 session 之中
     */
    public static function clearResultMessages()
    {
        SessionBrg::remove('resultMessage');
    }

    /**
     *  append form 操作之後的臨時訊息
     */
    protected static function _addResultMessage( $string, $type )
    {
        $type = strtolower($type);

        $values = SessionBrg::get('resultMessage');
        if( !$values ) {
            $values = array();
            $values[] = array('message'=>$string,'type'=>$type);
        }
        else {
            $values[] = array('message'=>$string,'type'=>$type);
        }

        SessionBrg::set('resultMessage', $values );
    }


}