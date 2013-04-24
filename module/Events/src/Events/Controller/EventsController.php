<?php

namespace Events\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Transport;
use Zend\Mail\Message as Message;

class EventsController extends AbstractActionController
{
    private $I_promoteForm;
    private $I_eventService;
    
    public function __construct(\Events\Service\EventService $I_eventService, \Zend\Form\Form $I_promoteForm) {
        $this->I_eventService = $I_eventService;
        $this->I_promoteForm = $I_promoteForm;
    }
    
    public function indexAction()
    {
    	$i_country = $this->getAndCheckNumericParam('country');
    	return new ViewModel(array('events' => $this->I_eventService->getList($i_country)));
    }
    
    public function eventAction() {
    	$i_id = $this->getAndCheckNumericParam('id');
    	return new ViewModel(array('event' => $this->I_eventService->getEvent($i_id)));
    }

    public function promoteAction() {
        return array(
            'form' => $this->I_promoteForm,
        );
    }
    
    public function processAction(){
    
        $I_form = $this->I_promoteForm;
    
        if ($this->request->isPost()) {
            $as_post = $this->request->getPost()->toArray();
            
            $I_form->setData($as_post);
            
            if(!$I_form->isValid()) {
                
                print_r($I_form->getMessages());
                                
                $I_model = new ViewModel(array(
                    'error' => true,
                    'form'  => $I_form,
                ));
                $I_model->setTemplate('events/events/promote');
                return $I_model;
            } 
            
            $this->I_eventService->insertEventFromArray($as_post);
            
            return $this->redirect()->toRoute('events/thanks');
          
        }
    }
    
    public function thankyouAction() {
        return new ViewModel();
    }
    
}
