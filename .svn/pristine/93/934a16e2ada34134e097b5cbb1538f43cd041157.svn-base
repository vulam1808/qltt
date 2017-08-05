<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "BaseMapper.php";
class Model_MasterDistrictBase {
    protected $_id;
    protected $_code;
    protected $_name;
    protected $_master_province_id;
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
            throw new Exception("Invalid Admin property");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Admin property");
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
    
    public function setCode($value){
        $this->_code=$value;
        return $this;
    }
    public function getCode(){return $this->_code;}
     public function setId($value){
        $this->_id=$value;
        return $this;
    }
    public function getId(){return $this->_id;}
    public function setName($value){
        $this->_name=$value;
        return $this;
    }
    public function getName(){return $this->_name;}
    public function setMaster_province_Id($value){
        $this->_master_province_id=$value;
        return $this;
    }
    public function getMaster_province_Id(){return $this->_master_province_id;}
     public function setCreated_date($value){
        $this->_created_date=$value;
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
class Model_DbTable_MasterDistrict extends Zend_Db_Table_Abstract
{
    protected $_name = "master_district";
    protected $_primary = "id";
}
class Model_MasterDistrictMapperBase extends BaseMapper{
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
            $this->setDbTable("Model_DbTable_MasterDistrict");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_MasterDistrict $entry){
        $data = array(
                'id' => $entry->getId(),
                'code' => $entry->getCode(),
                'name'=> $entry->getName(),
                'master_province_id'=> $entry->getMaster_province_Id(),
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
    
      public function find($id, Model_MasterDistrict $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return null;
        }
        $row=$result->current();
        $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setMaster_province_Id($row->master_province_id)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);
    }
    public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
            $entry = new Model_MasterDistrict();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setMaster_province_Id($row->master_province_id)
                ->setIs_delete($row->is_delete)
                ->setComment($row->comment);
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
		$queryTotal = "SELECT count(*) as totals FROM master_district ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM master_district ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_District();
            $entry->setId($row->id)
                 ->setId($row->id)
                ->setCode($row->code)
                ->setName($row->name)
                ->setCreated_date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setMaster_province_Id($row->master_province_id)
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
				$html .= '<option value="'.$item->getId().'"  selected="selected">'.$item->getName().'</option>';
			}else{
				$html .= '<option value="'.$item->getId().'">'.$item->getName().'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
}
