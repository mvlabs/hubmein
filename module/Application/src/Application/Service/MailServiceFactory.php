<?php

namespace Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport;


class MailServiceFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $I_serviceLocator) {
		
	    // create mail message
	    $I_message = new Message();
	    
	    // set from and to addresses
	    // (sample params; in a real project, get them from config array)
	    $I_message->addFrom('system@mywebsite.com');
	    $I_message->addTo('alerts@mywebsite.com');
	    
	    
	    // create transport
	    $I_transport = new Transport\Sendmail();
	    
		return new MailService($I_message, $I_transport);
		
	}

}