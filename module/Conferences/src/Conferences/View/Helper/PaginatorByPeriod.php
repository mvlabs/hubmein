<?php
namespace Conferences\View\Helper;

use Conferences\View\Helper\DispatchRouteViewInterface;

use Zend\View\Helper\AbstractHelper;

use Conferences\Service\ConferenceService;
/**
 * Description of PaginatorByPeriod
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class PaginatorByPeriod extends AbstractHelper implements DispatchRouteViewInterface {
    
    const CFPS = "cfps";
    const DEFAULT_PERIOD_KEY = "month_year";
    /**
     *
     * @var \Conferences\Service\ConferencesService
     */
    private $eventService;
    /**
     *
     * @var string
     */
    protected $routeName; 
    
    /**
     * 
     * @param \Conferences\Service\ConferenceService $eventService
     */
    public function __construct( ConferenceService $eventService ) {
        
        $this->eventService = $eventService;
                
    }
    
    /**
     * 
     * @param string $periodParam
     * @return string
     */
    public function __invoke( $periodParam ) {
             
        if($periodParam) {
            $activeCfps = ($this->routeName == self::CFPS) ? true:false;

            $periods = $this->eventService->getUpcomingConferencesPeriods($activeCfps);
            $dateTimeFromParam = new \DateTime($periodParam);
            $html = "<div class='pagination'>";

            if(($position = $this->findPeriodParamPosition($dateTimeFromParam, $periods))) {

                $prev = (isset($periods[$position - 1][self::DEFAULT_PERIOD_KEY])) ? $periods[$position - 1][self::DEFAULT_PERIOD_KEY] : null;
                $next = (isset($periods[$position + 1][self::DEFAULT_PERIOD_KEY])) ? $periods[$position + 1][self::DEFAULT_PERIOD_KEY] : null; 

            }

            if(isset($prev)) {

                $prevFormattedDate = strtolower($prev->format("F-Y"));
                $prevUrl = $this->view->url($this->routeName,array("controller"=>"events"))."?period=".$prevFormattedDate;
                $html .= "<a class='bigbutton navigation left' href='".$prevUrl."'>".$prevFormattedDate."</a>";

            }

            if(isset($next)) {

                $nextFormattedDate = strtolower($next->format("F-Y"));
                $nextUrl = $this->view->url($this->routeName,array("controller"=>"events"))."?period=".$nextFormattedDate;
                $html .= "<a class='bigbutton navigation right' href='".$nextUrl."'>".$nextFormattedDate."</a>";

            }

            return $html;
        }
    }
    
    public function setRouteName($routeName) {
        
        $this->routeName = $routeName;
        
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
