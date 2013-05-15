<?php

namespace Events\Service;

use Events\Entity\Event;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;


class EventService implements EventManagerAwareInterface {

	private $events;
	
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
     * Get Event
     *
     * @param int Event Id
     * @return \Events\Entity\Event 
     */
    public function getEvent($id) {
        return $this->mapper->getEvent($id);
    }

    /**
     * Get Event List
     *
     * @param mixed $countryId
     * @return array List of Event
     */
    public function getList($country = null) {
        return $this->mapper->getEventList($country);
    }
    
    public function getListArray() {
        return $this->mapper->getListArray();
    }
        
    public function getLocalEvents() {
    	$country = 1;	// Suppose we fetch this from somewhere and 1 is Italy...
    	$limit = 4;			
    	return $this->mapper->getEventList($country, $limit);
    } 
        
    public function getCountries() {
    	return $this->mapper->getCountryList();
    }
    
    public function insertEventFromArray(array $formData) {
        
        $event = Event::createFromArray($formData);
            
        $this->mapper->saveEvent($event);
        
        //trigger 'event_saved' event
        $this->getEventManager()->trigger('event_saved', $this, array(
                                          'title' => $event->getTitle()
        ));
    
        return $event;
        
    }
    
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $events;
        return $this;
    }

    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

}