<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use Behat\Zf2Extension\Context\Zf2AwareContextInterface;

use Events\Service\EventService,
    Events\DataFilter\RequestBuilder;

use Doctrine\ORM\EntityManager;

use Events\Entity\Event;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use Doctrine\Common\DataFixtures\Loader,
    Doctrine\Common\DataFixtures\Executor\ORMExecutor,
    Doctrine\Common\DataFixtures\Purger\ORMPurger;

/**
 * Behat Context with test regarding Conferences 
 *
 * @author David Contavalli < mauipipe@gmail.com >
 * @copyright M.V. Associates for VDA (c) 2011 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */

class ConferenceContext extends BehatContext implements Zf2AwareContextInterface{
    
    private $zf2Application;
    private $I_eventService;
    private $conferenceNr;
    
    private $expectedList;
    
    private $mockRequest;
    private $result;
    
    public function setZf2App(\Zend\Mvc\Application $zf2Application) {
        
        $this->zf2Application = $zf2Application;
        
    }
    
        
    public function getServiceManager() {
        
        return $this->zf2Application->getServiceManager();
        
    }
    
    public function getEntityManager() {
        
        return $this->zf2Application->getServiceManager()->get("doctrine.entitymanager.orm_default");
        
    }
      
    
   /**
     * @Given /^I have an american and an european conference$/
     */
    public function iHaveAnAmericanAndAnEuropeanConference()
    {
         
        /*@TOFIX
         $hydrator = new DoctrineHydrator($this->getEntityManager(),"Events\Entity\Event");
         $eventData = $this->loadMockConference();
         
         $event = $hydrator->hydrate($eventData[1], new \Events\Entity\Event);
                
         assertEquals($eventData[1], $hydrator->extract($event));
         * 
         */
        
         $this->insertConferences();
                     
    }

   
    //Test option retrieving
    
    /**
     * @When /^I get a region list$/
     */
    public function iGetARegionList()
    {
        
        $regions = $this->getServiceManager()->get("event.service")->getRegionByUpcomingConferences();
        $hydrator = new DoctrineHydrator($this->getEntityManager(), "Events\Entity\Country");
        $serializedRegions = array();
        
        foreach($regions as $region) {
            
            $serializedRegions[] = $hydrator->extract($region);
                                   
        }
        
        $this->expectedList = $serializedRegions;
        assertNotNull($this->expectedList);
        
    }

    /**
     * @Then /^I should have a list with:$/
     */
    public function iShouldHaveAListWith(TableNode $expectetionData)
    {
      
        assertEquals($expectetionData->getHash(), $this->expectedList);
                
    }
    
    /**
     * @Given /^I have an conference on october and november$/
     */
    public function iHaveAnConferenceOnOctoberAndNovember()
    {
        $this->insertConferences();
    }

    /**
     * @When /^I get a period list$/
     */
    public function iGetAPeriodList()
    {
        
        $periods = $this->getServiceManager()->get("event.service")->getPeriodByUpcomingConferences();
        
        $serializedPeriods = array();
               
        foreach($periods as $period) {
            
            $dateInstance = $period['month_year'];
            $serializedPeriods[0][] = $dateInstance->format("F Y");
                                   
        }
        
        $this->expectedList = $serializedPeriods;
        assertNotNull($this->expectedList);
        
    }
    
    //TEST EventService count
    
     /**
     * @Given /^I send a request:$/
     */
    public function iSendARequest(TableNode $request)
    {
       
        $requestData = $request->getHash();
        $this->mockRequest = RequestBuilder::createObjFromArray($requestData[0]);
        
        assertInstanceOf("Events\DataFilter\RequestBuilder", $this->mockRequest);
           
    }

    /**
     * @When /^the request is passed to countListByFilter method$/
     */
    public function theRequestIsPassedToCountlistbyfilterMethod()
    {
        
        $eventService  = $this->getServiceManager()->get("event.service");
        
        assertInstanceOf("Events\Service\EventService", $eventService);
        assertTrue(is_callable(array($eventService,"countByFilter")));
        
        $this->result = $eventService->countByFilter($this->mockRequest);
        
    }

    /**
     * @Then /^I should get "([^"]*)" as result$/
     */
    public function iShouldGetAsResult($number)
    {
        
        assertEquals($number, $this->result);
        
    }
    
    //TEST EventService search
    
    
    //END OF FUNCTIONAL
    
    //TEST ON UI 
    
    /**
     * @When /^I am on the home page$/
     */
    public function iAmOnTheHomePage()
    {
        
        $this->getMainContext()->visit($this->getMainContext()->locatePath("/"));
        $this->getMainContext()->getPage()->hasButton("Refine");
        
    }

  /**
     * @Then /^I select the "([^"]*)" I could be able to pick between:$/
     */
    public function iSelectTheICouldBeAbleToPickBetween($selectClass, TableNode $expectedOption)
    {
        $actualOption = array();
        $flag = 0;
                
        $this->getMainContext()->getPage()->hasSelect("select.".$selectClass);
        
        foreach($this->getMainContext()->getPage()->findAll("css","select.".$selectClass." option ") as $option) {
            
            $actualOption[$flag]['value'] = $option->getValue();
            $actualOption[$flag]['text']  = $option->getText();
            $flag++;
        }
              
    }
    
