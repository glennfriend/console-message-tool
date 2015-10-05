<?php

/**
 *  分頁管理
 *
 *      output html
 *      custom uri format
 *      google SEO
 *
 */
class PageLimit
{
    protected $_params          = Array();  // array, 使用者可建立的參數
    protected $_page            = 1;        // 頁數
    protected $_pageShowCount;              // 每頁顯示數量
    protected $_rowCount;                   // 資料總筆數
    protected $_gap             = 5 ;       // 間距
    protected $_baseUrl         = '';       // string
    protected $_customUrl       = null;     // 自己訂義的 url

    /**
     *  init
     */
    public function __construct()
    {
        $this->_pageShowCount = Config::get('db.items_per_page');
    }

    /**
     *  設定每頁幾筆資料
     */
    public function setPageShowCount( $pageShowCount )
    {
        $this->_pageShowCount = (int) $pageShowCount;
    }
    public function getPageShowCount()
    {
        return $this->_pageShowCount;
    }

    /**
     *  設定資料總筆數
     */
    public function setRowCount( $rowCount )
    {
        $this->_rowCount = (int) $rowCount;
    }
    public function getRowCount()
    {
        return $this->_rowCount;
    }

    /**
     *  取得總頁數
     */
    public function getTotalPage()
    {
        if ( $this->_pageShowCount <=0 ) {
            return 1;
        }
        $totalPage = ceil( $this->_rowCount / $this->_pageShowCount );
        return ( $totalPage <= 0 ? 1 : $totalPage );
    }

    /**
     *  設定現在在第幾頁
     */
    public function setPage( $page )
    {
        if( $page<1 ) {
            $page = 1;
        }
        $this->_page = (int) $page;
    }
    public function getPage()
    {
        return $this->_page;
    }

    /**
     *  設定參數
     */
    public function setParams( $params )
    {
        $allowParams = Array();
        foreach( $params as $key => $value ) {
            if( $value ) {
                $allowParams[ $key ] = $value;
            }
        }
        $this->_params = $allowParams;
    }
    public function getParams()
    {
        return $this->_params;
    }
    public function getParam( $key )
    {
        if( isset($this->_params[$key]) ) {
            return $this->_params[$key];
        }
        return null;
    }

    // ====================================================================================================
    /**
     *  設定 自訂義 的 url format
     */
    public function setCustomUrlFormat( $url )
    {
        return $this->_customUrl = $url;
    }
    /**
     *  產生 自訂義 的 url format
     *
     *  sample:
     *
     *      /simple
     *      /simple/search/{search}/page/{page}
     *
     *  提示:
     *      參數為 {name} , 例如 {searchKey}
     *
     */
    public function generateCustomUrl( $params )
    {
        $customUrl = $this->_customUrl;
        foreach( $params as $key => $value ) {
            if( !$value ) {
                continue;
            }
            $fromString = '{'. $key .'}';
            $toString   = $value;
            $customUrl  = str_replace( $fromString, $toString, $customUrl );
        }

        // 對 page 參數做特殊處理
        $customUrl = str_replace('&page={page}', '', $customUrl );
        $customUrl = str_replace('page={page}',  '', $customUrl );
        $customUrl = str_replace('/{page}',      '', $customUrl );
        $customUrl = str_replace('{page}',       '', $customUrl );
        $customUrl = rtrim($customUrl, '&');
        $customUrl = rtrim($customUrl, '?');
        return $customUrl;
    }

    // ====================================================================================================
    /**
     *  需要 url manager 來產生網址
     */
    function setBaseUrl( $baseUrl )
    {
        $this->_baseUrl = $baseUrl;
    }

    // ====================================================================================================
    /**
     *  產生基本樣式
     */
    public function render()
    {

        $start = $this->_page - $this->_gap;
        $end   = $this->_page + $this->_gap;
        if( $start<1 ) {
            $start=1;
        }

        $maxPage = $this->getTotalPage();
        if( $end>$maxPage ) {
            $end=$maxPage;
        }

        if( $this->_rowCount <= $this->_pageShowCount ) {
            return '';
        }


        $html = '';
        if( 1 != $this->_page ) {
            $html .= '<li><a href="'. $this->generateUri($this->_page-1) .'">&laquo; Prev</a></li>';
        }
        else {
            $html .= '<li class="disabled"><a>&laquo; Prev</a></li>';
        }

        for( $i=$start; $i<=$end ; $i++ ) {
            if( $this->_page == $i ) {
                $html .= '<li class="active"><a href="'. $this->generateUri($i) .'">'. $i .'</a></li>';
            }
            else {
                $html .= '<li><a href="'. $this->generateUri($i) .'">'. $i .'</a></li>';
            }
        }

        if( $maxPage != $this->_page ) {
            $html .= '<li><a href="'. $this->generateUri($this->_page+1) .'">Next &raquo;</a></li>';
        }
        else {
            $html .= '<li class="disabled"><a>Next &raquo;</a></li>';
        }

        // data information
        /*
        if ( $this->getRowCount() > 0 ) {
            $html .= '<li ><a><b>Total  <span class="badge">'. $this->getRowCount() .'</span></b></a></li>';
            $html .= '<li ><a><b>Page <span class="badge">'. $this->getPage() .' / '. $this->getTotalPage() .'</span></b></a></li>';
        }
        */

        return $html;

    }

    /**
     *  拼出 uri
     */
    public function generateUri( $page )
    {
        if( $page>1 ) {
            $this->_params['page'] = $page;
        }
        else {
            unset( $this->_params['page'] );
        }

        if( !$this->_customUrl ) {
            return url( $this->_baseUrl, $this->_params );
        }
        else {
            return $this->generateCustomUrl( $this->_params );
        }
    }

    /**
     *  產生 google SEO
     *
     *  example:
     *      <link rel="canonical" href="/path/list.php" />
     *      <link rel="prev"      href="/path/list.php/5" />
     *      <link rel="next"      href="/path/list.php/7" />
     *
     */
    public function generateSeo()
    {
        die('d039248i502394d8i502394id85394058');
        Yii::app()->clientScript->registerLinkTag('canonical', null, $this->generateUri(1) );

        $page = $this->getPage();
        if ( $page > 1 ) {
            Yii::app()->clientScript->registerLinkTag('prev', null, $this->generateUri($page-1) );
        }
        if ( $page < $this->getTotalPage() ) {
            Yii::app()->clientScript->registerLinkTag('next', null, $this->generateUri($page+1) );
        }

    }

}
