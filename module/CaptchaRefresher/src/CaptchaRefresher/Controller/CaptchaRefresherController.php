<?php
namespace CaptchaRefresher\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\Captcha\Image;
/**
 * Description of RefresherController
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class CaptchaRefresherController extends AbstractActionController {
       
    private $captchaImage;
    
    public function __construct(Image $captchaImage) {
        ;
    }
    
    public function refreshCaptchAction(){
        
        
                
    }
    
}

?>
