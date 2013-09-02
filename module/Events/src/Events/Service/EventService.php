<?php

namespace Events\Service;

use Events\Entity\Event,
    Events\DataFilter\RequestBuilder,
    Events\Mapper\EventMapperInterface;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Handles interaction with events (IE conferences)
 *
 * @author Stefano Valle
 *
 */
class EventService implements EventManagerAwareInterface {

    /**
     * Event Manager (Zend Framework 2 component - NOT related to conferences!)
     * 
     * @var \Zend\EventManager\EventManagerInterface
     */
    private $eventManager;

    /*
     * @var \Events\Mapper\EventMapper Event Mapper
     */
    private $eventMapper = null;


    /*
     * Constructs service 
     * 
     * @param \Events\Mapper\EventMapper Event Mapper
     */
    public function __construct( EventMapperInterface $mapper ) {

        $this->eventMapper = $mapper;

    }
	
     /**
     * Gets a specific Event
     *
     * @param int Event Id
     * @return \Events\Entity\Event 
     */
    public function getEvent( $id ) {
       
        return $this->eventMapper->getEvent( $id );
        
    }
    
    public function getFullList() {
        
        return $this->eventMapper->getFullList();
        
    }

    /**
     * Get Event List given an array of criterias
     *
     * @return array list of Event Entity
     */
    public function getListByFilter( RequestBuilder $requestBuilder ) {
               
        return $this->eventMapper->getListByFilter( $requestBuilder );
        
    }
    
    /**
     * Count Event list given an array of criterias
     */
    public function countListByFilter( RequestBuilder $requestBuilder ){
        
        return $this->eventMapper->countListByFilter( $requestBuilder );
        
    }
    
    public function getCountryListAsArray() {
        
        return $this->eventMapper->getCountryListAsArray();
        
    }
           
    /**
     * 
     */
    public function getRegionByUpcomingConferences(){
        
        return $this->eventMapper->getRegionByUpcomingConferences();
        
    }
    
    /**
     * Get a list of period based on upcoming conferences
     * @return array
     */
    public function getPeriodByUpcomingConferences(){
        
        return $this->eventMapper->getPeriodByUpcomingConferences();
        
    }
        
    /**
     * Inserts or updates an event from array data
     *
     * @param array $formData
     * @return \Events\Entity\Event
     */
    public function upsertEvent(\Events\Entity\Event $event) {
        
        $event->setPublicationdate(new \DateTime());
        
        $this->eventMapper->saveEvent($event);
        
        //trigger 'event_saved' event
        $this->getEventManager()->trigger('event_saved', $this, array(
            'title' => $event->getTitle()
                
        ));
    
        return $event;
        
    }
    
    /**
     * Removes an event from db
     * 
     * @param \Events\Entity\Event $event
     */
    public function removeEvent(\Events\Entity\Event $event) {
        
        $this->eventMapper->removeEvent($event);
        
    }
    
    /**
     * Injects Event Manager (ZF2 component) into this class
     *
     * @see \Zend\EventManager\EventManagerAwareInterface::setEventManager()
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->eventManager = $events;
        return $this;
    }

    /**
     * Fetches Event Manager (ZF2 component) from this class
     *
     * @see \Zend\EventManager\EventsCapableInterface::getEventManager()
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }
        return $this->eventManager;
    }

}