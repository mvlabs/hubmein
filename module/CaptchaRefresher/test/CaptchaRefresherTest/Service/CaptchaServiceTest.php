<?php
use CaptchaRefresher\Service\CaptchaService;
use Zend\Math\Rand;
/**
 * Description of RefreshService
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class RefreshServiceTest extends PHPUnit_Framework_TestCase{
     
    const IMAGE_SUFFIX = ".png";
    const DEFAULT_CAPTCHA_FOLDER = "/public/images/captcha"; 
    /**
     * @expectedException
     * @exceptionMessage "Argument 1 passed to CaptchaRefresher\Service\CaptchaService::__construct() must be an instance of Zend\Captcha\AbstractAdapter, none given"
     * @test
     */
    
    public function anExceptionIsRaisedIfNoImgIsPassed(){
        
        //new CaptchaService();
        
    }
    
    /**
     * @test
     */
    public function canGenerateCaptchaImage(){
         
        $randomMd5 = $this->generaterrRandmD5();
        $mockResult = $this->mockResult($randomMd5);
         
        $captchaImage = $this->prepareCaptcha('image');
        $captchaImage->shouldReceive("generate")->once()->andReturn($mockResult['id']);
        $captchaImage->shouldReceive("getImgUrl")->once()->andReturn(self::DEFAULT_CAPTCHA_FOLDER.DIRECTORY_SEPARATOR);
        $captchaImage->shouldReceive("getId")->once()->andReturn($randomMd5);
        $captchaImage->shouldReceive("getSuffix")->once()->andReturn(self::IMAGE_SUFFIX);
        
        
        $captchaService = new CaptchaService($captchaImage);
        
        $reflection = new \ReflectionClass($captchaService);
        $this->assertTrue($reflection->hasMethod("generate"));
        
        $result = $captchaService->generate();      
        $this->assertEquals($mockResult, $result); 
        
    }
    
    private function prepareCaptcha( $captchaType ) {
        
        $captchaObjName = ucfirst($captchaType);
             
        return \Mockery::mock("Zend\Captcha\\".$captchaObjName);
        
    }
    
    private function mockResult( $generatedMd5 ) {
        
        return array(
            "id"=>"123232314134114",
            "src"=>self::DEFAULT_CAPTCHA_FOLDER.DIRECTORY_SEPARATOR.$generatedMd5.self::IMAGE_SUFFIX
        );
        
    }
    
    private function generaterrRandmD5(){
        
        return md5(Rand::getBytes(32));
        
    }
}


