<?php

namespace Events\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class DoctrineEventMapperFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $I_serviceLocator) {
		
	    $I_entityManager = $I_serviceLocator->get('doctrine.entitymanager.orm_default');
	    
		return new DoctrineEventMapper($I_entityManager);
		
	}

}