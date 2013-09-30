<?php

namespace Conferences\Form;

use Zend\Form\Form,
    Zend\Form\Element\Captcha,
    Zend\Captcha\Image as CaptchaImage,
    Zend\Form\Element\Email,
    Zend\Form\Element\Textarea,
    Zend\Form\Element\Text,
    Zend\Form\Element\Csrf,
    Zend\Form\Element\File,
    Zend\Form\Element\Date,
    Zend\Validator;

class Promote extends Form {
       
    public function __construct(array $countryList = null, $name = 'contact') {
        
        parent::__construct($name);
                    
        $dataFolder = './data/fonts';
        $defaultFont = 'arial.ttf';
        
        $email = new Email('email');
        $email->setLabel('Your Email*')
              ->setAttributes(array(
                  'multiple'=>true,
                 'id'=>'email',
                 'type'=>'text',
              ))->setValidator(new Validator\EmailAddress(array("message"=>"wrong mail format")));
        
        
        
        $title = new Text('title');
        $title->setLabel("Conference name*")
               ->setName('title')
               ->setAttributes( array(
                    'id'    => 'title',
               ));
        
        $dateFrom = new Date('datefrom');
        $dateFrom->setLabel("From*")
                 ->setName('dateFrom')
                 ->setAttributes( array(
                    'id' => 'dateFrom',
                    'maxLength'=>'100',
                    'class'=>'datepicker'
                 ));
        
        $dateTo = new Date('dateto');
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
         
        $address = new Text('address');
        $address->setLabel('Address')
                ->setName('address')
                ->setAttributes( array(
                   'id' => 'address',
                   'maxLength' => '200'
                ));
        
        $country = new Text('country');
        $country->setLabel('country')
                ->setName('address')
                ->setAttributes( array(
                   'id' => 'address',
                   'maxLength' => '200'
                ));
        
        $city = new Text('city');
        $city->setLabel('City')
                ->setName('city')
                ->setAttributes( array(
                   'id' => 'city',
                   'maxLength' => '200'
                ));
        
        $venue = new Text('venue');
        $venue->setLabel('Venue')
              ->setName('venue')
              ->setAttributes( array(
                 'id' => 'venue',
                  'maxLength' => '200'
                  
              ));
        
        $twitterAccount = new Text('twitteraccount');
        $twitterAccount->setLabel('Twitter Account')
              ->setName('twitteraccount')
              ->setAttributes( array(
                 'id' => 'twitter-account',
                  'maxLength' => '200'
                  
              ));
                
       $twitterHashTag = new Text('twitterhashtag');
       $twitterHashTag->setLabel('Twitter Hashtag')
              ->setName('twitterhashtag')
              ->setAttributes( array(
                 'id' => 'twitter-hashtag',
                 'maxLength' => '200'
              ));
       
       $logo = new File('image-file');
       $logo->setLabel('Upload Logo')
              ->setName('logo')
              ->setAttributes( array(
                 'id' => 'conferencelogo',
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
        $this->add($country);
        $this->add($city);
        $this->add($venue);
        $this->add($address);
        $this->add($twitterAccount);
        $this->add($twitterHashTag);
        $this->add($logo);
        $this->add($captcha);
        $this->add($csrf);
        $this->add($logo);    
        $this->add($submit);
               
    }	  
}