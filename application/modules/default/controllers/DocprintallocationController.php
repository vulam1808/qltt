<?php
include_once APPLICATION_PATH . "/models/Doc_Print_Allocation.php";
include_once APPLICATION_PATH."/models/Doc_Print_Create.php";
include_once APPLICATION_PATH."/models/Master_Print.php";
include_once APPLICATION_PATH."/models/Doc_Print_Handling.php";
include_once  APPLICATION_PATH."/models/SysDepartments.php"; 
include_once  APPLICATION_PATH."/models/Sys_User.php";
include_once APPLICATION_PATH."/models/Doc_Print_Payment.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class DocPrintAllocationController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Doc_Print_AllocationMapper();
        $this->model= new Model_Doc_Print_Allocation(); 
        $this->modelMapperDocPrintCreate = new Model_Doc_Print_CreateMapper();
        $this->modelDocPrintCreate = new Model_Doc_Print_Create();
        $this->modelMapperMasterPrint = new Model_Master_PrintMapper();
        $this->modelMasterPrint = new Model_Master_Print();
        $this->modelDocPrintHandling = new Model_Doc_Print_Handling();
        $this->modelMapperDocPrintHandling = new Model_Doc_Print_HandlingMapper();
        $this->modelDepartment = new Model_SysDepartments();
        $this->modelMapperDepartment = new Model_SysDepartmentsMapper();
        $this->modelUser = new Model_Sys_User();
        $this->modelMapperUser = new Model_Sys_UserMapper();
        $this->modelPrintPayment = new Model_Doc_Print_Payment();
        $this->modelMapperPrintPayment = new Model_Doc_Print_PaymentMapper();
    }
   
    public function indexAction(){       
    }
    public function nameprintAction(){
          if($this->getRequest()->isPost()){   
              $id_master_print= $this->_getParam("id_master_print","");           
              $menber[]=array(                     
                     'name_print'=>  GlobalLib::getName('master_print', $id_master_print, 'name')                     
               );
              echo json_encode($menber);                            
              exit();
          }
    }
    public function nameuserAction(){
          if($this->getRequest()->isPost()){   
              $id_sys_user= $this->_getParam("sys_user_id","");           
              $menber[]=array(                     
                     'name_user'=>  GlobalLib::getName('sys_user', $id_sys_user, 'first_name').' '. GlobalLib::getName('sys_user', $id_sys_user, 'last_name')                    
               );
              echo json_encode($menber);                            
              exit();
          }
    }
    public function namedepartmentAction(){
          if($this->getRequest()->isPost()){   
              $sys_department_id= $this->_getParam("sys_department_id","");           
              $menber[]=array(                     
                     'name_department'=>  GlobalLib::getName('sys_department', $sys_department_id, 'name')     
               );
              echo json_encode($menber);                            
              exit();
          }
    }
    public function nameprintcreateAction(){
          if($this->getRequest()->isPost()){   
              $doc_print_create_id= $this->_getParam("doc_print_create_id",""); 
              //mang id__doc_print_create
              $array_iddocprintcreate = explode(",", $doc_print_create_id);
              $string_name = "";
                for($i=0;$i<count($array_iddocprintcreate);$i++){
                    if($string_name==""){
                        $string_name = GlobalLib::getName('doc_print_create', $array_iddocprintcreate[$i], 'coefficient') ;
                    }  else {
                        $string_name = $string_name.','. GlobalLib::getName('doc_print_create', $array_iddocprintcreate[$i], 'coefficient');
                    }

                }
              $menber[]=array(                     
                     'name_printcreate'=>  $string_name     
               );
              echo json_encode($menber);                            
              exit();
          }
    }
    public function printallocationexportAction(){
        $this->_helper->layout->disableLayout();
            if($this->getRequest()->isPost()){
              $redirectUrl = $this->aConfig["site"]["url"]."default/docprintallocation/list";
                if(strlen($_POST['ngaycapphat'])<0){
                    $ngaycapphat = date("Y/m/d H:i:s");
                }  else {
                     $ngaycapphat =GlobalLib::toMysqlDateString( $_POST['ngaycapphat']).' '.'00:00:00';//'2015-07-04 00:00:00';//
                }
                if(strlen($_POST['sohd'])>0){
                    $sohd = $_POST['sohd'];
                }
                if(strlen($_POST['sys_department_id'])>0){
                    $sys_department_id = $_POST['sys_department_id'];
                }
                if(isset($_POST['sys_user_id'])){
                    $sys_user_id =$_POST['sys_user_id'];
                }
                //phong ban ngay cap
               
            }
            
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 15;
            $stt=1;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");
            $objPHPExcel->getActiveSheet()->setCellValue('G1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('G1:L1'); $objPHPExcel->getActiveSheet()->getStyle("G1:L1")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('G2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('G2:L2');$objPHPExcel->getActiveSheet()->getStyle("G2:L2")->getFont()->setUnderline(true);			
            $objPHPExcel->getActiveSheet()->getStyle("G1:L1")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->getStyle("G2:L2")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
             $objPHPExcel->getActiveSheet()->getStyle("A4:L5")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->setCellValue('A4', "PHIẾU XUẤT ẤN CHỈ");$objPHPExcel->getActiveSheet()->mergeCells('A4:L4');
             $objPHPExcel->getActiveSheet()->getStyle("A4:L4")->getFont()->setSize(14);
            $objPHPExcel->getActiveSheet()->getStyle("A4:L4")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('A5', "Liên 1: Kế toán");$objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
            $objPHPExcel->getActiveSheet()->setCellValue('I6', "Ký hiệu: PN-AC");$objPHPExcel->getActiveSheet()->mergeCells('I6:J6');
            $objPHPExcel->getActiveSheet()->setCellValue('I7', "Số:");$objPHPExcel->getActiveSheet()->mergeCells('I7:J7');
            $objPHPExcel->getActiveSheet()->setCellValue('A9', "Họ và tên người nhận ấn chỉ:");$objPHPExcel->getActiveSheet()->mergeCells('A9:D9');
            $objPHPExcel->getActiveSheet()->setCellValue('E9', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('E9:J9');
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Theo giấy giới thiệu số:");$objPHPExcel->getActiveSheet()->mergeCells('A10:D10');
            $objPHPExcel->getActiveSheet()->setCellValue('E10', "……………………………….........................................");$objPHPExcel->getActiveSheet()->mergeCells('E10:F10');
            $objPHPExcel->getActiveSheet()->setCellValue('G10', "Ngày:");
            $objPHPExcel->getActiveSheet()->setCellValue('H10', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('H10:J10');
            $objPHPExcel->getActiveSheet()->setCellValue('A11', "Kèm theo bảng kê đề nghị nhận số:");$objPHPExcel->getActiveSheet()->mergeCells('A11:D11');
            $objPHPExcel->getActiveSheet()->setCellValue('E11', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('E11:F11');
            $objPHPExcel->getActiveSheet()->setCellValue('G11', "Ngày:");
            $objPHPExcel->getActiveSheet()->setCellValue('H11', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('H11:J11');
             $objPHPExcel->getActiveSheet()->setCellValue('A12', "Ngày xuất ấn chỉ:");$objPHPExcel->getActiveSheet()->mergeCells('A12:D12');
              $objPHPExcel->getActiveSheet()->setCellValue('E12', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('E12:J12');
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A13', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A13:A14');
             $objPHPExcel->getActiveSheet()->getStyle("A13:A14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A13:A14")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('B13', "Tên ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('B13:E14');
             $objPHPExcel->getActiveSheet()->getStyle("B13:E14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("B13:E14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('F13', "Ký hiệu");$objPHPExcel->getActiveSheet()->mergeCells('F13:F14');
             $objPHPExcel->getActiveSheet()->getStyle("F13:F14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("F13:F14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('G13', "Số lượng");$objPHPExcel->getActiveSheet()->mergeCells('G13:G14');
             $objPHPExcel->getActiveSheet()->getStyle("G13:G14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("G13:G14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('H13', "Từ quyển...tới quyển...");$objPHPExcel->getActiveSheet()->mergeCells('H13:I14');
             $objPHPExcel->getActiveSheet()->getStyle("H13:I14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("H13:I14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('J13', "Từ số...tới số...");$objPHPExcel->getActiveSheet()->mergeCells('J13:K14');
             $objPHPExcel->getActiveSheet()->getStyle("J13:K14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("J13:K14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('L13', "Tổng");$objPHPExcel->getActiveSheet()->mergeCells('L13:L14');
             $objPHPExcel->getActiveSheet()->getStyle("L13:L14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("L13:L14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
             $objPHPExcel->getActiveSheet()->getStyle('A13:L14')->getFont()->setBold(true);
               // thuc hien xuat du lieu ra file excel
               $dateallocationmax=$ngaycapphat;
//               $id_doc_print_allocation=
               $getsysdepartmentid=$sys_department_id;
               $getsysuserid=$sys_user_id;
               $getrequestnumber=$sohd;        
             //lay ra ngay lon nhat trong bang csdl
//            $dateallocationmax= $this->modelMapper->maxdateallocation();
//            $id_doc_print_allocation =  $this->modelMapper->findidbyname('date_allocation',$dateallocationmax);
//            $this->modelMapper->find($id_doc_print_allocation,$this->model);
           // $getmasterprintid = $this->model->getMaster_Print_Id();
//            $getsysdepartmentid = $this->model->getSys_Department_Id();
//            $getsysuserid = $this->model->getUser_Id();
//            $getrequestnumber = $this->model->getRequest_Number();
            //xuat du lieu ra luoi
            $selectmasterprintid="select distinct master_print_id from doc_print_allocation where sys_department_id='$getsysdepartmentid' and sys_user_id='$getsysuserid' and request_number='$getrequestnumber' and  date_allocation ='$dateallocationmax'";
//            $selectmasterprintid="select distinct master_print_id from doc_print_allocation where sys_department_id='2' and sys_user_id='6' and request_number='ko11' and  date_allocation ='2015-07-09 00:00:00'";
            foreach ($this->modelMapper->fetchAlllPrint($selectmasterprintid) as $value) {
                $master_print_id = $value->getMaster_Print_Id();
                $selectlist ="select doc_print_create_id,master_print_id,sys_department_id,sys_user_id,request_number,date_allocation from doc_print_allocation where master_print_id='$master_print_id' and sys_department_id='$getsysdepartmentid' and sys_user_id='$getsysuserid'  and request_number='$getrequestnumber' and date_allocation ='$dateallocationmax' and is_delete ='0'";
                $soluong =0;$string_soquyen ='';$string_serial='';
                 foreach ($this->modelMapper->fetchAlllExport($selectlist) as $values) {
                     $doc_print_create_id = $values->getDoc_Print_Create_Id();
                     $soluong++;
                     if($string_soquyen == ""){
                         $string_soquyen = GlobalLib::getName('doc_print_create', $doc_print_create_id, 'coefficient');
                     }  else {
                         $string_soquyen = $string_soquyen .','.GlobalLib::getName('doc_print_create', $doc_print_create_id, 'coefficient');
                     }
                     if($string_serial == ""){
                         $string_serial = GlobalLib::getName('doc_print_create', $doc_print_create_id, 'serial');
                     }  else {
                         $string_serial = $string_serial .','.GlobalLib::getName('doc_print_create', $doc_print_create_id, 'serial');
                     }
                     $master_print_id = $values->getMaster_Print_Id();
                     $sys_department_id = $values->getSys_Department_Id();
                     $sys_user_id = $values->getUser_Id();
                     $hovaten = GlobalLib::getName('sys_user', $sys_user_id, 'first_name').' '.GlobalLib::getName('sys_user', $sys_user_id, 'last_name');
                     $request_number = $values->getRequest_Number();
                     $date_allocation = $values->getDate_Allocation();
                } 
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount, $stt)->getAlignment()->applyFromArray($style_alignment);
                $objPHPExcel->getActiveSheet()->mergeCells('B' . $rowCount.':'.'E' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'name'));
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'E' . $rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                 $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(30);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);
                
                $objPHPExcel->getActiveSheet()->mergeCells('F' . $rowCount.':'.'F' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'code'));
                $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':'.'F' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->mergeCells('G' . $rowCount.':'.'G' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $soluong);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount.':'.'G' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                 $objPHPExcel->getActiveSheet()->mergeCells('H' . $rowCount.':'.'I' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, $string_soquyen);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':'.'I' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                
                $objPHPExcel->getActiveSheet()->mergeCells('J' . $rowCount.':'.'K' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount, $string_serial);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount.':'.'I' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                
                
                $objPHPExcel->getActiveSheet()->mergeCells('L' . $rowCount.':'.'L' . $rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'L' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                
                $objPHPExcel->getActiveSheet()->mergeCells('E9:J9');
                $objPHPExcel->getActiveSheet()->setCellValue('E9', $hovaten);
                $objPHPExcel->getActiveSheet()->setCellValue('E12',GlobalLib::viewDate($date_allocation ));$objPHPExcel->getActiveSheet()->mergeCells('E12:J12');
                $objPHPExcel->getActiveSheet()->setCellValue('E10', $request_number);$objPHPExcel->getActiveSheet()->mergeCells('E10:F10');
                
                $rowCount++;
                $stt++;
                
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
            $objPHPExcel->getActiveSheet()->getStyle('A1:L'.$rowCount)->getFont()->setName('Times New Roman');
            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle("A1:A1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("F1:F1")->applyFromArray($styleArray);
           
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle("A3:K" . $rowCount)->getAlignment()->applyFromArray($style_alignment);
            //tên file excel
            $filename='PhieuXuatAnChi'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
//            $this->_redirect($redirectUrl);
    }
    public function savedocprintallocationAction(){
        $this->_helper->layout->disableLayout();
        if($this->getRequest()->isPost()){
           $arraydocprintallocation = $_POST['dataallocation'];
           $this->modelMapper->updatesorderDoc_Print_Allocation(); 
           for($i=0;$i<count($arraydocprintallocation);$i++){
               $arrayprintcreate = $arraydocprintallocation[$i]['doc_print_create_id'];
               if(count($arrayprintcreate)==1)
                   {
//                   $this->modelMapper->updatesorderDoc_Print_Allocation();
                   $this->model->setDoc_Print_Create_Id((int)$arrayprintcreate[0]);
                   //cap nhat trang thai DOING cho bang doc_print_create
                   $serial_recovery=$this->modelMapperDocPrintCreate->findidbyserialrecovery("id",(int)$arrayprintcreate[0]);
                   $serial=$this->modelMapperDocPrintCreate->findidbyserialserial("id",(int)$arrayprintcreate[0]);
                   $serial_allocation ;
                   if($serial_recovery == null){
                       $serial_allocation = $serial;
                   }else{
                       $serial_allocation = $serial_recovery;
                   }
                   
                   $this->modelMapperDocPrintCreate->updatestatusDoc_Print_Create((int)$arrayprintcreate[0],"DOING");
                   //
                   $this->model->setMaster_Print_Id((int)$arraydocprintallocation[$i]['master_print_id']);
                   $this->model->setSys_Department_Id((int)$arraydocprintallocation[$i]['sys_department_id']);
                   $this->model->setUser_Id((int)$arraydocprintallocation[$i]['sys_user_id']);
                   $this->model->setRequest_Number($arraydocprintallocation[$i]['request_number']);
                   $this->model->setDate_Allocation(GlobalLib::toMysqlDateString($arraydocprintallocation[$i]['data_allocation']));
                   $this->model->setComment($arraydocprintallocation[$i]['comment']);
                   $this->model->setStatus("DOING");
                   $this->model->setCreated_Date(date("Y/m/d H:i:s"));
                   $this->model->setCreated_By(GlobalLib::getLoginId());
                   $this->model->setModified_Date(date("Y/m/d H:i:s"));
                   $this->model->setModified_By(GlobalLib::getLoginId());
                   $this->model->setIs_Delete(0);$this->model->setOrder(1);$this->model->setSerial_Recovery1($serial_allocation);
                   $this->modelMapper->save($this->model);
               }  else {
                  
                   for($j=0;$j<count($arrayprintcreate);$j++){
                   $this->model->setDoc_Print_Create_Id((int)$arrayprintcreate[$j]);
                   
                   $serial_recovery=$this->modelMapperDocPrintCreate->findidbyserialrecovery("id",(int)$arrayprintcreate[$j]);
                   $serial=$this->modelMapperDocPrintCreate->findidbyserialserial("id",(int)$arrayprintcreate[$j]);
                   
                    $serial_allocation ;
                   if($serial_recovery == null){
                       $serial_allocation = $serial;
                   }else{
                       $serial_allocation = $serial_recovery;
                   }
                   
                   //cap nhat trang thai cho bang doc_print_create
                   $this->modelMapperDocPrintCreate->updatestatusDoc_Print_Create((int)$arrayprintcreate[$j],"DOING");
                   $this->model->setMaster_Print_Id((int)$arraydocprintallocation[$i]['master_print_id']);
                   $this->model->setSys_Department_Id((int)$arraydocprintallocation[$i]['sys_department_id']);
                   $this->model->setUser_Id((int)$arraydocprintallocation[$i]['sys_user_id']);
                   $this->model->setRequest_Number($arraydocprintallocation[$i]['request_number']);
                   $this->model->setDate_Allocation(GlobalLib::toMysqlDateString($arraydocprintallocation[$i]['data_allocation']));
                   $this->model->setComment($arraydocprintallocation[$i]['comment']);
                   $this->model->setCreated_Date(date("Y/m/d H:i:s"));
                   $this->model->setCreated_By(GlobalLib::getLoginId());
                   $this->model->setModified_Date(date("Y/m/d H:i:s"));
                   $this->model->setModified_By(GlobalLib::getLoginId());
                   $this->model->setStatus("DOING");
                   $this->model->setIs_Delete(0);$this->model->setOrder(1);$this->model->setSerial_Recovery1($serial_allocation);
                   $this->modelMapper->save($this->model);
                }
            }
           }
        }
        
    }
    public function addAction(){
        $this->view->itemdepartment= $this->modelDepartment;
        $this->view->itemuser= $this->modelUser;
        $this->view->itemdocprintcreated= $this->modelDocPrintCreate;
        $this->view->masterprintHTML = GlobalLib::getComboSeclectTitlee('master_print_id', 'master_print', 'id', 'code', 0,'name',  false,  'where id in (select distinct master_print_id from doc_print_create where is_delete ="0")',NULL, 'onchange="getPrintCreatWithMasterPrint(\'' . $this->aConfig["site"]["url"] .'default/service/index'. '\')"', 'Chưa lựa chọn');
        $this->view->printcreateHTML = GlobalLib::getComboSeclect('doc_print_create_id', 'doc_print_create', 'id', 'coefficient',0,  true, 'where status !="DONE" and master_print_id="0" and is_delete="0"' , NULL, '', 'Chưa lựa');
        if($this->getRequest()->isPost()){
            if(isset($_POST['sys_department_id'])){
                $sys_department_id = $_POST['sys_department_id'];
            }
            if(isset($_POST['request_number'])){
                $request_number = $_POST['request_number'];
            }
            if(strlen($_POST['ngaycapphat'])>0)
            {
                $ngaycapphat = GlobalLib::toMysqlDateString( $_POST['ngaycapphat']).' '.'00:00:00';
            } 
            if(isset($_POST['request_number'])){
                $request_number = $_POST['request_number'];
            }
            if(isset($_POST['sys_user_id'])){
                $sys_user_id = $_POST['sys_user_id'];
            }
           $this-> printallocationexport($sys_department_id,$request_number,$ngaycapphat,$sys_user_id);
            $redirectUrl = $this->aConfig["site"]["url"]."default/docprintallocation/list";
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }
    //
   
    //xuat excel cap phat cho doi
    public function printallocationexport($sys_department_id,$request_number,$ngaycapphat,$sys_user_id){
           $redirectUrl = $this->aConfig["site"]["url"]."default/docprintallocation/list";
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 15;
            $stt=1;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");
            $objPHPExcel->getActiveSheet()->setCellValue('G1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('G1:L1'); $objPHPExcel->getActiveSheet()->getStyle("G1:L1")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('G2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('G2:L2');$objPHPExcel->getActiveSheet()->getStyle("G2:L2")->getFont()->setUnderline(true);			
            $objPHPExcel->getActiveSheet()->getStyle("G1:L1")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->getStyle("G2:L2")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
             $objPHPExcel->getActiveSheet()->getStyle("A4:L5")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->setCellValue('A4', "PHIẾU XUẤT ẤN CHỈ");$objPHPExcel->getActiveSheet()->mergeCells('A4:L4');
             $objPHPExcel->getActiveSheet()->getStyle("A4:L4")->getFont()->setSize(14);
            $objPHPExcel->getActiveSheet()->getStyle("A4:L4")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('A5', "Liên 1: Kế toán");$objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
            $objPHPExcel->getActiveSheet()->setCellValue('I6', "Ký hiệu: PN-AC");$objPHPExcel->getActiveSheet()->mergeCells('I6:J6');
            $objPHPExcel->getActiveSheet()->setCellValue('I7', "Số:");$objPHPExcel->getActiveSheet()->mergeCells('I7:J7');
            $objPHPExcel->getActiveSheet()->setCellValue('A9', "Họ và tên người nhận ấn chỉ:");$objPHPExcel->getActiveSheet()->mergeCells('A9:D9');
            $objPHPExcel->getActiveSheet()->setCellValue('E9', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('E9:J9');
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Theo giấy giới thiệu số:");$objPHPExcel->getActiveSheet()->mergeCells('A10:D10');
            $objPHPExcel->getActiveSheet()->setCellValue('E10', "……………………………….........................................");$objPHPExcel->getActiveSheet()->mergeCells('E10:F10');
            $objPHPExcel->getActiveSheet()->setCellValue('G10', "Ngày:");
            $objPHPExcel->getActiveSheet()->setCellValue('H10', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('H10:J10');
            $objPHPExcel->getActiveSheet()->setCellValue('A11', "Kèm theo bảng kê đề nghị nhận số:");$objPHPExcel->getActiveSheet()->mergeCells('A11:D11');
            $objPHPExcel->getActiveSheet()->setCellValue('E11', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('E11:F11');
            $objPHPExcel->getActiveSheet()->setCellValue('G11', "Ngày:");
            $objPHPExcel->getActiveSheet()->setCellValue('H11', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('H11:J11');
            $objPHPExcel->getActiveSheet()->setCellValue('A12', "Ngày xuất ấn chỉ:");$objPHPExcel->getActiveSheet()->mergeCells('A12:D12');
            $objPHPExcel->getActiveSheet()->setCellValue('E12', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('E12:J12');
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A13', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A13:A14');
             $objPHPExcel->getActiveSheet()->getStyle("A13:A14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A13:A14")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('B13', "Tên ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('B13:E14');
             $objPHPExcel->getActiveSheet()->getStyle("B13:E14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("B13:E14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('F13', "Ký hiệu");$objPHPExcel->getActiveSheet()->mergeCells('F13:F14');
             $objPHPExcel->getActiveSheet()->getStyle("F13:F14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("F13:F14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('G13', "Số lượng");$objPHPExcel->getActiveSheet()->mergeCells('G13:G14');
             $objPHPExcel->getActiveSheet()->getStyle("G13:G14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("G13:G14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('H13', "Từ quyển...tới quyển...");$objPHPExcel->getActiveSheet()->mergeCells('H13:I14');
             $objPHPExcel->getActiveSheet()->getStyle("H13:I14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("H13:I14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('J13', "Từ số...tới số...");$objPHPExcel->getActiveSheet()->mergeCells('J13:K14');
             $objPHPExcel->getActiveSheet()->getStyle("J13:K14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("J13:K14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('L13', "Tổng");$objPHPExcel->getActiveSheet()->mergeCells('L13:L14');
             $objPHPExcel->getActiveSheet()->getStyle("L13:L14")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("L13:L14")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
             $objPHPExcel->getActiveSheet()->getStyle('A13:L14')->getFont()->setBold(true);
            
               // thuc hien xuat du lieu ra file excel
               $dateallocationmax=$ngaycapphat;
//               $id_doc_print_allocation=
               $getsysdepartmentid=$sys_department_id;
               $getsysuserid=$sys_user_id;
               $getrequestnumber=$request_number;        
             //lay ra ngay lon nhat trong bang csdl
//            $dateallocationmax= $this->modelMapper->maxdateallocation();
//            $id_doc_print_allocation =  $this->modelMapper->findidbyname('date_allocation',$dateallocationmax);
//            $this->modelMapper->find($id_doc_print_allocation,$this->model);
           // $getmasterprintid = $this->model->getMaster_Print_Id();
//            $getsysdepartmentid = $this->model->getSys_Department_Id();
//            $getsysuserid = $this->model->getUser_Id();
//            $getrequestnumber = $this->model->getRequest_Number();
            //xuat du lieu ra luoi
            $selectmasterprintid="select distinct master_print_id from doc_print_allocation where sys_department_id='$getsysdepartmentid' and sys_user_id='$getsysuserid' and request_number='$getrequestnumber' and  date_allocation ='$dateallocationmax' and `order` ='1'";
           
            foreach ($this->modelMapper->fetchAlllPrint($selectmasterprintid) as $value) {
                $master_print_id = $value->getMaster_Print_Id();
                 $selectlist ="select doc_print_create_id,master_print_id,sys_department_id,sys_user_id,request_number,date_allocation from doc_print_allocation where master_print_id='$master_print_id' and sys_department_id='$getsysdepartmentid' and sys_user_id='$getsysuserid'  and request_number='$getrequestnumber' and date_allocation ='$dateallocationmax' and `order` ='1' and is_delete ='0'";
                $soluong =0;$string_soquyen ='';$string_serial='';
                 foreach ($this->modelMapper->fetchAlllExport($selectlist) as $values) {
                     $doc_print_create_id = $values->getDoc_Print_Create_Id();
                     $soluong++;
                     if($string_soquyen == ""){
                         $string_soquyen = GlobalLib::getName('doc_print_create', $doc_print_create_id, 'coefficient');
                     }  else {
                         $string_soquyen = $string_soquyen .','.GlobalLib::getName('doc_print_create', $doc_print_create_id, 'coefficient');
                     }
                     if($string_serial == ""){
                         $string_serial = GlobalLib::getName1('doc_print_create', $doc_print_create_id, 'serial,serial_recovery');
                     }  else {
                         $string_serial = $string_serial .','.GlobalLib::getName1('doc_print_create', $doc_print_create_id, 'serial,serial_recovery');
                     }
                     $master_print_id = $values->getMaster_Print_Id();
                     $sys_department_id = $values->getSys_Department_Id();
                     $sys_user_id = $values->getUser_Id();
                     $hovaten = GlobalLib::getName('sys_user', $sys_user_id, 'first_name').' '.GlobalLib::getName('sys_user', $sys_user_id, 'last_name');
                     $request_number = $values->getRequest_Number();
                     $date_allocation = $values->getDate_Allocation();
                } 
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount, $stt)->getAlignment()->applyFromArray($style_alignment);
                $objPHPExcel->getActiveSheet()->mergeCells('B' . $rowCount.':'.'E' . $rowCount);  
                  $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'name'));
                 $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'E' . $rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                 $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(30);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);
                    
                $objPHPExcel->getActiveSheet()->mergeCells('F' . $rowCount.':'.'F' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, GlobalLib::getName('master_print', $master_print_id, 'code'));
                $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':'.'F' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
               
                $objPHPExcel->getActiveSheet()->mergeCells('G' . $rowCount.':'.'G' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $soluong);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount.':'.'G' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                
                $objPHPExcel->getActiveSheet()->mergeCells('H' . $rowCount.':'.'I' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, $string_soquyen);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':'.'I' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                
                $objPHPExcel->getActiveSheet()->mergeCells('J' . $rowCount.':'.'K' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount, $string_serial);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount.':'.'I' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                
                
                $objPHPExcel->getActiveSheet()->mergeCells('L' . $rowCount.':'.'L' . $rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'L' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                
                
                
                $objPHPExcel->getActiveSheet()->mergeCells('E9:J9');
                $objPHPExcel->getActiveSheet()->setCellValue('E9', $hovaten);
                $objPHPExcel->getActiveSheet()->setCellValue('E12',GlobalLib::viewDate($date_allocation ));$objPHPExcel->getActiveSheet()->mergeCells('E12:J12');
                $objPHPExcel->getActiveSheet()->setCellValue('E10', $request_number);$objPHPExcel->getActiveSheet()->mergeCells('E10:F10');
                
                $rowCount++;
                $stt++;
                
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
             $objPHPExcel->getActiveSheet()->getStyle('A1:L'.$rowCount)->getFont()->setName('Times New Roman');
            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle("A1:A1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("F1:F1")->applyFromArray($styleArray);
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
//            $objPHPExcel->getActiveSheet()->getStyle("A3:K" . $rowCount)->getAlignment()->applyFromArray($style_alignment);
            //tên file excel
            $filename='PhieuXuatAnChi'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
//            $this->_redirect($redirectUrl);
    }






    public function editAction(){
        $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."default/docprintallocation/list";
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
            if(isset($_POST["doc_print_create_id"])){
                $this->model->setDoc_Print_Create_id($_POST["doc_print_create_id"]);
            }
            if(isset($_POST["sys_department_id"])){
                $this->model->setSys_Department_Id($_POST["sys_department_id"]);
            } 
            if(strlen($_POST["serial_allocation"])){
                $this->model->setSerial_Allocation($_POST["serial_allocation"]);
            }
            if(strlen($_POST["serial_recovery"])){
                $this->model->setSerial_Recovery($_POST["serial_recovery"]);
            } 
            if(strlen($_POST["date_allocation"])<=0){
                $ngay_capphat = date("Y/m/d H:i:s");
            }  else {
                $ngay_capphat = GlobalLib::toMysqlDateString($_POST["date_allocation"]);
            }
            $this->model->setDate_Allocation($ngay_capphat);
            if(strlen($_POST["date_recovery"])){
                $this->model->setDate_Recovery($_POST["date_recovery"]);
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
    public function listAction(){  
         $this->view->itemdepartment= $this->modelDepartment;
        $this->view->itemuser= $this->modelUser;
    }    
     public function serviceAction(){
        $this->_helper->layout->disableLayout();
       
        foreach ($this->modelMapper->fetchAll() as $items ) {
            if($items->getStatus()=="DONE"){
                $trangthai = "Thanh toán hết";
            }elseif ($items->getStatus()=="DOING") {
                $trangthai = "Đang sử dụng";
            }  else {
                $trangthai = "Thu hồi";
            }  
            //serial_recovery
            if(($items->getStatus()=="DONE")||($items->getStatus()=="RECOVERY")){
                $idprintpayment=$this->modelMapperPrintPayment->findidbyname('doc_print_allocation_id',$items->getId());
                $this->modelMapperPrintPayment->find($idprintpayment,$this->modelPrintPayment);
                if($this->modelPrintPayment->getSerial_Recovery()==""){
                    $getserialrecovery="";
                }  else {
                    $getserialrecovery = $this->modelPrintPayment->getSerial_Recovery();
                }
                if($this->modelPrintPayment->getSerial_Fail()==""){
                    $getserialfail="";
                }  else {
                    $getserialfail = $this->modelPrintPayment->getSerial_Fail();
                }
            }  else {
                $getserialrecovery="";$getserialfail="";
            }
            if($items->getStatus()=="DOING"){
                $menber[]=array(
                'id' => $items->getId(), 
                'doc_print_create_id'=>$items->getDoc_Print_Create_Id(),
                'name_doc_print_create'=>GlobalLib::getName('doc_print_create', $items->getDoc_Print_Create_Id(),'coefficient' ),
                'master_print_id'=>$items->getMaster_Print_Id(),
                'name_print'=>  GlobalLib::getName('master_print', $items->getMaster_Print_Id(),'code' ),
                'serial_print'=>  GlobalLib::getName1('doc_print_create', $items->getDoc_Print_Create_Id(),'serial,serial_recovery' ),   
                'sys_department_id'=>$items->getSys_Department_Id(),
                'name_sys_department_id'=>  GlobalLib::getName('sys_department', $items->getSys_Department_Id(),'name' ),
                'sys_user_id'=>$items->getUser_Id(),
                'name_user'=>  GlobalLib::getName('sys_user', $items->getUser_Id(), 'first_name').' '.GlobalLib::getName('sys_user', $items->getUser_Id(), 'last_name'),
                'request_number'=>$items->getRequest_Number(),
                'status' =>$trangthai,
                'anchithuhoi'=> $getserialrecovery,
                'anchihuhong'=> $getserialfail,
                'date_allocation'=> GlobalLib::viewDate($items->getDate_Allocation()),
                
            );
            }
        }
        echo json_encode($menber);
        exit();
    } 
    
   
   //xuat danh sach an chi da thu hoi ra excel
   public function exportserialrecoveryAction() {
        $this->_helper->layout->disableLayout();
        if ($this->getRequest()->isPost()) {
            $ided=0;
            if(strlen($_POST['list'])>0)
            {
                $ided = $_POST['list'];
            }  else {
                $ided = 0;
            }
            $redirectUrl=$this->aConfig["site"]["url"]."default/docprintallocation/list";
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 4;
            $stt=1;
            $objPHPExcel->getActiveSheet()->setCellValue('A3', "STT");
            $objPHPExcel->getActiveSheet()->setCellValue('B3', "Tên ấn chỉ");
            $objPHPExcel->getActiveSheet()->setCellValue('C3',"Serial cấp phát");
            $objPHPExcel->getActiveSheet()->setCellValue('D3',"Serial đã thu hồi");
            $objPHPExcel->getActiveSheet()->setCellValue('E3',"Phòng ban");
            //
//            $ided = $this->_getParam("id","");
            $select ="";
            $select11 ="select distinct master_print_id,sys_department_id from doc_print_allocation where master_print_id='$ided'";
            $select12 ="select distinct master_print_id,sys_department_id from doc_print_allocation";
            if($ided == 0){
                $select = $select12;
            }  else {
                $select = $select11;
            }
            foreach ($this->modelMapper->fetchAllExport_Department($select) as $value) {
                $master_print_id = $value->getMaster_Print_Id();
                $name_print =  GlobalLib::getName('master_print', $value->getMaster_Print_Id(),'name') ;
                $sys_department_id = $value->getSys_Department_Id();
                $name_department = GlobalLib::getName('sys_department', $value->getSys_Department_Id(),'name');
                $string_serialallocation=  $this->stringserialallocation_department($master_print_id,$sys_department_id);
                $string_serialrecovery = $this->stringserialrecovery_department($master_print_id,$sys_department_id);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $name_print);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $string_serialallocation);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, $string_serialrecovery); 
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowCount, $name_department); 
                $rowCount++;
                $stt++;
            }       
            $objPHPExcel->getActiveSheet()->mergeCells('A1:D2');
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "Danh sách ấn chỉ đã thu hồi");
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
            foreach (range('A', 'E') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }
            //tên file excel
            $filename='DanhSachAnChiThuHoi'.date('m-Y').'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
           
            exit();
             $this->_redirect($redirectUrl);
        }
    }
   public function checkcodeAction(){
          $this->_helper->layout()->disableLayout();
         if($this->_request->isPost()){
             $code= $this->_getParam("code","");
             $id= $this->modelMapper->findidbyname('code',$code);
//             $id = 1;
             if($id !=0){
                 $menber[]=array(
                     'code'=>1,
                     'message'=>'Mã code này đã tồn tại. Vui lòng kiểm tra và nhập lại'
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
   
     public function confirmdeleteAction()
    {
//        if($this->getRequest()->getPost()){
            $count =0;
            $list_serial_allocation = $this->_getParam("serial_allocation","");
            $id_master_print = $this->_getParam("id_master_print","");
//            $list_serial_allocation="12,13-20,30,40";
//            $id_master_print="4";        
            //tao day serial_allocation de xoa
            $array_serial = array();$i=0;
            $array_serialallocation = explode(",", $list_serial_allocation);
            if(count($array_serialallocation)==1){
                $array1 = explode("-", $array_serialallocation[0]);
                if(count($array1)==1){
                    $array_serial[$i++] = (int)$array1[0];
                }else{
                    for($i =(int) $array1[0];$i<= (int)$array1[1];$i++){
                        $array_serial[$i++]=$i;
                    }
                }
            }  else {
                foreach ($array_serialallocation as $value) {
                    $array2 = explode("-", $value);
                    if(count($array2)==1){
                        $array_serial[$i++]=(int)$array2[0];
                    }  else {
                        for($k=(int)$array2[0];$k<=(int)$array2[1];$k++){
                            $array_serial[$i++]=$k;
                        }
                    }
                }
            }
            //tim serial de xoa
            foreach ($array_serial as $items) {
                $id_doc_print_allocation =$this->modelMapper->findidbyserialrecovery($id_master_print,$items);
                if($id_doc_print_allocation ==0){
                       $count =1;break;
                }
            }
            echo ($count);
            exit();
//        }
        
    }
    public function deleteAction(){
        $list_serial_allocation = $this->_getParam("serial_allocation","");
        $id_master_print = $this->_getParam("id_master_print","");
//        $list_serial_allocation="1-15";
//        $id_master_print="6";        
        $redirectUrl=$this->aConfig["site"]["url"]."default/docprintallocation/list"; 
       
         //tao day serial_allocation de xoa
            $array_serial = array();$i=0;
            $array_serialallocation = explode(",", $list_serial_allocation);
            if(count($array_serialallocation)==1){
                $array1 = explode("-", $array_serialallocation[0]);
                if(count($array1)==1){
                    $array_serial[$i++] =(int) $array1[0];
                }else{
                    for($h =(int) $array1[0];$h<= (int)$array1[1];$h++){
                        $array_serial[$i++]=$h;
                    }
                }
            }  else {
                foreach ($array_serialallocation as $value) {
                    $array2 = explode("-", $value);
                    if(count($array2)==1){
                        $array_serial[$i++]=(int)$array2[0];
                    }  else {
                        for($k=(int)$array2[0];$k<=(int)$array2[1];$k++){
                            $array_serial[$i++]=$k;
                        }
                    }
                }
            }
            //thuc hien xoa
            foreach ($array_serial as $value) {
               $id = $this->modelMapper->findidbyserialrecovery($id_master_print,$value);
               $this->modelMapper->find($id,$this->model);
               $this->modelMapper->deleteDoc_Print_Allocation($id);
            }
            $this->_redirect($redirectUrl);
//            echo json_encode($array_serial);
//             exit();
    }    
    
    
    
    
    
    public function tamAction(){
        $this->_helper->layout->disableLayout();
        echo json_encode($this->modelMapper->findidbyserial(4,17,5));
        exit();
    }
}
