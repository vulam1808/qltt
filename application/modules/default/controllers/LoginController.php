<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include APPLICATION_PATH . "/models/Sys_User.php";
include APPLICATION_PATH."/models/Sys_User_Group.php";
//include APPLICATION_PATH."/models/Agent.php";

class LoginController extends Zend_Controller_Action {

    public function init() {
        $this->modelMapper = new Model_Sys_UserMapper();
        $this->model = new Model_Sys_User();
         $this->modelUserGroupMapper= new Model_Sys_User_GroupMapper();
          $this->modelUserGroup = new Model_Sys_User_Group();
 
        
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $user = GlobalLib::getUserLogin();
        $this->userid = $user['id'];
//        $this->Agentmodel= new Model_Agent();
//        $this->AgentmodelMapper= new Model_AgentMapper();
    }

    public function loginAction() {
        $this->_helper->layout()->disableLayout();
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
            $rs = $this->modelMapper->authen($username,$password,$remenber);
            if($rs)
            {
                $mode = 0;
                   $auth = Zend_Auth::getInstance();
                   if($auth->hasIdentity())
                    {
                       $userInfo = $auth->getIdentity();
                       $groupCode = $userInfo->group_code;
                        if($groupCode == 'admin')
                        {
                              $mode = 2;
                        }
                        else if($groupCode == 'default')
                        {
                            $mode = 1;
                        }
                         else if($groupCode == 'leader')
                        {
                                $mode = 3;
                        }
                        else if($groupCode == 'master')
                        {
                                $mode = 4;
                        }
                    }
                //$redirectUrl = $this->aConfig["site"]["url"] . "default/login/login";
                if(empty($mode)){
                    $errorCode = 4;
                } else {
                    
                    //$this->modelMapper->authenUser($this->model,$remenber);
                    if ($mode==1) {
                        $redirectUrl = $this->aConfig["site"]["url"]."default/index/index";
                        $url = $this->aConfig["site"]["url"];
                        echo '[{"code":"1","url":"' . $url . 'default/index/index"}]';
                        exit;
                    } else if($mode==2){
                        $redirectUrl = $this->aConfig["site"]["url"]. "admin/index/index";
                        $url = $this->aConfig["site"]["url"];
                        echo '[{"code":"1","url":"' . $url . 'admin/index/index"}]';
                        exit;
                    } else if($mode==3){
                          $redirectUrl = $this->aConfig["site"]["url"]. "leader/index/index";
                          $url = $this->aConfig["site"]["url"];
                        echo '[{"code":"1","url":"' . $url . 'leader/index/index"}]';
                        exit;
                    }
                     else if($mode==4){
                          $redirectUrl = $this->aConfig["site"]["url"]. "master/index/index";
                          $url = $this->aConfig["site"]["url"];
                        echo '[{"code":"1","url":"' . $url . 'master/index/index"}]';
                        exit;
                    }
                }
            }
            else
            {
                 $errorCode = 4;
            }
            if (!empty($errorCode)) {
                echo '[{"code":"' . $errorCode . '"}]';
                exit;
            }          
        //$this->_redirect($redirectUrl);
           
        }
    }
    
    public function logoutAction() {
//        $redirectUrl = $this->aConfig["site"]["url"] . "default/login/login";
//        GlobalLib::userLogout();
//        $this->_redirect($redirectUrl);
        $redirectUrl = $this->aConfig["site"]["url"] . "default/login/login";
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect($redirectUrl);
    }

    //ADMIN_DOIMATKHAU
    public function editAction() {
        $id = $this->_getParam("id", "");
        $redirectUrl = $this->aConfig["site"]["url"] . "default/index/index";
        if (empty($id)) {
            $this->_redirect($redirectUrl);
        }
        if ($this->userid != $id) {
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id, $this->model);
        $getId = $this->model->getId();
        $this->AgentmodelMapper->findbyid($getId,$this->Agentmodel);  
        $agentid=$this->Agentmodel->getId();
        if(empty($getId)) {
            $this->_redirect($redirectUrl);
        }
        if ($this->getRequest()->isPost()) {
            if (isset($_POST["id"])) {
                $this->model->setId($_POST["id"]);
            }
            if (strlen($_POST["username"]) > 0) {
                $this->model->setUsername($_POST["username"]);
            }
            
            if (strlen($_POST["first_name"]) > 0) {
                $this->model->setFirst_Name($_POST["first_name"]);
            }
            if (strlen($_POST["last_name"]) > 0) {
                $this->model->setLast_Name($_POST["last_name"]);
            }
            if (isset($_POST["birthday"])) {
                $this->model->setBirthday(GlobalLib::toMysqlDateString($_POST["birthday"]));
            }
            if (isset($_POST["order"])) {
                $this->model->setOrder($_POST["order"]);
            }
            $this->model->setCreated(date("Y/m/d H:i:s"));
            $this->model->setModified(date("Y/m/d H:i:s"));
            $this->modelMapper->save($this->model);
            if($agentid !=NULL){
                $this->Agentmodel->setId($agentid);
                if($_POST["agent_name"]){
                    $this->Agentmodel->setName($_POST["agent_name"]);
                }
                if($_POST["agent_address"]){
                    $this->Agentmodel->setAddress($_POST["agent_address"]);
                }
                if($_POST["legal_capital"]){
                    $this->Agentmodel->setLegal_Capital($_POST["legal_capital"]);
                }
                if($_POST["experience"])
                {
                    $this->Agentmodel->setExperience($_POST["experience"]);
                }
                if($_POST["representavie"]){
                    $this->Agentmodel->setRepresentavie($_POST["representavie"]);
                }
                if($_POST["birthday"]){
                    $this->Agentmodel->setBirthday(GlobalLib::toMysqlDateString($_POST["birthday"]));
                } 
                if (strlen($_POST["phone"]) > 0) {
                    $this->Agentmodel->setPhone($_POST["phone"]);
                }
                if($_POST["ability_sell"]){
                    $this->Agentmodel->setAbility_Sell($_POST["ability_sell"]);
                }
                if($_POST["tax_code"]){
                    $this->Agentmodel->setTax_Code($_POST["tax_code"]);
                }
                if($_POST["person"]){
                    $this->Agentmodel->setPerson($_POST["person"]);
                }
                if($_POST["identity_card"]){
                    $this->Agentmodel->setIdentity_Card($_POST["identity_card"]);
                }
                if($_POST["ability_archive"]){
                    $this->Agentmodel->setAbility_Archive($_POST["ability_archive"]);
                }
                $this->AgentmodelMapper->save($this->Agentmodel);
            }
            $this->_redirect($redirectUrl);
        }
        $this->view->agentitem=$this->Agentmodel;
        $this->view->item = $this->model;
    }

    public function changepasswordAction() {
        $id = $this->_getParam("id", "");
        $oldpassword = $this->_getParam("oldpassword", "");
        $password = $this->_getParam("password", "");
        $this->modelMapper->find($id, $this->model);
        $redirectUrl = $this->aConfig["site"]["url"] . '/default/index/index';
        if ($this->getRequest()->isPost()) {
            if ($this->model->getPassword() == md5($oldpassword)) {
                $this->model->setPassword(md5($password));
                $this->modelMapper->save($this->model);
            }
            echo '[{"html":\'' . $redirectUrl . '\'}]';
            exit();
        }
    }

}
