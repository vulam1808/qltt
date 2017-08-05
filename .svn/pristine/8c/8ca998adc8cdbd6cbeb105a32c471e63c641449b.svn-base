<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "BaseMapper.php";
class Model_Type_CriteriaBase {
    protected $_id;
    protected $_name;
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
    
  
  

}
class Model_DbTable_Type_Criteria extends Zend_Db_Table_Abstract
{
    protected $_name = "type_criteria";
    protected $_primary = "id";
}
class Model_Type_CriteriaMapperBase extends BaseMapper{
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
            $this->setDbTable("Model_DbTable_Type_Criteria");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Type_Criteria $entry){
        $data = array(
                'id' => $entry->getId(),
                'name'=> $entry->getName()                      
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
    
    public function find($id,  Model_Admin $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
        $entry->setId($row->id)
                ->setId($row->id)
                ->setUserName($row->user_name)
                ->setPassword($row->password)
                ->setFirst_Name($row->first_name)
                ->setLast_Name($row->last_name)
                ->setPhone($row->phone)
                ->setCreated($row->created)
                ->setCreated_By($row->created_by)
                ->setModified($row->modified)
                ->setModified_By($row->modified_by)
                ->setBirthday($row->birthday)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setEmail($row->email)
                ->setAdmin_Group_Id($row->admin_group_id);
    }
    
    public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
            $entry = new Model_Admin();
            $entry->setId($row->id)
                   ->setId($row->id)
                    ->setUserName($row->user_name)
                    ->setPassword($row->password)
                    ->setFirst_Name($row->first_name)
                    ->setLast_Name($row->last_name)
                    ->setPhone($row->phone)
                    ->setCreated($row->created)
                    ->setCreated_By($row->created_by)
                    ->setModified($row->modified)
                    ->setModified_By($row->modified_by)
                    ->setBirthday($row->birthday)
                    ->setOrder($row->order)
                    ->setStatus($row->status)
                    ->setEmail($row->email)
                    ->setAdmin_Group_Id($row->admin_group_id);
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
		$queryTotal = "SELECT count(*) as totals FROM admin ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM admin ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_Admin();
            $entry->setId($row->id)
                ->setId($row->id)
                ->setUserName($row->user_name)
                ->setPassword($row->password)
                ->setFirst_Name($row->first_name)
                ->setLast_Name($row->last_name)
                ->setPhone($row->phone)
                ->setCreated($row->created)
                ->setCreated_By($row->created_by)
                ->setModified($row->modified)
                ->setModified_By($row->modified_by)
                ->setBirthday($row->birthday)
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setEmail($row->email)
                ->setAdmin_Group_Id($row->admin_group_id);
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
