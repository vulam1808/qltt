<?php
include_once APPLICATION_PATH . "/models/MasterProvince.php";
include_once APPLICATION_PATH . "/models/MasterDistrict.php";
include_once APPLICATION_PATH . "/models/MasterWard.php";
class Admin_MasterDistrictController extends Zend_Controller_Action {

    public function init() {
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->model = new Model_MasterDistrict();
        $this->modelMapper = new Model_MasterDistrictMapper();       
        $this->Wardmodelmapper = new Model_MasterWardMapper();
    }
    
    public function indexAction(){
    }
    
    public function addAction() {
        if ($this->getRequest()->isPost()) {   
            $redirectUrl = $this->aConfig["site"]["url"] . "admin/masterdistrict/list";
            if (isset($_POST["id"])) {
                $this->model->setId($_POST["id"]);
            }
            if (isset($_POST["district_code"])) {
                $this->model->setCode($_POST["district_code"]);
            }
            if (isset($_POST["name_district"])) {
                $this->model->setName($_POST["name_district"]);
            }
             if (isset($_POST["comment"])) {
                $this->model->setComment($_POST["comment"]);
            }
          
            if (isset($_POST["master_province_id"])) {
                $this->model->setMaster_province_Id($_POST["master_province_id"]);
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
        $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/masterdistrict/list";
        if(empty($id)){
            $this->_redirect($redirectUrl);
        }
        $this->modelMapper->find($id,$this->model);
        $getId=$this->model->getId();
        if(empty($getId)){
            $this->_redirect($redirectUrl);
        }
       if ($this->getRequest()->isPost()) {   
            $redirectUrl = $this->aConfig["site"]["url"] . "admin/masterdistrict/list";
            if (isset($_POST["id"])) {
                $this->model->setId($_POST["id"]);
            }
            if (isset($_POST["district_code"])) {
                $this->model->setCode($_POST["district_code"]);
            }
            if (isset($_POST["name_district"])) {
                $this->model->setName($_POST["name_district"]);
            }
            if (isset($_POST["comment"])) {
                $this->model->setComment($_POST["comment"]);
            }
          
            if (isset($_POST["master_province_id"])) {
                $this->model->setMaster_province_Id($_POST["master_province_id"]);
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
    public function listAction(){
        $this->view->controller = $this;
        $this->view->item=$this->modelMapper->fetchAll();
        $this->view->item=$this->model;
    }    
    
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapper->fetchAll() as $items ) {
            $menber[]=array(
                'Id'=>$items->getId(),
                'DistrictCode'=>$items->getCode(),
                'DistrictName'=>$items->getName(),
                'ProvinceName'=>GlobalLib::getName('master_province',$items->getMaster_province_Id(),'name'),
                'Order'=>$items->getOrder()
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
        foreach($this->Wardmodelmapper->fetchAll() as $item)
        {
            if($item->getMaster_District_Id()==$id) $count= $count+1;
        }
        echo $count;
        exit();
    }

    public function deleteAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/masterdistrict/list";               
        $this->modelMapper->deleteMasterDistrict($id);
        $this->_redirect($redirectUrl);
    }
      public function excelAction(){
        $this->_helper->layout->disableLayout();
       //  $redirectUrl=$this->aConfig["site"]["url"]."admin/district/add";
            
        if ($this->getRequest()->isPost()) {
             $array_colums;
            if(strlen($_POST["listcheck"])>0){
                //chuyen chuoi thanh mang
                 $string=$_POST["listcheck"];
                 $array_colums=  explode(';',$string);  
            }
            $objPHPExcel = new PHPExcel(); 
            $objWorkSheet = new PHPExcel_Worksheet();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 4;
            $stt=1;
            //tạo tên cho worksheet
            $objPHPExcel->getActiveSheet()->setTitle("Danh sách các quận huyện ");
            $objPHPExcel->getActiveSheet()->setCellValue('A3', "STT");
            //Tao cột hiển thị theo dữ liêu
            $_ST=["B3","C3","D3","E3","F3","G3","H3","I3","J3","K3","L3"];
            //bien chay
            $i=0;
            foreach ($array_colums as $value) {                
                switch ($value) {
                    case 'code':
                         $objPHPExcel->getActiveSheet()->setCellValue($_ST[$i++], "Mã Huyện");
                        break;
                    case 'name':
                          $objPHPExcel->getActiveSheet()->setCellValue($_ST[$i++], "Tên Huyện");
                        break;
                    case 'province_id':
                         $objPHPExcel->getActiveSheet()->setCellValue($_ST[$i++], "Tỉnh");
                        break;
                    case 'created':
                         $objPHPExcel->getActiveSheet()->setCellValue($_ST[$i++], "Ngày tạo");
                        break;
                    case 'created_by':
                         $objPHPExcel->getActiveSheet()->setCellValue($_ST[$i++], "Tạo bỡi");
                        break;
                    case 'modified':
                         $objPHPExcel->getActiveSheet()->setCellValue($_ST[$i++], "Ngày chỉnh sửa");
                        break;
                    case 'modified_by':
                         $objPHPExcel->getActiveSheet()->setCellValue($_ST[$i++], "Sửa bỡi");
                        break;
                    case 'order':
                        $objPHPExcel->getActiveSheet()->setCellValue($_ST[$i++], "Số XXXX");
                        break;
                    case 'status':
                        $objPHPExcel->getActiveSheet()->setCellValue($_ST[$i++], "Trạng thái");
                        break;
                    default:
                       // $objPHPExcel->getActiveSheet()->setCellValue($_ST, "");$_ST="A3";
                        break;
                }
              }   
          //Hiển thị dữ liệu theo cột đã chọn    
            $j=0;$k=0; 
            $whr;
          //Xuất với điều kiện Tên Huyện  
            if ((strlen($_POST["district_id"])>0)) {
                $whr = "where name = '".$_POST["district_id"]."'";
            }
          //Xuấtvới điều kiện Tên tỉnh  
            if (strlen($_POST["province_id"])>0) {
                $whr= "where province_id = '".$_POST["province_id"]."'";
            } 
          //Xuất với điều kiện Tên Huyện và Tên Tỉnh 
            if((strlen($_POST["province_id"])>0) && (strlen($_POST["name"])>0)){
                $whr ="where province_id = '".$_POST["province_id"]."' and name = '".$_POST["district_id"]."'";
            } 
          
            foreach ($this->modelMapper->fetchAll_REPORT($whr) as $items) {               
               $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);               
               $_ST1=["B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","X"];
                  $j=0;
                //  $t=["name","code"]; 
                   foreach ( $array_colums as $vl) {   
                        switch ($vl) {
                            case 'code':
                                  $objPHPExcel->getActiveSheet()->setCellValue( $_ST1[$j++] . $rowCount, $items->getCode());
                                break;
                            case 'name':
                                  $objPHPExcel->getActiveSheet()->setCellValue( $_ST1[$j++] . $rowCount, $items->getName());
                                break;
                            case 'province_id':
                                  $objPHPExcel->getActiveSheet()->setCellValue( $_ST1[$j++] . $rowCount,  GlobalLib::getName("province",$items->getProvince_Id(),"name") );
                                break;
                            case 'created':
                                  $objPHPExcel->getActiveSheet()->setCellValue( $_ST1[$j++] . $rowCount, $items->getCreated());
                                break;
                            case 'created_by':
                                  $objPHPExcel->getActiveSheet()->setCellValue( $_ST1[$j++] . $rowCount, $items->getCreated_By());
                                break;
                            case 'modified':
                                  $objPHPExcel->getActiveSheet()->setCellValue( $_ST1[$j++] . $rowCount, $items->getModified());
                                break;
                            case 'modified_by':
                                  $objPHPExcel->getActiveSheet()->setCellValue( $_ST1[$j++] . $rowCount, $items->getModified_By());
                                break;
                            case 'order':
                                  $objPHPExcel->getActiveSheet()->setCellValue($_ST1[$j++] . $rowCount, $items->getOrder());
                                  $objPHPExcel->getActiveSheet()->getStyle($_ST1[$j++].'4:'.$_ST1[$j++]. ($rowCount - 1))->getNumberFormat()->setFormatCode("dd-mm-yyyy");
                                break;
                            case 'status':
                                  $objPHPExcel->getActiveSheet()->setCellValue( $_ST1[$j++] . $rowCount, $items->getStatus());
                                break;
                            default:
                               // $objPHPExcel->getActiveSheet()->setCellValue($_ST, "");$_ST="A3";
                                break;
                        }
                   }
             
                $rowCount++;  $stt++;
            } 
            $objPHPExcel->getActiveSheetIndex(2);
            $objPHPExcel->getActiveSheet()->setTitle("tt");
//            ////     
            $objPHPExcel->getActiveSheet()->mergeCells('L3:Q3');
            $objPHPExcel->getActiveSheet()->mergeCells('A1:K2');
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "Danh sách quận huyện");
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A3:K" . $rowCount)->getAlignment()->applyFromArray($style_alignment);
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ),
                ),
            );
            $styledataArray = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '080808'),
                    'size' => 15,
                    'name' => 'Times New Roman'
            ));
            $styletitleArray=array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '080808'),
                    'size' => 10,
                    'name' => 'Times New Roman')
            );
           
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styledataArray);
            $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($styletitleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A3:K' . ($rowCount - 1))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F4:F'.($rowCount-1))->getNumberFormat()->setFormatCode('#,##0 ;#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('I4:I'.($rowCount-1))->getNumberFormat()->setFormatCode('#,##0;#,##0');
            //cho cột tự động dãn ra theo dữ liệu bên trong
            foreach (range('A', 'K') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }
            //tên file excel
            $filename='BaoCaoNhapXuat-Thang '.date('m-Y').'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            // $this->_redirect($redirectUrl);
            exit();
        }
        
    }
