<?php

/**
 *  取得該欄位在 object 中有多少選項
 *
 *      example:
 *          cc('attribList', $user, 'status' );
 *          cc('attribList', $user, 'is_used' );
 *
 *  @param object , dbobject
 *  @param string , field name (依照該 dbobject 準標格式的規則命名)
 *  @return array
 */
function ccHelper_attribList( $dbobject, $field )
{
    $prefix = strtoupper($field) . '_';
    $reflection = new ReflectionObject($dbobject);
    $list = array();

    foreach( $reflection->getConstants() as $constant => $value ) {
        if( $prefix.'ALL'===$constant ) {
            continue;
        }
        if( substr($constant,0,strlen($prefix))===$prefix ) {
            $list[ $constant ] = $value;
        }
    }

    return $list;
}
