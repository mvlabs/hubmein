<?php

namespace Events\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class TagServiceFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    $mapper = $serviceLocator->get('Events\Mapper\TagMapper');
		return new TagService($mapper);
		
	}

}