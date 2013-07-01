<?php

namespace Events\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RightSideBarFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    $countryService = $serviceLocator->getServiceLocator()->get('Events\Service\RegionService');
           
	    $request = $serviceLocator->getServiceLocator()->get('Request');
	    
            $currentDatas = array();
	    $currentDatas['region'] = $request->getQuery('region', null);
	    $currentDatas['period'] = $request->getQuery('period',null);
            
           /*
            * TODO Need an explanation
            */
            
            if ( NULL !== $currentDatas['region'] && !is_numeric($currentDatas['region']) ) {

           //     throw new \UnexpectedValueException('Value of country ("'. $currentDatas['country'] . '") is invalid. Numeric values only are accepted');

            }
                        
            if ( NULL !== $currentDatas['period'] && !is_numeric($currentDatas['period']) ) {
                
	    //	throw new \UnexpectedValueException('Value of country ("'. $currentDatas['period'] . '") is invalid. Numeric values only are accepted');
                
	    }
                      
	    return new RightSideBar( $countryService->getFullList(),$currentDatas );
		
	}

}