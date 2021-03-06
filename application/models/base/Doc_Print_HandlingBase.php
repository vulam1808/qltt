<?php
include_once "BaseMapper.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Print_HandlingBase{
    protected $_id;
    protected $_master_print_id;
    protected $_doc_print_allocation_id;  
    protected $_doc_violations_handling_id;
    protected $_serial_handing;
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
            throw new Exception("Invalid doc_print_handling");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid doc_print_handling");
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
     public function setMaster_Print_Id($value){
        $this->_master_print_id=$value;
        return $this;
    }
    public function getMaster_Print_Id(){return $this->_master_print_id;}
    
     public function setDoc_Print_Allocation_Id($value){
        $this->_doc_print_allocation_id=$value;
        return $this;
    }
    public function getDoc_Print_Allocation_Id(){return $this->_doc_print_allocation_id;}
    public function setDoc_Violations_Handling_Id($value){
        $this->_doc_violations_handling_id=$value;
        return $this;
    }
    public function getDoc_Violations_Handling_Id(){return $this->_doc_violations_handling_id;}
     public function setSerial_Handing($value){
        $this->_serial_handing=$value;
        return $this;
    }
    public function getSerial_Handing(){return $this->_serial_handing;}
    
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
class Model_DbTable_Doc_Print_Handling extends Zend_Db_Table_Abstract
{
    protected $_name = "doc_print_handling";
    protected $_primary = "id";
}
class Model_Doc_Print_HandlingMapperBase extends BaseMapper{
     protected $_dbTable;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway Doc_Print_Handling");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Model_DbTable_Doc_Print_Handling");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Doc_Print_Handling $entry){
        $data = array(
                'id' => $entry->getId(),                
                'master_print_id'=>$entry->getMaster_Print_Id(),
                'doc_print_allocation_id'=>$entry->getDoc_Print_Allocation_Id(),
                'doc_violations_handling_id'=>$entry->getDoc_Violations_Handling_Id(),
                'serial_handing'=>$entry->getSerial_Handing(),
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
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array("id = ?" => $id));
        }
    }  
    public function find($id,  Model_Doc_Print_Handling $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
        $entry->setId($row->id)
                ->setId($row->id)     
                ->setMaster_Print_Id($row->master_print_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setDoc_Violations_Handling_Id($row->doc_violations_handling_id) 
                ->setSerial_Handing($row->serial_handing)
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
            $entry = new Model_Doc_Print_Handling();
            $entry->setId($row->id)
                ->setId($row->id)                
                ->setMaster_Print_Id($row->master_print_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setDoc_Violations_Handling_Id($row->doc_violations_handling_id)                
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
		$queryTotal = "SELECT count(*) as totals FROM doc_print_handling ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM doc_print_handling ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_Doc_Print_Handling();
            $entry->setId($row->id)
                  ->setId($row->id)           
                    ->setMaster_Print_Id($row->master_print_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setDoc_Violations_Handling_Id($row->doc_violations_handling_id)                
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