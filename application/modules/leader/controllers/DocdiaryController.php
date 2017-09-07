<?php
include APPLICATION_PATH . "/models/Doc_Diary.php";

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Leader_DocDiaryController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper= new Model_Doc_DiaryMapper();
        $this->model= new Model_Doc_Diary();
    }
    public function indexAction(){
       
    }
    public function addAction(){
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."leader/docdiary/list";
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(strlen($_POST["date_diary"])<=0){
                $ngay_kiem_tra = date("Y/m/d H:i:s");
            }  else {
                $ngay_kiem_tra = GlobalLib::toMysqlDateString($_POST["date_diary"]);
            }
            $this->model->setDate_Diary($ngay_kiem_tra);
            if(strlen($_POST["implementers"])){
                $this->model->setImplementers($_POST["implementers"]);
            }
            if(strlen($_POST["position"])){
                $this->model->setPosition($_POST["position"]);
            }
            if(strlen($_POST["content_inspection"])){
                $this->model->setContent_Inspection($_POST["content_inspection"]);
            }
            if(strlen($_POST["time_check"])){
                $this->model->setTime_Check($_POST["time_check"]);
            }
            if(strlen($_POST["status_and_test_results"])){
                $this->model->setStatus_And_Test_Results($_POST["status_and_test_results"]);
            }
            if(strlen($_POST["processing_results"])){
                $this->model->setProcessing_Results($_POST["processing_results"]);
            }
            if(strlen($_POST["signature"])){
                $this->model->setSignature($_POST["signature"]);
            }
            
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }
    public function editAction(){
        $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."leader/docdiary/list";
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
            if(strlen($_POST["date_diary"])<=0){
                $ngay_kiem_tra = date("Y/m/d H:i:s");
            }  else {
                $ngay_kiem_tra = GlobalLib::toMysqlDateString($_POST["date_diary"]);
            }
            $this->model->setDate_Diary($ngay_kiem_tra);
            if(strlen($_POST["implementers"])){
                $this->model->setImplementers($_POST["implementers"]);
            }
            if(strlen($_POST["position"])){
                $this->model->setPosition($_POST["position"]);
            }
            if(strlen($_POST["content_inspection"])){
                $this->model->setContent_Inspection($_POST["content_inspection"]);
            }
            if(strlen($_POST["time_check"])){
                $this->model->setTime_Check($_POST["time_check"]);
            }
            if(strlen($_POST["status_and_test_results"])){
                $this->model->setStatus_And_Test_Results($_POST["status_and_test_results"]);
            }
            if(strlen($_POST["processing_results"])){
                $this->model->setProcessing_Results($_POST["processing_results"]);
            }
            if(strlen($_POST["signature"])){
                $this->model->setSignature($_POST["signature"]);
            }
            
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->model->setIs_delete(0);
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }   
    public function listAction(){
        $this->view->fromdate="";
        $this->view->todate="";
        if($this->getRequest()->isPost()) {
            $this->view->fromdate = $_POST["fromdate"];
            $this->view->todate = $_POST["todate"];
        }
    }
    
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapper->fetchAll() as $items ) {
            $menber[]=array(
                'Id'=>$items->getId(),
                'date_diary'=>  GlobalLib::viewDate($items->getDate_Diary()),
                'implementers'=>$items->getImplementers(),                
                'position'=>$items->getPosition(),
                'content_inspection'=>$items->getContent_Inspection(),
                'time_check'=>$items->getTime_Check(),                
                'status_and_test_results'=>$items->getStatus_And_Test_Results(),
                'processing_results'=>$items->getProcessing_Results()
            );
        }
        echo json_encode($menber);
        exit();
    }
    public function servicetungaydenngayAction(){
        $this->_helper->layout->disableLayout();
        $ngaybatdau = $this->_getParam("fromdate","");
        $ngayketthuc = $this->_getParam("todate","");

        if($ngaybatdau == null && $ngayketthuc == null) {
            foreach ($this->modelMapper->fetchAll() as $items ) {
                $menber1[]=array(
                    'Id'=>$items->getId(),
                    'date_diary'=>  GlobalLib::viewDate($items->getDate_Diary()),
                    'implementers'=>$items->getImplementers(),
                    'position'=>$items->getPosition(),
                    'content_inspection'=>$items->getContent_Inspection(),
                    'time_check'=>$items->getTime_Check(),
                    'status_and_test_results'=>$items->getStatus_And_Test_Results(),
                    'processing_results'=>$items->getProcessing_Results()
                );
            }
            echo json_encode($menber1);
            exit();
        }
        else
        {
            foreach ($this->modelMapper->fetchwhereAll($ngaybatdau, $ngayketthuc) as $items) {
                $menber2[] = array(
                    'Id' => $items->getId(),
                    'date_diary' => GlobalLib::viewDate($items->getDate_Diary()),
                    'implementers' => $items->getImplementers(),
                    'position' => $items->getPosition(),
                    'content_inspection' => $items->getContent_Inspection(),
                    'time_check' => $items->getTime_Check(),
                    'status_and_test_results' => $items->getStatus_And_Test_Results(),
                    'processing_results' => $items->getProcessing_Results()
                );
            }
            echo json_encode($menber2);
            exit();
        }

    }
    
    public function printpaymenttonthatexportAction(){
        $this->_helper->layout->disableLayout();
            if($this->getRequest()->isPost()){
                $redirectUrl = $this->aConfig["site"]["url"]."leader/docdiary/list";
                if(strlen($_POST['tungay'])){
                    $tungay = $_POST['tungay'];
                }
                if(strlen($_POST['denngay'])){
                    $denngay = $_POST['denngay'];
                }
               
             $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 11;
            $stt=1;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QUẢN LÝ THỊ TRƯỜNG TỈNH, TP.....");$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "ĐỘI QUẢN LÝ THỊ TRƯỜNG………………………");$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->setCellValue('A3', "KIỂM TRA………………………");$objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            
            
            $objPHPExcel->getActiveSheet()->setCellValue('G2', "NHẬT KÝ THEO DÕI HOẠT ĐỘNG KIỂM TRA KIỂM SOÁT THỊ TRƯỜNG");$objPHPExcel->getActiveSheet()->mergeCells('G2:P2');
            $objPHPExcel->getActiveSheet()->getStyle('G2:P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); 
            $objPHPExcel->getActiveSheet()->getStyle("G2:P2")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("G2:P4")->getFont()->setSize(14);
            
            $objPHPExcel->getActiveSheet()->setCellValue('G3', "Từ ngày:");$objPHPExcel->getActiveSheet()->mergeCells('G3:H3');
            $objPHPExcel->getActiveSheet()->getStyle('G2:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('I3', $tungay); $objPHPExcel->getActiveSheet()->mergeCells('I3:K3');
//            $objPHPExcel->getActiveSheet()->getStyle('I3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             

            $objPHPExcel->getActiveSheet()->setCellValue('L3', "Đến ngày:");$objPHPExcel->getActiveSheet()->mergeCells('L3:M3');
            $objPHPExcel->getActiveSheet()->getStyle('L2:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->setCellValue('N3', $denngay); $objPHPExcel->getActiveSheet()->mergeCells('N3:P3');
//            $objPHPExcel->getActiveSheet()->getStyle('N2:P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objPHPExcel->getActiveSheet()->getStyle('G3:N3')->getFont()->setItalic(true);
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
             $objPHPExcel->getActiveSheet()->setCellValue('A5', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A5:A9');$objPHPExcel->getActiveSheet()->getStyle('A7:M9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("A5:A9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A5:A9")->getAlignment()->applyFromArray($style_alignment);
             
              
             $objPHPExcel->getActiveSheet()->setCellValue('B5', "Ngày tháng năm");$objPHPExcel->getActiveSheet()->mergeCells('B5:C9');
//             $objPHPExcel->getActiveSheet()->getStyle('B7:C9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("B5:C9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("B5:C9")->getAlignment()->applyFromArray($style_alignment);
             $objPHPExcel->getActiveSheet()->setCellValue('B10', "1");$objPHPExcel->getActiveSheet()->mergeCells('B10:C10');$objPHPExcel->getActiveSheet()->getStyle('B10:C10')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('B10:C10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            
             $objPHPExcel->getActiveSheet()->setCellValue('D5', "Họ và tên KSV được phân công kiểm tra");$objPHPExcel->getActiveSheet()->mergeCells('D5:E9');
//             $objPHPExcel->getActiveSheet()->getStyle('D7:E9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("D5:E9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("D5:E9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('D10', "2");$objPHPExcel->getActiveSheet()->mergeCells('D10:E10');$objPHPExcel->getActiveSheet()->getStyle('D10:E10')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('D10:E10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             
             $objPHPExcel->getActiveSheet()->setCellValue('F5', "Chức danh KSV khi thi hành công vụ");$objPHPExcel->getActiveSheet()->mergeCells('F5:F9');
//             $objPHPExcel->getActiveSheet()->getStyle('F7:F9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("F5:F9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("F5:F9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('F10', "3");$objPHPExcel->getActiveSheet()->mergeCells('F10:F10');$objPHPExcel->getActiveSheet()->getStyle('F10:F10')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('F10:F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             
             $objPHPExcel->getActiveSheet()->setCellValue('G5', "Đối tượng, địa bàn nội dung kiểm tra");$objPHPExcel->getActiveSheet()->mergeCells('G5:I9');
//             $objPHPExcel->getActiveSheet()->getStyle('G7:I9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("G5:I9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("G5:I9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('G10', "4");$objPHPExcel->getActiveSheet()->mergeCells('G10:I10');$objPHPExcel->getActiveSheet()->getStyle('G10:I10')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('G10:I10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             
             $objPHPExcel->getActiveSheet()->setCellValue('J5', "Thời gian kiểm tra\nTừ....giờ\nĐến...giờ");$objPHPExcel->getActiveSheet()->mergeCells('J5:J9');
//             $objPHPExcel->getActiveSheet()->getStyle('J7:J9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("J5:J9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("J5:J9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('J10', "5");$objPHPExcel->getActiveSheet()->mergeCells('J10:J10');$objPHPExcel->getActiveSheet()->getStyle('J10:J10')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('J10:J10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             
             $objPHPExcel->getActiveSheet()->setCellValue('K5', "Tình hình kiểm tra và kết quả kiểm tra");$objPHPExcel->getActiveSheet()->mergeCells('K5:N9');
//             $objPHPExcel->getActiveSheet()->getStyle('K5:N9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("K5:N9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("K5:N9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('K10', "6");$objPHPExcel->getActiveSheet()->mergeCells('K10:N10');$objPHPExcel->getActiveSheet()->getStyle('K10:N10')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('K10:N10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             
             $objPHPExcel->getActiveSheet()->setCellValue('O5', "Kết quả xử lý");$objPHPExcel->getActiveSheet()->mergeCells('O5:P9');
//             $objPHPExcel->getActiveSheet()->getStyle('O5:P9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("O5:P9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("O5:P9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('O10', "7");$objPHPExcel->getActiveSheet()->mergeCells('O10:P10');$objPHPExcel->getActiveSheet()->getStyle('O10:P10')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('O10:P10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             
             $objPHPExcel->getActiveSheet()->setCellValue('Q5', "Đại diện Đội, Tổ kiểm tra ký sổ");$objPHPExcel->getActiveSheet()->mergeCells('Q5:R9');
//             $objPHPExcel->getActiveSheet()->getStyle('Q5:R9')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle("Q5:R9")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("Q5:R9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
             $objPHPExcel->getActiveSheet()->setCellValue('Q10', "8");$objPHPExcel->getActiveSheet()->mergeCells('Q10:R10');$objPHPExcel->getActiveSheet()->getStyle('Q10:R10')->getFont()->setBold(true);
             $objPHPExcel->getActiveSheet()->getStyle('Q10:R10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
             $objPHPExcel->getActiveSheet()->getStyle('A10:'.'Q10')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             
             foreach ($this->modelMapper->fetchwhereAll($tungay,$denngay) as $value ) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,$stt);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'A'.$rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'A'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                 
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount,GlobalLib::viewDate($value->getDate_Diary()));$objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':'.'C'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount.':'.'C'.$rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount.':'.'C'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount,$value->getImplementers());$objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':E'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount.':E'.$rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount.':'.'E'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                   
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $value->getPosition());$objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':F'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount.':F'.$rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount.':'.'F'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                  
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $value->getContent_Inspection());$objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':'.'I'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':'.'I'.$rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':'.'I'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                   
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $value->getTime_Check());$objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':'.'J'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount.':'.'J'.$rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount.':'.'J'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$rowCount, $value->getStatus_And_Test_Results());$objPHPExcel->getActiveSheet()->mergeCells('K'.$rowCount.':'.'N'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$rowCount.':'.'N'.$rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$rowCount.':'.'N'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$rowCount, $value->getProcessing_Results());$objPHPExcel->getActiveSheet()->mergeCells('O'.$rowCount.':'.'P'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount.':'.'P'.$rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                 $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount.':'.'P'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$rowCount, $value->getSignature());$objPHPExcel->getActiveSheet()->mergeCells('Q'.$rowCount.':'.'R'.$rowCount);
                $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount.':'.'R'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                   
                $rowCount++;
                $stt++;
            }
            
            $rowCount++;
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1'); $objPHPExcel->getActiveSheet()->getStyle('A1:R'.$rowCount)->getFont()->setName('Times New Roman');
            $styleArray = array(
                'font' => array(
                    'bold' => true
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle("A1:A1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("F1:F1")->applyFromArray($styleArray);
            $filename='NhatKyTheoDoiHoatDongKiemTraKiemSoatThiTruong'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
        }
    }
    
    public function deleteAction(){
        $id= $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."leader/docdiary/list"; 
        $this->modelMapper->deleteDoc_Diary($id);
        $this->_redirect($redirectUrl);        
    }    
    
    
   
}
