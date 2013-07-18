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
    public function __construct( EventMapperInterface $I_mapper ) {

        $this->eventMapper = $I_mapper;

    }
	
     /**
     * Gets a specific Event
     *
     * @param int Event Id
     * @return \Events\Entity\Event 
     */
    public function getEvent( $i_id ) {
       
        return $this->eventMapper->getEvent( $i_id );
        
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
           
    /**
     * Inserts or updates an event from array data
     *
     * @param array $formData
     * @return \Events\Entity\Event
     */
    public function upsertEventFromArray(\Events\Entity\Event $event) {
                            
        $am_formData['country'] = $this->eventMapper->getCountry($am_formData['country']);
        $I_event = Event::createFromArray($am_formData);
            
        $this->eventMapper->saveEvent($I_event);
        
        
        //trigger 'event_saved' event
        $this->getEventManager()->trigger('event_saved', $this, array(
            
            'title' => $I_event->getTitle()
                
        ));
    
        return $event;
        
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
