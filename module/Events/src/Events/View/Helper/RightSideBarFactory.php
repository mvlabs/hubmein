<?php

namespace Events\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RightSideBarFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $I_serviceLocator) {
		
	    $I_service = $I_serviceLocator->getServiceLocator()->get('Events\Service\EventService');
	    $I_request = $I_serviceLocator->getServiceLocator()->get('Request');
	    
	    $m_currentCountry = $I_request->getQuery('country', null);
	    
	    if (NULL !== $m_currentCountry && !is_numeric($m_currentCountry)) {
	    	throw new \UnexpectedValueException('Value of country ("'. $m_currentCountry . '") is invalid. Numeric values only are accepted');
	    }
	    
	    return new RightSideBar($I_service->getCountries(), $m_currentCountry);
		
	}

}