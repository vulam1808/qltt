<?php
include APPLICATION_PATH."/models/base/Type_CommodityBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Type_Commodity extends Model_Type_CommodityBase{
    
}
class Model_Type_CommodityMapper extends Model_Type_CommodityMapperBase{
    public function fetchAllPublished(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=$db->select()
                ->from('Type_Commodity')
                ->//where('status=1');
        $stmt=$select->query();
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_Type_Commodity();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setCode($row->code)
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
    public function findidbycode($code){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from Type_Commodity where code='$code'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
    }
    
    public function findidbyname($name){
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from Type_Commodity where name='$name'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    
}
