<?php
namespace CaptchaRefresher\Service;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Description of CaptchaRefresherServiceFactory
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class CaptchaServiceFactory implements FactoryInterface{
   
    
    public function createService(ServiceLocatorInterface $service) {
        
        $captcha = $service->get('captcha.factory');
        return new CaptchaService($captcha);
        
    }    
    
}


