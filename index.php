<?php
   date_default_timezone_set('Asia/Ho_Chi_Minh');
   
   // Define base path obtainable throughout the whole application
    defined('BASE_PATH')
        || define('BASE_PATH', realpath(dirname(__FILE__)));
     
        
    // Define path to application directory
    defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', BASE_PATH . '/application');
    
    // Define application environment
    defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', 'development');//(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
   
   set_include_path(implode(PATH_SEPARATOR, array(
       realpath(APPLICATION_PATH . '/../library'),
       APPLICATION_PATH . '/models',
       get_include_path(),
   )));

   /** Zend_Application */
   require_once 'Zend/Application.php';
   require_once 'Zend/Mail.php';
   require_once 'PHPExcel/PHPExcel.php';
   
   // Create application, bootstrap, and run
   $application = new Zend_Application(
       APPLICATION_ENV,
       APPLICATION_PATH . '/configs/application.ini'
   );
  try{   
   $application->bootstrap()->run();
   }catch(Exception $ex){
   echo 'Lien ket cua quy khach khong ton tai';
   echo '<div style="display:block"><pre>';print_r($ex); echo '</pre></div>';
   }