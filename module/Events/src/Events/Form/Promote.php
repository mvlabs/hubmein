<?php

namespace Events\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\Validator;

class Promote extends Form {
    	
    public function __construct($name = null) {
        
        parent::__construct('contact');
        
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
            	'id'    => 'title',
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Conference name',
            ),
        ));

        $this->add(array(
            'name' => 'mainsitelink',
            'attributes' => array(
                'id'    => 'mainsitelink',
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
            'name'  => 'abstract',
            'attributes' => array(
            	'id'    => 'abstract',
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