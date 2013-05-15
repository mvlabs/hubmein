<?php
namespace ApplicationTest\Controller;

use Zend\Mvc\Application;

use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;


class ApplicationControllerTest extends AbstractHttpControllerTestCase {
    
    public function setUp() {
    	$this->setApplicationConfig(include __DIR__ . '/../../TestConfig.php.dist');
    	parent::setUp();
    }

    /**
     * Verifies that homa page can be accessed
     */
    public function testHomePageAccess() {
        
    	$this->dispatch('/');
    	$this->assertResponseStatusCode(200);
    	$this->assertModuleName('application');
    	$this->assertControllerName('application\controller\index');
    	$this->assertControllerClass('IndexController');
    	$this->assertActionName('index');
    	$this->assertMatchedRouteName('home');
    	
    }
    
}
