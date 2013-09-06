<?php
namespace Conferences\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Initialize the tag service used on TagList
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class TagListFactory implements FactoryInterface{
   
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        $tagService = $serviceLocator->getServiceLocator()->get("tag.service");
              
        return new TagList( $tagService );
        
    }    
    
}

?>
