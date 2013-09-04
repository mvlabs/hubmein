<?php
namespace Conferences\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class RegionServiceFactory implements FactoryInterface {

    
    public function createService(ServiceLocatorInterface $serviceLocator) {

        $mapper = $serviceLocator->get('Conferences\Mapper\RegionMapper');

        return new RegionService($mapper);

    }
        

}