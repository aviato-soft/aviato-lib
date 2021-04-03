<?php
declare(strict_types = 1);

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/assets/Sections.php';

use PHPUnit\Framework\TestCase;
use Avi\UI as AviUi;


final class testAviatoUi extends TestCase
{

	public function testFn_Construct(): void
	{
		$aviUi = new AviUi();

		// assert attribute page:
		$this->assertObjectHasAttribute('page', $aviUi);
		$test = [
			'style' => [],
			'javascript' => []
		];
		$this->assertEquals($test, $aviUi->page);

		// assert attribute response:
		$this->assertNull($aviUi->response);

		$aviUi = new AviUi([
			'response' => 'test'
		]);
		$this->assertEquals('test', $aviUi->response);
	}


	public function testFn_Section(): void
	{
		//Object section
		$aviUi = new AviUi();
		$response = $aviUi->Section('test', [], true);
		$test = '<section id="test" class="sec-obj-test">test section</section>';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		$response = $aviUi->Section('test', [
			'wrapper' => false,
			'javascript' => ['test.js']
		], true);
		$test = 'test section';
		//var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);

		$test = 'test.js';
		$this->assertEquals($test, $aviUi -> page['javascript'][0]);

		//Html section
		$response = $aviUi->Section('test', [
			'wrapper' => false,
			'class' => 'test',
			'type' => 'html',
			'root' => dirname(__FILE__)
		], true);
		$test = '<div class="html">Test</div>';
		//var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);


		//PHP section
		$response = $aviUi->Section('test', [
			'wrapper' => false,
			'type' => 'php',
			'root' => dirname(__FILE__)
		], true);
		$test = '<div class="php">Test</div>';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);


		//Missing Html section
		$response = $aviUi->Section('missing', [
			'wrapper' => false,
			'class' => 'test',
			'type' => 'html',
			'root' => dirname(__FILE__)
		], true);
		$test = '';
		//var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);


		//Missing PHP section
		$response = $aviUi->Section('missing', [
			'wrapper' => false,
			'type' => 'php',
			'root' => dirname(__FILE__)
		], true);
		$test = '';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);


		//Missing object
		$aviUi = new AviUi();
		$response = $aviUi->Section('test', ['wrapper' => false], true);
		$test = 'test section';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);


		//Test section echo response
		ob_start();
		$aviUi = new AviUi();
		$aviUi->Section('test', ['wrapper' => false], false);
		$result = ob_get_clean();
		$test = 'test section';
		// var_dump($response); // <-- uncomment this line to see the result!
		$this->assertEquals($test, $response);
	}
}