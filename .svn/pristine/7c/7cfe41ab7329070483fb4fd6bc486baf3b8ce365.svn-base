<?php
include APPLICATION_PATH."/models/base/Doc_Print_PaymentBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Print_Payment extends Model_Doc_Print_PaymentBase{
    
}
class Model_Doc_Print_PaymentMapper extends Model_Doc_Print_PaymentMapperBase{
    public function deleteDoc_Print_Payment($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_payment SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function updatesorderDoc_Print_Payment(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_payment SET `order`='0' " ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    //lay ra so luong,serial theo quyen
   public function updatestatusDoc_Print_Payment($id,$stringValueStatus){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_payment SET status='$stringValueStatus'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    //
    
     //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from doc_print_payment where ".$colums."='".$valueColums."' and is_delete = '0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    //lay ra serialrecovery 
     public function findserialrecovery($valueiddocprintcreate){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select serial_recovery from doc_print_payment where doc_print_create_id ='".$valueColums."' and is_delete = '0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->serial_recovery;  
    }
     public function findserialfail($valueiddocprintcreate){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select serial_fail from doc_print_payment where doc_print_create_id ='".$valueColums."' and is_delete = '0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->serial_fail;  
    }
    public function maxdatepayment(){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select max(date_payment)as date from doc_print_payment where is_delete = '0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->date;  
    }
    public function arrayserialpayment($stringserialpayment){
         $array_serial_xoahuhong = array();
        $i = 0;
        //lay serial trong chuoi hu hong
        $array_1 = explode(",", $valueSerialFail);
        if(count($array_1)==1)
        {
            $array_2 = explode("-", $array_1[0]);
            if(count($array_2)==1)
            {
                $array_serial_xoahuhong[$i++]=$array_2[0];
            }  else 
            {
                for($j=$array_2[0];$j<$array_2[1];$j++){
                    $array_serial_xoahuhong[$i++]=$j;
                }
            }
        }  else {
            foreach ($array_1 as $value) {
                $array_3 = explode("-", $value);
                if(count($array_3)==1)
                {
                    $array_serial_xoahuhong[$i++]=$array_3[0];
                }  else {
                    for($k=$array_3[0];$k<$array_3[1];$k++){
                        $array_serial_xoahuhong[$i++]=$k;
                    }
                }
            }
            
        }
        return $array_serial_xoahuhong;
    }

    public function fetchAlll($select){
         $db = Zend_Db_Table::getDefaultAdapter();
//        $select="select * from doc_print_payment where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Payment();
            $entry->setId($row->id)
                ->setId($row->id)                
                ->setSys_Department_Id($row->sys_department_id)
                ->setSys_User_Id($row->sys_user_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setMaster_Print_Id($row->master_print_id)
                ->setSerial_Recovery($row->serial_recovery)
                ->setSerial_Fail($row->serial_fail)
                ->setReasons_Fail($row->reasons_fail)
                ->setDate_Payment($row->date_payment)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)              
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setComment($row->comment)
                ->setIs_Delete($row->is_delete);
                
            $entries[]=$entry;
        }
        return $entries;
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_print_payment where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Payment();
            $entry->setId($row->id)
                ->setId($row->id)                
                ->setSys_Department_Id($row->sys_department_id)
                ->setSys_User_Id($row->sys_user_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setMaster_Print_Id($row->master_print_id)
                ->setSerial_Recovery($row->serial_recovery)
                ->setSerial_Fail($row->serial_fail)
                ->setReasons_Fail($row->reasons_fail)
                ->setDate_Payment($row->date_payment)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)              
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setComment($row->comment)
                ->setIs_Delete($row->is_delete);
                
            $entries[]=$entry;
        }
        return $entries;
    }
    public function arraySerialFail($sys_department_id,$doc_print_allocation_id,$master_print_id,$month,$year){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_print_payment where month(date_payment)='$month' and year(date_payment)='$year' and sys_department_id ='$sys_department_id' and doc_print_allocation_id ='$doc_print_allocation_id' and master_print_id ='$master_print_id' and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $arraySerialFail = array();
        foreach ($rows as $row){
           $arraySerialFail=GlobalLib::mergetwoarrays($arraySerialFail,Model_Doc_Print_PaymentMapper::arrayserialpayment($row->serial_fail));
        }
        return $arraySerialFail;
    }
}
