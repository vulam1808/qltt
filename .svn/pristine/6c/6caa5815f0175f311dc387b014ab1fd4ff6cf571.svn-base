<?php
include APPLICATION_PATH."/models/base/Sys_User_GroupBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Sys_User_Group extends Model_Sys_User_GroupBase{
    
}
class Model_Sys_User_GroupMapper extends Model_Sys_User_GroupMapperBase{
    public function deleteSys_User_Group($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE sys_user_group SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from Sys_User_Group where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Sys_User_Group();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setGroup_Name($row->group_name)                
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
