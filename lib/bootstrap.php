<?php

require_once dirname(__FILE__) .'/referly/base.php';

// You should define and include your own Referly subclass otherwise we fall back to the default.
if ( ! class_exists('Referly')) {
	require_once dirname(__FILE__) .'/referly.php';
}