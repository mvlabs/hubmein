<?php

namespace Conferences\Service;

use Conferences\Entity\Conference,
    Conferences\DataFilter\RequestBuilder,
    Conferences\Mapper\ConferenceMapperInterface;

use Zend\EventManager\EventManagerInterface,
    Zend\EventManager\EventManager,
    Zend\EventManager\EventManagerAwareInterface;


/**
 * Handles interaction with events (IE conferences)
 *
 * @author Stefano Valle
 *
 */
class ConferenceService implements EventManagerAwareInterface {
    
    const CFPS_ROUTENAME = "cpfs";
    
    /**
     * Event Manager (Zend Framework 2 component - NOT related to conferences!)
     * 
     * @var \Zend\EventManager\EventManagerInterface
     */
    private $eventManager;

    /*
     * @var \Conferences\Mapper\ConferenceMapper Conference Mapper
     */
    private $conferenceMapper = null;

    /*
     * Constructs service 
     * 
     * @param \Conferences\Mapper\ConferenceMapper Conference Mapper
     */
    public function __construct(ConferenceMapperInterface $conferenceMapper) {

        $this->conferenceMapper = $conferenceMapper;

    }
	
     /**
     * Gets a specific Conference
     *
     * @param string $slug
     * @return \Conferences\Entity\Conference 
     */
    public function getConference($slug) {
       
        return $this->conferenceMapper->getConference($slug);
        
    }
    
    public function getFullList() {
        
        return $this->conferenceMapper->getFullList();
        
    }

    /**
     * Get Conference List given an array of criterias
     *
     * @return array list of Conference Entity
     */
    public function fetchAllByFilter(RequestBuilder $requestBuilder) {
               
        return $this->conferenceMapper->fetchAllByFilter($requestBuilder);
        
    }
    
    /**
     * Count Conference list given an array of criterias
     */
    public function countByFilter(RequestBuilder $requestBuilder){
        
        return $this->conferenceMapper->countByFilter($requestBuilder);
        
    }
    
    public function getCountryListAsArray() {
        
        return $this->conferenceMapper->getCountryListAsArray();
        
    }
       
    /**
     * Get a list of region based on upcoming conferences
     * @param boolean $activeCfps
     * @return array
     */
    public function fetchAllRegionByRoute($routeName){
               
        return $this->conferenceMapper->fetchAllRegions($this->hasCfps($routeName));
        
    }
    
    /**
     * Get a list of period based on upcoming conferences
     * @param string $routeName
     * @return array
     */
    public function fetchAllPeriodByRoute($routeName){
        
        return $this->conferenceMapper->fetchAllPeriods($this->hasCfps($routeName));
        
    }
           
    /**
     * Inserts or updates an event from array data
     *
     * @param array $formData
     * @return \Conferences\Entity\Conference
     */
    public function upsertConference(Conference $conference) {
        
        // add a new conference?
        if (null == $conference->getId()) {
            $conference->setPublicationdateObject(new \DateTime());
            $conference->setSlug($this->generateConferenceSlug($conference));
        }
        
        $this->conferenceMapper->saveConference($conference);
        
        //trigger 'event_saved' event
        $this->getConferenceManager()->trigger('event_saved', $this, array(
            'title' => $conference->getTitle()
                
        ));
    
        return $conference;
        
    }
    
    /**
     * Removes an event from db
     * 
     * @param \Conferences\Entity\Conference $conference
     */
    public function removeConference(Conference $conference) {
        
        $this->conferenceMapper->removeConference($conference);
        
    }
    
    /**
     * Injects EventManager (ZF2 component) into this class
     *
     * @see \Zend\EventManager\EventManagerAwareInterface::EventManager()
     */
    public function setEventManager(EventManagerInterface $eventConference)
    {
        $eventConference->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        
        $this->eventManager = $eventConference;
        
        return $this;
    }

    /**
     * Fetches Conference Manager (ZF2 component) from this class
     *
     * @see \Zend\ConferenceManager\ConferencesCapableInterface::getConferenceManager()
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
        
            $this->setEventManager(new EventManager());
            
        }
        
        return $this->eventManager;
    }
   
    private function hasCfps($routeName){
        
        if($routeName == self::CFPS_ROUTENAME){
            
            return true;
            
        }
        
        return false;
        
    }
    
    public function generateConferenceSlug(\Conferences\Entity\Conference $conference) {
        
        // set source text
        $sourceText = $conference->getTitle() . ' ' . $conference->getDatefrom()->format('Y') . ' ' . $conference->getCity();
        
        // keep only numeric and alphabetic chars
        $filter = new \Zend\I18n\Filter\Alnum(true);
        $result = $filter->filter($sourceText);

        // replate spaces with dash
        return strtolower(str_replace(' ', '-', $result));

    }


}