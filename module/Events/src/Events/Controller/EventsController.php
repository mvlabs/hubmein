<?php

namespace Events\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Transport;
use Zend\Mail\Message as Message;

class EventsController extends AbstractActionController
{
    private $promoteForm;
    private $eventService;
    
    public function __construct(\Events\Service\EventService $eventService, \Zend\Form\Form $promoteForm) {
        $this->eventService = $eventService;
        $this->promoteForm = $promoteForm;
    }
    
    public function indexAction()
    {
    	$country = $this->getAndCheckNumericParam('country');
    	return new ViewModel(array('events' => $this->eventService->getList($country)));
    }
    
    public function eventAction() {
    	$id = $this->getAndCheckNumericParam('id');
    	return new ViewModel(array('event' => $this->eventService->getEvent($id)));
    }

    public function promoteAction() {
        return array(
            'form' => $this->promoteForm,
        );
    }
    
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
    
    public function thankyouAction() {
        return new ViewModel();
    }
    
}
