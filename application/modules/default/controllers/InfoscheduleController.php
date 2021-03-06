<?php
include APPLICATION_PATH . "/models/Info_Schedule.php";
include APPLICATION_PATH . "/models/Info_Schedule_Check.php";
//include APPLICATION_PATH . "/models/Doc_Violations_Handling.php";


class InfoScheduleController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Info_ScheduleMapper();
        $this->model= new Model_Info_Schedule(); 
        $this->modelinfoschedulecheckMapper= new Model_Info_Schedule_CheckMapper();
        $this->modelmodelinfoschedulecheck= new Model_Info_Schedule_Check(); 
//        $this->modelMapperDocViolationsHandling= new Model_Doc_Violations_HandlingMapper();
//        $this->modelDocViolationsHandling= new Model_Doc_Violations_Handling();  
    }
    public function addAction(){
        $this->view->provinceHTML = GlobalLib::getComboByProvince('master_province_id', 'master_province', 'id', 'name', 0, false, 'form-control', '', '', '', 'onchange="getDistrictWithProvinceSchedule(\'' . $this->aConfig["site"]["url"] .'default/service/index'. '\')"');
        $this->view->districtHTML = GlobalLib::getComboByDistrict('master_district_id', 'master_district', 'id', 'name', 0, true, 'form-control', '', 'where master_province_id=0', '', 'onchange="getWardWithDistrictSchedule(\''.$this->aConfig["site"]["url"].'default/service/index'.'\')"');
        $this->view->wardHTML = GlobalLib::getComboByWard('master_ward_id', 'master_ward', 'id', 'name', 0, true, 'form-control', '', '', 'where master_district_id=0', '');
        
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."default/infoschedule/list/";            
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(isset($_POST["name_schedule"])){
                $this->model->setName_Schedule($_POST["name_schedule"]);
            }
            if(strlen($_POST["district_id"])){
               $this->model->setMaster_District_Id($_POST["district_id"]);
            }
            if(strlen($_POST["ward_id"])){
               $this->model->setMaster_Ward_Id($_POST["ward_id"]);
            }
            if(strlen($_POST["date_from"])<=0){
                $ngay_tao = date("Y/m/d H:i:s");
            }  else {
                $ngay_tao = GlobalLib::toMysqlDateString($_POST["date_from"]);
            }
            $this->model->setDate_From($ngay_tao);
             if(strlen($_POST["date_to"])<=0){
                $ngay_tao = date("Y/m/d H:i:s");
            }  else {
                $ngay_tao = GlobalLib::toMysqlDateString($_POST["date_to"]);
            }
            $this->model->setDate_To($ngay_tao);
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
            $this->model->setIs_delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item= $this->model;
    }
    public function listAction(){
        
    }
    public function editAction(){
         $id= $this->_getParam("id","");   
         if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        $getDistrictId=$this->model->getMaster_District_Id();
        $getWardId=$this->model->getMaster_Ward_Id();
        $this->view->districtHTML = GlobalLib::getComboCheckk('master_district_id', 'master_district', 'id', 'name', $getDistrictId, true, 'form-control', '', '', '', 'onchange="getWardWithDistrictSchedule(\''.$this->aConfig["site"]["url"].'default/service/index'.'\')"');
        $this->view->wardHTML = GlobalLib::getComboCheckk('master_ward_id', 'master_ward', 'id', 'name', $getWardId, true, 'form-control', '', 'where master_district_id in ('.$getDistrictId.')', '', 'Xin Chờ Trong Giây Lát\');"');
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."default/infoschedule/list/";            
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(isset($_POST["name_schedule"])){
                $this->model->setName_Schedule($_POST["name_schedule"]);
            }
            if(strlen($_POST["district_id"])){
               $this->model->setMaster_District_Id($_POST["district_id"]);
            }
            if(strlen($_POST["ward_id"])){
               $this->model->setMaster_Ward_Id($_POST["ward_id"]);
            }
            if(strlen($_POST["date_from"])<=0){
                $ngay_tao = date("Y/m/d H:i:s");
            }  else {
                $ngay_tao = GlobalLib::toMysqlDateString($_POST["date_from"]);
            }
            $this->model->setDate_From($ngay_tao);
             if(strlen($_POST["date_to"])<=0){
                $ngay_tao = date("Y/m/d H:i:s");
            }  else {
                $ngay_tao = GlobalLib::toMysqlDateString($_POST["date_to"]);
            }
            $this->model->setDate_To($ngay_tao);
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
            $this->model->setIs_delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item= $this->model;
    }
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
         $identity = Zend_Auth::getInstance()->getIdentity();
        $sys_department_id = $identity->sys_department_id ;
        foreach ($this->modelMapper->fetchAll($sys_department_id) as $items ) {
            $id_inforcheck1 = $this->modelinfoschedulecheckMapper->findidbyid_info_schedule($items->getSys_Department_Id(),$items->getId());
//            $id_inforcheck2 = $this->modelMapperDocViolationsHandling->findidbyid_info_schedule($items->getSys_Department_Id(),$items->getId());
            $status ="";
            if(($id_inforcheck1 != null)){
                $this->modelinfoschedulecheckMapper->find($id_inforcheck1,$this->modelmodelinfoschedulecheck);
                $getdate_check =$this->modelmodelinfoschedulecheck->getDate_Check();
                if((strtotime($getdate_check)) <= (strtotime($items->getDate_To()))&&(strtotime($getdate_check)) >= (strtotime($items->getDate_From()))){
                    $status = "Đã thực hiện";
                }
                
            }elseif((strtotime(date("Y-m-d"))) <= (strtotime($items->getDate_To()))) {
                $status ="Đang thực hiện";
            }elseif(strtotime(date("Y-m-d")) > strtotime($items->getDate_To())){
                $status ="Chưa thực hiện";
            }
            $menber[]=array(
                'id' => $items->getId(),
                'name_schedule'=> $items->getName_Schedule(),  
                'date_from'=>  GlobalLib::viewDate($items->getDate_From()),
                'date_to'=>  GlobalLib::viewDate($items->getDate_To()),
                'sys_department_id'=>  GlobalLib::getName("sys_department",$items->getSys_Department_Id(),"name"),
                'master_district_id'=>  GlobalLib::getName("master_district",$items->getMaster_District_Id(),"name"),
                'master_ward_id'=>  GlobalLib::getName("master_ward",$items->getMaster_Ward_Id(),"name"),
                'is_confirm'=>$items->getIs_Confirm(),
                'confirm_sys_user_id'=>$items->getConfirm_Sys_User_Id(),
                'created_date'=>$items->getCreated_Date(),
                'created_by'=>$items->getCreated_By(),
                'modified_date'=>$items->getModified_Date(),
                'modified_by'=>$items->getModified_By(),
                'order'=>$items->getOrder(),
                'status'=>$status,
                'comment'=>$items->getComment()   

            );
        }
        echo json_encode($menber);
        exit();
    }
//    public  function confirmdeleteAction()
//    {
//        if($this->getRequest()->isPost()){
//           $count =0;
//           $id_info_schedule = $this->_getParam("id","");
//           $redirectUrl=$this->aConfig["site"]["url"]."default/infoschedule/list";      
//           $this->modelMapper->find($id_info_schedule,$this->model);
//           $id_info_schedulen =  $this->model->getId();
//           $info_schedulen_check=$this->modelinfoschedulecheckMapper->findidbyname('info_schedule_id',$id_info_schedulen);
//           if(empty($id_info_schedulen)){
//                $this->_redirect($redirectUrl);
//           }
//           if($info_schedulen_check!=0){
//               $count =1;
//           }
//           echo json_encode($count);                            
//           exit();
//        }
//    }
     public function deleteAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."default/infoschedule/list";               
        $this->modelMapper->deleteinfo_schedule($id);
        $this->_redirect($redirectUrl);
    }
        
}
