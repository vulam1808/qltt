<?php
include_once "BaseMapper.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Sys_UserBase{
    protected $_id;
    protected $_username;
    protected $_password;
    protected $_email;    
    protected $_cellphone;
    protected $_first_name;
    protected $_last_name;
    protected $_birthday;
    protected $_sys_department_id;
    protected $_is_leader;
    protected $_sys_user_group_id; 
    protected $_master_province_id; 
    protected $_master_district_id; 
    protected $_master_ward_id;
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
            throw new Exception("Invalid Sys_User property");   
        }   
        $this->$method($value);   
    }   
    public function __get($name)
    {
        $method = "get" . $name;
        if (("mapper" == $name) || !method_exists($this, $method)) {
            throw new Exception("Invalid Sys_User property");
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
     public function setEmail($value){
        $this->_email=$value;
        return $this;
    }
    public function getEmail(){return $this->_email;}
    
     public function setCellPhone($value){
        $this->_cellphone=$value;
        return $this;
    }
    public function getCellPhone(){return $this->_cellphone;}
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
    
    public function setSys_Department_Id($value){
        $this->_sys_department_id=$value;
        return $this;
    }
    public function getSys_Department_Id(){return $this->_sys_department_id;}
     public function setMaster_Province_Id($value){
        $this->_master_province_id=$value;
        return $this;
    }
    public function getMaster_Province_Id(){return $this->_master_province_id;}
     public function setMaster_District_Id($value){
        $this->_master_district_id=$value;
        return $this;
    }
    public function getMaster_District_Id(){return $this->_master_district_id;}
     public function setMaster_Ward_Id($value){
        $this->_master_ward_id=$value;
        return $this;
    }
    public function getMaster_Ward_Id(){return $this->_master_ward_id;}
    public function setIs_Leader($value){
        $this->_is_leader=$value;
        return $this;
    }
    public function getIs_Leader(){return $this->_is_leader;}
     public function setSys_User_Group_Id($value){
        $this->_sys_user_group_id=$value;
        return $this;
    }
    public function getSys_User_Group_Id(){return $this->_sys_user_group_id;}
    
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
class Model_DbTable_Sys_User extends Zend_Db_Table_Abstract
{
    protected $_name = "sys_user";
    protected $_primary = "id";
}
class Model_Sys_UserMapperBase extends BaseMapper{
     protected $_dbTable;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway sys_usered");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Model_DbTable_Sys_User");
        }
        return $this->_dbTable;
    }
    
    public function save(Model_Sys_User $entry){
        $data = array(
                'id' => $entry->getId(),
                'username'=> $entry->getUserName(),
                'password' => $entry->getPassword(),
                'cellphone'=>$entry->getCellPhone(),
                'email'=>$entry->getEmail(),
                'first_name'=>$entry->getFirst_Name(),
                'last_name'=>$entry->getLast_Name(),
                'birthday'=>$entry->getBirthday(),
                'sys_department_id'=>$entry->getSys_Department_Id(),
                'master_province_id'=>$entry->getMaster_Province_Id(),
                'master_district_id'=>$entry->getMaster_District_Id(),
                'master_ward_id'=>$entry->getMaster_Ward_Id(),
                'is_leader'=>$entry->getIs_Leader(),
                'sys_user_group_id'=>$entry->getSys_User_Group_Id(),
                'created_date'=>$entry->getCreated_Date(),
                'created_by'=>$entry->getCreated_By(),
                'modified_date'=>$entry->getModified_Date(),
                'modified_by'=>$entry->getModified_By(),
                'order'=>$entry->getOrder(),
                'status'=>$entry->getStatus(),
                //'is_delete'=>$entry->getIs_Delete(),
                'comment'=>$entry->getComment()
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
    
    public function find($id,  Model_Sys_User $entry){
        $result = $this->getDbTable()->find($id);
        if(0== count($result))
        {
            return;
        }
        $row=$result->current();
        $entry->setId($row->id)
                ->setId($row->id)
                ->setUserName($row->username)
                ->setPassword($row->password)
                ->setCellPhone($row->cellphone)
                ->setEmail($row->email)
                ->setFirst_Name($row->first_name)
                ->setLast_Name($row->last_name)
                ->setBirthday($row->birthday)
                ->setSys_Department_Id($row->sys_department_id)
                ->setMaster_Province_Id($row->master_province_id)
                ->setMaster_District_Id($row->master_district_id)
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setIs_Leader($row->is_leader)
                ->setSys_User_Group_Id($row->sys_user_group_id)
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)
                ->setIs_Delete($row->is_delete)
                ->setOrder($row->order)
                ->setComment($row->comment)
                ->setStatus($row->status);
               
    }
    
    public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($result as $row){
            $entry = new Model_Sys_User();
            $entry->setId($row->id)
                   ->setId($row->id)
                    ->setUserName($row->username)
                    ->setPassword($row->password)
                    ->setCellPhone($row->cellphone)
                    ->setEmail($row->email)
                    ->setFirst_Name($row->first_name)
                    ->setLast_Name($row->last_name)
                    ->setBirthday($row->birthday)
                    ->setSys_Department_Id($row->sys_department_id)
                    ->setMaster_Province_Id($row->master_province_id)
                    ->setMaster_District_Id($row->master_district_id)
                    ->setMaster_Ward_Id($row->master_ward_id)
                    ->setIs_Leader($row->is_leader)
                    ->setSys_User_Group_Id($row->sys_user_group_id)
                    ->setCreated_Date($row->created_date)
                    ->setCreated_By($row->created_by)
                    ->setModified_Date($row->modified_date)
                    ->setModified_By($row->modified_by)
                    ->setComment($row->comment)
                    ->setIs_Delete($row->is_delete)
                    ->setOrder($row->order)
                    ->setStatus($row->status);
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
		$queryTotal = "SELECT count(*) as totals FROM sys_user ".$sFilter."";
		$totalRecord = $this->getTotalRecords($queryTotal, $aFilterValues);
		$query = "SELECT * FROM sys_user ".$sFilter." order by ".$orderBy." ".$orderDirection." limit ".($page-1)*$pageSize.",".$pageSize."";
        $stmt = $db->query($query, $aFilterValues);		
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries   = array();
        foreach ($rows as $row) {
            $entry = new Model_Sys_User();
            $entry->setId($row->id)
               ->setId($row->id)
                ->setUserName($row->username)
                ->setPassword($row->password)
                ->setPhone($row->cellphone)
                ->setEmail($row->email)
                ->setFirst_Name($row->first_name)
                ->setLast_Name($row->last_name)
                ->setBirthday($row->birthday)
                ->setSys_Department_Id($row->sys_department_id)
                ->setMaster_Province_Id($row->master_province_id)
                ->setMaster_District_Id($row->master_district_id)
                ->setMaster_Ward_Id($row->master_ward_id)
                ->setIs_Leader($row->is_leader)
                ->setSys_User_Group_Id($row->sys_user_group_id)
                ->setCreated($row->created)
                ->setCreated_By($row->created_by)
                ->setModified($row->modified)
                ->setModified_By($row->modified_by)
                ->setComment($row->comment)
                ->setIs_Delete($row->is_delete)
                ->setOrder($row->order)
                ->setStatus($row->status);
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