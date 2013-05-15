<?php

namespace Events\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Events\Entity\Event;
use Events\Entity\Country;

class ZendDbEventMapperFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Event());

        $eventTable = new TableGateway('event', $dbAdapter, null, $resultSetPrototype);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Country());

        $countryTable = new TableGateway('country', $dbAdapter, null, $resultSetPrototype);

		return new ZendDbEventMapper($eventTable, $countryTable);
		
	}

}
