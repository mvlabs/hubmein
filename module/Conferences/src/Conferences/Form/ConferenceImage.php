<?php

namespace Conferences\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\Validator;

class ConferenceImage extends Form {
    	
    public function __construct() {
        
        parent::__construct();
        
        
        $image = new Element\File('image');
        $image->setAttributes(array('id', 'image-file'))
              ->setLabel('Conference image upload')
              ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($image);
        
        
        $submit = new Element\Button('submit');
        $submit->setAttributes(array('type'  => 'submit', 
                                     'class' => 'btn'
                              ))
               ->setLabel('Save');
        $this->add($submit);

   	}	  
}