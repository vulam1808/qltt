<?php
include APPLICATION_PATH . "/models/Master_Items_Limit.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_MasterItemsLimitController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Master_Items_LimitMapper();
        $this->model= new Model_Master_Items_Limit(); 
    }
    public function indexAction(){      
    }
    public function addAction(){
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/masteritemslimit/list";
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(isset($_POST["code"])){
                $this->model->setCode($_POST["code"]);
            }
            if(isset($_POST["name"])){
                $this->model->setName($_POST["name"]);
            }
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            if(isset($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(isset($_POST["status"])){
                $status=1;
            } else {
                $status=0;
            }
            $this->model->setStatus($status); 
            $this->model->setIs_Delete(0);
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }
    public function editAction(){
        $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/masteritemslimit/list";
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
            if(isset($_POST["code"])){
                $this->model->setCode($_POST["code"]);
            }
            if(isset($_POST["name"])){
                $this->model->setName($_POST["name"]);
            }
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
             if(isset($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(isset($_POST["status"])){
                $status=1;
            } else {
                $status=0;
            }
            $this->model->setStatus($status);
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }   
    public function listAction(){
        $this->view->controller = $this;
        $this->view->item=$this->modelMapper->fetchAll();
    }
    
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapper->fetchAll() as $items ) {
            $menber[]=array(
                'Id'=>$items->getId(),
                'code'=>$items->getCode(),
                'name'=>$items->getName(),                
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
        $redirectUrl=$this->aConfig["site"]["url"]."admin/masteritemslimit/list";               
        $this->modelMapper->deleteMaster_Items_Limit($id);
        $this->_redirect($redirectUrl);
    }    
    public function checkcodeAction(){
          $this->_helper->layout()->disableLayout();
         if($this->_request->isPost()){
             $code= $this->_getParam("code","");
             $id= $this->modelMapper->findidbyname('code',$code);
             if($id !=0){
                 $menber[]=array(
                     'code'=>1,
                     'message'=>'Mã code này đã tồn tại. Vui lòng kiểm tra và nhập lại'
                         );  
             } else {
                  $menber[]=array(
                     'code'=>0,
                     'message'=>''
                         );  
             }
             echo json_encode($menber);
             exit();
         }  
    }
   
}
