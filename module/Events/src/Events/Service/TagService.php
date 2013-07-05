<?php

namespace Events\Service;

use Events\Entity\Event;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

/**
 * Handles interaction with tags
 *
 * @author Stefano Valle
 *
 */
class TagService {

	
	
	/**
	 * Constructs service 
	 * 
	 * @param \Events\Mapper\TagMapper Event Mapper
	 */
	public function __construct(\Events\Mapper\TagMapperInterface $mapper) {
		$this->mapper = $mapper;
	}
	
	/**
	 * Gets a specific Tag
	 *
	 * @param int Tag Id
	 * @return \Events\Entity\Tag
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
     * @return \Events\Entity\Tag
     */
    public function upsertTag(\Events\Entity\Tag $tag) {
                            
        $this->mapper->saveTag($tag);
        
        return $tag;
        
    }
    
    /**
     * Removes a tag from db
     * 
     * @param \Events\Entity\Tag $tag
     */
    public function removeTag(\Events\Entity\Tag $tag) {
        
        $this->mapper->removeTag($tag);
        
    }

}