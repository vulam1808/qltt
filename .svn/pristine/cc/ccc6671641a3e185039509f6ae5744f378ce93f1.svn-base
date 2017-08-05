<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include APPLICATION_PATH."/models/base/SysDepartmentsBase.php";
class Model_SysDepartments extends Model_SysDepartmentsBase{
    
}
class Model_SysDepartmentsMapper extends Model_SysDepartmentsMapperBase{
   public function deleteDepartments($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE sys_department SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from sys_department where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_SysDepartments();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)  
                ->setLeader($row->leader)
                ->setParent_Id($row->parent_id)
                ->setIs_root($row->is_root)
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
    public function fetchAllfromdocviolationshandling(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select sys_department.id,sys_department.name from sys_department,doc_violations_handling where sys_department.id=doc_violations_handling.sys_department_id group by sys_department.id ";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_SysDepartments();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setName($row->name);
            $entries[]=$entry;
        }
        return $entries;
    }
   public function findidbycode($department_code){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from sys_department where code='$department_code'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
    }   
    public function findbyusername($username){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select max(id) as id from admin where user_name='$username'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return 1;
        } else {
            return $row[0]->id;
        }
    }
   
}
