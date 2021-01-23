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

		public function testClass(){

			$html = '<p><b class="a">foo</b><b class="b">bar</b><i class="a b">baz</i></p>';
			$obj = pQuery::fromHTML($html);

			$this->assertEquals(1, count($obj->find('b.a')));
			$this->assertEquals(2, count($obj->find('.a')));
		}

		public function testID(){

			$html = '<p><b id="a">foo</b><b id="b">bar</b></p>';
			$obj = pQuery::fromHTML($html);

			$this->assertEquals(1, count($obj->find('b#a')));
			$this->assertEquals(1, count($obj->find('#b')));
			$this->assertEquals(0, count($obj->find('#c')));
		}

	}
