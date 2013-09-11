<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;

use Behat\Zf2Extension\Context\Zf2AwareContextInterface;

use Conferences\Service\ConferenceService,
    Conferences\DataFilter\RequestBuilder;

use Doctrine\ORM\EntityManager;

use Conferences\Entity\Conference;

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
    private $I_conferenceService;
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
      
    
    //CRUD functionality
    
    /**
     * @Given /^I don\'t have conference saved on my system$/
     */
    public function iDonTHaveConferenceSavedOnMySystem()
    {
        
        $conferences = $this->getEntityManager()->getRepository("Conferences\Entity\Conference")->findAll();
        assertEquals( 0,sizeof($conferences) );
        
    }

    /**
     * @When /^I pass valid data and an empty Entity to save method$/
     */
    public function iPassValidDataAndAnEmptyEntityToSaveMethod()
    {
        $conferenceDatas = $this->loadMockConferenceData();
        
        $this->result = $this->insertConferences($conferenceDatas[0], new Conference);
        
        
        
    }

    /**
     * @Then /^I should have a saved Conference entity$/
     */
    public function iShouldHaveASavedConferenceEntity()
    {
        assertTrue($this->result->getId() > 0);
        assertInstanceOf("Conferences\Entity\Conference", $this->result);
        
    }

    /**
     * @Given /^it should have tags:$/
     */
    public function itShouldHaveTags(TableNode $tagTable)
    {
        $conference = $this->getEntityManager()->getRepository("Conferences\Entity\Conference")->find($this->result->getId());
             
        $tags = $conference->getTags();
        $tagDatas = array();
        
        for($i = 0; $i < sizeof($tags); $i++) {
            
            $tagDatas[$i]['name'] = $tags[$i]->getName();
            
        }
        
        assertSame($tagTable->getHash(),$tagDatas);
        
    }

    
    
     /**
     * @Given /^I have a list of (\d+) conferences$/
     */
    public function iHaveAListOfConferences($number)
    {
       /*@TOFIX
         $hydrator = new DoctrineHydrator($this->getEntityManager(),"Conferences\Entity\Conference");
         $conferenceData = $this->loadMockConference();
         
         $conference = $hydrator->hydrate($conferenceData[1], new \Conferences\Entity\Conference);
                
         assertEquals($conferenceData[1], $hydrator->extract($conference));
         * 
         */
        $savedConference = array();
        
        foreach($this->loadMockConferenceData() as $conferenceData) {
            
            $conference = $this->insertConferences( $conferenceData, new Conference() );
            
            if($conference instanceof Conference) {
                
                $savedConference[] = $conference;
                
            }
            
        }
                     
        assertEquals(intval($number),sizeof($savedConference));
    }

   
    //Test option retrieving
    
    /**
     * @When /^I get a region list$/
     */
    public function iGetARegionList()
    {
        
        $regions = $this->getServiceManager()->get("conference.service")->fetchAllRegionByRoute("conference");
        $hydrator = new DoctrineHydrator($this->getEntityManager(), "Conferences\Entity\Country");
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
        
        $periods = $this->getServiceManager()->get("conference.service")->fetchAllPeriodByRoute("conference");
        
        $serializedPeriods = array();
               
        foreach($periods as $period) {
            
            $dateInstance = $period['month_year'];
            $serializedPeriods[0][] = $dateInstance->format("F Y");
                                   
        }
        
        $this->expectedList = $serializedPeriods;
        assertNotNull($this->expectedList);
        
    }
    
    //TEST ConferenceService count
    
     /**
     * @Given /^I send a request:$/
     */
    public function iSendARequest(TableNode $request)
    {
       
        $requestData = $request->getHash();
        
        foreach($requestData[0] as $key => $value) {
            
            if($value === "true" || $value === "false"){
                
                $requestData[0][$key] = ($value == "true")?true:false;
                
            }
            
        }
        
        $this->mockRequest = RequestBuilder::createObjFromArray($requestData[0]);
        
        assertInstanceOf("Conferences\DataFilter\RequestBuilder", $this->mockRequest);
           
    }

    /**
     * @When /^the request is passed to countListByFilter method$/
     */
    public function theRequestIsPassedToCountlistbyfilterMethod()
    {
        
        $conferenceService  = $this->getServiceManager()->get("conference.service");
        
        assertInstanceOf("Conferences\Service\ConferenceService", $conferenceService);
        assertTrue(is_callable(array($conferenceService,"countListByFilter")));
                
        $this->result = $conferenceService->countListByFilter($this->mockRequest);
        
    }

    /**
     * @Then /^I should get "([^"]*)" as result$/
     */
    public function iShouldGetAsResult($number)
    {
        
        assertEquals($number, $this->result);
        
    }
        
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
     *  save mock conference
     */
    private function insertConferences( array $conferenceData,  Conference $conference ){
        
        
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
        $conference->setSlug();
        $conference->setDiscountForGroups($conferenceData['discountForGroups']);
        $conference->setDiscountForStudents($conferenceData['discountForStudents']);
        $conference->setIsVisible($conferenceData['isvisible']);
        $conference->setIsFeatured($conferenceData['isfeatured']);
        $conference->setCountry(
                    $em->getRepository('Conferences\Entity\Country')->find($conferenceData['country'])
                );

        $em->getRepository('Conferences\Entity\Country')->find($conferenceData['country']);

        foreach($conferenceData['tags'] as $tagId) {

            $tag = $em->getRepository('Conferences\Entity\Tag')->find($tagId);

            if(!$tag instanceof \Conferences\Entity\Tag ) {

                throw new UnexpectedValueException("Cannot find a valid tag"); 
            }

            $conference->addTag(
                        $tag
                    );

        }
        $em->persist($conference);
          
                     
         $em->flush();
         
         return $conference;
    }
    
    /**
     * 
     * @return array
     */
    private function loadMockConferenceData(){
        
        $currentDate = new \DateTime();
        $currentDate->add(new \DateInterval('P10D'));
        
        return array(
                  
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
                    "cfpclosingdate"=>$currentDate->format("d/m/Y"),
                    "hashtag" => "",
                    "venue"=>"Hilton hotel",
                    "contactemail"=>"zendcon@conf.com",
                    "twitteraccount"=>"https://twitter.com/zendcon",
                    "isinternational"=>true,
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
                    "discountForStudents"=>false,
                    "discountForGroups"=>true,
                    "publicationdate"=>"15/04/2013",
                    "isvisible"=>true,
                    "isfeatured" =>true,
                    "country" => 3,
                    "tags" =>array(3,4)

                ),
                array(
                    
                    "title"=>"phpday 2014",
                    "abstract"=>"italian php conference",
                    "datefrom"=>"15/05/2014",
                    "dateto"=>"18/05/2014",
                    "earlybirduntil"=>"04/03/2014",
                    "address"=>"via Marco Polo",
                    "city"=>"Verona",
                    "averagedayfee"=>"300",
                    "website"=>"www.phpday.com",
                    "cfpclosingdate"=>"02/03/2014",
                    "hashtag" => "",
                    "venue"=>"Marco Polo hotel",
                    "contactemail"=>"phpday@test.it",
                    "twitteraccount"=>"https://twitter.com/phpday",
                    "isinternational"=>true,
                    "discountForStudents"=>false,
                    "discountForGroups"=>true,
                    "publicationdate"=>"20/10/2013",
                    "isvisible"=>true,
                    "isfeatured" =>true,
                    "country" => 4,
                    "tags" =>array(2)

                ),
                              
            );
    }
  
}

?>
