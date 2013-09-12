<?php

namespace Conferences\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\FileInput;

class ConferenceImageFilter extends InputFilter {
    	
    public function __construct() {   	
        
        $this->add(array(
            'name'       => 'image',
            'validators' => array(
                
                // add validator to check file extension
                array(
                    'name' => '\Zend\Validator\File\Extension',
                    'options' => array('extension' => array('jpg')),
                ),
                
                // add validator to check image size
                array(
                    'name' => '\Zend\Validator\File\ImageSize',
                    'options' => array('minWidth' => 90,
                                       'maxWidth' => 90,
                                       'minHeight' => 90,
                                       'maxHeight' => 90)
                ),
            )
        ));
        
    }
}
