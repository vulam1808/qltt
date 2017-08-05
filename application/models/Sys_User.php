<?php
include APPLICATION_PATH."/models/base/Sys_UserBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Sys_User extends Model_Sys_UserBase{
    
}
class Model_Sys_UserMapper extends Model_Sys_UserMapperBase{
    public function deleteSys_User($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE Sys_User SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from sys_user where ".$colums."='".$valueColums."' and is_delete ='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    //kiem tra xem da co truong phong chua
     public function findidbyisleader($colums,$valueColums){
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from sys_user where ".$colums."='".$valueColums."' and is_delete ='0' and is_leader='1'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    public function fetchAlll($where){
//        $where="";
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from Sys_User where is_delete ='0'".$where."";     
//          $select="select * from Sys_User where is_delete ='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Sys_User();
            $entry->setId($row->id)
                     ->setId($row->id)
                    ->setUserName($row->username)
                    ->setPassword($row->password)
                    ->setCellPhone($row->cellphone)
                    ->setEmail($row->email)
                    ->setFirst_Name($row->first_name)
                    ->setLast_Name($row->last_name)
                    ->setBirthday($row->birthday)
                    ->setSys_Department_Id($row->sys_department_id)
                    ->setMaster_Province_Id($row->master_province_id)
                    ->setMaster_District_Id($row->master_district_id)
                    ->setMaster_Ward_Id($row->master_ward_id)
                    ->setIs_Leader($row->is_leader)
                    ->setSys_User_Group_Id($row->sys_user_group_id)
                    ->setCreated_Date($row->created_date)
                    ->setCreated_By($row->created_by)
                    ->setModified_Date($row->modified_date)
                    ->setModified_By($row->modified_by)
                    ->setComment($row->comment)
                    ->setIs_Delete($row->is_delete)
                    ->setOrder($row->order)
                    ->setStatus($row->status);
            $entries[]=$entry;
        }
        return $entries;
    }
   

    public function fetchAllFromSysDeparments($sys_department_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select id,username,sys_department_id from sys_user where sys_department_id='".$sys_department_id."'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_Sys_User();
           $entry->setId($row->id)
                ->setUserName($row->username);
            $entries[]=$entry;
        }
        return $entries;
    }

    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
          $select="select * from Sys_User where is_delete ='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Sys_User();
            $entry->setId($row->id)
                     ->setId($row->id)
                    ->setUserName($row->username)
                    ->setPassword($row->password)
                    ->setCellPhone($row->cellphone)
                    ->setEmail($row->email)
                    ->setFirst_Name($row->first_name)
                    ->setLast_Name($row->last_name)
                    ->setBirthday($row->birthday)
                    ->setSys_Department_Id($row->sys_department_id)
                    ->setMaster_Province_Id($row->master_province_id)
                    ->setMaster_District_Id($row->master_district_id)
                    ->setMaster_Ward_Id($row->master_ward_id)
                    ->setIs_Leader($row->is_leader)
                    ->setSys_User_Group_Id($row->sys_user_group_id)
                    ->setCreated_Date($row->created_date)
                    ->setCreated_By($row->created_by)
                    ->setModified_Date($row->modified_date)
                    ->setModified_By($row->modified_by)
                    ->setComment($row->comment)
                    ->setIs_Delete($row->is_delete)
                    ->setOrder($row->order)
                    ->setStatus($row->status);
            $entries[]=$entry;
        }
        return $entries;
    }
   

    
    
}
