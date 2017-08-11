<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "BaseMapper.php";
class Model_InfoBusinessBase {
    protected $_id;
    protected $_code;
    protected $_name;
    protected $_license_business;
    protected $_date_license;
    protected $_date_deadline;
    protected $_place_license;
    protected $_address_office;
    protected $_address_office2;
    protected $_address_branch;
    protected $_address_produce;
    protected $_address_produce1;
    protected $_address_produce11;
    protected $_address_produce111;
    protected $_work_business;
    protected $_phone;
    protected $_boss_business;
    protected $_address_permanent;
    protected $_cellphone;
    protected $_license_condition_business;
    protected $_date_license_condition_business;
    protected $_master_items_limit_id;
    protected $_master_items_condition_id;
    protected $_master_province_id;
    protected $_master_district_id;
    protected $_master_ward_id;
    protected $_master_business_type_id;
    protected $_master_business_size_id;
    protected $_date_check;
    protected $_type_business;
    protected $_created_date;
    protected $_created_by;
    protected $_modified_date;
    protected $_modified_by;
    protected $_order;
    protected $_status;
    protected $_is_delete;
    protected $_comment;
    
    public function __construct(array $options = NULL)   
    {   
        if (is_array($options)) {   
            $this->setOptions($options);   
        }   
    }   
    public function __set($name, $value)   
    {   
        $method = "set" . $name;   
        if (("mapper" == $name) || !method_exists($this, $method)) {   
            throw new Exception("Invalid Business property");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Business property");
        }
        return $this->$method();
    }
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = "set" . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function setId($value){
        $this->_id=$value;
        return $this;
    }
    public function getId(){return $this->_id;}
    
    public function setCode($value){
        $this->_code=$value;
        return $this;
    }
    public function getCode(){return $this->_code;}
    public function setName($value){
        $this->_name=$value;
        return $this;
    }
    public function getName(){return $this->_name;}
    
    public function setLicense_Business($value){
        $this->_license_business=$value;
        return $this;
    }
    public function getLicense_Business(){return $this->_license_business;}
    public function setDate_License($value){
        $this->_date_license=$value;
        return $this;
    }
    public function getDate_License(){return $this->_date_license;}
     public function setDate_Deadline($value){
        $this->_date_deadline=$value;
        return $this;
    }
    public function getDate_Deadline(){return $this->_date_deadline;}
    public function setPlace_License($value){
        $this->_place_license=$value;
        return $this;
    }
    public function getPlace_License(){return $this->_place_license;}
    
    public function setAddress_Office($value){
        $this->_address_office=$value;
        return $this;
    }
    public function getAddress_Office(){return $this->_address_office;}
     public function setAddress_Office2($value){
        $this->_address_office2=$value;
        return $this;
    }
    public function getAddress_Office2(){return $this->_address_office2;}
    
    public function setAddress_Branch($value){
        $this->_address_branch=$value;
        return $this;
    }
    public function getAddress_Branch(){return $this->_address_branch;}
     public function setAddress_Produce($value){
        $this->_address_produce=$value;
        return $this;
    }
    public function getAddress_Produce(){return $this->_address_produce;}

    public function setAddress_Produce1($value){
        $this->_address_produce1=$value;
        return $this;
    }
    public function getAddress_Produce1(){return $this->_address_produce1;}

