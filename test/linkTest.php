<?php

include_once 'testcase.php';

class LinkTest extends TestCase {
	
	public function testListLinks() {
		$r = $this->api->list_links($this->account_id);
		$this->assertEquals(200, $r['code']);
		$this->assertTrue(isset($r['data']->total_links));
		$this->assertTrue(isset($r['data']->links));
		$this->assertTrue(count($r['data']->links) > 0);
	}

	public function testCreateLink() {
		$url = 'http://www.amazon.com/Suck-UK-SK-CATDECK1-Scratch/dp/B006YR6EK8';
		$r = $this->api->create_link($url, $this->account_id);
		$this->assertEquals(200, $r['code']);
		$this->assertTrue(isset($r['data']->url));
		$this->assertTrue(isset($r['data']->id));
	}
	
	public function testCreateLinkWithoutAccountId() {
		$url = 'http://www.amazon.com/Apple-MacBook-MD101LL-13-3-Inch-VERSION/dp/B0074703CM';
		$r = $this->api->create_link($url);
		$this->assertEquals(200, $r['code']);
		$this->assertTrue(isset($r['data']->url));
		$this->assertTrue(isset($r['data']->id));
	}
	
}