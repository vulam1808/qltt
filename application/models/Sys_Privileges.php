<?php
include APPLICATION_PATH."/models/base/Sys_PrivilegesBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Sys_Privileges extends Model_Sys_PrivilegesBase{
    
}
class Model_Sys_PrivilegesMapper extends Model_Sys_PrivilegesMapperBase{
    public function deleteSysPrivileges($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE Sys_Privileges SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from Sys_Privileges where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Sys_Privileges();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setName($row->name)
                ->setModule($row->module)
                ->setController($row->controller)
                ->setAction($row->action)              
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setIs_Delete($row->is_delete)
                ->setComment($row->comment)    
                ->setOrder($row->order)
                ->setStatus($row->status);                
            $entries[]=$entry;
        }
        return $entries;
    }
    
}