    public function setAddress_Produce11($value){
        $this->_address_produce11=$value;
        return $this;
    }
    public function getAddress_Produce11(){return $this->_address_produce11;}
    public function setAddress_Produce111($value){
        $this->_address_produce111=$value;
        return $this;
    }
    public function getAddress_Produce111(){return $this->_address_produce111;}
     public function setWork_Business($value){
        $this->_work_business=$value;
        return $this;
    }
    public function getWork_Business(){return $this->_work_business;}
    public function setPhone($value){
        $this->_phone=$value;
        return $this;
    }
    public function getPhone(){return $this->_phone;}
    public function setBoss_Business($value){
        $this->_boss_business=$value;
        return $this;
    }
    public function getBoss_Business(){return $this->_boss_business;}
    public function setAddress_Permanent($value){
        $this->_address_permanent=$value;
        return $this;
    }
    public function getAddress_Permanent(){return $this->_address_permanent;}
     public function setCellphone($value){
        $this->_cellphone=$value;
        return $this;
    }
    public function getCellphone(){return $this->_cellphone;}
     public function setLicense_Condition_Business($value){
        $this->_license_condition_business=$value;
        return $this;
    }
    public function getLicense_Condition_Business(){return $this->_license_condition_business;}
     public function setDate_License_Condition_Business($value){
        $this->_date_license_condition_business=$value;
        return $this;
    }
    public function getDate_License_Condition_Business(){return $this->_date_license_condition_business;}
     public function setMaster_Items_Limit_Id($value){
        $this->_master_items_limit_id=$value;
        return $this;
    }
    public function getMaster_Items_Limit_Id(){return $this->_master_items_limit_id;}
    public function setMaster_Items_Condition_Id($value) {
        $this->_master_items_condition_id=$value;
        return $this;
    }
    public function getMaster_Items_Condition_Id(){return $this->_master_items_condition_id;}
     public function setMaster_Province_Id($value){
        $this->_master_province_id=$value;
        return $this;
    }
    public function getMaster_Province_Id(){return $this->_master_province_id;}
    public function setMaster_District_Id($value){
        $this->_master_district_id=$value;
        return $this;
    }
    public function getMaster_District_Id(){return $this->_master_district_id;}
     public function setMaster_Ward_Id($value){
        $this->_master_ward_id=$value;
        return $this;
    }
    public function getMaster_Ward_Id(){return $this->_master_ward_id;}
    public function setMaster_Business_Type_Id($value){
        $this->_master_business_type_id=$value;
        return $this;
    }
    public function getMaster_Business_Type_Id(){return $this->_master_business_type_id;}
    public function setMaster_Business_Size_Id($value){
        $this->_master_business_size_id=$value;
        return $this;
    }
    public function getMaster_Business_Size_Id(){return $this->_master_business_size_id;}
    public function setDate_Check($value){
        $this->_date_check=$value;
        return $this;
    }
    public function getDate_Check(){return $this->_date_check;}
     public function setType_Business($value){
        $this->_type_business=$value;
        return $this;
    }
    public function getType_Business(){return $this->_type_business;}
     public function setCreated_date($value) {
        $this->_created_date = $value;
        return $this;
    }
    public function getCreated_date(){return $this->_created_date;}
    public function setCreated_By($value) {
        $this->_created_by = $value;
        return $this;
    }
    public function getCreated_By(){return $this->_created_by;}
    
    public function setModified_date($value) {
        $this->_modified_date = $value;
        return $this;
    }
    public function getModified_date() {return $this->_modified_date;}
    
    public function setModified_By($value){
        $this->_modified_by=$value;
        return $this;
    }
    public function getModified_By(){return $this->_modified_by;}

    public function setOrder($value){
        $this->_order=$value;
        return $this;
    }
    public function getOrder(){return $this->_order;}
    
