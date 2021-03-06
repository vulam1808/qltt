<?php
include APPLICATION_PATH . "/models/Info_Schedule_Check.php";
include APPLICATION_PATH ."/models/Doc_Print_Allocation.php";
include APPLICATION_PATH."/models/Doc_Print_Create.php";
include APPLICATION_PATH . "/models/Sys_User.php";


class Admin_InfoScheduleCheckController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Info_Schedule_CheckMapper();
        $this->model= new Model_Info_Schedule_Check();
        $this->modelallocationMapper = new Model_Doc_Print_AllocationMapper();
        $this->modelallocation = new Model_Doc_Print_Allocation();
        $this->modelprintcreateMapper = new Model_Doc_Print_CreateMapper();
        $this->modeprintcreate = new Model_Doc_Print_Create();
        $this->modelMapperUser= new Model_Sys_UserMapper();
        $this->modelUser= new Model_Sys_User(); 
         $user_login =GlobalLib::getUserLogin();
         $this->user_id = $user_login["id"];
    }
    public function comboboxAction(){
         if($this->getRequest()->isPost()){             
              $combo = $_POST["arraycombobox"];//             
              $html="<div class=\"col-lg-2\">
                            <label>Serial</label>
                      </div>
                      <div class=\"col-lg-4\">"; 
               $comboHTML = GlobalLib::getcombo1('cobo_id',$combo,0);
               $html11 = $html.$comboHTML;             
              echo json_encode($html11);
              exit();
         }
    }
    public function returnserialAction(){
        if($this->getRequest()->isPost()){
            $masterprintid = $this->_getParam("master_print_id","");
            $docprintcreate = $this->_getParam("doc_print_create_id","");
            $iddocprintallocation= $this->modelallocationMapper->findidbyname1((int)$masterprintid,(int)$docprintcreate);
            $this->modelallocationMapper->find($iddocprintallocation,$this->modelallocation);
            $arrayserialcheck = $this->modelMapper->arrayserialcheck($iddocprintallocation);
            $getdocprintcreate = $this->modelallocation->getDoc_Print_Create_Id();
            $this->modelprintcreateMapper->find($getdocprintcreate,$this->modeprintcreate);
            $getserial = $this->modeprintcreate->getSerial();
            $getserialrecover1 = $this->modeprintcreate->getSerial_Recovery();
            $seriall = '';
            if($getserialrecover1==null){
                $seriall = $getserial;
            }else{
                $seriall =$getserialrecover1;
            }
            $serialll = GlobalLib::arraySerial($seriall);
            $menber[]=array(
                'serial'=>$serialll,                
                'serial_check'=>$arrayserialcheck
            );  
            echo json_encode($menber);
            exit();

        }
    }
    public function aaAction(){
        echo json_encode($this->modelallocationMapper->findidbyserial(3,19,30));
        exit();
    }

    public function addAction(){ 
//        $this->view->printcreatHTML = GlobalLib::getComboSeclect('doc_print_create_id', 'doc_print_create', 'id', 'coefficient',0,  false, 'where status !="DONE" and master_print_id="0" and is_delete="0"' , NULL, '', 'Chưa lựa');
             $this->view->scheduleHTML =  GlobalLib::getCombo('info_schedule_id', 'info_schedule', 'id', 'name_schedule',0, false, 'where sys_department_id=17');
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/infoschedulecheck/list/";            
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(isset($_POST["info_schedule_id"])){
                $this->model->setInfo_Schedule_Id($_POST["info_schedule_id"]);
            }
             if(isset($_POST["info_business_id"])){
                $this->model->setInfo_Business_Id($_POST["info_business_id"]);
            }  
            
            if(isset($_POST["master_print_id"])){
               $masterprintid= $_POST["master_print_id"];
            }
            if(isset($_POST["sys_department_id"])){
                $setSysDepartmentId = $_POST["sys_department_id"];
            }
            if(isset($_POST["doc_print_allocation_id"])){
                $Serial_Check = $_POST["doc_print_allocation_id"];
                $this->model->setSerial_Check($_POST["doc_print_allocation_id"]);
                
            }
             $doc_print_allocation_id = $this->modelallocationMapper->findidbyserial($masterprintid,$setSysDepartmentId,$Serial_Check);

             $this->model->setDoc_Print_Allocation_Id($doc_print_allocation_id); 
                        
            if(isset($_POST["sys_user_id"])){
                $id = $_POST["sys_user_id"];
            } 
            if($id != 0) {
                $this->model->setStaff_Check($id);
            }  else {
                $this->model->setStaff_Check(GlobalLib::getLoginId());
            }
            if(strlen($_POST["date_check"])<0){
                $date_check = date("Y/m/d H:i:s");
            }  else {
                $date_check = GlobalLib::toMysqlDateString($_POST["date_check"]);
            }
            $this->model->setDate_Check($date_check);
            if(isset($_POST["serial_check"])){
                $this->model->setSerial_Check($_POST["serial_check"]);
            }
            if(isset($_POST["sys_department_id"])){
                $this->model->setSys_Department_id($setSysDepartmentId);
            }
            if(isset($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(isset($_POST["is_violations"])){
                $is_violations=1;
            } else {
                $is_violations=0;
            }
            $this->model->setIs_Violations($is_violations);
            $this->model->setCreated_Date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_Date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_Delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item= $this->model;
    }
    public function listAction(){
        
    }
    public function editAction(){
         $id= $this->_getParam("id",""); 
          $redirectUrl = $this->aConfig["site"]["url"]."admin/infoschedulecheck/list/";    
         if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        $serialcheck = $this->model->getSerial_Check();
        $modifiedby = $this->model->getStaff_Check();
        $info_schedule_id = $this->model->getInfo_Schedule_Id();
        
        $getMasterPrintId=  GlobalLib::getName("doc_print_allocation",$this->model->getDoc_Print_Allocation_Id(),"master_print_id");
        $getDocPrintCreateId=GlobalLib::getName("doc_print_allocation",$this->model->getDoc_Print_Allocation_Id(),"doc_print_create_id");
        $id_user = $this->modelMapperUser->find($this->model->getStaff_Check(),$this->modelUser);
        $id_department = $this->modelUser->getSys_Department_Id();
         $this->view->getNameMasterPrint=$getMasterPrintId;
         $this->view->getSerialCheck=$serialcheck;
         $this->view->getModifiedBy=$modifiedby;
          $this->view->getinfoscheduleid=$info_schedule_id;
          $this->view->depart = $id_department;
//        $this->view->getDocPrintCreateId = $getDocPrintCreateId;
//                $this->view->printcreatHTML = GlobalLib::getComboSeclect('doc_print_create_id', 'doc_print_create', 'id', 'coefficient',$getDocPrintCreateId,  false, 'where status !="DONE" and master_print_id="0" and is_delete="0"' , NULL, '', 'Chưa lựa');

          if($this->getRequest()->isPost()){
             $redirectUrl = $this->aConfig["site"]["url"]."admin/infoschedulecheck/list/";               
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(isset($_POST["info_schedule_id"])){
                $this->model->setInfo_Schedule_Id($_POST["info_schedule_id"]);
            }
            if(isset($_POST["master_print_id"])){
               $masterprintid= $_POST["master_print_id"];
            }
            if(isset($_POST["sys_department_id"])){
                $setSysDepartmentId = $_POST["sys_department_id"];
            }
            if(isset($_POST["doc_print_allocation_id"])){
                $this->model->setSerial_Check($_POST["doc_print_allocation_id"]);
            }
            $doc_print_allocation_id = $this->modelallocationMapper->findidbyserial($_POST["master_print_id"],$setSysDepartmentId,$_POST["doc_print_allocation_id"]);

             $this->model->setDoc_Print_Allocation_Id($doc_print_allocation_id); 
             
            if(isset($_POST["info_business_id"])){
                $this->model->setInfo_Business_Id($_POST["info_business_id"]);
            } 
                        
            if(isset($_POST["sys_user_id"])){
                $id = $_POST["sys_user_id"];
            } 
            if($id != 0) {
                $this->model->setStaff_Check($id);
            }  else {
                $this->model->setStaff_Check(GlobalLib::getLoginId());
            }
            if(strlen($_POST["date_check"])<0){
                $date_check = date("Y/m/d H:i:s");
            }  else {
                $date_check = GlobalLib::toMysqlDateString($_POST["date_check"]);
            }
            $this->model->setDate_Check($date_check);
            if(isset($_POST["serial_check"])){
                $this->model->setSerial_Check($_POST["serial_check"]);
            }
            if(isset($_POST["sys_department_id"])){
                $this->model->setSys_Department_id($_POST["sys_department_id"]);
            }
            if(isset($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            $this->model->setCreated_Date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_Date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_Delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
            $this->view->item= $this->model;
    }  
     public function serviceAction(){
        $this->_helper->layout->disableLayout();
        $sys_department_id=null;
        foreach ($this->modelMapper->fetchAll($sys_department_id) as $items ) {
            $menber[]=array(
                'id' => $items->getId(),
                'info_schedule_id'=> GlobalLib::getName("info_schedule",$items->getInfo_Schedule_Id(),"name_schedule"),  
                'info_business_id'=>  GlobalLib::getName("info_business",$items->getInfo_Business_Id(),"name"),
                'doc_print_create_id'=> GlobalLib::getName("doc_print_create",GlobalLib::getName("doc_print_allocation",$items->getDoc_Print_Allocation_Id(),"doc_print_create_id"),"coefficient"),
                'master_print_id'=> GlobalLib::getName("master_print",GlobalLib::getName("doc_print_allocation",$items->getDoc_Print_Allocation_Id(),"master_print_id"),"code"),
                'serial_check'=>$items->getSerial_Check(),
                'staff_check'=>  GlobalLib::getName('sys_user',$items->getStaff_Check(),'first_name').' '.GlobalLib::getName('sys_user',$items->getStaff_Check(),'last_name'),
                'date_check'=>  GlobalLib::viewDate($items->getDate_Check()),
                'sys_department_id'=>  GlobalLib::getName('sys_department', $items->getSys_Department_Id(), 'name'),                
                'created_date'=>$items->getCreated_Date(),
                'created_by'=>$items->getCreated_By(),
                'modified_date'=>$items->getModified_Date(),
                'modified_by'=>$items->getModified_By(),
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus(),
                'comment'=>$items->getComment(),  
                'doc_violations_handling_id'=>$items->getDoc_Violations_Handling_Id(), 
                'is_delete'=>$items->getIs_Delete()

            );
        }
        echo json_encode($menber);
        exit();
    }
    public function servicedepartmentAction(){
        $this->_helper->layout->disableLayout();
        $info_business_id=$this->_getParam("info_business_id","0");
        $sys_department_id=$this->_getParam("sys_department_id","0");
        $date_check = GlobalLib::toMysqlDateString($this->_getParam("date_check",""));
        $stringid = $this->_getParam("stringid","");
        //$stringid = "15";
        if($stringid ==""){
            $where = "where  is_delete = '0' and info_business_id='$info_business_id' and sys_department_id='$sys_department_id' and date_check='$date_check'  and is_violations='1' and  ISNULL(doc_violations_handling_id)";
        }else{
             $where = "where id not in($stringid)"." and is_delete = '0' and info_business_id='$info_business_id' and sys_department_id='$sys_department_id' and date_check='$date_check'  and is_violations='1' and  ISNULL(doc_violations_handling_id)";
        }
        foreach ($this->modelMapper->fetchAlll($where) as $items ) {
            $menber[]=array(
                'id_infocheck' => $items->getId(),
                'info_schedule_id_infocheck'=> GlobalLib::getName("info_schedule",$items->getInfo_Schedule_Id(),"name_schedule"),  
                'info_business_id_infocheck'=>  GlobalLib::getName("info_business",$items->getInfo_Business_Id(),"name"),
                'doc_print_create_id_infocheck'=> GlobalLib::getName("doc_print_create",GlobalLib::getName("doc_print_allocation",$items->getDoc_Print_Allocation_Id(),"doc_print_create_id"),"coefficient"),
                'master_print_id_infocheck'=> GlobalLib::getName("master_print",GlobalLib::getName("doc_print_allocation",$items->getDoc_Print_Allocation_Id(),"master_print_id"),"code"),
                'serial_check_infocheck'=>$items->getSerial_Check(),
                'staff_check_infocheck'=>  GlobalLib::getName('sys_user',$items->getStaff_Check(),'first_name').' '.GlobalLib::getName('sys_user',$items->getStaff_Check(),'last_name'),
                'date_check_infocheck'=>  GlobalLib::viewDate($items->getDate_Check()),
                'sys_department_id_infocheck'=>  GlobalLib::getName('sys_department', $items->getSys_Department_Id(), 'name'),  
                'doc_violations_handling_id_infocheck'=>$items->getDoc_Violations_Handling_Id()
            );
        }
        echo json_encode($menber);
        exit();
    }
    public function findinfobusinessbyinfoscheduleAction(){
        $this->_helper->layout->disableLayout();
        $id = $this->_getParam("id","");
        foreach ($this->modelMapper->fetchAllbyscheduleid($id) as $items ) {
            $menber[]=array(
                'id' => $items->getId(),
                'info_schedule_id'=> GlobalLib::getName("info_schedule",$items->getInfo_Schedule_Id(),"name_schedule"),  
                'info_business_id'=>  GlobalLib::getName("info_business",$items->getInfo_Business_Id(),"name"),
                'doc_print_create_id'=> GlobalLib::getName("doc_print_create",GlobalLib::getName("doc_print_allocation",$items->getDoc_Print_Allocation_Id(),"doc_print_create_id"),"coefficient"),
                'master_print_id'=> GlobalLib::getName("master_print",GlobalLib::getName("doc_print_allocation",$items->getDoc_Print_Allocation_Id(),"master_print_id"),"code"),
                'serial_check'=>$items->getSerial_Check(),
                'staff_check'=>  GlobalLib::getName('sys_user',$items->getStaff_Check(),'first_name').' '.GlobalLib::getName('sys_user',$items->getStaff_Check(),'last_name'),
                'date_check'=>  GlobalLib::viewDate($items->getDate_Check()),
                'sys_department_id'=>  GlobalLib::getName('sys_department', $items->getSys_Department_Id(), 'name'),                
                'created_date'=>$items->getCreated_Date(),
                'created_by'=>$items->getCreated_By(),
                'modified_date'=>$items->getModified_Date(),
                'modified_by'=>$items->getModified_By(),
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus(),
                'comment'=>$items->getComment(),    
                'is_delete'=>$items->getIs_Delete()

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
        $redirectUrl=$this->aConfig["site"]["url"]."admin/infoschedulecheck/list";               
        $this->modelMapper->deleteInfo_Schedule_Check($id);
        $this->_redirect($redirectUrl);
    }  
}
