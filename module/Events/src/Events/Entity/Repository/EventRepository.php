<?php

namespace Events\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Events\DataFilter\EventFilter;


class EventRepository extends EntityRepository {
    
    const ANDQUERYVALUE = "AND";
    const ORQUERYVALUE = "OR";
       
    
    public function getFilteredList(EventFilter $EventFilter) {
        
        $queryFilter = $this->buildQuerySearch($EventFilter);
        
       $dql = "SELECT events ".
              "FROM Events\Entity\Event events ".
              "LEFT JOIN events.tags tag ".
              "LEFT JOIN events.country country ".
              "LEFT JOIN country.region region ".
               $queryFilter.
             " ORDER BY events.datefrom ASC ";
              
      
       $result = $this->_em->createQuery($dql)->getResult();
        
             
        return $result;
        
    }    
    
    public function countFilteredItems(EventFilter $EventFilter){
        
        $queryFilter = $this->buildQuerySearch($EventFilter);
        
        $dql = "SELECT COUNT (events) ".
               "FROM Events\Entity\Event events ".
               "LEFT JOIN events.tags tag ".
               "LEFT JOIN events.country country ".
               "LEFT JOIN country.region region ".
               $queryFilter.
               
              
        $result = $this->_em->createQuery($dql)->getScalarResult();
        
        return $result[0][1];
        
    }
    
    private function buildQuerySearch(EventFilter $EventFilter) {
        
        $filterDatas = $EventFilter->toArray();
        $queries = array();
        
        if( !isset($filterDatas['tc']) ) {
            
            throw new \Exception('key tc is not existent');            
        }
        
        
        if( sizeof($filterDatas)>0 ) {
                    
            foreach($filterDatas as $key => $value){
                
                switch( $key ) {
                    
                    case "region":
                        
                        $queries[] = $key .".slug LIKE '".$value."'";
                        
                        break;
                    case "dateFrom":
                        
                        $queries[] = "(events.datefrom >= '".$value."'";
                                                
                        break;
                    case "dateTo":
                        
                        $queries[] = "events.dateto <= '".$value."')";
                        
                        break;
                    case "tags":
                        
                        $queries[] = $this->buildTagQuery($filterDatas['tags'],$filterDatas['tc']);
                        
                        break;
                    case "default":
                        
                        throw new \Exception('No valid key passed on the query builder');
                       
                        break;
                }
                          
            }
               
        }
      
        
        if( sizeof($queries) == 0 ) {
            
            return "";
            
        }
        
        return "WHERE ".implode( " ".self::ANDQUERYVALUE." ",$queries );
               
    }
    
    /**
     * Build the query to add tags with condition AND or OR based on tags['tags']['tc'] 's value
     * @param array $tags
     * @return string
     * @throws \Exceptions if there are no element on array $tags 
     */
    private function buildTagQuery( array $tags,$separator ) {
              
        if( sizeof( $tags ) == 0 ) {
            
            throw new \Exception("There are no value in the given array");
            
        }
                  
        $separator = self::ORQUERYVALUE;
        $querySql = "";
        $tagNumber = sizeof($tags);
        
        $querys = array();
               
        foreach($tags as $tag) {
            
            $querys[] = "tag.name LIKE '".$tag."'";
            
        }
              
        $querySql .= "(".implode(" ".$separator." ",$querys).")";
        $querySql .= " GROUP BY events.id ".
                     " HAVING COUNT( events.id ) = ".$tagNumber;
        
         return $querySql;
        
    }
    
    
}
