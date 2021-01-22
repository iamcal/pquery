<?php

	class BasicTest extends PHPUnit_Framework_TestCase {

		public function testParse(){

			$html = '<p>This is a <b>test</b>.</p>';
			$obj = pQuery::fromHTML($html);

			$this->assertEquals('pQuery', get_class($obj));
		}

		public function testTags(){

			$html = '<p>This is a <b>test</b>.</p>';
			$obj = pQuery::fromHTML($html);

			$this->assertEquals(1, count($obj->find('p')));
			$this->assertEquals(1, count($obj->find('b')));
		}

	}
