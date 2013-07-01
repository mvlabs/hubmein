<?php
namespace Events\Mapper;

use Events\DataFilter\EventFilter;

interface EventMapperInterface {
    
    public function getEvent($id);
    
    public function getFilteredList(EventFilter $eventFilter, $limit = null);
       
    public function saveEvent(\Events\Entity\Event $event);
    
} 