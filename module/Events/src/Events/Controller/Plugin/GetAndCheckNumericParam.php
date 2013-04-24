<?php

namespace Events\Controller\Plugin;
use Zend\Mvc\InjectApplicationEventInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class GetAndCheckNumericParam extends AbstractPlugin {

	public function __invoke($s_paramName) {

		$I_controller = $this->getController();
		$m_value = $I_controller->getRequest()->getQuery($s_paramName, null);
		
		if (NULL !== $m_value && !is_numeric($m_value)) {
			throw new \UnexpectedValueException('Value of ' . $s_paramName . '("'. $m_value . '") is invalid. Numeric values only are accepted');
		}
		
		return $m_value;
		
	}

}

?>