<?php
include_once "BaseMapper.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Violations_HandlingBase{
    protected $_id;
    protected $_info_business_id;  
    protected $_master_violation_id; 
     protected $_master_sanctions_id;
    
    protected $_sys_department_id;//de danh khi bao cao cho ro rang
    protected $_sys_user_id;//user di xu ly
    protected $_date_violation;    
    protected $_amount; 
    protected $_created_date;
    protected $_create_by;
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
            throw new Exception("Invalid Doc_Violations_Handling");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Doc_Violations_Handling");
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
    public function setMaster_Sanctions_Id($value){
        $this->_master_sanctions_id=$value;
        return $this;
    }
   public function getMaster_Sanctions_Id(){return $this->_master_sanctions_id;} 
    public function setSys_Department_Id($value){
        $this->_sys_department_id=$value;
       return $this;
    }
    public function getSys_Department_Id(){return $this->_sys_department_id;}
    public function setSys_User_Id($value){
        $this->_sys_user_id=$value;
        return $this;
    }
    public function getSys_User_Id(){return $this->_sys_user_id;}
    public function setDate_Violation($value){
        $this->_date_violation=$value;
        return $this;
    }
    public function getDate_violation(){return $this->_date_violation;}
    public function setAmount($value){
        $this->_amount=$value;
        return $this;
    }
    public function getAmount(){return $this->_amount;} 
    public function setCreated_Date($value) {
        $this->_created_date=$value;
        return $this;
    }
    public function getCreated_Date(){return $this->_created_date;}
    
    public function setCreated_By($value) {
        $this->_create_by = $value;
        return $this;
    }
    public function getCreated_By(){return $this->_create_by;}
    
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
class Model_DbTable_Doc_Violations_Handling extends Zend_Db_Table_Abstract
{
    protected $_name = "doc_violations_handling";
    protected $_primary = "id";
}
class Model_Doc_Violations_HandlingMapperBase extends BaseMapper{
     protected $_dbTable;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway Doc_Violations_Handlinged");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Model_DbTable_Doc_Violations_Handling");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Doc_Violations_Handling $entry){
      
        $data = array(
                'id' => $entry->getId(),
                'info_business_id'=> $entry->getInfo_Business_Id(),  
                'master_violation_id'=>$entry->getMaster_Violation_Id(),
               'master_sanctions_id'=>$entry->getMaster_Sanctions_Id(),
                'sys_department_id'=>$entry->getSys_Department_Id(),
                'sys_user_id'=>$entry->getSys_User_Id(),
                'date_violation'=>$entry->getDate_Violation(),
                'amount'=>$entry->getAmount(),
                'created_date'=>$entry->getCreated_Date(),
                'created_by'=>$entry->getCreated_By(),
                'modified_date'=>$entry->getModified_Date(),
                'modified_by'=>$entry->getModified_By(),
                'order'=>$entry->getOrder(),
                'status'=>$entry->getStatus(),
                'comment'=>$entry->getComment()
                //'is_delete'=>$entry->getIs_Delete()               
                );
            if (null === ($id = $entry->getId())) {
               unset($data["id"]);
               $id = $this->getDbTable()->insert($data);
               $entry->setId($id);
            } else {
                $this->getDbTable()->update($data, array("id = ?" => $id));
            }
        
    }  
    public function find($id,  Model_Doc_Violations_Handling $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
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
               
    }
    
    public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
            $entry = new Model_Doc_Violations_Handling();
            $entry->setId($row->id)
                ->setId($row->id)    
                ->setInfo_Business_Id($row->info_business_id) 
                ->setMaster_Violation_Id($row->master_violation_id)
                ->setMaster_Sanctions_Id($row->master_sanction_id) 
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
            $entries[] = $entry;
        }
        return $entries;
    }
   
}