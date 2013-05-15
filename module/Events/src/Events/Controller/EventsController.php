<?php

namespace Events\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
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
     * Class constructor
     * 
     * @param \Events\Service\EventService $eventService
     * @param \Zend\Form\Form $promoteForm
     */
    public function __construct(\Events\Service\EventService $eventService, \Zend\Form\Form $promoteForm) {
        $this->eventService = $eventService;
        $this->promoteForm = $promoteForm;
    }
    
    /**
     * Returns a list of events, as fethched from model
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
    	$country = $this->getAndCheckNumericParam('country');
    	return new ViewModel(array('events' => $this->eventService->getList($country)));
    }
    
    /**
     * Displays a specific event 
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function eventAction() {
    	$id = $this->getAndCheckNumericParam('id');
    	return new ViewModel(array('event' => $this->eventService->getEvent($id)));
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
    
}
