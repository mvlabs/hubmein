<?php

namespace Events\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\Validator;

class Promote extends Form {
    	
    public function __construct(array $countryList = null, $name = 'contact') {
        
        parent::__construct($name);
        
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
       			'name' => 'datefrom',
       			'attributes' => array(
       					'id'    => 'datefrom',
       					'type'  => 'text',
       			),
       			'options' => array(
       					'label' => 'From',
       			),
       	));
       	
       	$this->add(array(
       			'name' => 'dateto',
       			'attributes' => array(
       					'id'    => 'dateto',
       					'type'  => 'text',
       			),
       			'options' => array(
       					'label' => 'To',
       			),
       	));
       	
        
        $this->add(array(
        		'name' => 'venue',
        		'attributes' => array(
        				'id'    => 'venue',
        				'type'  => 'text',
        		),
        		'options' => array(
        				'label' => 'Venue',
        		),
        ));
        
        $this->add(array(
        		'name' => 'city',
        		'attributes' => array(
        				'id'    => 'city',
        				'type'  => 'text',
        		),
        		'options' => array(
        				'label' => 'City',
        		),
        ));
        
        $this->add(array(
        		'name' => 'country',
        		'attributes' => array(
        				'id'    => 'city',
        				'type'  => 'select',
        		),
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array(
        				'label' => 'Country',
        				'empty_option' => 'Please choose...',
        				'value_options' => $countryList
        				),
        		)
        );
        
        $this->add(array(
            'name' => 'mainsitelink',
            'attributes' => array(
                'id'    => 'mainsitelink',
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Website',
            ),
        ));
        

        $this->add(array(
        		'name' => 'averagedayfee',
        		'attributes' => array(
        				'id'    => 'averagedayfee',
        				'type'  => 'text',
        		),
        		'options' => array(
        				'label' => 'Avg Daily Fee',
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
        	'options' => array('label' => '.')
        ));
	}	  
}