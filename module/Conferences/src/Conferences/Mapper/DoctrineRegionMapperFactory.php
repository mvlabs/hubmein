<?php
namespace Conferences\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Conferences\Mapper\DoctrineRegionMapper;

class DoctrineRegionMapperFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // Dependencies are fetched from Service Manager
	    $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
	    
		return new DoctrineRegionMapper($entityManager);
		
	}

}
