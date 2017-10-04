<?php
include APPLICATION_PATH . "/models/Info_Schedule_Check.php";
include APPLICATION_PATH ."/models/Doc_Print_Allocation.php";
include APPLICATION_PATH."/models/Doc_Print_Create.php";
include APPLICATION_PATH . "/models/Sys_User.php";
include APPLICATION_PATH . "/models/Doc_Violations_Handling.php";
include APPLICATION_PATH . "/models/Doc_Items_Handling.php";
include APPLICATION_PATH . "/models/Doc_Print_Handling.php";


class InfoScheduleCheckController extends Zend_Controller_Action{
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
        $this->modeldocviolationHandling= new Model_Doc_Violations_Handling();
        $this->modeldocviolatiohandlingMapper= new Model_Doc_Violations_HandlingMapper();
        $this->modelDocItemsHandling = new Model_Doc_Items_Handling();
        $this->modelMapperDocItemsHandling = new Model_Doc_Items_HandlingMapper();
        $this->modelDocPrintHandling = new Model_Doc_Print_Handling();
        $this->modelMapperDocPrintHandling = new Model_Doc_Print_HandlingMapper();
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

        $this->view->scheduleHTML =  GlobalLib::getCombo('info_schedule_id', 'info_schedule', 'id', 'name_schedule',0, false, 'where sys_department_id=17');
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."default/infoschedulecheck/list/";            
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
            if(isset($_POST["department"])){
                $setSysDepartmentId = $_POST["department"];
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
        $this->view->item = $this->model;
    }

    //Begin secvicesavehandlingAction - Lan Duong
    public function servicesavehandlingAction()
    {
        try {
            if($this->getRequest()->isPost()) {

                $violation_id = "";

                if(!empty($_POST['data'])) {
                    $data = $_POST['data'];
                    $violation_id = $data[0]['violation_id'];
                }

                if(isset($_POST["info_schedule_id"])){
                    $this->model->setInfo_Schedule_Id($_POST["info_schedule_id"]);
                }
                if(isset($_POST["info_business_id"])){
                    $this->model->setInfo_Business_Id($_POST["info_business_id"]);
                }

                if(!empty($violation_id)){
                    $this->model->setMaster_Violation_Id($violation_id);

                }

                if(isset($_POST["sys_department_id"])){
                    $setSysDepartmentId = $_POST["sys_department_id"];
                }

                if(isset($_POST["master_print_id"])){

                    $this->model->setDoc_Print_Allocation_Id($_POST["master_print_id"]);
                }

                if(isset($_POST["doc_print_allocation_id"])){
                    $this->model->setSerial_Check($_POST["doc_print_allocation_id"]);

                }

                if(isset($_POST["sys_user_id"])){
                    $iduser = $_POST["sys_user_id"];
                }
                if($iduser != 0) {
                    $this->model->setStaff_Check($iduser);
                }  else {
                    $this->model->setStaff_Check(GlobalLib::getLoginId());
                }
                if(strlen($_POST["date_check"])<0){
                    $date_check = date("Y/m/d H:i:s");
                }  else {
                    $date_check = GlobalLib::toMysqlDateString($_POST["date_check"]);
                }
                $this->model->setDate_Check($date_check);

                if(isset($_POST["sys_department_id"])){
                    $this->model->setSys_Department_id($setSysDepartmentId);
                }
                if(isset($_POST["comment"])){
                    $this->model->setComment($_POST["comment"]);
                }
                if(isset($_POST["is_violations"])){
                    $is_violations = $_POST["is_violations"];
                }

                $this->model->setIs_Violations($is_violations);
                $this->model->setCreated_Date(date("Y/m/d H:i:s"));
                $this->model->setCreated_By(GlobalLib::getLoginId());
                $this->model->setModified_Date(date("Y/m/d H:i:s"));
                $this->model->setModified_By(GlobalLib::getLoginId());
                $this->model->setIs_Delete(0);
                $this->modelMapper->save($this->model);


                // Lưu dữ liệu vào bảng doc_item_handling
                if(!empty($data)) {
                    $array_items_handling = $data[0]['array_items_handling'];
                    if (!empty($array_items_handling)) {
                        //$test = $array_items_handling[0]['serial_handling'];
                        $test = $this->model->getIs_Violations();
                        for ($e = 0; $e < count($array_items_handling); $e++) {
                            $master_items_id = $array_items_handling[$e]['master_items_id'];
                            if (empty($master_items_id)) {
                                continue;
                            }
                            $serial_handling = $array_items_handling[$e]['serial_handling'];
                            $quantity_commodity = $array_items_handling[$e]['quantity_commodity'];
                            $master_unit_id = $array_items_handling[$e]['master_unit_id'];
                            if (empty($master_unit_id)) {
                                $master_unit_id = null;
                            }

                            $master_sanction_id = $array_items_handling[$e]['master_sanction_id'];
                            if (empty($master_sanction_id)) {
                                $master_sanction_id = null;
                            }

                            $date_handling = $array_items_handling[$e]['date_handling'];
                            $date = GlobalLib::toMysqlDateString($date_handling);

                            $this->modelDocItemsHandling = new Model_Doc_Items_Handling();
                            $this->modelDocItemsHandling->setMaster_Items_Id($master_items_id);
                            $this->modelDocItemsHandling->setMaster_Sanction_Id($master_sanction_id);
                            $this->modelDocItemsHandling->setSerial_Handling($serial_handling);
                            $this->modelDocItemsHandling->setQuantity_Commodity($quantity_commodity);
                            $this->modelDocItemsHandling->setMaster_Unit_Id($master_unit_id);
                            $this->modelDocItemsHandling->setDate_Handling($date);
                            $this->modelDocItemsHandling->setAmount(0);
                            $this->modelDocItemsHandling->setStatus(GlobalLib::getName('master_sanction', $master_sanction_id, 'code'));
                            $this->modelDocItemsHandling->setCreated_Date(date("Y/m/d H:i:s"));
                            $this->modelDocItemsHandling->setCreated_By($this->model->getStaff_Check());
                            $this->modelDocItemsHandling->setModified_Date(date("Y/m/d H:i:s"));
                            $this->modelDocItemsHandling->setModified_By($this->model->getStaff_Check());
                            $this->modelDocItemsHandling->setInfo_Schedule_Check_Id($this->model->getId());
                            $this->modelMapperDocItemsHandling->save($this->modelDocItemsHandling);
                        }
                    }
                }

                $redirectUrl = $this->aConfig["site"]["url"] . "default/infoschedulecheck/list";
                $member[] = array(
                    'code' => 0,
                    'message' => $redirectUrl,
                    'value' => ''
                );
            }
        }
        catch (Exception $e) {
            $member[]=array(
                'code'=>1,
                'message'=>$e->getMessage(),
                'value'=>''
            );


        }
        echo json_encode($member);
        exit();
    }
    //End secvicesavehandlingAction - Lan Duong

