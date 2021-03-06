<?php

class Controller_Plugin_Multilanguage extends Zend_Controller_Plugin_Abstract {

    public function routeStartup(Zend_Controller_Request_Abstract $request) {
        if (substr($request->getRequestUri(), 0, -1) == $request->getBaseUrl()) {
            $request->setRequestUri($request->getRequestUri() . "en" . "/");
            $request->setParam("language", "en");
        }
    }

    public function routeShutdown(Zend_Controller_Request_Abstract $request) 
    {
        
//        $registry = Zend_Registry::getInstance();
//        $translate = $registry->get('Zend_Translate');
//        $currLocale = $translate->getLocale();
//
//        $lang = $request->getParam('language', 'vi');
//        switch ($lang) {
//            case 'vi':
//                $langLocale = 'vi_VN';
//                break;
//            case 'en':
//                $langLocale = 'en_US';
//                break;
//            default:
//                $langLocale = isset($session->lang) ? $session->lang : $currLocale;
//        }
//
//        $newLocale = new Zend_Locale();
//        $newLocale->setLocale($langLocale);
//        $registry->set('Zend_Locale', $newLocale);
//        $translate->setLocale($langLocale);
//        //echo '<pre>';print_r($translate);exit;
//        $registry->set('Zend_Translate', $translate);

        
        //echo $auth->hasIdentity();exit;
        /* if (!$auth->hasIdentity()) {	
          if ($request->getActionName() != 'login') {
          $r = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
          $r->gotoUrl('/admin/index/login')->redirectAndExist();
          }
          } */
        //Login lan dau
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
         $auth = Zend_Auth::getInstance();
        if ($action == 'login' && !$auth->hasIdentity())
        {
            return;
        }
        //Neu chua chung thuc thi login
        
         if (!$auth->hasIdentity()) {
            $r = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $r->gotoUrl('/default/login/login')->redirectAndExist();
         }
        
        $userInfo = $auth->getIdentity();
        $groupCode = $userInfo->group_code;
        if($groupCode != $module)
        {
            $url = '/'.$groupCode.'/index/index';
              $r = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $r->gotoUrl($url)->redirectAndExist();

        } 
    }
//
}