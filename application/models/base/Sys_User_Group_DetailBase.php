<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "BaseMapper.php";
class Model_Sys_User_Group_DetailBase {
    protected $_id;
    protected $_sys_user_group_id;
    protected $_sys_privileges;   
    protected $_created_date;
    protected $_create_by;
    protected $_modified_date;
    protected $_modified_by;
    protected $_status;
    protected $_order;
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
            throw new Exception("Invalid Sys_User_Group_Detail property");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Sys_User_Group_Detail property");
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
    
    public function setSys_User_Group_Id($value){
        $this->_sys_user_group_id=$value;
        return $this;
    }
    public function getSys_User_Group_Id(){return $this->_sys_user_group_id;}
    
    public function setSys_Privileges($value){
        $this->_sys_privileges=$value;
        return $this;
    }
    public function getSys_Privileges(){return $this->_sys_privileges;} 
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
class Model_DbTable_Sys_User_Group_Detail extends Zend_Db_Table_Abstract
{
    protected $_name = "sys_user_group_detail";
    protected $_primary = "id";
}
class Model_Sys_User_Group_DetailMapperBase extends BaseMapper{
     protected $_dbTable;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway Sys_User_Group_Detailed");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Model_DbTable_Sys_User_Group_Detail");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Sys_User_Group_Detail $entry){
        $data = array(
                'id' => $entry->getId(),
                'sys_user_group_id'=> $entry->getSys_User_Group_Id(),
                'sys_privileges' => $entry->getSys_Privileges(),                
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
    
    public function find($id,  Model_Sys_User_Group_Detail $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
        $entry->setId($row->id)
                ->setId($row->id)
                ->setSys_User_Group_Id($row->sys_user_group_id)
                ->setSys_Privileges($row->sys_privileges)               
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
            $entry = new Model_Sys_User_Group_Detail();
            $entry->setId($row->id)
                   ->setId($row->id)
                    ->setSys_User_Group_Id($row->sys_user_group_id)
                    ->setSys_Privileges($row->sys_privileges)               
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
		$queryTotal = "SELECT count(*) as totals FROM Sys_User_Group_Detail ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM Sys_User_Group_Detail ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_Admin();
            $entry->setId($row->id)
                    ->setId($row->id)
                    ->setSys_User_Group_Id($row->sys_user_group_id)
                    ->setSys_Privileges($row->sys_privileges)               
                    ->setCreated($row->created)
                    ->setCreated_By($row->created_by)
                    ->setModified($row->modified)
                    ->setModified_By($row->modified_by)                    
                    ->setOrder($row->order)
                    ->setStatus($row->status)
                    ->setComment($row->comment)
                    ->setIs_Delete($row->is_delete);
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
