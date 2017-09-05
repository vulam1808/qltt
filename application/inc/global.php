<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GlobalLib{
     const _DN       = 'DoanhNghiep';
     const _DNNDB      = 'DoanhNghiepNgoaiDiaBan';
     const _HKD       = 'HoKinhDoanh';
     const _TTHH      = 'TichThuHangHoa';
     const _XLVP      = 'XuLyViPham'; 
     const _TG      = 'TamGiu'; 
     const _VOCHU   = 'VoChu';
     const _KHONGXACDINH = 'KhongXacDinh';
    
    
    public static function getSiteUrl(){
        return self::getSiteConfig('url');
    }
    

    public static function getImageUrl(){
        return self::getSiteConfig('image_url');
    }
    
    public static function getSiteConfig($key) {
        $registry = Zend_Registry::getInstance();
        $siteConfig = $registry->get('site');
        return $siteConfig[$key];
    }
    public static function createOrderNo() {
        return date('Ymd') . time();
    }
    public static function query($query, $whereData = NULL) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $stmt = $db->query($query, $whereData);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        return $items;
    }
    public static function viewDate($date, $showTime = false) {
        if (empty($date) || trim($date) == '')
            return '';
        $format = '';
        if ($showTime == true) {
            $format = GlobalLib::getSiteConfig('datetimeformat');
        } else {
            $format = GlobalLib::getSiteConfig('dateformat');
        }
        return date($format, strtotime($date));
    }

    public static function getJsDateFormat() {
        return GlobalLib::getSiteConfig('jsdateformat');
    }

    public static function toMysqlDate($jsDate) {
        $jsDateFormat = GlobalLib::getSiteConfig('jsdateformat');
        $d = '';
        $m = '';
        $y = '';
        switch ($jsDateFormat) {
            case 'dd-mm-yy':
                list($d, $m, $y) = explode('-', $jsDate);
                break;
        }
        return mktime(0, 0, 0, $m, $d, $y);
    }

    public static function toMysqlDateString($jsDate) {
        if (empty($jsDate) || trim($jsDate) == '')
            return '';
        $jsDateFormat = GlobalLib::getSiteConfig('jsdateformat');
        $d = '';
        $m = '';
        $y = '';

        switch ($jsDateFormat) {
            case 'dd-mm-yy':
                list($d, $m, $y) = explode('-', $jsDate);
                break;
            case 'dd/mm/yy':
                list($d, $m, $y) = explode('/', $jsDate);
                break;
            case 'yy/mm/dd':
                list($y, $m, $d) = explode('/', $jsDate);
                break;
        }
        return $y . '-' . $m . '-' . $d;
    }

    public static function fetchAllReferTable($tableName, $valueColumn, $textColumn) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . '';
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $results = array();
        foreach ($items as $item) {
            $results[$item[$valueColumn]] = $item[$textColumn];
        }
        $results[0] = '';
        return $results;
    }        
    
    public static function getComboByForeignKey($fieldName, $tableName, $valueColumn,$foreignkeyColumn, $textColumn, $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT '.$foreignkeyColumn.',' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } 
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $html .= '<option value="0">Chưa lựa chọn</option>';
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';       
        return $html;
    }            
    public static function getCombo($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } 
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $html .= '<option value="0" >'.$zeroValueName.'</option>';
        
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option  value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';       
        return $html;
    }
      public static function getComboSchedule($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } 
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
//        $html .= '<option value="0" >'.$zeroValueName.'</option>';
        
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option  value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';       
        return $html;
    }
    public static function getComboTitle($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue,$title, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ',' .$title. ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } 
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $html .= '<option value="0" >'.$zeroValueName.'</option>';
        
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option title="'.$item[$title].'" value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';       
        return $html;
    }
     public static function getComboSeclect($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn .  ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } 
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $html .= '<option value="0">'.$zeroValueName.'</option>';
        
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option  value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';       
        return $html;
    }
    
     public static function getComboSeclectTitle($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue,$title, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn .  ',' .$title. ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } 
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $html .= '<option value="0">'.$zeroValueName.'</option>';
        
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option title="'.$item[$title].'" value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';       
        return $html;
    }
    public static function getComboSeclectTitlee($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue,$title, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn .  ',' .$title. ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } 
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $html .= '<option value="0">'.$zeroValueName.'</option>';
        
        foreach ($items as $item) {
            $selected = '';$flag = 0;
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            /********************/
                $query1 = 'select id,master_print_id,status from doc_print_create where master_print_id='.$item[$valueColumn].'';
                $stmt1 = $db->query($query1);
                $items1 = $stmt1->fetchAll(); //PDO::FETCH_CLASS);
                $stmt1->closeCursor();
                 foreach ($items1 as $item1) {
                     if(($item1['status']=="RECOVERY")||($item1['status']=="")){
                         $flag=1;
                     }
                 }
            /********************/
            if($flag == 1){     
            $html .= '<option title="'.$item[$title].'" value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
            }
            
        }
        $html .= '</select>';       
        return $html;
    }
    //P: dropdownlist and set multi selected
    //   $defaultValue: string    2,4,5
    public static function getComboMulti($fieldName, $tableName, $valueColumn, $textColumn,$textColumn1=NULL, $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        if($textColumn1 ==NULL){
            $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        } else {
          $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ','.$textColumn1. ' from ' . $tableName . ' '.$filters.' '.$orderBys;  
        }
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
            $html = '<select id="' . $fieldName . '" name="' . $fieldName . '[]" ' . $multiSelectHTML .' '.$onclick .'>';
        } 
        
        $html .= $html1;