//xuất dữ liệu ra file excel
    public function exportAction() {
        $this->_helper->layout->disableLayout();
        if ($this->getRequest()->isPost()) {            
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 4;
            $stt=1;
            $objPHPExcel->getActiveSheet()->setCellValue('A3', "STT");
            $objPHPExcel->getActiveSheet()->setCellValue('B3', "Tên kho");
            $objPHPExcel->getActiveSheet()->setCellValue('C3', "Thủ kho");
            $objPHPExcel->getActiveSheet()->setCellValue('D3', "Người giao");
            $objPHPExcel->getActiveSheet()->setCellValue('E3', "Số chứng từ");
            $objPHPExcel->getActiveSheet()->setCellValue('F3', "Tên VT/HH");
            $objPHPExcel->getActiveSheet()->setCellValue('G3', "Đơn vị tính");
            $objPHPExcel->getActiveSheet()->setCellValue('H3', "Số lượng nhập");
            $objPHPExcel->getActiveSheet()->setCellValue('I3', "Đơn giá");
         ///
           foreach ($this->modelBCNKN->fetchAll_NKN() as $items) {               
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $items['tenkho']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $items['thukho']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, $items['mabpkh']);                 
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $items['soct']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $items['mavthh']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $items['dvt']);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowCount, $items['sl']);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowCount, $items['dg']);                      
                $rowCount++;
                $stt++;
            }
            ////           
            $objPHPExcel->getActiveSheet()->mergeCells('A1:K2');
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "Báo Cáo Nhập Kho Ngày");
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("A3:K" . $rowCount)->getAlignment()->applyFromArray($style_alignment);
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ),
                ),
            );
            $styledataArray = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '080808'),
                    'size' => 15,
                    'name' => 'Times New Roman'
            ));
            $styletitleArray=array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '080808'),
                    'size' => 10,
                    'name' => 'Times New Roman')
            );
            $objPHPExcel->getActiveSheet()->getStyle('E4:E'. ($rowCount - 1))->getNumberFormat()->setFormatCode("dd-mm-yyyy");
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styledataArray);
            $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($styletitleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A3:K' . ($rowCount - 1))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F4:F'.($rowCount-1))->getNumberFormat()->setFormatCode('#,##0 ;#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('I4:I'.($rowCount-1))->getNumberFormat()->setFormatCode('#,##0;#,##0');
            foreach (range('A', 'K') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }
            //tên file excel
            $filename='BaoCaoDaiLyCap1-Thang '.date('m-Y').'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
             //$redirectUrl=$this->aConfig["site"]["url"]."admin/district/list";
             //$this->_redirect($redirectUrl);
            exit();
        }
    }
    ///lay du lieu luu vao csdl
    public function importagentAction(){
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost()) {
            
            $mimes = array(
                '.xls',
                '.xlsx'
            );
            $rowBeginn;
            if(isset($_POST['rowbegin'])){
                $rowBeginn=$_POST['rowbegin'];
            }
            if (isset($_FILES['my_file'])) {
                $fileName = $_FILES['my_file']['name'];
                $fileTmp=$_FILES['my_file']['tmp_name'];
                $fileType = $_FILES['my_file']['type'];
                $fileError = $_FILES['my_file']['error'];
                $file_ext = strtolower(substr($fileName,strrpos($fileName,"."))); 
                $total = $this->import_users_from_xls($fileTmp,$rowBeginn);
                }
             $redirectUrl = $this->aConfig["site"]["url"] . "/admin/district/list";    
             $this->_redirect($redirectUrl);
            // exit();
            
        }
    }

    function import_users_from_xls($path_tmp_name,$rowBegin) {
        ini_set('memory_limit', '128M');
        ini_set('max_execution_time', 0);
        $total = 0;
        $total_user = 0;
        $inputFileType = PHPExcel_IOFactory::identify($path_tmp_name);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load($path_tmp_name);
        $test = array();
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highrow = $worksheet->getHighestRow();
            $highcolumn = $worksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highcolumn);
            for ($row = $rowBegin; $row <= $highrow; $row++) {
                $code = $worksheet->getCellByColumnAndRow(1, $row);
                //kiem tra ma trung. Neu trung thi hien thi thong bao,bo qua tuy chon theo nguoi dung hoac im lang bo qua                
                 $codeExist= $this->modelMapper->findidbycode(trim($code->getValue()));
                 if($codeExist!=0){
                     continue; 
                 } 
                //
                $name = $worksheet->getCellByColumnAndRow(2, $row);
                $province_id_name = $worksheet->getCellByColumnAndRow(3, $row);
                $province_id = GlobalLib::getId('province','code',$province_id_name->getValue(),'id');
                    $this->model->setCode(trim($code->getValue()));
                    $this->model->setName(trim($name->getValue()));
                    $this->model->setProvince_Id(trim($province_id));
                    $this->model->setCreated(date("Y/m/d H:i:s"));
                     //$user=GlobalLib::getUserLogin();
                    //$id= $user['id'];
                    $this->model->setCreated_By(GlobalLib::getLoginId());
                    $this->model->setModified(date("Y/m/d H:i:s"));
                    $this->model->setModified_By(GlobalLib::getLoginId());
                    $this->modelMapper->save($this->model);                   
                    $total_user++; 
                $total++;
            }
            //var_dump($test);exit();
        }
        return $total."-".$total_user;
    }
    

    public function checkdistrictcodeAction(){
         $this->_helper->layout()->disableLayout();
         if($this->_request->isPost()){
             $district_code= $this->_getParam("district_code","");
             $id= $this->modelMapper->findidbycode($district_code);
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
    public function checkdistrictnameAction(){
        $this->_helper->layout()->disableLayout();
        if($this->_request->isPost()){
            $district_name=$this->_getParam("district_name","");
            $id=$this->modelMapper->findidbyname($district_name);
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
