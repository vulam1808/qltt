<?php
include APPLICATION_PATH."/models/base/Doc_Print_HandlingBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Print_Handling extends Model_Doc_Print_HandlingBase{
    
}
class Model_Doc_Print_HandlingMapper extends Model_Doc_Print_HandlingMapperBase{
    public function deleteDoc_Print_Handling($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_handling SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
     //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from doc_print_handling where ".$colums."='".$valueColums."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_print_handling where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Handling();
            $entry->setId($row->id)
                  ->setId($row->id)
                      ->setMaster_Print_Id($row->master_print_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setDoc_Violations_Handling_Id($row->doc_violations_handling_id)                
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
    public function findbydoc_violation_handing_id($id){
         $db = Zend_Db_Table::getDefaultAdapter();
//        $select="select 
//            doc_print_handling.id,
//            master_print.code,
//            master_print.name,
//            doc_print_allocation.master_print_id
//            from doc_print_handling 
//            left join doc_print_allocation on 
//                doc_print_handling.doc_print_allocation_id = doc_print_allocation.id
//            left join doc_print_create on
//                doc_print_allocation.doc_print_create_id = doc_print_create.id
//            left join master_print on
//                doc_print_create.master_print_id = master_print.id
//            where doc_print_handling.is_delete =0 and doc_print_handling.doc_violations_handling_id = ".$id;        
         $select = "select id,master_print_id,serial_handing,doc_violations_handling_id from doc_print_handling where doc_violations_handling_id='".$id."'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();    
        $entries = null;
        foreach ($rows as $row){
            $entries[] = array(
                'id' => $row->id,
                'code' => GlobalLib::getName("master_print",$row->master_print_id,"code"),
                'name' => GlobalLib::getName("master_print",$row->master_print_id,"name"),
                'serial' => $row->serial_handing
            );
        }
        return $entries;
    }
    public function arrayserial_handingsysdepartment($doc_print_allocation_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial_handing from doc_print_handling where doc_print_allocation_id ='$doc_print_allocation_id'  and is_delete ='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();$i=0;
        foreach ($rows as $row){
            $entries[$i++]=$row->serial_handing;
        }
        return $entries;
    }
    //////////
    public function arrayserial_handingsysdepartment_month($doc_print_allocation_id,$month,$year){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select t.serial_handing as serial_handing,t.doc_violations_handling_id,t.doc_print_allocation_id from doc_print_handling as t where t.doc_violations_handling_id in (select t1.id form doc_violations_handling as t1 where month(t1.date_violation)='".$month."' and year(t1.date_violation)='".$year."') and t.doc_print_allocation_id ='$doc_print_allocation_id' and t.is_delete ='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();$i=0;
        foreach ($rows as $row){
            $entries[$i++]=$row->serial_handing;
        }
        return $entries;
    }
    ////////////
}
