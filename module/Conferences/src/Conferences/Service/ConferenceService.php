<?php

namespace Conferences\Service;

use Conferences\Entity\Conference,
    Conferences\DataFilter\RequestBuilder,
    Conferences\Mapper\ConferenceMapperInterface;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\EventManager\EventManagerInterface,
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
    public function __construct( ConferenceMapperInterface $conferenceMapper ) {

        $this->conferenceMapper = $conferenceMapper;

    }
	
     /**
     * Gets a specific Conference
     *
     * @param int Conference Id
     * @return \Conferences\Entity\Conference 
     */
    public function getConference( $id ) {
       
        return $this->conferenceMapper->getConference( $id );
        
    }
    
    public function getFullList() {
        
        return $this->conferenceMapper->getFullList();
        
    }

    /**
     * Get Conference List given an array of criterias
     *
     * @return array list of Conference Entity
     */
    public function fetchAllByFilter( RequestBuilder $requestBuilder ) {
               
        return $this->conferenceMapper->fetchAllByFilter( $requestBuilder );
        
    }
    
    /**
     * Count Conference list given an array of criterias
     */
    public function countByFilter( RequestBuilder $requestBuilder ){
        
        return $this->conferenceMapper->countByFilter( $requestBuilder );
        
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
    public function upsertConference( Conference $conference ) {
        
        $conference->setPublicationdate(new \DateTime());
        
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
    public function removeConference( Conference $conference ) {
        
        $this->conferenceMapper->removeConference($conference);
        
    }
    
    /**
     * Injects EventManager (ZF2 component) into this class
     *
     * @see \Zend\EventManager\EventManagerAwareInterface::EventManager()
     */
    public function setConferenceManager(EventManagerInterface $conferences)
    {
        $conferences->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->eventManager = $conferences;
        return $this;
    }

    /**
     * Fetches Conference Manager (ZF2 component) from this class
     *
     * @see \Zend\ConferenceManager\ConferencesCapableInterface::getConferenceManager()
     */
    public function getConferenceManager()
    {
        if (null === $this->eventManager) {
            $this->setConferenceManager(new EventManager());
        }
        return $this->eventManager;
    }

    public function getEventManager() {
        
    }

    public function setEventManager(EventManagerInterface $eventManager) {
        
    }
    
    private function hasCfps($routeName){
        
        if($routeName == self::CFPS_ROUTENAME){
            
            return true;
            
        }
        
        return false;
        
    }

}