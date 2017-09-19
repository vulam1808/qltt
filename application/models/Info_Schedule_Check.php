<?php
include APPLICATION_PATH."/models/base/Info_Schedule_CheckBase.php";
//include APPLICATION_PATH."/models/base/InfoBusinessBase.php";
//include APPLICATION_PATH."/models/base/Master_ViolationBase.php";
//include APPLICATION_PATH."/models/base/Master_SanctionBase.php";
//include APPLICATION_PATH."/models/base/SysDepartmentsBase.php";
//include APPLICATION_PATH."/models/base/Master_ItemsBase.php";
//include APPLICATION_PATH."/models/base/Master_UnitBase.php";
//include APPLICATION_PATH."/models/base/Master_PrintBase.php";

class Model_Info_Schedule_Check extends Model_Info_Schedule_CheckBase{
    
}

class Model_Info_Schedule_CheckMapper extends Model_Info_Schedule_CheckMapperBase{
    public function deleteInfo_Schedule_Check($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE info_schedule_check SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    //cap nhat id_doc_violationshandling cho bang info_schedule_check
     public function updateInfo_Schedule_Check($id,$value){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE info_schedule_check SET doc_violations_handling_id='$value' where id ='$id' " ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
     //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from info_schedule_check where ".$colums."='".$valueColums."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    //
     public function findidbyid_info_schedule($sys_department_id,$info_schedule_id){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select distinct id,info_schedule_id,sys_department_id from info_schedule_check where sys_department_id='".$sys_department_id."' and info_schedule_id ='".$info_schedule_id."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
   
   public function fetchAll($sys_department_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        if($sys_department_id==null)
        $select="select * from info_schedule_check";
        else {
        $select="select * from info_schedule_check where sys_department_id ='".$sys_department_id."'";
        }
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Info_Schedule_Check();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setInfo_Schedule_Id($row->info_schedule_id) 
                ->setInfo_Business_Id($row->info_business_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id) 
                ->setSerial_Check($row->serial_check)
                ->setStaff_Check($row->staff_check) 
                ->setDate_Check($row->date_check)
                ->setSys_Department_Id($row->sys_department_id)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)              
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setComment($row->comment)
                ->setDoc_Violations_Handling_Id($row->doc_violations_handling_id)
                ->setIs_Delete($row->is_delete);
            $entries[]=$entry;
        }
        return $entries;
    }
    public function fetchAllbyscheduleid($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from info_schedule_check where info_schedule_id='".$id."'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Info_Schedule_Check();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setInfo_Schedule_Id($row->info_schedule_id) 
                ->setInfo_Business_Id($row->info_business_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id) 
                ->setSerial_Check($row->serial_check)
                ->setStaff_Check($row->staff_check) 
                ->setDate_Check($row->date_check)
                ->setSys_Department_Id($row->sys_department_id)
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
    ///
     public function fetchAlll($where){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from info_schedule_check ".$where;
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Info_Schedule_Check();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setInfo_Schedule_Id($row->info_schedule_id) 
                ->setInfo_Business_Id($row->info_business_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id) 
                ->setSerial_Check($row->serial_check)
                ->setStaff_Check($row->staff_check) 
                ->setDate_Check($row->date_check)
                ->setSys_Department_Id($row->sys_department_id)
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
    //
   public function arrayserialcheck($doc_print_allocation_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial_check from info_schedule_check where doc_print_allocation_id ='$doc_print_allocation_id' and is_delete ='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();$i=0;
        foreach ($rows as $row){
            $entries[$i++]=$row->serial_check;
        }
        return $entries;
    }
    public function arrayserialchecksysdepartment($sys_department_id,$doc_print_allocation_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial_check from info_schedule_check where doc_print_allocation_id ='$doc_print_allocation_id' and sys_department_id ='$sys_department_id' and is_delete ='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        $i=0;
        foreach ($rows as $row){
            $entries[$i++]=$row->serial_check;
        }
        if($rows == null)
        {
            $select1="select serial_check from info_schedule_check where sys_department_id ='$sys_department_id' and is_delete ='0'";
            $stmt = $db->query($select1);
            $rows1 = $stmt->fetchAll(PDO::FETCH_CLASS);
            $stmt->closeCursor();
            $entries1 = array();
            $i=0;
            foreach ($rows1 as $row){
                $entries1[$i++]=$row->serial_check;
            }
            return $entries1;
        }
        return $entries;
    }
    //lay serialcheck_sysdepartment theo phong ban,id_doc_allocation va theo thang
     public function arrayserialchecksysdepartment_month($sys_department_id,$doc_print_allocation_id,$month,$year){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial_check from info_schedule_check where doc_print_allocation_id ='$doc_print_allocation_id' and sys_department_id ='$sys_department_id' and  month(date_check)='".$month."' and year(date_check)='".$year."' and is_delete ='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();$i=0;
        foreach ($rows as $row){
            $entries[$i++]=$row->serial_check;
        }
        return $entries;
    }
    /*****************************************************************************/
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
    public function fetchAllFromSysDeparments(){
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

    // Hien thi du lieu theo Hanh Vi Vi Pham (1:'0: ko vi pham, 1: Vi Pham'; 2: '2: Co dau hieu vi pham')
    public function fetchAllByIsViolations($sys_department_id, $type_violations)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        if ($sys_department_id == null) {
            if($type_violations == 1)
                $select = "select * from info_schedule_check where is_violations in (0,1,3)";
            else
                $select = "select * from info_schedule_check where is_violations=2";
        }
        else {
            if($type_violations == 1)
                $select="select * from info_schedule_check where sys_department_id ='".$sys_department_id."' and is_violations in (0,1,3)";
            else
                $select="select * from info_schedule_check where sys_department_id ='".$sys_department_id."' and is_violations=2";
        }
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Info_Schedule_Check();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setInfo_Schedule_Id($row->info_schedule_id)
                ->setInfo_Business_Id($row->info_business_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setSerial_Check($row->serial_check)
                ->setStaff_Check($row->staff_check)
                ->setDate_Check($row->date_check)
                ->setSys_Department_Id($row->sys_department_id)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setComment($row->comment)
                ->setDoc_Violations_Handling_Id($row->doc_violations_handling_id)
                ->setIs_Delete($row->is_delete);
            $entries[]=$entry;
        }
        return $entries;
    }
    
}
