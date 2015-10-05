<?php

class ControllerBase extends Phalcon\Mvc\Controller
{

    protected function initialize()
    {
        logBrg::frontend( $this->dispatcher->getControllerName(), $this->dispatcher->getActionName() );
    }

    // This is executed before every found action
    public function beforeExecuteRoute($dispatcher)
    {
        /*
        if ($dispatcher->getActionName() == 'index') {
            $this->flash->error("hello all index");
            exit;
            //return false; ?????????
        }
        */
    }

    // Executed after every found action
    public function afterExecuteRoute($dispatcher)
    {
        
    }

    /**
     *  forword
     *  不會改變網址
     */
    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0], 
                'action'     => $uriParts[1]
            )
        );
    }

    /**
     *  recirect to main page
     *  會改變網址
     */
    protected function redirectMainPage()
    {
        $this->redirect('');
    }

    /**
     *  recirect to main page
     *  會改變網址
     */
    protected function redirect( $route, $params=array() )
    {
        // 有參數的情況, route 要做一些調整
        // 由於 response 沒有吃參數, 所以要自己組好
        if ( $params ) {
            $baseUri = $this->url->getBaseUri();
            $this->url->setBaseUri('');
            $route = $this->url->get( $route, $params );
            $this->url->setBaseUri( $baseUri );
        }
    
        // 重定向不會禁用視圖組件。因此視圖將正常顯示。你可以使用 $this->view->disable() 禁用視圖輸出。
        $this->view->disable();
        $this->response->redirect( $route );
        return;
    }

}
