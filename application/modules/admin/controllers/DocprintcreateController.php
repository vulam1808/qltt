<?php
include APPLICATION_PATH . "/models/Doc_Print_Create.php";
include APPLICATION_PATH . "/models/Doc_Print_Allocation.php";
include APPLICATION_PATH . "/models/Master_Print.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_DocPrintCreateController extends Zend_Controller_Action{
    protected static $_ngay='';
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Doc_Print_CreateMapper();
        $this->model= new Model_Doc_Print_Create();
        $this->modelDocPrintAllocation= new Model_Doc_Print_Allocation();
        $this->modelMapperDocPrintAllocation = new Model_Doc_Print_AllocationMapper();
        $this->modelMasterPrintMapper= new Model_Master_PrintMapper();
        $this->modelMasterPrint= new Model_Master_Print();
    }
    public function taAction(){
        $this->modelMapper->checkserialpayment(3,1,"1-18","19");
    }

    public function indexAction(){  
        
    }
    //cho ra quyen vừa mói tạo
    public function coefficientdacoAction(){
          if($this->getRequest()->isPost()){   
              $id_master_print= $this->_getParam("id_master_print","");
//              $id_master_print = '2';
              $idmax=$this->modelMapper->maxcoefficient('master_print_id',$id_master_print);
              $this->modelMapper->find($idmax,$this->model);
              $coefficientdanhap=$this->model->getCoefficient();
              $getMaster_Print_Id = $this->model->getMaster_Print_Id();
              $getSerial = $this->model->getSerial();
              $getSerial_Recovery = $this->model->getSerial_Recovery();
              $menber[]=array(
                     'coefficientdanhap'=>$coefficientdanhap,
                     'name_print'=>  GlobalLib::getName('master_print', $id_master_print, 'name'),
                     'serial'=> $getSerial,
               );
              echo json_encode($menber);                            
              exit();
          }
    }
    //kiem tra so quyen nhap vao dung khong
    public function checkcoefficientAction(){
        if($this->getRequest()->isPost()){
            $string_coefficient = $this->_getParam("coefficient","");
            $master_print_id = $this->_getParam("master_print_id","");
//            $string_coefficient="1ddf0,9";
//            $master_print_id = "20";
            $array_coefficient_exist = array();$i=0;
            $array_coefficient_new = array();$j=0;
            $array_coefficient_error = array();$k=0;
            $flag = 0;
            //tao ra danh sach coefficient da co trong CSDL
            foreach ($this->modelMapper->arraycoefficient($master_print_id) as $items ) {
               $array_coefficient_exist[$i++]=(int)$items->getCoefficient();
            }
            //tao ra mang chua coefficient chuan bi nhap vao CSDL
            $array_coefficient_new = explode(",", $string_coefficient);
            //kiem tra khong cho trung voi nhau(va thong bao ra loi nhung an chi da ton tai)
            for($i =0;$i < count($array_coefficient_new);$i++){
                 if(is_numeric($array_coefficient_new[$i])==FALSE){
                        $array_coefficient_error[$k++]="ktu;".$array_coefficient_new[$i];
                        $flag = 1;break;
                    }
                for($j=0;$j<count($array_coefficient_exist);$j++){
                    //kiem tra xem so quyen nhap vao phai la so
                   
                    if($array_coefficient_new[$i] == $array_coefficient_exist[$j]){
                        $array_coefficient_error[$k++]="ttai;".$array_coefficient_new[$i];
                        $flag = 1;break;
                    }
                }
            }
            //kiem tra so quyen them vao phai theo thu tu tang dan
            if($flag == 0){
                for($i=1;$i<count($array_coefficient_new);$i++){
                    if(is_numeric($array_coefficient_new[$i])== TRUE){
                        if($array_coefficient_new[$i]!= $array_coefficient_new[$i-1]+1){
                            $array_coefficient_error[$k++]="ttu;".$array_coefficient_new[$i];
                            $flag = 1;break;
                        }
                    }
                }
            }
            if($flag !=0){
                 $menber[]=array(
                     'code'=>1,
                     'error'=>$array_coefficient_error,
                     'message'=>'Mã lỗi xảy ra.'
                     );  
             } else {
                  $menber[]=array(
                     'code'=>0,
                     'error'=>$array_coefficient_error,
                     'message'=>''
                      );  
             }
             echo json_encode($menber);
             exit();
        }
    }
    //kiem tra serial nhap vao tuong ung voi tung quyen
    public function checkserialnewAction() {
         if($this->getRequest()->isPost()){  
             $id_master_print = $this->_getParam("id_master_print","");
             $coefficient = $this->_getParam("coefficient","");
             $serial_new = $this->_getParam("serial","");
//             $coefficient ="3"; $serial_new = "70-u0";$id_master_print = 20;
             $array_coefficient = explode(",", $coefficient);
             $flag =0;$j=0;$n=0;$n1=0;$n2=0;
             $array_error = array();
             $tam = explode(",", $serial_new);
             $array_d = array();
             $array_c = array();             
             foreach ($tam as $value){
                 $arr_tam = explode("-", $value);
                 $array_d[$n1++]=$arr_tam[0];
                 $array_c[$n2++]=$arr_tam[1];
             }
             $serialmax = $this->modelMapper->serialmaxcreate($id_master_print);
             //kiem tra 
             //kiem tra khong cho serial nhap vao la ky tu
             for($i = 0;$i<count($array_c);$i++){
                 if(is_numeric($array_d[$i])==FALSE){
                     $flag =1;$array_error[$n++] = "ktu;".$array_d[$i];
                 }
                 if(is_numeric($array_c[$i])==FALSE){
                     $flag =1;$array_error[$n++] = "ktu;".$array_c[$i];
                 }
             }
             //kiem tra serial trong day phai tang theo quy dinh
                for($i=0;$i<count($array_d);$i++){
                    if(is_numeric($array_d[$i])==TRUE){
                        $array_serial[$j++]=$array_d[$i];
                    }
                    if(is_numeric($array_c[$i])==TRUE){
                         $array_serial[$j++]=$array_c[$i];
                    }
                } 
                 for($i=0;$i<count($array_serial);$i++){
                    if($array_serial[$i]<=$serialmax){
                        $flag=1;$array_error[$n++]="ttai;".$array_serial[$i];
                    }
                }
             if($flag ==0){
                if(count($tam)!= count($array_coefficient)){
                 $flag =1;$array_error[$n++] = "thieu;";
                }  else {
                    for($i=2;$i<count($array_serial);$i++){
                        if($i%2==0){
                           if($array_serial[$i]<($array_serial[$i-1]+1)){
                                $flag =1;$array_error[$n++] = "ttai;".$array_serial[$i];
                           }
                        }
                    }
                }
             }
             if($flag !=0){
                 $menber[]=array(
                     'code'=>1,
                     'error'=>$array_error,
                     'message'=>'lỗi xảy ra.'
                     );  
             } else {
                  $menber[]=array(
                     'code'=>0,
                     'error'=>$array_error,
                     'message'=>''
                      );  
             }
             echo json_encode($menber);
             exit();
         }
    }
    public function savedocprintcreateAction(){
        $this->_helper->layout->disableLayout(); $stringidocprintcreate = "";
        if($this->getRequest()->isPost()){
           $arraydocprintcreate = $_POST['data'];
           $this->modelMapper->updatesorderDoc_Print_Create();
           for($i=0;$i<count($arraydocprintcreate);$i++){
             $this->model->setMaster_Print_Id($arraydocprintcreate[$i]['master_print_id']);
             $this->model->setInvoice_Number($arraydocprintcreate[$i]['invoice_number']);
             $this->model->setCreated_Date(GlobalLib::toMysqlDateString($arraydocprintcreate[$i]['created_date']));
             
             $this->model->setComment($arraydocprintcreate[$i]['comment']);
             $this->model->setCreated_By(GlobalLib::getLoginId());
             $this->model->setModified_Date(date("Y/m/d H:i:s"));
             $this->model->setModified_By(GlobalLib::getLoginId());
             $this->model->setIs_Delete(0); $this->model->setOrder(1);$this->model->setStatus("");
             //tao mang coefficient
             $array_coefficient = explode(",",$arraydocprintcreate[$i]['coefficient']);
             $array_serial = explode(",", $arraydocprintcreate[$i]['serial']);
                for($j=0;$j<count($array_coefficient);$j++){
                    $this->model->setCoefficient($array_coefficient[$j]);
                    $this->model->setSerial($array_serial[$j]);
                    $this->modelMapper->save($this->model);
                }
           }
        }
    }
    public function printcreateexportAction(){
        $this->_helper->layout->disableLayout();
            if($this->getRequest()->isPost()){
              $redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/list";
                if(strlen($_POST['ngaycapphat'])<0){
                    $ngaycapphat = date("Y/m/d H:i:s");
                }  else {
                     $ngaycapphat =GlobalLib::toMysqlDateString( $_POST['ngaycapphat']).' '.'00:00:00';//'2015-07-04 00:00:00';//
                }
                if(isset($_POST['sohd'])){
                    $sohd = $_POST['sohd'];
                }
            }
            $flag=1;
           $redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/list";
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 14;
            $stt=1;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('F1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('F1:J1');
            $objPHPExcel->getActiveSheet()->setCellValue('F2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('F2:J2');$objPHPExcel->getActiveSheet()->getStyle("F2:J2")->getFont()->setUnderline(true);
            $objPHPExcel->getActiveSheet()->getStyle('F1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->getStyle('F2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

            $objPHPExcel->getActiveSheet()->setCellValue('A4', "PHIẾU NHẬP ẤN CHỈ");$objPHPExcel->getActiveSheet()->mergeCells('A4:K4');
            $objPHPExcel->getActiveSheet()->getStyle("A4:K4")->getFont()->setBold(true);$objPHPExcel->getActiveSheet()->getStyle("A4:K4")->getFont()->setSize(14);
            $objPHPExcel->getActiveSheet()->setCellValue('A5', "Liên 1: Kế toán");$objPHPExcel->getActiveSheet()->mergeCells('A5:K5');
             $objPHPExcel->getActiveSheet()->getStyle('A4:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('I6', "Ký hiệu: PN-AC");$objPHPExcel->getActiveSheet()->mergeCells('I6:J6');
            $objPHPExcel->getActiveSheet()->setCellValue('I7', "Số:");$objPHPExcel->getActiveSheet()->mergeCells('I7:J7');
            $objPHPExcel->getActiveSheet()->setCellValue('A9', "Nhập ấn chỉ của:");$objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
            $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('C9', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('C9:J9');
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Theo hóa đơn (Phiếu xuất ấn chỉ) số:");$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
            $objPHPExcel->getActiveSheet()->setCellValue('C10', "……………………………….........................................");$objPHPExcel->getActiveSheet()->mergeCells('C10:F10');
            $objPHPExcel->getActiveSheet()->setCellValue('G10', "Ngày:");
            $objPHPExcel->getActiveSheet()->setCellValue('H10', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('H10:J10');
            $objPHPExcel->getActiveSheet()->setCellValue('A11', "Ngày nhập:");$objPHPExcel->getActiveSheet()->mergeCells('A11:B11');
            $objPHPExcel->getActiveSheet()->setCellValue('C11', "……………………………….......................................");$objPHPExcel->getActiveSheet()->mergeCells('C11:J11');
           
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A12', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A12:A13'); $objPHPExcel->getActiveSheet()->getStyle('A12:K13')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("A12:A13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A12:A13")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('B12', "Tên ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('B12:E13');
              $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
             $objPHPExcel->getActiveSheet()->getStyle("B12:E13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("B12:E13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('F12', "Số lượng");$objPHPExcel->getActiveSheet()->mergeCells('F12:F13');
             $objPHPExcel->getActiveSheet()->getStyle("F12:F13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("F12:F13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('G12', "Ký hiệu");$objPHPExcel->getActiveSheet()->mergeCells('G12:G13');
             $objPHPExcel->getActiveSheet()->getStyle("G12:G13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("G12:G13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('H12', "Từ quyển...tới quyển...");$objPHPExcel->getActiveSheet()->mergeCells('H12:I13');
             $objPHPExcel->getActiveSheet()->getStyle("H12:I13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("H12:I13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('J12', "Từ số...đến số...");$objPHPExcel->getActiveSheet()->mergeCells('J12:K13');
             $objPHPExcel->getActiveSheet()->getStyle("J12:K13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("J12:K13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
             if($flag == 1){
                 //xuat excel tren luoi
                $ngayn = $ngaycapphat;
                foreach ($this->modelMapper->masterprint_invoice_number_date1($sohd,$ngayn) as $value){
                    
                    $master_print_id = $value->getMaster_Print_Id();                
                     $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount, $stt)->getAlignment()->applyFromArray($style_alignment);
                     $objPHPExcel->getActiveSheet()->mergeCells('B' . $rowCount.':'.'E' . $rowCount);               
                     $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'name'));
                      $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'E' . $rowCount)->getAlignment()->applyFromArray($style_alignmentleft);
                              //
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'K' . $rowCount)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(30);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);

                   ///
//                     $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'E' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                     $objPHPExcel->getActiveSheet()->setCellValue('C11', GlobalLib::viewDate($ngayn));$objPHPExcel->getActiveSheet()->mergeCells('C11:J11');
                     $objPHPExcel->getActiveSheet()->setCellValue('C10', $sohd);$objPHPExcel->getActiveSheet()->mergeCells('C10:F10');
                     //lay danh sach tu quyen toi quyen 
                     $count_quyenanchi_list =0;$string_coefficient_list='';
                     foreach ($this->modelMapper->array_allcoefficient1($ngayn,$master_print_id,$sohd)as $valuess ){
                         $count_quyenanchi_list++;
                         if($string_coefficient_list==''){
                             $string_coefficient_list = $valuess->getCoefficient();
                         }else
                         $string_coefficient_list = $string_coefficient_list.','.$valuess->getCoefficient();
                     }
                     $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'code')); 
                     $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $count_quyenanchi_list); 
                     $objPHPExcel->getActiveSheet()->mergeCells('H' . $rowCount.':'.'I' . $rowCount); 
                     $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, $string_coefficient_list);
                     $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':'.'I' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                    //lay day serial theo ngay an chi va theo hoa don nhap vao\
                     $string_serial_list = '';
                     foreach ($this->modelMapper->array_allserial1($ngayn,$master_print_id,$sohd) as $values) {
                          if($string_serial_list==''){
                                if($values->getSerial_Recovery()!=""){
                                    $string_serial_list=$values->getSerial_Recovery();
                                }  else {
                                    $string_serial_list =$values->getSerial();
                                }
                        }  else {
                                if($values->getSerial_Recovery()!=""){
                                    $string_serial_list=$string_serial_list.','.$values->getSerial_Recovery();
                                }  else {
                                    $string_serial_list =$string_serial_list.','.$values->getSerial();
                                }
                             
                        }  
                     }
                    $objPHPExcel->getActiveSheet()->mergeCells('J' . $rowCount.':'.'K' . $rowCount);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount, $string_serial_list); 
                    $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $rowCount++;
                     $stt++;
                    }
                }
//                else {
//               // thuc hien xuat du lieu ra file excel
//                foreach ($this->modelMapper->arraymasterprint() as $value) {
//                    $string_serial = '';$string_coefficient='';
//                    //lay ra chuoi serial
//                    foreach ($this->modelMapper->arrayserialmasterprintdate($value->getMaster_Print_Id())as $values ){
//                        if($string_serial==''){
//                            $string_serial=$values->getSerial();
//                        }else
//                        $string_serial = $string_serial.','.$values->getSerial();
//                    }
//                    //lay ra chuoi Coefficient
//                    $count_quyenanchi =0;
//                    foreach ($this->modelMapper->arraycoefficientmasterprintdate($value->getMaster_Print_Id())as $valuess ){
//                        $count_quyenanchi++;
//                        if($string_coefficient==''){
//                            $string_coefficient = $valuess->getCoefficient();
//                        }else
//                        $string_coefficient = $string_coefficient.','.$valuess->getCoefficient();
//                    }
//                    foreach ($this->modelMapper->fetchprintserialdate($value->getMaster_Print_Id()) as $item) {
//                        $id = $item->getId();
//                        $invoice_number=$item->getInvoice_Number();
//                        $master_print_id=$item ->getMaster_Print_Id();
//                        $coefficient =$item->getCoefficient();
//                        $serial = $item->getSerial();
//                        $created_date   =$item->getCreated_Date();    
//                    }  
//                    //lay ra chuoi so quyen
//                   $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);
//                   $objPHPExcel->getActiveSheet()->mergeCells('B' . $rowCount.':'.'E' . $rowCount);               
//                   $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'name'));
//                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'E' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
//                   $objPHPExcel->getActiveSheet()->setCellValue('C11', GlobalLib::viewDate($created_date));$objPHPExcel->getActiveSheet()->mergeCells('C11:J11');
//                   $objPHPExcel->getActiveSheet()->setCellValue('E10', $invoice_number);$objPHPExcel->getActiveSheet()->mergeCells('E10:F10');
//                   $objPHPExcel->getActiveSheet()->mergeCells('H' . $rowCount.':'.'I' . $rowCount);
//                   $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $count_quyenanchi); 
//                   $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'code')); 
//                   $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, $string_coefficient);
//                   $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':'.'I' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
//                    $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':'.'I' . $rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
//                   $objPHPExcel->getActiveSheet()->mergeCells('J' . $rowCount.':'.'K' . $rowCount);
//                   $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount, $string_serial); 
//                  
//                   //
//                   
//                    $objPHPExcel->getActiveSheet()->getStyle('A12:A'. $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                    $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount.':'.'K' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
//                   $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//                   $rowCount++;
//                   $stt++;
//                }
//            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,"Người giao ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'B'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount,"Thủ kho");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':'.'E'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,"Kế toán");$objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':'.'H'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount,"Thủ trưởng đơn vị");$objPHPExcel->getActiveSheet()->mergeCells('I'.$rowCount.':'.'K'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getFont()->setBold(true);
            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'B'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':'.'E'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':'.'H'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('I'.$rowCount.':'.'K'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getFont()->setItalic(true);
            $rowCount++;
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle("A1:A1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("F1:F1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A1:L'.$rowCount)->getFont()->setName('Times New Roman');
//            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle("A3:K" . $rowCount)->getAlignment()->applyFromArray($style_alignment);
            //tên file excel
            $filename='PhieuNhapAnChi'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
//            $this->_redirect($redirectUrl);   
    } 
     //xuat danh sach an chi da thu hoi ra excel
    public function exportdocprintcreate($ngay,$flag1,$sohd) {
           
           $flag=$flag1;
           $redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/list";
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 14;
            $stt=1;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('F1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('F1:J1');
            $objPHPExcel->getActiveSheet()->setCellValue('F2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('F2:J2');$objPHPExcel->getActiveSheet()->getStyle("F2:J2")->getFont()->setUnderline(true);
            $objPHPExcel->getActiveSheet()->getStyle('F1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->getStyle('F2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

            $objPHPExcel->getActiveSheet()->setCellValue('A4', "PHIẾU NHẬP ẤN CHỈ");$objPHPExcel->getActiveSheet()->mergeCells('A4:K4');
            $objPHPExcel->getActiveSheet()->getStyle("A4:K4")->getFont()->setBold(true);$objPHPExcel->getActiveSheet()->getStyle("A4:K4")->getFont()->setSize(14);
            $objPHPExcel->getActiveSheet()->setCellValue('A5', "Liên 1: Kế toán");$objPHPExcel->getActiveSheet()->mergeCells('A5:K5');
             $objPHPExcel->getActiveSheet()->getStyle('A4:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('I6', "Ký hiệu: PN-AC");$objPHPExcel->getActiveSheet()->mergeCells('I6:J6');
            $objPHPExcel->getActiveSheet()->setCellValue('I7', "Số:");$objPHPExcel->getActiveSheet()->mergeCells('I7:J7');
            $objPHPExcel->getActiveSheet()->setCellValue('A9', "Nhập ấn chỉ của:");$objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
            $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('C9', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('C9:J9');
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Theo hóa đơn (Phiếu xuất ấn chỉ) số:");$objPHPExcel->getActiveSheet()->mergeCells('A10:C10');
            $objPHPExcel->getActiveSheet()->setCellValue('D10', "……………………………….........................................");$objPHPExcel->getActiveSheet()->mergeCells('D10:F10');
            $objPHPExcel->getActiveSheet()->setCellValue('G10', "Ngày:");
            $objPHPExcel->getActiveSheet()->setCellValue('H10', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('H10:J10');
            $objPHPExcel->getActiveSheet()->setCellValue('A11', "Ngày nhập:");$objPHPExcel->getActiveSheet()->mergeCells('A11:C11');
            $objPHPExcel->getActiveSheet()->setCellValue('D11', "……………………………….......................................");$objPHPExcel->getActiveSheet()->mergeCells('D11:J11');
           
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A12', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A12:A13');$objPHPExcel->getActiveSheet()->getStyle('A12:K13')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("A12:A13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A12:A13")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('B12', "Tên ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('B12:E13');
              $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
             $objPHPExcel->getActiveSheet()->getStyle("B12:E13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("B12:E13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('F12', "Số lượng");$objPHPExcel->getActiveSheet()->mergeCells('F12:F13');
             $objPHPExcel->getActiveSheet()->getStyle("F12:F13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("F12:F13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('G12', "Ký hiệu");$objPHPExcel->getActiveSheet()->mergeCells('G12:G13');
             $objPHPExcel->getActiveSheet()->getStyle("G12:G13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("G12:G13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('H12', "Từ quyển...tới quyển...");$objPHPExcel->getActiveSheet()->mergeCells('H12:I13');
             $objPHPExcel->getActiveSheet()->getStyle("H12:I13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("H12:I13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('J12', "Từ số...đến số...");$objPHPExcel->getActiveSheet()->mergeCells('J12:K13');
             $objPHPExcel->getActiveSheet()->getStyle("J12:K13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("J12:K13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
             if($flag == 1){
                 //xuat excel tren luoi
                $ngayn = GlobalLib::toMysqlDateString($ngay).' '.'00:00:00';
                foreach ($this->modelMapper->masterprint_invoice_number_date($sohd,$ngayn) as $value){
                    
                     $master_print_id = $value->getMaster_Print_Id();                
                     $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount, $stt)->getAlignment()->applyFromArray($style_alignment);
                     $objPHPExcel->getActiveSheet()->mergeCells('B' . $rowCount.':'.'E' . $rowCount);               
                     $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'name'));
                      $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'E' . $rowCount)->getAlignment()->applyFromArray($style_alignmentleft);
                              //
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'K' . $rowCount)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(30);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);

                   ///
                    
//                    $master_print_id = $value->getMaster_Print_Id();                
//                     $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);
//                     $objPHPExcel->getActiveSheet()->mergeCells('B' . $rowCount.':'.'E' . $rowCount);               
//                     $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'name'));
//                     $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'E' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                     $objPHPExcel->getActiveSheet()->setCellValue('D11', GlobalLib::viewDate($ngayn));$objPHPExcel->getActiveSheet()->mergeCells('D11:H11');
                     $objPHPExcel->getActiveSheet()->setCellValue('D10', $sohd);$objPHPExcel->getActiveSheet()->mergeCells('D10:F10');
                     //lay danh sach tu quyen toi quyen 
                     $count_quyenanchi_list =0;$string_coefficient_list='';
                     foreach ($this->modelMapper->array_allcoefficient($ngayn,$master_print_id,$sohd)as $valuess ){
                         $count_quyenanchi_list++;
                         if($string_coefficient_list==''){
                             $string_coefficient_list = $valuess->getCoefficient();
                         }else
                         $string_coefficient_list = $string_coefficient_list.','.$valuess->getCoefficient();
                     }
                     $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'code')); 
                     $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $count_quyenanchi_list); 
                     $objPHPExcel->getActiveSheet()->mergeCells('H' . $rowCount.':'.'I' . $rowCount); 
                     $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, $string_coefficient_list);
                     $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':'.'I' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                    //lay day serial theo ngay an chi va theo hoa don nhap vao\
                     $string_serial_list = '';
                     foreach ($this->modelMapper->array_allserial($ngayn,$master_print_id,$sohd) as $values) {
                          
                        if($string_serial_list==''){
                                if($values->getSerial_Recovery()!=""){
                                    $string_serial_list=$values->getSerial_Recovery();
                                }  else {
                                    $string_serial_list =$values->getSerial();
                                }
                        }  else {
                                if($values->getSerial_Recovery()!=""){
                                    $string_serial_list=$string_serial_list.','.$values->getSerial_Recovery();
                                }  else {
                                    $string_serial_list =$string_serial_list.','.$values->getSerial();
                                }
                             
                        }  
                     }
                    $objPHPExcel->getActiveSheet()->mergeCells('J' . $rowCount.':'.'K' . $rowCount);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount, $string_serial_list); 
                    $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $rowCount++;
                     $stt++;
                    }
                }else {
               // thuc hien xuat du lieu ra file excel
                foreach ($this->modelMapper->arraymasterprint() as $value) {
                    $string_serial = '';$string_coefficient='';
                    //lay ra chuoi serial
                    foreach ($this->modelMapper->arrayserialmasterprintdate($value->getMaster_Print_Id())as $values ){
                        if($string_serial==''){
                            $string_serial=$values->getSerial();
                        }else
                        $string_serial = $string_serial.','.$values->getSerial();
                    }
                    //lay ra chuoi Coefficient
                    $count_quyenanchi =0;
                    foreach ($this->modelMapper->arraycoefficientmasterprintdate($value->getMaster_Print_Id())as $valuess ){
                        $count_quyenanchi++;
                        if($string_coefficient==''){
                            $string_coefficient = $valuess->getCoefficient();
                        }else
                        $string_coefficient = $string_coefficient.','.$valuess->getCoefficient();
                    }
                    foreach ($this->modelMapper->fetchprintserialdate($value->getMaster_Print_Id()) as $item) {
                        $id = $item->getId();
                        $invoice_number=$item->getInvoice_Number();
                        $master_print_id=$item ->getMaster_Print_Id();
                        $coefficient =$item->getCoefficient();
                        $serial = $item->getSerial();
                        $created_date   =$item->getCreated_Date();    
                    }  
                    //lay ra chuoi so quyen
                   $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);
                   $objPHPExcel->getActiveSheet()->mergeCells('B' . $rowCount.':'.'E' . $rowCount);               
                   $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'name'));
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'E' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
                   $objPHPExcel->getActiveSheet()->setCellValue('C11', GlobalLib::viewDate($created_date));$objPHPExcel->getActiveSheet()->mergeCells('C11:J11');
                   $objPHPExcel->getActiveSheet()->setCellValue('E10', $invoice_number);$objPHPExcel->getActiveSheet()->mergeCells('E10:F10');
                   $objPHPExcel->getActiveSheet()->mergeCells('H' . $rowCount.':'.'I' . $rowCount);
                   $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $count_quyenanchi); 
                   $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'code')); 
                   $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, $string_coefficient);
                   $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':'.'I' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':'.'I' . $rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
                   $objPHPExcel->getActiveSheet()->mergeCells('J' . $rowCount.':'.'K' . $rowCount);
                   $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount, $string_serial); 
                  
                   //
                   
                    $objPHPExcel->getActiveSheet()->getStyle('A12:A'. $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount.':'.'K' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
                   $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                   $rowCount++;
                   $stt++;
                }
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,"Người giao ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'B'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount,"Thủ kho");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':'.'E'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,"Kế toán");$objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':'.'H'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount,"Thủ trưởng đơn vị");$objPHPExcel->getActiveSheet()->mergeCells('I'.$rowCount.':'.'K'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getFont()->setBold(true);
            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'B'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':'.'E'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':'.'H'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('I'.$rowCount.':'.'K'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getFont()->setItalic(true);
            $rowCount++;
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle("A1:A1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("F1:F1")->applyFromArray($styleArray);            
            $objPHPExcel->getActiveSheet()->getStyle('A1:L'.$rowCount)->getFont()->setName('Times New Roman');
            $filename='PhieuNhapAnChi'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
//            $this->_redirect($redirectUrl);
    }   
    
    public function addAction(){
        if($this->getRequest()->isPost()){
            $this->_helper->layout->disableLayout();
             $ngay = $_POST['ngaycapphat'];
             $sohd = $_POST['invoice_number'];
             $this->exportdocprintcreate($ngay,1,$sohd); 
              $redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/list";
            $this->_redirect($redirectUrl);
            
        }
        $this->view->item=$this->model;
    }
   
    public function listexportAction(){
        $this->_helper->layout->disableLayout();
        $ngay2=$this->_getParam("ngay","");
        $sohd2=$this->_getParam("sohd","");
        $id = $this->_getParam("idlist","");
        $flag = 0;
        if($ngay2==""){
            $flag = 0;
        }  else {
            $flag = 1;
        }
        $this->exportdocprintcreate($ngay2,1,$sohd2,$id); 
    }
    public function listAction(){ 
        if($this->getRequest()->isPost()){
            $this->_helper->layout->disableLayout();
            $data = $_POST['datafilter'];
            $ngay1=$data[0]['created_date'];
            $sohd1=$data[0]['invoice_number'];
            
//            $this->exportdocprintcreate($ngay,1,$sohd);
//            $redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/listexport/ngay/".$ngay."/sohd/".$sohd."";
             $redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/listexport/ngay/$ngay1/sohd/$sohd1";
            $this->_redirect($redirectUrl);
        }
    } 
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapper->fetchAll() as $items ) {
            //$master_print_id 
            if($items->getMaster_Print_Id()==""){
                $master_print_id ="";
            }  else {
                $master_print_name = GlobalLib::getName('master_print',$items->getMaster_Print_Id(),'name');
            }
            if($items->getMaster_Print_Id()==""){
                $master_print_code ="";
            }  else {
                $master_print_code = GlobalLib::getName('master_print',$items->getMaster_Print_Id(),'code');
            }
            if($items->getStatus()== ""){
                $status = 'Mới nhận';
            }elseif ($items->getStatus()=="RECOVERY") {
                $status = 'Thu hồi';
            }elseif ($items->getStatus()=="DONE"){
                $status = "Dùng hết";
            }  else {
                $status = "Đã cấp phát";
            }
            
            if(($status == 'Mới nhận')||($status == 'Thu hồi')){
            $menber[]=array(
                'Id'=>$items->getId(),
                'invoice_number'=>$items->getInvoice_Number(),
                'coefficient'=>$items->getCoefficient(),
                'serial'=>$items->getSerial(),
                'master_print_id'=>$master_print_name,
                'code_master_print'=>$master_print_code,
                'created_date'=>  GlobalLib::viewDate($items->getCreated_Date()),
                'comment'=>$items->getComment(),
                'status'=>$status,
                'serial_recovery'=>$items->getSerial_Recovery()
            );
            }
        }
        echo json_encode($menber);
        exit();
    } 
   
    public  function confirmdeleteAction()
    {
        if($this->getRequest()->isPost()){
            $count =0;
           $id_doc_print_create = $this->_getParam("id","");
//           $id_doc_print_create = '56';
           $redirectUrl=$this->aConfig["site"]["url"]."admin/docprintcreate/list";      
           $this->modelMapper->find($id_doc_print_create,$this->model);
           $getSerial = $this->model->getSerial();
           if(empty($getSerial)){
                $this->_redirect($redirectUrl);
           }
           $id_doc_print_allocation = $this->modelMapperDocPrintAllocation->findidbyname('doc_print_create_id',$id_doc_print_create);
           if($id_doc_print_allocation!=0){
               $count =1;
           }
            echo json_encode($count);                            
            exit();
        }
        
    }
    public function deleteAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/docprintcreate/list";               
        $this->modelMapper->deleteDoc_Print_Create($id);
        $this->_redirect($redirectUrl);
    }    
    
}
