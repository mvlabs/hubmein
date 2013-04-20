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
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Conference name',
            ),
        ));

        $this->add(array(
            'name' => 'conference_website',
            'attributes' => array(
                'id'    => 'conference_website',
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Conference website',
            ),
        ));
        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'id'    => 'email',
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
        
		$this->add(array(
            'name'  => 'about',
            'attributes' => array(
            	'id'    => 'about',
                'type'  => 'textarea',
                'cols'  => '40',
                'rows'  => '8',
            ),
		    'options' => array(
		        'label' => 'About',
		    )
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