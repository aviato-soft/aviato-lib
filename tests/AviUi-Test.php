<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/assets/Sections.php';

use PHPUnit\Framework\TestCase;
use Avi\UI as AviUi;
use const Avi\AVI_JS_MD5;

final class testAviatoUi extends TestCase
{


	public function testFn_Construct(): void
	{
		$aviUi = new AviUi();
		$this->assertIsObject($aviUi);

		// assert attribute page:
		$this->assertTrue(property_exists($aviUi, 'page'));
		$test = [
			'stylesheet' => [],
			'javascript' => []
		];
		$this->assertEquals($test, $aviUi->page);

		// assert attribute response:
		$this->assertTrue(property_exists($aviUi, 'response'));
		$this->assertEmpty($aviUi->response);

		$aviUi = new AviUi([
			'response' => 'test'
		]);
		$this->assertEquals('test', $aviUi->response);
	}


	public function testFn_Section(): void
	{
		// Object section normal
		$aviUi = new AviUi();
		$response = $aviUi->Section('test', [
			'folder' => 'assets',
			'root' => dirname(__FILE__)
		], true);
		$test = '<section class="sec-obj-test" id="test">test section</section>';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// Attributes
		$response = $aviUi->Section('test', [
			'attributes' => [
				'src' => 'javascript:;',
				'data-role' => 'test'
			],
			'folder' => 'assets',
			'root' => dirname(__FILE__)
		], true);
		$test = '<section class="sec-obj-test" data-role="test" id="test" src="javascript:;">test section</section>';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);


		// Object section no wrapper + including js file
		$response = $aviUi->Section('test', [
			'wrapper' => false,
			'javascript' => [
				'test.js'
			]
		], true);
		$test = 'test section';
		//var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		$test = 'test.js';
		$this->assertEquals($test, $aviUi->page['javascript'][0]);

		// section type = Object undefined
		// $aviUi->response = 'test22';
		$response = $aviUi->Section('test7', [
			'wrapper' => false
		], true);
		$test = '';
		$this->assertEquals($test, $response);


		$response = $aviUi->Section('test8', [
			'obj' => 'Sections',
			'params' => [
				'A',
				'B'
			]
		], true);
		$test = '<section class="sec-obj-test8" id="test8"><pre>A | B</pre></section>';
		$this->assertEquals($test, $response);

		// Html section
		$response = $aviUi->Section('test',
			[
				'class' => 'test',
				'folder' => 'assets',
				'root' => dirname(__FILE__),
				'type' => 'html',
				'wrapper' => false
			], true);
		$test = '<div class="html">Test</div>';
		//var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// Missing Html section
		$response = $aviUi->Section('missing',
			[
				'type' => 'html',
			], true);
		$test = '<section class="sec-html-missing" id="missing"></section>';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// Missing PHP section
		$response = $aviUi->Section('missing', [
			'type' => 'php',
			'wrapper' => false
		], true);
		$test = '';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		//Missing php section no log message
		$aviUi -> log = '';
		$response = $aviUi->Section('missing', [
			'type' => 'php',
			'wrapper' => false
		], true);
		$test = 'Missing php file on include in [section]:'.dirname(dirname(__FILE__)).'/src/sections/missing.php';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// Missing object
		$aviUi = new AviUi();
		$response = $aviUi->Section('missingObject', [
			'wrapper' => false
		], true);
		$test = '';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// section type = Object undefined
		$aviUi->response = 'test22';
		$response = $aviUi->Section('test7', [
			'wrapper' => false
		], true);
		$test = '';
		$this->assertEquals($test, $response);

		$aviUi -> log = '';
		$response = $aviUi->Section('missingObject', [
			'wrapper' => false
		], true);
		$test = 'UI: Missing object definition: Sections::missingObject';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		//send warning to log if section is a response object
		$aviUi->response = new Avi\Response();
		$response = $aviUi->Section('missingObject', [
			'wrapper' => false
		], true);
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($response, '');



