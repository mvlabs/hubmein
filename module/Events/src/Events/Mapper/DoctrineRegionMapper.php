<?php
namespace Events\Mapper;

use Events\Mapper\RegionMapperInterface;

use Doctrine\ORM\EntityManager;
/**
 *
 * @author MV Labs
 */
class DoctrineRegionMapper implements RegionMapperInterface{
    
    
    private $entityManager;
    private $countryRepository;
 
    public function __construct( EntityManager $entityManager ) 
    {
        
        $this->entityManager = $entityManager;
        $this->regionRepository = $this->entityManager->getRepository('Events\Entity\Region');
        
    }
    
    /*
     * Gets a list of countries
     * 
     * @return array
     */
    public function getFullList() 
    {
    	
        $regions = $this->regionRepository->findAll();
        $result = array();
        
        foreach ( $regions as $region ) {
            
            $result[$region->getId()] = $region->getName();
            
        }
                
        return $result;
        
    }

    public function getRegion( $id ) {
        
    }
    
}

?>
