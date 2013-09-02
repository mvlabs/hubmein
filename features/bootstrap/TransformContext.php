<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Gherkin\Node\TableNode;


/**
 * Contain all Transform 
 *
 * @author David Contavalli < mauipipe@gmail.com >
 * @copyright M.V. Associates for VDA (c) 2011 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class TransformContext {
    
    
    /**
      * Covert a number value passed as string into a int
      * @Transform /^(\d+)$/
      */
    public function castStringToNumber($s_string)
    {
        return intval($s_string);
    }
    
}

?>
