<?php
include_once "BaseMapper.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Items_HandlingBase{
    protected $_id;
    protected $_master_items_id;  
    protected $_master_sanction_id; 
    protected $_doc_violations_handling_id;
    protected $_serial_handling;
    protected $_sys_user_id;
    protected $_quantity_commodity; 
    protected $_master_unit_id;
    protected $_date_handling;
    protected $_amount;
    protected $_file_upload;
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
            throw new Exception("Invalid Doc_Items_Handling");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Doc_Items_Handling");
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
    
    public function setMaster_Items_Id($value){
        $this->_master_items_id=$value;
        return $this;
    }
    public function getMaster_Items_Id(){return $this->_master_items_id;} 
    public function setMaster_Sanction_Id($value){
        $this->_master_sanction_id=$value;
        return $this;
    }
    public function getMaster_Sanction_Id(){return $this->_master_sanction_id;} 
    public function setDoc_Violations_Handling_Id($value){
        $this->_doc_violations_handling_id=$value;
        return $this;
    }
    public function getDoc_Violations_Handling_Id(){return $this->_doc_violations_handling_id;} 
    public function setSerial_Handling($value){
        $this->_serial_handling=$value;
        return $this;
    }
    public function getSerial_Handling(){return $this->_serial_handling;}
    public function setQuantity_Commodity($value){
        $this->_quantity_commodity=$value;
        return $this;
    }
    public function getQuantity_Commodity(){return $this->_quantity_commodity;}
    public function setMaster_Unit_Id($value){
        $this->_master_unit_id=$value;
        return $this;
    }
    public function getMaster_Unit_Id(){return $this->_master_unit_id;}
    public function setDate_Handling($value){
        $this->_date_handling=$value;
        return $this;
    }
    public function getDate_Handling(){return $this->_date_handling;}
    public function setAmount($value){
        $this->_amount=$value;
        return $this;
    }
    public function getAmount(){return $this->_amount;}
    public function setFile_Upload($value){
        $this->_file_upload=$value;
        return $this;
    }
    public function getFile_Upload(){return $this->_file_upload;}
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
class Model_DbTable_Doc_Items_Handling extends Zend_Db_Table_Abstract
{
    protected $_name = "doc_items_handling";
    protected $_primary = "id";
}
class Model_Doc_Items_HandlingMapperBase extends BaseMapper{
     protected $_dbTable;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway Doc_Items_Handlinged");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Model_DbTable_Doc_Items_Handling");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Doc_Items_Handling $entry){
        $data = array(
                'id' => $entry->getId(),
                'master_items_id'=> $entry->getMaster_Items_Id(),  
                'master_sanction_id'=>$entry->getMaster_Sanction_Id(),
                'doc_violations_handling_id'=>$entry->getDoc_Violations_Handling_Id(),
                'serial_handling'=>$entry->getSerial_Handling(),
                'quantity_commodity'=>$entry->getQuantity_Commodity(),
                'master_unit_id'=>$entry->getMaster_Unit_Id(),
                'date_handling'=>$entry->getDate_Handling(),
                'amount'=>$entry->getAmount(),
                'file_upload'=>$entry->getFile_Upload(),               
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
    public function find($id, Model_Doc_Items_Handling $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
        $entry->setId($row->id)
                ->setId($row->id)
                ->setMaster_Items_Id($row->master_items_id) 
                ->setMaster_Sanction_Id($row->master_sanction_id)
                ->setDoc_Violations_Handling_id($row->doc_violations_handling_id) 
                ->setSerial_Handling($row->serial_handling)
                ->setQuantity_Commodity($row->quantity_commodity) 
                ->setMaster_Unit_Id($row->master_unit_id)
                ->setDate_Handling($row->date_handling)
                ->setAmount($row->amount) 
                ->setFile_Upload($row->file_upload)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)              
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setComment($row->comment)
                ->setIs_Delete($row->is_delete);
               
    }
    
   /* public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
            $entry = new Model_Doc_Items_Handling();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setMaster_Items_Id($row->master_items_id) 
                ->setMaster_Sanction_Id($row->master_sanction_id)
                ->setDoc_Violations_Handling_id($row->doc_violations_handling_id) 
                ->setSerial_Handling($row->serial_handling)
                ->setQuantity_Commodity($row->quantity_commodity) 
                ->setMaster_Unit_Id($row->master_unit_id)
                ->setDate_Handling($row->date_handling)
                ->setAmount($row->amount) 
                ->setFile_Upload($row->file_upload)
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
		$queryTotal = "SELECT count(*) as totals FROM Doc_Items_Handling ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM Doc_Items_Handling ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_Doc_Items_Handling();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setMaster_Items_Id($row->master_items_id) 
                ->setMaster_Sanction_Id($row->master_sanction_id)
                ->setDoc_Violations_Handling_id($row->doc_violations_handling_id) 
                ->setSerial_Handling($row->serial_handling)
                ->setQuantity_Commodity($row->quantity_commodity) 
                ->setMaster_Unit_Id($row->master_unit_id)
                ->setDate_Handling($row->date_handling)
                ->setAmount($row->amount) 
                ->setFile_Upload($row->file_upload)
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