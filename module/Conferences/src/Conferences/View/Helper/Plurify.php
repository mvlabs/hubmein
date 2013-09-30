<?php
namespace Conferences\View\Helper;

use Conferences\View\Helper\DispatchRouteViewInterface;

use Zend\View\Helper\AbstractHelper;

/**
 * Description of Plurify
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class Plurify extends AbstractHelper{
    
    public function __invoke($count, $name) {
        
        if($count > 1){
            $name = $name."s";
        }
        
        return $count." ".$name;
        
    }
    
}

