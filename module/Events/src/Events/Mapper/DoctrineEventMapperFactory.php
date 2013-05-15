<?php

namespace Events\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class DoctrineEventMapperFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
	    
		return new DoctrineEventMapper($entityManager);
		
	}

}