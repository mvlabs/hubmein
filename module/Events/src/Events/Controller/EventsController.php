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
            
        $conferences = $this->eventService->getListByFilter( $this->buildRequest() );
         
        return new ViewModel(array(
                            'conferences' => $conferences,
                     )
                );
                
    }
    
    /**
     * Display events with a call for paper still active
     */
    public function showcallForPaperAction(){
        
        $conferences = $this->eventService->getListByFilter($this->buildRequest());
        
        $viewModel = new ViewModel(
                array("conferences"=>$conferences)
                );
        $viewModel->setTemplate('events/events/index');
        
        return $viewModel;
        
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
                
                $viewModel = new ViewModel(array(
                    'error' => true,
                    'form'  => $form,
                ));
                $viewModel->setTemplate('events/events/promote');
                return $viewModel;
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
        
    /**
     * 
     * @return array 
     */
    private function countEvents() {
                         
       return $this->eventService->countListByFilter( $this->buildRequest() );
        
    }

    /**
     * Build an RequestBuilder object from a given array
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
        $requestParams['activeCfp'] = (isset($requestParamFromRoute['activeCfp']))?$requestParamFromRoute['activeCfp']:null; 
       
        return $requestParams;
        
    }
    
}
