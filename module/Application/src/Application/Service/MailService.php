<?php

namespace Application\Service;

use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;


class MailService {

    private $message;
    private $transport;
    
    public function __construct(Message $message, TransportInterface $transport) {
        $this->message = $message;
        $this->transport = $transport;
    }

    public function logEventSaved($e){
        
        //get event params
        $am_params = $e->getParams();
        $confTitle = $am_params['title'];
        
        
        $this->message->setSubject('Hubme.in - new conference promoted')
                      ->setBody('A new conference has been promoted: ' . $confTitle);
         
        $this->transport->send($this->message);
        
    }

}
