<?php
namespace CaptchaRefresherTest\Service;

use \PHPUnit_Framework_TestCase;
use CaptchaRefresher\Service\CaptchaFactory;


class CaptchaFactoryTest extends PHPUnit_Framework_TestCase {
    
    private $serviceManagerMock ;
    private $captchaRefreshFactory;
 
    
    protected  function setUp(){
        
        $this->serviceManagerMock =  \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $this->captchaRefreshFactory = new CaptchaFactory();
        
    }
    
    /**
     * @test
     */
    public function CanCreateARecaptchaCaptchaElement(){
               
        $this->serviceManagerMock->shouldReceive('get')
                                 ->with('config')
                                 ->andReturn($this->loadMockConfig('config/refresher.test.config.recaptcha.local.php'));
         
        
        $captcha = $this->captchaRefreshFactory->createService($this->serviceManagerMock);
        
        $this->assertInstanceOf("Zend\Captcha\Recaptcha",$captcha);
        
    }
    
    /**
     * @test
     */
    public function CanCreateCaptchaImageElement(){
                       
        $this->serviceManagerMock->shouldReceive('get')
                                 ->with('config')
                                 ->andReturn($this->loadMockConfig('config/refresher.test.config.image.local.php'));
         
        
        $captcha = $this->captchaRefreshFactory->createService($this->serviceManagerMock);
        
        $this->assertInstanceOf("Zend\Captcha\Image",$captcha);
        
    }
    
    private function loadMockConfig($path) {
               
        return require(realpath($path));
        
    }
    
}


?>
