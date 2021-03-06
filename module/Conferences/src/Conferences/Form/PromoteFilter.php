<?php

namespace Conferences\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;

class PromoteFilter extends InputFilter {
    	
    public function __construct() {   	
	
        $this->add(array(
            'email'   => 'email',
            'required'   => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
            	array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'message' => 'Email address format is invalid',
                    ),                
                ),
             ),
         ));
        
	$this->add(array(
            'name'       => 'title',
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
            'name'       => 'datefrom',
            'required'   => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
                array(
                    'name' => 'not_empty',
                ),
                new \Zend\Validator\Date(array('format' => 'Y-m-d'))
            ),
        ));

        $this->add(array(
            'name'       => 'dateto',
            'required'   => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
                array(
                    'name' => 'not_empty',
                ),
                new \Zend\Validator\Date(array('format' => 'Y-m-d'))
            ),
        ));

        $this->add(array(
            'name'       => 'mainsite',
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