    /**
     *  2 mock conference
     */
    private function insertConferences(){
        
        foreach ($this->loadMockConferenceData() as $conferenceData) {
            
                $conference = new Event();
                $em = $this->getEntityManager();
                          
                $conference->setTitle($conferenceData['title']);
                $conference->setAbstract($conferenceData['abstract']);
                $conference->setDatefrom( \DateTime::createFromFormat("d/m/Y",$conferenceData['datefrom']) );
                $conference->setDateto( \DateTime::createFromFormat("d/m/Y",$conferenceData['dateto']) );
                $conference->setEarlyBirdUntil(\DateTime::createFromFormat("d/m/Y",$conferenceData['earlybirduntil']));
                $conference->setAddress($conferenceData['address']);
                $conference->setCity($conferenceData['city']);
                $conference->setAveragedayfee($conferenceData['averagedayfee']);
                $conference->setWebsite($conferenceData['website']);
                $conference->setVenue($conferenceData['venue']);
                $conference->setCfpclosingdate( \DateTime::createFromFormat("d/m/Y",$conferenceData['cfpclosingdate']));
                $conference->setPublicationdate( \DateTime::createFromFormat("d/m/Y",$conferenceData['publicationdate']));
                $conference->setHashtag($conferenceData['hashtag']);
                $conference->setContactemail($conferenceData['contactemail']);
                $conference->setTwitteraccount($conferenceData['twitteraccount']);
                $conference->setIsinternational($conferenceData['isinternational']);
                $conference->setSlug($conferenceData['slug']);
                $conference->setDiscountForGroups($conferenceData['discountForGroups']);
                $conference->setDiscountForStudents($conferenceData['discountForStudents']);
                $conference->setIsVisible($conferenceData['isvisible']);
                $conference->setIsFeatured($conferenceData['isfeatured']);
                $conference->setCountry(
                            $em->getRepository('Events\Entity\Country')->find($conferenceData['country'])
                        );
                 
                $em->getRepository('Events\Entity\Country')->find($conferenceData['country']);
                
                foreach($conferenceData['tags'] as $tagValue) {

                    $conference->addTag(
                                $em->getRepository('Events\Entity\Tag')->find($tagValue)
                            );

                }
                $em->persist($conference);
          }
             
            
            $em->flush();
                   
    }
    
    /**
     * 
     * @return array
     */
    private function loadMockConferenceData(){
                       
        return array(
                  array(
                    "title"=>"ZendCon Europe 2013",
                    "abstract"=>"Firt Zend european conference",
                    "datefrom"=>"20/11/2013",
                    "dateto"=>"22/11/2013",
                    "earlybirduntil"=>"31/08/2013",
                    "address"=>"rue de Gauce 1809",
                    "city"=>"Paris",
                    "averagedayfee"=>"350",
                    "website"=>"www.zendcomeruope.com",
                    "cfpclosingdate"=>"12/05/2013",
                    "hashtag" => "",
                    "publicationdate"=>"12/02/2013",
                    "venue"=>"Hilton hotel",
                    "contactemail"=>"zendconeurope@test.com",
                    "twitteraccount"=>"https://twitter.com/zendconeurope",
                    "isinternational"=>true,
                    "slug"=>"zendCon2013",
                    "discountForStudents"=>false,
                    "discountForGroups"=>true,
                    "isvisible"=>true,
                    "isfeatured" =>true,
                    "country" => 3,
                    "tags" =>array(1,2)
                 ),
             array(
                "title"=>"ZendCon 2013",
                "abstract"=>"Worlwide zend conference",
                "datefrom"=>"04/10/2013",
                "dateto"=>"06/10/2013",
                "earlybirduntil"=>"05/10/2013",
                "address"=>"Mocking bird avenue",
                "city"=>"Los Angeles",
                "averagedayfee"=>"300",
                "website"=>"www.zendcon.com",
                "cfpclosingdate"=>"14/05/2013",
                "hashtag" => "",
                "venue"=>"Hilton hotel",
                "contactemail"=>"zendcon@conf.com",
                "twitteraccount"=>"https://twitter.com/zendcon",
                "isinternational"=>true,
                "slug"=>"zendCon2013",
                "discountForStudents"=>false,
                "discountForGroups"=>true,
                "publicationdate"=>"15/04/2013",
                "isvisible"=>true,
                "isfeatured" =>true,
                "country" => 1,
                "tags" =>array(1,2)

                ),
                     
            array(
                "title"=>"Agile Day 2013",
                "abstract"=>"Conference organized for Fabio Armani",
                "datefrom"=>"11/09/2013",
                "dateto"=>"13/09/2013",
                "earlybirduntil"=>"04/10/2013",
                "address"=>"Mocking bird avenue",
                "city"=>"Los Angeles",
                "averagedayfee"=>"300",
                "website"=>"www.agileday.com",
                "cfpclosingdate"=>"14/05/2013",
                "hashtag" => "",
                "venue"=>"Hilton hotel",
                "contactemail"=>"zendcon@conf.com",
                "twitteraccount"=>"https://twitter.com/agileday",
                "isinternational"=>true,
                "slug"=>"zendCon2013",
                "discountForStudents"=>false,
                "discountForGroups"=>true,
                "publicationdate"=>"15/04/2013",
                "isvisible"=>true,
                "isfeatured" =>true,
                "country" => 3,
                "tags" =>array(3,4)

                ),
                              
            );
    }
  
}

?>
