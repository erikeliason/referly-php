<?php

include_once 'testcase.php';

class LinkTest extends TestCase {
	
	public function testListLinks() {
		$r = $this->api->list_links($this->account_id);
		$this->assertEquals(200, $r['code']);
		$this->assertTrue(isset($r['data']->total));
		$this->assertTrue(isset($r['data']->links));
		$this->assertTrue(count($r['data']->links) > 0);
	}

	public function testCreateLink() {
		$r = $this->api->create_link($this->account_id, 'http://www.amazon.com/Suck-UK-SK-CATDECK1-Scratch/dp/B006YR6EK8/ref=sr_1_1?ie=UTF8&qid=1340263794&sr=8-1&keywords=cat+suck+uk');
		$this->assertEquals(200, $r['code']);
		$this->assertTrue(isset($r['data']->url));
		$this->assertTrue(isset($r['data']->id));
	}
	
}