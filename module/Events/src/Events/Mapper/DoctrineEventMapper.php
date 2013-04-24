<?php

namespace Events\Mapper;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineEventMapper implements EventMapperInterface, ServiceLocatorAwareInterface {

    private $I_entityManager;
    private $I_eventRepository;
    private $I_countryRepository;
    
	
     /**
     * Get Event
     *
     * @param int Event Id
     * @return \Events\Entity\Event 
     */
    public function getEvent($i_id)
    {
        
        $this->initDoctrine();
        
        $I_event = $this->I_eventRepository->find($i_id);
        
        if (null == $I_event) {
        	throw new \DomainException('No event with such ID here.');
        }
        
    	return $I_event;
    }
    
    public function getCountry($i_id)
    {
    
        $this->initDoctrine();
    
        $I_country = $this->I_countryRepository->find($i_id);
    
        if (null == $I_country) {
            throw new \DomainException('No country with such ID here.');
        }
    
        return $I_country;
    }

    
    /**
     * Get Event List
     *
     * @param string $countryId
     * @return integer Max number of events to return
     */
    public function getEventList($m_country = null, $i_limit = null)
    {
        
        $this->initDoctrine();

        //@todo manage limit param
        
        if ($m_country == null) {
            return $this->I_eventRepository->findAll();
        } else {
            
            $I_country = $this->I_countryRepository->findOneBySlug($m_country);
            return $this->I_eventRepository->findByCountry($I_country->getId());
            
            // or use repositories to reduce number of queries...
            
        }
        
    }
    
    public function getListArray()
    {
    
        $aI_events = $this->getList();

        $as_events = array();
        foreach($aI_events as $I_event) {
        
            $as_events[] = $I_event->toArray();
            
        }
        
        return $as_events;
        
    }
    
    public function getCountryList() {
    	
        $this->initDoctrine();
        
        //@todo manage method params
        
        $aI_countries = $this->I_countryRepository->findAll();
        
        $as_result = array();
        foreach ($aI_countries as $I_country) {
            $as_result[$I_country->getId()] = $I_country->getName();
        }
        
        return $as_result;
        
    }
    
    public function saveEvent(\Events\Entity\Event $I_event) {

        $this->initDoctrine();
        
        $this->I_entityManager->persist($I_event);
        $this->I_entityManager->flush();
    }
    
    /**
     * getEntityManager
     *
     * @return enitymanager
     */
    public function getEntityManager()
    {
        $this->I_servicelocator->get('doctrine.driver.orm_default')->getAllClassNames();
        if (null === $this->I_entityManager) {
            $this->setEntityManager($this->I_servicelocator->get('doctrine.entitymanager.orm_default'));
        }
    
        return $this->I_entityManager;
    }
    
    /**
     * setEntityManager
     *
     * @param \Doctrine\ORM\EntityManager $entityI_entityManagerymanager
     *
     * @return AccendiManager
     */
    public function setEntityManager($I_entityManager)
    {
        $this->I_entityManager=$I_entityManager;
    
        return $this;
    }

    public function setServiceLocator(ServiceLocatorInterface $I_servicelocator)
    {
        $this->I_servicelocator = $I_servicelocator;
    
        return $this;
    }
    
    public function getServiceLocator()
    {
        return $this->I_servicelocator;
    }
    
    private function initDoctrine() {
        $this->getEntityManager();
        $this->I_eventRepository = $this->I_entityManager->getRepository('Events\Entity\Event');
        $this->I_countryRepository = $this->I_entityManager->getRepository('Events\Entity\Country');
    }

}