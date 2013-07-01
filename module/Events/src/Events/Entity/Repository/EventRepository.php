<?php

namespace Events\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Events\DataFilter\EventFilter;


class EventRepository extends EntityRepository {
    
    const DATE_REGEXP = "";
    
    public function getFilteredList(EventFilter $EventFilter) {
        
        $queryFilter = $this->buildQuerySearch($EventFilter);
        
       $dql = "SELECT events,country,region ".
               "FROM Events\Entity\Event events ".
               "INNER JOIN events.country country ".
               "INNER JOIN country.region region ".
               $queryFilter;
       
        /*$qb = $this->_em->createQueryBuilder();
        $dql = $qb->select('events,country,region')
            ->from($this->_entityName, 'events')
            ->join('events.country','country')
            ->join('country.region','region')
            ->getDQL();*/
        
        
        $result = $this->_em->createQuery($dql)->getResult();
        
       
        return $result;
        
    }    
    
    public function countFilteredItems(EventFilter $EventFilter){
        
        $queryFilter = $this->buildQuerySearch($EventFilter);
        
        $dql = "SELECT COUNT (events) ".
               "FROM Events\Entity\Event events ".
               "INNER JOIN events.country country ".
               "INNER JOIN country.region region ".
                $queryFilter;
        
        $result = $this->_em->createQuery($dql)->getScalarResult();
        
        return $result[0][1];
        
    }
    
    private function buildQuerySearch(EventFilter $EventFilter) {
        
        $filterDatas = $EventFilter->toArray();
        $queries = array();
              
        
        if( sizeof($filterDatas)>0 ) {
                    
            foreach($filterDatas as $key => $value){
                
                switch( $key ) {
                    case "region":
                        
                        $queries[] = $key .".name LIKE '".$value."'";
                        
                        break;
                    case "dateFrom":
                        
                        $queries[] = "events.datefrom >= '".$value."'";
                                                
                        break;
                    case "dateTo":
                        
                        $queries[] = "events.dateto <= '".$value."'";
                        
                        break;
                    case "default":
                        
                        throw new \Exception('No valid key passed on the query builder');
                       
                        break;
                }
                          
            }
            
        
        }
        if(sizeof($queries) == 0) {
            
            return "";
            
        }
            return "WHERE ".implode(" AND ",$queries);
               
    }
    
    
}
