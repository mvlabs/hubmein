<?php

namespace Conferences\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;

class TagFilter extends InputFilter {
    	
    public function __construct() {   	
		
		$this->add(array(
            'name'       => 'name',
            'required'   => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
            	array(
	                'name' => 'not_empty',
	            ),                
            ),
        ));
			
    }
}