//        $html .= '<option value="0">'.$zeroValueName.'</option>';        
        foreach ($items as $item) {
            $selected = '';
            if (in_array($item[$valueColumn], explode(',', $defaultValue)))
                $selected = ' selected="selected"';
            if($textColumn1==NULL){
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
            } else {
                 $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]).' - '.str_replace("'", "\'", $item[$textColumn1]) . '</option>';
            }
        }
        $html .= '</select>';       
        return $html;
    }
    public static function getComboByList($fieldName,$value, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '') {
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect)
        {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value=""></option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML . '>';
        $html .= $html1;
        $item = explode(';',$value);
        $countItems = count($item);
        for($i=0;$i<$countItems;$i++) {
            $selected = '';
            if ($defaultValue == $item[$i])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$i] . '" ' . $selected .'>' . $item[$i] . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
   
    public static function getComboByNumber($fieldName,$value, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '') {
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML . '>';
        $html .= $html1;
        for($i=1;$i<=intval($value);$i++) {
            $selected = '';
            if ($defaultValue == $i)
                $selected = ' selected="selected"';
            $html .= '<option value="' . $i . '" ' . $selected .'>' . $i . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public static function getComboByArea($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">Khu vực</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
     public static function getComboByProvince($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='', $zeroValueName='Tỉnh thành') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">'.$zeroValueName.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public static function getComboByDepartment($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='', $zeroValueName='Phòng ban') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">'.$zeroValueName.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
     public static function getComboByMasterPrint($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = true, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='', $zeroValueName='Chọn tên ấn chỉ') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">'.$zeroValueName.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public static function getComboByUser($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='', $zeroValueName='chọn gười dùng') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">'.$zeroValueName.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public static function getPrint($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='', $zeroValueName='chọn gười dùng') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">'.$zeroValueName.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
     public static function getComboByAgent($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ', address from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">Đại Lý/Cửa hàng</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) .' - '.str_replace("'", "\'", $item['address']). '</option>';
        }
        $html .= '</select>';
        return $html;
    }
   public static function getComboByProductCategory($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">Nhóm Sản phẩm</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public static function getComboByProduct($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">Sản phẩm</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
  
    public static function getComboByDistrict($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">Quận Huyện</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
     public static function getComboByWard($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">Xã phường</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public static function getComboByPrintSerial($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = true, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">Chọn Serial cho ấn chỉ</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public static function getName($tableName, $valueColumn, $textColumn){
        if(empty($valueColumn))
        {
            return '';
        }
        if(strpos($valueColumn,',') !== false)
        {
            $strArray = explode(",",$valueColumn);
            $rs = "";
            for ($i = 0; $i < count($strArray) ; $i ++)
            {
                $strValue = $strArray[$i];
                $strValue = trim($strValue);
                $db = Zend_Db_Table::getDefaultAdapter();
                $query = 'SELECT '.$strValue.','.$textColumn . ' from ' . $tableName . ' where id= '. $strValue.'';
                $stmt = $db->query($query);
                $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
                $stmt->closeCursor();
                $results = array();
                foreach ($items as $item) {
                    $results[$item[$strValue]] = $item[$textColumn];
                    if(empty($rs))
                    {
                         $rs = $results[$strValue]; 
                    }
                    else
                    {
                        $rs = $rs.", ".$results[$strValue]; 
                    }
                }
            }
            return $rs;
        }
        else
        {
             $db = Zend_Db_Table::getDefaultAdapter();
            $query = 'SELECT '.$valueColumn.','.$textColumn . ' from ' . $tableName . ' where id= '. $valueColumn.'';
            $stmt = $db->query($query);
            $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
            $stmt->closeCursor();
            $results = array();
            foreach ($items as $item) {
                $results[$item[$valueColumn]] = $item[$textColumn];
               return $results[$valueColumn]; 
            }
        }
        
        return ''; 
        
    }  
    //
    public static function getName1($tableName, $valueColumn, $textColumn){
        if(empty($valueColumn))
        {
            return '';
        }
        if(strpos($valueColumn,',') !== false)
        {
            $strArray = explode(",",$valueColumn);
            $rs = "";
            for ($i = 0; $i < count($strArray) ; $i ++)
            {
                $strValue = $strArray[$i];
                $strValue = trim($strValue);
                $db = Zend_Db_Table::getDefaultAdapter();
                $query = 'SELECT '.$strValue.','.$textColumn . ' from ' . $tableName . ' where id= '. $strValue.'';
                $stmt = $db->query($query);
                $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
                $stmt->closeCursor();
                $results = array();
                //
                $arrayitemtex = explode(',',$textColumn);
                
                foreach ($items as $item) {
                    $tam ='';
                    if($item[$arrayitemtex[1]]!=''){
                        $tam = $item[$arrayitemtex[1]];
                    }  else {
                        $tam = $item[$arrayitemtex[0]];
                    }
                   // $results[$item[$strValue]] = $item[$arrayitemtex[0]];
                     $results[$item[$strValue]] = $tam;
                    if(empty($rs))
                    {
                         $rs = $results[$strValue]; 
                    }
                    else
                    {
                        $rs = $rs.", ".$results[$strValue]; 
                    }
                }
            }
            return $rs;
        }
        else
        {
             $db = Zend_Db_Table::getDefaultAdapter();
            $query = 'SELECT '.$valueColumn.','.$textColumn . ' from ' . $tableName . ' where id= '. $valueColumn.'';
            $stmt = $db->query($query);
            $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
            $stmt->closeCursor();
             $arrayitemtex = explode(',',$textColumn);
            $results = array();
            foreach ($items as $item) {
                 $tam ='';
                    if($item[$arrayitemtex[1]]!=''){
                        $tam = $item[$arrayitemtex[1]];
                    }  else {
                        $tam = $item[$arrayitemtex[0]];
                    }
                $results[$item[$valueColumn]] =$tam;
               return $results[$valueColumn]; 
            }
        }
        
        return ''; 
        
    }  
    public static function getNameItems($Name){
       if($Name=="condition")
        return "Kinh doanh có điều kiện"; 
       else
        return "Mặt hành kinh doanh hạn chế";
    }  
    
    public static function getNameStatus($Name){
       if($Name=="VoChu")
        return "Hàng vô chủ"; 
       else
        return "Hàng không xác định";
    }  
     public static function getNameBusiness($Name){
       if($Name=="DoanhNghiep")
        return "Doanh nghiệp"; 
       else{
       if($Name=="HoKinhDoanh")
        return "Hộ kinh doanh";
       else{
       if($Name=="DoanhNghiepNgoaiDiaBan") 
        return "Doanh Nghiệp ngoài địa bàn";
       else return "khongtontai";
           }
       }   
     }
      public static function getNameTypeMasterSanction($Name){
       if($Name=="TichThuHangHoa")
        return "Tịch Thu Hàng Hóa"; 
       else
        return "Xử Lý Vi Phạm";
    } 
    public static function getNameStatusHTXL($Name){
       if($Name=="TamGiu"){
        return "Tạm giữ"; 
       }elseif($Name =="TichThuHangHoa"){
        return "Tịch thu";
       }else{
        return "Xử lý vi phạm";   
       } 
    }  
    public static function getUserLoginName() {
        $session = new Zend_Session_Namespace('Zend_Auth_User_Info');
        return $session->userInfo['username'];
    }
    public static function checkUserLogin() {
        $session = new Zend_Session_Namespace('Zend_Auth_User_Info');
        if(empty($session) || empty($session->userInfo)){
           return false;
        }
        return true;
    }
    public static function getPermissionUser() {
        $session = new Zend_Session_Namespace('Zend_Auth_User_Info');
        if(empty($session) || empty($session->userInfo)){
           return $session->userInfo['username'];
        }
        return ;
    }
    public static function getUserLogin() {
        $session = new Zend_Session_Namespace('Zend_Auth_User_Info');
        return $session->userInfo;
    }
    public static function userLogout() {
        $session = new Zend_Session_Namespace('Zend_Auth_User_Info');
        $session->userInfo = NULL;
        unset($session->userInfo);
        unset($session);
    }
    public static function getLoginId() {
        $identity = Zend_Auth::getInstance()->getIdentity();
        if($identity){
            return $identity->id;
        }
        return 0;
    } 
    
    public static function getComboByDocPrintCreate($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT district' . $valueColumn . ',' . $textColumn . ', master_print_id from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">Mã tạo ấn chỉ</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
       
        foreach ($items as $item) {
            $selected = '';
            $serial_max="";
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
                $name_print = ""; 
                $name_print = GlobalLib::getName('master_print', $item['master_print_id'], 'name') ;
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $name_print) .' - '.str_replace("'", "\'",$item[$textColumn] ). '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    //Ham ABC
     public static function getComboVersatileSerial($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL,$valuaOption0,$separator, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
           $html1 = '<option value="0">'.$valuaOption0.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $tringTextColumn=$textColumn;
        $arrayTextColumn= explode(',', $tringTextColumn);      
       
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
                $tringTextColumnValue=''; $dem = 0;
            for($i = 0;$i<2;$i++){
                if($dem == 0){
                     $html1=  str_replace("'","\'", $item[$arrayTextColumn[$i]]).$separator; 
                }  else {
                    $tam ='';
                    if($item[$arrayTextColumn[2]]!=''){
                        $tam = $item[$arrayTextColumn[2]];
                    }  else {
                        $tam = $item[$arrayTextColumn[1]];
                    }
                    $html1=  str_replace("'","\'", $tam).' ';
                }
                $dem++;
                $tringTextColumnValue.= $html1;
            } 
            //cat bo dau o sau di
            $tringTextColumnValue=  substr($tringTextColumnValue,0, strlen($tringTextColumnValue)-1);
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . $tringTextColumnValue. '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    //Ham CB
      public static function getComboVersatile($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL,$valuaOption0,$separator, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
           $html1 = '<option value="0">'.$valuaOption0.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $tringTextColumn=$textColumn;
        $arrayTextColumn= explode(',', $tringTextColumn);      
       
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
                $tringTextColumnValue=''; $dem = 0;
            foreach ($arrayTextColumn as $value) {   
                if($dem == 0){
                     $html1=  str_replace("'","\'", $item[$value]).$separator; 
                }  else {
                    $html1=  str_replace("'","\'", $item[$value]).' ';
                }
                $dem++;
                $tringTextColumnValue.= $html1;
            }
            //cat bo dau o sau di
            $tringTextColumnValue=  substr($tringTextColumnValue,0, strlen($tringTextColumnValue)-1);
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . $tringTextColumnValue. '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    
    //
     //Ham CB
      public static function getComboVersatilee($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL,$valuaOption0,$separator, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
           $html1 = '<option value="0">'.$valuaOption0.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $tringTextColumn=$textColumn;
        $arrayTextColumn= explode(',', $tringTextColumn);      
       
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
                $tringTextColumnValue=''; $dem = 0;
            foreach ($arrayTextColumn as $value) {   
                if($dem == 0){
                    $html1=  str_replace("'","\'","(".GlobalLib::getNameStatusHTXL($item[$value]).")".$separator); 
                }  else {
                    $html1=  str_replace("'","\'", $item[$value]).' ';
                }
                $dem++;
                $tringTextColumnValue.= $html1;
            }
            //cat bo dau o sau di
            $tringTextColumnValue=  substr($tringTextColumnValue,0, strlen($tringTextColumnValue)-1);
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . $tringTextColumnValue. '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public static function getComboMasterPrint($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL,$valuaOption0,$separator, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
           $html1 = '<option value="0">'.$valuaOption0.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $tringTextColumn=$textColumn;
        $arrayTextColumn= explode(',', $tringTextColumn);      
       
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
                $tringTextColumnValue=''; $dem = 0;
            foreach ($arrayTextColumn as $value) {   
                if($dem == 0){
                     $html1=  str_replace("'","\'", $item[$value]).$separator; 
                }  else {
                    $html1=  str_replace("'","\'", $item[$value]).' ';
                }
                $dem++;
                $tringTextColumnValue.= $html1;
            }
            //cat bo dau o sau di
            $tringTextColumnValue=  substr($tringTextColumnValue,0, strlen($tringTextColumnValue)-1);
            $tringTextColumnValue= GlobalLib::getName("master_print",$tringTextColumnValue,"code");
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . $tringTextColumnValue. '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public static function getComboDocPrintCreate($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL,$valuaOption0,$separator, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
           $html1 = '<option value="0">'.$valuaOption0.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $tringTextColumn=$textColumn;
        $arrayTextColumn= explode(',', $tringTextColumn);      
       
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
                $tringTextColumnValue=''; $dem = 0;
            foreach ($arrayTextColumn as $value) {   
                if($dem == 0){
                     $html1=  str_replace("'","\'", $item[$value]).$separator; 
                }  else {
                    $html1=  str_replace("'","\'", $item[$value]).' ';
                }
                $dem++;
                $tringTextColumnValue.= $html1;
            }
            //cat bo dau o sau di
            $tringTextColumnValue=  substr($tringTextColumnValue,0, strlen($tringTextColumnValue)-1);
            $tringTextColumnValue= GlobalLib::getName("doc_print_create",$tringTextColumnValue,"coefficient");
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . $tringTextColumnValue. '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    //tra ve Id theo code
     public static function getId($tableName,$nameColumn,$valueColumn,$textColumn){        
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT '.$nameColumn.','.$textColumn . ' from ' . $tableName . ' where doc_print_create_id = "'. $valueColumn.'"';       
        $stmt = $db->query($query);
        $items = $stmt->fetchAll();
        $stmt->closeCursor();      
        $results = array();
        foreach ($items as $item) {
            $results[$textColumn] = $item[$textColumn];
        }
        return $results[$textColumn]; 
    } 
    //ham delete dung chung
     public static function delete($table,$column,$id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE ".$table." SET ".$column."='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
    public static function getCombotree($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } 
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $html .= '<option value="0">'.$zeroValueName.'</option>';        
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';       
        return $html;
    }
     public static function returntree($id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT * from sys_department where is_root=1';       
        $stmt = $db->query($query);
        $items = $stmt->fetchAll();
        $stmt->closeCursor();   
        $selected='item-selected=""';
        foreach($items as $item){
            if($item["id"]==$id){$selected='item-selected="true"';}
        echo '<li '.$selected.' item-expanded="true" id='.$item["id"].' value="'.$item["id"].'">'.$item["name"];
        $selected='item-selected=""';
        GlobalLib::dequy($item["id"],$id);   
        echo '</li>';
        }     
    }
    public function dequy($parent_id,$id) {
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT * from sys_department where parent_id='.$parent_id;       
        $stmt = $db->query($query);
        $items = $stmt->fetchAll();
        $stmt->closeCursor(); 
        $selected='item-selected=""';
        echo'<ul>';
        foreach($items as $item){
            if($item["id"]==$id){$selected='item-selected="true"';}
        echo '<li '.$selected.' item-expanded="true" id='.$item["id"].' value="'.$item["id"].'" >'.$item["name"];
        $selected='item-selected=""';
        GlobalLib::dequy($item["id"],$id);
        echo '</li>';
        }
        echo '</ul>';
    }
    public static function getComboInfoBusiness($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='', $zeroValueName='Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">'.$zeroValueName.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
           if($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
            
        }
        $html .= '</select>';
        return $html;
    } 
     public static function getComboInfoBusiness1($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='', $zeroValueName='Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        $showkq = explode(',',$defaultValue);
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">'.$zeroValueName.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            foreach($showkq as $itemkq){
           if($itemkq == $item[$valueColumn])
            $selected = ' selected="selected"';}
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
           
            
        }
        $html .= '</select>';
        return $html;
    }
    public static function getComboInfoBusiness11($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue,$title, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='', $zeroValueName='Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
         $query = 'SELECT ' . $valueColumn . ',' . $textColumn .  ',' .$title. ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        $showkq = explode(',',$defaultValue);
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } else {
            $html1 = '<option value="0">'.$zeroValueName.'</option>';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
            foreach($showkq as $itemkq){
           if($itemkq == $item[$valueColumn])
            $selected = ' selected="selected"';}
             $html .= '<option title="'.$item[$title].'" value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
           
            
        }
        $html .= '</select>';
        return $html;
    }
    
    
     public static function getComboCheckk($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        $showkq = explode(',',$defaultValue);
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        } 
//        else {
//            $html1 = '<option value="0">'.$zeroValueName.'</option>';
//        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        foreach ($items as $item) {
            $selected = '';
             foreach($showkq as $itemkq){
           if($itemkq == $item[$valueColumn])
            $selected = ' selected="selected"';}
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
//    public static function getComboCheck($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue,$title, $multiSelect = false, $cssClass = '', $cssStyle = '', $filters = '', $orderBys = NULL, $onclick='', $zeroValueName='Chưa lựa chọn') {
//        $db = Zend_Db_Table::getDefaultAdapter();
//         $query = 'SELECT ' . $valueColumn . ',' . $textColumn .  ',' .$title. ' from ' . $tableName . ' '.$filters.' '.$orderBys;
//        $stmt = $db->query($query);
//        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
//        $stmt->closeCursor();
//        $multiSelectHTML = '';
//        $html1 = '';
//        $showkq = explode(',',$defaultValue);
//        if ($multiSelect) {
//            $multiSelectHTML = 'multiple="multiple"';
//        } 
////        else {
////            $html1 = '<option value="0">'.$zeroValueName.'</option>';
////        }
//        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" style="' . $cssStyle . '" class="' . $cssClass . '" ' . $multiSelectHTML .' '.$onclick .'>';
//        $html .= $html1;
//        foreach ($items as $item) {
//            $selected = '';
//            foreach($showkq as $itemkq){
//           if($itemkq == $item[$valueColumn])
//            $selected = ' selected="selected"';}
//             $html .= '<option title="'.$item[$title].'" value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
//        }
//        $html .= '</select>';
//        return $html;
//    }
    
    public static function serialMax($strSerial){
      
        if(empty($strSerial))
            return "";
        
          $max = "";
        $entries = array();
        if(strpos($strSerial,',')!== false)
        {
            $array = explode(',', $strSerial);
             for($j=0;$j<count($array);$j++){
                if(strpos($array[$j],'-')!== false)
                {
                    $array1 = explode('-', $array[$j]);
                    for($i=0;$i<count($array1);$i++){
                        $entries[] = $array1[$i];
                    }
                }
                else
                {
                    $entries[] = $array[$j];
                }
            }  
        }
        else
        {
            $array1 = explode('-', $strSerial);
            for($e=0;$e<count($array1);$e++){
                        $entries[] = $array1[$e];
            }
        }
        if(count($entries) > 0)
        {
            $max = $entries[0];
            for($j=0;$j<count($entries);$j++){
                if($entries[$j]>$max){
                    $tam = $max;
                    $max = $entries[$j];
                    $entries[$j] = $tam;
                }
            }
        }
        return $max;
    }
    public static function serialMin($strSerial){
         
        if(empty($strSerial))
            return "";
        
        $min = "";
        $entries = array();
        if(strpos($strSerial,',')!== false)
        {
            $array = explode(',', $strSerial);
             for($j=0;$j<count($array);$j++){
                if(strpos($array[$j],'-')!== false)
                {
                    $array1 = explode('-', $array[$j]);
                    for($i=0;$i<count($array1);$i++){
                        $entries[] = $array1[$i];
                    }
                }
                else
                {
                    $entries[] = $array[$j];
                }
            }  
        }
        else
        {
            $array1 = explode('-', $strSerial);
            for($e=0;$e<count($array1);$e++){
                        $entries[] = $array1[$e];
            }
        }
         if(count($entries) > 0)
        {
            $min = $entries[0];
            for($j=0;$j<count($entries);$j++){
                if($entries[$j]<$min){
                    $tam = $min;
                    $min = $entries[$j];
                    $entries[$j] = $tam;
                }
            }
        }
        return $min;
    }
    
    public static function subtractMaxMin($max,$min){
        $rs = "";
        if((empty($max) || empty($min)))
        {
            return "";
        }
        if($max >=  $min)
        {
            $rs = ($max - $min)+1;
        }
        return $rs;
    }
     public static function subtractSerial($strSerial,$arrayHandling){
         
        if(empty($strSerial))
            return "";
        
     
        $entries = array();
        if(strpos($strSerial,',')!== false)
        {
             $max; $min;
            $array = explode(',', $strSerial);
             for($j=0;$j<count($array);$j++){
                if(strpos($array[$j],'-')!== false)
                {
                     $array1 = explode('-', $array[$j]);
                    if(count($array1) > 2)
                    {
                        $max =intval($array1[0]);
                        $min = intval($array1[1]);
                        for($i=$min;$i<=$max;$i++){
                            $rs = true;
                            for($f=0;$f<count($arrayHandling);$f++){
                                if($arrayHandling[$f]->serial_handing == $i)
                                {
                                    $rs = false;
                                    break;
                                }
                            }
                            if($rs == true)
                            {
                                $entries[] = $i;
                            }
                        }
                    }
                    else
                    {
                        for($i=0;$i<count($array1);$i++){
                            $rs = true;
                            for($f=0;$f<count($arrayHandling);$f++){
                                if($arrayHandling[$f]->serial_handing == $array1[$i])
                                {
                                    $rs = false;
                                    break;
                                }
                            }
                            if($rs == true)
                            {
                                $entries[] = $array1[$i];
                            }
                        }
                    }
                }
                else
                {
                     $rs = true;
                    for($f=0;$f<count($arrayHandling);$f++){
                        if($arrayHandling[$f]->serial_handing == $array[$j])
                        {
                            $rs = false;
                            break;
                        }
                    }
                    if($rs == true)
                    {
                        $entries[] = $array[$j];
                    }
                }
            }  
        }
        else
        {
            if(strpos($strSerial,'-')!== false)
            {
                 $array1 = explode('-', $strSerial);
                if(count($array1) >= 2)
                {
                    $min = intval($array1[0]);
                    $max =intval($array1[1]);
                    
                    for($i=$min;$i<=$max;$i++){
                         $rs = true;
                        for($f=0;$f<count($arrayHandling);$f++){
                            if($arrayHandling[$f]->serial_handing == $i)
                            {
                                $rs = false;
                                break;
                            }
                        }
                        if($rs == true)
                        {
                            $entries[] = $i;
                        }
                    }
                }
                else
                {
                    for($i=0;$i<count($array1);$i++){
                        $rs = true;
                        for($f=0;$f<count($arrayHandling);$f++){
                            if($arrayHandling[$f]->serial_handing == $array1[$i])
                            {
                                $rs = false;
                                break;
                            }
                        }
                        if($rs == true)
                        {
                            $entries[] = $array1[$i];
                        }
                    }
                }
            }
            else
            {
                 $rs = true;
                for($f=0;$f<count($arrayHandling);$f++){
                    if($arrayHandling[$f]->serial_handing == $strSerial)
                    {
                        $rs = false;
                        break;
                    }
                }
                if($rs == true)
                {
                    $entries[] = $strSerial;
                }
            }
        }
        
        return $entries;
    }
     public static function arraySerial($tringserial){
         $array =  array();$i=0;
         $array1 = explode(",", $tringserial);
         if(count($array1)==1){
             $array11 = explode("-", $array1[0]);
             if(count($array11)==1){
                 $array[$i++]= (int)$array11[0];
             }  else {
                 for($j = (int)$array11[0];$j<=(int)$array11[1];$j++){
                     $array[$i++]=$j;
                 }
             }
         }  else {
             foreach ($array1 as $value) {
                 $array2 = explode("-", $value);
                 if(count($array2)==1){
                     $array[$i++]=(int)$array2[0];
                 }  else {
                     for($j = (int)$array2[0];$j<=(int)$array2[1];$j++){
                         $array[$i++]=$j;
                     }
                 }
             }
         }
         return $array;
     }
     //
     public static function ckeckarray($int,$array){
         $a = array();
         $a = $array;$dem = 0;
         for($i = 0 ; $i<count($a);$i++){
             if($a[$i]==$int){
                 $dem= 1;
                 break;
             }
         }
         return $dem;
     }
     //nhap 2 mang lai voi nhau
     public static function mergetwoarrays($array11,$array22){
           $array12 = array();$i=0;
            for($ii = 0;$ii<count($array11);$ii++){
                $array12[$i++]=$array11[$ii];
            }
            if($i==count($array11)){
                for($iii = 0;$iii<count($array22);$iii++){
                    $array12[$i++]= $array22[$iii];
                }
            }
            return $array12;
     }
     //
     public static function arrayserialminus($array1,$array2){
        $array12 = array();$i=0;
        for($ii = 0;$ii<count($array1);$ii++){
            if(GlobalLib::ckeckarray($array1[$ii],$array2)==0){
                $array12[$i++]= $array1[$ii];
            }
        }
        return $array12;
     }
     public static function getCB($Name, $tableName , $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
       
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple" class="form-control"';
        } 
        $html = '<select id="' . $Name . '" name="' . $Name . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $html .= '<option value="0">'.$zeroValueName.'</option>';        
        foreach ($tableName as $item) {
            $selected = '';
            if ($defaultValue == (int)$item)
                $selected = ' selected="selected"';
            $html .= '<option value="' . (int)$item. '" ' . $selected .'>' . str_replace("'", "\'", (int)$item) . '</option>';
        }
        $html .= '</select>';       
        return $html;
    }
    public static function getcombo1($name,$rarrayserial,$default){
     $htmll ='<select id="'.$name.'" >';
     $htmll .= '<option value="0">Chọn serial</option>'; 
    
          foreach ($rarrayserial as $item) {
            $selected = '';
            if ($default == (int)$item)
                $selected = ' selected="selected"';
            $htmll .= '<option value="' . (int)$item. '" ' . $selected .'>' . str_replace("'", "\'", (int)$item) . '</option>';
        }
    
    
        $htmll .= '</select> 
        <input id="selectionlog" style="display: none" name="selectionlog" /> ';
         return $htmll;
    }
    //lay ra day serial da su dung theo cuon
     public static function SerialUsedd($serial,$serialRecover,$serialFail) {
         //lay ra so luong
//                $getSerial ='1-20';
//                $arraySerialRecover = GlobalLib::arraySerial('15-20');
//                $arraySerialFail = GlobalLib::arraySerial('14');
                $getSerial = $serial;
                $arraySerialRecover = GlobalLib::arraySerial($serialRecover);
                $arraySerialFail = GlobalLib::arraySerial($serialFail);
                $arraychuasudung = array();$k=0;
                 //nhap hai mamng lai theo thu tu tang dan
                for($n = 0;$n<count($arraySerialRecover);$n++){
                    $arraychuasudung[$k++] = $arraySerialRecover[$n];
                }
//                if($k=(count($arraySerialRecover))){
//                    if($arraySerialFail[0]!= 0){
//                    for($n = 0;$n<count($arraySerialFail);$n++){
//                        $arraychuasudung[$k++] = $arraySerialFail[$n];
//                    }}
//                }
                //sap xep mang tang dan
                $max = $arraychuasudung[0];
                for($n = 1; $n<count($arraychuasudung);$n++){
                    if($arraychuasudung[$n]>$max){
                         $tam = $arraychuasudung[$n];
                         $max = $tam;
                         $arraychuasudung[$n] = $tam;
                     }
                }
                //lay mang chi co nhung so serial da su dung
//                $getserial="1-20";
                $arrayserial = explode("-", $getSerial);$arr = array();$p=0;
                for($n = (int)$arrayserial[0];$n<=(int)$arrayserial[1];$n++){
                    if(GlobalLib::ckeckarray($n, $arraychuasudung)==0){
                        $arr[$p++] = $n;
                    }
                }
                //tao ra chuoi serial da su dung
                $flag = "";$t="";$arrayseriallist = array();$a1=0;$dem=0;$a2=1;$co=false;
                $arrayseriallist1 = array();
                $dem = count($arr);
                $min = $arr[0];
                $flag = $min-1;
                for($n = 0; $n<count($arr);$n++){
                $tam = $arr[$n]; 
                $arrayseriallist[$a1++]=$tam;
                $arrayseriallist1[0]=$min;
                if($dem ==1){
                    $arrayseriallist1[0]=$tam;
                }elseif($tam == ($flag+1)){
                    $flag = $tam;
                    if($a1 == $dem){
                        $flag = $tam;
                        $arrayseriallist1[$a2++]="-";
                        $arrayseriallist1[$a2++]=$tam;
                    }
                    $co = true;
                }elseif ($tam > ($flag+1)) {
                    if($a1 == $dem){
                        $flag = $tam;
                        $arrayseriallist1[$a2++]=",";
                        $arrayseriallist1[$a2++]=$tam;
                        $co = true;
                    }else
                        if($co == true){
                        $arrayseriallist1[$a2++]="-";
                        $arrayseriallist1[$a2++]=$flag; 
                        $arrayseriallist1[$a2++]=",";
                        $arrayseriallist1[$a2++]=$tam;
                        $flag = $tam;$co = false;
                    }else {
                        $arrayseriallist1[$a2++]=",";
                        $arrayseriallist1[$a2++]=$tam;
                        $flag = $tam;
                    }
                }               
                }
                $arrtam = array();$a3=0;
                 $st = implode('', $arrayseriallist1);
                 $arr11= explode(",",$st);
                foreach ($arr11 as $value1) {
                    $arr12 = explode("-", $value1);
                    if(count($arr12)==1){
                        $arrtam[$a3++]=$value1;
                    }  else {
                        if((int)$arr12[0]==(int)$arr12[1]){
                             $arrtam[$a3++] = ",";
                             $arrtam[$a3++] = $arr12[0];
                        }  else {
                             $arrtam[$a3++] = ",";
                             $arrtam[$a3++] = $value1;
                        }
                    }
                }
                $str = implode('', $arrtam);
                $str = substr($str, 1);
                return $str;
//                echo json_encode($str);
//                exit();
    }
    public static function arrayStringSerial($tringSerial){
        $array_serial_xoahuhong = array();
        $i = 0;
        //lay serial trong chuoi hu hong
        if($tringSerial != "")
            {
            $array_1 = explode(",", $tringSerial);
            if(count($array_1)==1)
            {
                $array_2 = explode("-", $array_1[0]);
                if(count($array_2)==1)
                {
                    $array_serial_xoahuhong[$i++]=(int)$array_2[0];
                }  else 
                {
                    for($j=(int)$array_2[0];$j<(int)$array_2[1];$j++){
                        $array_serial_xoahuhong[$i++]=$j;
                    }
                }
            }  else {
                foreach ($array_1 as $value) {
                    $array_3 = explode("-", $value);
                    if(count($array_3)==1)
                    {
                        $array_serial_xoahuhong[$i++]=(int)$array_3[0];
                    }  else {
                        for($k=(int)$array_3[0];$k<(int)$array_3[1];$k++){
                            $array_serial_xoahuhong[$i++]=$k;
                        }
                    }
                }

            }
            return $array_serial_xoahuhong;
        }  else {
            return $array_serial_xoahuhong;
        }
        
        
    }
    public static function sapxep($array){
        for ($i = 0; $i < count($array)-1;$i++){
            for ($j = $i+1; $j < count($array);$j++){
                if ($array[$i]>$array[$j])
                {
                    $k = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $k;
                }
            }    
        }
        return $array;
    }

    // Lan Duong
    public static function getComboMultiDoanhNghiep($fieldName, $tableName, $valueColumn, $textColumn, $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
        }
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        $html .= $html1;
        $html .= '<option value="0">'.$zeroValueName.'</option>';
        foreach ($items as $item) {
            $selected = '';
            if ($defaultValue == $item[$valueColumn])
                $selected = ' selected="selected"';
            $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public static function getComboMultiSelect($fieldName, $tableName, $valueColumn, $textColumn,$textColumn1=NULL, $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        if($textColumn1 ==NULL){
            $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        } else {
            $query = 'SELECT ' . $valueColumn . ',' . $textColumn . ','.$textColumn1. ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        }
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
            $html = '<select id="' . $fieldName . '" name="' . $fieldName . '[]" ' . $multiSelectHTML .' '.$onclick .'>';
        }

        $html .= $html1;
//        $html .= '<option value="0">'.$zeroValueName.'</option>';
        foreach ($items as $item) {
            $selected = '';
            if (in_array($item[$valueColumn], explode(',', $defaultValue)))
                $selected = ' selected="selected"';
            if($textColumn1==NULL){
                $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
            } else {
                $html .= '<option value="' . $item[$valueColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]).' - '.str_replace("'", "\'", $item[$textColumn1]) . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    public static function getComboDistinctMultiSelect($fieldName, $tableName, $valueColumn, $textColumn,$textColumn1=NULL, $defaultValue, $multiSelect = false, $filters = '', $orderBys = NULL, $onclick='', $zeroValueName = 'Chưa lựa chọn') {
        $db = Zend_Db_Table::getDefaultAdapter();
        if($textColumn1 ==NULL){
            $query = 'SELECT DISTINCT ' . $textColumn . ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        } else {
            $query = 'SELECT DISTINCT' . $textColumn . ','.$textColumn1. ' from ' . $tableName . ' '.$filters.' '.$orderBys;
        }
        $i = 1;
        $stmt = $db->query($query);
        $items = $stmt->fetchAll(); //PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $multiSelectHTML = '';
        $html1 = '';
        $html = '<select id="' . $fieldName . '" name="' . $fieldName . '" ' . $multiSelectHTML .' '.$onclick .'>';
        if ($multiSelect) {
            $multiSelectHTML = 'multiple="multiple"';
            $html = '<select id="' . $fieldName . '" name="' . $fieldName . '[]" ' . $multiSelectHTML .' '.$onclick .'>';
        }

        $html .= $html1;
        //$html .= '<option value="0">'.$zeroValueName.'</option>';
        foreach ($items as $item) {
            $selected = '';
            if (in_array($i, explode(',', $defaultValue)))
                $selected = ' selected="selected"';
            if($textColumn1==NULL){
                //$html .= '<option value="' . $item[$textColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
                $html .= '<option value="' . $i . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]) . '</option>';
            } else {
                $html .= '<option value="' . $item[$textColumn] . '" ' . $selected .'>' . str_replace("'", "\'", $item[$textColumn]).' - '.str_replace("'", "\'", $item[$textColumn1]) . '</option>';
            }
            $i++;
        }
        $html .= '</select>';
        return $html;
    }

    public static function getHiddenFieldControl($id, $name)
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $html = '<input id="' . $id . '" name="' . $id . '" type=hidden>';

        return $html;
    }
}


