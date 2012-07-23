<?php

class Referly_Base {
	
	public $base_url = 'https://refer.ly/api/';
	
	public $version = '120701';
	
	public $verify_ssl = TRUE;
	
	protected $key;
	
	protected $secret;
	
	protected static $instance;
	
	protected $query = array();
	
	protected $post = array();
	
	public function __construct($key, $secret) {
		$this->key = $key;
		$this->secret = $secret;
	}
	
	public static function instance($key = NULL, $secret = NULL) {
		if ( ! is_null($key) && ! is_null($secret)) {
			self::$instance = new Referly($key, $secret);
		}
		if (self::$instance) {
			return self::$instance;
		}
		else {
			throw new Referly_Exception('You must provide a key and secret the first time you get an instance.', 403);
		}
	}
	
	/**
	 * List Links
	 *
	 * @param string $account_id List links your app has created for the given account id.
	 *
	 * @return { links: [ {id: 'LWD', url: 'http://refer.ly/LWD'}, ... ], total: X }
	 */
	public function list_links($account_id) {
		$this->query = array(
			'account_id' => $account_id,
		);
		return $this->_send_request('/links', 'GET');
	}
	
	/**
	 * Create a link
	 *
	 * @param string $account_id Create a link for the given account_id.
	 * @param url $url The url you want to direct users to.
	 *
	 * @return { id: 'HZLD', url: 'http://refer.ly/HZLD' }
	 */
	public function create_link($url, $account_id = NULL) {
		$this->post = array(
			'account_id' => $account_id,
			'url' => $url
		);
		return $this->_send_request('/links', 'POST');
	}
	
	/**
	 * Grant a reward
	 *
	 * @param string $visit_id The visit_id that converted.
	 * @param float $amount The amount to reward in US dollars.
	 * @param string $payable_on The date the reward is payable on.
	 *
	 * @return { reward_id: '1f0f9e1abb7011e1a7327fb81d69b655' }
	 */
	public function grant_reward($visit_id, $amount, $payable_on = date('Y-m-d', time() + 60*60*24*30)) {
		$this->post = array(
			'visit_id' => $visit_id,
			'amount' => $amount,
			'earned_on' => date('Y-m-d', time()),
			'payable_on' => $payable_on
		);
		return $this->_send_request('/rewards', 'POST');
	}
	
	/**
	 * Private methods.
	 */
	private function _build_url($path) {
		return sprintf('%s%s%s', $this->base_url, $this->version, $path);
	}
	
	private function _send_request($path, $method = 'GET') {
		$ch = curl_init();
		$url = $this->_build_url($path);
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, sprintf('%s:%s', $this->key, $this->secret));
		curl_setopt($ch, CURLOPT_USERAGENT, 'referly-php-api');

		// SSL
		if ($this->verify_ssl) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		}
		else {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		}

		$headers = array();
		
		switch ($method) {
			case 'POST':
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
				break;
		}

		if (count($headers) > 0) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		$response = curl_exec($ch);

		if ( ! $response && $response !== '') {
			throw new Referly_Exception(curl_error($ch), curl_errno($ch));
		}
		
		$result = array(
			'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
			'data' => json_decode($response)
		);
		
		curl_close($ch);
		return $result;
	}
}

class Referly_Response {
	
	public $status;
	
	public $response;
	
	public function status($status = NULL) {
		if ( ! is_null($status)) {
			$this->status = $status;
		}
		return $this->status;
	}
	
	public function __get($column) {
		return $this->response[$column];
	}
	
}

class Referly_Exception extends Exception {
	
}