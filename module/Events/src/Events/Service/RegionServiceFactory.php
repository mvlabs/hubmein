<?php
namespace Events\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class RegionServiceFactory implements FactoryInterface {

    
    public function createService(ServiceLocatorInterface $serviceLocator) {

        $mapper = $serviceLocator->get('Events\Mapper\RegionMapper');

        return new RegionService($mapper);

    }
        

}