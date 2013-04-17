<?php

namespace Events\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DisplayCost extends AbstractHelper {

	public function __invoke($i_cost) {
		if (0 == $i_cost) {
			return 'Event is <strong class="free">Free</strong> or supported by <strong class="free">Donations</strong>';
		}
		return 'Average Daily Cost: <strong class="cost">' . $i_cost . '&euro;</strong>';
	}

}