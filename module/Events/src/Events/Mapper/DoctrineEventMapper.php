<?php

namespace Events\Mapper;

use Zend\ServiceManager\ServiceManager,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use Events\DataFilter\EventFilter;

class DoctrineEventMapper implements EventMapperInterface {

    private $entityManager;
    private $eventRepository;
    
 
    public function __construct(\Doctrine\ORM\EntityManager $entityManager) 
    {
        $this->entityManager = $entityManager;
        $this->eventRepository = $this->entityManager->getRepository('Events\Entity\Event');
	
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
    * Gets list of filtered evetns
    *
    * @param string $countryId
    * @return integer Max number of events to return
    */
    public function getFilteredList( EventFilter $EventFilter, $limit = null )
    {
        
        return $this->eventRepository->getFilteredList($EventFilter);
                
    }
     
    
    /**
     * Count a list given an EventFilter
     */
    public function countFilteredItems( EventFilter $EventFilter ){
      
        return $this->eventRepository->countFilteredItems($EventFilter);
        
    }
    
    /**
     * 
     */
    public function getFullList(){
              
        return $this->eventRepository->findAll();
        
    }
    
    /**
     * Saves an event
     * 
     * @param \Events\Entity\Event Event to save
     */
    public function saveEvent(\Events\Entity\Event $event) 
    {

        $this->entityManager->persist($event);
        $this->entityManager->flush();
        
    }
    
}
