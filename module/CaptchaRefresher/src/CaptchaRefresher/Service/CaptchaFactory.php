<?php
namespace CaptchaRefresher\Service;

use Zend\Captcha\Factory as CaptchaCreator,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of CaptchaRefresherFactory
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 * 
 * 
 */
class CaptchaFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $services) {
        
        $config = $services->get('config');
        
        if(!isset($config['refresher'])) {
            
            throw new \OutOfRangeException("refresher key does not exist inside configuration");
            
        }
        
        $captchaParam = $config['refresher'];
        $captcha = CaptchaCreator::factory($captchaParam);
        
        return $captcha;
        
    }
    
}


