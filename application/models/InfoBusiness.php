<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include APPLICATION_PATH."/models/base/InfoBusinessBase.php";
class Model_InfoBusiness extends Model_InfoBusinessBase{
    
}
class Model_InfoBusinessMapper extends Model_InfoBusinessMapperBase{
    public function deleteInfoBusiness($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE info_business SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 

    }

    public function fetchInfoBusinessByID($info_business_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from info_business where id='".$info_business_id."'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_InfoBusiness();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setLicense_Business($row->license_business)
                ->setDate_License($row->date_license)
                ->setDate_Deadline($row->date_deadline)
                ->setPlace_License($row->place_license)
                ->setAddress_Office($row->address_office)
                ->setAddress_Office2($row->address_office2)
                ->setAddress_Branch($row->address_branch)
                ->setAddress_Produce($row->address_produce)
                ->setAddress_Produce1($row->address_produce1)
                ->setAddress_Produce11($row->address_produce11)
                ->setAddress_Produce111($row->address_produce111)
                ->setWork_Business($row->work_business)
                ->setPhone($row->phone)
                ->setBoss_Business($row->boss_business)
                ->setAddress_Permanent($row->address_permanent)
                ->setCellphone($row->cellphone)
                ->setLicense_Condition_Business($row->license_condition_business)
                ->setDate_License_Condition_Business($row->date_license_condition_business)
                ->setMaster_Items_Limit_Id($row->master_items_limit_id)
                ->setMaster_Items_Condition_Id($row->master_items_condition_id)
                ->setMaster_Province_Id($row->master_province_id)
                ->setMaster_District_Id($row->master_district_id)
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setMaster_Business_Type_Id($row->master_business_type_id)
                ->setMaster_Business_Size_Id($row->master_business_size_id)
                ->setDate_Check($row->date_check)
                ->setType_Business($row->type_business)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);
            $entries[]=$entry;
        }
        return $entries;
    }

    public function fetchAll($type_business){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from info_business where type_business='".$type_business."'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_InfoBusiness();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setLicense_Business($row->license_business)
                ->setDate_License($row->date_license)
                ->setDate_Deadline($row->date_deadline)
                ->setPlace_License($row->place_license)
                ->setAddress_Office($row->address_office)
		        ->setAddress_Office2($row->address_office2)
                ->setAddress_Branch($row->address_branch)
                ->setAddress_Produce($row->address_produce)
                ->setAddress_Produce1($row->address_produce1)
                ->setAddress_Produce11($row->address_produce11)
                ->setAddress_Produce111($row->address_produce111)
                ->setWork_Business($row->work_business)
                ->setPhone($row->phone)
                ->setBoss_Business($row->boss_business)
                ->setAddress_Permanent($row->address_permanent)
                ->setCellphone($row->cellphone)
                ->setLicense_Condition_Business($row->license_condition_business)   
                ->setDate_License_Condition_Business($row->date_license_condition_business)
                ->setMaster_Items_Limit_Id($row->master_items_limit_id)
                ->setMaster_Items_Condition_Id($row->master_items_condition_id)
                ->setMaster_Province_Id($row->master_province_id)
                ->setMaster_District_Id($row->master_district_id)
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setMaster_Business_Type_Id($row->master_business_type_id)
                ->setMaster_Business_Size_Id($row->master_business_size_id)
                ->setDate_Check($row->date_check)
                ->setType_Business($row->type_business)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);   
            $entries[]=$entry;
        }
        return $entries;
    }
    public function fetchAllByUser($type_business,$userId){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from info_business where type_business='".$type_business."' and created_by = '".$userId."'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_InfoBusiness();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setLicense_Business($row->license_business)
                ->setDate_License($row->date_license)
                ->setDate_Deadline($row->date_deadline)
                ->setPlace_License($row->place_license)
                ->setAddress_Office($row->address_office)
		        ->setAddress_Office2($row->address_office2)
                ->setAddress_Branch($row->address_branch)
                ->setAddress_Produce($row->address_produce)
                ->setAddress_Produce1($row->address_produce1)
                ->setAddress_Produce11($row->address_produce11)
                ->setAddress_Produce111($row->address_produce111)
                ->setWork_Business($row->work_business)
                ->setPhone($row->phone)
                ->setBoss_Business($row->boss_business)
                ->setAddress_Permanent($row->address_permanent)
                ->setCellphone($row->cellphone)
                ->setLicense_Condition_Business($row->license_condition_business)   
                ->setDate_License_Condition_Business($row->date_license_condition_business)
                ->setMaster_Items_Limit_Id($row->master_items_limit_id)
                ->setMaster_Items_Condition_Id($row->master_items_condition_id)
                ->setMaster_Province_Id($row->master_province_id)
                ->setMaster_District_Id($row->master_district_id)
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setMaster_Business_Type_Id($row->master_business_type_id)
                ->setMaster_Business_Size_Id($row->master_business_size_id)
                ->setDate_Check($row->date_check)
                ->setType_Business($row->type_business)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);   
            $entries[]=$entry;
        }
        return $entries;
    }
    public function fetchAllNotByUser($type_business,$userId){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from info_business where type_business='".$type_business."' and created_by != '".$userId."'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_InfoBusiness();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setLicense_Business($row->license_business)
                ->setDate_License($row->date_license)
                ->setPlace_License($row->place_license)
                ->setDate_Deadline($row->date_deadline)
                ->setAddress_Office($row->address_office)
                ->setAddress_Office2($row->address_office2)
                ->setAddress_Branch($row->address_branch)
                ->setAddress_Produce($row->address_produce)
                ->setAddress_Produce1($row->address_produce1)
                ->setAddress_Produce11($row->address_produce11)
                ->setAddress_Produce111($row->address_produce111)
                ->setWork_Business($row->work_business)
                ->setPhone($row->phone)
                ->setBoss_Business($row->boss_business)
                ->setAddress_Permanent($row->address_permanent)
                ->setCellphone($row->cellphone)
                ->setLicense_Condition_Business($row->license_condition_business)
                ->setDate_License_Condition_Business($row->date_license_condition_business)
                ->setMaster_Items_Limit_Id($row->master_items_limit_id)
                ->setMaster_Items_Condition_Id($row->master_items_condition_id)
                ->setMaster_Province_Id($row->master_province_id)
                ->setMaster_District_Id($row->master_district_id)
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setMaster_Business_Type_Id($row->master_business_type_id)
                ->setMaster_Business_Size_Id($row->master_business_size_id)
                ->setDate_Check($row->date_check)
                ->setType_Business($row->type_business)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);
            $entries[]=$entry;
        }
        return $entries;
    }
     public function  fetchAll_REPORT($wherer){
        $db = Zend_Db_Table::getDefaultAdapter();      
       $select=" select * from info_business '".$wherer."'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();       
        foreach ($rows as $row) {
            $entry = new Model_MasterDistrict();   
           $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setLicense_Business($row->license_business)
                ->setDate_License($row->date_license)
                ->setDate_Deadline($row->date_deadline)
                ->setPlace_License($row->place_license)
                ->setAddress_Office($row->address_office)
		        ->setAddress_Office2($row->address_office2)
                ->setAddress_Branch($row->address_branch)
                ->setAddress_Produce($row->address_produce)
                ->setAddress_Produce1($row->address_produce1)
                ->setAddress_Produce11($row->address_produce11)
                ->setAddress_Produce111($row->address_produce111)
                ->setWork_Business($row->work_business)
                ->setPhone($row->phone)
                ->setBoss_Business($row->boss_business)
                ->setAddress_Permanent($row->address_permanent)
                ->setCellphone($row->cellphone)
                ->setLicense_Condition_Business($row->license_condition_business)   
                ->setDate_License_Condition_Business($row->date_license_condition_business)
                ->setMaster_Items_Limit_Id($row->master_items_limit_id)
                ->setMaster_Items_Condition_Id($row->master_items_condition_id)
                ->setMaster_Province_Id($row->master_province_id)
                ->setMaster_District_Id($row->master_district_id)
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setMaster_Business_Type_Id($row->master_business_type_id)
                ->setMaster_Business_Size_Id($row->master_business_size_id)
                ->setDate_Check($row->date_check)
                ->setType_Business($row->type_business)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);   
            $entries[]=$entry;
        }
        return $entries;
    }
     public function findidbyname1($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from info_business where ".$colums."='".$valueColums."' and is_delete='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
     public function findidbycode($code_business){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id,code from info_business where is_delete=0 and code='$code_business'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
    }
    public function findidbyname($district_name){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from info_business where is_delete=0 and name='$district_name'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
    }
     public function findtypebusinessbyid($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id,type_business from info_business where id='$id'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->type_business;   
    }
    public function finddocviolationsbyid($id){
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id,info_business_id from doc_violations_handling where info_business_id='$id'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;   
         
    }
    public function findbusinessbyid($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select * from info_business where id='$id'";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_InfoBusiness();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setLicense_Business($row->license_business)
                ->setDate_License($row->date_license)
                ->setDate_Deadline($row->date_deadline)
                ->setPlace_License($row->place_license)
                ->setAddress_Office($row->address_office)
		        ->setAddress_Office2($row->address_office2)
                ->setAddress_Branch($row->address_branch)
                ->setAddress_Produce($row->address_produce)
                ->setAddress_Produce1($row->address_produce1)
                ->setAddress_Produce11($row->address_produce11)
                ->setAddress_Produce111($row->address_produce111)
                ->setWork_Business($row->work_business)
                ->setPhone($row->phone)
                ->setBoss_Business($row->boss_business)
                ->setAddress_Permanent($row->address_permanent)
                ->setCellphone($row->cellphone)
                ->setLicense_Condition_Business($row->license_condition_business)   
                ->setDate_License_Condition_Business($row->date_license_condition_business)
                ->setMaster_Items_Limit_Id($row->master_items_limit_id)
                ->setMaster_Items_Condition_Id($row->master_items_condition_id)
                ->setMaster_District_Id($row->master_district_id)
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setMaster_Business_Type_Id($row->master_business_type_id)
                ->setMaster_Business_Size_Id($row->master_business_size_id)
                ->setDate_Check($row->date_check)
                ->setType_Business($row->type_business)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);   
            $entries[]=$entry;
        }
        return $entries;
    }

    /// Lan Duong
    public function fetchAllFilterDoanhNghiep($type_business, $doanhnghiep_id, $nganhnghe_id, $tinhthanh_id, $loaihinh_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $conditions = " where type_business='".$type_business."'";
        if($type_business == 'DoanhNghiep'){
            if($doanhnghiep_id != null) {
                $conditions .= "  and code in (".$doanhnghiep_id.")";
            }
            //$arrNganhnghe = explode(",",$nganhnghe_id);
            if($nganhnghe_id != null){
                $conditions .= " and work_business in (".$nganhnghe_id.")";
            }

            if($tinhthanh_id != null){
                $conditions .= " and master_province_id in (".$tinhthanh_id.")";
            }

            if($loaihinh_id != null){
                $conditions .= " and master_business_type_id in (".$loaihinh_id.")";
            }
        }

        $select = "select * from info_business " . $conditions;
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_InfoBusiness();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setLicense_Business($row->license_business)
                ->setDate_License($row->date_license)
                ->setDate_Deadline($row->date_deadline)
                ->setPlace_License($row->place_license)
                ->setAddress_Office($row->address_office)
                ->setAddress_Office2($row->address_office2)
                ->setAddress_Branch($row->address_branch)
                ->setAddress_Produce($row->address_produce)
                ->setAddress_Produce1($row->address_produce1)
                ->setAddress_Produce11($row->address_produce11)
                ->setAddress_Produce111($row->address_produce111)
                ->setWork_Business($row->work_business)
                ->setPhone($row->phone)
                ->setBoss_Business($row->boss_business)
                ->setAddress_Permanent($row->address_permanent)
                ->setCellphone($row->cellphone)
                ->setLicense_Condition_Business($row->license_condition_business)
                ->setDate_License_Condition_Business($row->date_license_condition_business)
                ->setMaster_Items_Limit_Id($row->master_items_limit_id)
                ->setMaster_Items_Condition_Id($row->master_items_condition_id)
                ->setMaster_Province_Id($row->master_province_id)
                ->setMaster_District_Id($row->master_district_id)
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setMaster_Business_Type_Id($row->master_business_type_id)
                ->setMaster_Business_Size_Id($row->master_business_size_id)
                ->setDate_Check($row->date_check)
                ->setType_Business($row->type_business)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);
            $entries[]=$entry;
        }
        return $entries;
    }
   
}
