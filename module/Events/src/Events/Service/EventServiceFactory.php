<?php

namespace Events\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class EventServiceFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $I_serviceLocator) {
		
	    $I_mapper = $I_serviceLocator->get('Events\Mapper\EventMapper');
		return new EventService($I_mapper);
		
	}

}