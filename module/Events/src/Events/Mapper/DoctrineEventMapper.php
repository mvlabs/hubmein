<?php

namespace Events\Mapper;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineEventMapper implements EventMapperInterface {

    private $I_entityManager;
    private $I_eventRepository;
    private $I_countryRepository;
 
    public function __construct(\Doctrine\ORM\EntityManager $I_entityManager) 
    {
        $this->I_entityManager = $I_entityManager;
        $this->I_eventRepository = $this->I_entityManager->getRepository('Events\Entity\Event');
	    $this->I_countryRepository = $this->I_entityManager->getRepository('Events\Entity\Country');
    }
	
     /**
     * Get an Event
     *
     * @param int Event Id
     * @return \Events\Entity\Event 
     */
    public function getEvent($i_id)
    {
    	
        $I_event = $this->I_eventRepository->find($i_id);
        
        if (null == $I_event) {
        	throw new \DomainException('No event with such ID here.');
        }
        
    	return $I_event;
    }
    
    /**
     * Get a country
     * 
     * @param int Country id
     * @throws \DomainException
     * @return \Events\Entity\Country 
     */
    public function getCountry($i_id)
    {
    
        $I_country = $this->I_countryRepository->find($i_id);
    
        if (null == $I_country) {
            throw new \DomainException('No country with such ID here.');
        }
    
        return $I_country;
    }

    
    /**
     * Get list of events
     *
     * @param string $countryId
     * @return integer Max number of events to return
     */
    public function getEventList($i_country = null, $i_limit = null)
    {
        
        if (null == $i_country) {
            return $this->I_eventRepository->findAll();
        }
        
        return $this->I_eventRepository->findByCountry($i_country);
        
    }
    
    /*
     * Get list of countries
     * 
     * @return array
     */
    public function getCountryList() 
    {
    	
        $aI_countries = $this->I_countryRepository->findAll();
        
        $as_result = array();
        foreach ($aI_countries as $I_country) {
            $as_result[$I_country->getId()] = $I_country->getName();
        }
        
        return $as_result;
        
    }
    
    /**
     * Save an avent
     * 
     * @param \Events\Entity\Event Event to save
     */
    public function saveEvent(\Events\Entity\Event $I_event) 
    {

        $this->I_entityManager->persist($I_event);
        $this->I_entityManager->flush();
        
    }
    
}