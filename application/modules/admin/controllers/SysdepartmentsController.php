<?php
    include_once APPLICATION_PATH."/models/Sys_User.php";
    include_once  APPLICATION_PATH."/models/SysDepartments.php"; 
  // include_once  APPLICATION_PATH."/models/Type_Departments.php"; 
    class Admin_SysDepartmentsController extends Zend_Controller_Action{
    //put your code here
    public function init() {
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->model= new Model_SysDepartments();
        $this->modelMapper= new Model_SysDepartmentsMapper();  
        $this->modelAdmin = new Model_Sys_User();
        $this->modelMapperAdmin= new Model_Sys_UserMapper();
    }
    

    public function indexAction(){}
    public function listAction() {}    
    public function serviceAction(){
        $this->_helper->layout->disableLayout();        
        foreach ($this->modelMapper->fetchAll() as $items ) {
            $menber[]=array(                                
                'ID'=>$items->getId(),
                'Code'=>$items->getCode(),
                'Name'=>$items->getName(), 
                'Order'=>$items->getOrder(),
                'Leader'=>$items->getLeader(), 
                'Parent_id'=>$items->getParent_Id(),
              //  'leader_department'=> GlobalLib::getName('admin',$items->getLeader(), 'first_name').' '.GlobalLib::getName('admin', $items->getLeader(), 'last_name'),
              //  'type_department'=> GlobalLib::getName('type_departments',$items->getType_Department_Id(),'name')
            );
        }
        echo json_encode($menber);
        exit();
    }
    public function servicefromdocviolationshandlingAction(){
        $this->_helper->layout->disableLayout();        
        foreach ($this->modelMapper->fetchAllfromdocviolationshandling() as $items ) {
            $menber[]=array(                                
                'ID'=>$items->getId(),
                'Name'=>$items->getName(),             
            );
        }
        echo json_encode($menber);
        exit();
    }
    public function list1Action(){
        
    }
    public function addAction() {
        $this->view->itemAdmin=$this->modelAdmin;
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/sysdepartments/list";            
            if(isset($_POST["id"])){
                $this->model->setId("id");
            }
            if(strlen($_POST["code_department"])){
                $this->model->setCode($_POST["code_department"]);
            }
            if(strlen($_POST["name_department"])){
                $this->model->setName($_POST["name_department"]);
            } 
            if(strlen($_POST["parent_id"])){
                $this->model->setParent_Id($_POST["parent_id"]);
                $this->model->setIs_root(0);
            }   
            else $this->model->setIs_root(1);
            if(strlen($_POST["leader_department"])){
                $this->model->setLeader($_POST["leader_department"]);
            } 
            if(isset($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }     
           $this->view->item= $this->model;
    }
    public function editAction() {
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysdepartments/list";
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
            if(strlen($_POST["code_department"]) ){
                $this->model->setCode($_POST["code_department"]);
            }            
            if(strlen($_POST["name_department"])){
                $this->model->setName($_POST["name_department"]);
            }
            if(strlen($_POST["parent_id"])){
                if($this->model->getIs_root()==0)
                $this->model->setParent_Id($_POST["parent_id"]);
            }
            if(strlen($_POST["leader_department"])){
                $this->model->setLeader($_POST["leader_department"]);
            }            
            
            if(isset($_POST["order_department"])){
                $this->model->setOrder($_POST["order_department"]);
            }
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }        
        $this->view->item=$this->model;
    }
    public function changepasswordAction() {
        $id= $this->_getParam("id","");                
        $password= $this->_getParam("password","");
        $this->modelMapper->find($id,$this->model);
        $redirectUrl=$this->aConfig["site"]["url"]."admin/admin/list"; 
        if($this->getRequest()->isPost()){         
                $this->model->setPassword(md5($password));        
                $this->modelMapper->save($this->model);
            echo '[{"html":\'' . $redirectUrl . '\'}]';
            exit();       
        }
    }
    public  function confirmdeleteAction()
    {
        if($this->getRequest()->isPost()){
            $count =0;
           $id_sys_department = $this->_getParam("id","");
           $redirectUrl=$this->aConfig["site"]["url"]."admin/sysdepartments/list";      
           $this->modelMapper->find($id_sys_department,$this->model);
           $getId = $this->model->getId();
           if(empty($getId)){
                $this->_redirect($redirectUrl);
           }
           $id_sys_department_user = $this->modelMapperAdmin->findidbyname('sys_department_id',$getId);
           if($id_sys_department_user!=0){
               $count =1;
           }
            echo json_encode($count);                            
            exit();
        }
    }
    
    public function deleteAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysdepartments/list";               
        $this->modelMapper->delete($id);
        $this->_redirect($redirectUrl);
    }
    public function checkdepartmentscodeAction(){
          $this->_helper->layout()->disableLayout();
          if($this->_request->isPost()){
             $code_department= $this->_getParam("code_department","");
             $id= $this->modelMapper->findidbycode($code_department);
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
    public function checkusernameAction(){
        $this->_helper->layout->disableLayout();
        if($this->_request->isPost()){
            $username = $this->_getParam("username","");
            $usernameuser=$this->UsermodelMapper->findbyusername($username);
            $usernameadmin=$this->modelMapper->findbyusername($username);
            if($usernameuser != NULL || $usernameadmin != NULL){
                $menber[]=array(
                     'code'=>1,
                     'message'=>''
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
