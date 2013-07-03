<?php

namespace Events\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\Validator;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Tag extends Form {
    	
    public function __construct(array $countryList = null) {
        
        parent::__construct();
        
        // set for hydrator
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new \Events\Entity\Tag());
        
        // set form appearance
        $this->setAttribute('class', 'form-horizontal');
        
        $title = new Element\Text('name');
        $title->setAttributes(array('id'    => 'title',
                                    'type'  => 'text',
                                    'class' => 'input-large',
                             ))
              ->setLabel('Tag name')
              ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($title);
        
        
        $submit = new Element\Button('submit');
        $submit->setAttributes(array('type'  => 'submit', 
                                     'class' => 'btn'
                              ))
               ->setLabel('Save');
        $this->add($submit);

   	}	  
}