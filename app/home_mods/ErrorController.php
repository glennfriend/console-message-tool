<?php

class ErrorController extends ControllerBase
{

    public function indexAction()
    {
        // 找不到頁面就顯示 page not found
        // 不要再導回首頁 $this->redirectMainPage()

        // disabled layout, use action view
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_LAYOUT);
    }

    /*
        選擇要 render 那些 view
        LEVEL_NO_RENDER         Indicates to avoid generating any kind of presentation.
        LEVEL_ACTION_VIEW       Generates the presentation to the view associated to the action.
        LEVEL_BEFORE_TEMPLATE   Generates presentation templates prior to the controller layout.
        LEVEL_LAYOUT            Generates the presentation to the controller layout.
        LEVEL_AFTER_TEMPLATE    Generates the presentation to the templates after the controller layout.
        LEVEL_MAIN_LAYOUT       Generates the presentation to the main layout. File views/index.phtml
        {
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        }
    */

    /*
    if (!$this->request->isAjax()) 
    {
        // disable layout
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    */

}