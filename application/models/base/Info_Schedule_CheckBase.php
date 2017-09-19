<?php
include_once "BaseMapper.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Info_Schedule_CheckBase{
    protected $_id;
    protected $_info_schedule_id;  
    protected $_info_business_id;
    protected $_master_violation_id;
    protected $_doc_print_allocation_id;  
    protected $_serial_check;//de danh khi bao cao cho ro rang
    protected $_staff_check;//user di xu ly
    protected $_sys_department_id;
    protected $_date_check;
    protected $_created_date;
    protected $_created_by;
    protected $_modified_date;
    protected $_modified_by;   
    protected $_order;
    protected $_status;
    protected $_is_delete;
    protected $_is_violations;
    protected $_doc_violations_handling_id;
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
    
    public function setInfo_Schedule_Id($value){
        $this->_info_schedule_id=$value;
        return $this;
    }
    public function getInfo_Schedule_Id(){return $this->_info_schedule_id;} 
    public function setInfo_Business_Id($value){
        $this->_info_business_id=$value;
        return $this;
    }
    public function getInfo_Business_Id(){return $this->_info_business_id;}

    public function setMaster_Violation_Id($value){
        $this->_master_violation_id=$value;
        return $this;
    }
    public function getMaster_Violation_Id(){return $this->_master_violation_id;}

    public function setDoc_Print_Allocation_Id($value){
        $this->_doc_print_allocation_id=$value;
        return $this;
    }
   public function getDoc_Print_Allocation_Id(){return $this->_doc_print_allocation_id;} 
    public function setSerial_Check($value){
        $this->_serial_check=$value;
       return $this;
    }
    public function getSerial_Check(){return $this->_serial_check;}
    public function setStaff_Check($value){
        $this->_staff_check=$value;
        return $this;
    }
    public function getStaff_Check(){return $this->_staff_check;}
    public function setDate_Check($value){
        $this->_date_check=$value;
        return $this;
    }
    public function getDate_Check(){return $this->_date_check;}
     public function setSys_Department_Id($value){
        $this->_sys_department_id=$value;
        return $this;
    }
    public function getSys_Department_Id(){return $this->_sys_department_id;}
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
    public function setIs_Violations($value){
        $this->_is_violations=$value;
        return $this;
    }
    public function getIs_Violations(){return $this->_is_violations;}
    public function setDoc_Violations_Handling_Id($value){
        $this->_doc_violations_handling_id=$value;
        return $this;
    }
    public function getDoc_Violations_Handling_Id(){return $this->_doc_violations_handling_id;}
}
class Model_DbTable_Info_Schedule_Check extends Zend_Db_Table_Abstract
{
    protected $_name = "info_schedule_check";
    protected $_primary = "id";
}
class Model_Info_Schedule_CheckMapperBase extends BaseMapper{
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
            $this->setDbTable("Model_DbTable_Info_Schedule_Check");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Info_Schedule_Check $entry){
      
        $data = array(
                'id' => $entry->getId(),
                'info_schedule_id'=> $entry->getInfo_Schedule_Id(),  
                'info_business_id'=>$entry->getInfo_Business_Id(),
                'master_violation_id'=>$entry->getMaster_Violation_Id(),
                'doc_print_allocation_id'=>$entry->getDoc_Print_Allocation_Id(),
                'serial_check'=>$entry->getSerial_Check(),
                'staff_check'=>$entry->getStaff_Check(),
                'sys_department_id'=>$entry->getSys_Department_Id(),
                'date_check'=>$entry->getDate_Check(),
                'created_date'=>$entry->getCreated_Date(),
                'created_by'=>$entry->getCreated_By(),
                'modified_date'=>$entry->getModified_Date(),
                'modified_by'=>$entry->getModified_By(),
                'order'=>$entry->getOrder(),
                'status'=>$entry->getStatus(),
                'comment'=>$entry->getComment(),    
                'is_delete'=>$entry->getIs_Delete(),
                'is_violations'=>$entry->getIs_Violations(),
                'doc_violations_handling_id'=>$entry->getDoc_Violations_Handling_Id()
                );
            if (null === ($id = $entry->getId())) {
               unset($data["id"]);
               $id = $this->getDbTable()->insert($data);
               $entry->setId($id);
            } else {
                $this->getDbTable()->update($data, array("id = ?" => $id));
            }
        
    }

    public function updateViolation($id, $is_violations) {
        if($is_violations == 0)
            $violation = 3; // Không vi phạm, trả lại
        else
            $violation = $is_violations;
        $data = array(
            'id' => $id,
            'modified_date'=> date("Y/m/d H:i:s"),
            'is_violations'=>$violation
        );
        $this->getDbTable()->update($data, array("id = ?" => $id));
    }

    public function find($id,Model_Info_Schedule_Check $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
        $entry->setId($row->id)
                ->setId($row->id)
                ->setInfo_Schedule_Id($row->info_schedule_id) 
                ->setInfo_Business_Id($row->info_business_id)
                ->setMaster_Violation_Id($row->master_violation_id)
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
                ->setIs_Violations($row->is_violations)
                ->setDoc_Violations_Handling_Id($row->doc_violations_handling_id)
                ->setIs_Delete($row->is_delete);
               
    }
    
   /* public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
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
                ->setIs_Violations($row->is_violations)
                ->setDoc_Violations_Handling_Id($row->doc_violations_handling_id)
                ->setIs_Delete($row->is_delete);
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
            $entries[] = $entry;
        }
        return $entries;
    }
   
}