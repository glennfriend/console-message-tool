<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $channel    = InputBrg::get('channel');
        $page       = (int) InputBrg::get('page');
        $myMessages = [];
        $rowCount   = 0;
        $messages   = new Messages();

        if ($channel) {
            $options = array(
                'channel'   => $channel,
                '_page'     => $page
            );
            $myMessages = $messages->findMessages($options);
            $rowCount   = $messages->numFindMessages($options);
        }

        $pageLimit = new PageLimit();
        $pageLimit->setBaseUrl('');
        $pageLimit->setRowCount($rowCount);
        $pageLimit->setPage($page);
        $pageLimit->setParams(array(
            'channel' => $channel,
        ));

        $this->view->setVars(array(
            'pageLimit' => $pageLimit,
            'messages' => $myMessages,
            'allChannel' => $messages->getAllChannel(),
        ));
    }
}
