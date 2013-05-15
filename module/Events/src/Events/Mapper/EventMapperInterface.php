<?php
namespace Events\Mapper;

interface EventMapperInterface {
    
    public function getEvent($id);
    
    public function getCountry($id);
    
    public function getEventList($country = null, $limit = null);
    
    public function getCountryList();
    
    public function saveEvent(\Events\Entity\Event $event);
    
} 