<?php
namespace CaptchaRefresherTest\Controller;

use PHPUnit_Framework_TestCase;

use CaptchaRefresher\Service\CaptchaServiceFactory;
/**
 * Description of RefreshControllerFactoryTest
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class CaptchaServiceFactoryTest extends PHPUnit_Framework_TestCase{
    
    private $mockServiceManager;
    private $mockCaptcha;
    
    protected function setUp(){
        
       $this->mockServiceManager = \Mockery::mock("Zend\ServiceManager\ServiceManager");
        
    }
    
    /**
     * @test
     */
    public function canCreateRecaptchaService(){
        
        
        $this->mockCaptcha = \Mockery::mock("Zend\Captcha\Image");
        $this->mockServiceManager->shouldReceive("get")->with('captcha')->andReturn($this->mockCaptcha);
        
        $refresher = new CaptchaServiceFactory();
        $reflection = new \ReflectionClass($refresher);
        $this->assertTrue($reflection->hasMethod('createService'));
        
        $recaptchaController = $refresher->createService($this->mockServiceManager);
        
        $this->assertInstanceOf("CaptchaRefresher\Service\CaptchaService", $recaptchaController);
        
    }
         
}


