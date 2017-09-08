<?php
include APPLICATION_PATH."/models/base/Doc_Print_CreateBase.php";

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Print_Create extends Model_Doc_Print_CreateBase{
    
}
class Model_Doc_Print_CreateMapper extends Model_Doc_Print_CreateMapperBase{
    public function deleteDoc_Print_Create($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_create SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function updatesorderDoc_Print_Create(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_create SET `order`='0' " ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    //lay ra so luong,serial theo quyen
   public function updatestatusDoc_Print_Create($id,$stringValueStatus){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_create SET status='$stringValueStatus'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function updateserialrecoveryDoc_Print_Create($id,$stringValueStatus){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_create SET serial_recovery='$stringValueStatus'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function updatesserialrecoveryDoc_Print_Create($id,$stringValueStatus){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_print_create SET serial_recovery='$stringValueStatus'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public function serialwithquyensomasterprintid($master_print_id,$coefficient){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial from doc_print_create where master_print_id='$master_print_id' and coefficient ='$coefficient' and is_delete='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($rows==NULL){
            return null;
        }
        return $rows[0]->serial;  
    }
    //
    public function checkserialpayment($anchi,$quyen,$serial_recovery,$serial_fail){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial from doc_print_create where master_print_id='$anchi' and coefficient ='$quyen' and is_delete='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
         if($rows==NULL){
            $seriall= null;
        }
        $seriall = $rows[0]->serial; 
        $arrayserial = explode("-", $seriall);
        $arr_serial = array();$j=0;
        $arr_error = array();$err=0;
        $flag=0;$co=0;  
        for($i=(int)$arrayserial[0];$i<=$arrayserial[1];$i++){
            $arr_serial[$j++]=$i;
        }
        //mang serial recovery
        $arr_recovery = array();$m=0;
        $array_recovery = explode(",", $serial_recovery);
        if(count($array_recovery)==1){
            $array_recovery1 = explode("-", $array_recovery[0]);
            if(count($array_recovery1)==1){
               $arr_recovery[$m++]=(int)$array_recovery1[0];
            }  else {
               if((int)$array_recovery1[0]>=(int)$array_recovery1[1]){
                   $flag = 1;
                   $arr_error[$err++]="sx:".$array_recovery1[0];
               }  else {
                   for($ii =(int) $array_recovery1[0];$ii<=(int)$array_recovery1[1];$ii++){
                        $arr_recovery[$m++]=$ii; 
                   } 
               } 
            }
        }  else {
            foreach ($array_recovery as $value) {
                $array_recovery2 = explode("-", $value);
                if(count($array_recovery2)==1){
                    $arr_recovery[$m++]=(int)$array_recovery2[0];
                }  else {
                    if((int)$array_recovery2[0]>=(int)$array_recovery2[1]){
                        $flag = 1;
                        $arr_error[$err++]="sx:".$array_recovery2[0];
                    }  else {
                        for($kk = (int)$array_recovery2[0];$kk<=(int)$array_recovery2[1];$kk++){
                            $arr_recovery[$m++]=$kk;
                        }
                    }
                }
            }
        }
        //        
        $arr_fail = array();$n=0;
        $array_fail = explode(",", $serial_fail);
        if(count($array_fail)==1){
            $array_fail1 = explode("-", $array_fail[0]);
            if(count($array_fail1)==1){
               $arr_fail[$n++]=(int)$array_fail1[0];
            }  else {
                if((int)$array_fail1[0]>=(int)$array_fail1[1]){
                        $flag = 1;
                        $arr_error[$err++]="sx:".$array_fail1[0];
                }  else {
                        for($ii = (int)$array_fail1[0];$ii<=(int)$array_fail1[1];$ii++){
                           $arr_fail[$n++]=$ii; 
                        }
                } 
            }
        }  else {
            foreach ($array_fail as $value) {
                $array_fail2 = explode("-", $value);
                if(count($array_fail2)==1){
                    $arr_fail[$n++]=(int)$array_fail2[0];
                }  else {
                        if((int)$array_fail2[0]>=(int)$array_fail2[1]){
                           $flag = 1;
                           $arr_error[$err++]="sx:".$array_fail2[0];
                        }  else {
                            for($kk = (int)$array_fail2[0];$kk<=(int)$array_fail2[1];$kk++){
                                $arr_fail[$n++]=$kk;
                            }
                        }
               }
            }
        }
        //kiem tra mang tang dan trong serial_recovery va serial fail
        if($flag==0){
            for($t = 1; $t<count($arr_recovery);$t++){
                if($arr_recovery[$t]<= $arr_recovery[$t-1]){
                    $flag = 1;$arr_error[$err++]="sx:".$arr_recovery[$t];
                    break;
                }
            }
        }
        if($flag == 0){
            for($t = 1; $t<count($arr_fail);$t++){
                if($arr_fail[$t]<= $arr_fail[$t-1]){
                    $flag = 1;$arr_error[$err++]="sx:".$arr_fail[$t];
                    break;
                }
            }
        }
        //kiem tra hai mang serial thu hoi va serial hong co trong serial nhap vao khong
        if($flag == 0){
            for($l1 = 0;$l1<count($arr_fail);$l1++){
                for($l2 = 0;$l2<count($arr_recovery);$l2++){
                    if($arr_fail[$l1]==$arr_recovery[$l2]){
                        $flag = 1;$arr_error[$err++]="trung:".$arr_fail[$l1];
                        $co = 1;break;
                    }
                }
            }
        }  
        
        $dem = 0;
        if($co == 0){
            for($h = 0;$h<count($arr_recovery);$h++){
                $dem =0;
                for($h1 = 0;$h1<count($arr_serial);$h1++){
                    if($arr_recovery[$h]==$arr_serial[$h1]){
                        $dem = 1;
                    }
                }
                if($dem == 0){
                    $flag = 1;
                    $arr_error[$err++]="khong:".$arr_recovery[$h];break;
                }
            }
            for($h = 0;$h<count($arr_fail);$h++){
                $dem =0;
                for($h1 = 0;$h1<count($arr_serial);$h1++){
                    if($arr_fail[$h]==$arr_serial[$h1]){
                        $dem = 1;
                    }
                }
                if($dem == 0){
                    $flag = 1;$arr_error[$err++]="khong:".$arr_fail[$h];break;
                }
            }
        }
         $menber[]=array(
                     'flag'=>$flag,
                     'error'=> $arr_error,
               );
        echo json_encode($menber);
        exit();
    }
    //serial lon nhat trong ky
     public function serialmaxprintid($master_print_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial from doc_print_create where master_print_id='$master_print_id' and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();$i=0;
        foreach ($rows as $row){
          $serial = $row->serial;
          $array = explode('-', $serial);
          $entries[$i++] = $array[0];
          $entries[$i++] = $array[1];
        }
        $max = $entries[0];
        for($j=1;$j<count($entries);$j++){
            if($entries[$j]>$max){
                $tam = $max;
                $max = $entries[$j];
                $entries[$j] = $tam;
            }
        }
        return $max;
    }
    //serial lon nhat trong ky
    
    public function checkserialinserial($serial,$serialinput){
        $arrayserial = explode("-", $serial);
        $array_serial_xoahuhong = array();
        $i = 0;
        //lay serial trong chuoi hu hong
        $array_1 = explode(",", $valueSerialFail);
        if(count($array_1)==1){
            $array_2 = explode("-", $array_1[0]);
            if(count($array_2)==1){
                $array_serial_xoahuhong[$i++]=$array_2[0];
            }  else {
                for($j=$array_2[0];$j<$array_2[1];$j++){
                    $array_serial_xoahuhong[$i++]=$j;
                }
            }
        }  else {
            foreach ($array_1 as $value) {
                $array_3 = explode("-", $value);
                if(count($array_3)==1){
                    $array_serial_xoahuhong[$i++]=$array_3[0];
                }  else {
                    for($k=$array_3[0];$k<$array_3[1];$k++){
                        $array_serial_xoahuhong[$i++]=$k;
                    }
                }
            }
            
        }
        $flag=0;
        //
        for($n =0;$n< count($array_serial_xoahuhong);$n++){
            for($l=$arrayserial[0];$l<=$arrayserial[1];$l++){
                if(($array_serial_xoahuhong[$n]!=$arrayserial)&&($l == $arrayserial[1])){
                    $flag =1;break;
                }
            }
        }
       
        return $flag ;
        
        
    }

        //ham selec where
     public function fetchAllSelect($select){
         $db = Zend_Db_Table::getDefaultAdapter();
//        $select="select * from doc_print_create where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setId($row->id)
                 ->setId($row->id) 
                ->setMaster_Print_Id($row->master_print_id)
                ->setInvoice_Number($row->invoice_number)    
                ->setCoefficient($row->coefficient)
                ->setSerial($row->serial)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by) 
                ->setComment($row->comment)
                ->setSerial_Recovery($row->serial_recovery)    
                ->setIs_Delete($row->is_delete);
                
            $entries[]=$entry;
        }
        return $entries;
    }
    //ham trả về id_doc_print_create lấy ra quyển số lớn nhất (đã được tạo) tại thời điểm bất kỳ    
    public function maxcoefficient($colums,$valueColums){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id  from doc_print_create where ".$colums."='".$valueColums."' and is_delete='0' and coefficient in (select max(coefficient) as coefficient from doc_print_create where ".$colums."='".$valueColums."')";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    //ham tra ve id_doc_print_create theo cot va gia tri cua cot truyen vao
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from doc_print_create where ".$colums."='".$valueColums."' and is_delete='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
     public function findidbyserialrecovery($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select serial_recovery from doc_print_create where ".$colums."='".$valueColums."' and is_delete='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->serial_recovery;  
    }
     public function findidbyserialserial($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select serial from doc_print_create where ".$colums."='".$valueColums."' and is_delete='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->serial;  
    }
    //ham lay ra mang coefficient theo ma an chi
    public function arraycoefficient($master_print_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_print_create where master_print_id='$master_print_id' and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setCoefficient($row->coefficient);
            $entries[]=$entry;
        }
        return $entries;
    }
    //danh sach an chi theo ngay gio cho lan nhap sau cung
    public function arraymasterprint(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select DISTINCT master_print_id from doc_print_create where created_date in (select max(created_date)as created_date from doc_print_create ) and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setMaster_Print_Id($row->master_print_id);
            $entries[]=$entry;
        }
        return $entries;
    }
//tra ve mang serial theo ngay moi nhap va theo an chi(lan nhap sau cung)
     public function arrayserialmasterprintdate($master_print_id){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select  serial from doc_print_create where created_date in (select max(created_date)as created_date from doc_print_create ) and master_print_id='$master_print_id' and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setSerial($row->serial);
            $entries[]=$entry;
        }
        return $entries;
    }
 //tra ve day so quyen theo an chi theo ngay moi nhap\
       public function arraycoefficientmasterprintdate($master_print_id){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select  coefficient from doc_print_create where created_date in (select max(created_date)as created_date from doc_print_create ) and master_print_id='$master_print_id' and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setCoefficient($row->coefficient);
            $entries[]=$entry;
        }
        return $entries;
    } 
    //danh sach an chi theo ma an chi (sun dung cho lan nhap sau cung)
 public function fetchprintserialdate($master_print_id){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select  * from doc_print_create where created_date in (select max(created_date)as created_date from doc_print_create ) and master_print_id='$master_print_id' and is_delete ='0' limit 1";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setId($row->id)
                 ->setId($row->id) 
                ->setMaster_Print_Id($row->master_print_id)
                ->setInvoice_Number($row->invoice_number)    
                ->setCoefficient($row->coefficient)
                ->setSerial($row->serial)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by) 
                ->setComment($row->comment)
                ->setIs_Delete($row->is_delete);
            $entries[]=$entry;
        }
        return $entries;
    }
