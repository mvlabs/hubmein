<?php
namespace Conferences\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Zend\Form\Form;

/**
 * Description of renderFormRow();
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class RenderFormRow extends AbstractHelper {

    public function __invoke($elementName,Form $form) {
       
        echo $this->getView()->formRow($form->get($elementName));
        
    }
    
}
?>
