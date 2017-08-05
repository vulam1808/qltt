<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Default_Controller_Plugin_Multilanguage extends Zend_Controller_Plugin_Abstract
{
    public function routeStartup (Zend_Controller_Request_Abstract $request)
    {
		if (substr($request->getRequestUri(), 0, -1) == $request->getBaseUrl()){
			$request->setRequestUri($request->getRequestUri()."en"."/");
			$request->setParam("language", "en");
		}
    }
 
    public function routeShutdown (Zend_Controller_Request_Abstract $request)
    {
        
//		$registry = Zend_Registry::getInstance();
//		$translate = $registry->get('Zend_Translate');
//		$currLocale = $translate->getLocale();
//		
//		$lang = $request->getParam('language','vi');
//		switch($lang) {
//			case 'vi':
//				$langLocale = 'vi_VN'; break;
//			case 'en':
//				$langLocale = 'en_US'; break;
//			default:
//				$langLocale = isset($session->lang) ? $session->lang : $currLocale;
//		}
//		
//		$newLocale = new Zend_Locale();
//		$newLocale->setLocale($langLocale);
//		$registry->set('Zend_Locale', $newLocale);
//		$translate->setLocale($langLocale);
//		$registry->set('Zend_Translate', $translate);
//		
//		$auth = Zend_Auth::getInstance();
//		//echo $auth->hasIdentity();exit;
//		if (!$auth->hasIdentity()) {	
//			if ($request->getActionName() != 'login') {
//				$r = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
//			    $r->gotoUrl('/default/login/login')->redirectAndExist();
//			}
//		}
    }
}