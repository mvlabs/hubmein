<?php

namespace Conferences\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class DoctrineConferenceMapperFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // Dependencies are fetched from Service Manager
	    $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
	    
            return new DoctrineConferenceMapper($entityManager);
		
	}

}