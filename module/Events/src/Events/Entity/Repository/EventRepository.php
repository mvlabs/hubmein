<?php

namespace Events\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Events\DataFilter\EventFilter;


class EventRepository extends EntityRepository {
    
    const DATE_REGEXP = "";
       
    
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
        
        $dql = "SELECT COUNT(e.id) FROM Events\Entity\Event e WHERE e.id IN (";
        $dql .= "SELECT events.id  ";
        $dql .= "FROM Events\Entity\Event events ";
                if(sizeof($EventFilter->getTagList()) > 0) {
        $dql .= "LEFT JOIN events.tags tag ";
                }
        $dql .="LEFT JOIN events.country country ";
        $dql .="LEFT JOIN country.region region ";
        $dql .= $queryFilter;
        $dql .= ")";
         
       
        $result = $this->_em->createQuery($dql)->getScalarResult();
        $totalCount = (sizeof($result)> 0)? $result[0][1]:0;
        
       
        return $totalCount;
        
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
                        
                        $queries[$key] = $key .".slug LIKE '".$value."'";
                        
                        break;
                    case "dateFrom":
                        
                        $queries[$key] = "(events.datefrom >= '".$value."'";
                                                
                        break;
                    case "dateTo":
                        
                        $queries[$key] = "events.dateto <= '".$value."')";
                        
                        break;
                    case "tags":
                        
                        $queries[$key] = $this->buildTagQuery($filterDatas['tags'],$filterDatas['tc']);
                        
                        break;
                    case "default":
                        
                        throw new \Exception('No valid key passed on the query builder');
                       
                        break;
                }
                          
            }
               
        }
             
        if(sizeof($queries) == 0) {
            
            return $this->addGroupBy();
            
        }
        
        return " WHERE ".implode( " ".self::ANDQUERYVALUE." ",$queries );
               
    }
    
    /**
     * Build the query to add tags 
     * @param array $tags
     * @return string
     * @throws \Exceptions if there are no element on array $tags 
     */
    private function buildTagQuery( array $tags,$condition ) {
              
        if( sizeof( $tags ) == 0 ) {
            
            throw new \Exception("There are no value in the given array");
            
        }
                  
        $separator = self::ORQUERYVALUE;
        $querySql = "";
        $tagNumber = sizeof($tags);
        
        $querys = array();
               
        foreach($tags as $tag) {
            
            $querys[] = "tag.name = '".$tag."'";
            
        }
           
        $querySql .= "(".implode(" ".$separator." ",$querys).")";
        
        if($condition == "all") {
             
            $querySql .= $this->addGroupBy($tagNumber);
            
        }
        
        return $querySql;
        
    }
    
   
    private function addGroupBy($tagNumber = null) {
        
        $query = "";
        
        if(isset($tagNumber)) {
                             
            $query .= " GROUP BY events.id ";
            $query .= " HAVING COUNT(events.id) = ".$tagNumber;
        }
               
        return $query;
    }
    
    
}
