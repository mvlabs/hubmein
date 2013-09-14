<?php
namespace CaptchaRefresher\Controller;
use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use CaptchaRefresher\Controller\CaptchaRefresherController;

/**
 * Description of CaptchaRefresherControllerFactory
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class CaptchaRefresherControllerFactory implements FactoryInterface{
    
    
    public function createService(ServiceLocatorInterface $service) {
        
        $refresherService = $service->get('captcha.service');
        
        return new CaptchaRefresherController($refresherService);
        
    }   
    
}

?>
