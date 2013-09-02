<?php

namespace Events\Mapper;

use Doctrine\ORM\EntityManager;

use Events\DataFilter\RequestBuilder;


class DoctrineEventMapper implements EventMapperInterface {

    private $entityManager;
    private $eventRepository;
    
 
    public function __construct( EntityManager $entityManager ) 
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
    
    public function getFullList() {
        
        return $this->eventRepository->findAll();
        
    }
        
   /**
    * 
    * Get a list of Events Entity by a given $criterias array
    * @param array $criterias
    * @return array mixed 
    */
    public function getListByFilter( RequestBuilder $requestBuilder )
    {
        
        return $this->eventRepository->getFilteredList( $requestBuilder );
                
    }
     
    
    /**
     * Gets number of filtered events by a given $criterias array 
     * @param array $criterias
     * return int 
     */
    public function countListByFilter( RequestBuilder $requestBuilder ){
      
        return $this->eventRepository->countFilteredItems( $requestBuilder );
        
    }
    
    public function getCountryListAsArray() {
        
        $countries = $this->countryRepository->findAll();

    }

   /**
    * 
    */
    public function getRegionByUpcomingConferences(){
        
        return $this->eventRepository->getRegionsWithConferences();
        
    }
     
    /**
     * Saves an event
     * 
     */
    public function getPeriodByUpcomingConferences() {
        
        return $this->eventRepository->getPeriodWithConferences();
        
    }
    
    /**
     * Removes an event
     *
     * @param \Events\Entity\Event Event to remove
     */
    public function removeEvent(\Events\Entity\Event $event)
    {
    
        $this->entityManager->remove($event);
        $this->entityManager->flush();
    
    }
    
}