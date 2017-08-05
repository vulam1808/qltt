<?php
include APPLICATION_PATH."/models/base/Sys_User_Group_DetailBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Sys_User_Group_Detail extends Model_Sys_User_Group_DetailBase{
    
}
class Model_Sys_User_Group_DetailMapper extends Model_Sys_User_Group_DetailMapperBase{
    public function deleteSys_User_Group_Detail($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE Sys_User_Group_Detail SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from Sys_User_Group_Detail where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Sys_User_Group_Detail();
            $entry->setId($row->id)
                    ->setId($row->id)
                    ->setSys_User_Group_Id($row->sys_user_group_id)
                    ->setSys_Privileges($row->sys_privileges)               
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
