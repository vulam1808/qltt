<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
     protected function _initFrontController() {
        Zend_Loader::loadClass('Zend_Controller_Front');
        $front = Zend_Controller_Front::getInstance();
        $front->setControllerDirectory(
                array(
                    'default' => APPLICATION_PATH . "/modules/default/controllers",
                    'admin' => APPLICATION_PATH . "/modules/admin/controllers",
                    'leader' => APPLICATION_PATH."/modules/leader/controllers",
                     'master' => APPLICATION_PATH."/modules/master/controllers"
        ));
        include_once APPLICATION_PATH . "/modules/admin/controllers/plugin/Multi.php";
        $front->registerPlugin(new Controller_Plugin_Multilanguage());
        include_once APPLICATION_PATH . "/../library/Vnecom/Controller/Plugin/RequestedModuleLayoutLoader.php";
        $front->registerPlugin(new Vnecom_Controller_Plugin_RequestedModuleLayoutLoader());
        return $front;
     }
    protected function _initDB() {
        $config = $this->getOptions();
        include_once APPLICATION_PATH . "/inc/global.php";

        $db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
        //set default adapter
        Zend_Db_Table::setDefaultAdapter($db);

        //save Db in registry for later use
        Zend_Registry::set("db", $db);
        
        Zend_Registry::set("site", $config['site']);
    }
}