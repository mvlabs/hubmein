<?php

namespace Conferences\Service;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

use Conferences\Entity\Tag,
    Conferences\Mapper\TagMapperInterface;


/**
 * Handles interaction with tags
 *
 * @author Stefano Valle
 *
 */
class TagService {
         
    private $tagMapper;
    /**
     * @param \Conferences\Mapper\TagMapper Event Mapper
     */
    public function __construct( TagMapperInterface $tagMapper ) {

       $this->tagMapper = $tagMapper;

    }

    /**
     * Gets a specific Tag
     *
     * @param int Tag Id
     * @return \Conferences\Entity\Tag
     */
     public function getTag($id) {

       return $this->tagMapper->getTag($id);

     }  
	
    /**
     * Get Tag List
     *
     * @return array List of Tags
     */
    public function getList() {
        
        return $this->tagMapper->getTagList();
        
    }
    
    /**
     * Gets the list of tags in the form of array
     */
    public function getTagListAsArray() {
        
        return $this->tagMapper->getTagListAsArray();
        
    }
        
    /**
     * Inserts or updates a tag from array data
     *
     * @param array $formData
     * @return \Conferences\Entity\Tag
     */
    public function upsertTag( Tag $tag ) {
                            
        $this->tagMapper->saveTag($tag);
        
        return $tag;
        
    }
    
    /**
     * Removes a tag from db
     * 
     * @param \Conferences\Entity\Tag $tag
     */
    public function removeTag( Tag $tag ) {
        
        $this->tagMapper->removeTag($tag);
        
    }
    
    public function fetchAllPopularTag( $activeCfps ){
        
        return $this->tagMapper->fetchAllPopularTag( $activeCfps );
        
    }
    

}