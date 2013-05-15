<?php
namespace ApplicationTest\Controller;

use Zend\Mvc\Application;

use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;


class ApplicationEndToEndTest extends AbstractHttpControllerTestCase {
    
    /**
     * This should NOT come from here (DRY)
     * @var int Number of events to be shown in home
     */
    const HOME_MAX_EVENTS = 4;
    
    
    public function setUp() {
    	$this->setApplicationConfig(include __DIR__ . '/../../TestConfig.php.dist');
    	parent::setUp();
    }

    
    /**
     * Verifies that homa page can be accessed
     */
    public function testHomePageData() {
        
    	$this->dispatch('/');
    	
    	$this->assertResponseStatusCode(200);
    	$this->assertControllerClass('IndexController');
    	$this->assertActionName('index');
    	
    	// Tells us whether we're on right page
    	$this->assertQueryContentContains("html body#about div#page div#main-content.clearfix div.wrap div.full-width div.intro-message div.border-bottom h2 strong", "best events");
    	
    	// Counting elements
    	$this->assertQueryCountMax("html body#about div#page div#main-content.clearfix div.wrap div.full-width section#content.fl div.conferences div.event", self::HOME_MAX_EVENTS);
    	 
    	// XPath to pick Nth element (2nd in this case - no such support for CSS selectors)
    	$this->assertXPathQueryContentContains('/html/body/div/div[2]/div/div/div[2]/div[2]/h3', 'Speaker');
    	
    }
    
}
