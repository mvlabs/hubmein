<?php

namespace Events\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;

class PromoteFilter extends InputFilter {
    	
    public function __construct() {   	
		
		$this->add(array(
            'name'       => 'conference_name',
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
		
		$this->add(array(
		    'name'       => 'conference_website',
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
			
    	$this->add(array(
            'name'       => 'email',
            'required'   => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
            	array(
	                'name' => 'not_empty',
	            ),
                array(
                    'name'    => 'EmailAddress',
                    'options' => array(
                        'allow'  => HostnameValidator::ALLOW_DNS,
                        'domain' => true
                    ),                    
                ),
            ),
        ));

    }
}