    public function listAction(){
        
    }
    public function editAction(){
         $id= $this->_getParam("id",""); 
          $redirectUrl = $this->aConfig["site"]["url"]."default/infoschedulecheck/list/";    
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
             $redirectUrl = $this->aConfig["site"]["url"]."default/infoschedulecheck/list/";               
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

    public function updateviolationAction(){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();

            if ($this->getRequest()->isPost()) {
                $data = $_POST['data'];
                $id = $data[0]['info_schedule_check_id'];
                $is_violations = $data[0]['is_violations'];
                $amount = $data[0]['amount'];
                $dateviolation = $data[0]['date_handling'];
                $date_violation = GlobalLib::toMysqlDateString($dateviolation);
                $array_print_handling = $data[0]['array_print_handling'];

                $this->modelMapper->updateViolation($id, $is_violations);
                if($is_violations == 0)
                    $this->modelMapperDocItemsHandling->updateSanction($id,'10','TL_TG');
                else {
                    $select="select * from info_schedule_check where id=".$id;
                    $stmt=$db->query($select);
                    $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
                    $stmt->closeCursor();
                    foreach ($rows as $row){
                        // Tao du lieu cho bang doc_violation_handling va luu
                        $this->mdocviolatiohandling= new Model_Doc_Violations_Handling();
                        $this->mdocviolatiohandling->setInfo_Business_Id($row->info_business_id);
                        $this->mdocviolatiohandling->setMaster_Violation_Id($row->master_violation_id);
                        $this->mdocviolatiohandling->setMaster_Sanctions_Id(GlobalLib::getItemInDocItemsHandlingByScheduleCheckID("doc_items_handling", $row->id, "master_sanction_id"));
                        $this->mdocviolatiohandling->setSys_Department_Id($row->sys_department_id);
                        $this->mdocviolatiohandling->setSys_User_id($row->staff_check);
                        $this->mdocviolatiohandling->setDate_Violation($date_violation);
                        $this->mdocviolatiohandling->setAmount($amount);
                        $this->mdocviolatiohandling->setCreated_Date($date_violation);
                        $this->mdocviolatiohandling->setCreated_By($row->created_by);
                        $this->mdocviolatiohandling->setModified_Date($date_violation);
                        $this->mdocviolatiohandling->setModified_By($row->modified_by);
                        $this->mdocviolatiohandling->setOrder($row->order);
                        $this->mdocviolatiohandling->setStatus($row->status);
                        $this->mdocviolatiohandling->setComment($row->comment);
                        $this->mdocviolatiohandling->setIs_Delete($row->is_delete);
                        $this->modeldocviolatiohandlingMapper->save($this->mdocviolatiohandling);

                        // Cap nhat bang info_schedule_check
                        $idDocViolationsHandling = $this->mdocviolatiohandling->getId();
                        $this->modelMapper->updateInfo_Schedule_Check($id,$idDocViolationsHandling);

                        // Tao du lieu cho bang doc_print_handling va luu
                        for($f = 0;$f < count($array_print_handling);$f++ ) {
                            $master_print_id = $array_print_handling[$f]['master_print_id'];
                            $print_allocation_id = $array_print_handling[$f]['print_allocation_id'];
                            $serial = $array_print_handling[$f]['serialname'];

                            if(empty($print_allocation_id) || empty($master_print_id))
                            {
                                continue;
                            }

                            $this->mDocPrintHandling = new Model_Doc_Print_Handling();
                            $this->mDocPrintHandling->setMaster_Print_Id($master_print_id);
                            $this->mDocPrintHandling->setDoc_Print_Allocation_Id($print_allocation_id);
                            $this->mDocPrintHandling->setDoc_Violations_Handling_Id($idDocViolationsHandling);
                            $this->mDocPrintHandling->setSerial_Handing($serial);
                            $this->mDocPrintHandling->setCreated_Date($date_violation);
                            $this->mDocPrintHandling->setCreated_By($row->created_by);
                            $this->mDocPrintHandling->setModified_Date($date_violation);
                            $this->mDocPrintHandling->setModified_By($row->modified_by);
                            $this->modelMapperDocPrintHandling->save($this->mDocPrintHandling);
                        }

                        // Tao du lieu tang vat vi pham cho bang doc_item_violation va luu
                        $array_items_violation = $data[0]['array_items_violation'];
                        if (!empty($array_items_violation)) {
                            for ($k = 0; $k < count($array_items_violation); $k++) {
                                $master_items_id = $array_items_violation[$k]['master_items_id'];
                                $master_sanction_id = $array_items_violation[$k]['master_sanction_id'];
                                $doc_violations_handling_id = $idDocViolationsHandling;
                                $serial_handling = $array_items_violation[$k]['serial_handling'];
                                $quantity_commodity = $array_items_violation[$k]['quantity_commodity'];
                                $master_unit_id = $array_items_violation[$k]['master_unit_id'];
                                $date_handling = $array_items_violation[$k]['date_handling'];
                                $datehandling = GlobalLib::toMysqlDateString($date_handling);
                                $amount = $array_items_violation[$k]['amount'];

                                $this->modelDocItemsHandling = new Model_Doc_Items_Handling();
                                $this->modelDocItemsHandling->setMaster_Items_Id($master_items_id);
                                $this->modelDocItemsHandling->setMaster_Sanction_Id($master_sanction_id);
                                $this->modelDocItemsHandling->setDoc_Violations_Handling_Id($doc_violations_handling_id);
                                $this->modelDocItemsHandling->setSerial_Handling($serial_handling);
                                $this->modelDocItemsHandling->setQuantity_Commodity($quantity_commodity);
                                $this->modelDocItemsHandling->setMaster_Unit_Id($master_unit_id);
                                $this->modelDocItemsHandling->setDate_Handling($datehandling);
                                $this->modelDocItemsHandling->setAmount($amount);
                                $this->modelDocItemsHandling->setCreated_Date(date("Y/m/d H:i:s"));
                                $this->modelDocItemsHandling->setCreated_By($row->staff_check);
                                $this->modelDocItemsHandling->setModified_Date(date("Y/m/d H:i:s"));
                                $this->modelDocItemsHandling->setModified_By($row->staff_check);
                                $this->modelDocItemsHandling->setStatus(GlobalLib::getName('master_sanction', 3, 'code'));
                                $this->modelDocItemsHandling->setInfo_Schedule_Check_Id($id);
                                $this->modelMapperDocItemsHandling->save($this->modelDocItemsHandling);
                            }
                        }

                        // Tao du lieu tang vat tra lai cho bang doc_item_violation va luu
                        $array_items_return = $data[0]['array_items_return'];
                        if (!empty($array_items_return)) {
                            for ($m = 0; $m < count($array_items_return); $m++) {
                                $master_items_id = $array_items_return[$m]['master_items_id'];
                                $master_sanction_id = $array_items_return[$m]['master_sanction_id'];
                                //$doc_violations_handling_id = $idDocViolationsHandling;
                                $serial_handling = $array_items_return[$m]['serial_handling'];
                                $quantity_commodity = $array_items_return[$m]['quantity_commodity'];
                                $master_unit_id = $array_items_return[$m]['master_unit_id'];
                                $date_handling = $array_items_return[$m]['date_handling'];
                                $datehandling = GlobalLib::toMysqlDateString($date_handling);
                                $amount = $array_items_return[$m]['amount'];

                                $this->modelDocItemsHandling = new Model_Doc_Items_Handling();
                                $this->modelDocItemsHandling->setMaster_Items_Id($master_items_id);
                                $this->modelDocItemsHandling->setMaster_Sanction_Id($master_sanction_id);
                                //$this->modelDocItemsHandling->setDoc_Violations_Handling_Id($doc_violations_handling_id);
                                $this->modelDocItemsHandling->setSerial_Handling($serial_handling);
                                $this->modelDocItemsHandling->setQuantity_Commodity($quantity_commodity);
                                $this->modelDocItemsHandling->setMaster_Unit_Id($master_unit_id);
                                $this->modelDocItemsHandling->setDate_Handling($datehandling);
                                $this->modelDocItemsHandling->setAmount($amount);
                                $this->modelDocItemsHandling->setCreated_Date(date("Y/m/d H:i:s"));
                                $this->modelDocItemsHandling->setCreated_By($row->staff_check);
                                $this->modelDocItemsHandling->setModified_Date(date("Y/m/d H:i:s"));
                                $this->modelDocItemsHandling->setModified_By($row->staff_check);
                                $this->modelDocItemsHandling->setStatus(GlobalLib::getName('master_sanction', $master_sanction_id, 'code'));
                                $this->modelDocItemsHandling->setInfo_Schedule_Check_Id($id);
                                $this->modelMapperDocItemsHandling->save($this->modelDocItemsHandling);
                            }
                        }

                        // Cap nhat du lieu cho bang doc_items_handling
                        //$this->modelMapperDocItemsHandling->updateSanction($id,'3','XLN_TT');
                        //$this->modelMapperDocItemsHandling->updateDocViolationHandling($id,$idDocViolationsHandling);
                    }

                }

                $redirectUrl = $this->aConfig["site"]["url"] . "default/infoschedulecheck/list";
                $member[] = array(
                    'code' => 0,
                    'message' => $redirectUrl,
                    'value' => ''
                );
            }
        }
        catch (Exception $e) {
            $member[]=array(
                'code'=>1,
                'message'=>$e->getMessage(),
                'value'=>''
            );
        }
        echo json_encode($member);
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
        $redirectUrl=$this->aConfig["site"]["url"]."default/infoschedulecheck/list";               
        $this->modelMapper->deleteInfo_Schedule_Check($id);
        $this->_redirect($redirectUrl);
    }

