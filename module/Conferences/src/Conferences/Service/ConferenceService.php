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
        
    /**
     * Event Manager (Zend Framework 2 component - NOT related to conferences!)
     * 
     * @var \Zend\EventManager\EventManagerInterface
     */
    private $conferenceManager;

    /*
     * @var \Conferences\Mapper\ConferenceMapper Conference Mapper
     */
    private $conferenceMapper = null;

    /*
     * Constructs service 
     * 
     * @param \Conferences\Mapper\ConferenceMapper Conference Mapper
     */
    public function __construct( ConferenceMapperInterface $mapper ) {

        $this->eventMapper = $mapper;

    }
	
     /**
     * Gets a specific Conference
     *
     * @param int Conference Id
     * @return \Conferences\Entity\Conference 
     */
    public function getConference( $id ) {
       
        return $this->eventMapper->getConference( $id );
        
    }
    
    public function getFullList() {
        
        return $this->eventMapper->getFullList();
        
    }

    /**
     * Get Conference List given an array of criterias
     *
     * @return array list of Conference Entity
     */
    public function getListByFilter( RequestBuilder $requestBuilder ) {
               
        return $this->eventMapper->getListByFilter( $requestBuilder );
        
    }
    
    /**
     * Count Conference list given an array of criterias
     */
    public function countListByFilter( RequestBuilder $requestBuilder ){
        
        return $this->eventMapper->countListByFilter( $requestBuilder );
        
    }
    
    public function getCountryListAsArray() {
        
        return $this->eventMapper->getCountryListAsArray();
        
    }
       
    /**
     * @param boolean $activeCfps
     * @return array
     */
    public function getUpcomingConferencesRegions($activeCfps){
        
        return $this->eventMapper->getUpcomingConferencesRegions($activeCfps);
        
    }
    
    /**
     * Get a list of period based on upcoming conferences
     * @param boolean $activeCfps
     * @return array
     */
    public function getUpcomingConferencesPeriods($activeCfps){
        
        return $this->eventMapper->getUpcomingConferencesPeriods($activeCfps);
        
    }
           
    /**
     * Inserts or updates an event from array data
     *
     * @param array $formData
     * @return \Conferences\Entity\Conference
     */
    public function upsertConference( Conference $conference ) {
        
        $conference->setPublicationdate(new \DateTime());
        
        $this->eventMapper->saveConference($conference);
        
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
        
        $this->eventMapper->removeConference($conference);
        
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

}