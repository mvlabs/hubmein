<?php

namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DisplayCost extends AbstractHelper {

	public function __invoke($cost) {
		if (0 == $cost) {
			return 'Event is <strong class="free">Free</strong> or supported by <strong class="free">Donations</strong>';
		}
		return 'Average Daily Cost: <strong class="cost">' . $cost . '&euro;</strong>';
	}

}