<?php
namespace Events\Mapper;

interface EventMapperInterface {
    
    public function getEvent($i_id);
    
    public function getEventList($m_country = null, $i_limit = null);
    
    public function getCountryList();
    
    public function saveEvent(\Events\Entity\Event $I_event);
    
} 