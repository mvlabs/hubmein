<?php

namespace Events\Service;

use Events\Entity\Event;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class EventService {

	private $I_sm = null;
	
	/*
	 * @var \Events\Mapper\EventMapper Event Mapper
	 */
	private $I_mapper = null;
	
	
	/*
	 * Constructs service 
	 * 
	 * @param \Events\Mapper\EventMapper Event Mapper
	 */
	public function __construct(\Events\Mapper\EventMapperInterface $I_mapper) {
		$this->I_mapper = $I_mapper;
	}
	
     /**
     * Get Event
     *
     * @param int Event Id
     * @return \Events\Entity\Event 
     */
    public function getEvent($i_id) {
        return $this->I_mapper->getEvent($i_id);
    }

    /**
     * Get Event List
     *
     * @param mixed $countryId
     * @return array List of Event
     */
    public function getList($m_country = null) {
        return $this->I_mapper->getEventList($m_country);
    }
    
    public function getListArray() {
        return $this->I_mapper->getListArray();
    }
        
    public function getLocalEvents() {
    	$m_country = 'italy';	// Suppose we fetch this from somewhere
    	$i_limit = 4;			
    	return $this->I_mapper->getEventList($m_country, 4);
    } 
        
    public function getCountries() {
    	return $this->I_mapper->getCountryList();
    }
    
    public function insertEventFromArray(array $am_formData) {
    
        $I_event = Event::createFromArray($am_formData);
    
        $this->I_mapper->saveEvent($I_event);
    
        return $I_event;
        
    }

}