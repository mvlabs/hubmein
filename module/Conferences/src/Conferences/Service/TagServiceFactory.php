<?php

namespace Conferences\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class TagServiceFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    $mapper = $serviceLocator->get('Conferences\Mapper\TagMapper');
		return new TagService($mapper);
		
	}

}