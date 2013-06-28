<?php

namespace Events\Service;

use Events\Entity\Event;
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
	private $mapper = null;
	
	
	/*
	 * Constructs service 
	 * 
	 * @param \Events\Mapper\EventMapper Event Mapper
	 */
	public function __construct(\Events\Mapper\EventMapperInterface $mapper) {
		$this->mapper = $mapper;
	}
	
     /**
     * Gets a specific Event
     *
     * @param int Event Id
     * @return \Events\Entity\Event 
     */
    public function getEvent($i_id) {
        return $this->mapper->getEvent($i_id);
    }

    /**
     * Get Event List
     *
     * @param mixed $countryId
     * @return array List of Event
     */
    public function getList($m_country = null) {
        return $this->mapper->getEventList($m_country);
    }
    
    /**
     * Gets the list of events in the form of array
     */
    public function getListArray() {
        return $this->mapper->getListArray();
    }
        
    /**
     * Fetches events (IE conferences) related to a specific country
     */
    public function getLocalEvents() {
    	$m_country = 1;	// Suppose we fetch this from somewhere and 1 is Italy...
    	$i_limit = 4;			
    	return $this->mapper->getEventList($m_country, 4);
    } 
        
    /**
     * Fetches list of countries within the system
     */
    public function getCountryListAsArray() {
    	return $this->mapper->getCountryListAsArray();
    }
    
    /**
     * Inserts or updates an event from array data
     *
     * @param array $formData
     * @return \Events\Entity\Event
     */
    public function upsertEvent(\Events\Entity\Event $event) {
        
        $event->setPublicationdate(new \DateTime());
        
        $this->mapper->saveEvent($event);
        
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
        
        $this->mapper->removeEvent($event);
        
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