<?php
include APPLICATION_PATH."/models/base/MasterWardBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_MasterWard extends Model_MasterWardBase{
    
}
class Model_MasterWardMapper extends Model_MasterWardMapperBase{
    public function deleteWard($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE MASTER_WARD SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from master_ward where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_MasterWard();
            $entry->setId($row->id)
                ->setId($row->id)  
                ->setCode($row->code)
                ->setName($row->name)
                ->setMaster_district_Id($row->master_district_id)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);
                
            $entries[]=$entry;
        }
        return $entries;
    }
     public function findidbycode($ward_code){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from master_ward where is_delete=0 and code='$ward_code'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
    }
    public function findidbyname($ward_name){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from master_ward where is_delete=0 and name='$ward_name'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
    }
    public function findprovincebydistrict($district_name){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from master_district where is_delete=0 and name='$district_name'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
    }
}