    public function setStatus($value){
        $this->_status=$value;
        return $this;
    }
    public function getStatus(){return $this->_status;}  
     public function setIs_delete($value){
        $this->_is_delete=$value;
        return $this;
    }
    public function getIs_delete(){return $this->_is_delete;}  
    public function setComment($value){
        $this->_comment=$value;
        return $this;
    }
    public function getComment(){return $this->_comment;} 
   

}
class Model_DbTable_InfoBusiness extends Zend_Db_Table_Abstract
{
    protected $_name = "info_business";
    protected $_primary = "id";
}
class Model_InfoBusinessMapperBase extends BaseMapper{
     protected $_dbTable;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway provided");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Model_DbTable_InfoBusiness");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_InfoBusiness $entry){
        $data = array(
                'id' => $entry->getId(),
                'code'=> $entry->getCode(),
                'name' => $entry->getName(),
                'license_business'=>$entry->getLicense_Business(),
                'date_license'=>$entry->getDate_License(),
                'date_deadline'=>$entry->getDate_Deadline(),
                'place_license'=>$entry->getPlace_License(),
                'address_office'=> $entry->getAddress_Office(),
		'address_office2'=> $entry->getAddress_Office2(),
                'address_branch' => $entry->getAddress_Branch(),
                'address_produce' =>$entry->getAddress_Produce(),
                'address_produce1' =>$entry->getAddress_Produce1(),
                'address_produce11' =>$entry->getAddress_Produce11(),
                'address_produce111' =>$entry->getAddress_Produce111(),
                'work_business'=>$entry->getWork_Business(),
                'phone'=>$entry->getPhone(),
                'boss_business'=>$entry->getBoss_Business(),
                'address_permanent'=> $entry->getAddress_Permanent(),
                'cellphone' => $entry->getCellphone(),
                'license_condition_business'=>$entry->getLicense_Condition_Business(),   
                'date_license_condition_business'=>$entry->getDate_License_Condition_Business(),
                'master_items_limit_id'=>$entry->getMaster_Items_Limit_Id(),
                'master_items_condition_id'=>$entry->getMaster_Items_Condition_Id(),
                'master_province_id'=>$entry->getMaster_Province_Id(),
                'master_district_id'=>$entry->getMaster_District_Id(),
                'master_ward_id'=>$entry->getMaster_Ward_Id(),
                'master_business_type_id'=>$entry->getMaster_Business_Type_Id(),
                'master_business_size_id'=>$entry->getMaster_Business_Size_Id(),
                'date_check'=>$entry->getDate_Check(),
                'type_business'=>$entry->getType_Business(),
                'created_date'=>$entry->getCreated_date(),
                'created_by'=>$entry->getCreated_By(),
                'modified_date'=>$entry->getModified_date(),
                'modified_by'=>$entry->getModified_By(),
                'order'=>$entry->getOrder(),
                'status'=>$entry->getStatus(),
               //'is_delete'=>$entry->getIs_delete(),
                'comment'=>$entry->getComment(),
               
                );
         if (null === ($id = $entry->getId())) {
            unset($data["id"]);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array("id = ?" => $id));
        }
    }
    
    public function delete($id){
        $this->getDbTable()->delete("id=".$id);
    }
    
    public function find($id,  Model_InfoBusiness $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
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
    }
    
   /* public function fetchAll($type_business){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
            if($type_business != )
            $entry = new Model_InfoBusiness();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setLicense_Business($row->license_business)
                ->setDate_License($row->date_license)
                ->setPlace_License($row->place_license)
                ->setAddress_Office($row->address_office)
		->setAddress_Office2($row->address_office2)
                ->setAddress_Branch($row->address_branch)
                ->setAddress_Produce($row->address_produce)
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
    }*/
    public function fetchAllArray()
    {
		$data = array(array());
        $resultSet = $this->getDbTable()->fetchAll(PDO::FETCH_COLUMN);
		$count = count($resultSet);
		for($i=0;$i<$count;$i++)
		{
			$data[$resultSet[$i]['id']]['name'] = $resultSet[$i]['name'];
		}
		return $data;
    }
     public function fetchPaging($page, $pageSize, $orderBy, $orderDirection, &$totalRecord, $filters=null)
    {
        $db = Zend_Db_Table::getDefaultAdapter();	
		$aFilterValues = array();
		$sFilter = $this->createWhereCondition($filters, $aFilterValues);
		$queryTotal = "SELECT count(*) as totals FROM info_business ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM info_business ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_Business();
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
            $entries[] = $entry;
        }
        return $entries;
    }
    public function createCombo($id=0, $name='id', $width=230)
	{
		$items = $this->fetchAll();
		$html = '<select name="'.$name.'" style="width:'.$width.'px">';
		$html .= '<option value="0">--Please select--</option>';
		foreach ($items as $item)
		{
			if($id == $item->getId())
			{
				$html .= '<option value="'.$item->getId().'"  selected="selected">'.$item->getUserName().'</option>';
			}else{
				$html .= '<option value="'.$item->getId().'">'.$item->getUserName().'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
}
