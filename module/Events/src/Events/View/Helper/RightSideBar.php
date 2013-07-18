<?php
namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;

class RightSideBar extends AbstractHelper {

    
    private $services = array();
    private $loadedCurrentDatas = array();
    
    
    const MAX_MONTH_NUMBER = 6;
    
    public function __construct(array $regions,array $tags, array $currentRequestDatas) {
               
        $this->services['regions'] = $regions;
        $this->services['tags'] = $tags;
        $this->loadedCurrentDatas['region'] = $currentRequestDatas['region'];
        $this->loadedCurrentDatas['period'] = $currentRequestDatas['period'];
                 
    }
    
    public function __invoke() {
            
            
            $this->getView()->render('partials/seach_form.phtml', $this->getValuesForPartial());
           
            //$urlPlugin = $this->view->plugin('url');
    
            
           // $url = $urlPlugin('events',array('controller'=>'events','action'=>'search'));
            
          /*
            $html .=  '<div class="rounded-box-title box">';
            $html .=      '<div class="box-inner clearfix">';
            $html .=         '<form id="search-form" name="search" action="" method="get" class="sidebar-form">';
            $html .=         '<p class="more-wrap">';
            $html .=            '<a class="more reset-filters">Clear filters</a>';
	    $html .=	      '</p>';
        
            $html .=           '<div>';
            $html .=           '<label for="location-1">Period: </label>';
            $html .=            '<select data-placeholder="select tag" multiple class="chzn-select topics" tabindex="8">';
            $html .=                '<option value="all"></option>';
                   
                               foreach( $this->tags as $tagName ) {
                                   
            $html .=                '<option value="'.$tagName.'"selected>'.$tagName.'</option>';
            
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
                                        foreach ( $this->regions as $region ) {
                                                
                                                $sluggedRegion = self::convertRegionToSlug($region);
                                                                                              
                                                $html .= '<option value="' . $sluggedRegion . '" '.( $this->requestRegion == $sluggedRegion ? 'selected':'' ).'>' . $region . '</option>';

                                        }
             $html .=              '</select>';
             $html .=             '</p>';
             $html .=              '<p>';
             $html .=             '<label for="location-1">Period: </label>';
             $html .=                '<select name="period">';
             $html .=                    '<option value="*" >All periods</option>';
                                      
                                           for( $monthRange = 0;$monthRange < self::MAX_MONTH_NUMBER;$monthRange++ ) {
                                              
                                               if( $monthRange > 0 )  {
                                                   
                                                   $currentDate = new \DateTime();
                                                   $DateInterval = new \DateInterval('P1M');
                                                   $currentDate->add($DateInterval);

                                               }            

                                               $html .= '<option value="' . $this->currentDate->format('F-Y') . '"'.( $this->requestPeriod == $this->currentDate->format('F-Y')?' selected="selected"':'' ).'>' . $this->currentDate->format('F-Y') . '</option>';

                                           }     
             $html .=                '</select>
                                      </p>
                                          <div class="loader"></div>
                                          <div class="count-loader"></div>
                                          <div class="result"></div>
                                          <div class="submit-loader"></div>
                                      <p><input type="submit" class="bigbutton" value="Refine"></p>
                                </form>
                          </div>
                     </div><!-- END: box -->
                
                

        return $html;
        */
    
    }
    
    private function getValuesForPartial() {
        
        $filters = array();
        
        $filters['currents'] = $this->loadedCurrentDatas;
        $filters['service'] = $this->services;
        
        return $filters;
        
    }
    
    /*private static function convertRegionToSlug($region) {
        
        return str_replace(" ","-",trim(strtolower(trim($region))));
    }*/

}