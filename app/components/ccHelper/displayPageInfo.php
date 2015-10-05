<?php

/**
 *  顯示 page info
 */
function ccHelper_displayPageInfo( $pageLimit )
{
    $show = '';
    if ( is_object($pageLimit) && $pageLimit->getRowCount() > 0 ) {
        $show .= ' Total  <span class="badge">'. $pageLimit->getRowCount() .'</span>';
        $show .= ' , Page <span class="badge">'. $pageLimit->getPage() .' / '. $pageLimit->getTotalPage() .'</span>';
    }
    return $show;

}

