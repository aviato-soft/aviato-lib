<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Avi\Filter as AviFilter;

final class testAviatoFilter extends TestCase
{

	private function proxy($query) {
		$proxyUrl = AVI_TEST_PROXY;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, sprintf("%s?%s",
			$proxyUrl,
			http_build_query(array_merge($_GET, ['action' => json_encode($query)])))
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}


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
		$_GET = [];
		$_GET['date'] = '2013-11-09';
		$_GET['number'] = '22';

		$_POST= [];
		$_POST['action'] = 'test';

		$test = [
			'action' => 'test',
			'date' => '2013-11-09',
			'number' => '22'
		];

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



	public function testFn_xssClean(): void
	{
		$filter = new AviFilter();
		$test = '<script\x0Dtype="text/javascript">javascript:alert(1);</script>';
		$result = $filter->xssClean($test);
		$this->assertEquals('(1);', $result);

		$test = [
			'<IMG """><SCRIPT>alert("XSS")</SCRIPT>"\>',
			'<IMG onmouseover="alert(\'xxs\')">'
		];
		$result = $filter->xssClean($test);
		$this->assertEquals($test, $result);
	}


	public function testFn_post(): void
	{
		$filter = new AviFilter();
		$test = 'Aviato-Soft';
		$_POST['test'] = $test;
		$result = $filter->post('test') ?? $this->proxy([
			'call' => [
				'Filter',
				'post',
			],
			'args' => [
				'test'
			]
		]);
		$this->assertEquals($test, $result);

		$test = "<img src=j&#X41vascript:alert('test2')>";
		$_POST['xss'] = $test;
		$result = $filter->post('xss') ?? $this->proxy([
			'call' => [
				'Filter',
				'post',
			],
			'args' => [
				'xss'
			]
		]);
		$this->assertEquals('<img >', $result);
	}


	public function testFn_get(): void
	{
		$filter = new AviFilter();
		$test = 'Aviato-Soft';
		$_GET['test'] = $test;
		$result = $filter->get('test') ?? $this->proxy([
			'call' => [
				'Filter',
				'get',
			],
			'args' => [
				'test'
			]
		]);
		$this->assertEquals($test, $result);
	}



	public function testFn_var(): void
	{
		$filter = new AviFilter();
		$test = 7;
		$_POST['test'] = $test;
		$result = $filter->var('test', INPUT_POST, [
			'number' => 'int',
			'max' => 10,
			'min' => 1
		]) ?? $this->proxy([
			'call' => [
				'Filter',
				'var',
			],
			'args' => [
				'test',
				INPUT_POST,
				[
					'number' => 'int'

				]
			]
		]);
		$this->assertEquals($test, $result);


		$test = 7.333;
		$_POST['test'] = $test;
		$result = $filter->var('test', INPUT_POST, ['number' => 'float']) ?? $this->proxy([
			'call' => [
				'Filter',
				'var',
			],
			'args' => [
				'test',
				INPUT_POST,
				[
					'number' => 'float'

				]
			]
		]);
		$this->assertEquals($test, $result);


		$test = 'Aviato-Soft';
		$_POST['test'] = $test;
		$result = $filter->var('test', INPUT_POST, [
			'id' => FILTER_VALIDATE_REGEXP,
			'flags' => FILTER_NULL_ON_FAILURE,
			'options' => [
				'regexp' => "/^[a-zA-Z0-9]{3,24}$/i"
			]]) ?? $result = $this->proxy([
			'call' => [
				'Filter',
				'var',
			],
			'args' => [
				'test',
				INPUT_POST,
				[
					'regexp' => "/^[a-zA-Z0-9]{3,24}$/i"
				]
			]
		]);
		$this->assertFalse($result);

		$result = $filter->var('test', INPUT_POST, [
			'regexp' => "/^[a-zA-Z0-9_-]{3,24}$/i"
		]) ?? $this->proxy([
			'call' => [
				'Filter',
				'var',
			],
			'args' => [
				'test',
				INPUT_POST,
				[
					'regexp' => "/^[a-zA-Z0-9_-]{3,24}$/i"
				]
			]
		]);
		$this->assertEquals($test, $result);
	}


	public function testFn_request(): void
	{
		$filter = new AviFilter();
		$testG = 'GET: Aviato-Soft';
		$testP = 'POST: Aviato-Soft';

		//test 1: P[ ] G[ ]
		$_POST = [];
		$_GET = [];
		$result = $filter->request('test') ?? $this->proxy([
			'call' => [
				'Filter',
				'request',
			],
			'args' => [
				'test'
			]
		]);
		$this->assertEquals('', $result);

		//test2: P[x] G[ ]
		$_POST['test'] = $testP;
		$result = $filter->request('test') ?? $this->proxy([
			'call' => [
				'Filter',
				'request',
			],
			'args' => [
				'test'
			]
		]);
		$this->assertEquals($testP, $result);

		//test 3: P[x] G[x]
		$_GET['test'] = $testG;
		$result = $filter->request('test') ?? $this->proxy([
			'call' => [
				'Filter',
				'request',
			],
			'args' => [
				'test'
			]
		]);
		$this->assertEquals($testP, $result);

		//test 4: P[ ] G[x]
		$_POST = [];
		$result = $filter->request('test') ?? $this->proxy([
			'call' => [
				'Filter',
				'request',
			],
			'args' => [
				'test'
			]
		]);
		$this->assertEquals($testG, $result);

	}

}
