<?php

/**
 *  example:
 *  
 *      cc('dbobjectToArray', $user, array('id','name','nickname','email','createTime') );
 *  
 */
function ccHelper_dbobjectToArray( $dbobject, $allowField=array() )
{
    mb_internal_encoding("UTF-8");
    $data = array();

    $items = (array) $dbobject;
    foreach( $items as $key => $value ) {

        if( 
              0 == ord(mb_substr($key,0,1)) && 
             42 == ord(mb_substr($key,1,1)) && 
              0 == ord(mb_substr($key,2,1)) && 
             95 == ord(mb_substr($key,3,1)) 
        ) 
        {
            $key = mb_substr($key,4);
        }
        else {
            continue;
        }

        if( !in_array( $key , $allowField ) ) {
            continue;
        }
        $data[ $key ] = $value;
    }

    return $data;
}
