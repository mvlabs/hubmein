<?php

namespace Events\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RightSideBarFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    $service = $serviceLocator->getServiceLocator()->get('Events\Service\EventService');
	    $request = $serviceLocator->getServiceLocator()->get('Request');
	    
	    $currentCountry = $request->getQuery('country', null);
	    
	    if (NULL !== $currentCountry && !is_numeric($currentCountry)) {
	    	throw new \UnexpectedValueException('Value of country ("'. $currentCountry . '") is invalid. Numeric values only are accepted');
	    }
	    
	    return new RightSideBar($service->getCountries(), $currentCountry);
		
	}

}