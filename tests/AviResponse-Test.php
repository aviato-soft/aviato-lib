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


	public function testFn_Construct(): void
	{
		$aviResponse = new AviResponse();

		// assert attribute action:
		$this->assertObjectHasAttribute('action', $aviResponse);
		$test = $aviResponse->action;
		$this->assertNull($test);

		// assert attribute data:
		$this->assertObjectHasAttribute('data', $aviResponse);
		$test = [];
		$result = $aviResponse->data;
		$this->assertEquals($test, $result);

		// assert attribute success:
		$this->assertObjectHasAttribute('success', $aviResponse);
		$this->assertNull($aviResponse->success);
	}


	public function testFn_Get(): void
	{
		$aviResponse = new AviResponse();
		$result = json_decode($aviResponse->get(), true);
		// expected:
		// var_dump($result);
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
		$_REQUEST['section'] = 'testInvalid';
		$test = '<section id="testInvalid" class="sec-obj-testInvalid"></section>';
		$aviResponse = new AviResponseTest('section');
		$result = json_decode($aviResponse->get(), true);
		$this->assertEquals($test, $result['data']);
		$this->assertTrue($result['success']);

		// get(section)
		$_REQUEST['section'] = 'test';
		$test = '<section id="test" class="sec-obj-test">test section</section>';
		$aviResponse = new AviResponseTest('section');
		$result = json_decode($aviResponse->get(), true);
		$this->assertEquals($test, $result['data']);
		$this->assertTrue($result['success']);
		// var_dump($result); // <-- uncomment this line to see the result!

		//get(section) with params:
		$_REQUEST['section'] = 'test';
		$_REQUEST['params'] = 'a=1,b=2';
		// var_dump($_REQUEST);
		$aviResponse = new AviResponseTest('section');
		$result = json_decode($aviResponse->get(), true);
		$this->assertEquals($test, $result['data']);
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
		$result = json_decode($aviResponse->get(), true);
		//Missing Upload Handler Definition!
		$this->assertTrue($result['success']);

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

	/**
	 * Test method to set/get action
	 */
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


	/**
	 * Test method to set/get data
	 */
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


	/**
	 * Test success set/get function
	 */
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