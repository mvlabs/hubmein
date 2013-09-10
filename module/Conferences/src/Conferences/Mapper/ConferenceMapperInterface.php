<?php
namespace Conferences\Mapper;

use Conferences\DataFilter\RequestBuilder,
    Conferences\Entity\Conference;

/**
 * interface for the ConferenceMapper
 *
 * @author David Contavalli < mauipipe@gmail.com >
 * @copyright M.V. Associates for VDA (c) 2011 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */


interface ConferenceMapperInterface {
    
    public function getConference( $id );
    
    public function fetchAllByFilter( RequestBuilder $requestBuilder );
    
    public function countByFilter( RequestBuilder $requestBuilder );
       
    public function saveConference( Conference $conference );
    
} 
