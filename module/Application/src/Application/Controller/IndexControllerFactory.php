<?php
namespace Application\Controller;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use Application\Controller\IndexController;

/**
 * Inject needed services into the controller
 *
 * @author David Contavalli < mauipipe@gmail.com >
 * @copyright M.V. Associates for VDA (c) 2011 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class IndexControllerFactory implements FactoryInterface {
    
    
    public function createService( ServiceLocatorInterface $serviceLocator ) {
        
             // get services from  Service Manager
	    $conferenceService = $serviceLocator->getServiceLocator()->get( 'Events\Service\EventService' );
	    
          
	    // Create an instance of IndexController injecting services $eventService,$regionService,$tagService as dependencies  (IoC in action)
	    $indexController = new IndexController( $conferenceService ); 
	    
	    return $indexController; 
        
    }    
}

?>