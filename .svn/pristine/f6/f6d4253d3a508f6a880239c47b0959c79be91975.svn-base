<?php

class BaseMapper {
    public function createWhereCondition($filters, &$aFilterValues) {
        $sFilter = '';
        if (!empty($filters)) {
            foreach ($filters as $fName => $fVal) {
                if(strpos($fName,'filteroperator'))continue;
                $aValue[0] = $fVal;//explode('_', $fVal);
                $aValue[1] = $filters[$fName.'_filteroperator'];
                switch ($aValue[1]) {//'=','<>', '>', '>=', '<','<=','%like%','%like','like%'
                    case '=':
                        $sFilter .= ' ' . $fName . ' = ? and ';
                        $aFilterValues[] = $aValue[0];
                        break;
                    case '<>':
                        $sFilter .= ' ' . $fName . ' <> ? and ';
                        $aFilterValues[] = $aValue[0];
                        break;
                    case '>':
                        $sFilter .= ' ' . $fName . ' > ? and ';
                        $aFilterValues[] = $aValue[0];
                        break;
                    case '>=':
                        $sFilter .= ' ' . $fName . ' >= ? and ';
                        $aFilterValues[] = $aValue[0];
                        break;
                    case '<':
                        $sFilter .= ' ' . $fName . ' < ? and ';
                        $aFilterValues[] = $aValue[0];
                        break;
                    case '<=':
                        $sFilter .= ' ' . $fName . ' <= ? and ';
                        $aFilterValues[] = $aValue[0];
                        break;
                    case '%like%':
                        $sFilter .= ' ' . $fName . ' like ? and ';
                        $aFilterValues[] = '%' . $aValue[0] . '%';
                        break;
                    case '%like':
                        $sFilter .= ' ' . $fName . ' like ? and ';
                        $aFilterValues[] = '%' . $aValue[0];
                        break;
                    case 'like%':
                        $sFilter .= ' ' . $fName . ' like ? and ';
                        $aFilterValues[] = $aValue[0] . '%';
                        break;
                    default:
                        $sFilter .= ' ' . $fName . ' = ? and ';
                        $aFilterValues[] = $aValue[0];
                        break;
                }
            }
            if (!empty($sFilter)) {
                $sFilter = substr($sFilter, 0, strlen($sFilter) - 4);
                $sFilter = ' where ' . $sFilter;
            }
        }
        return $sFilter;
    }

    public function getTotalRecords($query, $aFilterValues) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $stmt = $db->query($query, $aFilterValues);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $totalRecords = 0;
        foreach ($rows as $row) {
            $totalRecords = $row->totals;
        }
        return $totalRecords;
    }
    public function authen($uname, $upass, $rememberme) {//echo $uname.'_'.$upass;exit;
        $upass = trim($upass);
        
        require_once 'Zend/Auth/Adapter/DbTable.php';
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($db);
        $authAdapter->setTableName('sys_user')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password');
        $authAdapter->setIdentity($uname);
        $authAdapter->setCredential($upass);
        $authAdapter->getDbSelect()->join('sys_user_group', ' sys_user.sys_user_group_id = sys_user_group.id ',array('group_name','group_code'));;
          
        // 4. Khởi tạo chứng thực và lấy kết quả chứng thực
        require_once 'Zend/Auth.php';
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
         // 5. Kiểm tra chứng thực thành công hay thất bại và xử lý
        if ($result->isValid()) {
            // Lấy tất cả các dữ liệu trừ cột password
            $getInfo = $authAdapter->getResultRowObject(null,array('password'));
              // Ghi dữ liệu đã chứng thực vào session
            $auth->getStorage()->write($getInfo);
            require_once('Zend/Session/Namespace.php');
            $session = new Zend_Session_Namespace('Zend_Auth');
            $session->setExpirationSeconds(24 * 3600);
            if ($rememberme) {
                Zend_Session::rememberMe();
            }
            return $result->isValid();
        }
        return $result->isValid();
    }
}