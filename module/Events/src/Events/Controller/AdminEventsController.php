<?php

namespace Events\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Transport;
use Zend\Mail\Message as Message;

class AdminEventsController extends AbstractActionController
{
    
    /**
     * Event creation and edit Form 
     *  
     * @var \Zend\Form\Form
     */
    private $form;
    
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
    public function __construct(\Events\Service\EventService $eventService, \Events\Form\Event $form) {
        $this->eventService = $eventService;
        $this->form = $form;
    }
    
    /**
     * Returns a list of events, as fethched from model
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
    	return new ViewModel(array('events' => $this->eventService->getList()));
    }
    
    /**
     * Add new event
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction() 
    {
        $this->processForm();
        
        $view = new ViewModel(array('form' => $this->form, 'title' => 'New event'));
        $view->setTemplate('events/admin-events/event-form');
        return $view;
    }
    
    /*
     * public function editAction()
    {
        $I_dog = $this->getEntityFromQuerystring();
                
        // bind entity values to form
        $this->I_form->bind($I_dog);
        
        $I_view = new ViewModel(array('form' => $this->I_form, 'title' => 'Edit dog'));
        $I_view->setTemplate('mva-module-template/index/dog-form');
        return $I_view;
    }
    
    public function deleteAction()
    {
        $I_dog = $this->getEntityFromQuerystring();
                
        $this->I_service->deleteDog($I_dog);
        
        return $this->redirect()->toRoute('mva-module-template');
    }
     */
    
    
    /*
     * Private methods
     */
    
    private function processForm() {
        
        if ($this->request->isPost()) {
        
            $event = $this->getEventFromQuerystring(true);
            
            // bind entity values to form
            if (!($event instanceof \Events\Entity\Event)) {
                $this->form->bind($event);
                $confirmMessage = 'Event ' . $event->getTitle() . ' updated successfully';
            } else {
                $confirmMessage = 'Event inserted successfully';
            }
            
            // get post data
            $post = $this->request->getPost()->toArray();
                        
            // fill form
            $this->form->setData($post);
        
            // check if form is valid
            if(!$this->form->isValid()) {
        
                // prepare view
                $I_view = new ViewModel(array('form'  => $this->form,
                                              'title' => 'Some errors during event processing'));
                $view->setTemplate('events/admin-events/event-form');
                return $I_view;
        
            }
        
            // use service to save data
            $event = $this->service->upsertEventFromArray($this->form->getData());
        
            $this->flashMessenger()->setNamespace('admin-event')->addMessage($confirmMessage);
            
        }
        
    }
    
    private function getEventFromQuerystring($allowNull = false) {
    
        $id = (int)$this->params('id');
    
        if (empty($id) || $id <= 0){
            $this->getResponse()->setStatusCode(404);    //@todo there is a better way?
            // Probably triggering Not Found Event SM
            // Zend\Mvc\Application: dispatch.error
            return;
        }
    
        $event = $this->service->getEvent($id);
    
        if (!$allowNull) {
            if ($event === null){
                throw new \Exception('Event not found');    //@todo throw custom exception type
            }
        }
    
        return $event;
    
    }
    
}