///SU DUNG CHO LIST DOC_PRINT_CREATE
    //danh sach ngay duy nhat co trong bang doc_print_create
    public function array_allcreateddate(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select DISTINCT created_date,invoice_number from doc_print_create where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setCreated_Date($row->created_date);
            $entries[]=$entry;
        }
        return $entries;
    }
    //danh sach ấn chỉ duy nhat co trong bang doc_print_create
    public function array_allmasterprintid(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select DISTINCT master_print_id from doc_print_create where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setMaster_Print_Id($row->master_print_id);
            $entries[]=$entry;
        }
        return $entries;
    }
   
     public function masterprint_invoice_number_date($invoice_number,$date){
        $db= Zend_Db_Table::getDefaultAdapter();
        $select ="select DISTINCT master_print_id from doc_print_create where created_date ='$date' and invoice_number='$invoice_number' and `order` ='1' and is_delete='0'";
        $stmt = $db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setMaster_Print_Id($row->master_print_id);
            $entries[]=$entry;
        }
        return $entries;
    }
     public function masterprint_invoice_number_date1($invoice_number,$date){
        $db= Zend_Db_Table::getDefaultAdapter();
        $select ="select DISTINCT master_print_id from doc_print_create where created_date ='$date' and invoice_number='$invoice_number'  and is_delete='0'";
        $stmt = $db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setMaster_Print_Id($row->master_print_id);
            $entries[]=$entry;
        }
        return $entries;
    }
    //danh sach serial theo ngay,theo an chi co trong bang doc_print_create
    public function array_allserial1($date,$master_print_id,$invoice_number){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial,serial_recovery from doc_print_create where created_date ='$date' and invoice_number='$invoice_number' and master_print_id='$master_print_id' and  is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setSerial($row->serial);
            $entry->setSerial_Recovery($row->serial_recovery);
            $entries[]=$entry;
        }
        return $entries;
    }
    public function array_allserial($date,$master_print_id,$invoice_number){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select serial,serial_recovery from doc_print_create where created_date ='$date' and invoice_number='$invoice_number' and master_print_id='$master_print_id' and `order`='1' and is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setSerial($row->serial);
            $entry->setSerial_Recovery($row->serial_recovery);
            $entries[]=$entry;
        }
        return $entries;
    }
    //danh sách so quyen theo an chi theo ngay co trong bang doc_print_create
    public function array_allcoefficient($date,$master_print_id,$invoice_number){
        $db = Zend_Db_Table::getDefaultAdapter();
        if($master_print_id!=""){
        $select="select coefficient from doc_print_create where created_date ='$date'  and master_print_id='$master_print_id' and invoice_number='$invoice_number' and `order` ='1' and is_delete ='0'";}
        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setCoefficient($row->coefficient);
            $entries[]=$entry;
        }
        return $entries;
    }
     public function array_allcoefficient1($date,$master_print_id,$invoice_number){
        $db = Zend_Db_Table::getDefaultAdapter();
        if($master_print_id!=""){
        $select="select coefficient from doc_print_create where created_date ='$date'  and master_print_id='$master_print_id' and invoice_number='$invoice_number'  and is_delete ='0'";}
        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setCoefficient($row->coefficient);
            $entries[]=$entry;
        }
        return $entries;
    }
