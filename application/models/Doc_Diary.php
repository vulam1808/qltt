<?php
include APPLICATION_PATH."/models/base/Doc_DiaryBase.php";

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Diary extends Model_Doc_DiaryBase{
    
}
class Model_Doc_DiaryMapper extends Model_Doc_DiaryMapperBase{
    public function deleteDoc_Diary($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE doc_diary SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
     //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from doc_diary where ".$colums."='".$valueColums."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    public function findid($id){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from doc_diary where id='".$id."'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    
    
   public function fetchAll($userID = null){     
         $db = Zend_Db_Table::getDefaultAdapter();
         $select="select * from doc_diary where created_by = '".$userID."' and is_delete ='0'";        
         if($userID===NULL)
            $select="select * from doc_diary where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Diary();
            $entry->setId($row->id)
                  ->setId($row->id)
                ->setDate_Diary($row->date_diary) 
                ->setImplementers($row->implementers)
                ->setPosition($row->position) 
                ->setContent_Inspection($row->content_inspection)
                ->setTime_Check($row->time_check) 
                ->setStatus_And_Test_Results($row->status_and_test_results)
                ->setProcessing_Results($row->processing_results)
                ->setSignature($row->signature) 
                ->setId_Info_Schedule_Check($row->id_info_schedule_check)
                
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
     public function fetchwhereAll($tungay,$denngay,$userID = null){
         $db = Zend_Db_Table::getDefaultAdapter();
         $ngaybatdau = GlobalLib::toMysqlDateString($tungay);
         $ngayketthuc = GlobalLib::toMysqlDateString($denngay);
        $select="select * from doc_diary where created_by = '".$userID."' and is_delete ='0' and date_diary BETWEEN CAST('$ngaybatdau' AS DATE) AND CAST('$ngayketthuc' AS DATE) ";                
         if($userID===NULL) {
             $select = "select * from doc_diary where date_diary BETWEEN CAST('$ngaybatdau' AS DATE) AND CAST('$ngayketthuc' AS DATE) and is_delete ='0'";
         }

        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Doc_Diary();
            $entry->setId($row->id)
                  ->setId($row->id)
                ->setDate_Diary($row->date_diary) 
                ->setImplementers($row->implementers)
                ->setPosition($row->position) 
                ->setContent_Inspection($row->content_inspection)
                ->setTime_Check($row->time_check) 
                ->setStatus_And_Test_Results($row->status_and_test_results)
                ->setProcessing_Results($row->processing_results)
                ->setSignature($row->signature) 
                ->setId_Info_Schedule_Check($row->id_info_schedule_check)
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