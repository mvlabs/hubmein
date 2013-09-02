<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode,
    Behat\MinkExtension\Context\MinkContext;

use Behat\Zf2Extension\Context\Zf2AwareContextInterface;


//
// Require 3rd-party libraries here:
//
   require_once 'PHPUnit/Autoload.php';
   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext implements Zf2AwareContextInterface
{
    
    private $zf2Application;
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        
        $this->useContext("conference", new ConferenceContext());
        $this->useContext("doctrine", new \DoctrineFixtureContext());
        
    }

    public function setZf2App(\Zend\Mvc\Application $zf2Application) {
        
        $this->zf2Application = $zf2Application;
        
    }
    
    public function getPage(){
        
        return $this->getSession()->getPage();
        
    }


}
