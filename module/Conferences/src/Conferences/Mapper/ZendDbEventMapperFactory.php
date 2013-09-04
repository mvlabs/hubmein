<?php

namespace Conferences\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

use Conferences\Entity\Conference,
    Conferences\Entity\Country;

class ZendDbConferenceMapperFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Conference());

        $eventTable = new TableGateway('event', $dbAdapter, null, $resultSetPrototype);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Country());

        $countryTable = new TableGateway('country', $dbAdapter, null, $resultSetPrototype);

		return new ZendDbConferenceMapper($eventTable, $countryTable);
		
	}

}
