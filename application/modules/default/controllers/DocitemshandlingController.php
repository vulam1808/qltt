<?php
include_once APPLICATION_PATH."/models/Doc_Items_Handling.php";

class DocItemsHandlingController extends Zend_Controller_Action{
 public function init(){
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->model= new Model_Doc_Items_Handling();
        $this->modelMapper= new Model_Doc_Items_HandlingMapper();
 }
  public function editAction(){
       $id= $this->_getParam("id","");  
       $type=$this->_getParam("type","");  
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
         if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."default/docitemshandling/list";            
            if(isset($_POST["master_items_id"])){
                $this->model->setMaster_Items_Id($_POST["master_items_id"]);
            }
            if(strlen($_POST["master_sanction_id"])>0){
                $this->model->setMaster_Sanction_Id($_POST["master_sanction_id"]);
                $this->model->setStatus(GlobalLib::getName("master_sanction",$_POST["master_sanction_id"],"code"));
            }           
            if(strlen($_POST["serial_handling"])){
                $this->model->setSerial_Handling($_POST["serial_handling"]);
            }
            if(strlen($_POST["quantity_commodity"])){
                $this->model->setQuantity_Commodity($_POST["quantity_commodity"]);
            }           
            if(isset($_POST["master_unit_id"])){
                $this->model->setMaster_Unit_Id($_POST["master_unit_id"]);
            }
            if(strlen($_POST["date_handling"])>0){
                $this->model->setDate_Handling(GlobalLib::toMysqlDateString($_POST["date_handling"]));
            }
             if(isset($_POST["amount"])){
                $this->model->setAmount($_POST["amount"]);
            }
          
            $this->model->setCreated_Date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_Date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }     
        $this->view->type=$type;
        $this->view->item= $this->model;
  }
  
  public function listAction(){
       if($this->getRequest()->isPost()){
            
            if(isset($_POST["month"])){
                $this->view->month=$_POST["month"];
            }
            if(isset($_POST["year"])){
                $this->view->year=$_POST["year"];
            }       
        }
       $this->view->item=$this->model;
  }
   public function listttAction(){
       if($this->getRequest()->isPost()){
            
            if(isset($_POST["month"])){
                $this->view->month=$_POST["month"];
            }
            if(isset($_POST["year"])){
                $this->view->year=$_POST["year"];
            }       
        }
       $this->view->item=$this->model;
  }
    public function listitemreturnAction(){
        if($this->getRequest()->isPost()){

            if(isset($_POST["month"])){
                $this->view->month=$_POST["month"];
            }
            if(isset($_POST["year"])){
                $this->view->year=$_POST["year"];
            }
        }
        $this->view->item=$this->model;
    }
  public function serviceAction(){
      $status= $this->_getParam("status",""); 
      $month=$this->_getParam("month","");
      $year=$this->_getParam("year","");
      $this->_helper->layout->disableLayout();
       $identity = Zend_Auth::getInstance()->getIdentity();
        $sys_department_id = $identity->sys_department_id ;
        foreach ($this->modelMapper->fetchAll($status,$month,$year,$sys_department_id) as $items ){
        $menber[] = array(
                'id' => $items->getId(),
                'master_items_id'=> GlobalLib::getName("master_items",$items->getMaster_Items_Id(),"name"),  
                'master_sanction_id'=>  GlobalLib::getName("master_sanction",$items->getMaster_Sanction_Id(),"name"),
                'doc_violations_handling_id'=> GlobalLib::getName("info_business",GlobalLib::getName("doc_violations_handling",$items->getDoc_Violations_Handling_Id(),"info_business_id"),"name"),
                'serial_handling'=>$items->getSerial_Handling(),
                'quantity_commodity'=>$items->getQuantity_Commodity(),
                'master_unit_id'=>$items->getMaster_Unit_Id(),
                'date_handling'=>GlobalLib::viewDate($items->getDate_Handling()),
                'amount'=>$items->getAmount(),
                'file_upload'=>$items->getFile_Upload(),               
                'created_date'=>$items->getCreated_Date(),
                'created_by'=>$items->getCreated_By(),
                'modified_date'=>$items->getModified_Date(),
                'modified_by'=>$items->getModified_By(),
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus(),
                'comment'=>$items->getComment()           
                );
        }
         echo json_encode($menber);
        exit();
  }

  // lan duong
  public function servicetichthuAction(){
      $status= $this->_getParam("status",""); 
      $month=$this->_getParam("month","");
      $year=$this->_getParam("year","");
      $this->_helper->layout->disableLayout();
      $identity = Zend_Auth::getInstance()->getIdentity();
        $sys_department_id = $identity->sys_department_id ;
        foreach ($this->modelMapper->fetchAlltichthu($status,$month,$year,$sys_department_id) as $items ){
        $menber[] = array(
                'id' => $items->getId(),
                'master_items_id'=> GlobalLib::getName("master_items",$items->getMaster_Items_Id(),"name"),  
                'master_sanction_id'=>  GlobalLib::getName("master_sanction",$items->getMaster_Sanction_Id(),"name"),
                'doc_violations_handling_id'=> GlobalLib::getName("info_business",GlobalLib::getName("doc_violations_handling",$items->getDoc_Violations_Handling_Id(),"info_business_id"),"name"),
                'serial_handling'=>$items->getSerial_Handling(),
                'quantity_commodity'=>$items->getQuantity_Commodity(),
                'master_unit_id'=>$items->getMaster_Unit_Id(),
                'date_handling'=>  GlobalLib::viewDate($items->getDate_Handling()),
                'amount'=>$items->getAmount(),
                'file_upload'=>$items->getFile_Upload(),               
                'created_date'=>$items->getCreated_Date(),
                'created_by'=>$items->getCreated_By(),
                'modified_date'=>$items->getModified_Date(),
                'modified_by'=>$items->getModified_By(),
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus(),
                'comment'=>$items->getComment()           
                );
        }
         echo json_encode($menber);
        exit();
  }

    public function servicetangvattralaiAction(){
        $status= $this->_getParam("status","");
        $month=$this->_getParam("month","");
        $year=$this->_getParam("year","");
        $this->_helper->layout->disableLayout();
        $identity = Zend_Auth::getInstance()->getIdentity();
        $sys_department_id = $identity->sys_department_id ;
        foreach ($this->modelMapper->fetchAllTangVatTraLai($status,$month,$year,$sys_department_id) as $items ){
            $menber[] = array(
                'id' => $items->getId(),
                'master_items_id'=> GlobalLib::getName("master_items",$items->getMaster_Items_Id(),"name"),
                'master_sanction_id'=>  GlobalLib::getName("master_sanction",$items->getMaster_Sanction_Id(),"name"),
                'info_schedule_check_id'=> GlobalLib::getName("info_business",GlobalLib::getName("info_schedule_check",$items->getInfo_Schedule_Check_Id(),"info_business_id"),"name"),
                'serial_handling'=>$items->getSerial_Handling(),
                'quantity_commodity'=>$items->getQuantity_Commodity(),
                'master_unit_id'=>$items->getMaster_Unit_Id(),
                'date_handling'=>GlobalLib::viewDate($items->getDate_Handling()),
                'amount'=>$items->getAmount(),
                'file_upload'=>$items->getFile_Upload(),
                'created_date'=>$items->getCreated_Date(),
                'created_by'=>$items->getCreated_By(),
                'modified_date'=>$items->getModified_Date(),
                'modified_by'=>$items->getModified_By(),
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus(),
                'comment'=>$items->getComment()
            );
        }
        echo json_encode($menber);
        exit();
    }
}

