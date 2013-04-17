<?php

namespace Events\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Transport;
use Zend\Mail\Message as Message;

class EventsController extends AbstractActionController
{
    private $I_promoteForm;
    private $I_message;
    private $I_transport;
    
    public function indexAction()
    {
    	$m_country = $this->getRequest()->getQuery('country', null);
    	
    	$I_eventService = $this->getServiceLocator()->get('Events\Service\EventService');
    	return new ViewModel(array('events' => $I_eventService->getList($m_country), 
    			                   'countries' => $I_eventService->getCountries())
    			            );
    }
    
    public function eventAction() {
    	
    	$m_id = $this->params()->fromQuery('id'); 
    	
    	if (!is_numeric($m_id)) {
    		throw new \UnexpectedValueException($m_id . ' is not a valid Event ID (integers only are accepted)');
    	}
    	
    	$I_eventService = $this->getServiceLocator()->get('Events\Service\EventService');
    	return new ViewModel(array('event' => $I_eventService->getEvent($m_id), 
    			                  'countries' => $I_eventService->getCountries()));
    }

    public function promoteAction() {
        return array(
            'form' => $this->I_promoteForm,
        );
    }
    
    public function processAction(){
    
        $I_form = $this->I_promoteForm;
    
        $as_feedback = array();
        if ($this->request->isPost()) {
            $as_post = $this->request->getPost()->toArray();
            
            $I_form->setData($as_post);
            if(!$I_form->isValid()) {
                                
                $I_model = new ViewModel(array(
                    'error' => true,
                    'form'  => $I_form,
                ));
                $I_model->setTemplate('events/events/promote');
                return $I_model;
            } 
            
            $this->sendEmail($as_post);
            
            return $this->redirect()->toRoute('events/thanks');
          
        }
    }
    
    public function thanksAction() {
        return new ViewModel();
    }
    
    public function setForm(\Events\Form\Promote $I_promoteForm) {
        $this->I_promoteForm = $I_promoteForm;
    }
    
    public function setMessage(Message $I_message) {
        $this->I_message = $I_message;
    }
    
    public function setMailTransport(Transport\TransportInterface $I_transport) {
        $this->I_transport = $I_transport;
    }
    
    private function sendEmail(array $as_data) {
        
        //preparing the message
        $s_from    = $as_data['email'];
        $s_subject = '[Hubmein] New conference submitted';
        $s_body    = 'The conference ' . $as_data['conference_name'] . ' has been submitted to Hubmein!';
        
        $this->I_message->addFrom($s_from)
                        ->addReplyTo($s_from)
                        ->setSubject($s_subject)
                        ->setBody($s_body);
        
        $this->I_transport->send($this->I_message);
        
    }
    }
