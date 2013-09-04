<?php
namespace Events\View\Helper;

use Events\View\Helper\DispatchRouteViewInterface;

use Zend\View\Helper\AbstractHelper;
use Events\Service\EventService,
    Events\Service\TagService;



class RightSideBar extends AbstractHelper implements DispatchRouteViewInterface{

    const CFPS = "cfps";
    
    private $conferenceService;
    private $tagService;
    private $currentRequestParams = array();
    private $routeName;
    
    public function __construct(EventService $conferenceService, TagService $tagService, array $currentRequestParams) {
               
        $this->conferenceService = $conferenceService;
        $this->tagService = $tagService;
        $this->currentRequestParams = $currentRequestParams;
        
    }
    
    public function __invoke() {
               
        return  $this->view->render('partials/search_form', $this->setDataForPartial($this->conferenceService , $this->tagService, $this->currentRequestParams));
             
    }
    
    public function setRouteName($routeName) {
        
        $this->routeName = $routeName;
        
    }
    
    private function setDataForPartial( EventService $conferenceService, TagService $tagService, array $currentRequestParams ) {
        
        $filters = array();
        $activeCfps = ($this->routeName == self::CFPS) ? true:false;
            
        $filters['currentRequest'] = $currentRequestParams;
        $filters['regions'] = $conferenceService->getUpcomingConferencesRegions($activeCfps);
        $filters['periods'] = $conferenceService->getUpcomingConferencesPeriods($activeCfps);
        $filters['tags'] = $tagService->getTagListAsArray();
        
        return $filters;
        
    }

    
       
}