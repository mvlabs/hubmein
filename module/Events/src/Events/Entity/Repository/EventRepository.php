<?php

namespace Events\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Events\DataFilter\EventFilter;


class EventRepository extends EntityRepository {
    
    const ANDQUERYVALUE = "AND";
    const ORQUERYVALUE = "OR";
    
    private $tagQuerySeparator = array("all"=>self::ANDQUERYVALUE,"alo"=>self::ORQUERYVALUE);
    
    public function getFilteredList(EventFilter $EventFilter) {
        
        $queryFilter = $this->buildQuerySearch($EventFilter);
        
       $dql = "SELECT events,country,region ".
               "FROM Events\Entity\Event events ".
               "INNER JOIN events.country country ".
               "INNER JOIN country.region region ".
               "INNER JOIN events.tags tag ".
               $queryFilter;
       
       
        /*$qb = $this->_em->createQueryBuilder();
          $dql = $qb->select('events,country,region')
            ->from($this->_entityName, 'events')
            ->join('events.country','country')
            ->join('country.region','region')
            ->getDQL();*/
        
       
        $result = $this->_em->createQuery($dql)->getResult();
        
        var_dump($dql);
        var_dump($result);
        
        
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
                    case "tags":
                       
                        $queries[] = self::buildTagQuery($filterDatas['tags'], $filterDatas['tags']['tc']);
                        
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
     * @throws \Exceptions if there are no element on array $tags or if there is no filter set in $tags['tags']['tc']
     */
    private static function buildTagQuery( array $tags ) {
              
        if( sizeof( $tags ) == 0 ) {
            
            throw new \Exception("There are no value in the given array");
            
        }
        
        if( !isset( $tags['tags']['tc'] ) || empty( $tags['tags']['tc'] ) ) {
        
            throw new \Exception('tc key in tags array does not exist');
            
        }
                        
        $separator = $this->tagQuerySeparator[$tags['tags']['tc']];
        $querys = array();
                
        
        foreach($tags as $tag) {
            
            $querys[] = "tag.name = '".$tag."'";
            
        }
        
        return "(".implode(" ".$separator." ",$querys).")";
        
    }
    
    
}
