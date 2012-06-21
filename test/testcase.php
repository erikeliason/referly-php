<?php

abstract class TestCase extends PHPUnit_Framework_TestCase {
	
	public $api_key = 'e93575c0bb3411e19ff992bdfcb69be5';
	
	public $secret = 'c1b1dedb61eb690d55a7be3807d62c81';
	
	public $account_id = 'f3a04c22a60511e1833422000a1cd7c9';
	
	public function setUp() {
		$this->loadApi();
	}
	
	public function loadApi() {
		$this->api = Referly::instance($this->api_key, $this->secret);
		$this->api->base_url = 'https://dev.refer.ly/api/';
		$this->api->verify_ssl = FALSE;
	}

}