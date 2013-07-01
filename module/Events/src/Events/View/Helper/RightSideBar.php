<?php

namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class RightSideBar extends AbstractHelper {

    private $countries;
    
    private $currentRegion;
    private $currentPeriod;
    
    const MAX_MONTH_NUMBER = 6;
    
    public function __construct(array $regions,array $currentRequestDatas) {
        
        $this->regions = $regions;
        $this->requestRegion = $currentRequestDatas['region'];
        $this->requestPeriod = $currentRequestDatas['period'];
        $this->currentDate = new \DateTime();
    }
    
    public function __invoke() {
            
            $urlPlugin = $this->view->plugin('url');
            
            $url = $urlPlugin('events/regionfilter',array('controller'=>'events','action'=>'search','region'=>'Africa'));
            
            $html = '<aside id="sidebar" class="fr">';
            $html .=  '<div class="rounded-box-title box">';
            $html .=      '<div class="box-inner clearfix">';
            $html .=         '<form id="country-form" action="'.$url.'" method="get" class="sidebar-form">';
            $html .=          '<div class="layout-slider">';
            $html .=             '</div>';
            $html .=                '<p>';
            $html .=                '<label for="location-1">Location: </label>';
            $html .=                '<select name="region" id="region">';
            $html .=                    '<option value="" >All regions</option>';
                                        foreach ( $this->regions as $id => $name ) {

                                                $html .= '<option value="' . $id . '"'.( $this->currentRegion == $id?' selected="selected"':'' ).'>' . $name . '</option>';

                                        }
             $html .=                '</select>';
             $html .=                '</p>';
             $html .=                '<p>';
             $html .=                '<select name="period">';
             $html .=                    '<option value="" >All periods</option>';
                                      
                                           for( $monthRange = 0;$monthRange < self::MAX_MONTH_NUMBER;$monthRange++ ) {
                                              
                                               if( $monthRange > 0 )  {

                                                   $DateInterval = new \DateInterval('P1M');
                                                   $this->currentDate->add($DateInterval);

                                               }            

                                               $html .= '<option value="' . $this->currentDate->format('F-Y') . '"'.( $this->currentPeriod == $this->currentDate->format('F-Y')?' selected="selected"':'' ).'>' . $this->currentDate->format('F-Y') . '</option>';

                                           }     
             $html .=                '</select>
                                      </p>
                                      <p><a href="#" onclick="document.getElementById(\'country-form\').submit();" class="bigbutton">Refine</a></p>
                                </form>
                          </div>
                     </div><!-- END: box -->
                    </aside>
                <!-- END: sidebar -->';

        return $html;

    }

}