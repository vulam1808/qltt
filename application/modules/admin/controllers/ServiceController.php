<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Admin_ServiceController extends Zend_Controller_Action {
    //put your code here
    public function init() {
    }
     public function indexAction(){
        if ($this->_request->isPost()) {
            $action = $_POST['action'];
        } else {
            $action = '';
        }
         switch ($action) {
            case 'getprovince':
                $this->_helper->layout()->disableLayout();
                $provinceHTML = '<select name="province_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $area_id = $this->_getParam("area_id", "");
                    if (is_numeric($area_id)) {
                        $provinceHTML = GlobalLib::getCombo('province_id', 'province', 'id', 'name', 0, false, 'where id in (select province_id from area_province_category where area_id=' . $area_id.')');
                    }
                }
                echo '[{"html":\'' . $provinceHTML . '\'}]';
                exit;
                break;
            case 'getdistrict':
                $this->_helper->layout()->disableLayout();               
                $districtHTML = '<select name="master_dictrict_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $master_province_id = $this->_getParam("master_province_id", "");
                    if (is_numeric($master_province_id)) {
                        $districtHTML = GlobalLib::getCombo('master_dictrict_id', 'master_district', 'id', 'name', 0, false, 'where master_province_id=' . $master_province_id.'','','','Quận huyện');
                        $wardHTML = GlobalLib::getCombo('master_ward_id', 'master_ward', 'id', 'name', 0, false, 'where master_district_id=0','','','Xã phường');
                    }
                }
                echo '[{"html":\'' . $districtHTML . '\',"html1":\'' . $wardHTML . '\'}]';
                exit;
                break;
            case 'getdistrictschedule':
                $this->_helper->layout()->disableLayout();               
                $districtHTML = '<select name="master_dictrict_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $master_province_id = $this->_getParam("master_province_id", "");
                    if (is_numeric($master_province_id)) {
                        $districtHTML = GlobalLib::getComboSchedule('master_dictrict_id', 'master_district', 'id', 'name', 0, true, 'where master_province_id=' . $master_province_id.'','','','');
                        $wardHTML = GlobalLib::getComboSchedule('master_ward_id', 'master_ward', 'id', 'name', 0, true, 'where master_district_id=0','','','');
                    }
                }
                echo '[{"html":\'' . $districtHTML . '\',"html1":\'' . $wardHTML . '\'}]';
                exit;
                break;
            case 'getsysuser':
                $this->_helper->layout()->disableLayout();               
                $sysuserHTML = '<select name="sys_user_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $sys_department_id = $this->_getParam("sys_department_id", "");
                    if (is_numeric($sys_department_id)) {
                        $sysuserHTML =  GlobalLib::getComboVersatile('sys_user_id', 'sys_user', 'id', 'username,first_name,last_name', '0',false, 'form-control', '', 'where sys_department_id=' . $sys_department_id.' and username != "NULL"', '', 'Người dùng','-','');
                        }
                }
                echo '[{"html":\'' . $sysuserHTML . '\'}]';
                exit;
                break;
               
            case 'getsysuser1':
                $this->_helper->layout()->disableLayout();               
                $sysuserHTML = '<select name="sys_user_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $sys_department_id = $this->_getParam("sys_department_id", "");
                    if (is_numeric($sys_department_id)) {
                      $sysuserHTML = GlobalLib::getComboVersatile('sys_user_id', 'sys_user', 'id', 'username,first_name,last_name',0, false, 'form-control', '', 'where sys_department_id=' . $sys_department_id.' and username != "NULL"', '', 'Chọn người dùng','-','');
                    }
                }
                echo '[{"html":\'' . $sysuserHTML . '\'}]';
                exit;
                break;    
            case 'getmasterprint':
                $this->_helper->layout()->disableLayout();               
                $masterprintHTML = '<select name="master_print_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $sys_department_id = $this->_getParam("sys_department_id", "");
                    if (is_numeric($sys_department_id)) {
//                        $masterprintHTML = GlobalLib::getCombo('master_print_id', 'master_print', 'id', 'code',0,false, '', '', 'onchange="getDocPrintCreatWithMasterPrint(\'' . $this->aConfig["site"]["url"] . '\')"') ;
                      $masterprintHTML = GlobalLib::getComboMasterPrint('master_print_id', 'doc_print_allocation', 'master_print_id','master_print_id',0, false, '', '', 'where sys_department_id=' . $sys_department_id.'', 'group by master_print_id', 'Chọn ấn chỉ','-','');
                    }
                }
                echo '[{"html":\'' . $masterprintHTML . '\'}]';
                exit;
                break;
            case 'getmasterprint12':
                $this->_helper->layout()->disableLayout();               
                $masterprintHTML = '<select name="master_print_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $sys_department_id = $this->_getParam("sys_department_id", "");
                    $user_id = $this->_getParam("user", "");
                    $masterprint_id = $this->getParam("masterprint","");
                    $infoschedule_id = $this->getParam("infoscheduleid","");
                    
                    if($masterprint_id == ""){
                        $id_masterprint = 0;
                    }  else {
                        $id_masterprint = $masterprint_id;
                    }
                    if($user_id == null){
                        $id_user = 0;
                    }  else {
                        $id_user = $user_id;
                    }
                    if( $infoschedule_id == ""){
                        $id_infoschedule = 0;
                    }  else {
                        $id_infoschedule =  $infoschedule_id;
                    }
                    if (is_numeric($sys_department_id)) {
                      $masterprintHTML = GlobalLib::getComboMasterPrint('master_print_id', 'doc_print_allocation', 'master_print_id','master_print_id',$id_masterprint, false, '', '', 'where sys_department_id=' . $sys_department_id.' and status ="DOING" ', 'group by master_print_id', 'Chọn ấn chỉ','-','');
                      $sysuserHTML =  GlobalLib::getComboVersatile('sys_user_id', 'sys_user', 'id', 'username,first_name,last_name',$id_user ,false, 'form-control', '', 'where sys_department_id=' . $sys_department_id.' and username != "NULL"', '', 'Người dùng','-','');
                      $printcreatHTML = GlobalLib::getComboVersatileSerial('doc_print_create_id', 'doc_print_create', 'id', 'coefficient,serial,serial_recovery', 0, false, '', '', 'where  master_print_id = "0" and is_delete="0" and id in(select distinct doc_print_create_id from doc_print_allocation where sys_department_id ='.$sys_department_id.' and status ="DOING" and is_delete="0")', NULL,'Chọn quyển số','=>', '');
                      $scheduleHTML = GlobalLib::getCombo('info_schedule_id', 'info_schedule', 'id', 'name_schedule', $id_infoschedule, false, 'where sys_department_id=' . $sys_department_id.'','','','Lịch kiểm tra');
                    }
                }
                echo '[{"html":\'' . $masterprintHTML . '\',"html1":\'' . $sysuserHTML . '\',"html2":\'' . $printcreatHTML . '\',"html3":\'' . $scheduleHTML . '\'}]';
                exit;
                break;  
            
            case 'getdocprintcreate':
                $this->_helper->layout()->disableLayout();               
                $docprintcreatHTML = '<select name="doc_print_create_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $master_print_id = $this->_getParam("master_print_id", "");
                    $sys_department_id= $this->_getParam("sys_department_id", "");
                    if (is_numeric($master_print_id)) {
                        $docprintcreatHTML = GlobalLib::getComboDocPrintCreate('doc_print_create_id', 'doc_print_allocation', 'id','doc_print_create_id', 0, false, '', '', 'where master_print_id=' . $master_print_id.' and sys_department_id='.$sys_department_id.'', '', 'Chọn số cuốn','-','');
                       
                    }
                }
                echo '[{"html":\'' . $docprintcreatHTML . '\'}]';
                exit;
                break;
            case 'getprintcreate':
                $this->_helper->layout()->disableLayout();
                $printcreatHTML = '<select name="doc_print_create_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $master_print_id = $this->_getParam("master_print_id", "");
                    if (is_numeric($master_print_id)) {
                       // $printcreatHTML =GlobalLib::getComboSeclect('doc_print_create_id', 'doc_print_create', 'id', 'coefficient', 0,  true, 'where status !="DONE" and master_print_id = '.$master_print_id.' and is_delete="0"', NULL, '', 'Chưa lựa chọn');
                    $printcreatHTML = GlobalLib::getComboVersatileSerial('doc_print_create_id', 'doc_print_create', 'id', 'coefficient,serial,serial_recovery', 0, false, '', '', 'where status !="DONE" and status != "DOING" and master_print_id = '.$master_print_id.' and is_delete="0"', NULL,'Chọn quyển số','=>', '');
//                        $printcreatHTML = GlobalLib::getComboVersatile('doc_print_create_id', 'doc_print_create', 'id', 'coefficient,serial', 0, false, '', '', 'where status !="DONE" and status != "DOING" and master_print_id = '.$master_print_id.' and is_delete="0"', NULL,'Chọn quyển số','=>', '');
                    }
                }
                echo '[{"html":\'' . $printcreatHTML . '\'}]';
                exit;
                break;  
            case 'getprintcreate1':
                $this->_helper->layout()->disableLayout();               
                $printcreatHTML = '<select name="doc_print_create_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $master_print_id = $this->_getParam("master_print_id", "");
                    $sys_department_id = $this->_getParam("sys_department_id","");
                    if (is_numeric($master_print_id)) {
                       // $printcreatHTML =GlobalLib::getComboSeclect('doc_print_create_id', 'doc_print_create', 'id', 'coefficient', 0,  true, 'where status !="DONE" and master_print_id = '.$master_print_id.' and is_delete="0"', NULL, '', 'Chưa lựa chọn');
                    $printcreatHTML = GlobalLib::getComboVersatileSerial('doc_print_create_id', 'doc_print_create', 'id', 'coefficient,serial,serial_recovery', 0, false, '', '', 'where  master_print_id = '.$master_print_id.' and is_delete="0" and id in(select distinct doc_print_create_id from doc_print_allocation where sys_department_id ='.$sys_department_id.' and status ="DOING" and is_delete="0")', NULL,'Chọn quyển số','=>', '');
//                        $printcreatHTML = GlobalLib::getComboVersatile('doc_print_create_id', 'doc_print_create', 'id', 'coefficient,serial', 0, false, '', '', 'where status !="DONE" and status != "DOING" and master_print_id = '.$master_print_id.' and is_delete="0"', NULL,'Chọn quyển số','=>', '');
                    }
                }
                echo '[{"html":\'' . $printcreatHTML . '\'}]';
                exit;
                break;                 
            case 'getward':
                $this->_helper->layout()->disableLayout();            
                $wardHTML = '<select name="master_ward_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $master_district_id = $this->_getParam("master_district_id", "");
                    if (is_numeric($master_district_id)) {
                        $wardHTML = GlobalLib::getCombo('master_ward_id', 'master_ward', 'id', 'name', 0, false, 'where master_district_id=' . $master_district_id.'','','','Xã phường');
                       
                    }
                }
                echo '[{"html":\'' . $wardHTML . '\'}]';
                exit;
                break;
             case 'getwardschedule':
                $this->_helper->layout()->disableLayout();            
                $wardHTML = '<select name="master_ward_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $master_district_id = $this->_getParam("master_district_id", "");
                    if($master_district_id == ""){
                        $master_district_idd = 0;
                    }  else {
                        $master_district_idd = $master_district_id;
                    }
