<?php

namespace Conferences\Mapper;

use Doctrine\ORM\EntityManager;

use Conferences\DataFilter\RequestBuilder,
    Conferences\Entity\Conference;

class DoctrineConferenceMapper implements ConferenceMapperInterface {

    private $entityManager;
    private $conferenceRepository;
    
 
    public function __construct( EntityManager $entityManager ) 
    {
        $this->entityManager = $entityManager;
        $this->eventRepository = $this->entityManager->getRepository('Conferences\Entity\Conference');
        $this->countryRepository = $this->entityManager->getRepository('Conferences\Entity\Country');
	
    }
	
   /**
    * Gets an Conference
    *
    * @param int Conference Id
    * @return \Conferences\Entity\Conference 
    */
    public function getConference( $id ) {
    	
        $conference = $this->eventRepository->find($id);
        
        if (null == $conference) {
        	throw new \DomainException('No event with such ID here.');
        }
        
    	return $conference;
    }
    
    
    /**
     * 
     * @return type
     */
    public function getFullList() {
        
        return $this->eventRepository->findAll();
        
    }
    

    /**
     * Saves an event
     *
     * @param \Conferences\Entity\Conference Conference to save
     */
    public function saveConference( Conference $conference ) {

        $this->entityManager->persist($conference);
        $this->entityManager->flush();

    }
        
   /**
    * 
    * Get a list of Conferences Entity by a given $criterias array
    * @param array $criterias
    * @return array mixed 
    */
    public function getListByFilter( RequestBuilder $requestBuilder ){
        
        return $this->eventRepository->getListByFilter( $requestBuilder );
                
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
        
        $result = array();
        
        foreach ( $countries as $country ) {
            
            $result[$country->getId()] = $country->getName();
            
        }
                
        return $result;

    }
    
    /**
     * @param boolean $activeCfps
    * @return array contains a list of Conferences\Entity\Conference 
    */
    public function getUpcomingConferencesRegions($activeCfps){
        
        return $this->eventRepository->getUpcomingConferencesRegions($activeCfps);
        
    }
    
    /**
     * @return array contains a list of DateTime
     */
    public function getUpcomingConferencesPeriods($activeCfps)  {
        
        return $this->eventRepository->getUpcomingConferencesPeriods($activeCfps) ;
        
    }
    
    /**
     * Removes an event
     *
     * @param \Conferences\Entity\Conference Conference to remove
     */
    public function removeConference( Conference $conference )
    {
    
        $this->entityManager->remove($conference);
        $this->entityManager->flush();
    
    }
    
}