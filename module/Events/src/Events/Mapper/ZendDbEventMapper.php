<?php

namespace Events\Mapper;

class ZendDbEventMapper implements EventMapperInterface {

	/*
	 * @var array Events
	 */
	private $aI_events = null;
	
	
	/*
	 * Constructs service 
	 * 
	 */
	public function __construct() {

		//@todo
		
	}
	
     /**
     * Get Event
     *
     * @param int Event Id
     * @return \Events\Entity\Event 
     */
    public function getEvent($i_id)
    {
        //@todo
    }

    
    /**
     * Get Event List
     *
     * @param string $countryId
     * @return integer Max number of events to return
     */
    public function getList($m_country = null, $i_limit = null)
    {
    	//@todo
    	
    	
    }
    
    public function getCountries() {
    	
    	//@todo
    	
    }
    

}