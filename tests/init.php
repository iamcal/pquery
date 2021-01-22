<?php
	require_once __DIR__.'/../vendor/autoload.php';

	if (version_compare(PHP_VERSION, '8.0', '>=')){

		class_alias('\PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');
	}
