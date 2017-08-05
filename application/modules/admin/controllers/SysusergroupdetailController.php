<?php
include APPLICATION_PATH . "/models/Sys_User_Group_Detail.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_SysUserGroupDetailController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Sys_User_Group_DetailMapper();
        $this->model= new Model_Sys_User_Group_Detail(); 
    }
    public function indexAction(){       
    }
    public function addAction(){
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/sysusergroupdetail/list";
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(strlen($_POST["sys_user_group_id"])){
                $this->model->setSys_User_Group_Id($_POST["sys_user_group_id"]);
            }
            if(strlen($_POST["sys_privileges_id"])){
                $this->model->setSys_Privileges($_POST["sys_privileges_id"]);
            }            
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            if(strlen($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(strlen($_POST["status"])){
                $this->model->setStatus($_POST["status"]);
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
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysusergroupdetail/list";
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        if(empty($getId)){
            $this->_redirect($redirectUrl);
        }
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/sysusergroupdetail/list";
           if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(strlen($_POST["sys_user_group_id"])){
                $this->model->setSys_User_Group_Id($_POST["sys_user_group_id"]);
            }
            if(strlen($_POST["sys_privileges"])){
                $this->model->setSys_Privileges($_POST["sys_privileges"]);
            }            
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            if(strlen($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(strlen($_POST["status"])){
                $this->model->setStatus($_POST["status"]);
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
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapper->fetchAll() as $items ) {
            $menber[]=array(
                'Id'=>$items->getId(),
                'sys_user_group_id'=>GlobalLib::getName('sys_user_group',$items->getSys_User_Group_Id(),'group_name'),
                'sys_privileges'=>GlobalLib::getName('sys_privileges',$items->getSys_Privileges(),'name'),                
                'order'=>$items->getOrder(),
                'comment'=>$items->getComment(),               
                'status'=>$items->getStatus()
            );
        }
        echo json_encode($menber);
        exit();
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
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysusergroupdetail/list";               
        $this->modelMapper->deleteSys_User_Group_Detail($id);
        $this->_redirect($redirectUrl);
    }    
    
}
