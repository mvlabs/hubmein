<?php

namespace Events\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\Validator;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class Event extends Form {
    	
    public function __construct(array $tagList, array $countryList = null) {
        
        parent::__construct();
        
        // set for hydrator
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new \Events\Entity\Event());
        
        // set form appearance
        $this->setAttribute('class', 'form-horizontal');
        
        $title = new Element\Text('title');
        $title->setAttributes(array('id'    => 'title',
                                    'type'  => 'text',
                                    'class' => 'input-xxlarge',
                             ))
              ->setLabel('Conference name')
              ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($title);
        
        
        $abstract = new Element\Text('abstract');
        $abstract->setAttributes(array('id'    => 'abstract',
                                       'type'  => 'textarea',
                                       'rows'  => '8', 
                                       'class' => 'input-xxlarge',
                                ))
                 ->setLabel('Abstract')
                 ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($abstract);
        
        
        $dateFrom = new Element\Text('datefrom');
        $dateFrom->setAttributes(array('id'    => 'datefrom',
                                       'type'  => 'date',
                                       'class' => 'input-medium',
                                ))
                  ->setLabel('From')
                  ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($dateFrom);
        
        
        $dateTo = new Element\Text('dateto');
        $dateTo->setAttributes(array('id'    => 'dateto',
                                     'type'  => 'date',
                                     'class' => 'input-medium',
                              ))
                ->setLabel('To')
                ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($dateTo);
        
        
        $country = new Element\Select('country');
        $country->setAttributes(array('id'    => 'country',
                                      'type'  => 'select',
                               ))
                ->setLabel('Country')
                ->setLabelAttributes(array('class' => 'control-label'))
                ->setEmptyOption('Please choose...')
                ->setValueOptions($countryList);
        $this->add($country);
        
        
        $venue = new Element\Text('venue');
        $venue->setAttributes(array('id'    => 'venue',
                                    'type'  => 'text',
                                    'class' => 'input-xxlarge',
                             ))
              ->setLabel('Venue')
              ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($venue);
        
        
        $city = new Element\Text('city');
        $city->setAttributes(array('id'    => 'city',
                                   'type'  => 'text',
                                   'class' => 'input-xxlarge',
                            ))
             ->setLabel('City')
             ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($city);
        
        
        $address = new Element\Text('address');
        $address->setAttributes(array('id'    => 'address',
                                      'type'  => 'text',
                                      'class' => 'input-xxlarge',
                               ))
                ->setLabel('Address')
                ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($address);
        
        
        $website = new Element\Text('website');
        $website->setAttributes(array('id'    => 'website',
                                      'type'  => 'text',
                                      'class' => 'input-xxlarge', 
                               ))
                ->setLabel('Website')
                ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($website);
        
        
        $averagedayfee = new Element\Text('averagedayfee');
        $averagedayfee->setAttributes(array('id'    => 'averagedayfee',
                                            'type'  => 'text',
                                     ))
                      ->setLabel('Avg Daily Fee')
                      ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($averagedayfee);
        
        
        $earlybirduntil = new Element\Text('earlybirduntil');
        $earlybirduntil->setAttributes(array('id'    => 'earlybirduntil',
                                             'type'  => 'date',
                                             'class' => 'input-medium',
                                      ))
                       ->setLabel('Early bird until')
                       ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($earlybirduntil);
        
        
        $cfpclosingdate = new Element\Date('cfpclosingdate');
        $cfpclosingdate->setAttributes(array('id'    => 'cfpclosingdate',
                                             'type'  => 'date',
                                             'class' => 'input-medium',
                                      ))
                       ->setLabel('CFP closing date')
                       ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($cfpclosingdate);
        
        
        $contactemail = new Element\Text('contactemail');
        $contactemail->setAttributes(array('id'   => 'contactemail',
                                           'type'  => 'text',
                                           'class' => 'input-small',
                                    ))
                     ->setLabel('Contact email')
                     ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($contactemail);
        
        
        
        // social
        
        $hashtag = new Element\Text('hashtag');
        $hashtag->setAttributes(array('id'   => 'hashtag',
                                     'type'  => 'text',
                                     'class' => 'input-small',
                               ))
                ->setLabel('Hashtag')
                ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($hashtag);
        
        
        $joindinid = new Element\Text('joindinid');
        $joindinid->setAttributes(array('id'    => 'joindinid',
                                        'type'  => 'text',
                                        'class' => 'input-small',
                                 ))
                  ->setLabel('Joind.in ID')
                  ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($joindinid);
        
        
        $twitteraccount = new Element\Text('twitteraccount');
        $twitteraccount->setAttributes(array('id'    => 'twitteraccount',
                                             'type'  => 'text',
                                             'class' => 'input-small',
                                      ))
                       ->setLabel('Twitter account')
                       ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($twitteraccount);
        
        
        // other
        $isinternational = new Element\Checkbox('isinternational');
        $isinternational->setAttributes(array('id'    => 'isinternational',
                                              'type'  => 'checkbox',
                                              'class' => 'input-small',
                                       ))
                        ->setLabel('Is international?')
                        ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($isinternational);
        
        
        $discountforstudents = new Element\Checkbox('discountforstudents');
        $discountforstudents->setAttributes(array('id'    => 'discountforstudents',
                                                  'type'  => 'checkbox',
                                                  'class' => 'input-small',
                                           ))
                            ->setLabel('Discount for students?')
                            ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($discountforstudents);
        
        
        $discountforgroups = new Element\Checkbox('discountforgroups');
        $discountforgroups->setAttributes(array('id'    => 'discountforgroups',
                                                'type'  => 'checkbox',
                                                'class' => 'input-small',
                                         ))
                          ->setLabel('Discount for groups?')
                          ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($discountforgroups);
        
        
        $isvisible = new Element\Checkbox('isvisible');
        $isvisible->setAttributes(array('id'    => 'isvisible',
                                        'type'  => 'checkbox',
                                        'class' => 'input-small',
                                 ))
                  ->setLabel('Is visible?')
                  ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($isvisible);
        
        
        $isfeatured = new Element\Checkbox('isfeatured');
        $isfeatured->setAttributes(array('id'    => 'isfeatured',
                                         'type'  => 'checkbox',
                                         'class' => 'input-small',
                                  ))
                   ->setLabel('Is featured?')
                   ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($isfeatured);
        
        
        // tags
        
        $tags = new Element\MultiCheckbox('tags');
        $tags->setLabel('Tags')
             ->setValueOptions($tagList);
        $this->add($tags);
        
        $submit = new Element\Button('submit');
        $submit->setAttributes(array('type'  => 'submit', 
                                     'class' => 'btn'
                              ))
               ->setLabel('Save');
        $this->add($submit);

   	}	  
}