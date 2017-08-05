<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "BaseMapper.php";
class Model_AdminBase {
    protected $_id;
    protected $_username;
    protected $_password;
    protected $_phone;
    protected $_email;
    protected $_first_name;
    protected $_last_name;
    protected $_created;
    protected $_create_by;
    protected $_modified;
    protected $_modified_by;
    protected $_status;
    protected $_order;
    protected $_birthday;
    protected $_admin_group_id;
    protected $_departments_id;


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
    
    public function setUserName($value){
        $this->_username=$value;
        return $this;
    }
    public function getUserName(){return $this->_username;}
    
    public function setPassword($value){
        $this->_password=$value;
        return $this;
    }
    public function getPassword(){return $this->_password;}
    
    public function setFirst_Name($value){
        $this->_first_name=$value;
        return $this;
    }
    public function getFirst_Name(){return $this->_first_name;}
    
    public function setLast_Name($value){
        $this->_last_name=$value;
        return $this;
    }
    public function getLast_Name(){return $this->_last_name;}
    
    public function setBirthday($value){
        $this->_birthday=$value;
        return $this;
    }
    public function getBirthday(){return $this->_birthday;}
    
    public function setCreated($value) {
        $this->_created=$value;
        return $this;
    }
    public function getCreated(){return $this->_created;}
    
    public function setCreated_By($value) {
        $this->_create_by = $value;
        return $this;
    }
    public function getCreated_By(){return $this->_create_by;}
    
    public function setModified($value) {
        $this->_modified = $value;
        return $this;
    }
    public function getModified() {return $this->_modified;}
    
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
    
    public function setPhone($value){
        $this->_phone=$value;
        return $this;
    }
    public function getPhone(){return $this->_phone;}
    
    public function setEmail($value){
        $this->_email=$value;
        return $this;
    }
    public function getEmail(){return $this->_email;}
    
    public function setAdmin_Group_Id($value) {
            $this->_admin_group_id = $value;
            return $this;
        }

    public function getAdmin_Group_Id() {
            return $this->_admin_group_id;
        }
    public function setDepartments_Id($value){
        $this->_departments_id=$value;
    }
    public function getDepartments_Id(){
        return$this->_departments_id;
    }

}
class Model_DbTable_Admin extends Zend_Db_Table_Abstract
{
    protected $_name = "admin";
    protected $_primary = "id";
}
class Model_AdminMapperBase extends BaseMapper{
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
            $this->setDbTable("Model_DbTable_Admin");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Admin $entry){
        $data = array(
                'id' => $entry->getId(),
                'user_name'=> $entry->getUserName(),
                'password' => $entry->getPassword(),
                'phone'=>$entry->getPhone(),
                'first_name'=>$entry->getFirst_Name(),
                'last_name'=>$entry->getLast_Name(),
                'created'=>$entry->getCreated(),
                'created_by'=>$entry->getCreated_By(),
                'modified'=>$entry->getModified(),
                'modified_by'=>$entry->getModified_By(),
                'order'=>$entry->getOrder(),
                'status'=>$entry->getStatus(),
                'birthday'=>$entry->getBirthday(),
                'email'=>$entry->getEmail(),
                'admin_group_id'=>$entry->getAdmin_Group_Id(),
                'departments_id'=>$entry->getDepartments_Id()
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
                ->setAdmin_Group_Id($row->admin_group_id)
                ->setDepartments_Id($row->departments_id);
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
                    ->setAdmin_Group_Id($row->admin_group_id)
                    ->setDepartments_Id($row->departments_id);
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
                ->setAdmin_Group_Id($row->admin_group_id)
                ->setDepartments_Id($row->departments_id)    ;
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