		//Inline SCRIPT section
		$aviUi = new AviUi();
		$response = $aviUi -> Section('test', [
			'folder' => 'assets',
			'root' => dirname(__FILE__),
			'type' => 'script',
			'wrapper' => false,
		], true);
		$test = implode(PHP_EOL, [
			'<script >var test = {',
			'	info: \'this is a test\'',
			'};</script>'
		]);
		$this->assertEquals($test, $response);

		//MIssing Inline SCRIPT section
		$aviUi = new AviUi();
		$response = $aviUi -> Section('testX', [
			'folder' => 'assets',
			'root' => dirname(__FILE__),
			'type' => 'script',
			'wrapper' => false,
		], true);
		$test = '<script ></script>';
		$this->assertEquals($test, $response);

		// Object section no wrapper + including js file
		$response = $aviUi->Section('test', [
			'wrapper' => false,
			'javascript' => [
				'test.js'
			]
		], true);
		$test = 'test section';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// Test section echo response
		ob_start();
		$aviUi = new AviUi();
		$aviUi->Section('test', [
			'wrapper' => false
		], false);
		$response = ob_get_clean();
		$test = 'test section';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);
	}


	public function testFn_Page(): void
	{
		$template = implode('',
			[
				'<!doctype html>'.PHP_EOL,
				'<html %slang="en-EN">'.PHP_EOL,
				'<head><meta charset="UTF-8">',
				'<meta http-equiv="content-type" content="text/html">',
				'<meta name="application-name" content="AviLib">',
				'<meta name="author" content="Aviato Soft">',
				'<meta name="description" content="Web dust library v.'.Avi\Version::get().'">',
				'<meta name="generator" content="AviatoWebBuilder">',
				'<meta name="keywords" content="%s">',
				'<meta name="viewport" content="width=device-width, initial-scale=1.0">'.PHP_EOL,
				'<title>website</title>'.PHP_EOL,
				'<link rel="shortcut icon" href="//www.aviato.ro/favicon.ico"/>%s</head>'.PHP_EOL,
				'<body%s>'.PHP_EOL,
				'%s'.PHP_EOL,
				'%s',
				'<script src="/vendor/aviato-soft/avi-lib/src/js/aviato-'.AVI_JS_MD5.'-min.js"></script>'.PHP_EOL,
				'</body>'.PHP_EOL,
				'</html>'
			]);

		// test 1: empty default page
		$testv = [
			'',
			'Aviato, Aviato Soft, Aviato Web',
			'',
			'',
			'',
			''
		];
		$test = vsprintf($template, $testv);

		// var_dump($test);
		ob_start();
		$aviUi = new AviUi();
		$aviUi->Page();
		$result = ob_get_clean();
		// echo ($result); // <-- uncomment this line to see the result!
		// echo ($test);
		$this->assertEquals($test, $result);

		// test 2: customized head:
		$testv = [
			'class="avi" ',
			'Test',
			'<link href="/css/aviato.css" rel="stylesheet" type="text/css"/><script>;</script>',
			' class="avi"',
			'<div>test</div>',
			'<script src="/js/aviato.js"></script>'."\n"
		];
		$test = vsprintf($template, $testv);
		// var_dump($test);
		ob_start();
		$aviUi = new AviUi();
		$aviUi->content = [
			'<div>test</div>'
		];
		$aviUi->header = [
			'<script>;</script>'
		];
		$aviUi->page['stylesheet'] = [
			0 => [
				'href' => '/css/aviato.css'
			]
		];
		$aviUi->page['javascript'] = [
			0 => [
				'src' => '/js/aviato.js'
			]
		];
		$aviUi->Page(
			[
				'class' => 'avi',
				'meta' => [
					45 => [
						'name' => 'keywords',
						'content' => 'Test'
					]
				],
				'options' => [
					'htmlAttr' => [
						'class' => 'avi'
					]
				]
			]);
		$result = ob_get_clean();

		// var_dump($result); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $result);
	}
}