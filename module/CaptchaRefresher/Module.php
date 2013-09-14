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
    
    public function getServiceConfig(){
        
        return array(
            
            'aliases'=>array(
                'captcha.service'=>'CaptchaRefresher\Service\CaptchaService'
             ),  
            'factories'=> array(
                
                'captcha.factory'=>"CaptchaRefresher\Service\CaptchaFactory",
                'CaptchaRefresher\Service\CaptchaService'=>'CaptchaRefresher\Service\CaptchaServiceFactory'
                
            )
            
        );
        
    }
          
}
