<?php

namespace Conferences\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\Validator;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class Conference extends Form {
    	
    public function __construct(ObjectManager $objectManager, array $tagList, array $countryList = null) {
        
        parent::__construct();
        
        // set for hydrator
        $this->setHydrator(new DoctrineHydrator($objectManager, '\Conferences\Entity\Conference'));
        
        // set form appearance
        $this->setAttribute('class', 'form-horizontal');
        
        $title = new Element\Text('title');
        $title->setAttributes(array('id'    => 'title',
                                    'class' => 'input-xxlarge',
                             ))
              ->setLabel('Conference name')
              ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($title);
        
        
        $abstract = new Element\Text('abstract');
        $abstract->setAttributes(array('id'    => 'abstract',
                                       'rows'  => '8', 
                                       'class' => 'input-xxlarge',
                                ))
                 ->setLabel('Abstract')
                 ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($abstract);
        
        
        $dateFrom = new Element\Date('datefrom');
        $dateFrom->setAttributes(array('id'    => 'datefrom',
                                       'class' => 'input-medium',
                                ))
                  ->setLabel('From')
                  ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($dateFrom);
        
        
        $dateTo = new Element\Date('dateto');
        $dateTo->setAttributes(array('id'    => 'dateto',
                                     'class' => 'input-medium',
                              ))
                ->setLabel('To')
                ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($dateTo);
        
        
        $country = new Element\Select('country');
        $country->setAttributes(array('id'    => 'country',
                               ))
                ->setLabel('Country')
                ->setLabelAttributes(array('class' => 'control-label'))
                ->setEmptyOption('Please choose...')
                ->setValueOptions($countryList);
        $this->add($country);
        
        
        $venue = new Element\Text('venue');
        $venue->setAttributes(array('id'    => 'venue',
                                    'class' => 'input-xxlarge',
                             ))
              ->setLabel('Venue')
              ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($venue);
        
        
        $city = new Element\Text('city');
        $city->setAttributes(array('id'    => 'city',
                                   'class' => 'input-xxlarge',
                            ))
             ->setLabel('City')
             ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($city);
        
        
        $address = new Element\Text('address');
        $address->setAttributes(array('id'    => 'address',
                                      'class' => 'input-xxlarge',
                               ))
                ->setLabel('Address')
                ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($address);
        
        
        $website = new Element\Text('website');
        $website->setAttributes(array('id'    => 'website',
                                      'class' => 'input-xxlarge', 
                               ))
                ->setLabel('Website')
                ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($website);
        
        
        $averagedayfee = new Element\Text('averagedayfee');
        $averagedayfee->setAttributes(array('id'    => 'averagedayfee',
                                     ))
                      ->setLabel('Avg Daily Fee')
                      ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($averagedayfee);
        
        
        $earlybirduntil = new Element\Date('earlybirduntil');
        $earlybirduntil->setAttributes(array('id'    => 'earlybirduntil',
                                             'class' => 'input-medium',
                                      ))
                       ->setLabel('Early bird until')
                       ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($earlybirduntil);
        
        
        $cfpclosingdate = new Element\Date('cfpclosingdate');
        $cfpclosingdate->setAttributes(array('id'    => 'cfpclosingdate',
                                             'class' => 'input-medium',
                                      ))
                       ->setLabel('CFP closing date')
                       ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($cfpclosingdate);
        
        
        $contactemail = new Element\Text('contactemail');
        $contactemail->setAttributes(array('id'   => 'contactemail',
                                           'class' => 'input-small',
                                    ))
                     ->setLabel('Contact email')
                     ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($contactemail);
        
        
        
        // social
        
        $hashtag = new Element\Text('hashtag');
        $hashtag->setAttributes(array('id'   => 'hashtag',
                                     'class' => 'input-small',
                               ))
                ->setLabel('Hashtag')
                ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($hashtag);
        
        
        $joindinid = new Element\Text('joindinid');
        $joindinid->setAttributes(array('id'    => 'joindinid',
                                        'class' => 'input-small',
                                 ))
                  ->setLabel('Joind.in ID')
                  ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($joindinid);
        
        
        $twitteraccount = new Element\Text('twitteraccount');
        $twitteraccount->setAttributes(array('id'    => 'twitteraccount',
                                             'class' => 'input-small',
                                      ))
                       ->setLabel('Twitter account')
                       ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($twitteraccount);
        
        
        // other
        $isinternational = new Element\Checkbox('isinternational');
        $isinternational->setAttributes(array('id'    => 'isinternational',
                                              'class' => 'input-small',
                                       ))
                        ->setLabel('Is international?')
                        ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($isinternational);
        
        
        $discountforstudents = new Element\Checkbox('discountforstudents');
        $discountforstudents->setAttributes(array('id'    => 'discountforstudents',
                                                  'class' => 'input-small',
                                           ))
                            ->setLabel('Discount for students?')
                            ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($discountforstudents);
        
        
        $discountforgroups = new Element\Checkbox('discountforgroups');
        $discountforgroups->setAttributes(array('id'    => 'discountforgroups',
                                                'class' => 'input-small',
                                         ))
                          ->setLabel('Discount for groups?')
                          ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($discountforgroups);
        
        
        $isvisible = new Element\Checkbox('isvisible');
        $isvisible->setAttributes(array('id'    => 'isvisible',
                                        'class' => 'input-small',
                                 ))
                  ->setLabel('Is visible?')
                  ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($isvisible);
        
        
        $isfeatured = new Element\Checkbox('isfeatured');
        $isfeatured->setAttributes(array('id'    => 'isfeatured',
                                         'class' => 'input-small',
                                  ))
                   ->setLabel('Is featured?')
                   ->setLabelAttributes(array('class' => 'control-label'));
        $this->add($isfeatured);
        
        
        // tags
        
        $tags = new \DoctrineModule\Form\Element\ObjectMultiCheckbox('tags');
        $tags->setLabel('Tags')
             ->setValueOptions($tagList)
             ->setOptions(array('object_manager' => $objectManager,
                                'target_class'   => 'Conferences\Entity\Tag'));
        $this->add($tags);
        
        $submit = new Element\Button('submit');
        $submit->setAttributes(array('type'  => 'submit', 
                                     'class' => 'btn'
                              ))
               ->setLabel('Save');
        $this->add($submit);

   	}	  
}