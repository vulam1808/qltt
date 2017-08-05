<?php
include APPLICATION_PATH."/models/base/Master_ViolationBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Master_Violation extends Model_Master_ViolationBase{
    
}
class Model_Master_ViolationMapper extends Model_Master_ViolationMapperBase{
    public function deleteMaster_Violation($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE master_violation SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
     //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from master_violation where ".$colums."='".$valueColums."' and is_delete ='0'";
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
        $select="select * from master_violation where is_delete ='0' order by created_date DESC";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Master_Violation();
            $entry->setId($row->id)
                  ->setId($row->id)
                ->setName($row->name)
                ->setCode($row->code)    
                     ->setDecree($row->decree) 
                ->setArticle($row->article)
                ->setClause($row->clause)
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
