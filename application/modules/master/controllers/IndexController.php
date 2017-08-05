<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Master_IndexController extends Zend_Controller_Action{
    public function init(){
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
       
    }
    public function indexAction(){
        
    }
    
    public function loginAction(){
        $this->_helper->layout->disableLayout();
        error_reporting(0);
        $this->view->errors = NULL;
        if ($this->_request->isPost()) {
            $username = $this->_getParam("username", "");
            $password = $this->_getParam("password", "");
            $remenber = $this->_getParam("remember", 0);
            $errorCode = '';
            if (empty($username)) {
                $errorCode = 2;
            }
            if (empty($password)) {
                $errorCode = 3;
            }
            if (!$this->modelMapper->authen($username, $password, $remenber)) {
                $errorCode = 4;
            }
            if (!empty($errorCode)) {
                echo '[{"code":"' . $errorCode . '"}]';
                exit;
            }
            $url = $this->aConfig["site"]["url"];
            echo '[{"code":"1","url":"' . $url . 'master/index/index"}]';
            exit;
        }
    }
    
    public function logoutAction(){
        $redirectUrl = $this->aConfig["site"]["url"] . "default/login/login";
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect($redirectUrl);
    }
}

