<?php
include_once "BaseMapper.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_Print_PaymentBase{
    protected $_id;
    protected $_sys_department_id;  
    protected $_sys_user_id; 
    protected $_doc_print_allocation_id;
    protected $_master_print_id;
    protected $_serial_recovery;
    protected $_serial_fail;
    protected $_reasons_fail;
    protected $_date_payment;
    protected $_created_date;
    protected $_create_by;
    protected $_modified_date;
    protected $_modified_by;   
    protected $_order;
    protected $_status;
    protected $_is_delete;
    protected $_comment;
    protected $_soluong_xoabo_huhong;
    protected $_serial_xoabo_huhong;

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
            throw new Exception("Invalid doc_print_create");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid doc_print_create");
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
    public function setDoc_Print_Allocation_Id($value){
        $this->_doc_print_allocation_id=$value;
        return $this;
    }
    public function getDoc_Print_Allocation_Id(){return $this->_doc_print_allocation_id;}
     public function setMaster_Print_Id($value){
        $this->_master_print_id=$value;
        return $this;
    }
    public function getMaster_Print_Id(){return $this->_master_print_id;}
   
    public function setSerial_Recovery($value){
        $this->_serial_recovery=$value;
        return $this;
    }
    public function getSerial_Recovery(){return $this->_serial_recovery;}
   
   
    public function setSerial_Fail($value) {
        $this->_serial_fail=$value;
        return $this;
    }
   
    public function getSoLuong_XoaHuHong($valueSerialFail){
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
        if($valueSerialFail==""){
            return $this->_soluong_xoabo_huhong = 0;
        }
        $this->_soluong_xoabo_huhong=count($array_serial_xoahuhong);
        return $this->_soluong_xoabo_huhong;
        
    }
    
    public function getSerial_Fail(){return $this->_serial_fail;}
    
    public function setReasons_Fail($value) {
        $this->_reasons_fail = $value;
        return $this;
    }
    public function getReasons_Fail(){return $this->_reasons_fail;}
    public function setDate_Payment($value) {
        $this->_date_payment=$value;
        return $this;
    }
    public function getDate_Payment(){return $this->_date_payment;}
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
class Model_DbTable_Doc_Print_Payment extends Zend_Db_Table_Abstract
{
    protected $_name = "doc_print_payment";
    protected $_primary = "id";
}
class Model_Doc_Print_PaymentMapperBase extends BaseMapper{
     protected $_dbTable;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway doc_print_create");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Model_DbTable_Doc_Print_Payment");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Doc_Print_Payment $entry){
        $data = array(
                'id' => $entry->getId(),                
                'sys_department_id'=>$entry->getSys_Department_Id(),
                'sys_user_id'=>$entry->getSys_User_Id(),
                'doc_print_allocation_id'=>$entry->getDoc_Print_Allocation_Id(),
                'master_print_id'=>$entry->getMaster_Print_Id(),
                'serial_recovery'=>$entry->getSerial_Recovery(),
                'serial_fail'=>$entry->getSerial_Fail(),
                'reasons_fail'=>$entry->getReasons_Fail(),
                'date_payment'=>$entry->getDate_Payment(),
                'created_date'=>$entry->getCreated_Date(),
                'created_by'=>$entry->getCreated_By(),
                'modified_date'=>$entry->getModified_Date(),
                'modified_by'=>$entry->getModified_By(),
                'order'=>$entry->getOrder(),
                'status'=>$entry->getStatus(),
                'comment'=>$entry->getComment(),
                'is_delete'=>$entry->getIs_Delete()               
                );
         if (null === ($id = $entry->getId())) {
            unset($data["id"]);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array("id = ?" => $id));
        }
    }  
    public function find($id,  Model_Doc_Print_Payment $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
        $entry->setId($row->id)
                ->setId($row->id)                
                ->setsys_department_id($row->sys_department_id)
                ->setsys_user_id($row->sys_user_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setMaster_Print_Id($row->master_print_id)
                ->setSerial_Recovery($row->serial_recovery)
                ->setSerial_Fail($row->serial_fail)
                ->setReasons_Fail($row->reasons_fail)
                ->setDate_Payment($row->date_payment)
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
            $entry = new Model_Doc_Print_Payment();
            $entry->setId($row->id)
                 ->setId($row->id)                
                ->setSys_Department_Id($row->sys_department_id)
                ->setSys_User_Id($row->sys_user_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setMaster_Print_Id($row->master_print_id)
                ->setSerial_Recovery($row->serial_recovery)
                ->setSerial_Fail($row->serial_fail)
                ->setReasons_Fail($row->reasons_fail)
                ->setDate_Payment($row->date_payment)
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
		$queryTotal = "SELECT count(*) as totals FROM doc_print_create ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM doc_print_create ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_Doc_Print_Payment();
            $entry->setId($row->id)
                ->setId($row->id)                
                ->setsys_department_id($row->sys_department_id)
                ->setsys_user_id($row->sys_user_id)
                ->setDoc_Print_Allocation_Id($row->doc_print_allocation_id)
                ->setMaster_Print_Id($row->master_print_id)
                ->setSerial_Recovery($row->serial_recovery)
                ->setSerial_Fail($row->serial_fail)
                ->setReasons_Fail($row->reasons_fail)
                ->setDate_Payment($row->date_payment)
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