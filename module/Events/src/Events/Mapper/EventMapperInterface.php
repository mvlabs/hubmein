<?php
namespace Events\Mapper;

use Events\DataFilter\RequestBuilder,
    Events\Entity\Event;

/**
 * interface for the EventMapper
 *
 * @author David Contavalli < mauipipe@gmail.com >
 * @copyright M.V. Associates for VDA (c) 2011 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */


interface EventMapperInterface {
    
    public function getEvent( $id );
    
    public function getListByFilter( RequestBuilder $requestBuilder );
    
    public function countListByFilter( RequestBuilder $requestBuilder );
       
    public function saveEvent( Event $event );
    
} 
