<?php

/**
 *  Message
 *
 */
class Message extends BaseObject
{

    /**
     *  請依照 table 正確填寫該 field 內容
     *  @return array()
     */
    public static function getTableDefinition()
    {
        return array(
            'id' => array(
                'type'    => 'integer',
                'filters' => array('intval'),
                'storage' => 'getId',
                'field'   => 'id',
            ),
            'channel' => array(
                'type'    => 'string',
                'filters' => array('strip_tags','trim'),
                'storage' => 'getChannel',
                'field'   => 'channel',
            ),
            'message' => array(
                'type'    => 'string',
                'filters' => array('strip_tags','trim'),
                'storage' => 'getMessage',
                'field'   => 'message',
            ),
            'properties' => array(
                'type'    => 'string',
                'filters' => array('arrayval'),
                'storage' => 'getProperties',
                'field'   => 'properties',
            ),
            'createTime' => array(
                'type'    => 'timestamp',
                'filters' => array('dateval'),
                'storage' => 'getCreateTime',
                'field'   => 'create_time',
                'value'   => time(),
            ),
        );
    }

    /* ------------------------------------------------------------------------------------------------------------------------
        basic method rewrite or extends
    ------------------------------------------------------------------------------------------------------------------------ */

    /**
     *  Disabled methods
     *  @return array()
     */
    public static function getDisabledMethods()
    {
        return array();
    }

    /* ------------------------------------------------------------------------------------------------------------------------
        extends
    ------------------------------------------------------------------------------------------------------------------------ */



    /* ------------------------------------------------------------------------------------------------------------------------
        lazy loading methods
    ------------------------------------------------------------------------------------------------------------------------ */


}
