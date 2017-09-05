<?php
    include_once APPLICATION_PATH."/models/MasterProvince.php";
    include_once APPLICATION_PATH."/models/MasterDistrict.php";
    include_once APPLICATION_PATH."/models/MasterWard.php";
    include_once  APPLICATION_PATH."/models/InfoBusiness.php";   
    //include_once  APPLICATION_PATH."/Sys_User.php";
    class InfoBusinessController extends Zend_Controller_Action{
    //put your code here
    public function init() {
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->model= new Model_InfoBusiness();
        $this->modelMapper= new Model_InfoBusinessMapper();
        $this->modelProvince = new Model_MasterProvince();
        $this->modelProvinceMapper = new Model_MasterProvinceMapper(); 
        $this->modelDistrict = new Model_MasterDistrict();
        $this->modelDistrictMapper = new Model_MasterDistrictMapper(); 
        $this->modelWard = new Model_MasterWard();
        $this->modelWardMapper = new Model_MasterWardMapper(); 
    }
    public function indexAction(){}
    public function listAction() {
        $type_business= $this->_getParam("type_business","");
        $this->model->setType_business($type_business);
        if(empty($type_business)){
            $this->_redirect($redirectUrl);
        }
        $this->view->type_business=$type_business;

        //$this->view->testNganhNghe = "";

        if($this->getRequest()->isPost()) {
            if (isset($_POST['doanhnghiep_id'])) {
                $doanhnghiep_id = array();
                foreach ($_POST['doanhnghiep_id'] as $key => $value) {
                    array_push($doanhnghiep_id, $value);
                }
                $this->view->doanhnghiep_id = implode(",", $doanhnghiep_id);
            }

            if (isset($_POST['tinhthanh_id'])) {
                $tinhthanh_id = array();
                foreach ($_POST['tinhthanh_id'] as $key => $value) {
                    array_push($tinhthanh_id, $value);
                }
                $this->view->tinhthanh_id = implode(",", $tinhthanh_id);
            }

            if (isset($_POST['loaihinh_id'])) {
                $loaihinh_id = array();
                foreach ($_POST['loaihinh_id'] as $key => $value) {
                    array_push($loaihinh_id, $value);
                }
                $this->view->loaihinh_id = implode(",", $loaihinh_id);
            }

            if (isset($_POST['nganhnghe_id'])) {
                $nganhnghe_id = array();
                foreach ($_POST['nganhnghe_id'] as $key => $value) {
                    array_push($nganhnghe_id, $value);
                }
                $this->view->nganhnghe_id = implode(",", $nganhnghe_id);
            }
        }
        $this->view->doanhnghiepHTML = GlobalLib::getComboMultiSelect("doanhnghiep_id", "info_business", "code", "name",NULL,$this->view->doanhnghiep_id,true);
        $this->view->tinhthanhHTML = GlobalLib::getComboMultiSelect("tinhthanh_id", "master_province", "id", "name",NULL,$this->view->tinhthanh_id,true);
        $this->view->loaihinhHTML = GlobalLib::getComboMultiSelect("loaihinh_id", "master_business_type", "id", "name",NULL,$this->view->loaihinh_id,true," where code in ('DN_NN','DN_TN','CT_CP','CT_TNHH','CT_HD','CT_LD')");
        $this->view->nganhngheHTML = GlobalLib::getComboDistinctMultiSelect("nganhnghe_id", "info_business", "code", "work_business",NULL,$this->view->nganhnghe_id,true);
    }    
    public function serviceAction(){
        $type_business= $this->_getParam("type_business","");
        $userid = $this->_getParam("userid","");
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapper->fetchAllByUser($type_business,$userid) as $items ) {
            if($items->getType_Business()=="DoanhNghiep"){
                $t = 1;
            }  else if($items->getType_Business()=="HoKinhDoanh") {
                $t = 2;
            }  else {
                $t = 3;
            }
            $menber[]=array(
                'g'=> $t,
                'Id' => $items->getId(),
                'code'=> $items->getCode(),
                'name' => $items->getName(),
                'license_business'=>$items->getLicense_Business(),
                'date_license'=>GlobalLib::viewDate($items->getDate_License()),
                 'date_deadline'=>GlobalLib::viewDate($items->getDate_Deadline()),
                'place_license'=>$items->getPlace_License(),
                'address_office'=> $items->getAddress_Office(),
		'address_office2'=> $items->getAddress_Office2(),
                'address_branch' => $items->getAddress_Branch(),
                'address_produce' => $items->getAddress_Produce(),
                'work_business'=>$items->getWork_Business(),
                'phone'=>$items->getPhone(),
                'boss_business'=>$items->getBoss_Business(),
                'address_permanent'=> $items->getAddress_Permanent(),
                'cellphone' => $items->getCellphone(),
                'license_condition_business'=>$items->getLicense_Condition_Business(),
                'date_license_condition_business'=>GlobalLib::viewDate($items->getDate_License_Condition_Business()),
                'master_items_limit_id'=>GlobalLib::getName('master_items_limit',$items->getMaster_Items_Limit_Id(),'name'),
                'master_items_condition_id'=>GlobalLib::getName('master_items_condition',$items->getMaster_Items_Condition_Id(),'name'),
                'master_province'=>GlobalLib::getName('master_province',$items->getMaster_Province_Id(),'name'),
                'master_district'=>GlobalLib::getName('master_district',$items->getMaster_District_Id(),'name'),
                'master_ward'=>GlobalLib::getName('master_ward',$items->getMaster_Ward_Id(),'name'),
                'master_business_type_id'=>GlobalLib::getName('master_business_type',$items->getMaster_Business_Type_Id(),'name'),
                'master_business_size_id'=>GlobalLib::getName('master_business_size',$items->getMaster_Business_Size_Id(),'name'),
                'date_check'=>  GlobalLib::viewDate($items->getDate_Check()),
                'type_business'=>$items->getType_Business(),
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus(),
                'comment'=>$items->getComment()

            );
        }
        echo json_encode($menber);
        exit();
    }
        public function service1Action(){
            $type_business= $this->_getParam("type_business","");
            $userid = $this->_getParam("userid","");
            $this->_helper->layout->disableLayout();
            foreach ($this->modelMapper->fetchAllNotByUser($type_business,$userid) as $items ) {
                if($items->getType_Business()=="DoanhNghiep"){
                    $t = 1;
                }  else if($items->getType_Business()=="HoKinhDoanh") {
                    $t = 2;
                }  else {
                    $t = 3;
                }
                $menber[]=array(
                    'g'=> $t,
                    'Id' => $items->getId(),
                    'code'=> $items->getCode(),
                    'name' => $items->getName(),
                    'license_business'=>$items->getLicense_Business(),
                    'date_license'=>GlobalLib::viewDate($items->getDate_License()),
                    'place_license'=>$items->getPlace_License(),
                    'address_office'=> $items->getAddress_Office(),
                    'address_office2'=> $items->getAddress_Office2(),
                    'address_branch' => $items->getAddress_Branch(),
                    'address_produce' => $items->getAddress_Produce(),
                    'work_business'=>$items->getWork_Business(),
                    'phone'=>$items->getPhone(),
                    'boss_business'=>$items->getBoss_Business(),
                    'address_permanent'=> $items->getAddress_Permanent(),
                    'cellphone' => $items->getCellphone(),
                    'license_condition_business'=>$items->getLicense_Condition_Business(),
                    'date_license_condition_business'=>GlobalLib::viewDate($items->getDate_License_Condition_Business()),
                    'master_items_limit_id'=>GlobalLib::getName('master_items_limit',$items->getMaster_Items_Limit_Id(),'name'),
                    'master_items_condition_id'=>GlobalLib::getName('master_items_condition',$items->getMaster_Items_Condition_Id(),'name'),
                    'master_province'=>GlobalLib::getName('master_province',$items->getMaster_Province_Id(),'name'),
                    'master_district'=>GlobalLib::getName('master_district',$items->getMaster_District_Id(),'name'),
                    'master_ward'=>GlobalLib::getName('master_ward',$items->getMaster_Ward_Id(),'name'),
                    'master_business_type_id'=>GlobalLib::getName('master_business_type',$items->getMaster_Business_Type_Id(),'name'),
                    'master_business_size_id'=>GlobalLib::getName('master_business_size',$items->getMaster_Business_Size_Id(),'name'),
                    'date_check'=>  GlobalLib::viewDate($items->getDate_Check()),
                    'type_business'=>$items->getType_Business(),
                    'order'=>$items->getOrder(),
                    'status'=>$items->getStatus(),
                    'comment'=>$items->getComment()

                );
            }
            echo json_encode($menber);
            exit();
        }
    public function addAction(){
        $type_business= $this->_getParam("type_business","");
        $this->model->setType_business($type_business);
        if(empty($type_business)){
            $this->_redirect($redirectUrl);
        }
        $this->view->provinceHTML = GlobalLib::getComboByProvince('master_province_id', 'master_province', 'id', 'name', 0, false, 'form-control', '', '', '', 'onchange="getDistrictWithProvince(\'' . $this->aConfig["site"]["url"] .'default/service/index'. '\')"');
        $this->view->districtHTML = GlobalLib::getComboByDistrict('master_district_id', 'master_district', 'id', 'name', 0, false, 'form-control', '', 'where master_province_id=0', '', 'onchange="getWardWithDistrict(\''.$this->aConfig["site"]["url"].'default/service/index'.'\')"');
        $this->view->wardHTML = GlobalLib::getComboByWard('master_ward_id', 'master_ward', 'id', 'name', 0, false, 'form-control', '', 'where master_district_id=0', '', '');
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."default/infobusiness/list/type_business/".$type_business;            
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(strlen($_POST["code_business"])){
                $this->model->setCode($_POST["code_business"]);
            }
            if(strlen($_POST["name_business"])){
                $this->model->setName($_POST["name_business"]);
            }
            if(strlen($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(strlen($_POST["master_province_id"])){
                 if($_POST["master_province_id"] <=0)
                {
                    $this->model->setMaster_Province_Id(NULL);
                }
                else
                {
                    $this->model->setMaster_Province_Id($_POST["master_province_id"]);
                }
                
            }
            if(strlen($_POST["master_district_id"])){
                if($_POST["master_district_id"] <=0)
                {
                    $this->model->setMaster_District_Id(NULL);
                }
                else
                {
                   $this->model->setMaster_District_Id($_POST["master_district_id"]);
                }
                
            }
            if(strlen($_POST["master_ward_id"])){
                if($_POST["master_ward_id"] <=0)
                {
                    $this->model->setMaster_Ward_Id(NULL);
                }
                else
                {
                   $this->model->setMaster_Ward_Id($_POST["master_ward_id"]);
                }
                
            }
            if(isset($_POST["type_business"])){
                $this->model->setType_Business($_POST["type_business"]);
            }   
            if(isset($_POST["phone_business"])){
                $this->model->setPhone($_POST["phone_business"]);
            }   
            if(isset($_POST["license_business"])){
                $this->model->setLicense_Business($_POST["license_business"]);
            }
            if(strlen($_POST["day_license"])<=0){
                $date_license = date("Y/m/d H:i:s");
            }  else {
                $date_license = GlobalLib::toMysqlDateString($_POST["day_license"]);
            }
            $this->model->setDate_License($date_license);
            if(strlen($_POST["day_deadline"])<=0){
                $date_deadline = date("Y/m/d H:i:s");
            }  else {
                $date_deadline = GlobalLib::toMysqlDateString($_POST["day_deadline"]);
            }
            $this->model->setDate_Deadline($date_deadline);
            if(isset($_POST["place_license"])){
                $this->model->setPlace_License($_POST["place_license"]);
            }
            if(isset($_POST["address_office"])){
                $this->model->setAddress_Office($_POST["address_office"]);
            }
	    if(isset($_POST["address_office2"])){
                $this->model->setAddress_Office2($_POST["address_office2"]);
            }
            if(isset($_POST["address_branch"])){
                $this->model->setAddress_Branch($_POST["address_branch"]);
            }
             if(isset($_POST["address_produce"])){
                $this->model->setAddress_Produce($_POST["address_produce"]);
            }
            if(isset($_POST["address_produce1"])){
                $this->model->setAddress_Produce1($_POST["address_produce1"]);
            }
            if(isset($_POST["address_produce11"])){
                $this->model->setAddress_Produce11($_POST["address_produce11"]);
            }
            if(isset($_POST["address_produce111"])){
                $this->model->setAddress_Produce111($_POST["address_produce111"]);
            }
            if(isset($_POST["work_business"])){
                $this->model->setWork_Business($_POST["work_business"]);
            }
           if(isset($_POST["master_business_type_value"])){
                if($_POST["master_business_type_value"] <=0)
                {
                    $this->model->setMaster_Business_Type_Id(NULL);
                }
                else
                {
                    $this->model->setMaster_Business_Type_Id($_POST["master_business_type_value"]);  
                }
            }            
            if(isset($_POST["master_business_size_id"])){
                if($_POST["master_business_size_id"] <=0)
                {
                    $this->model->setMaster_Business_Size_Id(NULL);
                }
                else {
                    $this->model->setMaster_Business_Size_Id($_POST["master_business_size_id"]);
                }
            }
            if(isset($_POST["master_items_condition_value"])){
                if($_POST["master_items_condition_value"] <=0)
                {
                    $this->model->setMaster_Items_Condition_Id(NULL);
                }
                else {
                    $this->model->setMaster_Items_Condition_Id($_POST["master_items_condition_value"]);
                }
                
            }
            if(isset($_POST["master_items_limit_value"])){
                  if($_POST["master_items_limit_value"] <=0)
                {
                    $this->model->setMaster_Items_Limit_Id(NULL);
                }
                else {
                      $this->model->setMaster_Items_Limit_Id($_POST["master_items_limit_value"]);
                }
              
            }
            if(isset($_POST["license_condition_business"])){
                $this->model->setLicense_Condition_Business($_POST["license_condition_business"]);
            }
            if(strlen($_POST["date_license_condition_business"])<=0){
                $date_license_condition_business = date("Y/m/d H:i:s");
            }  else {
                $date_license_condition_business = GlobalLib::toMysqlDateString($_POST["date_license_condition_business"]);
            }
            $this->model->setDate_License_Condition_Business($date_license_condition_business);
            if(isset($_POST["boss_business"])){
                $this->model->setBoss_Business($_POST["boss_business"]);
            }
            if(isset($_POST["address_permanent"])){
                $this->model->setAddress_Permanent($_POST["address_permanent"]);
            }
            if(isset($_POST["cellphone"])){
                $this->model->setCellphone($_POST["cellphone"]);
            }
//            
            if(strlen($_POST["day_check"])<=0){
                $date_check = date("Y/m/d H:i:s");
            }  else {
                $date_check = GlobalLib::toMysqlDateString($_POST["day_check"]);
            }
            $this->model->setDate_Check($date_check);
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            $this->model->setStatus(1);
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }    
           $this->view->type_business=$type_business;
           $this->view->item= $this->model;
    }
    public function editAction() {
        $id= $this->_getParam("id","");   
        $type_business = $this->modelMapper->findtypebusinessbyid($id);
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        $getProvinceId=$this->model->getMaster_Province_Id();
        $getDistrictId=$this->model->getMaster_District_Id();
        $getWardId=$this->model->getMaster_Ward_Id();
         $this->view->provinceHTML = GlobalLib::getComboByProvince('master_province_id', 'master_province', 'id', 'name', $getProvinceId, false, 'form-control', '', '', '', 'onchange="getDistrictWithProvince(\'' . $this->aConfig["site"]["url"] .'default/service/index'.  '\')"');
        $this->view->districtHTML = GlobalLib::getComboByDistrict('master_district_id', 'master_district', 'id', 'name', $getDistrictId, false, 'form-control', '', 'where master_province_id=\''.$getProvinceId.'\'', '', 'onchange="getWardWithDistrict(\''.$this->aConfig["site"]["url"].'default/service/index'. '\')"');
        $this->view->wardHTML = GlobalLib::getComboByWard('master_ward_id', 'master_ward', 'id', 'name', $getWardId, false, 'form-control', '', 'where master_district_id=\''.$getDistrictId.'\'', '', '');
       
         if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."default/infobusiness/list/type_business/".$type_business;            
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(strlen($_POST["code_business"])){
                $this->model->setCode($_POST["code_business"]);
            }
            if(strlen($_POST["name_business"])){
                $this->model->setName($_POST["name_business"]);
            }
            if(strlen($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(strlen($_POST["master_province_id"])){
                 if($_POST["master_province_id"] <=0)
                {
                    $this->model->setMaster_Province_Id(NULL);
                }
                else
                {
                     $this->model->setMaster_Province_Id($_POST["master_province_id"]);
                }
               
            }
            if(strlen($_POST["master_district_id"])){
                 if($_POST["master_district_id"] <=0)
                {
                    $this->model->setMaster_District_Id(NULL);
                }
                else
                {
                       $this->model->setMaster_District_Id($_POST["master_district_id"]);
                }
              
            }
            if(strlen($_POST["master_ward_id"])){
                if($_POST["master_ward_id"] <=0)
                {
                    $this->model->setMaster_Ward_Id(NULL);
                }
                else
                {
                    $this->model->setMaster_Ward_Id($_POST["master_ward_id"]);
                }
                
            }
            if(isset($_POST["type_business"])){
                $this->model->setType_Business($_POST["type_business"]);
            }   
            if(isset($_POST["phone_business"])){
                $this->model->setPhone($_POST["phone_business"]);
            }   
            if(isset($_POST["license_business"])){
                $this->model->setLicense_Business($_POST["license_business"]);
            }
            if(strlen($_POST["day_license"])<=0){
                $date_license = date("Y/m/d H:i:s");
            }  else {
                $date_license = GlobalLib::toMysqlDateString($_POST["day_license"]);
            }
            $this->model->setDate_License($date_license);
            if(strlen($_POST["day_deadline"])<=0){
                $date_deadline = date("Y/m/d H:i:s");
            }  else {
                $date_deadline = GlobalLib::toMysqlDateString($_POST["day_deadline"]);
            }
            $this->model->setDate_Deadline($date_deadline);
            if(isset($_POST["place_license"])){
                $this->model->setPlace_License($_POST["place_license"]);
            }
            if(isset($_POST["address_office"])){
                $this->model->setAddress_Office($_POST["address_office"]);
            }
	    if(isset($_POST["address_office2"])){
                $this->model->setAddress_Office2($_POST["address_office2"]);
            }
            if(isset($_POST["address_branch"])){
                $this->model->setAddress_Branch($_POST["address_branch"]);
            }
            if(isset($_POST["address_produce"])){
                $this->model->setAddress_Produce($_POST["address_produce"]);
            }
            if(isset($_POST["address_produce1"])){
                $this->model->setAddress_Produce1($_POST["address_produce1"]);
            }
            if(isset($_POST["address_produce11"])){
                $this->model->setAddress_Produce11($_POST["address_produce11"]);
            }
            if(isset($_POST["address_produce111"])){
                $this->model->setAddress_Produce111($_POST["address_produce111"]);
            }
            if(isset($_POST["work_business"])){
                $this->model->setWork_Business($_POST["work_business"]);
            }
           if(isset($_POST["master_business_type_value"])){
                if($_POST["master_business_type_value"] <=0)
                {
                    $this->model->setMaster_Business_Type_Id(NULL);
                }
                else
                {
                    $this->model->setMaster_Business_Type_Id($_POST["master_business_type_value"]);
                }
                
            }            
            if(isset($_POST["master_business_size_id"])){
                if($_POST["master_business_size_id"] <=0)
                {
                    $this->model->setMaster_Business_Size_Id(NULL);
                }
                else
                {
                      $this->model->setMaster_Business_Size_Id($_POST["master_business_size_id"]);
                }
              
            }
            if(isset($_POST["master_items_condition_value"])){
                 if($_POST["master_items_condition_value"] <=0)
                {
                    $this->model->setMaster_Items_Condition_Id(NULL);
                }
                else
                {
                     $this->model->setMaster_Items_Condition_Id($_POST["master_items_condition_value"]);
                }
                
            }
            if(isset($_POST["master_items_limit_value"])){
                if($_POST["master_items_limit_value"] <=0)
                {
                    $this->model->setMaster_Items_Limit_Id(NULL);
                }
                else
                {
                    $this->model->setMaster_Items_Limit_Id($_POST["master_items_limit_value"]);
                }
                
            }
            if(isset($_POST["license_condition_business"])){
                $this->model->setLicense_Condition_Business($_POST["license_condition_business"]);
            } 
            if(strlen($_POST["date_license_condition_business"])<=0){
                $date_license_condition_business = date("Y/m/d H:i:s");
            }  else {
                $date_license_condition_business = GlobalLib::toMysqlDateString($_POST["date_license_condition_business"]);
            }
            $this->model->setDate_License_Condition_Business($date_license_condition_business);
            if(isset($_POST["boss_business"])){
                $this->model->setBoss_Business($_POST["boss_business"]);
            }
            if(isset($_POST["address_permanent"])){
                $this->model->setAddress_Permanent($_POST["address_permanent"]);
            }
            if(isset($_POST["cellphone"])){
                $this->model->setCellphone($_POST["cellphone"]);
            }
            if(strlen($_POST["day_check"])<=0){
                $date_check = date("Y/m/d H:i:s");
            }  else {
                $date_check = GlobalLib::toMysqlDateString($_POST["day_check"]);
            }
            $this->model->setDate_Check($date_check);
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            $this->model->setStatus(1);
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }    
           $this->view->type_business= $type_business;
           $this->view->item= $this->model;
    }
   
    public function checkdocviolationsAction() {
        $this->_helper->layout()->disableLayout();
//         if($this->_request->isPost()){
             $id= $this->_getParam("id","");
              $urls = $this->aConfig["site"]["url"]."default/docviolationshandling/listfrominfobusiness/id/".$id;
             $id= $this->modelMapper->finddocviolationsbyid($id);
             if($id !=0){
                 $menber[]=array(
                     'code'=>1,
                     'message'=>"<div style='margin: 10px;'><a href='$urls'></a></div>",
                     'url'=>$urls
                         );  
             } else {
                  $menber[]=array(
                     'code'=>0,
                     'message'=>'<div style="margin: 10px;" id="doc_violations" name="doc_violations">Hiện không có vi phạm xử phạt nào</div>'
                    );
             }
             echo json_encode($menber);
             exit();
//         }  
    }
    public  function confirmdeleteAction()
    {
        $id = $this->_getParam("id","0");
        $count = 0;
        foreach($this->AdminAreamodelMapper->fetchAll() as $item)
        {
            if($item->getAdmin_Id()==$id) $count= $count+1;
        }
        echo $count;
        exit();
    }
    
    public function deleteAction(){
       $id= $this->_getParam("id","");
        $type_business = $this->modelMapper->findtypebusinessbyid($id);
        $redirectUrl = $this->aConfig["site"]["url"]."default/infobusiness/list/type_business/".$type_business;                   
        $this->modelMapper->deleteInfoBusiness($id);
        $this->_redirect($redirectUrl);
    }
    
    public function checkcodeAction(){
        $this->_helper->layout()->disableLayout();
         if($this->_request->isPost()){
             $code_business= $this->_getParam("code_business","");
             $id= $this->modelMapper->findidbycode($code_business);
             if($id !=0){
                 $menber[]=array(
                     'code'=>1,
                     'message'=>'Mã code này đã tồn tại. Vui lòng kiểm tra và nhập lại'
                         );  
             } else {
                  $menber[]=array(
                     'code'=>0,
                     'message'=>'');
             }
             echo json_encode($menber);
             exit();
         }  
    }
    public function add1Action(){}
    public function findbusinessbyidAction()
    {
        $this->_helper->layout()->disableLayout();
        $id = $this->_getParam("id","");
        $result = $this->modelMapper->findbusinessbyid($id);        
        foreach ($result as $items)
        {
            $menber[]=array(
                'Id' => $items->getId(),
                'code'=> $items->getCode(),
                'name' => $items->getName(),
                'license_business'=>$items->getLicense_Business(),
                'date_license'=>$items->getDate_License(),
                 'date_deadline'=>$items->getDate_Deadline(),
                'place_license'=>$items->getPlace_License(),
                'address_office'=> $items->getAddress_Office(),
		'address_office2'=> $items->getAddress_Office2(),
                'address_branch' => $items->getAddress_Branch(),
                'address_produce' => $items->getAddress_Produce(),
                'address_produce1' => $items->getAddress_Produce1(),
                'address_produce11' => $items->getAddress_Produce11(),
                'address_produce111' => $items->getAddress_Produce111(),
                'work_business'=>$items->getWork_Business(),
                'phone'=>$items->getPhone(),
                'boss_business'=>$items->getBoss_Business(),
                'address_permanent'=> $items->getAddress_Permanent(),
                'cellphone' => $items->getCellphone(),
                'license_condition_business'=>$items->getLicense_Condition_Business(),   
                'date_license_condition_business'=>$items->getDate_License_Condition_Business(),
                'master_items_limit_id'=>$items->getMaster_Items_Limit_Id(),
                'master_items_condition_id'=>$items->getMaster_Items_Condition_Id(),
                'master_district'=>GlobalLib::getName('master_district',$items->getMaster_District_Id(),'name'),
                'master_ward'=>GlobalLib::getName('master_ward',$items->getMaster_Ward_Id(),'name'),
                'master_business_type_id'=>$items->getMaster_Business_Type_Id(),
                'master_business_size_id'=>$items->getMaster_Business_Size_Id(),
                'date_check'=>$items->getDate_Check(),
                'type_business'=>$items->getType_Business(),
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus(),
                'comment'=>$items->getComment()
            );
        }
        echo json_encode($menber);
        exit();
            
    }

    // Lan Duong
        public function filterdoanhnghiepAction(){
            $this->_helper->layout->disableLayout();
            $type_business= $this->_getParam("type_business","");
            $doanhnghiep_id = $this->_getParam("doanhnghiep_id","");
            $tinhthanh_id = $this->_getParam("tinhthanh_id","");
            $loaihinh_id = $this->_getParam("loaihinh_id","");
            $nganhnghe_id = $this->_getParam("nganhnghe_id","");
            //var_dump($nganhnghe_id);die();
            foreach ($this->modelMapper->fetchAllFilterDoanhNghiep($type_business, $doanhnghiep_id, $nganhnghe_id, $tinhthanh_id, $loaihinh_id) as $items ) {
                if($items->getType_Business()=="DoanhNghiep"){
                    $t = 1;
                }  else if($items->getType_Business()=="HoKinhDoanh") {
                    $t = 2;
                }  else {
                    $t = 3;
                }
                $menber[]=array(
                    'g'=> $t,
                    'Id' => $items->getId(),
                    'code'=> $items->getCode(),
                    'name' => $items->getName(),
                    'license_business'=>$items->getLicense_Business(),
                    'date_license'=>GlobalLib::viewDate($items->getDate_License()),
                    'date_deadline'=>GlobalLib::viewDate($items->getDate_Deadline()),
                    'place_license'=>$items->getPlace_License(),
                    'address_office'=> $items->getAddress_Office(),
                    'address_office2'=> $items->getAddress_Office2(),
                    'address_branch' => $items->getAddress_Branch(),
                    'address_produce' => $items->getAddress_Produce(),
                    'address_produce1' => $items->getAddress_Produce1(),
                    'address_produce11' => $items->getAddress_Produce11(),
                    'address_produce111' => $items->getAddress_Produce111(),
                    'work_business'=>$items->getWork_Business(),
                    'phone'=>$items->getPhone(),
                    'boss_business'=>$items->getBoss_Business(),
                    'address_permanent'=> $items->getAddress_Permanent(),
                    'cellphone' => $items->getCellphone(),
                    'license_condition_business'=>$items->getLicense_Condition_Business(),
                    'date_license_condition_business'=>GlobalLib::viewDate($items->getDate_License_Condition_Business()),
                    'master_items_limit_id'=>GlobalLib::getName('master_items_limit',$items->getMaster_Items_Limit_Id(),'name'),
                    'master_items_condition_id'=>GlobalLib::getName('master_items_condition',$items->getMaster_Items_Condition_Id(),'name'),
                    'master_province'=>GlobalLib::getName('master_province',$items->getMaster_Province_Id(),'name'),
                    'master_district'=>GlobalLib::getName('master_district',$items->getMaster_District_Id(),'name'),
                    'master_ward'=>GlobalLib::getName('master_ward',$items->getMaster_Ward_Id(),'name'),
                    'master_business_type_id'=>GlobalLib::getName('master_business_type',$items->getMaster_Business_Type_Id(),'name'),
                    'master_business_size_id'=>GlobalLib::getName('master_business_size',$items->getMaster_Business_Size_Id(),'name'),
                    'date_check'=>  GlobalLib::viewDate($items->getDate_Check()),
                    'type_business'=>$items->getType_Business(),
                    'order'=>$items->getOrder(),
                    'status'=>$items->getStatus(),
                    'comment'=>$items->getComment()

                );
            }
            echo json_encode($menber);
            exit();
        }
}
