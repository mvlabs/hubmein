<?php

namespace Conferences\View\Helper;


use Zend\View\Helper\AbstractHelper;
use Conferences\Service\TagService;
use Conferences\View\Helper\DispatchRouteViewInterface;


/**
 * Display a list of tags with conferences' count ordered by conference count
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class TagList extends AbstractHelper implements DispatchRouteViewInterface{
    
    const CFPS = "cfps";
    /**
     * @var Conferences\Service\TagService;
     */
    private $tagService;
    /**
     * @var string 
     */
    private $routeName;
    
    public function __construct(TagService $tagService){
        
        $this->tagService = $tagService;
        
    }
    
    public function __invoke() {
        
        $activeCfps = ($this->routeName == self::CFPS)?true:false; 
            
        return  $this->view->render('partials/tag_list', array("tags"=>$this->tagService->fetchAllPopularTag($activeCfps)));
               
    }

    public function setRouteName($routeName) {
        
        $this->routeName = $routeName;
        
    }
    
        
}


