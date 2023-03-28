<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.

declare(strict_types = 1);

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/assets/Sections.php';
require_once dirname(__FILE__) . '/assets/AviResponseTest.php';

use PHPUnit\Framework\TestCase;
use Avi\Response as AviResponse;
use Psr\Log\Test\TestLogger;

final class testAviatoResponse extends TestCase
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
		$_POST = [];
		$aviResponse = new AviResponse();
		$this->assertIsObject($aviResponse);

		// assert attribute action:
		$this->assertTrue(property_exists($aviResponse, 'action'));
		$test = $aviResponse->action;
		$this->assertNull($test);


		// assert attribute data:
		$this->assertTrue(property_exists($aviResponse, 'data'));
		$test = [];
		$result = $aviResponse->data;
		$this->assertEquals($test, $result);

		// assert attribute success:
		$this->assertTrue(property_exists($aviResponse, 'success'));
		$this->assertNull($aviResponse->success);
	}


	public function testFn_Get(): void
	{
		$aviResponse = new AviResponse();
		$result = json_decode($aviResponse->get(), true);

		//print_r($result);
		// expected:
		/*
		 * [
		 * 'action' => NULL,
		 * 'data' => [],
		 * 'log' => [
		 * 0 => [
		 * 'id' => 100,
		 * 'message' => "Undefined action!",
		 * 'type' => "arrray",
		 * 'time' => 1617202333
		 * ]
		 * 1 =>
		 * 'id' => 201,
		 * 'message' => "Empty response!",
		 * 'type' => "arrray",
		 * 'time' => 1617202333
		 * 'success' => false
		 * ]
		 *
		 */
		// action
		$this->assertArrayHasKey('action', $result);
		$this->assertNull($result['action']);

		// data
		$this->assertArrayHasKey('data', $result);
		$this->assertEquals(array(), $result['data']);

		// log
		$this->assertArrayHasKey('log', $result);
		$this->assertArrayHasKey('0', $result['log']);
		$this->assertArrayHasKey('id', $result['log'][0]);
		$this->assertEquals(100, $result['log'][0]['id']);
		$this->assertArrayHasKey('message', $result['log'][0]);
		$this->assertEquals('Undefined action!', $result['log'][0]['message']);
		$this->assertArrayHasKey('type', $result['log'][0]);
		$this->assertEquals('error', $result['log'][0]['type']);
		$this->assertArrayHasKey('1', $result['log']);
		$this->assertEquals(201, $result['log'][1]['id']);
		$this->assertEquals('Empty response!', $result['log'][1]['message']);
		$this->assertEquals('warning', $result['log'][1]['type']);

		// success
		$this->assertArrayHasKey('success', $result);
		$this->assertFalse($result['success']);

		// get(section) - non existent object
		$_POST['section'] = 'testInvalid';
		$expected = '<section class="sec-obj-testInvalid" id="testInvalid"></section>';
		$result = $this->proxy([
			'call' => [
				"test-Response_Get"
			]
		]);
		$this->assertEquals($expected, $result);

		//test made trough proxy, because POST value is required
		$aviResponse = new AviResponseTest('section');
		$result = json_decode($aviResponse->get(), true);
		$unexptected = '<section class="sec-obj-" id=""></section>';
		$this->assertEquals($unexptected, $result['data']);
		$this->assertTrue($result['success']);

		// get(section)
		$_POST = [];
		$_GET['section'] = 'test';
		$test = '<section class="sec-obj-test" id="test">test section</section>';
		$result = $this->proxy([
			'call' => [
				"test-Response_Get"
			]
		]);
		$this->assertEquals($test, $result);

		$aviResponse = new AviResponseTest('section');
		$result = json_decode($aviResponse->get(), true);
		$this->assertEquals($unexptected, $result['data']);
		$this->assertTrue($result['success']);
		// var_dump($result); // <-- uncomment this line to see the result!

		//get(section) with params:
		$_GET['section'] = 'test8';
		$_GET['params'] = 'a=1,b=2';
		$test = '<section class="sec-obj-test8" id="test8"><pre>a=1 | b=2</pre></section>';
		$result = $this->proxy([
			'call' => [
				"test-Response_Get"
			]
		]);
		$this->assertEquals($test, $result);
		//var_dump($_REQUEST);

		//test made trough proxy, because REQUEST value is required
		$aviResponse = new AviResponseTest('section');
		$result = json_decode($aviResponse->get(), true);
		$this->assertEquals($unexptected, $result['data']);
		$this->assertTrue($result['success']);

		//get location
		$aviResponse = new AviResponseTest('section');
		$location = 'www.aviato.ro';
		$aviResponse -> location = $location;
		$result = json_decode($aviResponse->get(), true);
		$this->assertEquals($location, $result['location']);
		$this->assertTrue($result['success']);


		// get(upload)
		//$_REQUEST['up'] = 'test';
		//$test = '<section id="test" class="sec-obj-test">test section</section>';
		$aviResponse = new AviResponseTest('upload');
		$result = json_decode($aviResponse->get(), true);
		//Missing Upload Handler!
		$this->assertFalse($result['success']);

		$_REQUEST['handler'] = 'UploadTest';
		$result = json_decode($aviResponse->get(), true);
		//Missing Upload Handler Definition!
		$this->assertFalse($result['success']);

		$_REQUEST['handler'] = 'fnUpload';
		$_FILES = ['a', 'b', 'c'];
		$result = $this->proxy([
			'call' => [
				"test-Response_Get"
			]
		]);
		$this->assertEquals($test, $result);

		$result = json_decode($aviResponse->get(), true);
		//Missing Upload Handler Definition!
		$this->assertFalse($result['success']);
		//test made trough proxy
		//$this->assertNull($result['success']);

		//var_dump($result); // <-- uncomment this line to see the result!
	}


	public function testFn_getData()
	{
		$_REQUEST['fn'] = 3;
		$aviResponse = new AviResponseTest('call');
		$aviResponse->get();

		$result = $aviResponse -> getData(1);
		$test = 'one';
		$this->assertEquals($test, $result);

		$result = $aviResponse -> getData(2);
		$test = 'two';
		$this->assertEquals($test, $result);

		$result = $aviResponse -> getData(3);
		$this->assertNull($result);

		//var_dump($aviResponse -> data); // <-- uncomment this line to see the result!
	}


	public function testFn_Action()
	{
		//Empty action:
		$aviResponse = new AviResponse();

		//get the response
		$result = json_decode($aviResponse->get(false), true);
		$this->assertEquals(100, $result['log'][0]['id']); //= undefined action
		// var_dump($result); // <-- uncomment this line to see the result!

		//set action:
		$test = 'test';
		$result = $aviResponse -> action($test);
		$aviResponse -> data = $test;
		$this -> assertEquals($result, $test);
		//get the response
		$result = json_decode($aviResponse->get(), true);
		//var_dump($result); // <-- uncomment this line to see the result!
	}


	public function testFn_ResponseData()
	{
		$aviResponse = new AviResponse();
		// 1st call set data as a string
		$aviResponse->data = 'test!';
		$responseData = $aviResponse->getData();
		// var_dump($responseData); // <-- uncomment this line to see the result!
		$this->assertEquals('test!', $responseData);

		// 2nd call set data as an array
		$aviResponse->data = array(
			'test' => 'Test message'
		);
		$response = json_decode($aviResponse->get(), true);
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertArrayHasKey('test', $response['data']);
		$this->assertEquals('Test message', $response['data']['test']);
	}


	public function testFn_Success()
	{
		$aviResponse = new AviResponse();

		$success = $aviResponse->success(false);
		$this->assertFalse($success);

		$success = $aviResponse->success(1);
		$this->assertFalse($success);

		$success = $aviResponse->success(true);
		$this->assertTrue($success);

		$response = json_decode($aviResponse->get(), true);
		$this->assertTrue($response['success']);

		$log = $aviResponse -> log('Error Test', 'error', 299);
		$log = $aviResponse -> log('Error Test', 'error', 299);
		$log = $aviResponse -> log('Error Test', 'error', 299);
		$success = $aviResponse->success();
		$response = json_decode($aviResponse->get(), true);
		$this->assertTrue($success);
		$this->assertTrue($response['success']);
		//var_dump($response); // <-- uncomment this line to see the result!
	}


	public function testFn_ResponseLog()
	{
		$aviResponse = new AviResponse();
		$result = 'Test log';
		$aviResponse->action('test');
		$aviResponse->data = 'test';
		$aviResponse->log($result);
		$response = json_decode($aviResponse->get(), true);
		// var_dump($response); // <-- uncomment this line to see the result!

		$this->assertEquals($result, $response['log'][0]['message']);
	}


	public function testFn_Type()
	{
		$test = 'array';
		$aviResponse = new AviResponseTest();
		$aviResponse->type($test);
		$aviResponse->getType();
		$response = $aviResponse->get();
		$this->assertEquals($test, $response['data']['type']);
	}


	public function testFm_LogMessage()
	{
		$aviResponse = new AviResponseTest();
		$response =$aviResponse -> testLogMessages(300);
		$test = 300;
		$this->assertEquals($test, $response);
		//var_dump($response);
	}


	public function testFn_Result()
	{
		ob_start();
		$_REQUEST['fn'] = 1;
		$aviResponse = new AviResponseTest('call');
		$aviResponse->type('array');
		$aviResponse->result();
		$result = ob_get_clean();
		$test = [
			'test data'
		];
		$this->assertEquals(print_r($test, true), $result);
		//var_dump($result); // <-- uncomment this line to see the result!

		$_REQUEST['fn'] = 2;
		$aviResponse->type('html');
		$test = '<div>Test Data</div>';
		ob_start();
		$aviResponse->result();
		$result = ob_get_clean();
		$this->assertEquals($test, $result);

		$result = $aviResponse->result(null, true);
		$this->assertEquals($test, $result['data']);

		ob_start();
		$aviResponse->type('xjson');
		$aviResponse->result();
		$headersList = headers_list();
		$test = '{"action":"call","data":"<div>Test Data<\/div>","log":[],"success":null}';
		$result = ob_get_clean();
		$this->assertEquals($test, $result);

		// var_dump($result); // <-- uncomment this line to see the result!
	}

}