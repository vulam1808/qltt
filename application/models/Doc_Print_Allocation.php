<?php
include APPLICATION_PATH."/models/base/Doc_Print_AllocationBase.php";

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Print_Allocation extends Model_Doc_Print_AllocationBase{
    
}
class Model_Doc_Print_AllocationMapper extends Model_Doc_Print_AllocationMapperBase{
    public function deleteDoc_Print_Allocation($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_allocation SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function updatesorderDoc_Print_Allocation(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_allocation SET `order`='0' " ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function updatestatusDoc_Print_Allocation($id,$stringValueStatus){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_allocation SET status='$stringValueStatus'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
     public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from doc_print_allocation where ".$colums."='".$valueColums."' and is_delete='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    //ham tra ve id_doc_print_allocation
    public function findidbyserial($masterprintid,$sysdepartmentid,$valueserial){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id,master_print_id,sys_department_id,serial_recovery1 from doc_print_allocation where master_print_id='$masterprintid' and sys_department_id='$sysdepartmentid' and is_delete='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $arrayserial = array();$i=0;$id=0;
        foreach ($rows as $row){
            $arraytam = explode("-", $row->serial_recovery1);
            for($j=(int)$arraytam[0];$j<=(int)$arraytam[1];$j++){
                $arrayserial[$i++]=$j;
            }
            if(GlobalLib::ckeckarray($valueserial,$arrayserial)==1){
                $id = $row->id;break;
            }
            
        }
        if($id != null){
            return $id;
        }  else {
            return null;
        }
        
    }
     public function findidbyname1($valueColums1,$valueColums2){        
       $db = Zend_Db_Table::getDefaultAdapter();
       // $select= "select id from doc_print_allocation where ".$colums1."='".$valueColums1."' and ".$colums2."='".$valueColums2."' and is_delete='0'";
       $select= "select id from doc_print_allocation where master_print_id='$valueColums1' and doc_print_create_id='$valueColums2' and is_delete='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    public function findidbyserialrecovery1($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select serial_recovery1 from doc_print_allocation where ".$colums."='".$valueColums."' and is_delete='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->serial_recovery1;  
    }
    //lay ra danh sach an chi da duoc nhap vao trong bang doc_print_created
    public function maxdateallocation(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select max(date_allocation)as date_allocation from doc_print_allocation where  is_delete='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($rows==NULL){
            return null;
        }
        return $rows[0]->date_allocation;  
    }
    
 public function fetchAlllPrint($select){
        $db = Zend_Db_Table::getDefaultAdapter();
        //$select1="select distinct master_print_id from doc_print_allocation where sys_department_id=18 and sys_user_id=24 and request_number='Lan-Cap-001'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
            $entry
                ->setMaster_Print_Id($row->master_print_id);
            $entries[]=$entry;
        }
        return $entries;
    }
   public function fetchAlllExport($select){
         $db = Zend_Db_Table::getDefaultAdapter();
       // $select="select * from doc_print_allocation where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
            $entry             
                ->setDoc_Print_Create_id($row->doc_print_create_id)
                ->setMaster_Print_Id($row->master_print_id)
                ->setSys_Department_id($row->sys_department_id)
                ->setUser_Id($row->sys_user_id)
                ->setRequest_Number($row->request_number)
                ->setDate_Allocation($row->date_allocation)
                ->setCreated_Date($row->created_date)
               ;
            $entries[]=$entry;
        }
        return $entries;
    } 
    
     public function fetchAlllExportPrintPayment($where){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_print_allocation where sys_department_id='$where' and status ='DOING' and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
            $entry  
                ->setId($row->id)    
                ->setDoc_Print_Create_id($row->doc_print_create_id)
                ->setMaster_Print_Id($row->master_print_id)
                ->setSys_Department_id($row->sys_department_id)
                ->setSerial_Recovery1($row->serial_recovery1)    
               
               ;
            $entries[]=$entry;
        }
        return $entries;
    } 
    public function fetchAlllSerial($masterprintid,$sysdepartmentid){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select id,serial_recovery1,master_print_id,sys_department_id from doc_print_allocation where sys_department_id='$sysdepartmentid' and master_print_id ='$masterprintid' and status ='DOING' and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
            $entry  
                ->setId($row->id)  
                ->setMaster_Print_Id($row->master_print_id)
                ->setSys_Department_id($row->sys_department_id)
                ->setSerial_Recovery1($row->serial_recovery1)    
               
               ;
            $entries[]=$entry;
        }
        return $entries;
    } 
    
    public function fetchAlll($select){
         $db = Zend_Db_Table::getDefaultAdapter();
       // $select="select * from doc_print_allocation where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
            $entry->setId($row->id)
                 ->setId($row->id)                
                ->setDoc_Print_Create_id($row->doc_print_create_id)
                ->setMaster_Print_Id($row->master_print_id)
                ->setSys_Department_id($row->sys_department_id)
                ->setSys_User_Id($row->sys_user_id)
                ->setRequest_Number($row->request_number)
                ->setDate_Allocation($row->date_allocation)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)              
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setComment($row->comment)
                    ->setSerial_Recovery1($row->serial_recovery1)
                ->setIs_Delete($row->is_delete);
            $entries[]=$entry;
        }
        return $entries;
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_print_allocation where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
            $entry->setId($row->id)
                 ->setId($row->id)                
                ->setDoc_Print_Create_id($row->doc_print_create_id)
                ->setMaster_Print_Id($row->master_print_id)
                ->setSys_Department_id($row->sys_department_id)
                ->setUser_Id($row->sys_user_id)
                ->setRequest_Number($row->request_number)
                ->setDate_Allocation($row->date_allocation)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)              
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setComment($row->comment)
                ->setSerial_Recovery1($row->serial_recovery1)
                ->setIs_Delete($row->is_delete);
            $entries[]=$entry;
        }
        return $entries;
    }
    //ham lay serial theo ma an chi va theo phong ban
    public function arrayserial($master_print_id,$sys_department_id){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select id,master_print_id,sys_department_id,serial_recovery1,is_delete,status from doc_print_allocation where master_print_id='$master_print_id' and sys_department_id='$sys_department_id' and is_delete ='0' and status !='RECOVERY'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
            $entry->setId($row->id)
                    ->setId($row->id)   
                    ->setMaster_Print_Id($row->master_print_id)
                    ->setSys_Department_id($row->sys_department_id)
                    ->setSerial_Recovery1($row->serial_recovery1)
                    ->setIs_Delete($row->is_delete);
            $entries[]=$entry;
        }
        return $entries;
    }  
     public function arrayserial_month($master_print_id,$sys_department_id,$month,$year){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select id,master_print_id,sys_department_id,serial_recovery1,date_allocation,is_delete from doc_print_allocation where month(date_allocation)='".$month."' and year(date_allocation)='".$year."' and master_print_id='$master_print_id' and sys_department_id='$sys_department_id' and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
            $entry->setId($row->id)
                    ->setId($row->id)   
                    ->setMaster_Print_Id($row->master_print_id)
                    ->setSys_Department_id($row->sys_department_id)
                    ->setSerial_Recovery1($row->serial_recovery1)
                    ->setIs_Delete($row->is_delete);
            $entries[]=$entry;
        }
        return $entries;
    }    












































    //Tra ve gia tri ngay gio cho lan cap phat gan day nhat theo an chi
    public function dateSerialMax($serial,$is_master_print){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select date_allocation from doc_print_allocation where master_print_id ='$is_master_print' and serial_allocation ='$serial'and is_delete='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($rows==NULL){
            return null;
        }
        return $rows[0]->date_allocation;  
    }
    
    
    
    
    
    //Danh sach serial theo ngay
    public function fetchallserialdate($date){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial_allocation from doc_print_allocation where is_delete ='0' and date_allocation='$date'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
            $entry->setSerial_Allocation($row->serial_allocation);
            $entries[]=$entry;
        }
        return $entries;
    }

    //Nhan id_master_print hoac phong ban tra ra chuoi serial theo dang chuoi rut gon
      //ham tra ve chuoi serial_allocation
      public function stringprint_allocation($id_master_print){
        $db = Zend_Db_Table::getDefaultAdapter();
        $array_string_serial = array(); 
//        $flag = $min;
        $stmt = $db->query("select min(serial_allocation) as serialmin from doc_print_allocation where master_print_id = '$id_master_print' and is_delete='0' ");
        $rowsmin = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($rowsmin==NULL){
            return null;
        }
        return $row[0]->serialmin;  
      }
      //ham tra ve chuoi serial_recovery
    /*******************************************/
     //tra ve id theo cot va gia tri can tim
   
   
   
   public function findidbynamemax($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id,max(serial_allocation) as serial from doc_print_allocation where ".$colums."='".$valueColums."' and is_delete ='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->serial;  
    }
    //
    
    
    public function fetchAlll1($select){
         $db = Zend_Db_Table::getDefaultAdapter();
       // $select="select * from doc_print_allocation where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
             $entry->//setDoc_Print_Create_id($row->doc_print_create_id)
                   setSys_Department_Id($row->sys_department_id)
                   ->setDate_Allocation($row->date_allocation)
                   ->setMaster_Print_Id($row->master_print_id)      
               ;
            $entries[]=$entry;
        }
        return $entries;
    }
    ////mmmm///
     public function fetchAlll11($select){
         $db = Zend_Db_Table::getDefaultAdapter();
       // $select="select * from doc_print_allocation where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
             $entry->setMaster_Print_Id($row->master_print_id)
                     ->setDoc_Print_Create_Id($row->doc_print_create_id)
                      ->setId($row->id)
                     ;
            $entries[]=$entry;
        }
        return $entries;
    }
     public function fetchAlll11q($select){
         $db = Zend_Db_Table::getDefaultAdapter();
       // $select="select * from doc_print_allocation where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
             $entry->setMaster_Print_Id($row->master_print_id)
//                     ->setDoc_Print_Create_Id($row->doc_print_create_id)
//                      ->setId($row->id)
                     ;
            $entries[]=$entry;
        }
        return $entries;
    }
    ///
   
     ////mmmm///
     public function fetchAllSerialDepartmentPrintId($select){
         $db = Zend_Db_Table::getDefaultAdapter();
       // $select="select * from doc_print_allocation where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
//        $entries = array();
//        foreach ($rows as $row){
//            $entry = new Model_Doc_Print_Allocation();
//            $entry->setId($row->id);
//             $entry->setSerial_Allocation($row->serial_allocation)
////                   ->setMaster_Print_Id($row->master_print_id)  
//               ;
//            $entries[]=$entry;
//        }
        return $rows;
    }
    ///
     ////mmmm///
     public function fetchAllExport_Department($select){
         $db = Zend_Db_Table::getDefaultAdapter();
       // $select="select * from doc_print_allocation where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Allocation();
             $entry->setMaster_Print_Id($row->master_print_id)
                   ->setSys_Department_Id($row->sys_department_id)
               ;
            $entries[]=$entry;
        }
        return $entries;
    }
    //////////
    public function fetchAllCount($t2,$t3,$t4){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="SELECT count(t.id) as tong FROM doc_print_allocation as t  where  t.sys_department_id='$t2' and t.date_allocation='$t3' and master_print_id = '$t4' and is_delete ='0';";        
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->tong; 
    }
    public function fetchAllMin($t2,$t3,$t4){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="SELECT min(t.serial_allocation) as tong FROM doc_print_allocation as t  where  t.sys_department_id='$t2' and t.date_allocation='$t3' and t.master_print_id = '$t4' and is_delete='0';";        
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->tong; 
    }
     public function fetchAllCountPublic($where){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="SELECT count(t.id) as tong FROM doc_print_allocation as t  where  "."$where";        
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->tong; 
    }
    public function fetchAllSerialMinPublic($where){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="SELECT min(t.serial_allocation) as tong FROM doc_print_allocation as t  where  "."$where";        
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->tong; 
    }
    public function fetchAllSerialMaxPublic($where){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select max(serial_allocation) as serial from doc_print_allocation where "."$where";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->serial;  
    }
    //Cho ra day Serial Chua cap phat///
    public function fetchAllCount1($macapphat){
         $db = Zend_Db_Table::getDefaultAdapter();
//        $select="SELECT count(t.id) as tong FROM doc_print_allocation as t  where t.doc_print_create_id='$t1' and t.sys_department_id='$t2' and t.date_allocation='$t3' and is_delete ='0';";        
        $select="select count(t.id) as tong from doc_print_allocation as t where t.serial_recovery='0' and t.master_print_id ='$macapphat' and t.is_delete = '0' and t.id not in (select t1.doc_print_allocation_id from doc_print_handling as t1 where t1.is_delete='0')";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->tong; 
    }
    public function fetchAllMin1($macapphat){
         $db = Zend_Db_Table::getDefaultAdapter();
//        $select="SELECT min(t.serial_allocation) as tong FROM doc_print_allocation as t  where t.doc_print_create_id='$t1' and t.sys_department_id='$t2' and t.date_allocation='$t3' and is_delete='0';";        
        $select="select min(t.serial_allocation) as tong from doc_print_allocation as t where t.serial_recovery='0' and t.master_print_id ='$macapphat' and t.is_delete = '0' and t.id not in (select t1.doc_print_allocation_id from doc_print_handling as t1 where t1.is_delete='0')";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->tong; 
    }
    /////
    //tìm serial chua cấp phát
     public function findidbyserialrecovery($valueMasterPrintId,$valueserial_allocation){        
       $db = Zend_Db_Table::getDefaultAdapter();
         $select="select id from doc_print_allocation where serial_allocation='$valueserial_allocation' and master_print_id ='$valueMasterPrintId' and  is_delete = '0' and id not in (select doc_print_allocation_id from doc_print_handling where is_delete='0')";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    

    //
    
    
}
