<?php
namespace Events\Mapper;

use Events\Mapper\RegionMapperInterface;

use Doctrine\ORM\EntityManager;
/**
 *
 * @author MV Labs
 */
class DoctrineRegionMapper implements RegionMapperInterface{
    
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     *
     * @var Events\Entity\Repository\EventsRepository 
     */
    private $regionRepository;
 
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
    public function getListAsArray() 
    {
    	
        $regions = $this->regionRepository->getList();
       
        $result = array();
        
        foreach ( $regions as $region ) {
            
            $result[$region->getSlug()] = $region->getName();
            
        }
                
        return $result;
        
    }

    public function getRegion( $id ) {
        
    }
    
}

?>
