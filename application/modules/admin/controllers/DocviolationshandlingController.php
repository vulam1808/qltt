<?php
include APPLICATION_PATH . "/models/Doc_Violations_Handling.php";
include APPLICATION_PATH . "/models/Doc_Print_Allocation.php";
include APPLICATION_PATH . "/models/Doc_Items_Handling.php";
include APPLICATION_PATH . "/models/Doc_Print_Handling.php";
include APPLICATION_PATH . "/models/Info_Schedule_Check.php";
include APPLICATION_PATH . "/models/Sys_User.php";

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_DocViolationsHandlingController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Doc_Violations_HandlingMapper();
        $this->model= new Model_Doc_Violations_Handling(); 
        $this->modeldocprintallocation= new Model_Doc_Print_Allocation();
        $this->modelMapperdocprintallocation = new Model_Doc_Print_AllocationMapper();
        $this->modelDocItemsHandling = new Model_Doc_Items_Handling();
        $this->modelMapperDocItemsHandling = new Model_Doc_Items_HandlingMapper();
        $this->modelDocPrintHandling = new Model_Doc_Print_Handling();
        $this->modelMapperDocPrintHandling = new Model_Doc_Print_HandlingMapper();
        $this->modelInfoScheduleCheck = new Model_Info_Schedule_Check();
        $this->modelMapperInfoScheduleCheck = new Model_Info_Schedule_CheckMapper();
        $this->modelMapperSysUser= new Model_Sys_UserMapper();
        $this->modelSysUser= new Model_Sys_User(); 
        
         $user_login =GlobalLib::getUserLogin();
         $this->user_id = $user_login["id"];
        
    }
    public function tamAction(){
        
    }
    //luu xu phat hang hóa vo chu
    public function saveownerlessgoodsAction(){
         $this->_helper->layout->disableLayout();
        if($this->getRequest()->isPost()){
           $redirectUrl = $this->aConfig["site"]["url"]."admin/docviolationshandling/listownerlessgoods";
           $arraydataxuphatvochu = $_POST['dataxuphatvochu'];
           ///
           //cap nhat trang thai cho doc_voilationshandling
           $this->modelMapper->updatesorderDoc_Violations_Handling();
            //them thong tin vao bang doc_violationshandling
                $this->model->setSys_Department_Id($arraydataxuphatvochu[0]['sys_department_id']);
                $this->model->setSys_User_Id(GlobalLib::getLoginId());
                $this->model->setDate_Violation(GlobalLib::toMysqlDateString($arraydataxuphatvochu[0]['date_handling']));
                $this->model->setOrder(1);
                $this->model->setCreated_Date(date("Y/m/d H:i:s"));
                $this->model->setCreated_By(GlobalLib::getLoginId());
                $this->model->setModified_Date(date("Y/m/d H:i:s"));
                $this->model->setModified_By(GlobalLib::getLoginId());
                $this->model->setIs_Delete(0);
                $this->modelMapper->save($this->model);
                
                //tim ra id doc_vialattionshandling co order =1( vua moi them vao)
               $id_doc_violationshandling =  $this->modelMapper->findidbyname("`order`",1);
                
           for($i=0;$i<count($arraydataxuphatvochu);$i++){
                //luu du lieu vao doc_items_handling
                   $this->modelDocItemsHandling->setMaster_Items_Id((int)$arraydataxuphatvochu[$i]['master_items_id']);
                   $this->modelDocItemsHandling->setMaster_Sanction_Id((int)$arraydataxuphatvochu[$i]['master_sanction_id']);
                   $this->modelDocItemsHandling->setDoc_Violations_Handling_Id($id_doc_violationshandling);
                   $this->modelDocItemsHandling->setSerial_Handling($arraydataxuphatvochu[$i]['serial_handling']);
                   $this->modelDocItemsHandling->setQuantity_Commodity($arraydataxuphatvochu[$i]['quantity_commodity']);
                   $this->modelDocItemsHandling->setMaster_Unit_Id((int)$arraydataxuphatvochu[$i]['master_unit_id']);
                   $this->modelDocItemsHandling->setDate_Handling(GlobalLib::toMysqlDateString($arraydataxuphatvochu[$i]['date_handling']));
                   $this->modelDocItemsHandling->setAmount($arraydataxuphatvochu[$i]['amount']);
                   $this->modelDocItemsHandling->setComment($arraydataxuphatvochu[$i]['comment']);
                   $this->modelDocItemsHandling->setStatus($arraydataxuphatvochu[$i]['status']); 
                   $this->modelDocItemsHandling->setCreated_Date(date("Y/m/d H:i:s"));
                   $this->modelDocItemsHandling->setCreated_By(GlobalLib::getLoginId());
                   $this->modelDocItemsHandling->setModified_Date(date("Y/m/d H:i:s"));
                   $this->modelDocItemsHandling->setModified_By(GlobalLib::getLoginId());
                   $this->modelDocItemsHandling->setIs_Delete(0);
                   $this->modelMapperDocItemsHandling->save($this->modelDocItemsHandling);
           }
           echo json_encode($redirectUrl);
           exit();
//            $this->redirect($redirectUrl);
        }
        
    }
     //luu them moi hang hoa tich thu khi xu phat
    public function saveitemshandlingAction(){
         $this->_helper->layout->disableLayout();
        if($this->getRequest()->isPost()){
           $redirectUrl = $this->aConfig["site"]["url"]."admin/docviolationshandling/listownerlessgoods";
           $arraydata = $_POST['dataadd'];
           for($i=0;$i<count($arraydata);$i++){
                //luu du lieu vao doc_items_handling
                   $this->modelDocItemsHandling->setMaster_Items_Id((int)$arraydata[$i]['master_items_id']);
                   $this->modelDocItemsHandling->setMaster_Sanction_Id((int)$arraydata[$i]['master_sanction_id']);
                   $this->modelDocItemsHandling->setDoc_Violations_Handling_Id((int)$arraydata[$i]['id']);
                   $this->modelDocItemsHandling->setSerial_Handling($arraydata[$i]['serial_handling']);
                   $this->modelDocItemsHandling->setQuantity_Commodity($arraydata[$i]['quantity_commodity']);
                   $this->modelDocItemsHandling->setMaster_Unit_Id((int)$arraydata[$i]['master_unit_id']);
                   $this->modelDocItemsHandling->setDate_Handling(GlobalLib::toMysqlDateString($arraydata[$i]['date_handling']));
                   $this->modelDocItemsHandling->setAmount($arraydata[$i]['amount']);
//                   $this->modelDocItemsHandling->setComment($arraydata[0]['comment']);
                   $this->modelDocItemsHandling->setStatus(GlobalLib::getName('master_sanction', (int)$arraydata[$i]['master_sanction_id'], 'code')); 
                   $this->modelDocItemsHandling->setCreated_Date(date("Y/m/d H:i:s"));
                   $this->modelDocItemsHandling->setCreated_By(GlobalLib::getLoginId());
                   $this->modelDocItemsHandling->setModified_Date(date("Y/m/d H:i:s"));
                   $this->modelDocItemsHandling->setModified_By(GlobalLib::getLoginId());
                   $this->modelDocItemsHandling->setIs_Delete(0);
                   $this->modelMapperDocItemsHandling->save($this->modelDocItemsHandling);
           }
           echo json_encode($redirectUrl);
           exit();
//            $this->redirect($redirectUrl);
        }
        
    }
     //
     public function editvochuAction(){
       $id= $this->_getParam("id","");  
       $type=$this->_getParam("type","");  
        $this->modelMapperDocItemsHandling->find($id,$this->modelDocItemsHandling);
        $getId=$this->modelDocItemsHandling->getId();
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
         if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/docviolationshandling/listownerlessgoods";            
            if(isset($_POST["master_items_id"])){
                $this->modelDocItemsHandling->setMaster_Items_Id($_POST["master_items_id"]);
            }
            if(strlen($_POST["master_sanction_id"])>0){
                $this->modelDocItemsHandling->setMaster_Sanction_Id($_POST["master_sanction_id"]);
                $this->modelDocItemsHandling->setStatus(GlobalLib::getName("master_sanction",$_POST["master_sanction_id"],"code"));
            }           
            if(strlen($_POST["serial_handling"])){
                $this->modelDocItemsHandling->setSerial_Handling($_POST["serial_handling"]);
            }
            if(strlen($_POST["quantity_commodity"])){
                $this->modelDocItemsHandling->setQuantity_Commodity($_POST["quantity_commodity"]);
            }           
            if(isset($_POST["master_unit_id"])){
                $this->modelDocItemsHandling->setMaster_Unit_Id($_POST["master_unit_id"]);
            }
            if(strlen($_POST["date_handling"])>0){
                $this->modelDocItemsHandling->setDate_Handling(GlobalLib::toMysqlDateString($_POST["date_handling"]));
            }
             if(isset($_POST["amount"])){
                $this->modelDocItemsHandling->setAmount($_POST["amount"]);
            }
            $this->modelDocItemsHandling->setStatus($_POST["status"]);
            $this->modelDocItemsHandling->setCreated_Date(date("Y/m/d H:i:s"));
            $this->modelDocItemsHandling->setCreated_By(GlobalLib::getLoginId());
            $this->modelDocItemsHandling->setModified_Date(date("Y/m/d H:i:s"));
            $this->modelDocItemsHandling->setModified_By(GlobalLib::getLoginId());
            $this->modelMapperDocItemsHandling->save($this->modelDocItemsHandling);
            $this->_redirect($redirectUrl);
        }     
        $this->view->type=$type;
        $this->view->item= $this->modelDocItemsHandling;
  }
   ///
    public function namedepartmentAction(){
          if($this->getRequest()->isPost()){   
              $arraydata = $_POST['data'];
              $menber[]=array(                     
                    'name_department'=>  GlobalLib::getName('sys_department', $arraydata[0]['sys_department_id'], 'name')  ,
                    'name_items'=>  GlobalLib::getName('master_items', $arraydata[0]['master_items_id'], 'name') ,
                    'name_sanction'=>  GlobalLib::getName('master_sanction', $arraydata[0]['master_sanction_id'], 'name') ,
                    'name_unit'=>  GlobalLib::getName('master_unit', $arraydata[0]['master_unit_id'], 'name') ,
                    'name_status'=>  GlobalLib::getNameStatus( $arraydata[0]['status']) 
               );
              echo json_encode($menber);                            
              exit();
          }
    }
     public function namedepartmenttAction(){
          if($this->getRequest()->isPost()){   
              $arraydata = $_POST['data'];
              $menber[]=array(                     
                    'name_department'=> GlobalLib::getName('sys_department', $arraydata[0]['sys_department_id'], 'name')  ,
                    'name_items'=>  GlobalLib::getName('master_items', $arraydata[0]['master_items_id'], 'name') ,
                    'name_sanction'=>  GlobalLib::getName('master_sanction', $arraydata[0]['master_sanction_id'], 'name') ,
                    'name_unit'=>  GlobalLib::getName('master_unit', $arraydata[0]['master_unit_id'], 'name') 
               );
              echo json_encode($menber);                            
              exit();
          }
    }
    public function editshandlingAction() {
         $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list/type_business/DoanhNghiep";
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
            if(isset($_POST["info_business_id"])){
                $this->model->setInfo_Business_Id($_POST["info_business_id"]);
            }
            if(strlen($_POST["master_violation_id1"])){
                $this->model->setMaster_Violation_Id($_POST["master_violation_id1"]);
            } 
            if(strlen($_POST["master_sanctions_id"])){
                $this->model->setMaster_Sanctions_Id($_POST["master_sanctions_id"]);
            }
            if(strlen($_POST["amount"])){
                $this->model->setAmount($_POST["amount"]);
            }
            if(strlen($_POST["sys_user_id"])){
                $this->model->setSys_User_Id($_POST["sys_user_id"]);
            } 
            if(strlen($_POST["date_violation"])){
               $this->model->setDate_Violation(GlobalLib::toMysqlDateString($_POST["date_violation"]));
            }
             if(strlen($_POST["comment"])){
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
        $this->view->item=$this->model;
        
    }
    public function indexAction(){ 
         if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/docviolationshandling/list";
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(isset($_POST["master_business_id"])){
                $this->model->setMaster_Business_Id($_POST["master_business_id"]);
            }
            if(isset($_POST["master_violation_id"])){
                $this->model->setMaster_Violation_Id($_POST["master_violation_id"]);
            } 
            if(strlen($_POST["master_sanctions_id"])){
                $this->model->setMaster_Sanctions_Id($_POST["master_sanctions_id"]);
            }
            if(strlen($_POST["master_deparment_id"])){
                $this->model->setMaster_Deparment_Id($_POST["master_deparment_id"]);
            } 
            if(strlen($_POST["sys_user_id"])){
                $this->model->setSys_User_Id($_POST["sys_user_id"]);
            } 
            if(strlen($_POST[" date_violation"])){
                $this->model->setDate_Violation($_POST["date_violation"]);
            } 
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            if(strlen($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(isset($_POST["status"])){
                $status=1;
            } else {
                $status=0;
            }
            $this->model->setStatus($status); 
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
    public function add1Action(){
    }
    public function popupprintAction(){
    }
    public function list1Action(){
    }
    public function list2Action(){
    }
    public function secviceitemsAction(){
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapperDocItemsHandling->fetchAll() as $items ) {
            $menber[]=array(
                'id'=>$items->getId(),
                'master_items_id'=>$items->getMaster_Items_Id(),
                'master_sanction_id'=>$items->getMaster_Sanction_Id(),
                'doc_violations_handling_id'=>$items->getDoc_Violations_Handling_Id(),
                'serial_handling'=>$items->getSerial_Handling(),
                'quantity_commodity'=>$items->getQuantity_Commodity(),
                'master_unit_id'=>$items->getMaster_Unit_Id(),
                'date_handling'=>$items->getDate_Handling(),
                'amount'=>$items->getAmount(),
                'file_upload'=>$items->getFile_Upload(),
                'comment'=>$items->getComment(),
            );
        }
        echo json_encode($menber);
        exit();
    }
    public function editprintshandlingAction(){
        $id = $this->_getParam("id","");
        $idprint = $this->_getParam("idprint","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list/type_business/DoanhNghiep";
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        $sysDepartmentId = $this->model->getSys_Department_Id();
        $this->view->sysDepartmentId = $sysDepartmentId;
        $this->modelMapperDocPrintHandling->find($idprint,$this->modelDocPrintHandling);
        $sysMasterPrint = $this->modelDocPrintHandling->getMaster_Print_Id();
        $serialHanding = $this->modelDocPrintHandling->getSerial_Handing();
        $this->view->sysMasterPrint = $sysMasterPrint;
        $this->view->serialHanding = $serialHanding;
        
        if(empty($getId)){
            $this->_redirect($redirectUrl);
        }
        
        if($this->getRequest()->isPost()){           
//            
            $redirectUrl = $this->aConfig["site"]["url"]."admin/docviolationshandling/list";
            if(isset($_POST["id"])){
                $this->modelDocPrintHandling->setId($_POST["id"]);
            }
            if(isset($_POST["master_print_id"])){
                $this->modelDocPrintHandling->setMaster_Print_Id($_POST["master_print_id"]);
            }
            if(isset($_POST["sys_department_id"])){
                $setSysDepartmentId = $_POST["sys_department_id"];
            }
            if(isset($_POST["doc_print_allocation_id"])){
                $this->modelDocPrintHandling->setSerial_Handing($_POST["doc_print_allocation_id"]);
            }
            $doc_print_allocation_id = $this->modelMapperdocprintallocation->findidbyserial($_POST["master_print_id"],$setSysDepartmentId,$_POST["doc_print_allocation_id"]);
            
            $this->modelDocPrintHandling->setDoc_Violations_Handling_Id($getId); 
            $this->modelDocPrintHandling->setDoc_Print_Allocation_Id($doc_print_allocation_id); 
           
            if(isset($_POST["order"])){
                $this->modelDocPrintHandling->setOrder($_POST["order"]);
            }
            if(strlen($_POST["comment"])){
                $this->modelDocPrintHandling->setComment($_POST["comment"]);
            }
            if(isset($_POST["status"])){
                $status=1;
            } else {
                $status=0;
            }
            
            $this->modelDocPrintHandling->setStatus($status); 
            $this->modelDocPrintHandling->setCreated_Date(date("Y/m/d H:i:s"));
            $this->modelDocPrintHandling->setCreated_By(GlobalLib::getLoginId());
            $this->modelDocPrintHandling->setModified_Date(date("Y/m/d H:i:s"));
            $this->modelDocPrintHandling->setModified_By(GlobalLib::getLoginId());
            $this->modelDocPrintHandling->setIs_Delete(0);
            $this->modelMapperDocPrintHandling->save($this->modelDocPrintHandling);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->modelDocPrintHandling;
    }
    public function edititemshandlingAction(){
        $id = $this->_getParam("id","");
        $idprint = $this->_getParam("iditem","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list/type_business/DoanhNghiep";
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        $sysDepartmentId = $this->model->getSys_Department_Id();
        $this->view->sysDepartmentId = $sysDepartmentId;
        $this->modelMapperDocItemsHandling->find($idprint,$this->modelDocItemsHandling);
        
        if(empty($getId)){
            $this->_redirect($redirectUrl);
        }
        if($this->getRequest()->isPost()){ 
            $redirectUrl = $this->aConfig["site"]["url"]."admin/docviolationshandling/list";
            if(isset($_POST["id"])){
                $this->modelDocItemsHandling->setId($_POST["id"]);
            }
            if(isset($_POST["master_items_id"])){
                $this->modelDocItemsHandling->setMaster_Items_Id($_POST["master_items_id"]);
            }
            if(isset($_POST["master_sanction_id"])){
                $this->modelDocItemsHandling->setMaster_Sanction_Id($_POST["master_sanction_id"]);
            }
            $this->modelDocItemsHandling->setDoc_Violations_Handling_Id($getId); 
            if(strlen($_POST["serial_handling"])){
                $this->modelDocItemsHandling->setSerial_Handling($_POST["serial_handling"]);
            }
            if(strlen($_POST["quantity_commodity"])){
                $this->modelDocItemsHandling->setQuantity_Commodity($_POST["quantity_commodity"]);
            }
            if(isset($_POST["master_unit_id"])){
                $this->modelDocItemsHandling->setMaster_Unit_Id($_POST["master_unit_id"]);
            }
//            if(strlen($_POST["date_handling"])){
//                $this->modelDocItemsHandling->setDate_Handling($_POST["date_handling"]);
//            }
            if(strlen($_POST["date_handling"])<=0){
                $ngaytao = date("Y/m/d H:i:s");
            }  else {
                $ngaytao = GlobalLib::toMysqlDateString($_POST["date_handling"]);
            }
            $this->modelDocItemsHandling->setDate_Handling($ngaytao);
            if(strlen($_POST["amount"])){
                $this->modelDocItemsHandling->setAmount($_POST["amount"]);
            }
            if(strlen($_POST["comment"])){
                $this->modelDocItemsHandling->setComment($_POST["comment"]);
            }
            if(isset($_POST["order"])){
                $this->modelDocItemsHandling->setOrder($_POST["order"]);
            }
            
            if(isset($_POST["status"])){
                $status=1;
            } else {
                $status=0;
            }
            
            $this->modelDocItemsHandling->setStatus($status); 
            $this->modelDocItemsHandling->setCreated_Date(date("Y/m/d H:i:s"));
            $this->modelDocItemsHandling->setCreated_By(GlobalLib::getLoginId());
            $this->modelDocItemsHandling->setModified_Date(date("Y/m/d H:i:s"));
            $this->modelDocItemsHandling->setModified_By(GlobalLib::getLoginId());
            $this->modelDocItemsHandling->setIs_Delete(0);
            $this->modelMapperDocItemsHandling->save($this->modelDocItemsHandling);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->modelDocItemsHandling;
    }
    public function additemshandlingAction(){
        $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list/type_business/DoanhNghiep";
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        $sysDepartmentId = $this->model->getSys_Department_Id();
        $this->view->sysDepartmentId = $sysDepartmentId;
         $this->view->id = $id;
        if(empty($getId)){
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->modelDocItemsHandling;
    }
    public function addAction(){
         
         $this->view->type_business = $this->_getParam("type_business","");
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/docviolationshandling/list";
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(isset($_POST["master_business_id"])){
                $this->model->setMaster_Business_Id($_POST["master_business_id"]);
            }
            if(isset($_POST["master_violation_id"])){
                $this->model->setMaster_Violation_Id($_POST["master_violation_id"]);
            } 
            if(strlen($_POST["master_sanctions_id"])){
                $this->model->setMaster_Sanctions_Id($_POST["master_sanctions_id"]);
            }
            if(strlen($_POST["master_deparment_id"])){
                $this->model->setMaster_Deparment_Id($_POST["master_deparment_id"]);
            } 
            if(strlen($_POST["sys_user_id"])){
                $this->model->setSys_User_Id($_POST["sys_user_id"]);
            } 
            if(strlen($_POST[" date_violation"])){
                $this->model->setDate_Violation($_POST["date_violation"]);
            } 
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            if(strlen($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(isset($_POST["status"])){
                $status=1;
            } else {
                $status=0;
            }
            $this->model->setStatus($status); 
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
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list/type_business/DoanhNghiep";
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
            if(isset($_POST["info_business_id"])){
                $this->model->setInfo_Business_Id($_POST["info_business_id"]);
            }
            if(strlen($_POST["master_violation_id1"])){
                $this->model->setMaster_Violation_Id($_POST["master_violation_id1"]);
            } 
            if(strlen($_POST["master_sanctions_id"])){
                $this->model->setMaster_Sanctions_Id($_POST["master_sanctions_id"]);
            }
            if(strlen($_POST["amount"])){
                $this->model->setAmount($_POST["amount"]);
            }
            if(strlen($_POST["sys_user_id"])){
                $this->model->setSys_User_Id($_POST["sys_user_id"]);
            } 
            if(strlen($_POST["date_violation"])){
               $this->model->setDate_Violation(GlobalLib::toMysqlDateString($_POST["date_violation"]));
            }
             if(strlen($_POST["comment"])){
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
        $this->view->item=$this->model;
    }  
    public function edititemshandingAction(){
        $id_itemshanding = $this->_getParam("id","");
        $doc_violations_handling_id = $this->_getParam("doc_violations_handling_id","");
        
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list";
        if(empty($id_itemshanding)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapperDocItemsHandling->find($id_itemshanding,$this->modelDocItemsHandling);
        $getId=$this->modelDocItemsHandling->getId();
        if(empty($getId)){
            $this->_redirect($redirectUrl);
        }
        if($this->getRequest()->isPost()){           
            if(isset($_POST["id"])){
                $this->modelDocItemsHandling->setId($_POST["id"]);
            }
            if(isset($_POST["master_items_id"])){
                $this->modelDocItemsHandling->setMaster_Items_Id($_POST["master_items_id"]);
            }
            if(isset($_POST["master_sanction_id"])){
                $this->modelDocItemsHandling->setMaster_Sanction_Id($_POST["master_sanction_id"]);
            } 
            if(strlen($_POST["doc_violations_handling_id"])>0){
                $this->modelDocItemsHandling->setDoc_Violations_Handling_Id($_POST["doc_violations_handling_id"]);
            }
            if(isset($_POST["serial_handling"])){
                $this->modelDocItemsHandling->setSerial_Handling($_POST["serial_handling"]);
            }
            if(isset($_POST["quantity_commodity"])){
                $this->modelDocItemsHandling->setQuantity_Commodity($_POST["quantity_commodity"]);
            } 
            if(strlen($_POST["master_unit_id"])){
                $this->modelDocItemsHandling->setMaster_Unit_Id($_POST["master_unit_id"]);
            }
            
            if(strlen($_POST["ngaytichthu"])>0){
               $ngay_tich_thu = GlobalLib::toMysqlDateString($_POST["ngaytichthu"]);
            }  else {
               $ngay_tich_thu = date("Y/m/d H:i:s");
            }
            $this->modelDocItemsHandling->setDate_Handling($ngay_tich_thu);
            if(strlen($_POST["amount"])){
                $this->modelDocItemsHandling->setAmount($_POST["amount"]);
            }
            if(strlen($_POST["file_upload"])){
                $this->modelDocItemsHandling->setFile_Upload($_POST["file_upload"]);
            }
            if(strlen($_POST["comment"])){
                $this->modelDocItemsHandling->setComment($_POST["comment"]);
            }
            $this->modelDocItemsHandling->setCreated_Date(date("Y/m/d H:i:s"));
            $this->modelDocItemsHandling->setCreated_By(GlobalLib::getLoginId());
            $this->modelDocItemsHandling->setModified_Date(date("Y/m/d H:i:s"));
            $this->modelDocItemsHandling->setModified_By(GlobalLib::getLoginId());
            $this->modelDocItemsHandling->setIs_Delete(0);
            $this->modelMapperDocItemsHandling->save($this->modelDocItemsHandling);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->modelDocItemsHandling;
    }
    public function editprinthandlingAction(){
        $id_itemshanding = $this->_getParam("id","");
        $doc_violations_handling_id = $this->_getParam("doc_violations_handling_id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list";
        if(empty($id_itemshanding)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapperDocPrintHandling->find($id_itemshanding,$this->modelDocPrintHandling);
        $getId=$this->modelDocPrintHandling->getId();
         $getDocPrintAllocation = $this->modelDocPrintHandling->getDoc_Print_Allocation_Id();
        if(empty($getId)){
            $this->_redirect($redirectUrl);
        }
        if(empty($getDocPrintAllocation)){
             $this->_redirect($redirectUrl);
        }
        $this->modelMapperdocprintallocation->find($getDocPrintAllocation,$this->modeldocprintallocation);
        $sys_department_id = $this->modeldocprintallocation->getSys_Department_Id();
        //cho ra combobox an chi theo phong ban lay tu ma id_doc_violations_handling
         $this->view->masterprintidHTML = GlobalLib::getComboByMasterPrint('master_print_id', 'master_print', 'id', 'name', 0, FALSE, 'form-control', '', 'where id in (select master_print_id from doc_print_allocation where sys_department_id ="1")', '', 'onchange="getDepartmentMasterPrintWithSerial(\'' . $this->aConfig["site"]["url"] . '\','.$sys_department_id.')"');
         $this->view->serialallocationHTML = GlobalLib::getComboByPrintSerial('doc_print_allocation_id', 'doc_print_allocation', 'id', 'serial_allocation', 0, false, 'form-control', '', 'where master_print_id="0"', '', '');
        
        if($this->getRequest()->isPost()){           
            if(isset($_POST["id"])){
                $this->modelDocPrintHandling->setId($_POST["id"]);
            }
            if(isset($_POST["doc_print_allocation_id"])){
                $this->modelDocPrintHandling->setDoc_Print_Allocation_Id($_POST["doc_print_allocation_id"]);
            }
            $this->modelDocPrintHandling->setDoc_Violations_Handling_Id($doc_violations_handling_id);
            if(strlen($_POST["comment"])){
                $this->modelDocPrintHandling->setComment($_POST["comment"]);
            }
            $this->modelDocPrintHandling->setCreated_Date(date("Y/m/d H:i:s"));
            $this->modelDocPrintHandling->setCreated_By(GlobalLib::getLoginId());
            $this->modelDocPrintHandling->setModified_Date(date("Y/m/d H:i:s"));
            $this->modelDocPrintHandling->setModified_By(GlobalLib::getLoginId());
            $this->modelDocPrintHandling->setIs_Delete(0);
            $this->modelMapperDocPrintHandling->save($this->modelDocPrintHandling);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->modelDocPrintHandling;
        
    }
   
    public function listownerlessgoodsAction(){}
    public function addownerlessgoodsAction(){
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list/type_business/DoanhNghiep";
        $this->modelMapperSysUser->find(GlobalLib::getLoginId(),$this->modelSysUser);
        $getId=$this->modelSysUser->getId();
        $sysDepartmentId = $this->modelSysUser->getSys_Department_Id();
        $this->view->sysDepartmentId = $sysDepartmentId;
    }
    public function serviceownerlessgoodsAction(){
        $this->_helper->layout->disableLayout();
        $status = $this->_getParam("status","");
        echo json_encode($this->modelMapper->fetchvochu($status));
        exit();
    }
    public function listAction(){       
        $id= $this->_getParam("id","");
        $month= $this->_getParam("month","");
        $year = $this->_getParam("year","");
        $seltab = $this->_getParam("seltab","");
        $this->view->id=$id;
        $this->view->month=$month;
        $this->view->year=$year;
        $this->view->seltab =$seltab;
        if($this->getRequest()->isPost()){
            
            if(isset($_POST["month"])){
                $this->view->month=$_POST["month"];
            }
            if(isset($_POST["year"])){
                $this->view->year=$_POST["year"];
            }
            
        }
    } 
    public function listfrominfobusinessAction(){       
        $id= $this->_getParam("id","");     
        $this->view->id=$id;
    } 
    
    //ham tra ve an chi theo phong ban, va an chi hien ra chi la an chi chua xua ly va khong thu hoi
    public function secviceprintdepartmentAction(){
        $this->_helper->layout->disableLayout();
        $sys_department_id = $this->_getParam("id","");
        foreach ($this->modelMapperdocprintallocation->fetchAlll11("select distinct master_print_id from doc_print_allocation where sys_department_id ='$sys_department_id'") as $value) {
            $menber[]=array(
                'master_print_id'=>$value->getMaster_Print_Id(),
                'name_print'=>  GlobalLib::getName('master_print', $value->getMaster_Print_Id(), 'name')
            );
        }
        echo json_encode($menber);
        exit();
    }
    public function secviceprintdepartmentaAction(){
        $this->_helper->layout->disableLayout();
        $sys_department_id = $this->_getParam("id","");
        foreach ($this->modelMapperdocprintallocation->fetchAlll11q("select distinct master_print_id from doc_print_allocation where sys_department_id ='$sys_department_id'") as $value) {
            $menber[]=array(
                'master_print_id'=>$value->getMaster_Print_Id(),
                'name_print'=>  GlobalLib::getName('master_print', $value->getMaster_Print_Id(), 'code')
            );
        }
        echo json_encode($menber);
        exit();
    }
    //
    public function arrayserialshandlingAction(){
        $this->_helper->layout->disableLayout();
        $idmasterprint = $this->_getParam("idmaster","4");
        $idsysdepartment = $this->_getParam("idsys","17");
        $i=0;$arrayserial = array();
        foreach ($this->modelMapperdocprintallocation->arrayserial($idmasterprint,$idsysdepartment) as $items ) {
           $serialtam = $items->getserial_recovery1();
           $arraytam = explode("-", $serialtam);
           for($j = (int)$arraytam[0];$j<= (int)$arraytam[1];$j++){
               $arrayserial[$i++]=$j;
           }
        }
        echo json_encode($arrayserial);
        exit();
    }
    //mang lay ra danh sach serial_allocation
    public function arrayserialcheckAction(){
        $this->_helper->layout->disableLayout();
        if($this->getRequest()->isPost()){ 
//            $idmasterprint = $this->_getParam("idmaster","4");
//            $idsysdepartment = $this->_getParam("idsys","17");
            $arraydata = $_POST['data'];
            $idmasterprint =  $arraydata[0]['master_print_id'];
            $idsysdepartment = $arraydata[0]['sys_department_id'];
            $k=0;$arraydocprintallocation = array();$arrayserialcheck = array();$arrayserialhanding = array();$tam = "";
            $i=0;$arrayserial = array();$arrayserialdc = array();$arrayserialxp = array();
            foreach ($this->modelMapperdocprintallocation->arrayserial($idmasterprint,$idsysdepartment) as $items ) {            //
                    $serialtam = $items->getserial_recovery1();
                    $arraytam = explode("-", $serialtam);
                    for($j = (int)$arraytam[0];$j<= (int)$arraytam[1];$j++){
                        $arrayserial[$k++]=$j;
                    }
                   $arraydocprintallocation[$i++]=$items->getId();
                   $arrayserialcheck = GlobalLib::mergetwoarrays($arrayserialcheck, $this->modelMapperInfoScheduleCheck->arrayserialchecksysdepartment($idsysdepartment,$items->getId())) ;
                   $arrayserialhanding = GlobalLib::mergetwoarrays($arrayserialhanding,$this->modelMapperDocPrintHandling->arrayserial_handingsysdepartment($items->getId()));
            }
            $arrayserialxp = GlobalLib::mergetwoarrays($arrayserialcheck,$arrayserialhanding);
            $arrayserialdc = GlobalLib::arrayserialminus($arrayserial,$arrayserialxp);
            $arr[0]=(int)$arraydata[0]['defaultserial'];
            if($arr[0]!= 0){
                $arrayserialdc = GlobalLib::mergetwoarrays($arrayserialdc,$arr);
            }
            
            //tao ra combobox
            $comboHTML = GlobalLib::getcombo1('cobo_id',$arrayserialdc,$arr[0]);
            echo json_encode($comboHTML);
            exit();
        }
    }
 //mang lay ra danh sach serial_allocation
    public function arrayserialcheckkAction(){
        $this->_helper->layout->disableLayout();
        if($this->getRequest()->isPost()){ 
//            $idmasterprint = $this->_getParam("idmaster","4");
//            $idsysdepartment = $this->_getParam("idsys","17");
            $arraydata = $_POST['data'];
            $idmasterprint =  $arraydata[0]['master_print_id'];
            $idsysdepartment = $arraydata[0]['sys_department_id'];
            $stringserialtam = $arraydata[0]['arrayserialtam'];
            $arrayserialtam = explode(",", $stringserialtam);
            $k=0;$arraydocprintallocation = array();$arrayserialcheck = array();$arrayserialhanding = array();$tam = "";
            $i=0;$arrayserial = array();$arrayserialdc = array();$arrayserialxp = array();
            foreach ($this->modelMapperdocprintallocation->arrayserial($idmasterprint,$idsysdepartment) as $items ) {            //
                    $serialtam = $items->getserial_recovery1();
                    $arraytam = explode("-", $serialtam);
                    for($j = (int)$arraytam[0];$j<= (int)$arraytam[1];$j++){
                        $arrayserial[$k++]=$j;
                    }
                   $arraydocprintallocation[$i++]=$items->getId();
                   $arrayserialcheck = GlobalLib::mergetwoarrays($arrayserialcheck, $this->modelMapperInfoScheduleCheck->arrayserialchecksysdepartment($idsysdepartment,$items->getId())) ;
                   $arrayserialhanding = GlobalLib::mergetwoarrays($arrayserialhanding,$this->modelMapperDocPrintHandling->arrayserial_handingsysdepartment($items->getId()));
            }
            $arrayserialxp = GlobalLib::mergetwoarrays($arrayserialcheck,$arrayserialhanding);
            //nhap array serial tren mang tam cua list danh sach su phat
            if(count($arrayserialtam)==0){
                 $arrayserialdc = GlobalLib::arrayserialminus($arrayserial,$arrayserialxp);
            }else{
                 $arrayserialxp1 = GlobalLib::mergetwoarrays($arrayserialxp,$arrayserialtam);
                $arrayserialdc = GlobalLib::arrayserialminus($arrayserial,$arrayserialxp1);
            }
            $arr[0]=(int)$arraydata[0]['defaultserial'];
            if($arr[0]!= 0){
                $arrayserialdc = GlobalLib::mergetwoarrays($arrayserialdc,$arr);
            }
            
            //tao ra combobox
//            $comboHTML = GlobalLib::getcombo1('cobo_id',$arrayserialdc,$arr[0]);
            echo json_encode($arrayserialdc);
            exit();
        }
    }



    //ham list serial theo ma phong ban va ma an chi
    public function secviceserialdepartmentmasterprintAction(){
        
            $sys_department_id = $this->_getParam("id","");
            foreach ($this->modelMapperdocprintallocation->fetchAlll11("select * from doc_print_allocation where  sys_department_id ='$sys_department_id' and  is_delete = '0' "
                                                                        . "and  status='DOING'") as $values1) {
                $doc_print_create_id = $values1->getDoc_Print_Create_Id();
                $doc_print_allocation_id = $values1->getId();
                $arrayseriallist = array();
                $i=0;
                $arrayHandling = $this->modelMapperdocprintallocation->fetchAllSerialDepartmentPrintId(" select serial_handing from doc_print_handling where 
                                                                        doc_print_allocation_id =$doc_print_allocation_id and is_delete ='0'");
                foreach ($this->modelMapperdocprintallocation->fetchAllSerialDepartmentPrintId("
                                                                        select * from doc_print_create where 
                                                                        id =$doc_print_create_id and is_delete ='0'") as $value) {
                   $name_print  = GlobalLib::getName('master_print', $value->master_print_id, 'name');
                    $serial = "";
                    if($value->status == "RECOVERY")    
                    {
                        $serial = $value->serial_recovery;
                    }
                    else
                    {
                        $serial = $value->serial;
                    }
                    $array =  GlobalLib::subtractSerial($serial,$arrayHandling);
                    for($j=0;$j<count($array);$j++){
                            $menber[]=array(
                                'master_print_id'=>$value->master_print_id,
                                'name_print'=>  $name_print,
                                'print_allocation_id'=> $values1->getId(),
                                'serial'=> $array[$j]
                            );
                    }
                }
                
                }
            echo json_encode($menber);
            exit();
         
    }
  
    public function service1Action(){
        $this->_helper->layout->disableLayout();
//        $type_business= $this->_getParam("type_business","");
//        $type_business='DoanhNghiep';
        foreach ($this->modelMapper->fetchAll1() as $items ) {
            $menber[]=array(
               'id' => $items->getId(),
                'info_business_id_id'=>$items->getInfo_Business_Id(),
                'info_business_id'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'name'),
                'address_business'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'address_office'),
//                'master_violation_id'=> GlobalLib::getName('master_violation',$items->getMaster_Violation_Id(),'name'),
//                'master_sanction_id'=>GlobalLib::getName('master_sanction',$items->getMaster_Sanctions_Id(),'name'),
                'doc_items_handling'=>  GlobalLib::getName('master_items',GlobalLib::getName('doc_items_handling',$items->getId(),'master_items_id'),'name'),
//                'master_department_id'=>GlobalLib::getName('sys_department',$items->getMaster_Department_Id(),'name'),
                'sys_user_id'=>$items->getSys_User_Id(),
                'date_violation'=>$items->getDate_Violation(),
//                'amount'=>$items->getAmount(),
                'created_date'=>$items->getCreated_Date(),
                'created_by'=>$items->getCreated_By(),
                'modified_date'=>$items->getModified_Date(),
                'modified_by'=>$items->getModified_By(),
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus(),
                'comment'=>$items->getComment()
                //'is_delete'=>$items->getIs_Delete()      
            );
        }
        echo json_encode($menber);
        exit();
      
    } 
    public function listfromprintrecordsAction(){       
        $id= $this->_getParam("id","");
        $month= $this->_getParam("month","");
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->view->id=$id;
        $this->view->month=$month;
    }    
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        $type_business= $this->_getParam("type_business","");   
        $id= $this->_getParam("id","");
        $month= $this->_getParam("month","");     
        $year = $this->_getParam("year","");
        $menber = array();
        foreach ($this->modelMapper->fetchAll($type_business,$id,$month,$year) as $items ){
            $menber[]=array(
                'id' => $items->getId(),
                'info_business_id'=> $items->getInfo_Business_Id(),
                'info_business_name'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'name'),
                'address_business'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'address_office'),
                'master_violation_id'=> GlobalLib::getName('master_violation',$items->getMaster_Violation_Id(),'name'),
                'master_sanction_id'=>GlobalLib::getName('master_sanction',$items->getMaster_Sanctions_Id(),'name'),
                'doc_items_handling'=>  GlobalLib::getName('master_items',GlobalLib::getName('doc_items_handling',$items->getId(),'master_items_id'),'name'),
                'sys_department_id'=>GlobalLib::getName('sys_department',$items->getSys_Department_Id(),'name'),
                'sys_user_id'=>$items->getSys_User_Id(),
                'date_violation'=>$items->getDate_Violation(),
                'amount'=>$items->getAmount(),
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
    public function servicefrominfobusinessAction(){
        $this->_helper->layout->disableLayout();
        $id= $this->_getParam("id","");  
        foreach ($this->modelMapper->fetchAllfrominfobusiness($id) as $items ){
            $menber[]=array(
                'id' => $items->getId(),
                'info_business_id'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'name'),
                'address_business'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'address_office'),
                'master_violation_id'=> GlobalLib::getName('master_violation',$items->getMaster_Violation_Id(),'name'),
                'master_sanction_id'=>GlobalLib::getName('master_sanction',$items->getMaster_Sanctions_Id(),'name'),
                'doc_items_handling'=>  GlobalLib::getName('master_items',GlobalLib::getName('doc_items_handling',$items->getId(),'master_items_id'),'name'),
                'sys_department_id'=>GlobalLib::getName('sys_department',$items->getSys_Department_Id(),'name'),
                'sys_user_id'=>$items->getSys_User_Id(),
                'date_violation'=>$items->getDate_Violation(),
                'amount'=>$items->getAmount(),
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

    public function serviceprintrecordsAction(){
        $this->_helper->layout->disableLayout();
        $id= $this->_getParam("id","");
        $month= $this->_getParam("month","");
        foreach ($this->modelMapper->fetchAllprintrecords($id,$month) as $items ) {
            $menber[]=array(
                'id' => $items->getId(),
                'info_business_id'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'name'),
                'address_business'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'address_office'),
                'master_violation_id'=> GlobalLib::getName('master_violation',$items->getMaster_Violation_Id(),'name'),
                'master_sanction_id'=>GlobalLib::getName('master_sanction',$items->getMaster_Sanctions_Id(),'name'),
                'doc_items_handling'=>  GlobalLib::getName('master_items',GlobalLib::getName('doc_items_handling',$items->getId(),'master_items_id'),'name'),
                'sys_department_id'=>GlobalLib::getName('sys_department',$items->getSys_Department_Id(),'name'),
                'sys_user_id'=>$items->getSys_User_Id(),
                'date_violation'=>$items->getDate_Violation(),
                'amount'=>$items->getAmount(),
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
     public function serviceinfoschedulecheckAction(){
        $this->_helper->layout->disableLayout();
        $id= $this->_getParam("id","");
        foreach ($this->modelMapper->fetchAllinfoschedulecheck($id) as $items ) {
            $menber[]=array(
                'id' => $items->getId(),
                'info_business_id'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'name'),
                'address_business'=> GlobalLib::getName('info_business',$items->getInfo_Business_Id(),'address_office'),
                'master_violation_id'=> GlobalLib::getName('master_violation',$items->getMaster_Violation_Id(),'name'),
                'master_sanction_id'=>GlobalLib::getName('master_sanction',$items->getMaster_Sanctions_Id(),'name'),
                'doc_items_handling'=>  GlobalLib::getName('master_items',GlobalLib::getName('doc_items_handling',$items->getId(),'master_items_id'),'name'),
                'sys_department_id'=>GlobalLib::getName('sys_department',$items->getSys_Department_Id(),'name'),
                'sys_user_id'=>$items->getSys_User_Id(),
                'date_violation'=>$items->getDate_Violation(),
                'amount'=>$items->getAmount(),
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
     public function servicerecordsmanagementAction(){
        $this->_helper->layout->disableLayout();
        $type_business= $this->_getParam("type_business","");
        $year = $this->_getParam("year","");
        $menber = array();
        foreach ($this->modelMapper->fetchAllrecordsmanagement($type_business,$year) as $items ) { 
            $menber[]=array(
                'id' => $items->getId(),
                'month'=> $items->getDate_violation(),            
                'sys_department_id'=>$items->getSys_Department_Id()                
                
            );
         }
            
        echo json_encode($menber);
        exit();
      
    } 
    public function servicerecordsmanagementgroupAction(){
        $this->_helper->layout->disableLayout();
        $type_business= $this->_getParam("type_business","");
        $year = $this->_getParam("year","");
        $menber = array();
        foreach ($this->modelMapper->fetchAllrecordsmanagementgroup($type_business,$year) as $items ) { 
            $menber[]=array(
                'id' => $items->getId(),
                'month'=> $items->getDate_violation(),            
                'sys_department_id'=>$items->getSys_Department_Id(),
                'name_department'=>  GlobalLib::getName("sys_department",$items->getSys_Department_Id(),"name")
                
            );
         }
            
        echo json_encode($menber);
        exit();
      
    } 
      public function servicecomboboxAction(){
      $this->_helper->layout->disableLayout();
      //foreach ($this->modelMapper->fetchAll() as $items ) {
        $type = $this->_getParam("type","");
        
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list";
        if(empty($type)){
            $this->_redirect($redirectUrl);
        }
        if($type == 'business')
        {
            $typeBusiness = $this->_getParam("type_business","");
            $where = "";
            if(!empty($typeBusiness))
            {
                $where = "WHERE type_business = '".$typeBusiness."'";
            }
            foreach ($this->modelMapper->fetchAllInfoBusiness($where) as $items ) {
                 $menber[]=array(
                    'business_id' => $items->getId(),
                    'info_business_name' => $items->getName(),
                    'address_office' => $items->getAddress_Office()
                );
            }
        }
        else if($type == 'violation')
        {
            foreach ($this->modelMapper->fetchAllMasterViolation() as $items ) {
               $menber[]=array(
                   'violation_id' => $items->getId(),
                  'violation_name' => $items->getName()
               );
            }
        }
        else if($type == 'sanction')
        {
            foreach ($this->modelMapper->fetchAllMasterSanction("WHERE type = '".GlobalLib::_XLVP."'") as $items ) {
               $menber[]=array(
                  'sanction_id' => $items->getId(),
                  'sanction_name' => $items->getName()
               );
            }
        }
        else if($type == 'print')
        {
            foreach ($this->modelMapper->fetchAllMasterPrint() as $items ) {
               $menber[]=array(
                  'print_id' => $items->getId(),
                  'print_name' => $items->getName()
               );
            }
        }
        else if($type == 'unit')
        {
            foreach ($this->modelMapper->fetchAllMasterUnit() as $items ) {
               $menber[]=array(
                  'unit_id' => $items->getId(),
                  'unit_name' => $items->getName()
               );
            }
        }
        else if($type == 'items')
        {
            foreach ($this->modelMapper->fetchAllMasterItems() as $items ) {
               $menber[]=array(
                  'items_id' => $items->getId(),
                  'items_name' => $items->getName()
               );
            }
        }
        
            echo json_encode($menber);
            exit();
      
    } 
    //List danh sach thu hoi an chi
    public function serviceprintunusedAction(){
        $this->_helper->layout->disableLayout();
        $ided = $this->_getParam("id","");
        $select ="";
        $select11 ="select distinct doc_print_create_id from doc_print_allocation where doc_print_create_id='$ided' and  is_delete = '0' and id not in (select doc_print_allocation_id from doc_print_handling where is_delete='0')";
        $select12 ="select distinct doc_print_create_id from doc_print_allocation where is_delete = '0' and id not in (select doc_print_allocation_id from doc_print_handling where is_delete='0')";
        if($ided == 0){
            $select = $select12;
        }  else {
            $select = $select11;
        }
        //"select distinct doc_print_create_id from doc_print_allocation where doc_print_create_id='$ided' and  is_delete = '0' and id not in (select doc_print_allocation_id from doc_print_handling where is_delete='0')"
        foreach ($this->modelMapper->fetchAlll11($select) as $value ) {
            $doc_print_create_id = $value->getDoc_Print_Create_Id();
            $flag = "";$t="";$arrayseriallist = array();$i=0;$dem=0;$j=1;$co=false;
            $arrayseriallist1 = array();
            $dem = $this->modelMapper->fetchAllCount1($doc_print_create_id);
            $min = $this->modelMapper->fetchAllMin1($doc_print_create_id);
            $flag = $min-1;
            foreach ($this->modelMapper->fetchAlll("select * from doc_print_allocation where doc_print_create_id ='$doc_print_create_id' and is_delete = '0' and id not in (select doc_print_allocation_id from doc_print_handling where is_delete='0')") as $items ) {
                $tam = $items->getSerial_Allocation(); 
                $arrayseriallist[$i++]=$tam;
                $arrayseriallist1[0]=$min;
                if($dem ==1){
                    $arrayseriallist1[0]=$tam;
                }elseif($tam == ($flag+1)){
                    $flag = $tam;
                    if($i == $dem){
                        $flag = $tam;
                        $arrayseriallist1[$j++]="-";
                        $arrayseriallist1[$j++]=$tam;
                    }
                    $co = true;
                }elseif ($tam > ($flag+1)) {
                    if($i == $dem){
                        $flag = $tam;
                        $arrayseriallist1[$j++]=",";
                        $arrayseriallist1[$j++]=$tam;
                        $co = false;
                    }else
                        if($co == true){
                        $arrayseriallist1[$j++]="-";
                        $arrayseriallist1[$j++]=$flag; 
                        $arrayseriallist1[$j++]=",";
                        $arrayseriallist1[$j++]=$tam;
                        $flag = $tam;$co = false;
                    }else {
                        $arrayseriallist1[$j++]=",";
                        $arrayseriallist1[$j++]=$tam;
                        $flag = $tam;
                    }
                }               
                
            }
            //cho ra ket qua 
            $st = implode('', $arrayseriallist1);
//            echo json_encode($st);
//            exit();
            $menber[]=array(
                    'Id'=>$items->getId(),
                    'doc_print_create_id'=>$items->getDoc_Print_Create_Id(),
                    'serial_allocation'=>$st,
                    'serial_recovery'=>""
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
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docprintcreate/list";               
        $this->modelMapper->deleteDoc_Print_Create($id);
        $this->_redirect($redirectUrl);
    }  
    public function secvicesavehandlingAction()
    {
        try {
            $data=  $_POST['data'];
            $department=  $_POST['department'];
            $user=  $_POST['user'];
            $dateViolation=  GlobalLib::toMysqlDateString($_POST['date']);
            for($i = 0;$i < count($data);$i++ )
            {
               $info_business_id = $data[$i]['info_business_id'];
               $info_schedule_check = $data[$i]['info_schedule_check'];
               $array_print_handling = $data[$i]['array_print_handling'];
               if(empty($info_business_id))
               {
                   //throw new Exception("Không có thông tin doanh nghiêp ở dòng thứ ".$i);
                   continue;
               }
               if(empty($array_print_handling))
               {
                    //throw new Exception("Không có thông tin ấn chỉ ở dòng thứ ".$i);
                   continue;
               }
               $sanction_id = $data[$i]['sanction_id'];
               if(empty($sanction_id))
               {
                   $sanction_id = null;
                    //throw new Exception("Không thông tin hình thức xử lý ở dòng thứ ".$i);
               }
               
               $violation_id = $data[$i]['violation_id'];
                if(empty($violation_id))
                {
                   $violation_id = null;
                    // throw new Exception("Không có thông tin hành vi vi phạm ở dòng thứ ".$i);
                }
               $amount = $data[$i]['amount'];
               $this->model= new Model_Doc_Violations_Handling(); 
               $this->model->setInfo_Business_Id($info_business_id);
               $this->model->setMaster_Violation_Id($violation_id);
               $this->model->setMaster_Sanctions_Id($sanction_id);
               $this->model->setDate_violation($dateViolation);
               $this->model->setAmount($amount);
               $identity = Zend_Auth::getInstance()->getIdentity();
               
                    $this->model->setSys_Department_Id($department);
                    $this->model->setSys_User_Id($user);
            

               $this->model->setCreated_Date(date("Y/m/d H:i:s"));
               $this->model->setCreated_By(GlobalLib::getLoginId());
               $this->model->setModified_Date(date("Y/m/d H:i:s"));
               $this->model->setModified_By(GlobalLib::getLoginId());
               //$this->model->setIs_Delete(0);
               $this->modelMapper->save($this->model);
               $idDocViolationsHandling = $this->model->getId();
               //info_schedule_check cap nhat id_doc_violationshandling
               $this->modelMapperInfoScheduleCheck->updateInfo_Schedule_Check($info_schedule_check,$idDocViolationsHandling);
               
               for($f = 0;$f < count($array_print_handling);$f++ )
               {
                    $master_print_id = $array_print_handling[$f]['master_print_id'];
                    $print_allocation_id = $array_print_handling[$f]['print_allocation_id'];
                      $serial = $array_print_handling[$f]['serialname'];
                    
                    if(empty($print_allocation_id) || empty($master_print_id))
                    {
                        continue;
                    }
                    $this->modelDocPrintHandling = new Model_Doc_Print_Handling();
                     $this->modelDocPrintHandling->setMaster_Print_Id($master_print_id);
                    $this->modelDocPrintHandling->setDoc_Print_Allocation_Id($print_allocation_id);
                    $this->modelDocPrintHandling->setDoc_Violations_Handling_Id($idDocViolationsHandling);    
                    $this->modelDocPrintHandling->setDoc_Violations_Handling_Id($idDocViolationsHandling);   
                    $this->modelDocPrintHandling->setSerial_Handing($serial);
                            
                    $this->modelDocPrintHandling->setCreated_Date(date("Y/m/d H:i:s"));
                    $this->modelDocPrintHandling->setCreated_By(GlobalLib::getLoginId());
                    $this->modelDocPrintHandling->setModified_Date(date("Y/m/d H:i:s"));
                    $this->modelDocPrintHandling->setModified_By(GlobalLib::getLoginId());    

                    $this->modelMapperDocPrintHandling->save($this->modelDocPrintHandling);
               }
               
               $array_items_handling = $data[$i]['array_items_handling'];
               if(!empty($array_items_handling))
               {
                   for($e = 0;$e < count($array_items_handling);$e++ )
                   {
                    $master_items_id = $array_items_handling[$e]['master_items_id'];
                    if(empty($master_items_id))
                    {
                        continue;
                    }
                    $serial_handling = $array_items_handling[$e]['serial_handling'];
                    $quantity_commodity = $array_items_handling[$e]['quantity_commodity'];
                    $master_unit_id = $array_items_handling[$e]['master_unit_id'];
                    if(empty($master_unit_id))
                    {
                        $master_unit_id = null;
                    }
                    
                    $master_sanction_id = $array_items_handling[$e]['master_sanction_id'];
                     if(empty($master_sanction_id))
                    {
                        $master_sanction_id = null;
                    }
                    
                    $date_handling = $array_items_handling[$e]['date_handling'];
                    $date = GlobalLib::toMysqlDateString($date_handling);
                    $amountItem = $array_items_handling[$e]['amountItem'];

                    $this->modelDocItemsHandling = new Model_Doc_Items_Handling();
                    $this->modelDocItemsHandling->setMaster_Items_Id($master_items_id); 
                    $this->modelDocItemsHandling->setMaster_Sanction_Id($master_sanction_id);
                    $this->modelDocItemsHandling->setDoc_Violations_Handling_id($idDocViolationsHandling); 
                    $this->modelDocItemsHandling->setSerial_Handling($serial_handling);
                    $this->modelDocItemsHandling->setQuantity_Commodity($quantity_commodity); 
                    $this->modelDocItemsHandling->setMaster_Unit_Id($master_unit_id);
                    $this->modelDocItemsHandling->setDate_Handling($date);
                    $this->modelDocItemsHandling->setAmount($amountItem); 
                    //$this->modelDocItemsHandling->setFile_Upload($row->file_upload);
                    $this->modelDocItemsHandling->setStatus(GlobalLib::getName('master_sanction', $master_sanction_id, 'code'));
                    $this->modelDocItemsHandling->setCreated_Date(date("Y/m/d H:i:s"));
                    $this->modelDocItemsHandling->setCreated_By(GlobalLib::getLoginId());
                    $this->modelDocItemsHandling->setModified_Date(date("Y/m/d H:i:s"));
                    $this->modelDocItemsHandling->setModified_By(GlobalLib::getLoginId());              
                    //$this->modelDocItemsHandling->setOrder($row->order);
                    //$this->modelDocItemsHandling->setStatus($row->status);
                    //$this->modelDocItemsHandling->setComment($row->comment);
                    //$this->modelDocItemsHandling->setIs_Delete($row->is_delete);
                    $this->modelMapperDocItemsHandling->save($this->modelDocItemsHandling);
                   }
               }
                   
               
            }
             $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/list";
             $member[]=array(
                     'code'=>0,
                     'message'=>$redirectUrl,
                     'value'=>''
                         ); 
        } catch (Exception $e) {
             $member[]=array(
                     'code'=>1,
                     'message'=>$e->getMessage(),
                     'value'=>''
                         ); 
            
             
        } 
          echo json_encode($member);
          exit();
         
    }
    public function getaddressbusinessAction(){
        $id_business= $this->_getParam("id_business","");
//        $redirectUrl=$this->aConfig["site"]["url"]."admin/docprintcreate/list";               
        $address = $this->modelMapper->getAddressbusiness($id_business);
        echo json_encode($address);
        exit();
    }    
    public function getdocprinthandingAction()
    {
        $doc_violation_handing_id = $this->_getParam("doc_violation_handing_id","");
        $this->_helper->layout->disableLayout();              
        $result = null;
        try
        {
            $result = $this->modelMapperDocPrintHandling->findbydoc_violation_handing_id($doc_violation_handing_id);
        } catch (Exception $ex) {

        }
        if($result!=null)
            echo json_encode ($result);
        else 
            echo 0;
        exit();
    }
    public function getdocitemhandingAction()
    {
        $doc_violation_handing_id = $this->_getParam("doc_violation_handing_id","");
        $this->_helper->layout->disableLayout();         
        $result = null;
        try
        {
            $result = $this->modelMapperDocItemsHandling->finditembyViolationHandling($doc_violation_handing_id);
        } catch (Exception $ex) {

        }
        
        if($result!=null)
            echo json_encode ($result);
        else 
            echo 0;
        exit();        
    }
    public function serviceallresultAction(){
        $this->_helper->layout->disableLayout();
        $string = $this->modelMapper->fetchAllresult(1,2015);
//        foreach ($this->modelMapper->fetchAllresult() as $items ) {
//            $menber[]=array(
//              'LCVH'=> $items->sums,
//          
//               
//            );
//        }
        echo json_encode($string);
        exit();
      
    } 
    public function serviceresultAction(){
        $this->_helper->layout->disableLayout();
  //      $string = $this->modelMapper->fetchresult(2,2015);
        foreach ($this->modelMapper->fetchresult(2,2015) as $items ) {
            $menber[]=array(
              'LCVH'=> $items->sums,
          
               
            );
        }
        echo json_encode($string);
        exit();
      
    } 
      public function exportcheckAction() {
          if($this->getRequest()->isPost()){  
            $redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/list";
            $quy = $_POST["quy"];
            $year = $_POST["year"];
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 14;
            $stt=1;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");
            $objPHPExcel->getActiveSheet()->setCellValue('T1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('T1:W1');
            $objPHPExcel->getActiveSheet()->setCellValue('U2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('U2:W2');			
            $objPHPExcel->getActiveSheet()->getStyle("T1:W1")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->getStyle("U2:W2")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->setCellValue('L4', "KẾT QUẢ KIỂM TRA,XỬ LÝ QUÝ ".$quy." NĂM");$objPHPExcel->getActiveSheet()->mergeCells('L4:Q4');
            $objPHPExcel->getActiveSheet()->getStyle("L4:Q4")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('L5', "Kèm theo Báo cáo số:   /BC-QLTT ngày,     tháng,   năm");$objPHPExcel->getActiveSheet()->mergeCells('L5:Q5');
            $objPHPExcel->getActiveSheet()->setCellValue('O6', "Đơn vị tính");$objPHPExcel->getActiveSheet()->mergeCells('O6:Q6');
            
           
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A11', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A11:A13');
             $objPHPExcel->getActiveSheet()->getStyle("A11:A13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A11:A13")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('B11', "Đội QLTT số...");$objPHPExcel->getActiveSheet()->mergeCells('B11:C13');
             $objPHPExcel->getActiveSheet()->getStyle("B11:C13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("B11:C13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('D11', "Đơn vị tính");$objPHPExcel->getActiveSheet()->mergeCells('D11:D13');
             $objPHPExcel->getActiveSheet()->getStyle("D11:D13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("D11:D13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('E11', "Tổng số vụ kiểm tra/xử lý/thu phạt VPHC");$objPHPExcel->getActiveSheet()->mergeCells('E11:E13');
             $objPHPExcel->getActiveSheet()->getStyle("E11:E13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("E11:E13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('F11', "Hàng cấm");$objPHPExcel->getActiveSheet()->mergeCells('F11:F13');
             $objPHPExcel->getActiveSheet()->getStyle("F11:F13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("F11:F13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('G11', "Hàng nhập lậu");$objPHPExcel->getActiveSheet()->mergeCells('G11:G13');
             $objPHPExcel->getActiveSheet()->getStyle("G11:G13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("G11:G13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('H11', "Gian lận thương mại");$objPHPExcel->getActiveSheet()->mergeCells('H11:K11');
             $objPHPExcel->getActiveSheet()->getStyle("H11:K11")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("H11:K11")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('H12', "Lĩnh vực giá");$objPHPExcel->getActiveSheet()->mergeCells('H12:H13');
             $objPHPExcel->getActiveSheet()->getStyle("H12:H13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("H12:H13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('I12', "Đo lường");$objPHPExcel->getActiveSheet()->mergeCells('I12:I13');
             $objPHPExcel->getActiveSheet()->getStyle("I12:I13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("I12:I13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('J12', "Chất lượng");$objPHPExcel->getActiveSheet()->mergeCells('J12:J13');
             $objPHPExcel->getActiveSheet()->getStyle("J12:J13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("J12:J13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('K12', "Vi phạm khác");$objPHPExcel->getActiveSheet()->mergeCells('K12:K13');
             $objPHPExcel->getActiveSheet()->getStyle("K12:K13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("K12:K13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('L11', "Vi phạm quyền SHTT và bảng giá");$objPHPExcel->getActiveSheet()->mergeCells('L11:Q11');
             $objPHPExcel->getActiveSheet()->getStyle("L11:Q11")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("L11:Q11")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('L12', "Nguồn gốc xuất xứ");$objPHPExcel->getActiveSheet()->mergeCells('L12:L13');
             $objPHPExcel->getActiveSheet()->getStyle("L12:L13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("L12:L13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('M12', "Nhãn hiệu HH");$objPHPExcel->getActiveSheet()->mergeCells('M12:M13');
             $objPHPExcel->getActiveSheet()->getStyle("M12:M13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("M12:M13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('N12', "Kiểu dáng CN");$objPHPExcel->getActiveSheet()->mergeCells('N12:N13');
             $objPHPExcel->getActiveSheet()->getStyle("N12:N13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("N12:N13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('O12', "Chỉ dẫn địa lý");$objPHPExcel->getActiveSheet()->mergeCells('O12:O13');
             $objPHPExcel->getActiveSheet()->getStyle("O12:O13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("O12:O13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('P12', "Chất lượng,Công dụng");$objPHPExcel->getActiveSheet()->mergeCells('P12:P13');
             $objPHPExcel->getActiveSheet()->getStyle("P12:P13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("P12:P13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('Q12', "Tem nhãn,bao bì");$objPHPExcel->getActiveSheet()->mergeCells('Q12:Q13');
             $objPHPExcel->getActiveSheet()->getStyle("Q12:Q13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("Q12:Q13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('R11', "Vi phạm trong kinh doanh");$objPHPExcel->getActiveSheet()->mergeCells('R11:U11');
             $objPHPExcel->getActiveSheet()->getStyle("R11:U11")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("R11:U11")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('R12', "ĐKKD,HCKD,KDCĐK");$objPHPExcel->getActiveSheet()->mergeCells('R12:R13');
             $objPHPExcel->getActiveSheet()->getStyle("R12:R13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("R12:R13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('S12', "Quy định ghi nhãn HH");$objPHPExcel->getActiveSheet()->mergeCells('S12:S13');
             $objPHPExcel->getActiveSheet()->getStyle("S12:S13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("S12:S13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('T12', "Đầu cơ,găm hàng");$objPHPExcel->getActiveSheet()->mergeCells('T12:T13');
             $objPHPExcel->getActiveSheet()->getStyle("T12:T13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("T12:T13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('U12', "Vi phạm khác");$objPHPExcel->getActiveSheet()->mergeCells('U12:U13');
             $objPHPExcel->getActiveSheet()->getStyle("U12:U13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("U12:U13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('V11', "Phạt và truy thu thuế");$objPHPExcel->getActiveSheet()->mergeCells('V11:V13');
             $objPHPExcel->getActiveSheet()->getStyle("V11:V13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("V11:V13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('W11', "Bán hàng tịch thu");$objPHPExcel->getActiveSheet()->mergeCells('W11:W13');
             $objPHPExcel->getActiveSheet()->getStyle("W11:W13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("W11:W13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('X11', "Phối hợp KTLN");$objPHPExcel->getActiveSheet()->mergeCells('X11:X13');
             $objPHPExcel->getActiveSheet()->getStyle("X11:X13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("X11:X13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
             $count = 15;
             $i=1;
              $objPHPExcel->getActiveSheet()->setCellValue('A14', "A");
              $objPHPExcel->getActiveSheet()->setCellValue('B14', "B");$objPHPExcel->getActiveSheet()->mergeCells('B14:C14');
              $objPHPExcel->getActiveSheet()->setCellValue('D14', "C");
              $objPHPExcel->getActiveSheet()->setCellValue('E14', "1");
              $objPHPExcel->getActiveSheet()->setCellValue('F14', "2");
              $objPHPExcel->getActiveSheet()->setCellValue('G14', "3");
              $objPHPExcel->getActiveSheet()->setCellValue('H14', "4");
              $objPHPExcel->getActiveSheet()->setCellValue('I14', "5");
              $objPHPExcel->getActiveSheet()->setCellValue('J14', "6");
              $objPHPExcel->getActiveSheet()->setCellValue('K14', "7");
              $objPHPExcel->getActiveSheet()->setCellValue('L14', "8");
              $objPHPExcel->getActiveSheet()->setCellValue('M14', "9");
              $objPHPExcel->getActiveSheet()->setCellValue('N14', "10");
              $objPHPExcel->getActiveSheet()->setCellValue('O14', "11");
              $objPHPExcel->getActiveSheet()->setCellValue('P14', "12");
              $objPHPExcel->getActiveSheet()->setCellValue('Q14', "13");
              $objPHPExcel->getActiveSheet()->setCellValue('R14', "14");
              $objPHPExcel->getActiveSheet()->setCellValue('S14', "15");
              $objPHPExcel->getActiveSheet()->setCellValue('T14', "16");
              $objPHPExcel->getActiveSheet()->setCellValue('U14', "17");
              $objPHPExcel->getActiveSheet()->setCellValue('V14', "18");
              $objPHPExcel->getActiveSheet()->setCellValue('W14', "19");
              $objPHPExcel->getActiveSheet()->setCellValue('X14', "20");
            
 //            $rowCount = 15;
                       
             foreach ($this->modelMapper->fetchresult($quy,$year) as $value){
                    $value0=$value[0];
                    $value1=$value[1];
                   $objPHPExcel->getActiveSheet()->setCellValue('A' . $count, $i);$objPHPExcel->getActiveSheet()->mergeCells('A'.$count.':A'.($count+1));
                   $objPHPExcel->getActiveSheet()->setCellValue('B' . $count, $value0["department"]);$objPHPExcel->getActiveSheet()->mergeCells('B'.$count.':C'.($count+1));
                   $objPHPExcel->getActiveSheet()->setCellValue('D' . $count, "Vụ");
                   $objPHPExcel->getActiveSheet()->setCellValue('E' . $count, $value0["result"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('F' . $count, $value0["HC"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('G' . $count, $value0["HNL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('H' . $count, $value0["LVG"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('I' . $count, $value0["ĐL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('J' . $count, $value0["CL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('K' . $count, $value0["VPK1"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('L' . $count, $value0["NGXX"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('M' . $count, $value0["NHHH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('N' . $count, $value0["KDCN"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('O' . $count, $value0["CDĐL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('P' . $count, $value0["CLCD"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('Q' . $count, $value0["Tem"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('R' . $count, $value0["ĐKKD"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('S' . $count, $value0["QĐGNHH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('T' . $count, $value0["ĐCGH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('U' . $count, $value0["VPK2"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('V' . $count, $value0["VSATTP"]);
                   $count++;    
                   $objPHPExcel->getActiveSheet()->setCellValue('D' . $count, "Tiền");
                   $objPHPExcel->getActiveSheet()->setCellValue('E' . $count, $value1["result"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('F' . $count, $value1["HC"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('G' . $count, $value1["HNL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('H' . $count, $value1["LVG"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('I' . $count, $value1["ĐL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('J' . $count, $value1["CL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('K' . $count, $value1["VPK1"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('L' . $count, $value1["NGXX"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('M' . $count, $value1["NHHH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('N' . $count, $value1["KDCN"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('O' . $count, $value1["CDĐL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('P' . $count, $value1["CLCD"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('Q' . $count, $value1["Tem"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('R' . $count, $value1["ĐKKD"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('S' . $count, $value1["QĐGNHH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('T' . $count, $value1["ĐCGH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('U' . $count, $value1["VPK2"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('V' . $count, $value1["VSATTP"]);
                   $count++;
                   $i++;
                   }
                   $objPHPExcel->getActiveSheet()->setCellValue('A' . $count, $i);$objPHPExcel->getActiveSheet()->mergeCells('A'.$count.':A'.($count+1));
                   $objPHPExcel->getActiveSheet()->setCellValue('B' . $count, "Tổng cộng");$objPHPExcel->getActiveSheet()->mergeCells('B'.$count.':C'.($count+1));
                   $objPHPExcel->getActiveSheet()->setCellValue('D' . $count, "Vụ");   
                    $objPHPExcel->getActiveSheet()->setCellValue('D' .($count+1), "Tiền");
             foreach ($this->modelMapper->fetchresultend($quy,$year) as $value){
       
                   $objPHPExcel->getActiveSheet()->setCellValue('E' . $count, $value["results"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('F' . $count, $value["HC"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('G' . $count, $value["HNL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('H' . $count, $value["LVG"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('I' . $count, $value["ĐL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('J' . $count, $value["CL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('K' . $count, $value["VPK1"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('L' . $count, $value["NGXX"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('M' . $count, $value["NHHH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('N' . $count, $value["KDCN"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('O' . $count, $value["CDĐL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('P' . $count, $value["CLCD"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('Q' . $count, $value["Tem"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('R' . $count, $value["ĐKKD"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('S' . $count, $value["QĐGNHH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('T' . $count, $value["ĐCGH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('U' . $count, $value["VPK2"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('V' . $count, $value["VSATTP"]);
                   $count++;    
                   }      
              
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle("A1:A1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("F1:F1")->applyFromArray($styleArray);
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A3:X" .($count-1))->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('A14:X'.($count-1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            //tên file excel
            $filename='PhieuKiemTraXuLyTheoQuy'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
          }
    }  
    public function exportcheckallAction() {
          if($this->getRequest()->isPost()){  
            $redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/list";
            $quy = $_POST["quy"];
            $year = $_POST["year"];
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 14;
            $stt=1;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "SỞ CÔNG THƯƠNG BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "CHI CỤC QUẢN LÝ THỊ TRƯỜNG");
            $objPHPExcel->getActiveSheet()->setCellValue('T1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('T1:W1');
            $objPHPExcel->getActiveSheet()->setCellValue('U2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('U2:W2');			
            $objPHPExcel->getActiveSheet()->getStyle("T1:W1")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->getStyle("U2:W2")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->setCellValue('L4', "TỔNG HỢP KẾT QUẢ KIỂM TRA,XỬ LÝ QUÝ ".$quy." NĂM");$objPHPExcel->getActiveSheet()->mergeCells('L4:Q5');
            $objPHPExcel->getActiveSheet()->getStyle("L4:Q5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('L7', "Kèm theo Báo cáo số:      /BC-QLTT ngày     tháng      năm");$objPHPExcel->getActiveSheet()->mergeCells('L7:Q7');
            $objPHPExcel->getActiveSheet()->setCellValue('T8', "Đơn vị tính");$objPHPExcel->getActiveSheet()->mergeCells('T8:V8');
      
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A10', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A10:A12');
             $objPHPExcel->getActiveSheet()->getStyle("A10:A12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A10:A12")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('B10', "Nội dung");$objPHPExcel->getActiveSheet()->mergeCells('B10:E12');
             $objPHPExcel->getActiveSheet()->getStyle("B10:E12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("B10:E12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('F10', "Đơn vị tính");$objPHPExcel->getActiveSheet()->mergeCells('F10:F12');
             $objPHPExcel->getActiveSheet()->getStyle("F10:F12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("F10:F12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('G10', "Tổng số");$objPHPExcel->getActiveSheet()->mergeCells('G10:G12');
             $objPHPExcel->getActiveSheet()->getStyle("G10:G12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("G10:G12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('H10', "Hàng cấm");$objPHPExcel->getActiveSheet()->mergeCells('H10:H12');
             $objPHPExcel->getActiveSheet()->getStyle("H10:H12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("H10:H12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('I10', "Hàng nhập lậu");$objPHPExcel->getActiveSheet()->mergeCells('I10:I12');
             $objPHPExcel->getActiveSheet()->getStyle("I10:I12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("I10:I12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('J10', "Gian lận thương mại");$objPHPExcel->getActiveSheet()->mergeCells('J10:M10');
             $objPHPExcel->getActiveSheet()->getStyle("J10:M10")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("J10:M10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('J11', "Lĩnh vực giá");$objPHPExcel->getActiveSheet()->mergeCells('J11:J12');
             $objPHPExcel->getActiveSheet()->getStyle("J11:J12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("J11:J12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('K11', "Đo lường");$objPHPExcel->getActiveSheet()->mergeCells('K11:K12');
             $objPHPExcel->getActiveSheet()->getStyle("k11:k12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("k11:k12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('L11', "Chất lượng");$objPHPExcel->getActiveSheet()->mergeCells('L11:L12');
             $objPHPExcel->getActiveSheet()->getStyle("L11:L12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("L11:L12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('M11', "Vi phạm khác");$objPHPExcel->getActiveSheet()->mergeCells('M11:M12');
             $objPHPExcel->getActiveSheet()->getStyle("M11:M12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("M11:M12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('N10', "Vi phạm quyền SHTT và bảng giá");$objPHPExcel->getActiveSheet()->mergeCells('N10:S10');
             $objPHPExcel->getActiveSheet()->getStyle("N10:S10")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("N10:S10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('N11', "Nguồn gốc xuất xứ");$objPHPExcel->getActiveSheet()->mergeCells('N11:N12');
             $objPHPExcel->getActiveSheet()->getStyle("N11:N12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("N11:N12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('O11', "Nhãn hiệu HH");$objPHPExcel->getActiveSheet()->mergeCells('O11:O12');
             $objPHPExcel->getActiveSheet()->getStyle("O11:O12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("O11:O12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('P11', "Kiểu dáng CN");$objPHPExcel->getActiveSheet()->mergeCells('P11:P12');
             $objPHPExcel->getActiveSheet()->getStyle("P11:P12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("P11:P12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('Q11', "Chỉ dẫn địa lý");$objPHPExcel->getActiveSheet()->mergeCells('Q11:Q12');
             $objPHPExcel->getActiveSheet()->getStyle("Q11:Q12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("Q11:Q12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('R11', "Chất lượng,Công dụng");$objPHPExcel->getActiveSheet()->mergeCells('R11:R12');
             $objPHPExcel->getActiveSheet()->getStyle("R11:R12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("R11:R12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('S11', "Tem nhãn,bao bì");$objPHPExcel->getActiveSheet()->mergeCells('S11:S12');
             $objPHPExcel->getActiveSheet()->getStyle("S11:S12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("S11:S12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('T10', "Vi phạm trong kinh doanh");$objPHPExcel->getActiveSheet()->mergeCells('T10:X10');
             $objPHPExcel->getActiveSheet()->getStyle("T10:X10")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("T10:X10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('T11', "ĐKKD,HCKD,KDCĐK");$objPHPExcel->getActiveSheet()->mergeCells('T11:T12');
             $objPHPExcel->getActiveSheet()->getStyle("T11:T12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("T11:T12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('U11', "Quy định ghi nhãn HH");$objPHPExcel->getActiveSheet()->mergeCells('U11:U12');
             $objPHPExcel->getActiveSheet()->getStyle("U11:U12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("U11:U12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('V11', "Đầu cơ,găm hàng");$objPHPExcel->getActiveSheet()->mergeCells('V11:V12');
             $objPHPExcel->getActiveSheet()->getStyle("V11:V12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("V11:V12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('W11', "Vi phạm khác");$objPHPExcel->getActiveSheet()->mergeCells('W11:W12');
             $objPHPExcel->getActiveSheet()->getStyle("W11:W12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("W11:W12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('X11', "VSATTP,chống dịch");$objPHPExcel->getActiveSheet()->mergeCells('X11:X12');
             $objPHPExcel->getActiveSheet()->getStyle("X11:X12")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("X11:X12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
             
             $noidung = array("Số vụ kiểm tra trong kỳ","Số vụ vi phạm trong kỳ","-Số vụ xử lý trong kỳ","-Chưa xử lý chuyển kỳ sau","Không có vi phạm","Trong đó,tồn hàng(quý) trước","Số tiền QLTT thu trong kỳ","Tiền phạt hành chính","Tiền bán hàng tịch thu","Phạt và truy thu thuế","Hàng hóa tịch thu chờ bán","Hàng hóa đã bán sung quỹ NN","Hàng hóa tịch thu chờ tiêu hủy","Hàng hóa tịch thu đã tiêu hủy","Hàng hóa tịch thu đã tiêu hủy","Tổng số tiền thu nạp ngân sách","Tiền phạt hành chính","Tiền bán hàng tịch thu","Phạt và truy thu thuế","Đốc thu kỳ trước nộp kỳ này","Thu khác","Chuyển ngành khác xử lý","Trong đó: Chuyển xử lý HS","Phối hợp với các ngành");
             $count = array(15,21,22,29,30);
             for($i=0;$i<23;$i++){
                 if($i ==0)
                 {
                      
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, "I");
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $noidung[$i]);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.":C".$rowCount)->getFont()->setBold(true);
                 }
                 else if($i ==6)
                 {
                      
                       $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, "II");
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $noidung[$i]);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.":C".$rowCount)->getFont()->setBold(true);
                 }
                 else if($i ==14)
                 {
                      
                       $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, "III");
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $noidung[$i]);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.":C".$rowCount)->getFont()->setBold(true);
                 }
                 else if($i ==20)
                 {
                      
                       $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, "IV");
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $noidung[$i]);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.":C".$rowCount)->getFont()->setBold(true);
                 }
                 else
                 {
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $noidung[$i]);
                        $stt++;
                 }
                  $objPHPExcel->getActiveSheet()->mergeCells('B'. $rowCount.':E'. $rowCount);
                  $rowCount++;
             }
             
                      $objPHPExcel->getActiveSheet()->setCellValue('A13', "A");
                      $objPHPExcel->getActiveSheet()->setCellValue('B13', "B");$objPHPExcel->getActiveSheet()->mergeCells('B13:E13');
                      $objPHPExcel->getActiveSheet()->setCellValue('F13', "C");
                      $objPHPExcel->getActiveSheet()->setCellValue('G13', "1");
                      $objPHPExcel->getActiveSheet()->setCellValue('H13', "2");
                      $objPHPExcel->getActiveSheet()->setCellValue('I13', "3");
                      $objPHPExcel->getActiveSheet()->setCellValue('J13', "4");
                      $objPHPExcel->getActiveSheet()->setCellValue('K13', "5");
                      $objPHPExcel->getActiveSheet()->setCellValue('L13', "6");
                      $objPHPExcel->getActiveSheet()->setCellValue('M13', "7");
                      $objPHPExcel->getActiveSheet()->setCellValue('N13', "8");
                      $objPHPExcel->getActiveSheet()->setCellValue('O13', "9");
                      $objPHPExcel->getActiveSheet()->setCellValue('P13', "10");
                      $objPHPExcel->getActiveSheet()->setCellValue('Q13', "11");
                      $objPHPExcel->getActiveSheet()->setCellValue('R13', "12");
                      $objPHPExcel->getActiveSheet()->setCellValue('S13', "13");
                      $objPHPExcel->getActiveSheet()->setCellValue('T13', "14");
                      $objPHPExcel->getActiveSheet()->setCellValue('U13', "15");
                      $objPHPExcel->getActiveSheet()->setCellValue('V13', "16");
                      $objPHPExcel->getActiveSheet()->setCellValue('W13', "17");
                      $objPHPExcel->getActiveSheet()->setCellValue('X13', "18");
                      
                      $objPHPExcel->getActiveSheet()->setCellValue('F14', "Vụ");
                      $objPHPExcel->getActiveSheet()->setCellValue('F15', "Vụ");
                      $objPHPExcel->getActiveSheet()->setCellValue('F16', "Vụ");
                      $objPHPExcel->getActiveSheet()->setCellValue('F17', "Vụ");
                      $objPHPExcel->getActiveSheet()->setCellValue('F18', "Vụ");
                      $objPHPExcel->getActiveSheet()->setCellValue('F19', "Vụ");
                      $objPHPExcel->getActiveSheet()->setCellValue('F20', "1.000đ");
                      $objPHPExcel->getActiveSheet()->setCellValue('F28', "1.000đ");
 //            $rowCount = 15;
             $rowdown = 14;
              foreach ($this->modelMapper->fetchAllresult($quy,$year) as $value){
                   $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowdown, $value["results"]);
                   $rowdown = 20;
              }
            $j=0;
             foreach ($this->modelMapper->fetchAllresult($quy,$year) as $value){
                
                   $objPHPExcel->getActiveSheet()->setCellValue('G' . $count[$j], $value["result"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('H' . $count[$j], $value["HC"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('I' . $count[$j], $value["HNL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('J' . $count[$j], $value["LVG"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('K' . $count[$j], $value["ĐL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('L' . $count[$j], $value["CL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('M' . $count[$j], $value["VPK1"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('N' . $count[$j], $value["NGXX"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('O' . $count[$j], $value["NHHH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('P' . $count[$j], $value["KDCN"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('Q' . $count[$j], $value["CDĐL"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('R' . $count[$j], $value["CLCD"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('S' . $count[$j], $value["Tem"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('T' . $count[$j], $value["ĐKKD"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('U' . $count[$j], $value["QĐGNHH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('V' . $count[$j], $value["ĐCGH"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('W' . $count[$j], $value["VPK2"]);
                   $objPHPExcel->getActiveSheet()->setCellValue('X' . $count[$j], $value["VSATTP"]);
                  
                   $j++;                
                   }
              
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle("A1:A1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("F1:F1")->applyFromArray($styleArray);
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A3:X" . 36)->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('A13:X36')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            //tên file excel
            $filename='PhieuTongHopKetQuaKiemTraXuLy'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
          }
    } 
    public function deletevochuAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docviolationshandling/listownerlessgoods";               
        $this->modelMapperDocItemsHandling->deleteDoc_Items_Handling($id);
        $this->_redirect($redirectUrl);
    } 
}
