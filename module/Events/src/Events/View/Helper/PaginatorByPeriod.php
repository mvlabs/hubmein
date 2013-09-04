<?php
namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Events\Service\EventService;
/**
 * Description of PaginatorByPeriod
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class PaginatorByPeriod extends AbstractHelper {
    
    const DEFAULT_ROUTE = "conferences";
    const DEFAULT_PERIOD_KEY = "month_year";
    
    private $eventService;
    protected $currentRoute; 
    
    public function __construct( EventService $eventService ) {
        
        $this->eventService = $eventService;
        $this->currentRoute = self::DEFAULT_ROUTE;
        
    }
    
    public function __invoke($periodParam = null) {
        
        $periods = $this->eventService->getPeriodByUpcomingConferences();
        $dateTimeFromParam = new \DateTime($periodParam);
        $html = "<div class='pagination'>";
        $prev = null;
        $next = $periods[1][self::DEFAULT_PERIOD_KEY];
                        
        if(($position = $this->findPeriodParamPosition($dateTimeFromParam, $periods)) && ($next != $dateTimeFromParam)) {
            
            $prev = (isset($periods[$position - 1][self::DEFAULT_PERIOD_KEY])) ? $periods[$position - 1][self::DEFAULT_PERIOD_KEY] : null;
            $next = (isset($periods[$position + 1][self::DEFAULT_PERIOD_KEY])) ? $periods[$position + 1][self::DEFAULT_PERIOD_KEY] : null; 
                   
        }
              
        if(isset($prev)) {
            
            $prevFormattedDate = strtolower($prev->format("F-Y"));
            $prevUrl = $this->view->url($this->currentRoute,array("controller"=>"events","action"=>""))."?period=".$prevFormattedDate;
            $html .= "<a class='bigbutton navigation left' href='".$prevUrl."'>".$prevFormattedDate."</a>";
            
        }
        
        if(isset($next)) {
            
            $nextFormattedDate = strtolower($next->format("F-Y"));
            $nextUrl = $this->view->url($this->currentRoute,array("controller"=>"events","action"=>""))."?period=".$nextFormattedDate;
            $html .= "<a class='bigbutton navigation right' href='".$nextUrl."'>".$nextFormattedDate."</a>";
            
        }
        
        return $html;
        
    }
    
    public function setCurrentRoute( $currentRoute ){
        
        $this->currentRoute = $currentRoute;
        
    }
    
    private function findPeriodParamPosition( $dateToSearch, array $periods ){
        
        foreach($periods as $position => $values ) {
                         
            if($values[self::DEFAULT_PERIOD_KEY]->format("F-Y") == $dateToSearch->format("F-Y")) {
                
                return $position;
                
            }
                
        }
        
    }
        
}

?>
