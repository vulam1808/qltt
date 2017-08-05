<?php
include_once "BaseMapper.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Info_ScheduleBase{
    protected $_id;
    protected $_name_schedule;  
    protected $_date_from; 
    protected $_date_to;
    
    protected $_sys_department_id;//de danh khi bao cao cho ro rang
    protected $_master_district_id;//user di xu ly
    protected $_master_ward_id;    
    protected $_is_confirm; 
    protected $_confirm_sys_user_id;
    protected $_confirm_date;
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
            throw new Exception("Invalid Info_Schedule");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Info_Schedule");
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
    
    public function setName_Schedule($value){
        $this->_name_schedule=$value;
        return $this;
    }
    public function getName_Schedule(){return $this->_name_schedule;} 
    public function setDate_From($value){
        $this->_date_from=$value;
        return $this;
    }
    public function getDate_From(){return $this->_date_from;} 
    public function setDate_To($value){
        $this->_date_to=$value;
        return $this;
    }
   public function getDate_To(){return $this->_date_to;} 
    public function setSys_Department_Id($value){
        $this->_sys_department_id=$value;
       return $this;
    }
    public function getSys_Department_Id(){return $this->_sys_department_id;}
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
    public function setIs_Confirm($value){
        $this->_is_confirm=$value;
        return $this;
    }
    public function getIs_Confirm(){return $this->_is_confirm;} 
    public function setConfirm_Sys_User_Id($value) {
        $this->_confirm_sys_user_id=$value;
        return $this;
    }
    public function getConfirm_Sys_User_Id(){return $this->_confirm_sys_user_id;}
    public function setConfirm_Date($value){
        $this->_confirm_date=$value;
        return $this;
    }
    public function getConfirm_Date(){return $this->_confirm_date;} 
     public function setCreated_Date($value) {
        $this->_created_date = $value;
        return $this;
    }
    public function getCreated_Date(){return $this->_created_date;}
    public function setCreated_By($value) {
        $this->_created_by = $value;
        return $this;
    }
    public function getCreated_By(){return $this->_created_by;}
    
    public function setModified_Date($value) {
        $this->_modified_date = $value;
        return $this;
    }
    public function getModified_Date() {return $this->_modified_date;}
    
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
    
    public function setComment($value){
        $this->_comment=$value;
        return $this;
    }
    public function getComment(){return $this->_comment;}
    public function setIs_Delete($value){
        $this->_is_delete=$value;
        return $this;
    }
    public function getIs_Delete(){return $this->_is_delete;}
}
class Model_DbTable_Info_Schedule extends Zend_Db_Table_Abstract
{
    protected $_name = "info_schedule";
    protected $_primary = "id";
}
class Model_Info_ScheduleMapperBase extends BaseMapper{
     protected $_dbTable;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway Info_Scheduleged");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Model_DbTable_Info_Schedule");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Info_Schedule $entry){
      
        $data = array(
                'id' => $entry->getId(),
                'name_schedule'=> $entry->getName_Schedule(),  
                'date_from'=>$entry->getDate_From(),
                'date_to'=>$entry->getDate_To(),
                'sys_department_id'=>$entry->getSys_Department_Id(),
                'master_district_id'=>$entry->getMaster_District_Id(),
                'master_ward_id'=>$entry->getMaster_Ward_Id(),
                'is_confirm'=>$entry->getIs_Confirm(),
                'confirm_sys_user_id'=>$entry->getConfirm_Sys_User_Id(),
                'created_date'=>$entry->getCreated_Date(),
                'created_by'=>$entry->getCreated_By(),
                'modified_date'=>$entry->getModified_Date(),
                'modified_by'=>$entry->getModified_By(),
                'order'=>$entry->getOrder(),
                'status'=>$entry->getStatus(),
                'comment'=>$entry->getComment(),             
                );
            if (null === ($id = $entry->getId())) {
               unset($data["id"]);
               $id = $this->getDbTable()->insert($data);
               $entry->setId($id);
            } else {
                $this->getDbTable()->update($data, array("id = ?" => $id));
            }
        
    }  
    public function find($id,Model_Info_Schedule $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
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
               
    }
    
    public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
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
		$queryTotal = "SELECT count(*) as totals FROM Doc_Violations_Handling ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM Doc_Violations_Handling ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
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
            $entries[] = $entry;
        }
        return $entries;
    }
   
}