<?php

namespace Events\DataFilter;

class EventFilter {
    
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
        
        $this->setTotalCount($totalCount);
        
    }
      
    public static function createObjFromArray(array $request) {
        //init the Event filter object
        $EventFilter = new EventFilter();
        //Default page number
        $pageNumber = (isset($request[ 'page' ]))?$request[ 'page' ]:1;
        
      
        
        //Set Period
        if( isset( $request[ 'period' ] ) && $request[ 'period' ] !== "" ) {
            
            $datefromStringFormat =  '1-'.$request[ 'period' ];
            $dateFrom = \DateTime::createFromFormat( 'd-F-Y',$datefromStringFormat );
            $EventFilter->setDateFrom( $dateFrom );
            
            $dateToStringFormat = date( 't' )."-".$request[ 'period' ];
            $dateTo = \DateTime::createFromFormat( 'd-F-Y',$dateToStringFormat );
            $EventFilter->setDateTo( $dateTo );
            
        }
       
        //Set tags 
        if( isset( $request['tags'] ) && !empty( $request['tags'] ) ) {
                       
            $tags = explode( self::TAGLIST_SEPARATOR,$request['tags'] );
            $EventFilter->setTagList($tags);
            
        }
        
        if( isset( $request[ 'tc' ] ) ) {
            
            $EventFilter->setTotalCount( $request['tc'] );
           
        }
        
        $EventFilter->setRegion($request['region']);
        $EventFilter->setPageNumber($pageNumber);
              
        return $EventFilter; 
    }
    
    public function toArray(){
        
      $filterDatas = array();  
      
      if(isset($this->region)) {
          
          $filterDatas['region'] = $this->region;
          
      }
      
      if(isset($this->dateFrom)) {
          
          $filterDatas['dateFrom'] = $this->dateFrom->format('Y-m-d')." 00:00:00";
          
      }
      
       if(isset($this->dateTo)) {
          
          $filterDatas['dateTo'] = $this->dateTo->format('Y-m-d')." 00:00:00";
          
      }
      
      if(isset($this->tagList) && isset($this->totalCount)) {
                
          $filterDatas['tags'] = $this->tagList;
          $filterDatas['tags']['tc'] = $this->totalCount;
          
      }
      
      return $filterDatas;
      
    }
     
}