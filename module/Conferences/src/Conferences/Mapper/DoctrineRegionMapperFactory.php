<?php
namespace Conferences\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Conferences\Mapper\DoctrineRegionMapper;

class DoctrineRegionMapperFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
			    
	    $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
	    
		return new DoctrineRegionMapper($entityManager);
		
	}

}
