<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.

declare(strict_types = 1);

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Avi\Version as AviVersion;
use const Avi\AVI_MAJOR;
use const Avi\AVI_MINOR;
use const Avi\AVI_PATCH;
use const Avi\AVI_JS_MD5;


final class testAviatoVersion extends TestCase
{


	public function testFn_Get(): void
	{
		$result = AviVersion::get();

		$test = AVI_MAJOR.'.'.AVI_MINOR.'.'.AVI_PATCH;

		$this -> assertEquals($test, $result);

		//this test will pove that deploy build was create the right file:
		$result = file_exists(dirname(__FILE__) . '/../src/js/aviato-'.AVI_JS_MD5.'-min.js');
		$this -> assertTrue($result);
	}
}