<?php
namespace Conferences\Mapper;

interface TagMapperInterface {
    
    public function getTag($id);
    
    public function getTagList();
    
    public function getTagListAsArray();
    
    public function saveTag(\Conferences\Entity\Tag $tag);
    
    public function removeTag(\Conferences\Entity\Tag $tag);
    
} 