<?php
namespace Conferences\Service;

use Conferences\Mapper\RegionMapperInterface;

/**
 *
 * @author MVLabs
 */

class RegionService {
    
    /*
     * @var \Conferences\Mapper\RegionMapper Event Mapper
     */
    private $regionMapper = null;


    /*
     * Constructs service 
     * 
     * @param \Conferences\Mapper\RegionMapper Event Mapper
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
