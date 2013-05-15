<?php

namespace Events\Mapper;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineEventMapper implements EventMapperInterface {

    private $entityManager;
    private $eventRepository;
    private $countryRepository;
 
    public function __construct(\Doctrine\ORM\EntityManager $entityManager) 
    {
        $this->entityManager = $entityManager;
        $this->eventRepository = $this->entityManager->getRepository('Events\Entity\Event');
	    $this->countryRepository = $this->entityManager->getRepository('Events\Entity\Country');
    }
	
     /**
     * Gets an Event
     *
     * @param int Event Id
     * @return \Events\Entity\Event 
     */
    public function getEvent($id)
    {
    	
        $event = $this->eventRepository->find($id);
        
        if (null == $event) {
        	throw new \DomainException('No event with such ID here.');
        }
        
    	return $event;
    }
    
    /**
     * Gets a specific country
     * 
     * @param int Country id
     * @throws \DomainException
     * @return \Events\Entity\Country 
     */
    public function getCountry($id)
    {
    
        $country = $this->countryRepository->find($id);
    
        if (null == $country) {
            throw new \DomainException('No country with such ID here.');
        }
    
        return $country;
    }

    
    /**
     * Gets list of events
     *
     * @param string $countryId
     * @return integer Max number of events to return
     */
    public function getEventList($country = null, $limit = null)
    {
        
        if (null == $country) {
            return $this->eventRepository->findAll();
        }
        
        return $this->eventRepository->findByCountry($country);
        
    }
    
    /*
     * Gets a list of countries
     * 
     * @return array
     */
    public function getCountryList() 
    {
    	
        $countries = $this->countryRepository->findAll();
        
        $result = array();
        foreach ($countries as $country) {
            $result[$country->getId()] = $country->getName();
        }
        
        return $result;
        
    }
    
    /**
     * Saves an avent
     * 
     * @param \Events\Entity\Event Event to save
     */
    public function saveEvent(\Events\Entity\Event $event) 
    {

        $this->entityManager->persist($event);
        $this->entityManager->flush();
        
    }
    
}