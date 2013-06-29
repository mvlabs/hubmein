<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $I_application       = $e->getApplication();
        $I_eventManager        = $I_application->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($I_eventManager);
        
        // attach mail service to events
        $I_sharedEventManager = $I_eventManager->getSharedManager();
        $I_sm = $I_application->getServiceManager();
        $I_mailService = $I_sm->get('Application\Service\MailService');
        $I_sharedEventManager->attach('Events\Service\EventService', 'event_saved', array($I_mailService, 'logEventSaved'));
        
        // Common Error Handling Code
        /*$I_eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function($e) {
        
            // Do nothing if no error in the event
            $error = $e->getError();
            if (empty($error)) {
                return;
            }
             
            switch ($error) {
                case Application::ERROR_CONTROLLER_NOT_FOUND:
                case Application::ERROR_CONTROLLER_INVALID:
                case Application::ERROR_ROUTER_NO_MATCH:
                    // Specifically not handling these
                    echo "Requested Resource Not Found";
                    exit;
                     
                case Application::ERROR_EXCEPTION:
                default:
                    echo "Exception Thrown: " . $e->getParam('exception')->getMessage();
                    exit;
            }
             
        });*/
        
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
}
