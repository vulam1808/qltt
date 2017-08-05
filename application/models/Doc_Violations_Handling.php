<?php
include APPLICATION_PATH."/models/base/Doc_Violations_HandlingBase.php";
include APPLICATION_PATH."/models/base/InfoBusinessBase.php";
include APPLICATION_PATH."/models/base/Master_ViolationBase.php";
include APPLICATION_PATH."/models/base/Master_SanctionBase.php";
include APPLICATION_PATH."/models/base/SysDepartmentsBase.php";
include APPLICATION_PATH."/models/base/Master_ItemsBase.php";
include APPLICATION_PATH."/models/base/Master_UnitBase.php";
include APPLICATION_PATH."/models/base/Master_PrintBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Master_Print extends Model_Master_PrintBase{
    
}
class Model_Master_Unit extends Model_Master_UnitBase{
    
}
class Model_Master_Items extends Model_Master_ItemsBase{
    
}
class Model_InfoBusiness extends Model_InfoBusinessBase{
    
}
class Model_Master_Violation extends Model_Master_ViolationBase{
    
}
class Model_Doc_Violations_Handling extends Model_Doc_Violations_HandlingBase{
    
}
class Model_Master_Sanction extends Model_Master_SanctionBase{
    
}
class Model_SysDepartments extends Model_SysDepartmentsBase{
    
}

