<?php

namespace Events\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DisplayCountrySelectFieldFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $I_serviceLocator) {
		
	    $I_service = $I_serviceLocator->getServiceLocator()->get('Events\Service\EventService');
		return new DisplayCountrySelectField($I_service->getCountries());
		
	}

}