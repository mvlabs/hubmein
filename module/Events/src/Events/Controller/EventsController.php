<?php

namespace Events\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\Form\Form;

use Events\Service\EventService,
    Events\Service\RegionService,
    Events\Service\TagService;
    
use Events\DataFilter\RequestBuilder,
    Zend\View\Model\JsonModel;


use Zend\Mail\Transport;
use Zend\Mail\Message as Message;

class EventsController extends AbstractActionController
{
    
    /**
     * Event creation Form 
     *  
     * @var \Zend\Form\Form
     */
    private $promoteForm;
    
    /**
     * Main service for handling events (IE conferences)
     * 
     * @var \Events\Service\EventService
     */
    private $eventService;
    
    /**
     *
     * @var \Events\Service\RegionService 
     */
    private $regionService;
    
   /**
    *
    * @var \Events\Service\TagService
    */
    private $tagService;
    
    /**
     * Class constructor
     * 
     * @param \Events\Service\EventService $eventService
     * @param \Zend\Form\Form $promoteForm
     * @param \Events\Service\RegionService
     * @param \Events\Service\TagService
     */
    public function __construct( EventService $eventService,RegionService $regionService, TagService $tagService, Form $promoteForm ) {
       
        $this->regionService = $regionService;
        $this->eventService = $eventService;
        $this->promoteForm = $promoteForm;
        $this->tagService = $tagService;
        
    }
    
    /**
     * Returns a list of events, as fethched from model
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        
    	//$region = $this->getAndCheckNumericParam('region');
        $requestBuilder = RequestBuilder::createObjFromArray($this->mergeRequest());
       
        // @todo pass class to event service
        $conferences = $this->eventService->getListByFilter($requestBuilder);
         
        return new ViewModel(array(
            
            'conferences' => $conferences,
         
            
        ));
                
    }
    
    /**
     * Displays a specific event 
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function eventAction() {
     
    	$id = $this->getAndCheckNumericParam('id');
    	
        return new ViewModel(array(
                                 'event' => $this->eventService->getEvent($id)
                            )
        );
        
    }

    /**
     * Displays promote page (with form)
     * 
     * @return multitype:\Zend\Form\Form
     */
    public function promoteAction() {
        
        return array(
            
            'form' => $this->promoteForm,
            
        );
        
    }
    
    /**
     * Form post handling
     * 
     * @return \Zend\View\Model\ViewModel|\Zend\Http\Response
     */
    public function processAction(){
    
        $form = $this->promoteForm;
    
        if ($this->request->isPost()) {
            $post = $this->request->getPost()->toArray();
            
            $form->setData($post);
            
            if(!$form->isValid()) {
                
                $model = new ViewModel(array(
                    'error' => true,
                    'form'  => $form,
                ));
                $model->setTemplate('events/events/promote');
                return $model;
            } 
            
            $this->eventService->insertEventFromArray($post);
            
            return $this->redirect()->toRoute('events/thanks');
          
        }
    }
    
    /**
     * Thank you action
     * 
     * After form has been submitted, user is sent here, so that 
     * a refresh user action won't harm model
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function thankyouAction() {
        
        return new ViewModel();
        
    }
    
    
    /**
     * Search events action
     * 
     * Retrieves events list according to the filters the user have defined 
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function searchAction() {
      
        $events = $this->searchEvents();
               
        $viewModel = new ViewModel(array('events' => $events));
        $viewModel->setTemplate('events/events/index');
               
        return $viewModel;
        
    }
    
    /**
     * Search events action
     * 
     * Retrieves events list according to the filters the user have defined 
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function countAction() {
      
        $eventsNr = $this->countEvents();
               
        $result = new JsonModel(array(
	    
            'count' => $eventsNr,
            'success'=>true,
            
        ));
        
        return $result;
        
    }
    
    
    /*
     * Private methods
     */
    private function listEvents() {
        
      
        //@TODO is the method createFilterFromUrlParam really necessary using a builder ?
        // get params from url and prepare RequestBuilder class
        $requestBuilder = $this->buildRequest();
               
        return $this->eventService->getListByFilter( $requestBuilder );
        
    }
    
    
    private function countEvents() {
                         
        // get params from url and prepare RequestBuilder class
       
        $requestBuilder = $this->buildRequest();
        
        return $this->eventService->countByFilter($requestBuilder);
        
    }

    /**
     *      * Build an RequestBuilder object from a given array
     * @param array $filteredRequest
     * @return \Events\DataFilter\RequestBuilder
     */
    private function buildRequest() {
                  
        return  RequestBuilder::createObjFromArray( $this->mergeRequest() );
        
    }
    
    /**
     * Merge region parameter from route with search request parameters
     * @return array $requestParams
     */
    private function mergeRequest() {
       
        $requestParams = $this->params()->fromQuery();
        $requestParamFromRoute = $this->params()->fromRoute();
        $requestParams['region'] = (isset($requestParamFromRoute['region']))?$requestParamFromRoute['region']:null; 
                
        return $requestParams;
        
    }
    
}
