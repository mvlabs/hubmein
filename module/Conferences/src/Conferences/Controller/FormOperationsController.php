<?php
namespace Conferences\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

use CaptchaRefresher\Service\CaptchaService;

/**
 * Description of FormOperationsController
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */

class FormOperationsController extends AbstractActionController{
  
    private $captchaService;
    
    public function __construct(CaptchaService $captchaService){
       
        $this->captchaService = $captchaService;
        
    }
    
    public function generateCaptchaAction(){
        
      //  var_dump($this->captchaService);
        $captchaData = $this->captchaService->generate();
               
        $result = new JsonModel(array(
            "captcha_data"=> $captchaData,
            "success"=>true
        ));
        
        return $result;
        
    }
    
}

?>
