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
     * @var bool
     */
    private $isCfp = false;
    
    /**
     * @var int
     */
    private $pageNumber = 1;


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
    
    
}