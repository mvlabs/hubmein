<?php

namespace Events\Controller\Plugin;
use Zend\Mvc\InjectApplicationEventInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class GetAndCheckNumericParam extends AbstractPlugin {

	public function __invoke($paramName) {

		$controller = $this->getController();
		$value = $controller->getRequest()->getQuery($paramName, null);
		
		if (NULL !== $value && !is_numeric($value)) {
			throw new \UnexpectedValueException('Value of ' . $paramName . '("'. $value . '") is invalid. Numeric values only are accepted');
		}
		
		return $value;
		
	}

}

?>