class Model_Doc_Violations_HandlingMapper extends Model_Doc_Violations_HandlingMapperBase{
    public function deleteDoc_Violations_Handling($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_violations_handling SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
     //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from doc_violations_handling where ".$colums."='".$valueColums."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    public function updatesorderDoc_Violations_Handling(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_violations_handling SET `order`='0' " ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function findidbyid_info_schedule($sys_department_id,$info_schedule_id){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id,info_schedule_id,sys_department_id from doc_violations_handling where sys_department_id='".$sys_department_id."' and info_schedule_id ='".$info_schedule_id."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
     public function fetchAll1(){
         $db = Zend_Db_Table::getDefaultAdapter();
//        $select="select doc_violations_handling.* from doc_violations_handling,info_business where doc_violations_handling.info_business_id=info_business.id and info_business.type_business='".$type_business."'";        
        $select="select * from doc_violations_handling  ";        
//        $select="select * from doc_violations_handling";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Violations_Handling();
            $entry->setId($row->id)
                ->setId($row->id)                
                ->setInfo_Business_Id($row->info_business_id) 
                ->setMaster_Violation_Id($row->master_violation_id)
//                ->setMaster_Sanctions_Id($row->master_sanction_id) 
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
   public function fetchAll($type_business,$id,$month,$year){
        $db = Zend_Db_Table::getDefaultAdapter();
        //$select="select * from doc_violations_handling";
        if($id==NULL)
        $select="select doc_violations_handling.*,info_business.id ids,info_business.type_business from doc_violations_handling inner join info_business on info_business.type_business='".$type_business."' where doc_violations_handling.info_business_id= info_business.id and month(date_violation)='".$month."'and year(date_violation)='".$year."'";        
        else 
        $select="select doc_violations_handling.*,info_business.id ids,info_business.type_business from doc_violations_handling inner join info_business on info_business.type_business='".$type_business."' where doc_violations_handling.info_business_id= info_business.id and month(date_violation)='".$month."'and sys_department_id='".$id."'"; 
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
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
    public function fetchAllMasterViolation(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select * from master_violation";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_Master_Violation();
           $entry->setId($row->id)
                ->setName($row->name);
            $entries[]=$entry;
        }
        return $entries;
    }
    public function fetchAllMasterSanction($where){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select * from master_sanction ". $where;        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_Master_Sanction();
           $entry->setId($row->id)
                ->setName($row->name);
            $entries[]=$entry;
        }
        return $entries;
    }
    public function fetchAllMasterItems(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select * from master_items";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_Master_Items();
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
    public function fetchAllrecordsmanagement($type_business,$year){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select doc_violations_handling.id,month(date_violation) month,sys_department_id from doc_violations_handling inner join info_business on doc_violations_handling.info_business_id= info_business.id and info_business.type_business='".$type_business."' where year(date_violation)='".$year."'"; 
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_Doc_Violations_Handling();    
           $entry->setId($row->id)
                ->setDate_Violation($row->month)
                ->setSys_Department_Id($row->sys_department_id);
            $entries[]=$entry;
           
        }
        return $entries;
    }
    public function fetchAllrecordsmanagementgroup($type_business,$year){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select doc_violations_handling.id,month(date_violation) month,sys_department_id from doc_violations_handling inner join info_business on doc_violations_handling.info_business_id= info_business.id and info_business.type_business='".$type_business."' where year(date_violation)='".$year."' group by doc_violations_handling.sys_department_id"; 
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
           $entry = new Model_Doc_Violations_Handling();    
           $entry->setId($row->id)
                ->setDate_Violation($row->month)
                ->setSys_Department_Id($row->sys_department_id);
            $entries[]=$entry;
           
        }
        return $entries;
    }
    public function fetchAllfrominfobusiness($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_violations_handling where info_business_id='".$id."'"; 
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row){
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
    public function fetchAllinfoschedulecheck($id){
        $arraymonth = array();
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select *  from doc_violations_handling where id='".$id."'";       
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
    public function fetchAllresult($quy,$year){
        if($quy==1){
        $begin = 1;
        $end = 3;
        }
        if($quy==2){
        $begin = 4;
        $end = 6;
        }
        if($quy==3){
        $begin = 7;
        $end = 9;
        }
        if($quy==4){
        $begin = 10;
        $end = 12;
        }
        $entries   = array("results"=>0,"result"=>0); 
        $entries1 = array("results"=>0,"result"=>0);
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select code from master_violation"; 
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entries[$row->code]="";
            $entries1[$row->code]="";
        }
         $select="select count(*) count from info_schedule_check where (month(date_check) between '".$begin."' and '".$end."') and year(date_check)='".$year."'"; 
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
         foreach($rows as $row){
         $resultschedulecheck=$row->count;}
            $select1= "select name,code,count(name) count,Sum(amount) sums FROM doc_violations_handling mv 
                        inner join master_violation dvh on mv.master_violation_id=dvh.id
                       WHERE (mv.is_delete = 0) and (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."'  group by name";
           $stmt1=$db->query($select1);
           $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
           $stmt1->closeCursor();
           //$entries1   = array(); 
           foreach($rows1 as $row2){
           $sum = $row2->sums;
           if(empty($sum))
           {
               $sum = 0;
           }
           $entries["result"]= $sum+$entries["result"];
           $entries[$row2->code]= $sum;
           $entries1["result"]= $row2->count+$entries1["result"];
           $entries["results"]=$entries["result"];
           $entries1[$row2->code]= $row2->count;
           }
           $entries1["results"]=$entries1["result"]+$resultschedulecheck;
        return $entries2 = array($entries1,$entries,$entries,$entries,$entries);
    }
    
     public function fetchresult($quy,$year){
        if($quy==1){
        $begin = 1;
        $end = 3;
        }
        if($quy==2){
        $begin = 4;
        $end = 6;
        }
        if($quy==3){
        $begin = 7;
        $end = 9;
        }
        if($quy==4){
        $begin = 10;
        $end = 12;
        }
        
        $db = Zend_Db_Table::getDefaultAdapter();
         $entriess1   = array("department"=>"","result"=>""); 
         $entriess = array("result"=>"");
         $select="select code from master_violation"; 
             $stmt=$db->query($select);
             $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
             $stmt->closeCursor();
             foreach($rows as $row){
                $entriess[$row->code]="";
                $entriess1[$row->code]="";
             }
        $entries=$entriess;
        $entries1=$entriess1; 
        $entries2 = array();
        $select="select count(*) count,sys_department_id from info_schedule_check where (month(date_check) between '".$begin."' and '".$end."') and year(date_check)='".$year."' group by sys_department_id"; 
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
        $entries=$entriess;
        $entries1=$entriess1;       
        $selects="select count(*) count,sys_department_id from doc_violations_handling where (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'";
        $stmts=$db->query($selects);
        $rowss = $stmts->fetchAll(PDO::FETCH_CLASS);
        $stmts->closeCursor();
        foreach($rowss as $row1)
        $entries1["department"]=  GlobalLib::getName("sys_department",$row->sys_department_id,"name");
        $entries1["result"]=$row->count."/".$row1->count; 
        
        
            $select1= "select name,code,count(name) count,Sum(amount) sums FROM doc_violations_handling mv 
                        inner join master_violation dvh on mv.master_violation_id=dvh.id
                       WHERE (mv.is_delete = 0) and (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'  group by name";
           $stmt1=$db->query($select1);
           $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
           $stmt1->closeCursor();
           foreach($rows1 as $row2){
           $sum = $row2->sums;
           if(empty($sum))
           {
               $sum = 0;
           }
           $entries[$row2->code]= $sum;
           $entries["result"]= $sum+$entries["result"];
           $entries1[$row2->code]= $row2->count;
           }
           $entries2[] = array($entries1,$entries);
       }
        return $entries2;
    }
    public function fetchresultend($quy,$year){
        if($quy==1){
        $begin = 1;
        $end = 3;
        }
        if($quy==2){
        $begin = 4;
        $end = 6;
        }
        if($quy==3){
        $begin = 7;
        $end = 9;
        }
        if($quy==4){
        $begin = 10;
        $end = 12;
        }
        
        $entries   = array("results"=>0,"result"=>0); 
        $entries1 = array("results"=>0,"result"=>0);
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select code from master_violation"; 
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entries[$row->code]="";
            $entries1[$row->code]="";
        }
         $select="select count(*) count from info_schedule_check where (month(date_check) between '".$begin."' and '".$end."') and year(date_check)='".$year."'"; 
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
         foreach($rows as $row){
         $resultschedulecheck=$row->count;}
            $select1= "select name,code,count(name) count,Sum(amount) sums FROM doc_violations_handling mv 
                        inner join master_violation dvh on mv.master_violation_id=dvh.id
                       WHERE (mv.is_delete = 0) and (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."'  group by name";
           $stmt1=$db->query($select1);
           $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
           $stmt1->closeCursor();
           //$entries1   = array(); 
           foreach($rows1 as $row2){
           $sum = $row2->sums;
           if(empty($sum))
           {
               $sum = 0;
           }
           $entries["result"]= $sum+$entries["result"];
           $entries[$row2->code]= $sum;
           $entries1["result"]= $row2->count+$entries1["result"];
           $entries["results"]=$entries["result"];
           $entries1[$row2->code]= $row2->count;
           }
           $entries1["results"]=$entries1["result"]+$resultschedulecheck;
           $entries1["results"]=$entries1["results"]."/".$entries1["result"];
        return $entries2=array($entries1,$entries);
    }
    
    ///
    public function fetchvochu($status,$sys_department_id = null){
        $arraymonth = array();
        $db = Zend_Db_Table::getDefaultAdapter();
        $select=" select t1.id as idvh,t1.sys_department_id,t1.sys_user_id,t1.date_violation,t1.is_delete,t2.id as iditems,t2.master_items_id,t2.master_sanction_id,t2.doc_violations_handling_id,t2.serial_handling,t2.quantity_commodity,t2.master_unit_id,t2.date_handling,t2.amount,t2.status from doc_violations_handling as t1 inner join doc_items_handling as t2 on t1.id = t2.doc_violations_handling_id where t1.is_delete ='0' and t2.is_delete='0' and t2.status='$status' and isnull(t1.info_business_id) and t1.sys_department_id = '$sys_department_id' ;";       
        if($sys_department_id===NULL)
            $select=" select t1.id as idvh,t1.sys_department_id,t1.sys_user_id,t1.date_violation,t1.is_delete,t2.id as iditems,t2.master_items_id,t2.master_sanction_id,t2.doc_violations_handling_id,t2.serial_handling,t2.quantity_commodity,t2.master_unit_id,t2.date_handling,t2.amount,t2.status from doc_violations_handling as t1 inner join doc_items_handling as t2 on t1.id = t2.doc_violations_handling_id where t1.is_delete ='0' and t2.is_delete='0' and t2.status='$status' and isnull(t1.info_business_id) ;";       
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) { 
           $entry = array();
           $entry['idvh']=$row->idvh;
           $entry['sys_department_id']=  GlobalLib::getName('sys_department', $row->sys_department_id, 'name');
           $entry['sys_user_id']=$row->sys_user_id;  
           $entry['date_violation']=$row->date_violation; 
           $entry['iditems']=$row->iditems; 
           $entry['master_items_id']=GlobalLib::getName('master_items',$row->master_items_id,'name'); 
           $entry['master_sanction_id']=GlobalLib::getName('master_sanction',$row->master_sanction_id,'name'); 
           $entry['doc_violations_handling_id']=$row->doc_violations_handling_id; 
           $entry['serial_handling']=$row->serial_handling; 
           $entry['quantity_commodity']=$row->quantity_commodity; 
           $entry['master_unit_id']=GlobalLib::getName('master_unit',$row-> master_unit_id,'name'); 
           $entry['date_handling']=  GlobalLib::viewDate($row-> date_handling); 
           $entry['amount']=$row-> amount; 
           $entry['status']=$row->  status; 
            $entries[]=$entry;
        }
        return $entries;
    }
    
}
