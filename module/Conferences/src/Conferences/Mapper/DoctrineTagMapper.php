<?php

namespace Conferences\Mapper;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Conferences\Entity\Tag;

class DoctrineTagMapper implements TagMapperInterface {

    private $entityManager;
    private $tagRepository;
 
    public function __construct(\Doctrine\ORM\EntityManager $entityManager) 
    {
        $this->entityManager = $entityManager;
        $this->tagRepository = $this->entityManager->getRepository('Conferences\Entity\Tag');
    }
    
    /**
     * Gets a Tag
     *
     * @param int Tag Id
     * @return \Conferences\Entity\Tag
     */
    public function getTag($id)
    {
         
        $tag = $this->tagRepository->find($id);
    
        if (null == $tag) {
            throw new \DomainException('No tag with such ID here.');
        }
    
        return $tag;
    }
	    
    /**
     * Gets list of tags
     *
     * @return list of Tags
     */
    public function getTagList()
    {
        
        return $this->tagRepository->findAll();
        
    }
    
    public function getTagListAsArray() {
        
        $tags = $this->tagRepository->findAll();
        
        $result = array();
        foreach ($tags as $tag) {
            $result[$tag->getId()] = $tag->getName();
        }
        
        return $result;
        
    }
    
    /**
     * Saves a tag
     *
     * @param \Conferences\Entity\Tag Tag to save
     */
    public function saveTag( Tag $tag ) {
    
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
    
    }
    
    /**
     * Removes a tag
     *
     * @param \Events\Entity\Tag Tag to remove
     */
    public function removeTag( Tag $tag ) {
    
        $this->entityManager->remove($tag);
        $this->entityManager->flush();
    
    }
    
    
}