<?php
namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Events\Service\EventService,
    Events\Service\TagService;



class RightSideBar extends AbstractHelper {

    
    private $conferenceService;
    private $tagService;
    private $currentRequestParams = array();
       
    public function __construct(EventService $conferenceService, TagService $tagService, array $currentRequestParams) {
               
        $this->conferenceService = $conferenceService;
        $this->tagService = $tagService;
        $this->currentRequestParams = $currentRequestParams;
                     
    }
    
    public function __invoke() {
               
        return  $this->view->render('partials/search_form', $this->setDataForPartial($this->conferenceService , $this->tagService, $this->currentRequestParams));
             
    }
    
    private function setDataForPartial( EventService $conferenceService, TagService $tagService, array $currentRequestParams ) {
        
        $filters = array();
        
        $filters['currentsRequest'] = $currentRequestParams;
        $filters['regions'] = $conferenceService->getRegionByUpcomingConferences();
        $filters['periods'] = $conferenceService->getPeriodByUpcomingConferences();
        $filters['tags'] = $tagService->getTagListAsArray();
        
        return $filters;
        
    }
    
    /*private static function convertRegionToSlug($region) {
        
        return str_replace(" ","-",trim(strtolower(trim($region))));
    }*/

}