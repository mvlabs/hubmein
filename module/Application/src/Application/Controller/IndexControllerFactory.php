<?php
namespace Application\Controller;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use Application\Controller\IndexController;

/**
 *
 * @author David Contavalli < mauipipe@gmail.com >
 * @copyright M.V. Associates for VDA (c) 2011 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class IndexControllerFactory implements FactoryInterface {
       
    public function createService(ServiceLocatorInterface $serviceLocator) {
                
	    $conferenceService = $serviceLocator->getServiceLocator()->get('Conferences\Service\ConferenceService');
	             
	    // Create an instance of IndexController injecting services $conferenceService as dependency (IoC in action)
	    $indexController = new IndexController($conferenceService); 
	    
	    return $indexController; 
        
    }    
}


