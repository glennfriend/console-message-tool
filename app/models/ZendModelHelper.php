<?php
/**
 *
 */
class ZendModelHelper
{
    /**
     *  如果代入的欄位不在白名單, 會 trigger error
     *
     *  @param array $options, 標準欄位格式
     *  @param array $allowFields, 予許的欄位白名單
     */
    public static function fieldsTriggerError( $options, $allowFields )
    {
        foreach ( $options as $field => $value) {
            if ( !in_array($field, $allowFields) ) {
                $field = preg_replace("/[^a-zA-Z0-9_]+/", '', $field );
                trigger_error("Custom Model Error: field not found '{$field}'", E_USER_ERROR);
            }
        }
    }

    /**
     *  將陣列資料的 null 轉換為 空字串
     *
     *  @param array $options, 標準欄位格式
     *  @return array
     */
    public static function fieldValueNullToEmpty( $options )
    {
        foreach ( $options as $field => $value) {
            if ( is_null($options[$field]) ) {
                $options[$field] = '';
            }
        }
        return $options;
    }

}
