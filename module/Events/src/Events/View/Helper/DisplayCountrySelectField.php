<?php

namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DisplayCountrySelectField extends AbstractHelper {

    private $countries;
    
    public function __construct($countries) {
        $this->countries = $countries;
    }
    
	public function __invoke() {
		
	    $html = '<select name="country" id="country">';
	    
	    foreach ($this->countries as $slug => $name) {
	        $html .= '<option value="' . $slug . '">' . $name . '</option>';
	    }
	    
	    $html .= '</select>';
	    
	    return $html;
	    
	}

}