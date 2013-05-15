<?php

namespace Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport;


class MailServiceFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // create mail message
	    $message = new Message();
	    
	    // set from and to addresses
	    // (sample params; in a real project, get them from config array)
	    $message->addFrom('system@mywebsite.com');
	    $message->addTo('alerts@mywebsite.com');
	    
	    
	    // create transport
	    $transport = new Transport\Sendmail();
	    
		return new MailService($message, $transport);
		
	}

}