<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.

declare(strict_types = 1);

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/assets/Sections.php';

use PHPUnit\Framework\TestCase;
use Avi\UI as AviUi;
use const Avi\AVI_JS_MD5;

final class testAviatoUi extends TestCase
{


	public function testFn_Construct(): void
	{
		$aviUi = new AviUi();

		// assert attribute page:
		$this->assertObjectHasAttribute('page', $aviUi);
		$test = [
			'stylesheet' => [],
			'javascript' => []
		];
		$this->assertEquals($test, $aviUi->page);

		// assert attribute response:
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
		$response = $aviUi->Section('test', [], true);
		$test = '<section id="test" class="sec-obj-test">test section</section>';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		//Object section no wrapper + including js file
		$response = $aviUi->Section('test', [
			'wrapper' => false,
			'javascript' => [
				'test.js'
			]
		], true);
		$test = 'test section';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		$test = 'test.js';
		$this->assertEquals($test, $aviUi->page['javascript'][0]);

		//section  type = Object undefined
		//$aviUi->response = 'test22';
		$response = $aviUi->Section('test7', ['wrapper' => false], true);
		$test = '';
		$this->assertEquals($test, $response);


		// Html section
		$response = $aviUi->Section('test',
			[
				'wrapper' => false,
				'class' => 'test',
				'type' => 'html',
				'root' => dirname(__FILE__)
			], true);
		$test = '<div class="html">Test</div>';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// PHP section
		$response = $aviUi->Section('test', [
			'wrapper' => false,
			'type' => 'php',
			'root' => dirname(__FILE__)
		], true);
		$test = '<div class="php">Test</div>';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// Missing Html section
		$response = $aviUi->Section('missing',
			[
				'wrapper' => false,
				'class' => 'test',
				'type' => 'html',
				'root' => dirname(__FILE__)
			], true);
		$test = '';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// Missing PHP section
		$response = $aviUi->Section('missing', [
			'wrapper' => false,
			'type' => 'php',
			'root' => dirname(__FILE__)
		], true);
		$test = '';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		// Missing object
		$aviUi = new AviUi();
		$response = $aviUi->Section('test', [
			'wrapper' => false
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
		$result = ob_get_clean();
		$test = 'test section';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);
	}


	public function testFn_Page(): void
	{
		$template = '<!DOCTYPE html>' . "\n";
		$template .= '<html lang="en-EN">' . "\n";
		$template .= '<head><meta charset="UTF-8"><meta http-equiv="content-type" content="text/html">' .
			'<meta name="application-name" content="AviLib"><meta name="author" content="Aviato Soft">' .
			'<meta name="description" content="Web dust library v.' . Avi\Version::get() . '">' .
			'<meta name="generator" content="AviatoWebBuilder">' . '<meta name="keywords" content="%s">' .
			'<meta name="viewport" content="width=device-width, initial-scale=1.0">';
		$template .= '<title>website</title>';
		$template .= '<link rel="shortcut icon" href="//www.aviato.ro/favicon.ico"/>%s</head>' . "\n";
		$template .= '<body%s>' . "\n";
		$template .= '%s' . "\n";
		$template .= '%s';
		$template .= '<script src="/vendor/aviato-soft/avi-lib/src/js/aviato-' . AVI_JS_MD5 . '-min.js"></script>' . "\n";
		$template .= '</body>' . "\n";
		$template .= '</html>';

		// test 1: empty default page
		$testv = [
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
			'Test',
			'<link href="/css/aviato.css" rel="stylesheet" type="text/css"/><script>;</script>',
			' class="avi"',
			'<div>test</div>',
			'<script src="/js/aviato.js"></script>' . "\n"
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
		$aviUi->Page([
			'class' => 'avi',
			'meta' => [
				45 => [
					'name' => 'keywords',
					'content' => 'Test'
				]
			]
		]);
		$result = ob_get_clean();

		// var_dump($result); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $result);
	}
}