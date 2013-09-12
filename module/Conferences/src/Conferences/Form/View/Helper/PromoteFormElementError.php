<?php
namespace Conferences\Form\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as BaseFormElementError;

class PromoteFormElementError extends BaseFormElementError {

   protected $messageCloseString     = '</li></ul>';
    protected $messageOpenFormat      = '<ul class="errors"><li>';
    protected $messageSeparatorString = '</li><li>';

}