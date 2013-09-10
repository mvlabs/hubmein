<?php

namespace Conferences\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Conferences\DataFilter\RequestBuilder;

/**
 *
 * @author David Contavalli < mauipipe@gmail.com >
 * @copyright M.V. Associates for VDA (c) 2011 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */



class ConferenceRepository extends EntityRepository {
    
    const ANDQUERYVALUE = "AND";
    const ORQUERYVALUE = "OR";
       
    
    public function fetchAllByFilter(RequestBuilder $RequestBuilder) {
              
       $queryFilter = $this->createQuerySearch($RequestBuilder);
        
       $dql = "SELECT conference ".
              "FROM Conferences\Entity\Conference conference ".
              "LEFT JOIN conference.tags tag ".
              "LEFT JOIN conference.country country ".
              "LEFT JOIN country.region region ".
               $queryFilter.
              " ORDER BY conference.datefrom ASC ";
                   
       $result = $this->_em->createQuery($dql)->getResult();
        
             
       return $result;
        
    }    
    
    public function countByFilter(RequestBuilder $RequestBuilder){
        
        $queryFilter = $this->createQuerySearch($RequestBuilder);
        
        $dql = "SELECT COUNT(e.id) FROM Conferences\Entity\Conference e WHERE e.id IN (";
        $dql .= "SELECT conference.id  ";
        $dql .= "FROM Conferences\Entity\Conference conference ";
                if(sizeof($RequestBuilder->getTagList()) > 0) {
        $dql .= "LEFT JOIN conference.tags tag ";
                }
        $dql .="LEFT JOIN conference.country country ";
        $dql .="LEFT JOIN country.region region ";
        $dql .= $queryFilter;
        $dql .= ")";
                
        $result = $this->_em->createQuery($dql)->getScalarResult();
        $totalCount = (sizeof($result)> 0)? $result[0][1]:0;
        
       
        return $totalCount;
        
    }
            
    /**
     * Retrieve a region's list based on conferences with a still active cfps
     * @param boolean $activeCfps
     * @return array
     */
    public function fetchAllRegions( $activeCfps ) {
		
                $conditionCol = "dateto";
                $conditionQuery = "";
                
                if($activeCfps){
                    
                    $conditionCol = "cfpclosingdate";
                    $conditionQuery = 'AND (c.cfpclosingdate is not null) ';
                    
                }
        
		$s_query = 'SELECT r ' . 
		           'FROM \Conferences\Entity\Region r '.
		           'JOIN r.countries co '.
		           'JOIN co.conferences c '.
		           'WHERE c.'.$conditionCol.' >= CURRENT_DATE() ' .
		           $conditionQuery.
		           'AND c.isVisible = TRUE ' .
		           'ORDER BY r.id';
		           
		$I_query = $this->getEntityManager()->createQuery($s_query);
				
		return $I_query->getResult();
		
	}
    
    /**
     * Retrieve period's list based on upcoming conferences  
     * @param boolean $activeCfps
     * @return array 
     */
    public function fetchAllPeriods( $activeCfps ) {
		
                $conditionCol = "dateto";
                $conditionQuery = "";
                
                if($activeCfps){
                    
                    $conditionCol = "cfpclosingdate";
                    $conditionQuery = 'AND (c.cfpclosingdate is not null) ';
                    
                }
                
		$s_query =  'SELECT DISTINCT c.dateto as month_year '.
                            'FROM \Conferences\Entity\Conference c '.
                            'WHERE c.'.$conditionCol.' >= CURRENT_DATE() '.
                            $conditionQuery.
                           'AND c.isVisible = TRUE '.
		           'ORDER BY month_year';
		                
		$I_query = $this->getEntityManager()->createQuery($s_query);
                
		return $I_query->getResult();
		
    }
   
    /**
     * 
     * @param \Conferences\DataFilter\RequestBuilder $requestBuilder
     * @return string
     * @throws \Exception
     */
    private function createQuerySearch( RequestBuilder $requestBuilder ) {
               
        $filterDatas = $requestBuilder->toArray();
        $queries = array();
                   
        if( !array_key_exists('tc', $filterDatas) ) {
            
            throw new \OutOfBoundsException('key tc is not existent');        
            
        }
           
        if( sizeof($filterDatas)>0 ) {
                    
            foreach($filterDatas as $key => $value){
                
                switch( $key ) {
                    
                    case "region":
                        
                        $queries[$key] = $key .".slug LIKE '".$value."'";
                        
                        break;
                    case "dateFrom":
                        
                        $queries[$key] = "(conference.datefrom >= '".$value."'";
                                                
                        break;
                    case "dateTo":
                        
                        $queries[$key] = "conference.dateto <= '".$value."')";
                        
                        break;
                    case "tags":
                        
                        $queries[$key] = $this->buildTagQuery($filterDatas['tags'],$filterDatas['tc']);
                        
                        break;
                    case "activeCfp":
                        
                        $queries[$key] = "conference.cfpclosingdate >= CURRENT_DATE()";
                       
                        break;
                    case "default":
                        
                        throw new \Exception('No valid key passed on the query builder');
                       
                        break;
                }
                          
            }
               
        }
             
        if( sizeof($queries) == 0 ) {
            
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
                             
            $query .= " GROUP BY conference.id ";
            $query .= " HAVING COUNT(conference.id) = ".$tagNumber;
        }
               
        return $query;
    }
       
    
}
