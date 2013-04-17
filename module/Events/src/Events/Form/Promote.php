<?php

namespace Events\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\Validator;

class Promote extends Form {
    	
    public function __construct($name = null) {
        
        parent::__construct('contact');
        
        $this->add(array(
            'name' => 'conference_name',
            'attributes' => array(
            	'id'    => 'conference_name',
                'label' => 'conference_name',
                'type'  => 'text',
            ),
        ));
        
        $this->add(array(
            'name' => 'conference_website',
            'attributes' => array(
                'id'    => 'conference_website',
                'label' => 'conference_website',
                'type'  => 'text',
            ),
        ));
		
        $this->add(array(
            'name'  => 'email',
            'attributes' => array(
                'id'    => 'email',
                'label' => 'Email',
                'type'  => 'text',
            ),
        ));
        
		$this->add(array(
            'name'  => 'about',
            'attributes' => array(
            	'id'    => 'about',
                'label' => 'about',
                'type'  => 'textarea',
                'cols'  => '40',
                'rows'  => '8',
            ),
        ));
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
            	'id'    => 'submit',
                'type'  => 'submit',
                'value' => 'Submit',
                'class' => 'bigbutton'
            ),
        ));
	}	  
}