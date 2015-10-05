<?php

/**
 *  顯示 page limit and page info
 */
function ccHelper_displayPageLimit( $pageLimit, $showPageInfo=false )
{
    if ( is_object($pageLimit) ) {

        $paginationInfo = '';
        if( $pageLimit->getTotalPage() > 1 ) {
            $paginationInfo = '<ul class="pagination">'. $pageLimit->render() . '</ul>';
        }

        $pageInfo = '';
        if ( $showPageInfo ) {
            $pageInfo = cc('displayPageInfo', $pageLimit );
        }
    
        return <<<EOD
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    {$paginationInfo}
                </div>
                <div class="pull-right">
                    {$pageInfo}
                </div>
            </div>
        </div>
EOD;
    }
    return '';

}

