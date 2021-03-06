<?php
include_once "BaseMapper.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Doc_DiaryBase{
    protected $_id;
    protected $_date_diary;  //ngày kiểm tra
    protected $_implementers; //ngừoi được phân công kiểm tra
    protected $_position;//chức danh khi thi hành công vụ
    protected $_content_inspection;//nội dung kiểm tra
    protected $_time_check;//thời gian kiểm tra
    protected $_status_and_test_results;//trạng thái và kết quả kiểm tra
    protected $_processing_results; //kết quả xử lý
    protected $_signature;//chữ ký
    protected $_id_info_schedule_check; 
            
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
    
    public function setDate_Diary($value){
        $this->_date_diary=$value;
        return $this;
    }
    public function getDate_Diary(){return $this->_date_diary;} 
    
    public function setImplementers($value){
        $this->_implementers=$value;
        return $this;
    }
    public function getImplementers(){return $this->_implementers;} 
    
    public function setPosition($value){
        $this->_position=$value;
        return $this;
    }
    public function getPosition(){return $this->_position;} 
    
    public function setContent_Inspection($value){
        $this->_content_inspection=$value;
        return $this;
    }
    public function getContent_Inspection(){return $this->_content_inspection;}
    
    public function setTime_Check($value){
        $this->_time_check=$value;
        return $this;
    }
    public function getTime_Check(){return $this->_time_check;}
    
    public function setStatus_And_Test_Results($value){
        $this->_status_and_test_results=$value;
        return $this;
    }
    public function getStatus_And_Test_Results(){return $this->_status_and_test_results;}
    
    public function setProcessing_Results($value){
        $this->_processing_results=$value;
        return $this;
    }
    public function getProcessing_Results(){return $this->_processing_results;}
    
    public function setSignature($value){
        $this->_signature=$value;
        return $this;
    }
    public function getSignature(){return $this->_signature;}
    
    public function setId_Info_Schedule_Check($value){
        $this->_id_info_schedule_check=$value;
        return $this;
    }
    public function getId_Info_Schedule_Check(){return $this->_id_info_schedule_check;}
   
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
class Model_DbTable_Doc_Diary extends Zend_Db_Table_Abstract
{
    protected $_name = "doc_diary";
    protected $_primary = "id";
}
class Model_Doc_DiaryMapperBase extends BaseMapper{
     protected $_dbTable;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway doc_diary");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Model_DbTable_Doc_Diary");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Doc_Diary $entry){
        $data = array(
                'id' => $entry->getId(),
                'date_diary'=> $entry->getDate_Diary(),  
                'implementers'=>$entry->getImplementers(),
                'position'=>$entry->getPosition(),
                'content_inspection'=>$entry->getContent_Inspection(),
                'time_check'=>$entry->getTime_Check(),
                'status_and_test_results'=>$entry->getStatus_And_Test_Results(),
                'processing_results'=>$entry->getProcessing_Results(),
                'signature'=>$entry->getSignature(),
                'id_info_schedule_check'=>$entry->getId_Info_Schedule_Check(),
                           
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
    public function find($id, Model_Doc_Diary $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
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
               
    }
    
    public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
            $entry = new Model_Model_Doc_Diary();
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
            $entry = new Model_Model_Doc_Diary();
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
            $entries[] = $entry;
        }
        return $entries;
    }
   
}