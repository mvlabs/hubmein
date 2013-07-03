<?php

namespace Events\Mapper;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineTagMapper implements TagMapperInterface {

    private $entityManager;
    private $tagRepository;
 
    public function __construct(\Doctrine\ORM\EntityManager $entityManager) 
    {
        $this->entityManager = $entityManager;
        $this->tagRepository = $this->entityManager->getRepository('Events\Entity\Tag');
    }
    
    /**
     * Gets a Tag
     *
     * @param int Tag Id
     * @return \Events\Entity\Tag
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
     * @param \Events\Entity\Tag Tag to save
     */
    public function saveTag(\Events\Entity\Tag $tag)
    {
    
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
    
    }
    
    /**
     * Removes a tag
     *
     * @param \Events\Entity\Tag Tag to save
     */
    public function removeTag(\Events\Entity\Tag $tag)
    {
    
        $this->entityManager->remove($tag);
        $this->entityManager->flush();
    
    }
    
    
}