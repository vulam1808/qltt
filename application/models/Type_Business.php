<?php
include APPLICATION_PATH."/models/base/Type_BusinessBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Type_Business extends Model_Type_BusinessBase{
    
}
class Model_Type_BusinessMapper extends Model_Type_BusinessMapperBase{
    public function fetchAllPublished(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=$db->select()
                ->from('Type_Business')
                ->//where('status=1');
        $stmt=$select->query();
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_Province();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setProvince_Code($row->province_code)
                ->setName($row->name)
                ->setCreated($row->created)
                ->setCreated_By($row->created_by)
                ->setModified($row->modified)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status);
            $entries[] = $entry;
        }
        return $entries;
    }
    public function findidbycode($province_code){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from province where province_code='$province_code'";
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
        $select= "select id from province where name='$province_name'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    
}
