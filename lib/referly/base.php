<?php

class Referly_Base {
	
	protected $key = '';
	
	protected $secret = '';
	
	public function __construct($key, $secret) {
		$this->key = $key;
		$this->secret = $secret;
	}
	
	public static function instance($key = NULL, $secret = NULL) {
		if ( ! is_null($key) && ! is_null($secret)) {
			$instance = new Referly($key, $secret);
		}
	}
	
	private function _send_request() {
		
	}
}

class Referly_Exception extends Exception {
	
}