<?php

namespace Conferences\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\Form\Form;

use Conferences\Service\ConferenceService,
    Conferences\Service\RegionService,
    Conferences\Service\TagService;
    
use Conferences\DataFilter\RequestBuilder,
    Zend\View\Model\JsonModel;

use Zend\Mail\Transport;
use Zend\Mail\Message as Message;

class ConferenceController extends AbstractActionController
{
    
    /**
     * Conference creation Form 
     *  
     * @var \Zend\Form\Form
     */
    private $promoteForm;
    
    /**
     * Main service for handling conferences (IE conferences)
     * 
     * @var \Conferences\Service\ConferenceService
     */
    private $conferenceService;
    
    /**
     *
     * @var \Conferences\Service\RegionService 
     */
    private $regionService;
    
    /**
     * Class constructor
     * 
     * @param \Conferences\Service\ConferenceService $conferenceService
     * @param \Zend\Form\Form $promoteForm
     * @param \Conferences\Service\RegionService
     * @param \Conferences\Service\TagService
     */
    public function __construct( ConferenceService $conferenceService,RegionService $regionService, TagService $tagService, Form $promoteForm ) {
       
        $this->regionService = $regionService;
        $this->conferenceService = $conferenceService;
        $this->promoteForm = $promoteForm;
        $this->tagService = $tagService;
    }
    
    /**
     * Returns a list of conferences, as fethched from model
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
            
        $conferences = $this->conferenceService->getListByFilter( $this->buildRequest() );
        $periodParam = $this->params()->fromQuery("period");
        $conferencesCount = $this->countConferences();
              
        return new ViewModel(array(
                            'conferences' => $conferences,
                            'periodParam' => $periodParam,
                            'count'=> $conferencesCount
                            )
                );
                
    }
    
    /**
     * Display conferences with a call for paper still active
     */
    public function showcallForPaperAction(){
        
        $conferences = $this->conferenceService->getListByFilter($this->buildRequest());
        $periodParam = $this->params()->fromQuery("period");
        
        $viewModel = new ViewModel(
                array("conferences"=>$conferences,
                      "periodParam"=>$periodParam)
                );
        $viewModel->setTemplate('conferences/conference/index');
        
        return $viewModel;
        
    }
    
    
    /**
     * Displays a specific conference 
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function conferenceAction() {
     
    	$id = $this->getAndCheckNumericParam('id');
    	
        return new ViewModel(array(
                                 'conference' => $this->conferenceService->getConference($id)
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
                $viewModel->setTemplate('conferences/conference/promote');
                return $viewModel;
            } 
            
            $this->conferenceService->insertConferenceFromArray($post);
            
            return $this->redirect()->toRoute('conferences/thanks');
          
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
     * Search conferences action
     * 
     * Retrieves conferences list according to the filters the user have defined 
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function searchAction() {
      
        $conferences = $this->searchConferences();
             
        $viewModel = new ViewModel(array('conferences' => $conferences));
        
        $viewModel->setTemplate('conferences/conference/index');
               
        return $viewModel;
        
    }
    
    /**
     * Search conferences action
     * 
     * Retrieves conferences list according to the filters the user have defined 
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function countAction() {
      
        $conferencesNr = $this->countConferences();
               
        $result = new JsonModel(array(
	    
            'count' => $conferencesNr,
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
    private function countConferences() {
       
       return $this->conferenceService->countListByFilter( $this->buildRequest() );
        
    }

    /**
     * Build an RequestBuilder object from a given array
     * @return \Conferences\DataFilter\RequestBuilder
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
