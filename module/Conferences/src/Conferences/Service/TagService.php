<?php

namespace Conferences\Service;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

use Conferences\Entity\Tag,
    Conferences\Entity\Conference;


/**
 * Handles interaction with tags
 *
 * @author Stefano Valle
 *
 */
class TagService {
         
        private $mapper;
        /**
	 * @param \Conferences\Mapper\TagMapper Event Mapper
	 */
	public function __construct(\Conferences\Mapper\TagMapperInterface $mapper) {
            
            $this->mapper = $mapper;
                
	}
	
	/**
	 * Gets a specific Tag
	 *
	 * @param int Tag Id
	 * @return \Conferences\Entity\Tag
	 */
	public function getTag($id) {
            
	    return $this->mapper->getTag($id);
            
	}
	
    /**
     * Get Tag List
     *
     * @return array List of Tags
     */
    public function getList() {
        
        return $this->mapper->getTagList();
        
    }
    
    /**
     * Gets the list of tags in the form of array
     */
    public function getTagListAsArray() {
        
        return $this->mapper->getTagListAsArray();
        
    }
        
    /**
     * Inserts or updates a tag from array data
     *
     * @param array $formData
     * @return \Conferences\Entity\Tag
     */
    public function upsertTag( Tag $tag ) {
                            
        $this->mapper->saveTag($tag);
        
        return $tag;
        
    }
    
    /**
     * Removes a tag from db
     * 
     * @param \Conferences\Entity\Tag $tag
     */
    public function removeTag( Tag $tag ) {
        
        $this->mapper->removeTag($tag);
        
    }
    
    public function getPopularTagList( $activeCfps ){
        
        return $this->mapper->getPopularTagList( $activeCfps );
        
    }
    

}