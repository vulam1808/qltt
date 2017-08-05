<?php
include_once APPLICATION_PATH . "/models/MasterWard.php";
include_once APPLICATION_PATH . "/models/MasterProvince.php";
include_once APPLICATION_PATH . "/models/MasterDistrict.php";
class Master_MasterWardController extends Zend_Controller_Action {

    public function init() {
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->model = new Model_MasterWard();
        $this->modelMapper = new Model_MasterWardMapper(); 
        $this->modelDistrict = new Model_MasterDistrict();
        $this->modelDistrictMapper = new Model_MasterDistrictMapper(); 
    }  
    public function indexAction(){
    }
    
    public function addAction() {
        $this->view->provinceHTML = GlobalLib::getComboByProvince('master_province_id', 'master_province', 'id', 'name', 0, false, 'form-control', '', '', '', 'onchange="getDistrictWithProvince(\'' . $this->aConfig["site"]["url"] .'master/service/index'. '\')"');
        $this->view->districtHTML = GlobalLib::getComboByDistrict('master_district_id', 'master_district', 'id', 'name', 0, false, 'form-control', '', 'where master_province_id=0', '', '');
        if ($this->getRequest()->isPost()) {   
            $redirectUrl = $this->aConfig["site"]["url"] . "master/masterward/list";
            if (isset($_POST["id"])) {
                $this->model->setId($_POST["id"]);
            }        
            if (isset($_POST["code_ward"])) {
                $this->model->setCode($_POST["code_ward"]);
            }
            if (isset($_POST["name_ward"])) {
                $this->model->setName($_POST["name_ward"]);
            }
            if (isset($_POST["comment"])) {
                $this->model->setComment($_POST["comment"]);
            }        
            if (isset($_POST["master_district_id"])) {
                $this->model->setMaster_district_Id($_POST["master_district_id"]);
            }
        
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item = $this->model;
    }
    public function editAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."master/masterward/list";
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
            $getId=$this->model->getId();
            $getDistrictId=$this->model->getMaster_district_Id();
        $this->modelDistrictMapper->find($getDistrictId,$this->modelDistrict);
            $getProvinceId=$this->modelDistrict->getMaster_province_Id();
        if(empty($getId)){
             $this->_redirect($redirectUrl);
        }
           $this->view->provinceHTML = GlobalLib::getComboByProvince('master_province_id', 'master_province', 'id', 'name', $getProvinceId, false, 'form-control', '', '', '', 'onchange="getDistrictWithProvince(\'' . $this->aConfig["site"]["url"] . '\')"');
           $this->view->districtHTML = GlobalLib::getComboByDistrict('master_district_id', 'master_district', 'id', 'name',  $getDistrictId, false, 'form-control', '', 'where master_province_id='.$getProvinceId.'', '','Xin Chờ Trong Giây Lát\');"');
        if ($this->getRequest()->isPost()) {   
            $redirectUrl = $this->aConfig["site"]["url"] . "master/masterward/list";
            if (isset($_POST["id"])) {
                $this->model->setId1($_POST["id"]);
            }      
            if (isset($_POST["code_ward"])) {
                $this->model->setCode($_POST["code_ward"]);
            }
            if (isset($_POST["name_ward"])) {
                $this->model->setName($_POST["name_ward"]);
            }
            if (isset($_POST["master_district_id"])) {
                $this->model->setMaster_district_Id($_POST["master_district_id"]);
            }
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item = $this->model;
      
    }    
    public function listAction(){
        $this->view->controller = $this;
        $this->view->item=$this->modelMapper->fetchAll();
    }    
    
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapper->fetchAll() as $items ) {
            $menber[]=array(
                'id'=>$items->getId(), 
                'code'=>$items->getCode(),
                'name'=>$items->getName(),
                'district_id'=> GlobalLib::getName('master_district',$items->getMaster_district_Id(),'name'),
                'district_id_province'=>GlobalLib::getName('master_province', GlobalLib::getName('master_district',$items->getMaster_district_Id(),'master_province_id'),'name'),
                'status' =>$items->getStatus(),
                'order'=>$items->getOrder()
            );
        }
        echo json_encode($menber);
        exit();
    }
    
    public function getdistrictAction(){
          $this->_helper->layout()->disableLayout();
                $districtHTML = '<select name="dictrict_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $province_id = $this->_getParam("province_id", "");
                    if (is_numeric($province_id)) {
                        $districtHTML = GlobalLib::getCombo('district_id', 'district', 'id', 'name', 0, false, 'where province_id=' . $province_id);
                    }
                }
                $districtHTML = $districtHTML;
                echo '[{"html":\'' . $districtHTML . '\'}]';
                exit;
    }
    
    public  function confirmdeleteAction()
    {
        $id = $this->_getParam("id","0");
        $count = 0;
        foreach($this->AgentmodelMapper->fetchAll() as $item)
        {
            if($item->getDistrict_Id()==$id) $count= $count+1;
        }
        echo $count;
        exit();
    }

    public function deleteAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."master/masterward/list";               
        $this->modelMapper->deleteWard($id);
        $this->_redirect($redirectUrl);
    }
    public function checkwardcodeAction(){
          $this->_helper->layout()->disableLayout();
         if($this->_request->isPost()){
             $ward_code= $this->_getParam("ward_code","");
             $id= $this->modelMapper->findidbycode($ward_code);
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
    public function checkwardnameAction(){
        $this->_helper->layout()->disableLayout();
        if($this->_request->isPost()){
            $ward_name=$this->_getParam("ward_name","");
            $id=$this->modelMapper->findidbyname($ward_name);
            if($id !=0){
                 $menber[]=array(
                     'code'=>1,
                     'message'=>'Tên tỉnh đã tồn tại.Vui lòng kiểm tra và nhập lại'
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
