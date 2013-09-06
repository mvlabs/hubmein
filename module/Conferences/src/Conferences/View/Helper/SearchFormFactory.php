<?php

namespace Conferences\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SearchFormFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    $conferenceService = $serviceLocator->getServiceLocator()->get('conference.service');
            $tagService = $serviceLocator->getServiceLocator()->get('Conferences\Service\TagService');
            $routeMatch = $serviceLocator->getServiceLocator()->get('Application')->getMvcEvent()->getRouteMatch();

            $request = $serviceLocator->getServiceLocator()->get('Request');
            
            $currentDatas = array();
	    $currentDatas['region'] = $routeMatch->getParam('region');
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
                      
	    return new SearchForm( $conferenceService, $tagService, $currentDatas );
		
	}

}