<?php
namespace Events\Mapper;

interface TagMapperInterface {
    
    public function getTag($id);
    
    public function getTagList();
    
    public function getTagListAsArray();
    
    public function saveTag(\Events\Entity\Tag $tag);
    
    public function removeTag(\Events\Entity\Tag $tag);
    
} 