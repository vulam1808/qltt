<?php
include APPLICATION_PATH . "/models/Doc_Print_Payment.php";
include_once  APPLICATION_PATH."/models/SysDepartments.php"; 
include_once  APPLICATION_PATH."/models/Doc_Print_Create.php"; 
include_once  APPLICATION_PATH."/models/Doc_Print_Allocation.php"; 
include_once  APPLICATION_PATH."/models/Sys_User.php"; 

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Leader_DocPrintPaymentController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Doc_Print_PaymentMapper();
        $this->model= new Model_Doc_Print_Payment(); 
        $this->modelDepartment = new Model_SysDepartments();
        $this->modelMapperDepartment = new Model_SysDepartmentsMapper();
        $this->modelUser = new Model_Sys_User();
        $this->modelMapperUser = new Model_Sys_UserMapper();
        $this->modelPrintAllocation = new Model_Doc_Print_Allocation();
        $this->modelMapperPrintAllocation = new Model_Doc_Print_AllocationMapper();
        $this->modelPrintCreate = new Model_Doc_Print_Create();
        $this->modelMapperPrintCreate = new Model_Doc_Print_CreateMapper();
        
    }
   
    public function checkserialpaymentAction(){ 
    if($this->getRequest()->isPost()){
//        $serialpayment1 = $this->_getParam('serialpayment','');
//        $serialpayment_2 = $this->_getParam('serialpayment2','');
//        $quyenso = $this->_getParam('quyenso','');
//        $masterprintid = $this->_getParam('masterprintid','');
        $datapayment = $_POST['datapayment'];
        //
        $serialpayment1 = $datapayment[0]['serial_recovery'];
        $serialpayment_2=$datapayment[0]['serial_fail'];
        $masterprintid =$datapayment[0]['master_print_id'];
        $quyenso =$datapayment[0]['doc_print_create_id'];
        $serialpayment="";
        $serial = $this->modelMapperCreate->serialwithquyensomasterprintid($masterprintid,$quyenso);
        if($serialpayment_2!=""){
            $serialpayment=$serialpayment1.','.$serialpayment_2;
        }else{
            $serialpayment = $serialpayment1;
        }
        
        $array = $this->modelMapper->arrayserialpayment($serialpayment);
        $arrayerror = array();$t=0;$flagktu=0;$flagttu=0;
        for($i=0;$i<count();$i++){
            if(is_numeric($array[$i])==FALSE){
                $arrayerror[$t++]="ktu;".$array[$i];$flagktu = 1;
            }
        }
        if($flagktu==0){
            for($i =1;$i<count($array[$i]);$i++){
                if($array[$i]==$array[$i-1]){
                   $arrayerror[$t++]="ttu;".$array[$i];$flagttu = 1;
                }
            }
        }
        //
        if($flagttu == 0){
             $flag = $this->modelMapperCreate->checkserialinserial($serial,$serialpayment);
             if($flag == 1){
                 $arrayerror[$t++]="kh;".$flag;
             }
        }
        if(count($arrayerror) !=0){
                 $menber[]=array(
                     'code'=>1,
                     'error'=>$arrayerror,
                     'message'=>'Mã lỗi xảy ra.'
                     );  
             } else {
                  $menber[]=array(
                     'code'=>0,
                     'error'=>$arrayerror,
                     'message'=>''
                      );  
             }
        echo json_encode($menber);
        exit();
    }
        
    }
    public function indexAction(){       
    }
     public function savedocprintpaymentAction(){
        $this->_helper->layout->disableLayout();
        if($this->getRequest()->isPost()){
           $redirectUrl = $this->aConfig["site"]["url"]."leader/docprintpayment/list";
           $arraydocprintpayment= $_POST['datapayment'];
           $this->modelMapper->updatesorderDoc_Print_Payment();
           for($i=0;$i<count($arraydocprintpayment);$i++){
               $this->modelMapperPrintAllocation->find((int)$arraydocprintpayment[$i]['id'],$this->modelPrintAllocation);
               $getdocprintcreate=$this->modelPrintAllocation->getDoc_Print_Create_Id();
               if($arraydocprintpayment[$i]['dunghet'] == "1"){
                   $this->modelMapperPrintAllocation->updatestatusDoc_Print_Allocation((int)$arraydocprintpayment[$i]['id'],'DONE');
                   $this->modelMapperPrintCreate->updatestatusDoc_Print_Create($getdocprintcreate,'DONE');
               }else if(($arraydocprintpayment[$i]['serial_recovery'] == "")&&(($arraydocprintpayment[$i]['serial_fail'] == ""))){
                   $this->modelMapperPrintAllocation->updatestatusDoc_Print_Allocation((int)$arraydocprintpayment[$i]['id'],'DOING');
                   $this->modelMapperPrintCreate->updatestatusDoc_Print_Create($getdocprintcreate,'DOING');
               }else if(($arraydocprintpayment[$i]['serial_recovery'] == "")&&(($arraydocprintpayment[$i]['serial_fail'] != ""))){
                   $this->modelMapperPrintAllocation->updatestatusDoc_Print_Allocation((int)$arraydocprintpayment[$i]['id'],'DONE');
                   $this->modelMapperPrintCreate->updatestatusDoc_Print_Create($getdocprintcreate,'DONE');
               }else {
                   $this->modelMapperPrintAllocation->updatestatusDoc_Print_Allocation((int)$arraydocprintpayment[$i]['id'],'RECOVERY');
                   $this->modelMapperPrintCreate->updatestatusDoc_Print_Create($getdocprintcreate,'RECOVERY');
                   $this->modelMapperPrintCreate->updatesserialrecoveryDoc_Print_Create($getdocprintcreate,$arraydocprintpayment[$i]['serial_recovery']);
               }
               //luu du lieu vao bang doc_print_payment
                   if(($arraydocprintpayment[$i]['dunghet']!='0')||($arraydocprintpayment[$i]['serial_recovery'] != "")||($arraydocprintpayment[$i]['serial_fail'] != "")){
                   $this->model->setSys_Department_Id((int)$arraydocprintpayment[$i]['sys_department_id']);
                   $this->model->setSys_User_Id((int)$arraydocprintpayment[$i]['sys_user_id']);
                   $this->model->setDoc_Print_Allocation_Id((int)$arraydocprintpayment[$i]['id']);
                   $this->model->setMaster_Print_Id((int)$arraydocprintpayment[$i]['master_print_id']);
                   $this->model->setSerial_Recovery($arraydocprintpayment[$i]['serial_recovery']);
                   $this->model->setSerial_Fail($arraydocprintpayment[$i]['serial_fail']);
                   $this->model->setReasons_Fail($arraydocprintpayment[$i]['reasons_fail']);
                   $this->model->setDate_Payment(GlobalLib::toMysqlDateString($arraydocprintpayment[$i]['date_payment']));
                   $this->model->setComment($arraydocprintpayment[$i]['comment']);
                   $this->model->setCreated_Date(date("Y/m/d H:i:s"));
                   $this->model->setCreated_By(GlobalLib::getLoginId());
                   $this->model->setModified_Date(date("Y/m/d H:i:s"));
                   $this->model->setModified_By(GlobalLib::getLoginId());
                   $this->model->setIs_Delete(0);$this->model->setOrder(1);
                           
                   $this->modelMapper->save($this->model);
                   
                  
               }
               
           }
           
            $this->redirect($redirectUrl);
        }
    }
    public function tamtamAction() {
         //lay ra so luong
                $getSerial ='1-20';
                $arraySerialRecover = GlobalLib::arraySerial('15-18,20');
                $arraySerialFail = GlobalLib::arraySerial('4-6,19');
                $arraychuasudung = array();$k=0;
                //nhap hai mamng lai theo thu tu tang dan
               
                for($n = 0;$n<count($arraySerialRecover);$n++){
                    $arraychuasudung[$k++] = $arraySerialRecover[$n];
                }
                if($k=(count($arraySerialRecover))){
                    if($arraySerialFail[0]!= 0){
                    for($n = 0;$n<count($arraySerialFail);$n++){
                        $arraychuasudung[$k++] = $arraySerialFail[$n];
                    }}
                }
                //sap xep mang tang dan
                $max = $arraychuasudung[0];
                for($n = 1; $n<count($arraychuasudung);$n++){
                    if($arraychuasudung[$n]>$max){
                         $tam = $arraychuasudung[$n];
                         $max = $tam;
                         $arraychuasudung[$n] = $tam;
                     }
                }
                //lay mang chi co nhung so serial da su dung
//                $getserial="1-20";
                $arrayserial = explode("-", $getSerial);$arr = array();$p=0;
                for($n = (int)$arrayserial[0];$n<=(int)$arrayserial[1];$n++){
                    if(GlobalLib::ckeckarray($n, $arraychuasudung)==0){
                        $arr[$p++] = $n;
                    }
                }
                //tao ra chuoi serial da su dung
                $flag = "";$t="";$arrayseriallist = array();$a1=0;$dem=0;$a2=1;$co=false;
                $arrayseriallist1 = array();
                $dem = count($arr);
                $min = $arr[0];
                $flag = $min-1;
                for($n = 0; $n<count($arr);$n++){
                $tam = $arr[$n]; 
                $arrayseriallist[$a1++]=$tam;
                $arrayseriallist1[0]=$min;
                if($dem ==1){
                    $arrayseriallist1[0]=$tam;
                }elseif($tam == ($flag+1)){
                    $flag = $tam;
                    if($a1 == $dem){
                        $flag = $tam;
                        $arrayseriallist1[$a2++]="-";
                        $arrayseriallist1[$a2++]=$tam;
                    }
                    $co = true;
                   
                }elseif ($tam > ($flag+1)) {                    
                    if($a1 == $dem){
                        if($co = true){
                        $flag = $tam;
                        $arrayseriallist1[$a2++]=",";
                        $arrayseriallist1[$a2++]=$tam;
                        $co = false;}
                    }else{
                        if($co == true){
                        $arrayseriallist1[$a2++]="-";
                        $arrayseriallist1[$a2++]=$flag; 
                        $arrayseriallist1[$a2++]=",";
                        $arrayseriallist1[$a2++]=$tam;
                        $flag = $tam;$co = false;
                        }else {
                            $arrayseriallist1[$a2++]=",";
                            $arrayseriallist1[$a2++]=$tam;
                            $flag = $tam;
                        }
                    }    
                }               
                }
                $arrtam = array();$e=0;
                 $st = implode('', $arrayseriallist1);
                 $arr11= explode(",",$st);
                foreach ($arr11 as $value) {
                    $arr12 = explode("-", $value);
                    if(count($arr12)==1){
                        $arrtam[$e++]=$value;
                    }  else {
                        if((int)$arr12[0]==(int)$arr12[1]){
                             $arrtam[$e++] = ",";
                             $arrtam[$e++] = $arr12[0];
                        }  else {
                             $arrtam[$e++] = ",";
                             $arrtam[$e++] = $value;
                        }
                       
                    }
                    
                }
                $str = implode('', $arrtam);
                $str = substr($str, 1);
                echo json_encode($str);
                exit();
    }
    public function printpaymentexport($pb,$us){
            $redirectUrl = $this->aConfig["site"]["url"]."leader/docprintpayment/list";
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 14;
            $stt=1;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('F1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('F1:J1');
            $objPHPExcel->getActiveSheet()->setCellValue('F2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('F2:J2');
            $objPHPExcel->getActiveSheet()->getStyle('F1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->getStyle('F2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

            $objPHPExcel->getActiveSheet()->setCellValue('A4', "BẢNG KÊ THANH TOÁN ẤN CHỈ");$objPHPExcel->getActiveSheet()->mergeCells('A4:K4');
            $objPHPExcel->getActiveSheet()->getStyle("A4:K4")->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('D5', "");$objPHPExcel->getActiveSheet()->mergeCells('D5:E5');
             $objPHPExcel->getActiveSheet()->getStyle('D4:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('G6', "");$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
            $objPHPExcel->getActiveSheet()->setCellValue('G7', "");$objPHPExcel->getActiveSheet()->mergeCells('G7:H7');
            $objPHPExcel->getActiveSheet()->setCellValue('A9', "Họ và tên người thanh toán:");$objPHPExcel->getActiveSheet()->mergeCells('A9:C9');
            $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('D9', "………………………………");$objPHPExcel->getActiveSheet()->mergeCells('D9:J9');
            $objPHPExcel->getActiveSheet()->setCellValue('A10', "Đơn vị:");$objPHPExcel->getActiveSheet()->mergeCells('A10:C10');
            $objPHPExcel->getActiveSheet()->setCellValue('D10', "……………………………….........................................");$objPHPExcel->getActiveSheet()->mergeCells('D10:F10');
            $objPHPExcel->getActiveSheet()->setCellValue('G10', "");
            $objPHPExcel->getActiveSheet()->setCellValue('H10', "");$objPHPExcel->getActiveSheet()->mergeCells('H10:J10');
           
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A11', "THANH TOÁN ẤN CHỈ ĐÃ SỬ DỤNG");$objPHPExcel->getActiveSheet()->mergeCells('A11:K11');
             $objPHPExcel->getActiveSheet()->getStyle('A11:K11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->getStyle("A11:K11")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $objPHPExcel->getActiveSheet()->getStyle("A11:K11")->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->setCellValue('A12', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A12:A13');
             $objPHPExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(30);
             $objPHPExcel->getActiveSheet()->getStyle("A12:A13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A12:A13")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('B12', "Tên ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('B12:E13');
             $objPHPExcel->getActiveSheet()->getStyle("B12:E13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("B12:E13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('F12', "Ký hiệu");$objPHPExcel->getActiveSheet()->mergeCells('F12:F13');
             $objPHPExcel->getActiveSheet()->getStyle("F12:F13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("F12:F13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('G12', "Số lượng");$objPHPExcel->getActiveSheet()->mergeCells('G12:G13');
             $objPHPExcel->getActiveSheet()->getStyle("G12:G13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("G12:G13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('H12', "Quyển số");$objPHPExcel->getActiveSheet()->mergeCells('H12:H13');
             $objPHPExcel->getActiveSheet()->getStyle("H12:H13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("H12:H13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
              $objPHPExcel->getActiveSheet()->setCellValue('I12', "Từ số..đến số");$objPHPExcel->getActiveSheet()->mergeCells('I12:I13');
             $objPHPExcel->getActiveSheet()->getStyle("I12:I13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("I12:I13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('J12', "Trong đó xóa bỏ, hư hỏng");$objPHPExcel->getActiveSheet()->mergeCells('J12:K12');
              $objPHPExcel->getActiveSheet()->getStyle('J12:K12')->getAlignment()->setWrapText(true);
              $objPHPExcel->getActiveSheet()->getStyle('J12:K12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             $objPHPExcel->getActiveSheet()->setCellValue('J13', "Số");$objPHPExcel->getActiveSheet()->mergeCells('J13:J13');
             $objPHPExcel->getActiveSheet()->getStyle('J13:J13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
              $objPHPExcel->getActiveSheet()->setCellValue('K13', "Số lượng");$objPHPExcel->getActiveSheet()->mergeCells('K13:K13');
             $objPHPExcel->getActiveSheet()->getStyle('K13:K13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             $objPHPExcel->getActiveSheet()->getStyle("J12:K13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
             $objPHPExcel->getActiveSheet()->getStyle('A12:K13')->getFont()->setBold(true);
             //
//             $max_date_payment = $this->modelMapper->maxdatepayment();
//             $id_doc_print_payment= $this->modelMapper->findidbyname('date_payment',$nt);
//             $this->modelMapper->find($id_doc_print_payment,$this->model);
//             $sysdepartmentid=$this->model->getSys_Department_Id();
//             $sysuserid = $this->model->getSys_User_Id();
             $objPHPExcel->getActiveSheet()->setCellValue('D9',  GlobalLib::getName('sys_user', $us, 'first_name').'-'.GlobalLib::getName('sys_user', $us, 'last_name') );$objPHPExcel->getActiveSheet()->mergeCells('D9:J9');
              $objPHPExcel->getActiveSheet()->setCellValue('D10', GlobalLib::getName('sys_department', $pb, 'name'));$objPHPExcel->getActiveSheet()->mergeCells('D10:F10');
             $select ="select * from doc_print_payment where sys_department_id ='$pb' and sys_user_id='$us'  and `order`='1' and is_delete='0'";
             foreach ($this->modelMapper->fetchAlll($select) as $value) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $stt);$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount, $stt)->getAlignment()->applyFromArray($style_alignment);
                $objPHPExcel->getActiveSheet()->mergeCells('B' . $rowCount.':'.'E' . $rowCount);               
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::getName('master_print', $value->getMaster_Print_Id(), 'name'));
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'E' . $rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'K' . $rowCount)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(30);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, GlobalLib::getName('master_print', $value->getMaster_Print_Id(), 'code'));
                $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':'.'F' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                $this->modelMapperPrintAllocation->find($value->getDoc_Print_Allocation_Id(),$this->modelPrintAllocation);
                $serial_recovery1 = $this->modelPrintAllocation->getSerial_Recovery1();
                $getdocprintcreateid = $this->modelPrintAllocation->getDoc_Print_Create_Id();
                $this->modelMapperPrintCreate->find($getdocprintcreateid,$this->modelPrintCreate);
                $getsoquyen=$this->modelPrintCreate->getCoefficient();
                $getserial1 = $this->modelPrintCreate->getSerial();
                //$getsoluong = $this->modelPrintCreate->getSoLuong($getserial);
                if($serial_recovery1 == null){
                    $getserial =$getserial1;
                }  else {
                    $getserial =$serial_recovery1;
                }
                //lay ra so luong
                $arraySerialRecover = GlobalLib::arraySerial($value->getSerial_Recovery());
                $arraySerialFail = GlobalLib::arraySerial($value->getSerial_Fail());
                $arraychuasudung = array();$k=0;
                //nhap hai mamng lai theo thu tu tang dan
               
              
               
                for($n = 0;$n<count($arraySerialRecover);$n++){
                    $arraychuasudung[$k++] = $arraySerialRecover[$n];
                }
//                if($k=(count($arraySerialRecover))){
//                    if($arraySerialFail[0]!= 0){
//                    for($n = 0;$n<count($arraySerialFail);$n++){
//                        $arraychuasudung[$k++] = $arraySerialFail[$n];
//                    }}
//                }
                //sap xep mang tang dan
                $max = $arraychuasudung[0];
                for($n = 1; $n<count($arraychuasudung);$n++){
                    if($arraychuasudung[$n]>$max){
                         $tam = $arraychuasudung[$n];
                         $max = $tam;
                         $arraychuasudung[$n] = $tam;
                     }
                }
                //lay mang chi co nhung so serial da su dung
//                $getserial="1-20";
                $arrayserial = explode("-", $getserial);$arr = array();$p=0;
                for($n = (int)$arrayserial[0];$n<=(int)$arrayserial[1];$n++){
                    if(GlobalLib::ckeckarray($n, $arraychuasudung)==0){
                        $arr[$p++] = $n;
                    }
                }
                //tao ra chuoi serial da su dung
                $flag = "";$t="";$arrayseriallist = array();$a1=0;$dem=0;$a2=1;$co=false;
                $arrayseriallist1 = array();
                $dem = count($arr);
                $min = $arr[0];
                $flag = $min-1;
                for($n = 0; $n<count($arr);$n++){
                $tam = $arr[$n]; 
                $arrayseriallist[$a1++]=$tam;
                $arrayseriallist1[0]=$min;
                if($dem ==1){
                    $arrayseriallist1[0]=$tam;
                }elseif($tam == ($flag+1)){
                    $flag = $tam;
                    if($a1 == $dem){
                        $flag = $tam;
                        $arrayseriallist1[$a2++]="-";
                        $arrayseriallist1[$a2++]=$tam;
                    }
                    $co = true;
                }elseif ($tam > ($flag+1)) {
                    if($a1 == $dem){
                        $flag = $tam;
                        $arrayseriallist1[$a2++]=",";
                        $arrayseriallist1[$a2++]=$tam;
                        $co = true;
                    }else
                        if($co == true){
                        $arrayseriallist1[$a2++]="-";
                        $arrayseriallist1[$a2++]=$flag; 
                        $arrayseriallist1[$a2++]=",";
                        $arrayseriallist1[$a2++]=$tam;
                        $flag = $tam;$co = false;
                    }else {
                        $arrayseriallist1[$a2++]=",";
                        $arrayseriallist1[$a2++]=$tam;
                        $flag = $tam;
                    }
                }               
                }
                $arrtam = array();$a3=0;
                 $st = implode('', $arrayseriallist1);
                 $arr11= explode(",",$st);
                foreach ($arr11 as $value1) {
                    $arr12 = explode("-", $value1);
                    if(count($arr12)==1){
                        $arrtam[$a3++]=$value1;
                    }  else {
                        if((int)$arr12[0]==(int)$arr12[1]){
                             $arrtam[$a3++] = ",";
                             $arrtam[$a3++] = $arr12[0];
                        }  else {
                             $arrtam[$a3++] = ",";
                             $arrtam[$a3++] = $value1;
                        }
                       
                    }
                    
                }
                $str = implode('', $arrtam);
                $str = substr($str, 1);
//                $st = implode('', $arrayseriallist1);
                $getsoluong = count(GlobalLib::arraySerial($str));
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $getsoluong);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount.':'.'G' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                 $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, $getsoquyen);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount.':'.'H' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                 $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowCount, $str);///
                $objPHPExcel->getActiveSheet()->getStyle('I' . $rowCount.':'.'I' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                 $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount, $value->getSerial_Fail());
                $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount.':'.'J' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                 $objPHPExcel->getActiveSheet()->setCellValue('K' . $rowCount, $value->getSoLuong_XoaHuHong($value->getSerial_Fail()));
                $objPHPExcel->getActiveSheet()->getStyle('K' . $rowCount.':'.'K' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                 $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//lay ra so serial xoa bo hung hong
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
            $filename='PhieuThanhToanAnChi'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
    }
    
    public function printpaymenttonthatexportAction(){
        $this->_helper->layout->disableLayout();
            if($this->getRequest()->isPost()){
                $redirectUrl = $this->aConfig["site"]["url"]."leader/docprintpayment/list";
                 if(isset($_POST['year'])){
                    $nam = $_POST['year'];
                }
                if(isset($_POST['quarter'])){
                    $quy = $_POST['quarter'];
                }
                if(isset($_POST['month'])){
                    $thang = $_POST['month'];
                }
           
             $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 10;
            $stt=1;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('H1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('H1:L1');
            $objPHPExcel->getActiveSheet()->setCellValue('H2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('H2:L2');
            $objPHPExcel->getActiveSheet()->getStyle('H2:L2')->getFont()->setUnderline(true);
            $objPHPExcel->getActiveSheet()->getStyle('H2:L2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H1:L1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->getStyle('H2:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

            $objPHPExcel->getActiveSheet()->setCellValue('A4', "BÁO CÁO TÌNH HÌNH TỔN THẤT, XỬ LÝ ẤN CHỈ");$objPHPExcel->getActiveSheet()->mergeCells('A4:K4');
            $objPHPExcel->getActiveSheet()->getStyle("A4:K4")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A4:K4")->getFont()->setSize(14);
            $objPHPExcel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('E5', "Tháng/Quý/Năm");$objPHPExcel->getActiveSheet()->mergeCells('E5:G5');
            $objPHPExcel->getActiveSheet()->getStyle('E5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A7', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A7:A9');$objPHPExcel->getActiveSheet()->getStyle('A7:M9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("A7:A9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A7:A9")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('B7', "Họ và tên");$objPHPExcel->getActiveSheet()->mergeCells('B7:C9');
             $objPHPExcel->getActiveSheet()->getStyle("B7:C9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("B7:C9")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('D7', "Đơn vị");$objPHPExcel->getActiveSheet()->mergeCells('D7:E9');
             $objPHPExcel->getActiveSheet()->getStyle("D7:E9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("D7:E9")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('F7', "Ngày tháng xảy ra tổn thất");$objPHPExcel->getActiveSheet()->mergeCells('F7:F9');
             $objPHPExcel->getActiveSheet()->getStyle("F7:F9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("F7:F9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('G7', "Ấn chỉ bị mất, hư hỏng, hủy");$objPHPExcel->getActiveSheet()->mergeCells('G7:M7');
             $objPHPExcel->getActiveSheet()->getStyle("G7:M7")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->getStyle("G7:M7")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('G8', "Tên ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('G8:I9');
             $objPHPExcel->getActiveSheet()->getStyle("G8:I9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("G8:I9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('J8', "Ký hiệu");$objPHPExcel->getActiveSheet()->mergeCells('J8:J9');
             $objPHPExcel->getActiveSheet()->getStyle("J8:J9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("J8:J9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('K8', "Quyển số");$objPHPExcel->getActiveSheet()->mergeCells('K8:K9');
             $objPHPExcel->getActiveSheet()->getStyle("K8:K9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("K8:K9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('L8', "Từ số đến số");$objPHPExcel->getActiveSheet()->mergeCells('L8:L9');
             $objPHPExcel->getActiveSheet()->getStyle("L8:L9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("L8:L9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->setCellValue('M8', "Số lượng tờ");$objPHPExcel->getActiveSheet()->mergeCells('M8:M9');
             $objPHPExcel->getActiveSheet()->getStyle("M8:M9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->getStyle("M8:M9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//           $nam='2015';
            if(($nam !="")&&($quy=="0")&&($thang=="0")){
                $select ="select * from doc_print_payment where year(date_payment)='$nam' and  is_delete='0'";
            }elseif (($nam !="")&&($quy !="0")&&($thang=="0")) {
                $tam="";
                if($quy=="1"){
                    $tam = "1,2,3";
                }elseif ($quy=="2") {
                    $tam = "4,5,6";
                }elseif ($quy=="3") {
                    $tam ="7,8,9";
                }  else {
                    $tam ="10,11,12";
                }
                $select ="select * from doc_print_payment where year(date_payment)='$nam' and month(date_payment) in ($tam) and  is_delete='0'";
            }elseif(($nam !="")&&($thang!="0")){
                $select ="select * from doc_print_payment where year(date_payment)='$nam' and month(date_payment)= '$thang' and  is_delete='0'";
            } 
            //$select ="select * from doc_print_payment where  is_delete='0'";
           
            foreach ($this->modelMapper->fetchAlll($select) as $value) {
                $getId = $value->getId();
                $getSysDepartmentId = $value->getSys_Department_Id();
                $getUserId = $value->getSys_User_Id();
                $getDocPrintAllocationId=$value->getDoc_Print_Allocation_Id();
                $getMasterPrintId = $value->getMaster_Print_Id();
                $getSerialRecovery = $value->getSerial_Recovery();
                $getSerialFail= $value->getSerial_Fail();
                $getReasonsFail = $value->getReasons_Fail();
                $getComment = $value->getComment();
                $getDatePayment = $value->getDate_Payment();
                //lay ra doc_print_create
                $this->modelMapperPrintAllocation->find($getDocPrintAllocationId,$this->modelPrintAllocation);
                $getPrintCreate = $this->modelPrintAllocation->getDoc_Print_Create_Id();
                $this->modelMapperPrintCreate->find($getPrintCreate,$this->modelPrintCreate);
                $getQuyenSo = $this->modelPrintCreate->getCoefficient();
                $getSoLuong_XoaHong = $value->getSoLuong_XoaHuHong($getSerialFail);  
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,$stt);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'A'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'A' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'A' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::getName('sys_user', $getUserId, 'first_name').' '.GlobalLib::getName('sys_user', $getUserId, 'last_name')); 
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':'.'C'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'C' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':'.'C' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                 //don vi
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, GlobalLib::getName('sys_department', $getSysDepartmentId, 'name')); 
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':'.'E'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount.':'.'E' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount.':'.'E' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //ngay thang nam
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, GlobalLib::viewDate($getDatePayment)); 
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':'.'F'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':'.'F' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount.':'.'F' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //ten an chi
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount,  GlobalLib::getName('master_print', $getMasterPrintId, 'name'));                 
                $objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':'.'I'.$rowCount);$objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':'.'I'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount.':'.'I' . $rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                  $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'K' . $rowCount)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(30);
                    $objPHPExcel->getActiveSheet()->getStyle('I' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment);
                
                $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount.':'.'I' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //kký hieu
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount,  GlobalLib::getName('master_print', $getMasterPrintId, 'code')); 
                $objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':'.'J'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount.':'.'J' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount.':'.'J' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //quyen so
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $rowCount,  $getQuyenSo); 
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$rowCount.':'.'K'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('K' . $rowCount.':'.'K' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('K' . $rowCount.':'.'K' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //tư so den so
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $rowCount,  $getSerialFail); 
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$rowCount.':'.'L'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('L' . $rowCount.':'.'L' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('L' . $rowCount.':'.'L' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //so luong to hu hong, huy
                 //tư so den so
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $rowCount,  $getSoLuong_XoaHong); 
                $objPHPExcel->getActiveSheet()->mergeCells('M'.$rowCount.':'.'M'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount.':'.'M' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('M' . $rowCount.':'.'M' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $rowCount++;
                $stt++;
            }
            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,"....Ngày...tháng....năm....");$objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'L'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'L'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount,"Người lập biểu");$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':'.'D'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount.':'.'D'.$rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount.':'.'D'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,"Phụ trách");$objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':'.'I'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount.':'.'I'.$rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount.':'.'I'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount,"Thủ trưởng đơn vị");$objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':'.'M'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount.':'.'M'.$rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount.':'.'M'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':'.'D'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount.':'.'D'.$rowCount)->getFont()->setItalic(true);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount.':'.'D'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':'.'I'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount.':'.'I'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount.':'.'I'.$rowCount)->getFont()->setItalic(true);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount,"(Ký ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':'.'M'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount.':'.'M'.$rowCount)->getFont()->setItalic(true);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount.':'.'M'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             
                    
                  
            $rowCount++;
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1'); $objPHPExcel->getActiveSheet()->getStyle('A1:M'.$rowCount)->getFont()->setName('Times New Roman');
            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );
//            foreach (range('A', 'M') as $columnID) {
//                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
//            }
            $objPHPExcel->getActiveSheet()->getStyle("A1:A1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("F1:F1")->applyFromArray($styleArray);
            $filename='BaoCaoTonThatAnChi'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
        }
    }
    
    public function addAction(){
        $this->view->itemdepartment= $this->modelDepartment;
        $this->view->itemuser= $this->modelUser;
        if($this->getRequest()->isPost()){
            $this->_helper->layout->disableLayout();
            if(strlen($_POST["sys_department_id"])>0){
                $deparment=$_POST["sys_department_id"];
            }  else {
                 $deparment="";
            }
//             if(strlen($_POST['ngaycapphat'])<0){
//                 $ngaycapphat =date("Y/m/d H:i:s");
//             }else{
//                $ngaycapphat = GlobalLib::toMysqlDateString( $_POST['ngaycapphat']).' '.'00:00:00';
//            } 
            if(isset($_POST["sys_user_id"])){
                $us = $_POST["sys_user_id"];
            }
            
            $redirectUrl = $this->aConfig["site"]["url"]."leader/docprintpayment/listexport/pb/".$deparment."/us/".$us."" ;
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }
    public function listexportAction(){
        $this->_helper->layout->disableLayout();
        $pb=$this->_getParam("pb","");
//        $nt=$this->_getParam("nt","");
        $us=$this->_getParam("us","");
        $this->printpaymentexport($pb,$us); 
    }
    public function listAction(){ 
    }
    public function reporttonthatAction(){
       $this->view->controller = $this; 
       $now = date("Y/m/d H:i:s");
       $ar_now =    split("/",$now);
       if($this->getRequest()->isPost()){
            $this->view->nam = $_POST["nam"];  
            
            if (isset($_POST['agent_id'])){
                $agent_id = array();
                foreach ($_POST['agent_id'] as $key => $value) {
                    array_push($agent_id,$value);                
                }            
                $this->view->agent_id = implode(",", $agent_id);
            }
       }
       else $this->view->nam = intval($ar_now[0]);              
       $html_nam = "<select id='nam' name='nam' class='form-control'> ";
       for($i = intval($this->view->nam)-5;$i<=intval($this->view->nam)+5;$i++)
       {
           if($i == $this->view->nam)
            $html_nam.="<option value='".$i."' selected='selected'>".$i."</option>";
           else
               $html_nam.="<option value='".$i."'>".$i."</option>";
       };
       $html_nam.="</select>";  
       $html_thang = "<select id='thang' name='thang' class='form-control'>";
       $html_thang.="<option value='0' selected='selected'>Chọn tháng</option>";
       for($j=1;$j<=12;$j++){
           $html_thang.="<option value='".$j."'>Tháng ".$j."</option>";
       }
       $html_thang.="</select>"; 
       $html_nam.="</select>";  
       $html_quy = "<select id='quy' name='quy' class='form-control'>";
        $html_quy.="<option value='0' selected='selected'>Chọn quý</option>";
       for($j=1;$j<=4;$j++){
           $html_quy.="<option value='".$j."'>Quý ".$j."</option>";
       }
       $html_quy.="</select>";  
       $this->view->html_nam = $html_nam;
       $this->view->html_quy = $html_quy;
       $this->view->html_thang = $html_thang;
      //
      
    }
    public function servicetonthatAction(){
        $this->_helper->layout->disableLayout();
        $nam = $this->_getParam("nam","");
        $quy = $this->_getParam("quy","");
        $thang = $this->_getParam("thang","");
        if(($nam !="")&&($quy=="0")&&($thang=="0")){
            $select ="select * from doc_print_payment where year(date_payment)='$nam' and  is_delete='0'";
        }elseif (($nam !="")&&($quy !="0")&&($thang=="0")) {
            $tam="";
            if($quy=="1"){
                $tam = "1,2,3";
            }elseif ($quy=="2") {
                $tam = "4,5,6";
            }elseif ($quy=="3") {
                $tam ="7,8,9";
            }  else {
                $tam ="10,11,12";
            }
            $select ="select * from doc_print_payment where year(date_payment)='$nam' and month(date_payment) in ($tam) and  is_delete='0'";
        }elseif(($nam !="")&&($thang!="0")){
            $select ="select * from doc_print_payment where year(date_payment)='$nam' and month(date_payment)= '$thang' and  is_delete='0'";
        }
        if($this->_getParam("t","")==1){
            $select ="select * from doc_print_payment where  is_delete='0'";
        }
        
         foreach ($this->modelMapper->fetchAlll($select) as $value) {
             $getId = $value->getId();
             $getSysDepartmentId = $value->getSys_Department_Id();
             $getUserId = $value->getSys_User_Id();
             $getDocPrintAllocationId=$value->getDoc_Print_Allocation_Id();
             $getMasterPrintId = $value->getMaster_Print_Id();
             $getSerialRecovery = $value->getSerial_Recovery();
             $getSerialFail= $value->getSerial_Fail();
             $getReasonsFail = $value->getReasons_Fail();
             $getComment = $value->getComment();
             $getDatePayment = $value->getDate_Payment();
             //lay ra doc_print_create
             $this->modelMapperPrintAllocation->find($getDocPrintAllocationId,$this->modelPrintAllocation);
             $getPrintCreate = $this->modelPrintAllocation->getDoc_Print_Create_Id();
             $this->modelMapperPrintCreate->find($getPrintCreate,$this->modelPrintCreate);
             $getQuyenSo = $this->modelPrintCreate->getCoefficient();
             $getSoLuong_XoaHong = $value->getSoLuong_XoaHuHong($getSerialFail);           
             $menber[]=array(
                'id' => $value->getId(),                 
                'name_sys_department_id' =>  GlobalLib::getName('sys_department', $getSysDepartmentId, 'name'),
                'name_sys_user_id'=>  GlobalLib::getName('sys_user', $getUserId, 'first_name').' '.GlobalLib::getName('sys_user', $getUserId, 'last_name'),                 
                'name_doc_print_create'=>$getQuyenSo,
                'master_print_id' => GlobalLib::getName('master_print', $getMasterPrintId,'code' ),
                'name_print'=>  GlobalLib::getName('master_print', $getMasterPrintId,'name' ),
                'serial_fail'=> $getSerialFail,
                'date_payment'=> GlobalLib::viewDate($getDatePayment),
                'soluong'=>$getSoLuong_XoaHong,
                'comment'=>$value->getComment()               
            );
         }
        echo json_encode($menber);
        exit();
    }  
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        $null = $this->_getParam("where","");
        foreach ($this->modelMapperPrintAllocation->fetchAlllExportPrintPayment($null) as $items ) {
            if($items->getSerial_Recovery1()!= null){
                $serialrecoveryy = $items->getSerial_Recovery1();
            }  else {
                $serialrecoveryy = GlobalLib::getName('doc_print_create', $items->getDoc_Print_Create_Id(),'serial');
            }
             $menber[]=array(
                'id' => $items->getId(), 
                'sys_department_id'=>$items->getSys_Department_Id(),
                'sys_user_id'=>$items->getUser_Id(),
                'doc_print_create_id'=>$items->getDoc_Print_Create_Id(),
                'name_doc_print_create'=>GlobalLib::getName('doc_print_create', $items->getDoc_Print_Create_Id(),'coefficient'),
                'serial_doc_print_create'=>$serialrecoveryy,//GlobalLib::getName1('doc_print_create', $items->getDoc_Print_Create_Id(),'serial,serial_recovery'),
                'master_print_id'=>$items->getMaster_Print_Id(),
                'name_print'=>  GlobalLib::getName('master_print', $items->getMaster_Print_Id(),'code' ),
                'serial_recovery'=>"",
                'serial_fail'=>"",
                'reasons_fail'=>"",
                'comment'=>"",
                'dunghet'=>0
            );
        }
        echo json_encode($menber);
        exit();
    }  
    public function servicelistAction(){
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapper->fetchAll() as $items ) {
            if($items->getSerial_Fail()==""){
                $serialfail = "";
            }  else {
                $serialfail = $items->getSerial_Fail();
            }
            if($items->getSerial_Recovery()==""){
                $serialrecovery = "";
            }  else {
                $serialrecovery = $items->getSerial_Recovery();
            }
            $this->modelMapperPrintAllocation->find($items->getDoc_Print_Allocation_Id(),$this->modelPrintAllocation);
            $serial_recovery1= $this->modelMapperPrintAllocation->findidbyserialrecovery1("id",$items->getDoc_Print_Allocation_Id());
            
            $getdocprintcreateid = $this->modelPrintAllocation->getDoc_Print_Create_Id();
            $this->modelMapperPrintCreate->find($getdocprintcreateid,$this->modelPrintCreate);
            $getid = $this->modelPrintCreate->getId();
            $quyenso = GlobalLib::getName('doc_print_create', $getid, 'coefficient');
            $serial = GlobalLib::getName('doc_print_create', $getid, 'serial');
            if($serial_recovery1 == null){
                $sr = $serial;
            }  else {
                $sr = $serial_recovery1;
            }
            $trangthai =  "";
            if ($serialrecovery !="") {
                $trangthai = "Thu hồi";
            } else {
                $trangthai = "Dùng hết";
            }
            
            $menber[]=array(
                'id'=>$items->getId(),
                'sys_department_id'=>  GlobalLib::getName('sys_department',$items->getSys_Department_Id(),'code'),
                'sys_user_id'=>  GlobalLib::getName('sys_user', $items->getSys_User_Id(), 'first_name').' '.GlobalLib::getName('sys_user',  $items->getSys_User_Id(), 'last_name'),                
                'doc_print_allocation_id'=>$quyenso,
                'serial'=>$sr,
                'master_print_id'=>  GlobalLib::getName('master_print', $items->getMaster_Print_Id(), 'code'),
                'serial_recovery'=>$serialrecovery,                
                'serial_fail'=>$serialfail,
                'reasons_fail'=>$items->getReasons_Fail(),
                'date_payment'=>  GlobalLib::viewDate($items->getDate_Payment()),
                'comment'=>$items->getComment(),
                'status'=>$trangthai
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
    //Xóa
    public function deleteAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."leader/docprintpayment/list";  
        $this->modelMapper->find($id,$this->model);
        $getDocPrintAllocation = $this->model->getDoc_Print_Allocation_Id();
        $this->modelMapperPrintAllocation->updatestatusDoc_Print_Allocation($getDocPrintAllocation,'DOING');
        $this->modelMapperPrintAllocation->find($getDocPrintAllocation,$this->modelPrintAllocation);
        $getDocPrintCreateId = $this->modelPrintAllocation->getDoc_Print_Create_Id();
        $this->modelMapperPrintCreate->find($getDocPrintCreateId,$this->modelPrintCreate);
        $idprintcreate = $this->modelPrintCreate->getId();
        $this->modelMapperPrintCreate->updatestatusDoc_Print_Create($idprintcreate,'DOING');
        $this->modelMapperPrintCreate->updateserialrecoveryDoc_Print_Create($idprintcreate,'');
        $this->modelMapper->deleteDoc_Print_Payment($id);
        $this->_redirect($redirectUrl);
    }
   
}

