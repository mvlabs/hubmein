<?php
namespace Events\Mapper;

interface EventMapperInterface {
    
    public function getEvent($i_id);
    
    public function getList($m_country = null, $i_limit = null);
    
    public function getCountries();
    
} 