//                    if (is_numeric($master_district_id)) {
//                        $wardHTML = GlobalLib::getComboSchedule('master_ward_id', 'master_ward', 'id', 'name', 0, true, 'where master_district_id in (20,24,25)','','','');
//                       
//                    }
//                    $master_district_id ="20,21";
                    $wardHTML = GlobalLib::getComboSchedule('master_ward_id', 'master_ward', 'id', 'name', 0, true, 'where master_district_id in ('.$master_district_idd.')','','','');
                }
                echo '[{"html":\'' . $wardHTML . '\'}]';
                exit;
                break;
            case 'getserialallocation':
                $this->_helper->layout()->disableLayout();            
                $serialallocationHTML = '<select name="doc_print_allocation_id" style="width: 386px;"><option value=""></option></select>';
                if ($this->_request->isPost()) {
                    $master_print_id = $this->_getParam("master_print_id", "");
                    $sys_department_id = $this->_getParam("sys_department_id","");
                    if (is_numeric($master_print_id)) {
                        $serialallocationHTML = GlobalLib::getCombo('doc_print_allocation_id', 'doc_print_allocation', 'id', 'serial_allocation', 0, false, 'where sys_department_id='.$sys_department_id.' and master_print_id=' . $master_print_id.'');
                       
                    }
                }
                echo '[{"html":\'' . $serialallocationHTML . '\'}]';
                exit;
                break;    
            case 'getcombobox':
                $this->_helper->layout()->disableLayout(); 
                $coboboxHTML = '<select name="combox_id" style="width:386px;"><option value =""></option></select>';
                if($this->_request->isPost()){
                    $arayserial = $this->_getParam("arrayserial","");
                       $cb = GlobalLib::getCB('cb_id', $arayserial, 0, false, '', '', '', '');
                }
                echo '[{"html":\'' . $cb . '\'}]';
                exit;
                break; 
     }
}
}
