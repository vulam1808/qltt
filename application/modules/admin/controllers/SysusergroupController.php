<?php
include APPLICATION_PATH . "/models/Sys_User_Group.php";
include APPLICATION_PATH . "/models/Sys_User.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_SysUserGroupController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Sys_User_GroupMapper();
        $this->model= new Model_Sys_User_Group(); 
        $this->modelUserMapper= new Model_Sys_UserMapper();
    }
    public function indexAction(){       
    }
    public function addAction(){
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/sysusergroup/list";
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(strlen($_POST["group_name"])){
                $this->model->setGroup_Name($_POST["group_name"]);
            }
            if(isset($_POST["order_user_group"])){
                $this->model->setOrder($_POST["order_user_group"]);
            }
            if(strlen($_POST["comment_user_group"])){
                $this->model->setComment($_POST["comment_user_group"]);
            }
            if(strlen($_POST["status_user_group"])){
                $this->model->setStatus($_POST["status_user_group"]);
            }
            $this->model->setCreated_Date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_Date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_Delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }
    public function editAction(){
        $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysusergroup/list";
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        if(empty($getId)){
            $this->_redirect($redirectUrl);
        }
        if($this->getRequest()->isPost()){
           if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(strlen($_POST["group_name"])){
                $this->model->setGroup_Name($_POST["group_name"]);
            }
            if(isset($_POST["order_user_group"])){
                $this->model->setOrder($_POST["order_user_group"]);
            }
            if(strlen($_POST["comment_user_group"])){
                $this->model->setComment($_POST["comment_user_group"]);
            }
            if(strlen($_POST["status_user_group"])){
                $this->model->setStatus($_POST["status_user_group"]);
            }
            $this->model->setCreated_Date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_Date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_Delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }   
    public function listAction(){       
    }    
     
     public  function confirmdeleteAction()
    {
        $id = $this->_getParam("id","0");
        $count = 0;
        echo $count;
        exit();
    }
    public function deleteAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysusergroup/list";               
        $this->modelMapper->deleteSys_User_Group($id);
        $this->_redirect($redirectUrl);
    } 
}
