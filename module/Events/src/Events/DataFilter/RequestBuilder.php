<?php

namespace Events\DataFilter;

/**
 * build a objet from a request
 *
 * @author David Contavalli < mauipipe@gmail.com >
 * @copyright M.V. Associates for VDA (c) 2011 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */


class RequestBuilder {
    
    /**
     * @var array
     */
    private $tagList;
    
    /**
     * @var \Events\Entity\Region
     */
    private $region;
    
    /**
     * @var DateTime
     */
    private $dateFrom;
    
    /**
     * @var DateTime
     */
    private $dateTo;
    
    /**
     * @var "string"
     */
    private $totalCount;
    
    
    /**
     * @var bool
     */
    private $isCfp = false;
       
    
    /**
     * @var int
     */
    private $pageNumber = 1;
    
    
    const TAGLIST_SEPARATOR = ",";
    const TOTALCOUNTDEFAULT = "all";
    
    
    private function __construct() {
        
    }
    
    public function getTagList(){
        
        return $this->tagList;
        
    }

    public function setTagList(array $tagList) {
        
        $this->tagList = $tagList;
        
    }
    
    
    public function setRegion($region) {
     
        $this->region = $region;
        
    }
    
    
    public function setDateFrom(\DateTime $dateFrom) {
        
        $this->dateFrom = $dateFrom;
        
    }
    
    
    public function setDateTo(\DateTime $dateTo) {
        
        $this->dateTo = $dateTo;
        
    }
    
    public function setPageNumber($pageNumber){
        
        $this->pageNumber = intval($pageNumber);
        
    }
    
    public function setTotalCount($totalCount) {
        
        $this->totalCount = $totalCount;
        
    }
     
    public static function createObjFromArray( $request ) {
        
       //init the Event filter object
        $RequestBuilder = new RequestBuilder();
        //Default page number
        $pageNumber = isset($request[ 'page' ]) ? $request[ 'page' ] : 1;
        
        $regionParam = isset($request['region']) ? $request['region'] : null;     
        $tcParam = isset( $request['tc']) ? $request['tc'] : self::TOTALCOUNTDEFAULT;
             
       
        //Set Period
        if( isset( $request[ 'period' ] ) && $request[ 'period' ] !== "" ) {
            
            $dateFrom =  '1-'.$request[ 'period' ];
            $dateFromObj = \DateTime::createFromFormat( 'd-F-Y',$dateFrom );
            $RequestBuilder->setDateFrom( $dateFromObj );
            
            $dateTo = date( "t-m-Y",  strtotime($dateFrom) );
            $dateToObj = \DateTime::createFromFormat( 'd-m-Y',$dateTo );
            $RequestBuilder->setDateTo( $dateToObj );
            
        }
       
        
        //Set tags 
        if( isset( $request['tags'] ) && !empty( $request['tags'] ) ) {
                       
            $tags = explode( self::TAGLIST_SEPARATOR,$request['tags'] );
            $RequestBuilder->setTagList($tags);
            
        }
        
               
        $RequestBuilder->setTotalCount( $tcParam );
        $RequestBuilder->setRegion( $regionParam );
        $RequestBuilder->setPageNumber($pageNumber);
              
        return $RequestBuilder; 
        
    }
    
    
    public function toArray() {
        
      $filterDatas = array();  
      $filterDatas['tc'] = $this->totalCount;     
      
      
      if(isset($this->region)) {
          
          $filterDatas['region'] = $this->region;
          
      }
      
      if(isset($this->dateFrom)) {
          
          $filterDatas['dateFrom'] = $this->dateFrom->format('Y-m-d')." 00:00:00";
          
      }
      
      
      if ( isset($this->dateTo) ) 
      {
          
          $filterDatas['dateTo'] = $this->dateTo->format('Y-m-d')." 00:00:00";
          
      }
      
      
      if ( isset($this->tagList) ) {
                   
          $filterDatas['tags'] = $this->tagList;
          
          
      }
     
      
      return $filterDatas;
      
    }
     
}