//danh sach duy nhat theo ngay, theo so hoa don, theo ma an chi
    public function fetchdateprintinvoicenumber($master_print_id,$date,$invoice_number){
        $db = Zend_Db_Table::getDefaultAdapter();       
        $select="select DISTINCT master_print_id,created_date,invoice_number from doc_print_create where master_print_id='$master_print_id' and created_date='$date' and invoice_number='$invoice_number' and is_delete ='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setMaster_Print_Id($row->master_print_id);
            $entry->setCreated_Date($row->created_date);
            $entry->setInvoice_Number($row->invoice_number);
            $entries[]=$entry;
        }
        return $entries;
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







    //ham tra ve serial da dc tao lon nhat trong lan cap phat cuoi cung theo dieu kien ma an chi
    public function serialmaxcreate($valueColums){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select serial from doc_print_create where master_print_id='".$valueColums."'and id in(select max(id)as id from doc_print_create where master_print_id='$valueColums' ) and created_date in(select max(created_date)as created_date from doc_print_create where master_print_id='$valueColums')";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $string_serial="";
        foreach ($rows as $row){
           $string_serial = $row->serial;
        }
        $serial_max=0;
        $array = explode(",", $string_serial);
        if(count($array)==1){
            $array1 = explode("-",$array[0]);
            if(count($array1)==1){
                $serial_max = (int)$array1[0];
            }  else {
                $serial_max = (int)$array1[1];
            }
        }  else {
            foreach ($array as $value) {
                $array2 = explode("-", $value);
                if(count($array2)==1){
                    $serial_max = (int)$array2[0];
                }else{
                    $serial_max =(int)$array2[1];
                }
            }
        }
        return $serial_max;
    }
    //ham lay ra chuoi serial chua dc cap phat ma da dc tao
    
    //ham tra ve id neu gia tri nhap vao thuoc doan la day seria co trong bang doc_print_create
    public function findidbyserial($colums,$valueColums,$number){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id,serial from doc_print_create where ".$colums."='".$valueColums."'and is_delete='0'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $values=''; $arrayserial = array();$i=0;
        foreach ($rows as $value) {
            $string_serial = $value->serial;
            $string_id = $value->id;
            $array_serial = explode(",", $string_serial);
            if(count($array_serial)==1){
                $array = explode("-", $array_serial[0]);
                if(count($array)==1){
                    $arrayserial[$i++] =$string_id.':'.(int) $array[0];
                }  else {
                    for($h =(int) $array[0];$h<= (int)$array[1];$h++){
                        $arrayserial[$i++] =$string_id.':'. $h;
                    }
                }
            }  else {
                foreach ($array_serial as $value) {
                    $array_1 = explode("-", $value);
                    if(count($array_1)==1){
                        $arrayserial[$i++]=$string_id.':'.(int) $array_1[0];
                    }  else {
                        for($k =(int) $array_1[0];$k<=(int)$array_1[1];$k++){
                            $arrayserial[$i++]=$string_id.':'. $k;
                        }
                    }
                }
            }
            //tim so trong mamng
//            $number = (int)$number;
            
        }
        for($j = 0;$j<count($arrayserial);$j++){
            $id_dpr = explode(":", $arrayserial[$j]);
                if((int)$id_dpr[1] == $number){
                    $values =(int) $id_dpr[0];break;
                                        
                } 
            }
        //return gia tri 
        if($values==''){
            return 0;
        }
        return $values;  
    }
     //tra ve id theo cot va gia tri can tim
    
    public function maxiddocprintcreate($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select max(id) as id from doc_print_create where ".$colums."='".$valueColums."' and is_delete='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    //Lấy tất cả ấn chỉ nhap xuất trong tháng
     public function getImportExportPrint($month,$year,$print_id){
        
         $db = Zend_Db_Table::getDefaultAdapter();
        //Lay an chi dc cap trong ky
        $select=" select 
                            doc_print_create.id,
                            doc_print_create.master_print_id,
                            doc_print_create.coefficient,
                            doc_print_create.invoice_number,
                            doc_print_create.serial,
                            doc_print_create.created_date,
                            doc_print_allocation.id as id_allocation 
                from doc_print_allocation inner join doc_print_create 
                        ON doc_print_create.id =doc_print_allocation.doc_print_create_id 
                         and doc_print_create.master_print_id = $print_id
                where month(doc_print_allocation.created_date) = $month and year(doc_print_allocation.created_date) = $year";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $arrayEntries = array(); 
          foreach ($rows as $row){
                $arrayEntries[$row->id]['status'] = "Export";
                $arrayEntries[$row->id]["serial_recovery"] = "";
                    $arrayEntries[$row->id]["serial_fail"] = "";
                    $arrayEntries[$row->id]["reasons_fail"] = "";

                //Lay an chi da thanh toan để lấy ấn chi thu hoi
                $select1=" select * from doc_print_payment where doc_print_payment.doc_print_allocation_id = $row->id_allocation";        
                $stmt1=$db->query($select1);
                $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
                $stmt1->closeCursor();
                foreach ($rows1 as $row1){
                    $arrayEntries[$row->id]["serial_recovery"] = $row1->serial_recovery;
                    $arrayEntries[$row->id]["serial_fail"] = $row1->serial_fail;
                    $arrayEntries[$row->id]["reasons_fail"] = $row1->reasons_fail;
                }
          }
          
         //Nhap trong ky
        $select2="select * from doc_print_create where month(created_date) = $month and year(created_date)=$year and master_print_id = $print_id";        
        $stmt2=$db->query($select2);
        $rows2 = $stmt2->fetchAll(PDO::FETCH_CLASS);
        $stmt2->closeCursor();
       
        foreach ($rows2 as $row){
            if(!array_key_exists($row->id,$arrayEntries))
            {
                  $arrayEntries[$row->id]['status'] = "Import";
            }
            else
            {
                $arrayEntries[$row->id]['status'] = "Import And Export";
            }
            $arrayEntries[$row->id]['invoice_number'] = $row->invoice_number;
             $arrayEntries[$row->id]['created_date'] = $row->created_date;
             $arrayEntries[$row->id]['coefficient'] = $row->coefficient;
              $arrayEntries[$row->id]['serial'] = $row->serial;
            
        }
        
        //Tồn đầu kỳ
        $select3="select * from doc_print_create where 
                    month(created_date) < $month and year(created_date)<=$year and master_print_id = $print_id
                    and (status = '' || status='RECOVERY')";        
        $stmt3=$db->query($select3);
        $rows3 = $stmt3->fetchAll(PDO::FETCH_CLASS);
        $stmt3->closeCursor();
       
        foreach ($rows3 as $row){
            $arrayEntries[$row->id]['status'] = "TonDauKy";
            $arrayEntries[$row->id]['invoice_number'] = $row->invoice_number;
            $arrayEntries[$row->id]['created_date'] = $row->created_date;
            $arrayEntries[$row->id]['coefficient'] = $row->coefficient;
            $arrayEntries[$row->id]['serial'] = $row->serial;
            $arrayEntries[$row->id]['serial_recovery'] = $row->serial_recovery;
           
        }
        return $arrayEntries;
    }
      public function getUsePrint($from,$to){
        
         $db = Zend_Db_Table::getDefaultAdapter();
        //Lay an chi 
         $select=" select * from master_print";   
        //$select="select * from doc_print_create where created_date BETWEEN '$from' AND '$to'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $arrayEntries = array(); 
          foreach ($rows as $row){
                //Get name
                $arrayEntries[$row->id]["Code"] = $row->code;
                $arrayEntries[$row->id]["Name"] = $row->name;
                //get ton dau ky
                $select3="select * from doc_print_create where 
                                   created_date < $from and master_print_id = $row->id
                                    and (status = '' || status='RECOVERY')";        
                $stmt3=$db->query($select3);
                $rows3 = $stmt3->fetchAll(PDO::FETCH_CLASS);
                $stmt3->closeCursor();
                $strSerialTonDauKy = "";
                foreach ($rows3 as $row3){
                        if(empty($row3->serial_recovery))  
                        {
                            $strSerialTonDauKy = $strSerialTonDauKy.",".$row3->serial;
                        }
                        else
                        {
                            $strSerialTonDauKy = $strSerialTonDauKy.",".$row3->serial_recovery;
                        
                        }
                }
                if(!empty($strSerialTonDauKy))
                {
                    $strSerialTonDauKy = substr($strSerialTonDauKy,1);
                }
                $max = GlobalLib::serialMax($strSerialTonDauKy);
                $min = GlobalLib::serialMin($strSerialTonDauKy);
                $arrayEntries[$row->id]["TDK_TuSo"] = $min;
                $arrayEntries[$row->id]["TDK_Denso"] = $max;
                $arrayEntries[$row->id]["TDK_Tong"] = GlobalLib::subtractMaxMin($max,$min);
                
                 //get print trong ky
                $select1="select * from doc_print_create where master_print_id = $row->id AND (created_date BETWEEN '$from' AND '$to')";        
                $stmt1=$db->query($select1);
                $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
                $stmt1->closeCursor();
                $strSerialTrongKy = "";
                $strSerialSuDung = "";
                $strSerialXoabo = "";
                $strSerialHuy = "";
                $strSerialHet = "";
                $strSerialTonCuoiKy = "";
                foreach ($rows1 as $row1){
                    $strSerialTrongKy = $strSerialTrongKy.",".$row1->serial;
                    if($row1->status == "DONE" || $row1->status == "RECOVERY")
                    {
                        $strSerialSuDung =  $strSerialSuDung.",".$row1->serial;
                        if($row1->status == "DONE")
                        {
                            $strSerialHet = $strSerialHet.",".$row1->serial;
                        }
                        else
                        {
                            $strSerialTonCuoiKy= $strSerialTonCuoiKy.",".$row1->serial_recovery;
                        }
                        $select2="select * from doc_print_payment inner join doc_print_allocation on doc_print_allocation.id = doc_print_payment.doc_print_allocation_id
                                                where doc_print_allocation.doc_print_create_id = $row1->id";        
                        $stmt2=$db->query($select2);
                        $rows2 = $stmt2->fetchAll(PDO::FETCH_CLASS);
                        $stmt2->closeCursor();
                        foreach ($rows2 as $row2){
                            if(empty($row2->serial_fail))
                                continue;
                             if(strpos($row2->reasons_fail,'Xóa')!== false
                                || strpos($row2->reasons_fail,'Xoa')!== false
                                || strpos($row2->reasons_fail,'XÓA')!== false)
                             {
                                 $strSerialXoabo = $strSerialXoabo.",".$row2->serial_fail;
                             }
//                             if(strpos($row2->reasons_fail,'Hủy')!== false
//                                || strpos($row2->reasons_fail,'Huy')!== false
//                                || strpos($row2->reasons_fail,'HUY')!== false)
                             else
                             {
                                 $strSerialHuy = $strSerialHuy.",".$row2->serial_fail;
                             }
                         }
                    }
                }
             
                if(!empty($strSerialTrongKy))
                {
                    $strSerialTrongKy = substr($strSerialTrongKy,1);
                }
                if(!empty($strSerialSuDung))
                {
                    $strSerialSuDung = substr($strSerialSuDung,1);
                }
                 if(!empty($strSerialXoabo))
                {
                    $strSerialXoabo = substr($strSerialXoabo,1);
                }
                if(!empty($strSerialHuy))
                {
                    $strSerialHuy = substr($strSerialHuy,1);
                }
                if(!empty($strSerialHet))
                {
                    $strSerialHet = substr($strSerialHet,1);
                }
                if(!empty($strSerialTonCuoiKy))
                {
                    $strSerialTonCuoiKy = substr($strSerialTonCuoiKy,1);
                }
                
                   
                $max = GlobalLib::serialMax($strSerialTrongKy);
                $min = GlobalLib::serialMin($strSerialTrongKy);
                $arrayEntries[$row->id]["TrongKy_TuSo"] = $min;
                $arrayEntries[$row->id]["TrongKy_DenSo"] = $max;
                $arrayEntries[$row->id]["TrongKy_TongSo"] = GlobalLib::subtractMaxMin($max,$min);;
                
                $max = GlobalLib::serialMax($strSerialSuDung);
                $min = GlobalLib::serialMin($strSerialSuDung);
                $arrayEntries[$row->id]["SuDung_TuSo"] = $min;
                $arrayEntries[$row->id]["SuDung_DenSo"] = $max;
                $arrayEntries[$row->id]["SuDung_Tong"] = GlobalLib::subtractMaxMin($max,$min);
               
                $max = GlobalLib::serialMax($strSerialXoabo);
                $min = GlobalLib::serialMin($strSerialXoabo);
                $arrayEntries[$row->id]["XoaBo_So"] = $strSerialXoabo;
                
                $arrayEntries[$row->id]["XoaBo_SoLuong"] = GlobalLib::subtractMaxMin($max,$min);
                
                 $max = GlobalLib::serialMax($strSerialHuy);
                $min = GlobalLib::serialMin($strSerialHuy);
                $arrayEntries[$row->id]["Huy_So"] = $strSerialHuy;
                $arrayEntries[$row->id]["Huy_SoLuong"] = GlobalLib::subtractMaxMin($max,$min);
                
                 $max = GlobalLib::serialMax($strSerialHet);
                $min = GlobalLib::serialMin($strSerialHet);
                $arrayEntries[$row->id]["Het_So"] = $strSerialHet;
                $arrayEntries[$row->id]["Het_SoLuong"] = GlobalLib::subtractMaxMin($max,$min);
                
                $max = GlobalLib::serialMax($strSerialTonCuoiKy);
                $min = GlobalLib::serialMin($strSerialTonCuoiKy);
                $arrayEntries[$row->id]["TCK_TuSo"] = $min;
                 $arrayEntries[$row->id]["TCK_DenSo"] = $max;
                $arrayEntries[$row->id]["Het_SoLuong"] = GlobalLib::subtractMaxMin($max,$min);             
          }
          
       
        return $arrayEntries;
    }
    public function getSerial($id_doc_print_alloaction){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_print_allocation where id='$id_doc_print_alloaction'";  
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($rows==NULL){
            return null;
        }
        return $rows[0]->serial_recovery1;   
    }
    //ham lay ra serial dang su dung doi voi nhung cuoc co trang thai la thu hoi(RECOVERY)
    public function getSerialUsed($id_doc_print_alloaction){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_print_payment where doc_print_allocation_id='$id_doc_print_alloaction'";  
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $strSerialUsed="";
        foreach ($rows as $row){
           $serial= Model_Doc_Print_CreateMapper::getSerial($row->doc_print_allocation_id);
           $serialRecovery = $row->serial_recovery;
           $serialFail = $row->serial_fail;
           $strSerialUsed= GlobalLib::SerialUsedd($serial,$serialRecovery,$serialFail);
        }
        return $strSerialUsed;
          
    }
     public function getIdWithDeparment($sys_department_id,$master_print_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        if($sys_department_id == 16){
            $select="select * from doc_print_allocation where  master_print_id='$master_print_id'";  
        }else{
            $select="select * from doc_print_allocation where sys_department_id='$sys_department_id' and master_print_id='$master_print_id'";  
        }
        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $arrayId = array();$i=0;
         foreach ($rows as $row){
            $arrayId[$i++]= $row->id;
         } 
         return $arrayId;
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from doc_print_create where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Print_Create();
            $entry->setId($row->id)
                 ->setId($row->id) 
                ->setMaster_Print_Id($row->master_print_id)
                ->setInvoice_Number($row->invoice_number)    
                ->setCoefficient($row->coefficient)
                ->setSerial($row->serial)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by) 
                ->setComment($row->comment)
                ->setStatus($row->status)
                ->setSerial_Recovery($row->serial_recovery)     
                ->setIs_Delete($row->is_delete);
                
            $entries[]=$entry;
        }
        return $entries;
    }
   
    //
    public function getUsePrintBySysdepartment($from,$to,$sys_department_id){
        
         $db = Zend_Db_Table::getDefaultAdapter();
         //lay ra nam thang cua tu ngay
        $arrayEntries = array();
        $i=0;
        //Lay an chi 
        if($sys_department_id == 16){
             $select="select * from master_print as t1 where is_delete='0' and t1.id in(select distinct t2.master_print_id from doc_print_allocation as t2 where  t2.is_delete='0') ";  
        }else{
            $select="select * from master_print as t1 where is_delete='0' and t1.id in(select distinct t2.master_print_id from doc_print_allocation as t2 where t2.sys_department_id='$sys_department_id' and t2.is_delete='0') ";  
        }
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        //
          foreach ($rows as $row){
            $arraySerialFail = array();
            $arrayserialDaSuDung = array();$daSuDung=0;
            $arraySerialCheckDaSuDung = array();$ii=0;
            $arraySerialHandlingDaSuDung= array();$iii=0;
            $arrayserialDaSuDungxp = array();
            $arrayTonCuoiKy = array();
            $strSerialSuDung ="";$strSerialXoabo="";
            $k=0;$arrayserial= array();
            $arraySerialCheck = array();$ii=0;
            $arraySerialHandling = array();$iii=0;
            $arraySerialInPeriod = array();$trongKy=0;
            $arrayTonCuoiKy = array();
            $arraySerialFaill = array();
                //Get name
                $arrayEntries[$row->id]["Code"] = $row->code;
                $arrayEntries[$row->id]["Name"] = $row->name;
                $arrayIdDocPrintAllocation= Model_Doc_Print_CreateMapper::getIdWithDeparment($sys_department_id,$row->id);
                $stringIdDocPrintAllocation = implode(',', $arrayIdDocPrintAllocation);
                //lay ra serial dc cap phat trong ky truoc. TON DAU KY
                 if($sys_department_id == 16){
                $select1="select id,master_print_id,sys_department_id,serial_recovery1,date_allocation,is_delete from doc_print_allocation where date_allocation < '$from' and master_print_id='$row->id' and  is_delete ='0'"; 
                 }else{ $select1="select id,master_print_id,sys_department_id,serial_recovery1,date_allocation,is_delete from doc_print_allocation where date_allocation < '$from' and master_print_id='$row->id' and sys_department_id='$sys_department_id' and is_delete ='0'";}  
                $stmt1=$db->query($select1);
                $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
                $stmt1->closeCursor();
                foreach ($rows1 as $row1){
                    $serialtam = $row1->serial_recovery1;
                    $arraytam = explode("-", $serialtam);
                    for($j = (int)$arraytam[0];$j<= (int)$arraytam[1];$j++){
                        $arrayserial[$k++]=$j;
                    }
                }
                if($sys_department_id == 16){
                $select11="select serial_check from info_schedule_check where doc_print_allocation_id in ($stringIdDocPrintAllocation) and  date_check < '$from' and is_delete ='0'";
                }else{$select11="select serial_check from info_schedule_check where doc_print_allocation_id in ($stringIdDocPrintAllocation) and sys_department_id ='$sys_department_id' and  date_check < '$from' and is_delete ='0'";}
                $stmt11=$db->query($select11);
                $rows11 = $stmt11->fetchAll(PDO::FETCH_CLASS);
                $stmt11->closeCursor();
                foreach ($rows11 as $row11){
                    $arraySerialCheck[$ii++]=$row11->serial_check;
                }
                 $select111="select t.serial_handing as serial_handing,t.doc_violations_handling_id,t.doc_print_allocation_id from doc_print_handling as t where t.doc_violations_handling_id in (select t1.id from doc_violations_handling as t1 where t1.date_violation < '$from') and  doc_print_allocation_id in ($stringIdDocPrintAllocation) and is_delete ='0'";
                $stmt111=$db->query($select111);
                $rows111 = $stmt111->fetchAll(PDO::FETCH_CLASS);
                $stmt111->closeCursor();
                foreach ($rows111 as $row111){
                    $arraySerialHandling[$iii++]=$row111->serial_handing;
                }
                if($sys_department_id == 16){
                $select1111="select * from doc_print_payment where date_payment < '$from' and  doc_print_allocation_id in($stringIdDocPrintAllocation) and master_print_id ='$row->id' and is_delete ='0'";  
                }else{$select1111="select * from doc_print_payment where date_payment < '$from' and sys_department_id ='$sys_department_id' and doc_print_allocation_id in($stringIdDocPrintAllocation) and master_print_id ='$row->id' and is_delete ='0'";  }
                $stmt1111=$db->query($select1111);
                $rows1111 = $stmt1111->fetchAll(PDO::FETCH_CLASS);
                $stmt1111->closeCursor();
                foreach ($rows1111 as $row1111){
                   $arraySerialFaill=GlobalLib::mergetwoarrays($arraySerialFaill,GlobalLib::arrayStringSerial($row1111->serial_fail));
                }
                $arrayserialxp1 = GlobalLib::mergetwoarrays($arraySerialCheck,$arraySerialHandling);
                $arrayserialxp = GlobalLib::mergetwoarrays($arrayserialxp1,$arraySerialFaill);
                $arrayserialdc = GlobalLib::arrayserialminus($arrayserial,$arrayserialxp);
                $strSerialTonDauKy = implode('', $arrayserialdc);
                $arrayserialdc = GlobalLib::sapxep($arrayserialdc);
                if(count($arrayserialdc)!=0){
                    $arrayEntries[$row->id]["TDK_TuSo"] = $arrayserialdc[0];
                    $arrayEntries[$row->id]["TDK_Denso"] = $arrayserialdc[count($arrayserialdc)-1];
                    $arrayEntries[$row->id]["TDK_Tong"] = count($arrayserialdc);
                }else{
                    $arrayEntries[$row->id]["TDK_TuSo"] = 0;
                    $arrayEntries[$row->id]["TDK_Denso"] = 0;
                    $arrayEntries[$row->id]["TDK_Tong"] = 0;
                }
                //TRONG KY
                $strSerialTrongKy ="";
                if($sys_department_id == 16){
               $selectTrongKy="select id,master_print_id,sys_department_id,serial_recovery1,date_allocation,is_delete from doc_print_allocation where (date_allocation BETWEEN '$from' AND '$to') and master_print_id='$row->id' and  is_delete ='0'"; 
                }else{$selectTrongKy="select id,master_print_id,sys_department_id,serial_recovery1,date_allocation,is_delete from doc_print_allocation where (date_allocation BETWEEN '$from' AND '$to') and master_print_id='$row->id' and sys_department_id='$sys_department_id' and is_delete ='0'";  }
                $stmtTrongKy=$db->query($selectTrongKy);
                $rowsTrongKy = $stmtTrongKy->fetchAll(PDO::FETCH_CLASS);
                $stmtTrongKy->closeCursor();
                foreach ($rowsTrongKy as $rowTrongKy){
                    $serialtam = $rowTrongKy->serial_recovery1;
                    $arraytam = explode("-", $serialtam);
                    for($j = (int)$arraytam[0];$j<= (int)$arraytam[1];$j++){
                        $arraySerialInPeriod[$trongKy++]=$j;
                    }
                }
                $strSerialTrongKy  = implode('', $arraySerialInPeriod);
                $arraySerialInPeriod = GlobalLib::sapxep($arraySerialInPeriod);
                if(count($arraySerialInPeriod)!=0){
                     $arrayEntries[$row->id]["TrongKy_TuSo"] = $arraySerialInPeriod[0];
                    $arrayEntries[$row->id]["TrongKy_DenSo"] = $arraySerialInPeriod[count($arraySerialInPeriod)-1];
                    $arrayEntries[$row->id]["TrongKy_TongSo"] = count($arraySerialInPeriod);
                }else{
                     $arrayEntries[$row->id]["TrongKy_TuSo"] = 0;
                    $arrayEntries[$row->id]["TrongKy_DenSo"] = 0;
                    $arrayEntries[$row->id]["TrongKy_TongSo"] =0;
                }
                //DA SU DUNG TRONG KY
                if($sys_department_id == 16){
                $selectDaSuDung1="select id,master_print_id,sys_department_id,serial_recovery1,date_allocation,is_delete from doc_print_allocation where (date_allocation BETWEEN '$from' AND '$to') and master_print_id='$row->id' and is_delete ='0'";     
                }else{$selectDaSuDung1="select id,master_print_id,sys_department_id,serial_recovery1,date_allocation,is_delete from doc_print_allocation where (date_allocation BETWEEN '$from' AND '$to') and master_print_id='$row->id' and sys_department_id='$sys_department_id' and is_delete ='0'";        }
                $stmtDaSuDung1=$db->query($selectDaSuDung1);
                $rowsDaSuDung1 = $stmtDaSuDung1->fetchAll(PDO::FETCH_CLASS);
                $stmtDaSuDung1->closeCursor();
                $arrayIdDocPrintAllocation = array();$p=0;
                foreach ($rowsDaSuDung1 as $rowDaSuDung1){
                    $serialtam = $rowDaSuDung1->serial_recovery1;
                    $id_doc_print_allocation =(int) $rowDaSuDung1->id;
                    $arraytam = explode("-", $serialtam);
                    for($j = (int)$arraytam[0];$j<= (int)$arraytam[1];$j++){
                        $arrayserialDaSuDung[$daSuDung++]=$j;
                    }
                }
                if($sys_department_id == 16){
                $selectDaSuDung11="select serial_check from info_schedule_check where doc_print_allocation_id in($stringIdDocPrintAllocation) and   (date_check BETWEEN '$from' AND '$to') and is_delete ='0'";
                }else{$selectDaSuDung11="select serial_check from info_schedule_check where doc_print_allocation_id in($stringIdDocPrintAllocation) and sys_department_id ='$sys_department_id' and  (date_check BETWEEN '$from' AND '$to') and is_delete ='0'";}
                $stmtDaSuDung11=$db->query($selectDaSuDung11);
                $rowsDaSuDung11 = $stmtDaSuDung11->fetchAll(PDO::FETCH_CLASS);
                $stmtDaSuDung11->closeCursor();
                foreach ($rowsDaSuDung11 as $rowDaSuDung11){
                    $arraySerialCheckDaSuDung[$ii++]=(int)$rowDaSuDung11->serial_check;
                } 
                 ///lay ra serial xu phat
                $selectDaSuDung111="select t.serial_handing as serial_handing,t.doc_violations_handling_id,t.doc_print_allocation_id from doc_print_handling as t where t.doc_violations_handling_id in (select t1.id from doc_violations_handling as t1 where (t1.date_violation BETWEEN '$from' AND '$to')) and  doc_print_allocation_id in($stringIdDocPrintAllocation) and is_delete ='0'";
                $stmtDaSuDung111=$db->query($selectDaSuDung111);
                $rowsDaSuDung111 = $stmtDaSuDung111->fetchAll(PDO::FETCH_CLASS);
                $stmtDaSuDung111->closeCursor();
                foreach ($rowsDaSuDung111 as $rowDaSuDung111){
                    $arraySerialHandlingDaSuDung[$iii++]=(int)$rowDaSuDung111->serial_handing;
                }
                //SERIAL XOA BO HU HONG
                if($sys_department_id == 16){
                 $selectXoaBo="select * from doc_print_payment where (date_payment BETWEEN '$from' AND '$to') and doc_print_allocation_id in($stringIdDocPrintAllocation) and master_print_id ='$row->id' and is_delete ='0'"; 
                }else{$selectXoaBo="select * from doc_print_payment where (date_payment BETWEEN '$from' AND '$to') and sys_department_id ='$sys_department_id' and doc_print_allocation_id in($stringIdDocPrintAllocation) and master_print_id ='$row->id' and is_delete ='0'";        }
                $stmtXoaBo=$db->query($selectXoaBo);
                $rowsXoaBo = $stmtXoaBo->fetchAll(PDO::FETCH_CLASS);
                $stmtXoaBo->closeCursor();

                foreach ($rowsXoaBo as $rowXoaBo){
                   $arraySerialFail=GlobalLib::mergetwoarrays($arraySerialFail,GlobalLib::arrayStringSerial($rowXoaBo->serial_fail));
                }
                /*****************************************************************************************************************************/
                $arrayserialDaSuDungxp1 = GlobalLib::mergetwoarrays($arraySerialCheckDaSuDung,$arraySerialHandlingDaSuDung);
                $arrayserialDaSuDungxp = GlobalLib::mergetwoarrays($arrayserialDaSuDungxp1,$arraySerialFail);
                $strSerialSuDung  = implode('', $arrayserialDaSuDungxp);
                $arrayserialDaSuDungxp = GlobalLib::sapxep($arrayserialDaSuDungxp);
                if(count($arrayserialDaSuDungxp)!=0){
                    $arrayEntries[$row->id]["SuDung_TuSo"] = $arrayserialDaSuDungxp[0];
                    $arrayEntries[$row->id]["SuDung_DenSo"] = $arrayserialDaSuDungxp[count($arrayserialDaSuDungxp)-1];
                    $arrayEntries[$row->id]["SuDung_Tong"] = count($arrayserialDaSuDungxp);
                }else{
                    $arrayEntries[$row->id]["SuDung_TuSo"] = "0";
                    $arrayEntries[$row->id]["SuDung_DenSo"] = "0";
                    $arrayEntries[$row->id]["SuDung_Tong"] = "0";
                }
                $strSerialXoabo = implode(',', $arraySerialFail);
                if(count($arraySerialFail)!=0){
                    $arrayEntries[$row->id]["XoaBo_So"] = $strSerialXoabo;
                    $arrayEntries[$row->id]["XoaBo_SoLuong"] = count($arraySerialFail);
                }else{
                    $arrayEntries[$row->id]["XoaBo_So"] = 0;
                    $arrayEntries[$row->id]["XoaBo_SoLuong"] = 0;
                }
                //TON CUOI KY
                //nhap array ton dau ky va array trong ky lai voi nhau
                $arrayTongTrongKy = GlobalLib::mergetwoarrays($arrayserialdc,$arraySerialInPeriod);
                $arrayEntries[$row->id]["Tong"]=count($arrayTongTrongKy);
                $arrayTonCuoiKy= GlobalLib::arrayserialminus($arrayTongTrongKy,$arrayserialDaSuDungxp);
                $arrayTonCuoiKy = GlobalLib::sapxep($arrayTonCuoiKy);
                //array ton cuoi ky bang array trong ky tru di array da su dung trong ky
                if(count($arrayTonCuoiKy)!=0){
                    $arrayEntries[$row->id]["TCK_TuSo"] = $arrayTonCuoiKy[0];
                    $arrayEntries[$row->id]["TCK_DenSo"] = $arrayTonCuoiKy[count($arrayTonCuoiKy)-1];
                    $arrayEntries[$row->id]["TCK_SoLuong"] = count($arrayTonCuoiKy); 
                }else{
                    $arrayEntries[$row->id]["TCK_TuSo"] = 0;
                    $arrayEntries[$row->id]["TCK_DenSo"] = 0;
                    $arrayEntries[$row->id]["TCK_SoLuong"] = 0;
                }
                $arrayEntries[$row->id]["Huy_So"] = 0;
                $arrayEntries[$row->id]["Huy_SoLuong"] = 0;
                $arrayEntries[$row->id]["Het_So"] = 0;
                $arrayEntries[$row->id]["Het_SoLuong"] = 0;   
          }
        return $arrayEntries;
    }
}
