<?php
include_once "BaseMapper.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsBase
 *
 * @author Vu
 */
class Model_NewsBase {
    //put your code here
    protected $_id;
    protected $_title;
    protected $_description;
    protected $_created;
    protected $_created_by;
    protected $_modified;
    protected $_modified_by;
    protected $_status;
    protected $_content;
    protected $_event;
    protected $_news_cat_id;
    
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
            throw new Exception("Invalid News property");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid News property");
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
    
    public function setTitle($value){
        $this->_title=$value;
        return $this;
    }
    public function getTitle(){return $this->_title;}
    
    public function setDescription($value){
        $this->_description=$value;
        return $this;
    }
    public function getDescription(){return $this->_description;}
    
    public function setContent($value){
        $this->_content=$value;
        return $this;
    }
    public function getContent(){
        return $this->_content;
    }
    
    public function setCreated($value){
        $this->_created=$value;
        return $this;
    }
    public function getCreated(){return $this->_created;}
    
    public function setCreated_By($value){
        $this->_created_by=$value;
        return $this;
    }
    public function getCreated_By(){return $this->_created_by;}

    public function setModified($value){
        $this->_modified=$value;
        return $this;
    }
    public function getModified(){return $this->_modified;}
    
    public function setModified_By($value){
        $this->_modified_by=$value;
        return $this;
    }
    public function getModified_By(){return $this->_modified_by;}
    
    public function setStatus($value){
        $this->_status=$value;
        return $this;
    }
    public function getStatus(){return $this->_status;}
    
    public function setEvent($value){
        $this->_event=$value;
        return $this;
    }
    public function getEvent(){return $this->_event;}
    
    public function setNews_Cat_Id($value){
        $this->_news_cat_id=$value;
        return $this;
    }
    public function getNews_Cat_Id(){return $this->_news_cat_id;}
    
}
class Model_DbTable_News extends Zend_Db_Table_Abstract{
    protected $_name="news";
    protected $_primary="id";
}
class Model_NewsMapperBase extends BaseMapper{
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
            $this->setDbTable("Model_DbTable_News");
        }
        return $this->_dbTable;
    }
     public function save(Model_News $entry){
        $data = array(
                'id' => $entry->getId(),
                'title'=>$entry->getTitle(),
                'description'=>$entry->getDescription(),
                'created'=>$entry->getCreated(),
                'created_by'=>$entry->getCreated_By(),
                'modified'=>$entry->getModified(),
                'modified_by'=>$entry->getModified_By(),
                'event'=>$entry->getEvent(),
                'content'=>$entry->getContent(),
                'status'=>$entry->getStatus(),
                'news_cat_id'=>$entry->getNews_Cat_Id()
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
    public function find($id, Model_News $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
        $entry->setId($row->id)
                ->setId($row->id)
                ->setTitle($row->title)
                ->setCreated($row->created)
                ->setCreated_By($row->created_by)
                ->setModified($row->modified)
                ->setModified_By($row->modified_by)
                ->setDescription($row->description)
                ->setContent($row->content)
                ->setEvent($row->event)
                ->setStatus($row->status)
                ->setNews_Cat_Id($row->news_cat_id);
    }
     public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
            $entry = new Model_News();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setTitle($row->title)
                ->setCreated($row->created)
                ->setCreated_By($row->created_by)
                ->setModified($row->modified)
                ->setModified_By($row->modified_by)
                ->setDescription($row->description)
                ->setContent($row->content)
                ->setEvent($row->event)
                ->setStatus($row->status)
                ->setNews_Cat_Id($row->news_cat_id);
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
		$queryTotal = "SELECT count(*) as totals FROM news ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM news ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_News();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setTitle($row->title)
                ->setCreated($row->created)
                ->setCreated_By($row->created_by)
                ->setModified($row->modified)
                ->setModified_By($row->modified_by)
                ->setDescription($row->description)
                ->setContent($row->content)
                ->setEvent($row->event)
                ->setStatus($row->status)
                ->setNews_Cat_Id($row->news_cat_id);
            $entries[] = $entry;
        }
        return $entries;
    }
}
