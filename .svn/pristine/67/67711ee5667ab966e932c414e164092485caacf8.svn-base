<?php
include APPLICATION_PATH."/models/base/MasterProvinceBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_MasterProvince extends Model_MasterProvinceBase{
    
}
class Model_MasterProvinceMapper extends Model_MasterProvinceMapperBase{
    public function deleteMasterProvince($id){
//        $db = Zend_Db_Table::getDefaultAdapter();
//        $select ="UPDATE master_province SET is_delete='1'  WHERE id='".$id."'" ;
//        $stmt=$db->query($select);
//        $select1 ="UPDATE master_district SET is_delete='1'  WHERE master_province_id='".$id."'" ;
//        $stmt1=$db->query($select1);
//        $stmt->closeCursor(); 
//        $stmt1->closeCursor(); 
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from master_province";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_MasterProvince();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setComment($row->comment)
                ->setIs_delete($row->is_delete)
                ->setStatus($row->status);
            $entries[]=$entry;
        }
        return $entries;
    }
    public function findidbycode($province_code){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from master_province where is_delete=0 and code='$province_code'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
    }
    
    public function findidbyname($province_name){
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from master_province where is_delete=0 and name='$province_name'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    
}
