<?php
include APPLICATION_PATH."/models/base/MasterDistrictBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_MasterDistrict extends Model_MasterDistrictBase{
    
}
class Model_MasterDistrictMapper extends Model_MasterDistrictMapperBase{
     public function deleteMasterDistrict($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE MASTER_DISTRICT SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);  
        $select1 ="UPDATE MASTER_WARD SET is_delete='1'  WHERE master_district_id='".$id."'" ;
        $stmt1=$db->query($select1);             
        $stmt->closeCursor(); 
        $stmt1->closeCursor(); 
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from master_district where is_delete=0";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_MasterDistrict();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setMaster_province_Id($row->master_province_id)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);
            $entries[]=$entry;
        }
        return $entries;
    }
     public function  fetchAll_REPORT($wherer){
        $db = Zend_Db_Table::getDefaultAdapter();      
       $select=" select * from master_district ".$wherer."";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
            $entry = new Model_MasterDistrict();   
           $entry->setId($row->id)
                 ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setMaster_province_Id($row->master_province_id)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);
            $entries[]=$entry;
        }
        return $entries;
    }
     public function findidbycode($district_code){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id,code from master_district where is_delete=0 and code='$district_code'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
    }
    public function findidbyname($district_name){
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
