<?php
include APPLICATION_PATH."/models/base/Doc_Items_HandlingBase.php";

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Items_Handling extends Model_Doc_Items_HandlingBase{
    
}
class Model_Doc_Items_HandlingMapper extends Model_Doc_Items_HandlingMapperBase{
    public function deleteDoc_Items_Handling($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_items_handling SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
     //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from doc_items_handling where ".$colums."='".$valueColums."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    public function findid($id){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from doc_items_handling where id='".$id."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    public function fetchAll($status,$month,$year,$sys_department_id = null){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="";
        $select1="select t1.*,t2.sys_department_id from doc_items_handling as t1 inner join doc_violations_handling as t2
                    on t1.doc_violations_handling_id =  t2.id and t2.sys_department_id = '$sys_department_id'  
                    where t1.is_delete ='0' and month(t1.date_handling)='".$month."' and year(t1.date_handling)='".$year."' and (t1.status='TG-CXL_TG' or t1.status='TL_TG' or t1.status='CGCQK_TG' or t1.status='XLN_TG') ";  
        $select2="select t1.*,t2.sys_department_id from doc_items_handling as t1 inner join doc_violations_handling as t2
                    on t1.doc_violations_handling_id =  t2.id and t2.sys_department_id = '$sys_department_id'  
                     where t1.is_delete ='0' and (month(t1.date_handling)='".$month."' and year(t1.date_handling)='".$year."' and t1.status='".$status."') ";        
        if($sys_department_id===NULL)
        {
            $select1="select * from doc_items_handling where is_delete ='0' and (month(date_handling)='".$month."' and year(date_handling)='".$year."' and status='TG-CXL_TG' or status='TL_TG' or status='CGCQK_TG' or status='XLN_TG') ";  
            $select2="select * from doc_items_handling where is_delete ='0' and (month(date_handling)='".$month."' and year(date_handling)='".$year."' and status='".$status."') ";        
        }
        if($status == "ALL"){
           $select =  $select1;
        }else{
           $select =  $select2; 
        }
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Items_Handling();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setMaster_Items_Id($row->master_items_id) 
                ->setMaster_Sanction_Id($row->master_sanction_id)
                ->setDoc_Violations_Handling_id($row->doc_violations_handling_id) 
                ->setSerial_Handling($row->serial_handling)
                ->setQuantity_Commodity($row->quantity_commodity) 
                ->setMaster_Unit_Id($row->master_unit_id)
                ->setDate_Handling($row->date_handling)
                ->setAmount($row->amount) 
                ->setFile_Upload($row->file_upload)
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
    //tich thu
    public function fetchAlltichthu($status,$month,$year,$sys_department_id = null){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="";
        $select1="select t1.*,t2.sys_department_id from doc_items_handling as t1 inner join doc_violations_handling as t2
                    on t1.doc_violations_handling_id =  t2.id and t2.sys_department_id = '$sys_department_id'  
                    where t1.is_delete ='0' and month(t1.date_handling)='".$month."' and year(t1.date_handling)='".$year."' and (t1.status='TT_TT' or t1.status='TH_TT' or t1.status='ĐG_TT' or t1.status='CGCQKSD_TT' or status='XLN_TT' )";  
        $select2="select t1.*,t2.sys_department_id from doc_items_handling as t1 inner join doc_violations_handling as t2
                    on t1.doc_violations_handling_id =  t2.id and t2.sys_department_id = '$sys_department_id'  
                     where t1.is_delete ='0' and (month(t1.date_handling)='".$month."' and year(t1.date_handling)='".$year."' and t1.status='".$status."' )";        
        if($sys_department_id===NULL)
        {
            $select1="select * from doc_items_handling where is_delete ='0' and (month(date_handling)='".$month."' and year(date_handling)='".$year."' and status='TT_TT' or status='TH_TT' or status='ĐG_TT' or status='CGCQKSD_TT' or status='XLN_TT' )";  
            $select2="select * from doc_items_handling where is_delete ='0' and (month(date_handling)='".$month."' and year(date_handling)='".$year."' and status='".$status."' )";        
        }
        if($status == "ALL"){
           $select =  $select1;
        }else{
           $select =  $select2; 
        }
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Items_Handling();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setMaster_Items_Id($row->master_items_id) 
                ->setMaster_Sanction_Id($row->master_sanction_id)
                ->setDoc_Violations_Handling_id($row->doc_violations_handling_id) 
                ->setSerial_Handling($row->serial_handling)
                ->setQuantity_Commodity($row->quantity_commodity) 
                ->setMaster_Unit_Id($row->master_unit_id)
                ->setDate_Handling($row->date_handling)
                ->setAmount($row->amount) 
                ->setFile_Upload($row->file_upload)
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
    function finditembyViolationHandling($doc_violations_handling_id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
//        $select="select doc_items_handling.serial_handling, master_items.name from doc_items_handling 
//            left join master_items on master_items.id = doc_items_handling.master_items_id 
//            where doc_items_handling.doc_violations_handling_id = ".$doc_violations_handling_id;      
        $select = "select id,master_sanction_id,master_items_id,doc_violations_handling_id,serial_handling from doc_items_handling where doc_violations_handling_id='".$doc_violations_handling_id."'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $result = null;
        foreach ($rows as $row)
        {
            $result[] = array(
                'id'=>$row->id,
                'name'=>  GlobalLib::getName("master_items",$row->master_items_id,"name"),
                'sanction'=>  GlobalLib::getName("master_sanction",$row->master_sanction_id,"name"),
                'serial'=>$row->serial_handling                
            );
        }
        return $result;
    }
    
}
