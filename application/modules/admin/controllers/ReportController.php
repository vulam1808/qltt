<?php
include APPLICATION_PATH . "/models/Report.php";
include APPLICATION_PATH."/models/Master_Print.php";
include APPLICATION_PATH."/models/Doc_Print_Create.php";
//include APPLICATION_PATH . "/models/Doc_Violations_Handling.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_ReportController extends Zend_Controller_Action{
    public function init(){       
        $bootstrap = $this->getInvokeArg("bootstrap");
        $this->aConfig = $bootstrap->getOptions();
        $this->view->aConfig = $this->aConfig;
        $this->modelMapper = new Model_ReportMapper();
        $this->model= new Model_Report(); 
        $this->modelDocPrintCreate= new Model_Doc_Print_Create();
        $this->modelMapperDocPrintCreate = new Model_Doc_Print_CreateMapper();
        $this->modelmasterprint= new Model_Master_Print();
        $this->modelMappermasterprint = new Model_Master_PrintMapper();
        //$this->modelViolationHandlingMapper= new Model_Doc_Violations_HandlingMapper();
    }
    public function indexAction(){      
    }
     public function mangementprintAction(){      
    }
    public function mangementuseprintAction(){      
    }
    public function mangementuseprintbysysdepartmentAction(){      
    }
    public function exportmangementprintAction() {
        $this->_helper->layout->disableLayout();
            $redirectUrl = $this->aConfig["site"]["url"]."admin/report/mangementprint";
            $month = $this->_getParam("month","");
            $year = $this->_getParam("year","");
            $print_id = $this->_getParam("master_print_id","");
            if(empty($month) || empty($year)|| empty($print_id))
            {
                $this->_redirect($redirectUrl);
                return;
            }
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 13;
            $stt=1;
             $styledataArray = array(
                'font' => array(
                    'color' => array('rgb' => '080808'),
                    'size' => 13,
                    'name' => 'Times New Roman'
            ));
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QUẢN LÝ THỊ TRƯỜNG BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
            //$objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");
            $objPHPExcel->getActiveSheet()->setCellValue('M1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('M1:R1');
            $objPHPExcel->getActiveSheet()->setCellValue('M2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('M2:R2');			
            $objPHPExcel->getActiveSheet()->getStyle("M1:R2")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
           
            $objPHPExcel->getActiveSheet()->setCellValue('D4', "THEO DÕI TÌNH HÌNH ẤN CHỈ");$objPHPExcel->getActiveSheet()->mergeCells('D4:P4');
            $objPHPExcel->getActiveSheet()->getStyle("D4:P4")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->getStyle("D4:E4")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('D6', "Tên ấn chỉ: ".$this->modelMappermasterprint->findidby('name','id',$print_id));$objPHPExcel->getActiveSheet()->mergeCells('D5:G5');
            $objPHPExcel->getActiveSheet()->setCellValue('D7', "Ký hiệu: ".$this->modelMappermasterprint->findidby('code','id',$print_id));$objPHPExcel->getActiveSheet()->mergeCells('D5:G5');
              $objPHPExcel->getActiveSheet()->getStyle("A1:G7")->applyFromArray($styledataArray);   
           
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'=> true
            );
             $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A10', "Chứng từ");$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
             //$objPHPExcel->getActiveSheet()->getStyle("A10:B10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("A10:B10")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('A11', "Số");$objPHPExcel->getActiveSheet()->mergeCells('A11:A12');
             //$objPHPExcel->getActiveSheet()->getStyle("A11:A12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("A11:A12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('B11', "Ngày tháng");$objPHPExcel->getActiveSheet()->mergeCells('B11:B12');
             //$objPHPExcel->getActiveSheet()->getStyle("B11:B12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("B11:B12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('C10', "Diễn giải");$objPHPExcel->getActiveSheet()->mergeCells('C10:C12');
             //$objPHPExcel->getActiveSheet()->getStyle("C10:C12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("C10:C12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('D10', "Đơn vị tính");$objPHPExcel->getActiveSheet()->mergeCells('D10:D12');
             //$objPHPExcel->getActiveSheet()->getStyle("D10:D12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("D10:D12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('E10', "Số lượng quyển");$objPHPExcel->getActiveSheet()->mergeCells('E10:E12');
             //$objPHPExcel->getActiveSheet()->getStyle("E10:E12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("E10:E12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('F10', "Quyển số");$objPHPExcel->getActiveSheet()->mergeCells('F10:F12');
             //$objPHPExcel->getActiveSheet()->getStyle("F10:F12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("F10:F12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('G10', "Từ số đến số");$objPHPExcel->getActiveSheet()->mergeCells('G10:G12');
             //$objPHPExcel->getActiveSheet()->getStyle("G10:G12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("G10:G12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('H10', "Tồn đầu kỳ");$objPHPExcel->getActiveSheet()->mergeCells('H10:J10');
             //$objPHPExcel->getActiveSheet()->getStyle("H10:J10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("H10:J10")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('H11', "Tổng số");$objPHPExcel->getActiveSheet()->mergeCells('H11:H12');
             //$objPHPExcel->getActiveSheet()->getStyle("H11:H12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("H11:H12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('I11', "Từ số đến số");$objPHPExcel->getActiveSheet()->mergeCells('I11:I12');
             //$objPHPExcel->getActiveSheet()->getStyle("I11:I12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("I11:I12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('J11', "Quyển số");$objPHPExcel->getActiveSheet()->mergeCells('J11:J12');
             //$objPHPExcel->getActiveSheet()->getStyle("J11:J12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("J11:J12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('K10', "Nhập trong kỳ");$objPHPExcel->getActiveSheet()->mergeCells('K10:M10');
             //$objPHPExcel->getActiveSheet()->getStyle("K10:M10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("K10:M10")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('K11', "Tổng số");$objPHPExcel->getActiveSheet()->mergeCells('K11:K12');
             //$objPHPExcel->getActiveSheet()->getStyle("K11:K12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("K11:K12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('L11', "Từ số đến số");$objPHPExcel->getActiveSheet()->mergeCells('L11:L12');
             //$objPHPExcel->getActiveSheet()->getStyle("L11:L12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("L11:L12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('M11', "Quyển số");$objPHPExcel->getActiveSheet()->mergeCells('M11:M12');
             //$objPHPExcel->getActiveSheet()->getStyle("M11:M12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("M11:M12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('N10', "Xuất trong kỳ");$objPHPExcel->getActiveSheet()->mergeCells('N10:Q10');
             //$objPHPExcel->getActiveSheet()->getStyle("N10:Q10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("N10:Q10")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('N11', "Tổng số");$objPHPExcel->getActiveSheet()->mergeCells('N11:N12');
             //$objPHPExcel->getActiveSheet()->getStyle("N11:N12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("N11:N12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('O11', "Từ số đến số");$objPHPExcel->getActiveSheet()->mergeCells('O11:O12');
             //$objPHPExcel->getActiveSheet()->getStyle("O11:O12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("O11:O12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('P11', "Quyển số");$objPHPExcel->getActiveSheet()->mergeCells('P11:P12');
             //$objPHPExcel->getActiveSheet()->getStyle("P11:P12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("P11:P12")->getAlignment()->applyFromArray($style_alignment);
             
               $objPHPExcel->getActiveSheet()->setCellValue('Q11', "Số hủy");$objPHPExcel->getActiveSheet()->mergeCells('Q11:Q12');
             //$objPHPExcel->getActiveSheet()->getStyle("Q11:Q12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("Q11:Q12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('R10', "Tồn cuối kỳ");$objPHPExcel->getActiveSheet()->mergeCells('R10:T10');
             //$objPHPExcel->getActiveSheet()->getStyle("R10:T10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("R10:T10")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('R11', "Từ số đến số");$objPHPExcel->getActiveSheet()->mergeCells('R11:R12');
             //$objPHPExcel->getActiveSheet()->getStyle("R11:R12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("R11:R12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('S11', "Quyển số");$objPHPExcel->getActiveSheet()->mergeCells('S11:S12');
             //$objPHPExcel->getActiveSheet()->getStyle("S11:S12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("S11:S12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->setCellValue('T11', "Tổng số");$objPHPExcel->getActiveSheet()->mergeCells('T11:T12');
             //$objPHPExcel->getActiveSheet()->getStyle("T11:T12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             //$objPHPExcel->getActiveSheet()->getStyle("T11:T12")->getAlignment()->applyFromArray($style_alignment);
             
             $objPHPExcel->getActiveSheet()->getStyle("A10:T12")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A10:T12")->getAlignment()->applyFromArray($style_alignment);
             
             //thuc hien xuat du lieu ra file excel
            //lẤY DỮ LIỆU NHẬP TRONG KỲ
             
              foreach ($this->modelMapperDocPrintCreate->getImportExportPrint($month,$year,$print_id) as $value)
              {

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount,$value['invoice_number']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, GlobalLib::viewDate($value['created_date'],false));
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, 'Cuốn');
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowCount, '1');
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $value['coefficient']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $value['serial']);
                    if($value['status'] == 'TonDauKy')
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, '1');
                        if(strlen($value['serial_recovery']) > 0)
                        {
                            $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowCount, $value['serial_recovery']);
                        }
                        else
                        {
                            $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowCount, $value['serial']);
                        }

                        $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount, $value['coefficient']);


                    }
                    if($value['status'] == 'Import' || $value['status'] == 'Import And Export')
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue('K' . $rowCount, '1');
                        $objPHPExcel->getActiveSheet()->setCellValue('L' . $rowCount, $value['serial']);
                        $objPHPExcel->getActiveSheet()->setCellValue('M' . $rowCount, $value['coefficient']);

                        //Tồn
                        if($value['status'] == 'Import')
                        {
                            $objPHPExcel->getActiveSheet()->setCellValue('R' . $rowCount, $value['serial']);
                            $objPHPExcel->getActiveSheet()->setCellValue('S' . $rowCount,  $value['coefficient']);
                            $objPHPExcel->getActiveSheet()->setCellValue('T' . $rowCount,'1');
                        }

                    }
                      if($value['status'] == 'Export' || $value['status'] == 'Import And Export')
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $rowCount, '1');
                        $objPHPExcel->getActiveSheet()->setCellValue('O' . $rowCount, $value['serial']);
                        $objPHPExcel->getActiveSheet()->setCellValue('P' . $rowCount, $value['coefficient']);
                        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $rowCount, $value['serial_fail']);
                        if(strlen($value['serial_recovery']) > 0)
                        {
                            $objPHPExcel->getActiveSheet()->setCellValue('R' . $rowCount, $value['serial_recovery']);
                            $objPHPExcel->getActiveSheet()->setCellValue('S' . $rowCount,  $value['coefficient']);
                            $objPHPExcel->getActiveSheet()->setCellValue('T' . $rowCount,'1');
                        }

                    }
                     $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'T' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                     $objPHPExcel->getActiveSheet()->getStyle('C11:C' . $rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount.':'.'T' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $rowCount++;
              }
          
            $styleArray = array(
                'font' => array(
                    'bold' => true
                ),
            );
            $objPHPExcel->getActiveSheet()->setCellValue('P'. $rowCount, "....,ngày....tháng....năm");
            $objPHPExcel->getActiveSheet()->mergeCells('P'.$rowCount.':T'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount.':T'.$rowCount)->getAlignment()->applyFromArray(
                                 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
            
            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $rowCount, "NGƯỜI LẬP BIỂU");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':E'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('P'. $rowCount, "THỦ TRƯỞNG ĐƠN VỊ");$objPHPExcel->getActiveSheet()->mergeCells('P'.$rowCount.':T'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':P'.$rowCount)->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':P'.$rowCount)->applyFromArray($styleArray);
              
            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('P'. $rowCount, "(Ký, ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('P'.$rowCount.':T'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $rowCount, "(Ký, ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':E'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':P'.$rowCount)->getAlignment()->applyFromArray($style_alignment);
            
            $objPHPExcel->getActiveSheet()->getStyle("A1:L2")->applyFromArray($styleArray);
             $objPHPExcel->getActiveSheet()->getStyle("A10:T12")->applyFromArray($styleArray);
             $objPHPExcel->getActiveSheet()->getStyle('A1:L'.$rowCount)->getFont()->setName('Times New Roman');
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            //$objPHPExcel->getActiveSheet()->getStyle("A3:K" . $rowCount)->getAlignment()->applyFromArray($style_alignment);
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
            //tên file excel
            $filename='BaoCaoTheoDoiTinhHinhAnChi'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
    }
    public function exportmangementuseprintAction() {
        $this->_helper->layout->disableLayout();
            //$redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/list";
            $month = $this->_getParam("month","");
            $year = $this->_getParam("year","");
            $quarter = $this->_getParam("quarter","");
            $actionExport= $this->_getParam("actionExport","");
            if(empty($actionExport) || empty($year))
            {
                $this->_redirect($redirectUrl);
                return;
            }
            $from ;$to;
            if($actionExport == "QUY")
            {
                if(empty($quarter))
                {
                    $this->_redirect($redirectUrl);
                    return;
                }
                if($quarter == "I")
                {
                    $from = $year."-01-01";
                    $to = $year."-03-31";
                }
                else if($quarter == "II")
                {
                    $from = $year."-04-01";
                    $to = $year."-06-30";
                }
                else if($quarter == "III")
                {
                     $from = $year."-07-01";
                    $to = $year."-09-30";
                }
                 else if($quarter == "IV")
                {
                    $from = $year."-10-01";
                    $to = $year."-12-31";
                }
            }
            if($actionExport == "THANG")
            {
                 $from = date_format(new DateTime($year."-".$month."-01"), 'Y-m-d');
                 $nextMonth = $month+1;
                 $nextdate = new DateTime($year."-".$nextMonth."-01");
                 date_add($nextdate, date_interval_create_from_date_string('-1 days'));
                 $to = date_format($nextdate, 'Y-m-d');
            }   
            if($actionExport == "YEAR")
            {
                 $from = $year."-01-01";
                    $to = $year."-12-31";
            }  
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 11;
            $stt=1;
             $styledataArray = array(
                'font' => array(
                    'color' => array('rgb' => '080808'),
                    'size' => 13,
                    'name' => 'Times New Roman'
            ));
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QUẢN LÝ THỊ TRƯỜNG BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
            $objPHPExcel->getActiveSheet()->setCellValue('M1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('M1:R1');
            $objPHPExcel->getActiveSheet()->setCellValue('M2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('M2:R2');			
            $objPHPExcel->getActiveSheet()->getStyle("M1:R2")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
           
            $objPHPExcel->getActiveSheet()->setCellValue('D4', "BÁO CÁO THEO DÕI TÌNH HÌNH SỬ DỤNG ẤN CHỈ TRONG THÁNG/QUÝ/NĂM");$objPHPExcel->getActiveSheet()->mergeCells('D4:P4');
            $objPHPExcel->getActiveSheet()->getStyle("D4:P4")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->getStyle("D4:E4")->getFont()->setBold(true);
//            $objPHPExcel->getActiveSheet()->setCellValue('D6', "Tên ấn chỉ: ".$this->modelMappermasterprint->findidby('name','id',$print_id));$objPHPExcel->getActiveSheet()->mergeCells('D5:G5');
//            $objPHPExcel->getActiveSheet()->setCellValue('J6', "Ký hiệu: ".$this->modelMappermasterprint->findidby('code','id',$print_id));$objPHPExcel->getActiveSheet()->mergeCells('J6:L6');
            $objPHPExcel->getActiveSheet()->getStyle("A1:T6")->applyFromArray($styledataArray);   
           
            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'=> true
            );
             $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A7', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A7:A10');
         
             $objPHPExcel->getActiveSheet()->setCellValue('B7', "Mã ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('B7:B10');

             $objPHPExcel->getActiveSheet()->setCellValue('C7', "Tên loại");$objPHPExcel->getActiveSheet()->mergeCells('C7:C10');
             $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            
             $objPHPExcel->getActiveSheet()->setCellValue('D7', "Ký hiệu");$objPHPExcel->getActiveSheet()->mergeCells('D7:D10');
            
             $objPHPExcel->getActiveSheet()->setCellValue('E7', "Số tồn đầu kỳ, mua/in phát hành/nhận trong kỳ");$objPHPExcel->getActiveSheet()->mergeCells('E7:I7');
             
             $objPHPExcel->getActiveSheet()->setCellValue('E8', "Tổng số");$objPHPExcel->getActiveSheet()->mergeCells('E8:E10');
             
             $objPHPExcel->getActiveSheet()->setCellValue('F8', "Tồn đầu kỳ");$objPHPExcel->getActiveSheet()->mergeCells('F8:G8');
            
             $objPHPExcel->getActiveSheet()->setCellValue('F9', "Từ số");$objPHPExcel->getActiveSheet()->mergeCells('F9:F10');
            
             $objPHPExcel->getActiveSheet()->setCellValue('G9', "Đến số");$objPHPExcel->getActiveSheet()->mergeCells('G9:G10');
             
             $objPHPExcel->getActiveSheet()->setCellValue('H8', "Mua/in phát hành/nhận");$objPHPExcel->getActiveSheet()->mergeCells('H8:I8');
            
             $objPHPExcel->getActiveSheet()->setCellValue('H9', "Từ số");$objPHPExcel->getActiveSheet()->mergeCells('H9:H10');
           
             $objPHPExcel->getActiveSheet()->setCellValue('I9', "Đến số");$objPHPExcel->getActiveSheet()->mergeCells('I9:I10');
            
             $objPHPExcel->getActiveSheet()->setCellValue('J7', "Sử dụng, xóa bỏ, mất, hỏng trong kỳ");$objPHPExcel->getActiveSheet()->mergeCells('J7:S7');
             
             $objPHPExcel->getActiveSheet()->setCellValue('J8', "Tổng số");$objPHPExcel->getActiveSheet()->mergeCells('J8:L8');
            
             $objPHPExcel->getActiveSheet()->setCellValue('J9', "Từ số ");$objPHPExcel->getActiveSheet()->mergeCells('J9:J10');
           
             $objPHPExcel->getActiveSheet()->setCellValue('K9', "Đến số");$objPHPExcel->getActiveSheet()->mergeCells('K9:K10');
            
             $objPHPExcel->getActiveSheet()->setCellValue('L9', "Tổng");$objPHPExcel->getActiveSheet()->mergeCells('L9:L10');
             
             $objPHPExcel->getActiveSheet()->setCellValue('M9', "Số lượng đã sử dụng");$objPHPExcel->getActiveSheet()->mergeCells('M9:M10');
           
             $objPHPExcel->getActiveSheet()->setCellValue('N9', "Xóa bỏ");$objPHPExcel->getActiveSheet()->mergeCells('N9:O9');
             
             $objPHPExcel->getActiveSheet()->setCellValue('N10', "Số lượng");
             
             $objPHPExcel->getActiveSheet()->setCellValue('O10', "Số");
          
             $objPHPExcel->getActiveSheet()->setCellValue('P9', "Hết");$objPHPExcel->getActiveSheet()->mergeCells('P9:Q9');
          
             $objPHPExcel->getActiveSheet()->setCellValue('P10', "Số lượng");
           
             $objPHPExcel->getActiveSheet()->setCellValue('Q10', "Số");
            
             $objPHPExcel->getActiveSheet()->setCellValue('R9', "Hủy");$objPHPExcel->getActiveSheet()->mergeCells('R9:S9');
             $objPHPExcel->getActiveSheet()->setCellValue('R10', "Số lượng");
             $objPHPExcel->getActiveSheet()->setCellValue('S10', "Số");
             
             $objPHPExcel->getActiveSheet()->setCellValue('T7', "Tồn cuối kỳ");$objPHPExcel->getActiveSheet()->mergeCells('T7:V7');
             $objPHPExcel->getActiveSheet()->setCellValue('T8', "Từ số");$objPHPExcel->getActiveSheet()->mergeCells('T8:T10');
             $objPHPExcel->getActiveSheet()->setCellValue('U8', "Tới số");$objPHPExcel->getActiveSheet()->mergeCells('U8:U10');
             $objPHPExcel->getActiveSheet()->setCellValue('V8', "Số lượng");$objPHPExcel->getActiveSheet()->mergeCells('V8:V10');
             
             $objPHPExcel->getActiveSheet()->getStyle("A7:V10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A7:V10")->getAlignment()->applyFromArray($style_alignment);
             
             //thuc hien xuat du lieu ra file excel
            //lẤY DỮ LIỆU NHẬP TRONG KỲ
             
              foreach ($this->modelMapperDocPrintCreate->getUsePrint($from,$to) as $value)
              {
                 $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount,$stt);
                 $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount,$value['Code']);
                 $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount,$value['Name']);
                 $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount,$value['Name']);
                 $tong = $value['TDK_Tong'] + $value['TrongKy_TongSo'];
                  $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowCount,$tong);
                 $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount,$value['TDK_TuSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount,$value['TDK_Denso']);
                  $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount,$value['TrongKy_TuSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowCount,$value['TrongKy_DenSo']);
                  
                   $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount,$value['SuDung_TuSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('K' . $rowCount,$value['SuDung_DenSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('L' . $rowCount,$value['SuDung_Tong']);
                  
                   $objPHPExcel->getActiveSheet()->setCellValue('M' . $rowCount,$value['SuDung_Tong']);
                   
                  $objPHPExcel->getActiveSheet()->setCellValue('N' . $rowCount,$value['XoaBo_SoLuong']);
                  $objPHPExcel->getActiveSheet()->setCellValue('O' . $rowCount,$value['XoaBo_So']);
                  
                   $objPHPExcel->getActiveSheet()->setCellValue('P' . $rowCount,$value['Het_SoLuong']);
                  $objPHPExcel->getActiveSheet()->setCellValue('Q' . $rowCount,$value['Het_So']);
                  
                  $objPHPExcel->getActiveSheet()->setCellValue('R' . $rowCount,$value['Huy_SoLuong']);
                  $objPHPExcel->getActiveSheet()->setCellValue('S' . $rowCount,$value['Huy_So']);
                  
                  $objPHPExcel->getActiveSheet()->setCellValue('T' . $rowCount,$value['TCK_TuSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('U' . $rowCount,$value['TCK_DenSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('V' . $rowCount,$value['Het_SoLuong']);
                  
                  $rowCount++;
                    $stt++;
              }
               $rowCount--;
                    $objPHPExcel->getActiveSheet()->getStyle('A11:V' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                  $objPHPExcel->getActiveSheet()->getStyle('A11:V' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                   $objPHPExcel->getActiveSheet()->getStyle('C11:C' . $rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                       $rowCount++;
//                 
//          
            $styleArray = array(
                'font' => array(
                    'bold' => true
                ),
            );
            $objPHPExcel->getActiveSheet()->setCellValue('P'. $rowCount, "....,ngày....tháng....năm");
            $objPHPExcel->getActiveSheet()->mergeCells('P'.$rowCount.':T'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount.':T'.$rowCount)->getAlignment()->applyFromArray(
                                 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
            
            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $rowCount, "NGƯỜI LẬP BIỂU");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':E'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('P'. $rowCount, "THỦ TRƯỞNG ĐƠN VỊ");$objPHPExcel->getActiveSheet()->mergeCells('P'.$rowCount.':T'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':P'.$rowCount)->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':P'.$rowCount)->applyFromArray($styleArray);
              
            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('P'. $rowCount, "(Ký, ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('P'.$rowCount.':T'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $rowCount, "(Ký, ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':E'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':P'.$rowCount)->getAlignment()->applyFromArray($style_alignment);
            
            $objPHPExcel->getActiveSheet()->getStyle("A1:L2")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("A7:V10")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A1:L'.$rowCount)->getFont()->setName('Times New Roman');
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            //$objPHPExcel->getActiveSheet()->getStyle("A3:K" . $rowCount)->getAlignment()->applyFromArray($style_alignment);
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
            //tên file excel
            $filename='BaoCaoTinhHinhSuDungAnChi'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
    }
    public function exportmangementuseprintbysysdepartmentAction() {
        $this->_helper->layout->disableLayout();
            //$redirectUrl = $this->aConfig["site"]["url"]."admin/docprintcreate/list";
            $month = $this->_getParam("month","");
            $year = $this->_getParam("year","");
            $quarter = $this->_getParam("quarter","");
            $sys_department_id = $this->_getParam("sys_department_id","");
            $actionExport= $this->_getParam("actionExport","");
            if(empty($actionExport) || empty($year))
            {
                $this->_redirect($redirectUrl);
                return;
            }
            $from ;$to;
            if($actionExport == "QUY")
            {
                if(empty($quarter))
                {
                    $this->_redirect($redirectUrl);
                    return;
                }
                if($quarter == "I")
                {
                    $from = $year."-01-01";
                    $to = $year."-03-31";
                }
                else if($quarter == "II")
                {
                    $from = $year."-04-01";
                    $to = $year."-06-30";
                }
                else if($quarter == "III")
                {
                     $from = $year."-07-01";
                    $to = $year."-09-30";
                }
                 else if($quarter == "IV")
                {
                    $from = $year."-10-01";
                    $to = $year."-12-31";
                }
            }
            if($actionExport == "THANG")
            {
                 $from = date_format(new DateTime($year."-".$month."-01"), 'Y-m-d');
                 $nextMonth = $month+1;
                 $nextdate = new DateTime($year."-".$nextMonth."-01");
                 date_add($nextdate, date_interval_create_from_date_string('-1 days'));
                 $to = date_format($nextdate, 'Y-m-d');
            }   
            if($actionExport == "NAM")
            {
                 $from = $year."-01-01";
                 $to = $year."-12-31";
            }  
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $rowCount = 11;
            $stt=1;
             $styledataArray = array(
                'font' => array(
                    'color' => array('rgb' => '080808'),
                    'size' => 13,
                    'name' => 'Times New Roman'
            ));
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QUẢN LÝ THỊ TRƯỜNG BÌNH ĐỊNH");$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
            $objPHPExcel->getActiveSheet()->setCellValue('M1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");$objPHPExcel->getActiveSheet()->mergeCells('M1:R1');
            $objPHPExcel->getActiveSheet()->setCellValue('M2', "Độc lập - Tự do - Hạnh phúc");$objPHPExcel->getActiveSheet()->mergeCells('M2:R2');
            $objPHPExcel->getActiveSheet()->getStyle("M1:R2")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );

            $objPHPExcel->getActiveSheet()->setCellValue('D4', "BÁO CÁO THEO DÕI TÌNH HÌNH SỬ DỤNG ẤN CHỈ TRONG THÁNG/QUÝ/NĂM");$objPHPExcel->getActiveSheet()->mergeCells('D4:P4');
            $objPHPExcel->getActiveSheet()->getStyle("D4:P4")->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
            );
            $objPHPExcel->getActiveSheet()->getStyle("D4:E4")->getFont()->setBold(true);
//            $objPHPExcel->getActiveSheet()->setCellValue('D6', "Tên ấn chỉ: ".$this->modelMappermasterprint->findidby('name','id',$print_id));$objPHPExcel->getActiveSheet()->mergeCells('D5:G5');
//            $objPHPExcel->getActiveSheet()->setCellValue('J6', "Ký hiệu: ".$this->modelMappermasterprint->findidby('code','id',$print_id));$objPHPExcel->getActiveSheet()->mergeCells('J6:L6');
            $objPHPExcel->getActiveSheet()->getStyle("A1:T6")->applyFromArray($styledataArray);

            //BANG
            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'=> true
            );
            $style_alignmentleft = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
             $objPHPExcel->getActiveSheet()->setCellValue('A7', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A7:A10');

             $objPHPExcel->getActiveSheet()->setCellValue('B7', "Mã ấn chỉ");$objPHPExcel->getActiveSheet()->mergeCells('B7:B10');

             $objPHPExcel->getActiveSheet()->setCellValue('C7', "Tên loại");$objPHPExcel->getActiveSheet()->mergeCells('C7:C10');
             $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);

             $objPHPExcel->getActiveSheet()->setCellValue('D7', "Ký hiệu");$objPHPExcel->getActiveSheet()->mergeCells('D7:D10');

             $objPHPExcel->getActiveSheet()->setCellValue('E7', "Số tồn đầu kỳ, mua/in phát hành/nhận trong kỳ");$objPHPExcel->getActiveSheet()->mergeCells('E7:I7');

             $objPHPExcel->getActiveSheet()->setCellValue('E8', "Tổng số");$objPHPExcel->getActiveSheet()->mergeCells('E8:E10');

             $objPHPExcel->getActiveSheet()->setCellValue('F8', "Tồn đầu kỳ");$objPHPExcel->getActiveSheet()->mergeCells('F8:G8');

             $objPHPExcel->getActiveSheet()->setCellValue('F9', "Từ số");$objPHPExcel->getActiveSheet()->mergeCells('F9:F10');

             $objPHPExcel->getActiveSheet()->setCellValue('G9', "Đến số");$objPHPExcel->getActiveSheet()->mergeCells('G9:G10');

             $objPHPExcel->getActiveSheet()->setCellValue('H8', "Mua/in phát hành/nhận");$objPHPExcel->getActiveSheet()->mergeCells('H8:I8');

             $objPHPExcel->getActiveSheet()->setCellValue('H9', "Từ số");$objPHPExcel->getActiveSheet()->mergeCells('H9:H10');

             $objPHPExcel->getActiveSheet()->setCellValue('I9', "Đến số");$objPHPExcel->getActiveSheet()->mergeCells('I9:I10');

             $objPHPExcel->getActiveSheet()->setCellValue('J7', "Sử dụng, xóa bỏ, mất, hỏng trong kỳ");$objPHPExcel->getActiveSheet()->mergeCells('J7:S7');

             $objPHPExcel->getActiveSheet()->setCellValue('J8', "Tổng số");$objPHPExcel->getActiveSheet()->mergeCells('J8:L8');

             $objPHPExcel->getActiveSheet()->setCellValue('J9', "Từ số ");$objPHPExcel->getActiveSheet()->mergeCells('J9:J10');

             $objPHPExcel->getActiveSheet()->setCellValue('K9', "Đến số");$objPHPExcel->getActiveSheet()->mergeCells('K9:K10');

             $objPHPExcel->getActiveSheet()->setCellValue('L9', "Tổng");$objPHPExcel->getActiveSheet()->mergeCells('L9:L10');

             $objPHPExcel->getActiveSheet()->setCellValue('M9', "Số lượng đã sử dụng");$objPHPExcel->getActiveSheet()->mergeCells('M9:M10');

             $objPHPExcel->getActiveSheet()->setCellValue('N9', "Xóa bỏ");$objPHPExcel->getActiveSheet()->mergeCells('N9:O9');

             $objPHPExcel->getActiveSheet()->setCellValue('N10', "Số lượng");

             $objPHPExcel->getActiveSheet()->setCellValue('O10', "Số");

             $objPHPExcel->getActiveSheet()->setCellValue('P9', "Hết");$objPHPExcel->getActiveSheet()->mergeCells('P9:Q9');

             $objPHPExcel->getActiveSheet()->setCellValue('P10', "Số lượng");

             $objPHPExcel->getActiveSheet()->setCellValue('Q10', "Số");

             $objPHPExcel->getActiveSheet()->setCellValue('R9', "Hủy");$objPHPExcel->getActiveSheet()->mergeCells('R9:S9');
             $objPHPExcel->getActiveSheet()->setCellValue('R10', "Số lượng");
             $objPHPExcel->getActiveSheet()->setCellValue('S10', "Số");

             $objPHPExcel->getActiveSheet()->setCellValue('T7', "Tồn cuối kỳ");$objPHPExcel->getActiveSheet()->mergeCells('T7:V7');
             $objPHPExcel->getActiveSheet()->setCellValue('T8', "Từ số");$objPHPExcel->getActiveSheet()->mergeCells('T8:T10');
             $objPHPExcel->getActiveSheet()->setCellValue('U8', "Tới số");$objPHPExcel->getActiveSheet()->mergeCells('U8:U10');
             $objPHPExcel->getActiveSheet()->setCellValue('V8', "Số lượng");$objPHPExcel->getActiveSheet()->mergeCells('V8:V10');

             $objPHPExcel->getActiveSheet()->getStyle("A7:V10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
             $objPHPExcel->getActiveSheet()->getStyle("A7:V10")->getAlignment()->applyFromArray($style_alignment);


             //thuc hien xuat du lieu ra file excel
            //lẤY DỮ LIỆU NHẬP TRONG KỲ

              foreach ($this->modelMapperDocPrintCreate->getUsePrintBySysdepartment($from,$to,$sys_department_id) as $value)
              {
                 $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount,$stt);
                 $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount,$value['Code']);
                 $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount,$value['Name']);
                 $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount,$value['Name']);
                 $tong = $value['TDK_Tong'] + $value['TrongKy_TongSo'];
                 $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowCount,$value['Tong']);
                 $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount,$value['TDK_TuSo']);
                 $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount,$value['TDK_Denso']);
                  $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount,$value['TrongKy_TuSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowCount,$value['TrongKy_DenSo']);

                   $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount,$value['SuDung_TuSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('K' . $rowCount,$value['SuDung_DenSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('L' . $rowCount,$value['SuDung_Tong']);

                   $objPHPExcel->getActiveSheet()->setCellValue('M' . $rowCount,$value['SuDung_Tong']);

                  $objPHPExcel->getActiveSheet()->setCellValue('N' . $rowCount,$value['XoaBo_SoLuong']);
                  $objPHPExcel->getActiveSheet()->setCellValue('O' . $rowCount,$value['XoaBo_So']);

                   $objPHPExcel->getActiveSheet()->setCellValue('P' . $rowCount,$value['Het_SoLuong']);
                  $objPHPExcel->getActiveSheet()->setCellValue('Q' . $rowCount,$value['Het_So']);

                  $objPHPExcel->getActiveSheet()->setCellValue('R' . $rowCount,$value['Huy_SoLuong']);
                  $objPHPExcel->getActiveSheet()->setCellValue('S' . $rowCount,$value['Huy_So']);

                  $objPHPExcel->getActiveSheet()->setCellValue('T' . $rowCount,$value['TCK_TuSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('U' . $rowCount,$value['TCK_DenSo']);
                  $objPHPExcel->getActiveSheet()->setCellValue('V' . $rowCount,$value['TCK_SoLuong']);

                  $rowCount++;
                    $stt++;
              }
               $rowCount--;
                    $objPHPExcel->getActiveSheet()->getStyle('A11:V' . $rowCount)->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
                  $objPHPExcel->getActiveSheet()->getStyle('A11:V' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                  $objPHPExcel->getActiveSheet()->getStyle('C11:C' . $rowCount)->getAlignment()->applyFromArray($style_alignmentleft)->setWrapText(true);
                  $rowCount++;
//
//
            $styleArray = array(
                'font' => array(
                    'bold' => true
                ),
            );
            $objPHPExcel->getActiveSheet()->setCellValue('P'. $rowCount, "....,ngày....tháng....năm");
            $objPHPExcel->getActiveSheet()->mergeCells('P'.$rowCount.':T'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount.':T'.$rowCount)->getAlignment()->applyFromArray(
                                 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));

            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $rowCount, "NGƯỜI LẬP BIỂU");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':E'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('P'. $rowCount, "THỦ TRƯỞNG ĐƠN VỊ");$objPHPExcel->getActiveSheet()->mergeCells('P'.$rowCount.':T'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':P'.$rowCount)->getAlignment()->applyFromArray($style_alignment);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':P'.$rowCount)->applyFromArray($styleArray);

            $rowCount++;
            $objPHPExcel->getActiveSheet()->setCellValue('P'. $rowCount, "(Ký, ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('P'.$rowCount.':T'.$rowCount);
            $objPHPExcel->getActiveSheet()->setCellValue('C'. $rowCount, "(Ký, ghi rõ họ tên)");$objPHPExcel->getActiveSheet()->mergeCells('C'.$rowCount.':E'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount.':P'.$rowCount)->getAlignment()->applyFromArray($style_alignment);

            $objPHPExcel->getActiveSheet()->getStyle("A1:L2")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("A7:V10")->applyFromArray($styleArray);

            $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
            //$objPHPExcel->getActiveSheet()->getStyle("A3:K" . $rowCount)->getAlignment()->applyFromArray($style_alignment);
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
            //tên file excel
            $filename='BaoCaoTinhHinhSuDungAnChi'.date("Y/m/d H:i:s").'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
            exit();
    }
    public function addAction(){
        if($this->getRequest()->isPost()){
            $redirectUrl = $this->aConfig["site"]["url"]."admin/masterunit/list";
            if(isset($_POST["id"])){
                $this->model->setId($_POST["id"]);
            }
            if(isset($_POST["code"])){
                $this->model->setCode($_POST["code"]);
            }
            if(isset($_POST["name"])){
                $this->model->setName($_POST["name"]);
            }
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
            if(isset($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(isset($_POST["status"])){
                $status=1;
            } else {
                $status=0;
            }
            $this->model->setStatus($status); 
            $this->model->setIs_Delete(0);
            $this->model->setCreated_date(date("Y/m/d H:i:s"));
            $this->model->setCreated_By(GlobalLib::getLoginId());
            $this->model->setModified_date(date("Y/m/d H:i:s"));
            $this->model->setModified_By(GlobalLib::getLoginId());
            $this->modelMapper->save($this->model);
            $this->_redirect($redirectUrl);
        }
        $this->view->item=$this->model;
    }
    public function editAction(){
        $id = $this->_getParam("id","");
        $redirectUrl=$this->aConfig["site"]["url"]."admin/masterunit/list";
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
            if(isset($_POST["code"])){
                $this->model->setCode($_POST["code"]);
            }
            if(isset($_POST["name"])){
                $this->model->setName($_POST["name"]);
            }
            if(isset($_POST["order"])){
                $this->model->setOrder($_POST["order"]);
            }
             if(isset($_POST["comment"])){
                $this->model->setComment($_POST["comment"]);
            }
            if(isset($_POST["status"])){
                $status=1;
            } else {
                $status=0;
            }
            $this->model->setStatus($status);
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
    }
    
    public function serviceAction(){
        $this->_helper->layout->disableLayout();
        foreach ($this->modelMapper->fetchAll() as $items ) {
            $menber[]=array(
                'Id'=>$items->getId(),
                'code'=>$items->getCode(),
                'name'=>$items->getName(),                
                'order'=>$items->getOrder(),
                'status'=>$items->getStatus()
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
        $redirectUrl=$this->aConfig["site"]["url"]."admin/masterunit/list";               
        $this->modelMapper->deleteMaster_Unit($id);
        $this->_redirect($redirectUrl);
    }    
    public function checkcodeAction(){
          $this->_helper->layout()->disableLayout();
         if($this->_request->isPost()){
             $code= $this->_getParam("code","");
             $id= $this->modelMapper->findidbyname('code',$code);
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

    // Lan Duong
    public function exportdocviolationshandlingAction(){
        $this->_helper->layout->disableLayout();
        $quy = $_POST["quy"];
        $year = $_POST["year"];
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 8;
        $stt=1;
        $styledataArray = array(
            'font' => array(
                'color' => array('rgb' => '080808'),
                'size' => 13,
                'name' => 'Times New Roman'
            ));

        $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");
        $objPHPExcel->getActiveSheet()->setCellValue('E1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");
        $objPHPExcel->getActiveSheet()->mergeCells('E1:Q1');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Độc lập - Tự do - Hạnh phúc");
        $objPHPExcel->getActiveSheet()->mergeCells('E2:Q2');
        $objPHPExcel->getActiveSheet()->getStyle("E1:Q1")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->getStyle("E2:Q2")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('E4', "KẾT QUẢ KIỂM TRA,XỬ LÝ QUÝ ".$quy." NĂM ".$year);
        $objPHPExcel->getActiveSheet()->mergeCells('E4:Q4');
        $objPHPExcel->getActiveSheet()->getStyle("E4:Q4")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle("E4:Q4")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('E5', "Kèm theo Báo cáo số:   /BC-QLTT ngày,     tháng,   năm");
        $objPHPExcel->getActiveSheet()->mergeCells('E5:Q5');
        $objPHPExcel->getActiveSheet()->getStyle("E5:Q5")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E6', "Đơn vị tính");
        $objPHPExcel->getActiveSheet()->mergeCells('E6:Q6');
        $objPHPExcel->getActiveSheet()->getStyle("E6:Q6")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //BANG
        $totalRow = $this->modelMapper->fetchRowCountDSBCKiemTraTheoQui($quy,$year);
        $totalRow = $totalRow + 13;
        $objPHPExcel->getActiveSheet()->setCellValue('A11', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A11:A13');
        $objPHPExcel->getActiveSheet()->getStyle("A11:A13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A11:A13")->getAlignment()->applyFromArray($style_alignment);
        $objPHPExcel->getActiveSheet()->setCellValue('B11', "Đội QLTT số...");$objPHPExcel->getActiveSheet()->mergeCells('B11:C13');
        $objPHPExcel->getActiveSheet()->getStyle("B11:C13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("B11:C13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('D11', "Đơn vị tính");$objPHPExcel->getActiveSheet()->mergeCells('D11:D13');
        $objPHPExcel->getActiveSheet()->getStyle("D11:D13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("D11:D13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('E11', "Tổng số vụ kiểm tra/xử lý/thu phạt VPHC");$objPHPExcel->getActiveSheet()->mergeCells('E11:E13');
        $objPHPExcel->getActiveSheet()->getStyle("E11:E13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("E11:E13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('F11', "Hàng cấm");$objPHPExcel->getActiveSheet()->mergeCells('F11:F13');
        $objPHPExcel->getActiveSheet()->getStyle("F11:F13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("F11:F13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('G11', "Hàng nhập lậu");$objPHPExcel->getActiveSheet()->mergeCells('G11:G13');
        $objPHPExcel->getActiveSheet()->getStyle("G11:G13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("G11:G13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('H11', "Gian lận thương mại");$objPHPExcel->getActiveSheet()->mergeCells('H11:K11');
        $objPHPExcel->getActiveSheet()->getStyle("H11:K11")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("H11:K11")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('H12', "Lĩnh vực giá");$objPHPExcel->getActiveSheet()->mergeCells('H12:H13');
        $objPHPExcel->getActiveSheet()->getStyle("H12:H13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("H12:H13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('I12', "Đo lường");$objPHPExcel->getActiveSheet()->mergeCells('I12:I13');
        $objPHPExcel->getActiveSheet()->getStyle("I12:I13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("I12:I13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('J12', "Chất lượng");$objPHPExcel->getActiveSheet()->mergeCells('J12:J13');
        $objPHPExcel->getActiveSheet()->getStyle("J12:J13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("J12:J13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('K12', "Vi phạm khác");$objPHPExcel->getActiveSheet()->mergeCells('K12:K13');
        $objPHPExcel->getActiveSheet()->getStyle("K12:K13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("K12:K13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('L11', "Vi phạm quyền SHTT và bảng giá");$objPHPExcel->getActiveSheet()->mergeCells('L11:Q11');
        $objPHPExcel->getActiveSheet()->getStyle("L11:Q11")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("L11:Q11")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('L12', "Nguồn gốc xuất xứ");$objPHPExcel->getActiveSheet()->mergeCells('L12:L13');
        $objPHPExcel->getActiveSheet()->getStyle("L12:L13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("L12:L13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('M12', "Nhãn hiệu HH");$objPHPExcel->getActiveSheet()->mergeCells('M12:M13');
        $objPHPExcel->getActiveSheet()->getStyle("M12:M13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("M12:M13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('N12', "Kiểu dáng CN");$objPHPExcel->getActiveSheet()->mergeCells('N12:N13');
        $objPHPExcel->getActiveSheet()->getStyle("N12:N13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("N12:N13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('O12', "Chỉ dẫn địa lý");$objPHPExcel->getActiveSheet()->mergeCells('O12:O13');
        $objPHPExcel->getActiveSheet()->getStyle("O12:O13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("O12:O13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('P12', "Chất lượng,Công dụng");$objPHPExcel->getActiveSheet()->mergeCells('P12:P13');
        $objPHPExcel->getActiveSheet()->getStyle("P12:P13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("P12:P13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('Q12', "Tem nhãn,bao bì");$objPHPExcel->getActiveSheet()->mergeCells('Q12:Q13');
        $objPHPExcel->getActiveSheet()->getStyle("Q12:Q13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("Q12:Q13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('R11', "Vi phạm trong kinh doanh");$objPHPExcel->getActiveSheet()->mergeCells('R11:U11');
        $objPHPExcel->getActiveSheet()->getStyle("R11:U11")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("R11:U11")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('R12', "ĐKKD,HCKD,KDCĐK");$objPHPExcel->getActiveSheet()->mergeCells('R12:R13');
        $objPHPExcel->getActiveSheet()->getStyle("R12:R13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("R12:R13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('S12', "Quy định ghi nhãn HH");$objPHPExcel->getActiveSheet()->mergeCells('S12:S13');
        $objPHPExcel->getActiveSheet()->getStyle("S12:S13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("S12:S13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('T12', "Đầu cơ,găm hàng");$objPHPExcel->getActiveSheet()->mergeCells('T12:T13');
        $objPHPExcel->getActiveSheet()->getStyle("T12:T13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("T12:T13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('U12', "Vi phạm khác");$objPHPExcel->getActiveSheet()->mergeCells('U12:U13');
        $objPHPExcel->getActiveSheet()->getStyle("U12:U13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("U12:U13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('V11', "Phạt và truy thu thuế");$objPHPExcel->getActiveSheet()->mergeCells('V11:V13');
        $objPHPExcel->getActiveSheet()->getStyle("V11:V13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("V11:V13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('W11', "Bán hàng tịch thu");$objPHPExcel->getActiveSheet()->mergeCells('W11:W13');
        $objPHPExcel->getActiveSheet()->getStyle("W11:W13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("W11:W13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('X11', "Phối hợp KTLN");$objPHPExcel->getActiveSheet()->mergeCells('X11:X13');
        $objPHPExcel->getActiveSheet()->getStyle("X11:X13")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("X11:X13")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');

        //$totalRow = $totalRow * 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A14', "A");
        $objPHPExcel->getActiveSheet()->getStyle('A14:A'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('B14', "B");
        $objPHPExcel->getActiveSheet()->mergeCells('B14:C14');
        $objPHPExcel->getActiveSheet()->getStyle('B14:C'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('D14', "C");
        $objPHPExcel->getActiveSheet()->getStyle('D14:D'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('E14', "1");
        $objPHPExcel->getActiveSheet()->getStyle('E14:E'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('F14', "2");
        $objPHPExcel->getActiveSheet()->getStyle('F14:F'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('G14', "3");
        $objPHPExcel->getActiveSheet()->getStyle('G14:G'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('H14', "4");
        $objPHPExcel->getActiveSheet()->getStyle('H14:H'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('I14', "5");
        $objPHPExcel->getActiveSheet()->getStyle('I14:I'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('J14', "6");
        $objPHPExcel->getActiveSheet()->getStyle('J14:J0'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('K14', "7");
        $objPHPExcel->getActiveSheet()->getStyle('K14:K'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('L14', "8");
        $objPHPExcel->getActiveSheet()->getStyle('L14:L'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('M14', "9");
        $objPHPExcel->getActiveSheet()->getStyle('M14:M'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('N14', "10");
        $objPHPExcel->getActiveSheet()->getStyle('N14:N'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('O14', "11");
        $objPHPExcel->getActiveSheet()->getStyle('O14:O'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('P14', "12");
        $objPHPExcel->getActiveSheet()->getStyle('P14:P'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('Q14', "13");
        $objPHPExcel->getActiveSheet()->getStyle('Q14:Q'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('R14', "14");
        $objPHPExcel->getActiveSheet()->getStyle('R14:R'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('S14', "15");
        $objPHPExcel->getActiveSheet()->getStyle('S14:S'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('T14', "16");
        $objPHPExcel->getActiveSheet()->getStyle('T14:T'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('U14', "17");
        $objPHPExcel->getActiveSheet()->getStyle('U14:U'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('V14', "18");
        $objPHPExcel->getActiveSheet()->getStyle('V14:V'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('W14', "19");
        $objPHPExcel->getActiveSheet()->getStyle('W14:W'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setCellValue('X14', "20");
        $objPHPExcel->getActiveSheet()->getStyle('X14:X'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $count = 15;
        $i=1;
        foreach ($this->modelMapper->fetchDSBCKiemTraTheoQui($quy,$year) as $value){
            $value0=$value[0];
            $value1=$value[1];
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $count, $i);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$count.':A'.($count+1));
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $count, $value0["department"]);
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$count.':C'.($count+1));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $count, "Vụ");
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $count, $value0["result"]);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $count, $value0["HC"]);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $count, $value0["HNL"]);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $count, $value0["LVG"]);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $count, $value0["ĐL"]);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $count, $value0["CL"]);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $count, $value0["VPK1"]);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $count, $value0["NGXX"]);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $count, $value0["NHHH"]);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $count, $value0["KDCN"]);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $count, $value0["CDĐL"]);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $count, $value0["CLCD"]);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $count, $value0["Tem"]);
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $count, $value0["ĐKKD"]);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $count, $value0["QĐGNHH"]);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $count, $value0["ĐCGH"]);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $count, $value0["VPK2"]);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $count, $value0["VSATTP"]);
            $count++;
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $count, "Tiền");
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $count, $value1["result"]);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $count, $value1["HC"]);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $count, $value1["HNL"]);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $count, $value1["LVG"]);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $count, $value1["ĐL"]);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $count, $value1["CL"]);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $count, $value1["VPK1"]);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $count, $value1["NGXX"]);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $count, $value1["NHHH"]);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $count, $value1["KDCN"]);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $count, $value1["CDĐL"]);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $count, $value1["CLCD"]);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $count, $value1["Tem"]);
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $count, $value1["ĐKKD"]);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $count, $value1["QĐGNHH"]);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $count, $value1["ĐCGH"]);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $count, $value1["VPK2"]);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $count, $value1["VSATTP"]);
            $count++;
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $count, $i);$objPHPExcel->getActiveSheet()->mergeCells('A'.$count.':A'.($count+1));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $count, "Tổng cộng");$objPHPExcel->getActiveSheet()->mergeCells('B'.$count.':C'.($count+1));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $count, "Vụ");
        $objPHPExcel->getActiveSheet()->setCellValue('D' .($count+1), "Tiền");

        // Footer
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$totalRow, 'Ngày lập phiếu');
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$totalRow.':E'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$totalRow.':E'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$totalRow.':E'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('S'.$totalRow, 'Thủ trưởng');
        $objPHPExcel->getActiveSheet()->mergeCells('S'.$totalRow.':W'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$totalRow.':W'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$totalRow.':W'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$totalRow.':E'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$totalRow.':E'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$totalRow.':E'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$totalRow.':E'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('S'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('S'.$totalRow.':W'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$totalRow.':W'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$totalRow.':W'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$totalRow.':W'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //tên file excel
        $filename='PhieuKiemTraXuLyTheoQuy'.date("Y/m/d H:i:s").'.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        exit();
    }

    public function exportkinhdoanhAction(){
        $this->_helper->layout->disableLayout();
        $type_business_name = "";
        $type_business_header_name = "";
        $type_business = $this->_getParam("type_business","");
        if($type_business == 'DoanhNghiep') {
            $type_business_name = 'DOANH NGHIỆP';
            $type_business_header_name = 'DOANH NGHIỆP';
        }
        else if($type_business == 'HoKinhDoanh') {
            $type_business_name = 'HỘ KINH DOANH';
            $type_business_header_name = 'HỘ KINH DOANH';
        }
        else {
            $type_business_name = 'DOANH NGHIỆP NGOÀI ĐỊA BÀN';
            $type_business_header_name = 'DOANH NGHIỆP';
        }
        $doanhnghiep_id = $this->_getParam("doanhnghiep_id","");
        $nganhnghe_id = $this->_getParam("nganhnghe_name","");
        $tinhthanh_id = $this->_getParam("tinhthanh_id","");
        $loaihinh_id = $this->_getParam("loaihinh_id","");

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");
        $objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
        $objPHPExcel->getActiveSheet()->getStyle("B1:C1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("B1:C1")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "Độc lập - Tự do - Hạnh phúc");
        $objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
        $objPHPExcel->getActiveSheet()->getStyle("B2:C2")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("B2:C2")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('B4', "DANH SÁCH ".$type_business_name);
        $objPHPExcel->getActiveSheet()->mergeCells('B4:D4');
        $objPHPExcel->getActiveSheet()->getStyle("B4:D4")->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle("B4:D4")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("B4:D4")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //BANG
        $totalRow = $this->modelMapper->fetchrRowCountDSKinhDoanh($type_business, $doanhnghiep_id, $nganhnghe_id, $tinhthanh_id, $loaihinh_id);
        $totalRow = $totalRow + 5;
        $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_left_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A5', "MÃ " .$type_business_header_name);
        $objPHPExcel->getActiveSheet()->getStyle('A5:A'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A5:A'.$totalRow)->getAlignment()->applyFromArray($style_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('A6:A'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B5', "TÊN " . $type_business_header_name);
        $objPHPExcel->getActiveSheet()->getStyle('B5:B'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('B5:B'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getStyle('B6:B'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('C5', "TRỤ SỞ CHÍNH");
        $objPHPExcel->getActiveSheet()->getStyle('C5:C'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C5:C'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getStyle('C6:C'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', "TỈNH THÀNH");
        $objPHPExcel->getActiveSheet()->getStyle('D5:D'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:D'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('D6:D'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('E5', "QUẬN HUYỆN");
        $objPHPExcel->getActiveSheet()->getStyle('E5:E'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('E5:E'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('E6:E'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('F5', "XÃ PHƯỜNG");
        $objPHPExcel->getActiveSheet()->getStyle('F5:F'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('F5:F'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('F6:F'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('G5', "NGÀNH NGHỀ");
        $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$totalRow)->getAlignment()->applyFromArray($style_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('G6:G'.$totalRow)->getAlignment()->setWrapText(true);

        $rowCount = 6;
        $stt=1;
        foreach ($this->modelMapper->fetchDSKinhDoanh($type_business, $doanhnghiep_id, $nganhnghe_id, $tinhthanh_id, $loaihinh_id) as $items){
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $items['code']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $items['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $items['address_office']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, $items['master_province_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowCount, $items['master_district_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $items['master_ward_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $items['work_business']);
            $rowCount++;
        }

        // Footer
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, 'Ngày lập phiếu');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':B'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$totalRow, 'Thủ trưởng');
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$totalRow.':G'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':B'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$totalRow.':G'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //tên file excel
        $filename='DanhSach'.$type_business.'.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        exit();
    }

    public function exportxuphatviphamAction(){
        $this->_helper->layout->disableLayout();
        $type_business_name = "";
        $type_business = $this->_getParam("type_business","");
        $id= $this->_getParam("id","");
        $month= $this->_getParam("month","");
        $year = $this->_getParam("year","");
        if($type_business == 'DoanhNghiep')
            $type_business_name = 'DOANH NGHIỆP';
        else if($type_business == 'HoKinhDoanh')
            $type_business_name = 'HỘ KINH DOANH';
        else
            $type_business_name = 'DOANH NGHIỆP NGOÀI ĐỊA BÀN';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");
        $objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
        $objPHPExcel->getActiveSheet()->getStyle("C1:D1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("C1:D1")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "Độc lập - Tự do - Hạnh phúc");
        $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("C2:D2")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('C4', "DANH SÁCH ".$type_business_name);
        $objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //BANG
        $totalRow = $this->modelMapper->fetchRowCountDSXuLiViPham($type_business,$id,$month,$year);
        $totalRow = $totalRow + 5;
        $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_left_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_right_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A5', "STT");
        $objPHPExcel->getActiveSheet()->getStyle('A5:A'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A5:A'.$totalRow)->getAlignment()->applyFromArray($style_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('A6:A'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B5', "TÊN " . $type_business_name);
        $objPHPExcel->getActiveSheet()->getStyle('B5:B'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('B5:B'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getStyle('B6:B'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('C5', "ĐỊA CHỈ");
        $objPHPExcel->getActiveSheet()->getStyle('C5:C'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C5:C'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getStyle('C6:C'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', "HÀNH VI VI PHẠM");
        $objPHPExcel->getActiveSheet()->getStyle('D5:D'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:D'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('D6:D'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('E5', "HÌNH THỨC XỬ LÍ");
        $objPHPExcel->getActiveSheet()->getStyle('E5:E'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('E5:E'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('E6:E'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('F5', "ĐỘI XỬ LÍ");
        $objPHPExcel->getActiveSheet()->getStyle('F5:F'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('F5:F'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('F6:F'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('G5', "SỐ TIỀN");
        $objPHPExcel->getActiveSheet()->getStyle('G5:H'.$totalRow)->getNumberFormat()->setFormatCode('#,##');
        $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$totalRow)->getAlignment()->applyFromArray($style_right_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('G6:G'.$totalRow)->getAlignment()->setWrapText(true);

        $rowCount = 6;
        $stt=1;
        foreach ($this->modelMapper->fetchDSXuLiViPham($type_business,$id,$month,$year) as $items){
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $items['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $items['TenDoanhNghiep']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $items['DiaChi']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, $items['HanhViViPham']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowCount, $items['HinhThucXuLy']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $items['DoiXuLy']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $items['SoTien']);
            $rowCount++;
        }

        // Footer
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, 'Ngày lập phiếu');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':B'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$totalRow, 'Thủ trưởng');
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$totalRow.':G'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':B'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$totalRow.':G'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRow.':G'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //tên file excel
        $filename='DanhSachXuPhatViPham'.$type_business.'.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        exit();
    }

    public function exporttangvattamgiuAction(){
        $this->_helper->layout->disableLayout();
        $status_name = "";
        $file_name = "";
        $status = $this->_getParam("status","");
        $month= $this->_getParam("month","");
        $year = $this->_getParam("year","");
        if($status == "CGCQK_TG") {
            $status_name = "DANH SÁCH TANG VẬT CHUYỂN CHO CƠ QUAN KHÁC";
            $file_name = "DanhSachTangVatChuyenChoCoQuanKhac";
        }
        else if($status == "XLN_TG") {
            $status_name = "DANH SÁCH TANG VẬT CẦN XỬ LÍ NHANH";
            $file_name = "DanhSachTangVatCanXuLiNhanh";
        }
        else if($status == "TL_TG") {
            $status_name = "DANH SÁCH TANG VẬT TRẢ LẠI";
            $file_name = "DanhSachTangVatTraLai";
        }
        else {
            $status_name = "DANH SÁCH TANG VẬT TẠM GIỮ";
            $file_name = "DanhSachTangVatTamGiu";
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");
        $objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
        $objPHPExcel->getActiveSheet()->getStyle("C1:D1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("C1:D1")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "Độc lập - Tự do - Hạnh phúc");
        $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
        $objPHPExcel->getActiveSheet()->getStyle("C2:D2")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("C2:D2")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('C4', $status_name);
        $objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //BANG
        $totalRow = $this->modelMapper->fetchRowCountDSTangVatTamGiu($status,$month,$year);
        $totalRow = $totalRow + 5;
        $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_left_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_right_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A5', "STT");
        $objPHPExcel->getActiveSheet()->getStyle('A5:A'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A5:A'.$totalRow)->getAlignment()->applyFromArray($style_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('A6:A'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B5', "TÊN HÀNG HÓA");
        $objPHPExcel->getActiveSheet()->getStyle('B5:B'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('B5:B'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getStyle('B6:B'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('C5', "TÊN DOANH NGHIỆP");
        $objPHPExcel->getActiveSheet()->getStyle('C5:C'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C5:C'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getStyle('C6:C'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', "BIÊN LAI TỊCH THU");
        $objPHPExcel->getActiveSheet()->getStyle('D5:D'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:D'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('D6:D'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('E5', "SỐ LƯỢNG");
        $objPHPExcel->getActiveSheet()->getStyle('E5:E'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('E5:E'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('E6:E'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('F5', "ĐƠN VỊ TÍNH");
        $objPHPExcel->getActiveSheet()->getStyle('F5:F'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('F5:F'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('F6:F'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('G5', "NGÀY TỊCH THU");
        $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$totalRow)->getAlignment()->applyFromArray($style_right_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('G6:G'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('H5', "SỐ TIỀN");
        $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$totalRow)->getNumberFormat()->setFormatCode('#,##');
        $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$totalRow)->getAlignment()->applyFromArray($style_right_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('H6:H'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('I5', "TRẠNG THÁI");
        $objPHPExcel->getActiveSheet()->getStyle('I5:I'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('I5:I'.$totalRow)->getAlignment()->applyFromArray($style_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('I6:I'.$totalRow)->getAlignment()->setWrapText(true);

        $rowCount = 6;
        foreach ($this->modelMapper->fetchDSTangVatTamGiu($status,$month,$year) as $items){
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $items['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $items['TenHangHoa']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $items['TenDoanhNghiep']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, $items['BienLaiTichThu']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowCount, $items['SoLuong']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $items['DonViTinh']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $items['NgayTichThu']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, $items['SoTien']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowCount, $items['TrangThai']);
            $rowCount++;
        }

        // Footer
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, 'Ngày lập phiếu');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':B'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$totalRow, 'Thủ trưởng');
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$totalRow.':I'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':B'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$totalRow.':I'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //tên file excel
        $filename = $file_name.'.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        exit();
    }

    public function exporttangvattichthuAction()
    {
        $this->_helper->layout->disableLayout();
        $status_name = "";
        $file_name = "";
        $status = $this->_getParam("status", "");
        $month = $this->_getParam("month", "");
        $year = $this->_getParam("year", "");
        if ($status == "XLN_TT") {
            $status_name = "DANH SÁCH TANG VẬT CẦN XỬ LÍ NHANH";
            $file_name = "DanhSachTangVatCanXuLiNhanh";
        } else if ($status == "TH_TT") {
            $status_name = "DANH SÁCH TANG VẬT TIÊU HỦY";
            $file_name = "DanhSachTangVatTieuHuy";
        } else if ($status == "ĐG_TT") {
            $status_name = "DANH SÁCH TANG VẬT ĐẤU GIÁ";
            $file_name = "DanhSachTangVatDauGia";
        } else if ($status == "CGCQK_TG") {
            $status_name = "DANH SÁCH TANG VẬT CHUYỂN CHO CƠ QUAN KHÁC";
            $file_name = "DanhSachTangVatChuyenChoCoQuanKhac";
        }
        else {
            $status_name = "DANH SÁCH TANG VẬT TỊCH THU-CHỜ XỬ LÍ";
            $file_name = "DanhSachTangVatTichThu-ChoXuLi";
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', "CHI CỤC QLTT BÌNH ĐỊNH");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "Đơn vị:………………………");
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM");
        $objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
        $objPHPExcel->getActiveSheet()->getStyle("C1:D1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("C1:D1")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "Độc lập - Tự do - Hạnh phúc");
        $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
        $objPHPExcel->getActiveSheet()->getStyle("C2:D2")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("C2:D2")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('C4', $status_name);
        $objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle("C4:E4")->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //BANG
        $totalRow = $this->modelMapper->fetchRowCountDSTangVatTichThu($status,$month,$year);
        $totalRow = $totalRow + 5;
        $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_left_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_right_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A5', "STT");
        $objPHPExcel->getActiveSheet()->getStyle('A5:A'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A5:A'.$totalRow)->getAlignment()->applyFromArray($style_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('A6:A'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B5', "TÊN HÀNG HÓA");
        $objPHPExcel->getActiveSheet()->getStyle('B5:B'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('B5:B'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getStyle('B6:B'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('C5', "TÊN DOANH NGHIỆP");
        $objPHPExcel->getActiveSheet()->getStyle('C5:C'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C5:C'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getStyle('C6:C'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('D5', "BIÊN LAI TỊCH THU");
        $objPHPExcel->getActiveSheet()->getStyle('D5:D'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:D'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('D6:D'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('E5', "SỐ LƯỢNG");
        $objPHPExcel->getActiveSheet()->getStyle('E5:E'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('E5:E'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('E6:E'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('F5', "ĐƠN VỊ TÍNH");
        $objPHPExcel->getActiveSheet()->getStyle('F5:F'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('F5:F'.$totalRow)->getAlignment()->applyFromArray($style_left_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('F6:F'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('G5', "NGÀY TỊCH THU");
        $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$totalRow)->getAlignment()->applyFromArray($style_right_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('G6:G'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('H5', "SỐ TIỀN");
        $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$totalRow)->getNumberFormat()->setFormatCode('#,##');
        $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$totalRow)->getAlignment()->applyFromArray($style_right_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('H6:H'.$totalRow)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('I5', "TRẠNG THÁI");
        $objPHPExcel->getActiveSheet()->getStyle('I5:I'.$totalRow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('I5:I'.$totalRow)->getAlignment()->applyFromArray($style_alignment);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('I6:I'.$totalRow)->getAlignment()->setWrapText(true);

        $rowCount = 6;
        foreach ($this->modelMapper->fetchDSTangVatTichThu($status,$month,$year) as $items){
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $items['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $items['TenHangHoa']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowCount, $items['TenDoanhNghiep']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, $items['BienLaiTichThu']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowCount, $items['SoLuong']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $items['DonViTinh']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $items['NgayTichThu']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $rowCount, $items['SoTien']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowCount, $items['TrangThai']);
            $rowCount++;
        }

        // Footer
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, 'Ngày lập phiếu');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':B'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$totalRow, 'Thủ trưởng');
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$totalRow.':I'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':B'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':B'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$totalRow.':I'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$totalRow.':I'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //tên file excel
        $filename = $file_name.'.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        exit();
    }

    public function exportnhatkitheodoiAction()
    {
        $this->_helper->layout->disableLayout();
        $tungay = $this->_getParam("tungay", "");
        $denngay = $this->_getParam("denngay", "");

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 11;

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

        $objPHPExcel->getActiveSheet()->setCellValue('L3', "Đến ngày:");$objPHPExcel->getActiveSheet()->mergeCells('L3:M3');
        $objPHPExcel->getActiveSheet()->getStyle('L2:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('N3', $denngay); $objPHPExcel->getActiveSheet()->mergeCells('N3:P3');
        $objPHPExcel->getActiveSheet()->getStyle('G3:N3')->getFont()->setItalic(true);

        //BANG
        $totalRow = $this->modelMapper->fetchRowCountNhatKiTheoDoi($tungay,$denngay);
        $totalRow = $totalRow + 6;
        $style_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_left_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style_right_alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('A5', "STT");$objPHPExcel->getActiveSheet()->mergeCells('A5:A9');$objPHPExcel->getActiveSheet()->getStyle('A7:M9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A5:A10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A5:A9")->getAlignment()->applyFromArray($style_alignment);


        $objPHPExcel->getActiveSheet()->setCellValue('B5', "Ngày tháng năm");$objPHPExcel->getActiveSheet()->mergeCells('B5:C9');
        $objPHPExcel->getActiveSheet()->getStyle("B5:C10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("B5:C9")->getAlignment()->applyFromArray($style_alignment);
        $objPHPExcel->getActiveSheet()->setCellValue('B10', "1");
        $objPHPExcel->getActiveSheet()->mergeCells('B10:C10');
        $objPHPExcel->getActiveSheet()->getStyle('B10:C10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B10:C10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('D5', "Họ và tên KSV được phân công kiểm tra");
        $objPHPExcel->getActiveSheet()->mergeCells('D5:E9');
        $objPHPExcel->getActiveSheet()->getStyle("D5:E10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("D5:E9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('D10', "2");
        $objPHPExcel->getActiveSheet()->mergeCells('D10:E10');
        $objPHPExcel->getActiveSheet()->getStyle('D10:E10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D10:E10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('F5', "Chức danh KSV khi thi hành công vụ");
        $objPHPExcel->getActiveSheet()->mergeCells('F5:F9');
        $objPHPExcel->getActiveSheet()->getStyle("F5:F10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("F5:F9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('F10', "3");
        $objPHPExcel->getActiveSheet()->mergeCells('F10:F10');
        $objPHPExcel->getActiveSheet()->getStyle('F10:F10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F10:F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('G5', "Đối tượng, địa bàn nội dung kiểm tra");
        $objPHPExcel->getActiveSheet()->mergeCells('G5:I9');
        $objPHPExcel->getActiveSheet()->getStyle("G5:I10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("G5:I9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('G10', "4");
        $objPHPExcel->getActiveSheet()->mergeCells('G10:I10');
        $objPHPExcel->getActiveSheet()->getStyle('G10:I10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G10:I10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('J5', "Thời gian kiểm tra\nTừ....giờ\nĐến...giờ");
        $objPHPExcel->getActiveSheet()->mergeCells('J5:J9');
        $objPHPExcel->getActiveSheet()->getStyle("J5:J10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("J5:J9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('J10', "5");
        $objPHPExcel->getActiveSheet()->mergeCells('J10:J10');
        $objPHPExcel->getActiveSheet()->getStyle('J10:J10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J10:J10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('K5', "Tình hình kiểm tra và kết quả kiểm tra");
        $objPHPExcel->getActiveSheet()->mergeCells('K5:N9');
        $objPHPExcel->getActiveSheet()->getStyle("K5:N10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("K5:N9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('K10', "6");
        $objPHPExcel->getActiveSheet()->mergeCells('K10:N10');
        $objPHPExcel->getActiveSheet()->getStyle('K10:N10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K10:N10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('O5', "Kết quả xử lý");
        $objPHPExcel->getActiveSheet()->mergeCells('O5:P9');
        $objPHPExcel->getActiveSheet()->getStyle("O5:P10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("O5:P9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('O10', "7");
        $objPHPExcel->getActiveSheet()->mergeCells('O10:P10');
        $objPHPExcel->getActiveSheet()->getStyle('O10:P10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('O10:P10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('Q5', "Đại diện Đội, Tổ kiểm tra ký sổ");
        $objPHPExcel->getActiveSheet()->mergeCells('Q5:R9');
        $objPHPExcel->getActiveSheet()->getStyle("Q5:R10")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("Q5:R9")->getAlignment()->applyFromArray($style_alignment)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->setCellValue('Q10', "8");
        $objPHPExcel->getActiveSheet()->mergeCells('Q10:R10');
        $objPHPExcel->getActiveSheet()->getStyle('Q10:R10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('Q10:R10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('Q10:'.'Q10')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $rowCount = 11;
        foreach ($this->modelMapper->fetchNhatKiTheoDoi($tungay,$denngay) as $items){
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $items['id']);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowCount, $items['date_diary']);
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$rowCount.':C'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount.':C'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount.':C'.$rowCount)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowCount, $items['implementers']);
            $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':E'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount.':E'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount.':E'.$rowCount)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowCount, $items['position']);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$totalRow)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $rowCount, $items['content_inspection']);
            $objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':I'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount.':I'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount.':I'.$rowCount)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $rowCount, $items['time_check']);
            $objPHPExcel->getActiveSheet()->getStyle('J' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$totalRow)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $rowCount, $items['status_and_test_results']);
            $objPHPExcel->getActiveSheet()->mergeCells('K'.$rowCount.':N'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $rowCount.':N'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$rowCount.':N'.$rowCount)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $rowCount, $items['processing_results']);
            $objPHPExcel->getActiveSheet()->mergeCells('O'.$rowCount.':P'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('O' . $rowCount.':P'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount.':P'.$rowCount)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $rowCount, "");
            $objPHPExcel->getActiveSheet()->mergeCells('Q'.$rowCount.':R'.$rowCount);
            $objPHPExcel->getActiveSheet()->getStyle('Q' . $rowCount.':R'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount.':R'.$rowCount)->getAlignment()->setWrapText(true);
            $rowCount++;
        }

        // Footer
        $totalRow = $totalRow + 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, 'Ngày lập phiếu');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':E'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':E'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':E'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$totalRow, 'Thủ trưởng');
        $objPHPExcel->getActiveSheet()->mergeCells('N'.$totalRow.':R'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$totalRow.':R'.$totalRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$totalRow.':R'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $totalRow = $totalRow + 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$totalRow.':E'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':E'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':E'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$totalRow.':E'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$totalRow, '(Kí ghi rõ họ tên)');
        $objPHPExcel->getActiveSheet()->mergeCells('N'.$totalRow.':R'.$totalRow);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$totalRow.':R'.$totalRow)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$totalRow.':R'.$totalRow)->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$totalRow.':R'.$totalRow)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        //tên file excel
        $filename = 'NhatKiTheoDoiHoatDong.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
        exit();
    }
}
