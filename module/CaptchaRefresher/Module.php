<?php

namespace CaptchaRefresher;

class Module 
{
       
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceManager(){
        
        return array(
            
            'aliases'=>array(
                'captcha'=>'CaptchaRefresher\Service\CaptchaFactory',
                'captcha.service'=>'CaptchaRefresher\Service\CaptchaRefresherService'
             ),  
            'factories'=> array(
                
                'Captcha'=>"CaptchaRefresher\Service\CaptchaFactory",
                'CaptchaRefresher\Service\CaptchaRefresherService'=>'CaptchaRefresher\Service\CaptchaRefresherServiceFactory'
                
            )
            
        );
        
    }
           
    public function getControllerConfig() {
        
        return array(
            'factories' => array(
                'CaptchaRefresher\Controller\RefreshController' => 'CaptchaRefresher\Controller\CaptchaRefresherControllerFactory',
           ),
        );
        
    }
       
}
