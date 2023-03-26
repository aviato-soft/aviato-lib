<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Avi\Filter as AviFilter;

final class testAviatoFilter extends TestCase
{


	public function testFn_Construct(): void
	{
		$filter = new AviFilter();
		$this->assertIsObject($filter);
	}


	public function testFn_ValidateDefinitions(): void
	{
		// invalid definitions (incomplete structure):
		$defInvalid = [
			'test'
		];
		$filter = new AviFilter($defInvalid);
		$this->assertIsObject($filter);
		$this->assertTrue(property_exists($filter, 'definition'));

		//invalid definitions (incomplete structure)
		$defInvalid = [
			'test' => ''
		];
		$filter = new AviFilter($defInvalid);
		$this->assertIsObject($filter);
		$this->assertTrue(property_exists($filter, 'definition'));

		//invalid definitions (incomplete structure)
		$defInvalid = [
			'test' => []
		];
		$filter = new AviFilter($defInvalid);
		$this->assertIsObject($filter);
		$this->assertTrue(property_exists($filter, 'definition'));

		//invalid definitions (invalid structure: missing input type)
		$defInvalid = [
			'test' => [
				'validation' => [
				]
			]
		];
		$filter = new AviFilter($defInvalid);
		$this->assertIsObject($filter);
		$this->assertTrue(property_exists($filter, 'definition'));

		//invalid definitions (incomplete structure)
		$defInvalid = [
			'test' => [
				INPUT_POST => []
			]
		];
		$filter = new AviFilter($defInvalid);
		$this->assertIsObject($filter);
		$this->assertTrue(property_exists($filter, 'definition'));


		$defValid = [
			'test' => [
				INPUT_POST => [
					'validate' => ['filter' => []],
					'sanitize' => ['filter' => []],
					'mixtisize' => ['filter' => []]
				]
			]
		];
		$filter = new AviFilter($defValid);
		$this->assertIsObject($filter);
		$this->assertTrue(property_exists($filter, 'definition'));
	}


	public function testFn_check(): void
	{
		$test = $_GET;
		$test['action'] =$_POST['action'];
		$def = [
			INPUT_GET => [
				'validate' => [
					'date' => [
						'filter' => FILTER_VALIDATE_REGEXP,
						'options' => [
							//format: yyyy-mm-dd
							'regexp' => "/^\d{4}-\d{2}-\d{2}$/"
						]
					],
					'number' => [
						'filter' => FILTER_VALIDATE_INT,
						'flags' => FILTER_REQUIRE_SCALAR
					]
				]
			],
			INPUT_POST => [
				'validate' => [
					'action' => [
						'filter' => FILTER_VALIDATE_REGEXP,
						'options' => [
							'regexp' => "/^(.*)$/"
						]
					]
				]
			]
		];
		$filter = new AviFilter($def);
		$result = $filter
		-> add(
			INPUT_GET,
			'sanitize',
			[
				'date' => [
					'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
					'options' => [
						'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK |
							FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH
					]
				],
				'number' => [
					'filter' => FILTER_SANITIZE_NUMBER_INT
				],
				'inexistent' => [
					'filter' => FILTER_SANITIZE_NUMBER_INT
				]
			]
		)
		-> check();
		//var_dump([$test, $result]);

		$this->assertEquals($test, $result);
	}

/*
	public function testFn_request(): void
	{
		$test = 'Aviato Soft';
		$filter = new AviFilter([]);
//		$result = $filter->request('section');
//		$this->assertEquals('', $result);

		$_GET['section'] = $test;
		$result = $filter->request('section');
		var_dump($test, $result);
		//$this->assertEquals($test, $result);

//		$_POST['section'] = $test;
//		$result = $filter->request('section');
//		$this->assertEquals($test, $result);
	}
*/
}
