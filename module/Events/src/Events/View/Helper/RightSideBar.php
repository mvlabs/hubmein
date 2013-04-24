<?php

namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class RightSideBar extends AbstractHelper {

    private $as_countries;
    
    private $i_currentCountry;
    
    public function __construct(Array $as_countries = null, $i_currentCountry) {
        $this->as_countries = $as_countries;
        $this->currentCountry = $i_currentCountry;
        
    }
    
	public function __invoke() {
		
		$html = '<aside id="sidebar" class="fr">
		<div class="rounded-box-title box">
		<div class="box-inner clearfix">
		<form id="country-form" action="/events" method="get" class="sidebar-form">
		<div class="layout-slider">
		</div>
		<p><label for="location-1">Location: </label>
		<select name="country" id="country">';
		foreach ($this->as_countries as $i_id => $name) {
			$html .= '<option value="' . $i_id . '"'.($this->currentCountry == $i_id?' selected="selected"':'').'>' . $name . '</option>';
		}
		$html .= '</select></p>
		<p><a href="#" onclick="document.getElementById(\'country-form\').submit();" class="bigbutton">Refine</a></p>
		</form>
		</div>
		</div><!-- END: box -->
		</aside>
        <!-- END: sidebar -->';
	    
	    return $html;
	    
	}

}