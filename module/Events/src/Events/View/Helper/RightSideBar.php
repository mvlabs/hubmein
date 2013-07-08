<?php

namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class RightSideBar extends AbstractHelper {

    private $regions;
    private $tags;
    
    
    private $currentRegion;
    private $currentPeriod;
    
    const MAX_MONTH_NUMBER = 6;
    
    public function __construct(array $regions,array $tags, array $currentRequestDatas) {
        
        $this->regions = $regions;
        $this->tags = $tags;
        $this->requestRegion = $currentRequestDatas['region'];
        $this->requestPeriod = $currentRequestDatas['period'];
        $this->currentDate = new \DateTime();
        
      
    }
    
    public function __invoke() {
            
            $urlPlugin = $this->view->plugin('url');
            
            $url = $urlPlugin('events',array('controller'=>'events','action'=>'search'));
            
            $html = '<aside id="sidebar" class="fr">';
            $html .=  '<div class="rounded-box-title box">';
            $html .=      '<div class="box-inner clearfix">';
            $html .=         '<form id="search-form" name="search" action="'.$url.'" method="get" class="sidebar-form">';
            $html .=         '<p class="more-wrap">';
            $html .=            '<a class="more reset-filters">Clear filters</a>';
	    $html .=	      '</p>';
            $html .=          '<div class="layout-slider">';
            $html .=          '</div>';
            $html .=           '<div>';
            $html .=           '<label for="location-1">Period: </label>';
            $html .=            '<select data-placeholder="select tag" multiple class="chzn-select topics" tabindex="8">';
            $html .=                '<option value="all"></option>';
                   
                               foreach( $this->tags as $value ) {
                            
            $html .=                '<option>'.$value.'</option>';
            
                                 }
            $html .=            '</select>';
            $html .=            '<p class="type-condition">';
            $html .=                 '<input type="radio" checked="true" value="all" name="tc">All <input type="radio" value="alo" name="tc"> At least one';
	    $html .=		'</p> ';
            $html .=             '</div>';
            $html .=             '<p>';
            $html .=               '<label for="location-1">Location: </label>';
            $html .=               '<select name="region" id="region">';
            $html .=                    '<option value="*" >All regions</option>';
                                        foreach ( $this->regions as $name ) {
                                                
                                                $urlName = trim(strtolower(trim($name)));
                                                                                                
                                                $html .= '<option value="' . str_replace(" ","-",$urlName) . '"'.( $this->currentRegion == $name ?' selected="selected"':'' ).'>' . $name . '</option>';

                                        }
             $html .=              '</select>';
             $html .=             '</p>';
             $html .=              '<p>';
             $html .=             '<label for="location-1">Period: </label>';
             $html .=                '<select name="period">';
             $html .=                    '<option value="*" >All periods</option>';
                                      
                                           for( $monthRange = 0;$monthRange < self::MAX_MONTH_NUMBER;$monthRange++ ) {
                                              
                                               if( $monthRange > 0 )  {

                                                   $DateInterval = new \DateInterval('P1M');
                                                   $this->currentDate->add($DateInterval);

                                               }            

                                               $html .= '<option value="' . $this->currentDate->format('F-Y') . '"'.( $this->currentPeriod == $this->currentDate->format('F-Y')?' selected="selected"':'' ).'>' . $this->currentDate->format('F-Y') . '</option>';

                                           }     
             $html .=                '</select>
                                      </p>
                                      <div class="count-loader"></div>
                                      <div class="result"></div>
                                      <div class="loader"></div>
                                      <p><input type="submit" class="bigbutton" value="Refine"></p>
                                </form>
                          </div>
                     </div><!-- END: box -->
                    </aside>
                <!-- END: sidebar -->';

        return $html;

    }
      

}