<?php
namespace Conferences\Mapper;

use Conferences\Mapper\RegionMapperInterface;

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
     * @var Conferences\Entity\Repository\ConferencesRepository 
     */
    private $regionRepository;
 
    public function __construct( EntityManager $entityManager ) {
        
        $this->entityManager = $entityManager;
        $this->regionRepository = $this->entityManager->getRepository('Conferences\Entity\Region');
        
    }
    
    /*
     * Gets a list of countries
     * 
     * @return array
     */
    public function getListAsArray() {
    	
        $regions = $this->regionRepository->getList();
       
        $result = array();
        
        foreach ( $regions as $region ) {
            
            $result[$region->getSlug()] = $region->getName();
            
        }
                
        return $result;
        
    }
   
}


