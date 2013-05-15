<?php

namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class RightSideBar extends AbstractHelper {

    private $countries;
    
    private $currentCountry;
    
    public function __construct(Array $countries = null, $currentCountry) {
        $this->countries = $countries;
        $this->currentCountry = $currentCountry;
        
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
		foreach ($this->countries as $id => $name) {
			$html .= '<option value="' . $id . '"'.($this->currentCountry == $id?' selected="selected"':'').'>' . $name . '</option>';
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