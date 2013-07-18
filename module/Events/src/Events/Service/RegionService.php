<?php
namespace Events\Service;

use Events\Mapper\RegionMapperInterface;

/**
 *
 * @author MVLabs
 */

class RegionService {
    
    /*
     * @var \Events\Mapper\RegionMapper Event Mapper
     */
    private $regionMapper = null;


    /*
     * Constructs service 
     * 
     * @param \Events\Mapper\RegionMapper Event Mapper
     */
    public function __construct( RegionMapperInterface $regionMapper ) {

        $this->regionMapper = $regionMapper;

    }
        
    /**
     * Fetches list of countries within the system
     */
    public function getListAsArray() {
        
    	return $this->regionMapper->getListAsArray();
        
    }
    
}

?>
