<?php

namespace Conferences\Form;

use Zend\Form\Form,
    Zend\Form\Element\Captcha,
    Zend\Captcha\Image as CaptchaImage,
    Zend\Form\Element\Email,
    Zend\Form\Element\Textarea,
    Zend\Form\Element\Text,
    Zend\Form\Element\Csrf,
    Zend\Validator;

class Promote extends Form {
       
    public function __construct(array $countryList = null, $name = 'contact') {
        
        parent::__construct($name);
        
                
        $dataFolder = './data/fonts';
        $defaultFont = 'arial.ttf';
        
        $email = new Email('email');
        $email->setName('email')
              ->setLabel('Your Email*')
              ->setAttributes(array(
                 'id'=>'email',
                 'type'=>'text'
              ));
        
        $title = new Text('title');
        $title->setLabel("Conference name*")
               ->setName('title')
               ->setAttributes( array(
                    'id'    => 'title',
               ));
        
        $dateFrom = new Text('datefrom');
        $dateFrom->setLabel("From*")
                 ->setName('dateFrom')
                 ->setAttributes( array(
                    'id' => 'dateFrom',
                    'maxLength'=>'100',
                    'class'=>'datepicker'
                 ));
        
        $dateTo = new Text('dateto');
        $dateTo->setLabel("To*")
                 ->setName('dateTo')
                 ->setAttributes( array(
                    'id' => 'dateTo',
                    'maxLength'=>'100',
                    'class'=>'datepicker' 
                 ));
        
        $webSite = new Text('mainsite');
        $webSite->setLabel("Event Website*")
                 ->setName('mainsite')
                 ->setAttributes( array(
                    'id' => 'mainsite',
                    'maxLength'=>'150'
                 ));
        
        $description = new Textarea('abstract');
        $description->setLabel("Description")
                 ->setName('abstract')
                 ->setAttributes( array(
                    'id' => 'abstract',
                    'maxLength'=>'160'
                 ));
        
        $tags = new Text('tags');
        $tags->setLabel("Tags")
             ->setName('tags')
             ->setAttributes( array(
                    'id' => 'tag',
                    'maxLength'=>'200'
                 ));
        
        $captchaImg = new CaptchaImage( array(
            'font'=>$dataFolder.DIRECTORY_SEPARATOR.$defaultFont,
            'width'=> 250,
            'height'=> 50,
            'doNoiseLevel'=> 40,
            'lineNoiseLevel'=> 3)
        );
        
        $captcha = new Captcha('captcha');
        $captcha->setCaptcha($captchaImg);
                                                
        $csrf = new Csrf('security');
        $csrf->setOptions(array(
           'csrf_options'=> array(
               'timeout'=>600
           ) 
        ));
        
        $submit = new Text('submit');
        $submit->setValue('Submit Conference')
               ->setAttributes(array(
                   'type'=>'submit',
                   'class'=>'bigbutton'                 
               ));
        	
        
        $this->add($email);
        $this->add($title);
        $this->add($dateFrom);
        $this->add($dateTo);
        $this->add($webSite);
        $this->add($description);
        $this->add($tags);
        $this->add($captcha);
        $this->add($csrf);
        $this->add($submit);
        
        /*
        $this->add(array(
        		'name' => 'venue',
        		'attributes' => array(
        				'id'    => 'venue',
        				
        		),
        		'options' => array(
        				'label' => 'Venue*',
        		),
        ));
        
        $this->add(array(
        		'name' => 'city',
        		'attributes' => array(
        				'id'    => 'city',
        				
        		),
        		'options' => array(
        				'label' => 'City*',
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
        				'label' => 'Country*',
        				'empty_option' => 'Please choose...',
        				'value_options' => $countryList
        				),
        		)
        );
       
        $this->add(array(
        		'name' => 'averagedayfee',
        		'attributes' => array(
        				'id'    => 'averagedayfee',
        				
        		),
        		'options' => array(
        				'label' => 'Avg Daily Fee',
        		),
        ));*/
    }	  
}