    // Lan Duong
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        $sys_department_id = $this->_getParam("sys_department_id","");
        $type_violations= $this->_getParam("type_violations","");
        foreach ($this->modelMapper->fetchAllByIsViolations($sys_department_id, $type_violations) as $items ) {
            $menber[]=array(
                'id' => $items->getId(),
                'info_schedule_id'=> GlobalLib::getName("info_schedule",$items->getInfo_Schedule_Id(),"name_schedule"),
                'info_business_id'=>  $items->getInfo_Business_Id(),
                'info_business_name'=>  GlobalLib::getName("info_business",$items->getInfo_Business_Id(),"name"),
                'info_business_office'=>  GlobalLib::getName("info_business",$items->getInfo_Business_Id(),"address_office"),
                'info_business_work'=>  GlobalLib::getName("info_business",$items->getInfo_Business_Id(),"work_business"),
                'master_print_schedule_check_id'=> GlobalLib::getName("master_print",$items->getDoc_Print_Allocation_Id(),"code"),
                'doc_print_create_schedule_check_id'=> GlobalLib::getName("doc_print_create",$items->getDoc_Print_Allocation_Id(),"coefficient"),
                'doc_print_allocation_schedule_check_id'=> GlobalLib::getName("master_print",$items->getDoc_Print_Allocation_Id(),"code"),
                'serial_schedule_check'=>$items->getSerial_Check(),
                'master_print_violation_id'=> GlobalLib::getName("master_print",GlobalLib::getName("doc_print_allocation",$items->getDoc_Print_Allocation_Id(),"master_print_id"),"code"),
                'doc_print_create_violation_id'=> GlobalLib::getName("doc_print_create",GlobalLib::getName("doc_print_allocation",$items->getDoc_Print_Allocation_Id(),"doc_print_create_id"),"coefficient"),
                'serial_violation_check'=>GlobalLib::getName("doc_print_allocation",$items->getDoc_Print_Allocation_Id(),"serial_recovery1"),
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

    public function getdocitemhandingAction()
    {
        $info_schedule_check_id = $this->_getParam("info_schedule_check_id","");
        $this->_helper->layout->disableLayout();
        $result = null;
        try
        {
            $result = $this->modelMapperDocItemsHandling->finditembyInfoScheduleCheck($info_schedule_check_id);
        } catch (Exception $ex) {

        }

        if($result!=null)
            echo json_encode ($result);
        else
            echo 0;
        exit();
    }
}
