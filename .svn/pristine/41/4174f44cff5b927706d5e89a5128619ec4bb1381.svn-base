<?php
include APPLICATION_PATH."/models/base/Master_Items_ConditionBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Master_Items_Condition extends Model_Master_Items_ConditionBase{
    
}
class Model_Master_Items_ConditionMapper extends Model_Master_Items_ConditionMapperBase{
    public function deleteMaster_Items_Condition($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE master_items_condition SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    //
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from master_items_condition where ".$colums."='".$valueColums."' and is_delete='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
     //tra ve id theo cot va gia tri can tim
//    public function findidbyname($colums,$valueColums){        
//       $db = Zend_Db_Table::getDefaultAdapter();
//        $select= "select id from master_items_condition where ".$colums."='".$valueColums."' where is_delete ='0'";
//        $stmt=$db->query($select);
//        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
//        $stmt->closeCursor();
//        if($row==NULL){
//            return null;
//        }
//        return $row[0]->id;  
//    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from master_items_condition where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Master_Items_Condition();
            $entry->setId($row->id)
                  ->setId($row->id)
                ->setName($row->name)
                ->setCode($row->code)     
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
    
}
