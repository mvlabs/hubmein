<?php
namespace CaptchaRefresher\Service;

use Zend\Captcha\AbstractAdapter;

/**
 * Description of CaptchaRefreshService
 *
 * @author David Contavalli <mauipipe@gmail.com>
 * @copyright M.V. Labs 2013 - All Rights Reserved -
 *  You may execute and modify the contents of this file, but only within the scope of this project.
 *  Any other use shall be considered forbidden, unless otherwise specified.
 * @link http://www.mvassociates.it
 */
class CaptchaService {
    
    private $captcha;
    
    public function __construct(AbstractAdapter $captcha) {
        
        $this->captcha = $captcha;
       
    }
    
    public function generate(){
        
        $captchaData = array();
        $captchaData['id'] = $this->captcha->generate();
        $captchaData['src'] = $this->captcha->getImgUrl().
                              $this->captcha->getId().
                              $this->captcha->getSuffix();
                           
        return $captchaData;
        
    }
    
}

?>
