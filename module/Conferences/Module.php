<?php

namespace Conferences;

use Zend\ModuleManager\Feature\ViewHelperProviderInterface,
    Zend\Mvc\MvcEvent;

class Module implements ViewHelperProviderInterface
{
     
    public function onBootstrap( MvcEvent $event ){
        
        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach('dispatch', array($this, 'preDispatch'), 100);
        
    }
    
    public function preDispatch( MvcEvent $event ) {
        
        $matchedRoute = $event->getRouteMatch()->getMatchedRouteName();
        $matchedRoutePart = explode("/",$matchedRoute);
        
        if($routeName = $matchedRoutePart[0]) {
            
            $serviceManager = $event->getApplication()->getServiceManager();
            
            $paginatorHelper = $serviceManager->get('viewhelpermanager')->get('paginatorbyperiod');
            $seachFormHelper = $serviceManager->get('viewhelpermanager')->get('searchform');
            $tagListHelper = $serviceManager->get('viewhelpermanager')->get('taglist');
            
            $paginatorHelper->setRouteName( $routeName );
            $seachFormHelper->setRouteName( $routeName );
            $tagListHelper->setRouteName( $routeName );
            
            return ;      
            
        }
        
        throw new \UnexpectedValueException('cannot retrieve a valid route');
        
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
    // Service Manager Configuration
    public function getServiceConfig() {
    	return array(
            'aliases'=>array(

                 'conference.service'=>'Conferences\Service\ConferenceService',
                 'tag.service'=>'Conferences\Service\TagService',
                 'conference.doctrine.mapper'=> 'Conferences\Mapper\DoctrineConferenceMapper'

             ),
            'factories' => array(
                
                'Conferences\Service\RegionService' => 'Conferences\Service\RegionServiceFactory',
                'Conferences\Service\ConferenceService' => 'Conferences\Service\ConferenceServiceFactory',
                'Conferences\Service\TagService' => 'Conferences\Service\TagServiceFactory',

                // Conferences mapper
                'Conferences\Mapper\ConferenceMapper' => 'Conferences\Mapper\DoctrineConferenceMapperFactory',
                'Conferences\Mapper\RegionMapper' => 'Conferences\Mapper\DoctrineRegionMapperFactory',
                //'Conferences\Mapper\EventMapper' => 'Conferences\Mapper\ZendDbEventMapperFactory'

                // Tags mapper
                'Conferences\Mapper\TagMapper' => 'Conferences\Mapper\DoctrineTagMapperFactory',
                //'Conferences\Mapper\EventMapper' => 'Conferences\Mapper\ZendDbEventMapperFactory'
            ),
    			
    	);
    }
    
    public function getControllerConfig() {
        
        return array(
            'factories' => array(
                'Conferences\Controller\Conference' => 'Conferences\Controller\ConferenceControllerFactory',
                'Conferences\Controller\FormOperations'=>'Conferences\Controller\FormOperationsControllerFactory',
                // Admin controllers
                'Conferences\Controller\AdminConference' => 'Conferences\Controller\AdminConferenceControllerFactory',
                'Conferences\Controller\AdminTags' => 'Conferences\Controller\AdminTagsControllerFactory',
            ),
        );
        
    } 
    
    
    public function getControllerPluginConfig()
    {
    	return array(
    		'invokables' => array(
    		    'getAndCheckNumericParam' => 'Conferences\Controller\Plugin\GetAndCheckNumericParam',
    		)
    	);
    }
    
    
    public function getViewHelperConfig()
    {
    	return array(
			'invokables' => array( 
                            
			    'cost' => 'Conferences\View\Helper\DisplayCost',
                            'plurify'=>'Conferences\View\Helper\Plurify',
                            'renderFormRow'=>'Conferences\View\Helper\RenderFormRow',
                            'formelementerrors' => 'Conferences\Form\View\Helper\PromoteFormElementError'
			),
                        'factories' => array(
                            
                            'searchForm' => 'Conferences\View\Helper\SearchFormFactory',
                            'paginatorByPeriod'=>'Conferences\View\Helper\PaginatorByPeriodFactory',
                            'tagList'=>'Conferences\View\Helper\TagListFactory'
                        ),
    	);
    }
    
}
