<?php

namespace Application\Service;

use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;


class MailService {

    private $I_message;
    private $I_transport;
    
    public function __construct(Message $I_message, TransportInterface $I_transport) {
        $this->I_message = $I_message;
        $this->I_transport = $I_transport;
    }

    public function logEventSaved($e){
        
        //get event params
        $am_params = $e->getParams();
        $s_confTitle = $am_params['title'];
        
        
        $this->I_message->setSubject('Hubme.in - new conference promoted')
                        ->setBody('A new conference has been promoted: ' . $s_confTitle);
         
        $this->I_transport->send($this->I_message);
        
    }

}
