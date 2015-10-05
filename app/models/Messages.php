<?php

/**
 *
 */
class Messages extends ZendModel
{
    const CACHE_MESSAGE = 'cache_message';

    /**
     *  table name
     */
    protected $tableName = 'messages';

    /**
     *  get method
     */
    protected $getMethod = 'getMessage';

    /**
     *  get db object by record
     *  @param  row
     *  @return TahScan object
     */
    public function mapRow( $row )
    {
        $object = new Message();
        $object->setId         ( $row['id']                      );
        $object->setChannel    ( $row['channel']                 );
        $object->setMessage    ( $row['message']                 );
        $object->setProperties ( unserialize($row['properties']) );
        $object->setCreateTime ( strtotime($row['create_time'])  );
        return $object;
    }

    /* ================================================================================
        write database
    ================================================================================ */

    /**
     *  add Message
     *  @param Message object
     *  @return insert id or false
     */
    public function addMessage( $object )
    {
        $insertId = $this->addObject( $object, true );
        if ( !$insertId ) {
            return false;
        }

        $object = $this->getMessage( $insertId );
        if ( !$object ) {
            return false;
        }

        $this->preChangeHook( $object );
        return $insertId;
    }

    /**
     *  update Message
     *  @param Message object
     *  @return int
     */
    public function updateMessage( $object )
    {
        $result = $this->updateObject( $object );
        if ( !$result ) {
            return false;
        }

        $this->preChangeHook( $object );
        return $result;
    }

    /**
     *  delete Message
     *  @param int id
     *  @return boolean
     */
    public function deleteMessage( $id )
    {
        $object = $this->getMessage($id);
        if ( !$object || !$this->deleteObject($id) ) {
            return false;
        }

        $this->preChangeHook( $object );
        return true;
    }

    /**
     *  pre change hook, first remove cache, second do something more
     *  about add, update, delete
     *  @param object
     */
    public function preChangeHook( $object )
    {
        // first, remove cache
        $this->removeCache( $object );
    }

    /**
     *  remove cache
     *  @param object
     */
    protected function removeCache( $object )
    {
        if ( $object->getId() <= 0 ) {
            return;
        }

        $cacheKey = $this->getFullCacheKey( $object->getId(), Messages::CACHE_MESSAGE );
        CacheBrg::remove( $cacheKey );
    }


    /* ================================================================================
        read access database
    ================================================================================ */

    /**
     *  get Message by id
     *  @param  int id
     *  @return object or false
     */
    public function getMessage( $id )
    {
        $object = $this->getObject( 'id', $id, Messages::CACHE_MESSAGE );
        if ( !$object ) {
            return false;
        }
        return $object;
    }

    /* ================================================================================
        find Messages and get count
        多欄、針對性的搜尋, 主要在後台方便使用, 使用 and 搜尋方式
    ================================================================================ */

    /**
     *  find many Message
     *  @param  option array
     *  @return objects or empty array
     */
    public function findMessages( $opt=array() )
    {
        $opt += array(
            '_order'        => 'id DESC',
            '_page'         => 1,
            '_itemsPerPage' => Config::get('db.items_per_page')
        );
        return $this->findMessagesReal( $opt );
    }

    /**
     *  get count by "findMessages" method
     *  @return int
     */
    public function numFindMessages( $opt=array() )
    {
        return $this->findMessagesReal( $opt, true );
    }

    /**
     *  findMessages option
     *  @return objects or record total
     */
    protected function findMessagesReal( $opt=array(), $isGetCount=false )
    {
        // validate 欄位 白名單
        $list = array(
            'channel', 'message', 'createTime', 
            '_order','_page','_itemsPerPage'
        );
        ZendModelHelper::fieldsTriggerError($opt, $list);
        $opt = ZendModelHelper::fieldValueNullToEmpty($opt);
        $select = $this->getDbSelect();

        if ( isset($opt['channel']) ) {
            $select->where->and->equalTo( 'channel', $opt['channel'] );
        }
        if ( isset($opt['message']) ) {
            $select->where->and->like('message', '%'.$opt['message'].'%' );
        }
        if ( isset($opt['createTime']) ) {
            $select->where->and->equalTo( 'create_time', $opt['createTime'] );
        }

        if ( !$isGetCount ) {
            return $this->findObjects( $select, $opt );
        }
        return $this->numFindObjects( $select );
    }

    /* ================================================================================
        extends
    ================================================================================ */

    /**
     *  取得現在有那些 channel
     */
    public function getAllChannel()
    {
        $key = 'channel';
        $select = $this
            ->getDbSelect()
            ->columns(array($key))
            ->group('channel');
        
        $result = $this->query($select);
        if ( !$result ) {
            return array();
        }

        $rows = [];
        $getMethod = $this->getMethod;
        while( $row = $result->next() ) {
            $rows[] = $row[$key];
        };
        return $rows;
    }

}
