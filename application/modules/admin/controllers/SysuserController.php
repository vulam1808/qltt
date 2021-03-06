<?php
include APPLICATION_PATH . "/models/Sys_User.php";
include_once  APPLICATION_PATH."/models/SysDepartments.php"; 
include_once  APPLICATION_PATH."/models/Doc_Print_Allocation.php"; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_SysUserController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Sys_UserMapper();
        $this->model= new Model_Sys_User(); 
        $this->modelDepartment = new Model_SysDepartments();
        $this->modelMapperDepartment = new Model_SysDepartmentsMapper();
         $this->modelPrintAllocation = new Model_Doc_Print_Allocation();
        $this->modelMapperPrintAllocation = new Model_Doc_Print_AllocationMapper();
    }
    public function indexAction(){       
    }
    public function editpassAction(){
        $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysusergroup/list";
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
         $this->view->item=$this->model;
    }

    public function addgroupAction(){
        $this->view->itemdepartment= $this->modelDepartment;
         $redirectUrl=$this->aConfig["site"]["url"]."admin/sysusergroup/list";
         if($this->getRequest()->isPost()){
            $id = $_POST["sys_user_id"];
            if(empty($id)){
                $this->_redirect($redirectUrl);
            }
            if(strlen($_POST["sys_user_id"])>0){
               $string_id = $_POST["id_user"];
            }
            $array_id = explode(",", $string_id);
            foreach ($array_id as $value) {
                $this->modelMapper->find($value,$this->model);
                $getId=$this->model->getId();
                if(empty($getId)){
                     $this->_redirect($redirectUrl);
                }
                if(strlen($_POST["sys_user_group_id"])>0){
                    $this->model->setSys_User_Group_Id($_POST["sys_user_group_id"]);
                }   
                $this->model->setModified_Date(date("Y/m/d H:i:s"));
                $this->model->setModified_By(GlobalLib::getLoginId());
                $this->model->setId($value);
                $this->modelMapper->save($this->model);
            }
            $this->_redirect($redirectUrl);
        }     
        $this->view->item= $this->model;
    }
    public function editgroupAction(){
        $this->view->itemdepartment= $this->modelDepartment;
         $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysusergroup/list";
         
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        $this->view->id = $getId;
        if(empty($getId)){
            $this->_redirect($redirectUrl);
        }
        if($this->getRequest()->isPost()){
            $id = $_POST["sys_user_id"];
            if(empty($id)){
                $this->_redirect($redirectUrl);
            }
            if(strlen($_POST["sys_user_id"])>0){
               $string_id = $_POST["id_user"];
            }
            $array_id = explode(",", $string_id);
            foreach ($array_id as $value) {
                $this->modelMapper->find($value,$this->model);
                $getId=$this->model->getId();
                if(empty($getId)){
                     $this->_redirect($redirectUrl);
                }
                if(strlen($_POST["sys_user_group_id"])>0){
                    $this->model->setSys_User_Group_Id($_POST["sys_user_group_id"]);
                }   
                $this->model->setModified_Date(date("Y/m/d H:i:s"));
                $this->model->setModified_By(GlobalLib::getLoginId());
                $this->model->setId($value);
                $this->modelMapper->save($this->model);
            }
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }
    public function addAction() {
        $this->view->itemdepartment= $this->modelDepartment;
        $this->view->provinceHTML = GlobalLib::getComboByProvince('master_province_id', 'master_province', 'id', 'name', 0, false, 'form-control', '', '', '', 'onchange="getDistrictWithProvince(\'' . $this->aConfig["site"]["url"] .'admin/service/index'. '\')"');
        $this->view->districtHTML = GlobalLib::getComboByDistrict('master_district_id', 'master_district', 'id', 'name', 0, false, 'form-control', '', 'where master_province_id=0', '', 'onchange="getWardWithDistrict(\''.$this->aConfig["site"]["url"].'admin/service/index'.'\')"');
        $this->view->wardHTML = GlobalLib::getComboByWard('master_ward_id', 'master_ward', 'id', 'name', 0, false, 'form-control', '', 'where master_district_id=0', '', '');
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/sysuser/list";            
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(strlen($_POST["username"])>0){
                $username = $_POST["username"];
            }  else {
                $username = "NULL";
            }
            $this->model->setUserName($username);
            
            if(strlen($_POST["password"])>0){
                $this->model->setPassword(md5($_POST["password"]));
            }  else {
                $this->model->setPassword("NULL");
            }
            if(strlen($_POST["cellphone"])>0){
                $this->model->setCellPhone($_POST["cellphone"]);
            }
            if(strlen($_POST["email"])>0){
                $this->model->setEmail($_POST["email"]);
            }
            if(strlen($_POST["first_name"])>0){
                $this->model->setFirst_Name($_POST["first_name"]);
            }
            if(strlen($_POST["last_name"])>0){
                $this->model->setLast_Name($_POST["last_name"]);
            }
            if(strlen($_POST["birthday"])<=0){
                $ngay_tao = date("Y/m/d H:i:s");
            }  else {
                $ngay_tao = GlobalLib::toMysqlDateString($_POST["birthday"]);
            }
            $this->model->setBirthday($ngay_tao);
            if(strlen($_POST["sys_department_id"])>0){
                $this->model->setSys_Department_Id($_POST["sys_department_id"]);
            }  else {
                 $this->model->setSys_Department_Id("");
            }
            if(strlen($_POST["master_province_id"])>0){
                $this->model->setMaster_Province_Id($_POST["master_province_id"]);
            }else{
                $this->model->setMaster_Province_Id("");
            }
            if(strlen($_POST["master_district_id"])>0){
                $this->model->setMaster_District_Id($_POST["master_district_id"]);
            }  else {
                $this->model->setMaster_District_Id("");
            }
            if(strlen($_POST["master_ward_id"])>0){
                $this->model->setMaster_Ward_Id($_POST["master_ward_id"]);
            }  else {
                $this->model->setMaster_Ward_Id("");
            }
            if(isset($_POST["is_leader"])){
                $is_leader=1;
            } else {
                $is_leader=0;
            }
            $this->model->setIs_Leader($is_leader);
            if(strlen($_POST["sys_user_group_id"])>0){
               $this->model->setSys_User_Group_Id($_POST["sys_user_group_id"]);
            }           
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            if(isset($_POST["status"])){
                $status=1;
            } else {
                $status=0;
            }
            $this->model->setStatus($status);
            if(isset($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            $this->model->setIs_Delete(date(0));
            $this->model->setCreated_Date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_Date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }     
           $this->view->item= $this->model;
    }
    public function popupAction(){
//        $id = $this->_getParam("id","");
//        $this->view->id=$id;
    }

    public function editAction(){
//        $popup=$this->_getParam("popup","");
        $id= $this->_getParam("id","");
//        if($popup == "oppent"){
//            $this->view->mo="opent";
//            $redirectUrl=$this->aConfig["site"]["url"]."admin/sysuser/popup/id/".$id;
//             $this->_redirect($redirectUrl);
//        }
         $this->view->itemdepartment= $this->modelDepartment;
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysuser/list";
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        $getPassword = $this->model->getPassword();
        if($this->model->getMaster_Province_Id()== null){
             $getProvinceId=0;
             $where = '';
        }  else {
             $getProvinceId=$this->model->getMaster_Province_Id();
             $where = '';
        }
        if($this->model->getMaster_District_Id()== null){
             $getDistrictId=0;
            $where1 = 'where master_province_id='.$getProvinceId.'';
        }  else {
              $getDistrictId=$this->model->getMaster_District_Id();
              $where1 = 'where master_province_id='.$getProvinceId.'';
        }
        if($this->model->getMaster_Ward_Id()== null){
             $getWardId=0;$where = 'where master_district_id='.$getDistrictId.'';
        }  else {
             $getWardId=$this->model->getMaster_Ward_Id(); $where = 'where master_district_id='.$getDistrictId.'';
        }
        
        $getid_sys_department = $this->model->getSys_Department_Id();
        $this->view->itemdepartment= $this->modelDepartment;
        
         $this->view->provinceHTML = GlobalLib::getComboByProvince('master_province_id', 'master_province', 'id', 'name', $getProvinceId, false, 'form-control', '', '', '', 'onchange="getDistrictWithProvince(\'' . $this->aConfig["site"]["url"] .'admin/service/index'. '\')"');
        $this->view->districtHTML = GlobalLib::getComboByDistrict('master_district_id', 'master_district', 'id', 'name', $getDistrictId, false, 'form-control', '', $where1, '', 'onchange="getWardWithDistrict(\''.$this->aConfig["site"]["url"].'admin/service/index'.'\')"');
        $this->view->wardHTML = GlobalLib::getComboByWard('master_ward_id', 'master_ward', 'id', 'name', $getWardId, false, 'form-control', '', $where, '', '');
        
//        $this->view->provinceHTML = GlobalLib::getComboByProvince('master_province_id', 'master_province', 'id', 'name', $getProvinceId, false, 'form-control', '', '', '', 'onchange="getDistrict1(\'' . $this->aConfig["site"]["url"] . 'admin/service/index\',$(\'#master_province_id\').val(),\'master_district_id\',\'Xin Chờ Trong Giây Lát\');"');
//        $this->view->districtHTML = GlobalLib::getComboByDistrict('master_district_id', 'master_district', 'id', 'name',  $getDistrictId, false, 'form-control', '', 'where master_province_id=0', '','onchange="getWard1(\'' . $this->aConfig["site"]["url"] . 'admin/service/index\',$(\'#master_district_id\').val(),\'master_ward_id\',\'Xin Chờ Trong Giây Lát\');"');
//        $this->view->wardHTML = GlobalLib::getComboByWard('master_ward_id', 'master_ward', 'id', 'name',  $getWardId, false, 'form-control', '', 'where master_district_id=0', '','Xin Chờ Trong Giây Lát\');"');
        if(empty($getId)){
             $this->_redirect($redirectUrl);
        }
        if($this->getRequest()->isPost()){
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(strlen($_POST["username"])>0){
                $this->model->setUserName($_POST["username"]);
            }
            
            if(strlen($_POST["password"])>0){
                if($getPassword == $_POST["password"]){
                    $this->model->setPassword($_POST["password"]);
                }else{
                    $this->model->setPassword(md5($_POST["password"]));
                }
            }
            if(strlen($_POST["cellphone"])>0){
                $this->model->setCellPhone($_POST["cellphone"]);
            }
            if(strlen($_POST["email"])>0){
                $this->model->setEmail($_POST["email"]);
            }
            if(strlen($_POST["first_name"])>0){
                $this->model->setFirst_Name($_POST["first_name"]);
            }
            if(strlen($_POST["last_name"])>0){
                $this->model->setLast_Name($_POST["last_name"]);
            }
            if(strlen($_POST["birthday"])<=0){
                $ngay_tao = date("Y/m/d H:i:s");
            }  else {
                $ngay_tao = GlobalLib::toMysqlDateString($_POST["birthday"]);
            }
            $this->model->setBirthday($ngay_tao);
            if(strlen($_POST["sys_department_id"])>0){
                $this->model->setSys_Department_Id($_POST["sys_department_id"]);
            }
            if(strlen($_POST["master_province_id"])>0){
                $this->model->setMaster_Province_Id($_POST["master_province_id"]);
            }else{
                $this->model->setMaster_Province_Id("");
            }
            if(strlen($_POST["master_district_id"])>0){
                $this->model->setMaster_District_Id($_POST["master_district_id"]);
            }  else {
                $this->model->setMaster_District_Id("");
            }
            if(strlen($_POST["master_ward_id"])>0){
                $this->model->setMaster_Ward_Id($_POST["master_ward_id"]);
            }  else {
                $this->model->setMaster_Ward_Id("");
            }
            if(strlen($_POST["is_leader"])>0){
                $this->model->setIs_Leader($_POST["is_leader"]);
            }
             if(strlen($_POST["sys_user_group_id"])>0){
                $this->model->setSys_User_Group_Id($_POST["sys_user_group_id"]);
             }           
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            if(isset($_POST["status"])){
                $this->model->setStatus($_POST["status"]);
            }
             if(isset($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            
            $this->model->setCreated_Date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_Date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }        
        $this->view->item=$this->model;
    }
    
    public function listAction(){       
    } 
    //kiem tra truong phong
    public function checkisleaderAction(){
        $this->_helper->layout()->disableLayout();
        if($this->_request->isPost()){
            $sys_department = $this->_getParam("sys_department","");
//            $sys_department = '1';
            $id_sys_user = $this->modelMapper->findidbyisleader("sys_department_id",$sys_department);
            if($id_sys_user !=0){
                 $menber[]=array(
                     'code'=>1,
                     'message'=>'Phòng này đã có trưởng phòng rồi'
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
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        $null = $this->_getParam("where","");
        foreach ($this->modelMapper->fetchAlll($null) as $items ) {
            if($items->getSys_Department_Id()!=""){
                $sys_department_id=GlobalLib::getName('sys_department', $items->getSys_Department_Id(),'name');
            }else {
                $sys_department_id ="";
            }
            if($items->getSys_User_Group_Id()!=""){
                $sys_user_group_id = GlobalLib::getName('sys_user_group', $items->getSys_User_Group_Id(), 'group_name');
            }  else {
                $sys_user_group_id="";
            }
            $hovaten = $items->getFirst_Name().' '.$items->getLast_Name();
             $menber[]=array(
                'id'=>$items->getId(),
                'username'=>$items->getUsername(), 
                'hovaten'=>$hovaten, 
                'first_name'=>$items->getFirst_Name(),
                'last_name'=>$items->getLast_Name(),
                'email'=>$items->getEmail(),
                'cellphone'=>$items->getCellPhone(),
                'sys_department_id'=>$sys_department_id,
                'sys_user_group_id' =>$sys_user_group_id,
                'birthday' => GlobalLib::viewDate($items->getBirthday() ),
                'comment'=>$items->getComment(), 
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus()
            );
        }
        echo json_encode($menber);
        exit();
    }    
    public function servicefromsysdepartmentAction(){
        $this->_helper->layout->disableLayout();
        $sys_department_id=$this->_getParam("sys_department_id","");
        $menber = array();
        foreach ($this->modelMapper->fetchAllFromSysDeparments($sys_department_id) as $items ) {
           
             $menber[]=array(
                'id'=>$items->getId(),
                'username'=>$items->getUsername()              
            );
        }
        echo json_encode($menber);
        exit();
    }  
    public  function confirmdeleteAction()
    {
        if($this->getRequest()->isPost()){
           $count =0;
           $id_sys_user = $this->_getParam("id","");
           $redirectUrl=$this->aConfig["site"]["url"]."admin/sysuser/list";      
           $this->modelMapper->find($id_sys_user,$this->model);
           $id_sys_usern =  $this->model->getId();
           $doc_print_allocation_id=$this->modelMapperPrintAllocation->findidbyname('sys_user_id',$id_sys_usern);
           if(empty($id_sys_usern)){
                $this->_redirect($redirectUrl);
           }
           if($doc_print_allocation_id!=0){
               $count =1;
           }
           echo json_encode($count);                            
           exit();
        }
    }
    //Xóa
    public function deleteAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysuser/list";               
        $this->modelMapper->delete($id);
        $this->_redirect($redirectUrl);
    }
    //Đổi mật khẩu
    public function changepasswordAction() {
        $id= $this->_getParam("id","");                
        $password= $this->_getParam("password","");         
        $this->modelMapper->find($id,$this->model);
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysuser/edit/id/".$id;       
        if($this->getRequest()->isPost()){             
                $this->model->setPassword(md5($password));               
                $this->modelMapper->save($this->model);
            echo '[{"html":\'' . $redirectUrl . '\'}]';            
            exit();
        }
    }
    ///
     //Đổi mật khẩu
    public function changepassword1Action() {
        $id= $this->_getParam("id","");                
        $password= $this->_getParam("password","");         
        $this->modelMapper->find($id,$this->model);
        $redirectUrl=$this->aConfig["site"]["url"]."admin/sysuser/list";       
        if($this->getRequest()->isPost()){             
                $this->model->setPassword(md5($password));               
                $this->modelMapper->save($this->model);
            echo '[{"html":\'' . $redirectUrl . '\'}]';            
            exit();
        }
    }
    //Kiểm tra oldpassword 
     public function checkoldpasswordAction(){
          $this->_helper->layout()->disableLayout();
         if($this->_request->isPost()){
             $old_password=  $this->_getParam("pass","");
             $id= $this->modelMapper->findidbyname('password',md5($old_password));
             if($id !=0){
                 $menber[]=array(
                     'code'=>1,
                     'message'=>'Mã password này đã tồn tại.'
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
        $this->_helper->layout()->disableLayout();
        if($this->_request->isPost()){
            $username=$this->_getParam("username","");
            $id=$this->modelMapper->findidbyname('username',$username);
            if($id !=0){
                 $menber[]=array(
                     'code'=>1,
                     'message'=>'Tên đăng nhập và mật khẩu này đã tồn tại.Vui lòng kiểm tra và nhập lại'
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
    public function abAction() {
        $this->_helper->layout()->disableLayout();
        $filename = $this->aConfig["site"]["url"]."ab.txt";
      //  $this->view->filename = $filename;
      //  $filename = "C:/Users/BKC/Desktop/New folder/huongdan.docx";
        $fp = fopen($filename, "rb");
        header("Content-type: application/octet-stream");
        header("Content-length: " . filesize($filename));
        fpassthru($fp);
        fclose($fp);
        echo json_encode($fp);  
        exit();
    }
}

