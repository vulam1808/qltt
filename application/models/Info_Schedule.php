<?php
include APPLICATION_PATH."/models/base/Info_ScheduleBase.php";
include APPLICATION_PATH."/models/base/InfoBusinessBase.php";
include APPLICATION_PATH."/models/base/Master_ViolationBase.php";
include APPLICATION_PATH."/models/base/Master_SanctionBase.php";
include APPLICATION_PATH."/models/base/SysDepartmentsBase.php";
include APPLICATION_PATH."/models/base/Master_ItemsBase.php";
include APPLICATION_PATH."/models/base/Master_UnitBase.php";
include APPLICATION_PATH."/models/base/Master_PrintBase.php";

class Model_Info_Schedule extends Model_Info_ScheduleBase{
    
}

class Model_Info_ScheduleMapper extends Model_Info_ScheduleMapperBase{
    public function deleteinfo_schedule($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE info_schedule SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
     //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from info_schedule where ".$colums."='".$valueColums."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }

   
   public function fetchAll($sys_department_id = null){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from info_schedule where sys_department_id = '$sys_department_id' ";
        if($sys_department_id===NULL)
        {
            $select="select * from info_schedule";
        }
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Info_Schedule();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setName_Schedule($row->name_schedule) 
                ->setDate_From($row->date_from)
                ->setDate_To($row->date_to) 
                ->setSys_Department_Id($row->sys_department_id)
                ->setMaster_District_Id($row->master_district_id) 
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setIs_Confirm($row->is_confirm)
                ->setConfirm_Sys_User_Id($row->confirm_sys_user_id)
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
   public function getAddressbusiness($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select address_office from info_business where id='".$id."'" ;        
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->address_office;  
    }
    public function fetchAllInfoBusiness($where){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select * from info_business ".$where;        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_InfoBusiness();
            if(empty($row->address_office))
            {
                $row->address_office = "";
            }
           $entry->setId($row->id)
                ->setName($row->name)
                ->setAddress_Office($row->address_office);
            $entries[]=$entry;
        }
        return $entries;
    }
    public function fetchAllSysDeparments(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select * from sys_deparment";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_SysDeparments();
           $entry->setId($row->id)
                ->setName($row->name);
            $entries[]=$entry;
        }
        return $entries;
    }

     public function fetchAllMasterUnit(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select * from master_unit";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_Master_Unit();
           $entry->setId($row->id)
                ->setName($row->name);
            $entries[]=$entry;
        }
        return $entries;
    }
     public function fetchAllMasterPrint(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select * from master_print";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_Master_Print();
           $entry->setId($row->id)
                ->setName($row->name);
            $entries[]=$entry;
        }
        return $entries;
    }

    public function fetchAllprintrecords($id,$month){
        $arraymonth = array();
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select *  from doc_violations_handling where sys_user_id='".$id."' and month(date_violation)='".$month."'";       
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_Doc_Violations_Handling();    
           $entry->setId($row->id)
                ->setId($row->id)
                ->setInfo_Business_Id($row->info_business_id) 
                ->setMaster_Violation_Id($row->master_violation_id)
                ->setMaster_Sanctions_Id($row->master_sanctions_id) 
                ->setSys_Department_Id($row->sys_department_id)
                ->setSys_User_id($row->sys_user_id) 
                ->setDate_Violation($row->date_violation)
                ->setAmount($row->amount)
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
