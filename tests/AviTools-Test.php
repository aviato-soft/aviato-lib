<?php
declare(strict_types = 1);

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Avi\Tools as AviTools;

final class testAviatoTools extends TestCase
{
	public function testFn_applyDefault(): void
	{
		// test assertion for normal usage
		$attributes = array(
			'id' => '1',
			'slug' => 'One'
		);
		$defaultAttributes = array(
			'name' => 'Aviato Soft'
		);
		$result = array(
			'id' => '1',
			'slug' => 'One',
			'name' => 'Aviato Soft'
		);
		$test = AviTools::applyDefault($attributes, $defaultAttributes);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion with bad type of parameters
		$attributes = false;
		$defaultAttributes = false;
		$result = false;
		$test = AviTools::applyDefault($attributes, $defaultAttributes);
		$this->assertEquals($result, $test);
	}


	public function testFn_str_supplant(): void
	{

		// test assertion for normal usage:
		$pattern = '<div id="{id}">{text}</div>';
		$array = array(
			'id' => 1,
			'text' => 'aviato'
		);
		$result = '<div id="1">aviato</div>';

		$test = AviTools::str_supplant($pattern, $array);

		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_sprinta(): void
	{

		// test assertion for normal usage:
		$pattern = '<div id="{id}">{text}</div>';
		$array = array(
			'id' => 1,
			'text' => 'aviato'
		);
		$result = '<div id="1">aviato</div>';

		$test = AviTools::sprinta($pattern, $array);

		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_printa(): void
	{

		// test assertion for normal usage:
		$pattern = '<div id="{id}">{text}</div>';
		$array = array(
			'id' => 1,
			'text' => 'aviato'
		);
		$result = '<div id="1">aviato</div>';

		ob_start();
		$test = AviTools::printa($pattern, $array);
		$test2 = ob_get_contents();
		ob_end_clean();

		$this->assertEquals($result, $test);
		$this->assertEquals($result, $test2);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_sprintaa(): void
	{

		// test assertion for normal usage:
		$pattern = '<div id="{id}">{text}</div>';
		$array = array(
			array(
				'id' => 1,
				'text' => 'aviato'
			),
			array(
				'id' => 2,
				'text' => 'soft'
			),
			array(
				'id' => 3,
				'text' => 'web'
			)
		);
		$result = '<div id="1">aviato</div><div id="2">soft</div><div id="3">web</div>';

		$test = AviTools::sprintaa($pattern, $array);

		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_printaa(): void
	{
		// test assertion for normal usage:
		$pattern = '<div id="{id}">{text}</div>';
		$array = array(
			array(
				'id' => 1,
				'text' => 'aviato'
			),
			array(
				'id' => 2,
				'text' => 'soft'
			),
			array(
				'id' => 3,
				'text' => 'web'
			)
		);
		$result = '<div id="1">aviato</div><div id="2">soft</div><div id="3">web</div>';

		ob_start();
		$test = AviTools::printaa($pattern, $array);
		$test2 = ob_get_contents();
		ob_end_clean();

		$this->assertEquals($result, $test);
		$this->assertEquals($result, $test2);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_atos(): void
	{
		// test assertion normal usage:
		$array = [
			0 => [
				'id' => 1.0,
				'slug' => 'One'
			],
			1 => [
				'id' => '2',
				'slug' => 'Two'
			]
		];
		$pattern = '<p data-id="{id}">{slug}</p>';
		$result = '<p data-id="1">One</p><p data-id="2">Two</p>';
		$test = AviTools::atos($array, $pattern);

		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion missing one parameter usage:
		$array = [
			0 => [
				'id' => 1,
				'slug' => 'One'
			],
			1 => [
				'id' => 2
			],
			2 => []
		];
		$pattern = '<p data-id="{id}">{slug}</p>';
		$result = '<p data-id="1">One</p><p data-id="2">{slug}</p><p data-id="{id}">{slug}</p>';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!


		// test assertion invalid pattern parameter usage:
		$pattern = false;
		$result = '';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion extra parameters usage:
		$array = array(
			0 => array(
				'id' => 1,
				'slug' => 'One',
				'x' => 'ics'
			),
			1 => array(
				0 => 1,
				'id' => 2,
				'slug' => 'Two'
			)
		);
		$pattern = '<p data-id="{id}">{slug}</p>';
		$result = '<p data-id="1">One</p><p data-id="2">Two</p>';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion invalid parameters types:
		$testDateTime = new DateTime();
		$array = array(
			0 => array(
				'id' => 1,
				'slug' => 'One'
			),
			1 => array(
				'id' => "2",
				'slug' => array(
					'Two'
				),
				0 => 7
			),
			2 => array(
				'id' => 3.0,
				'slug' => $testDateTime
			),
			3 => array(
				'id' => 4,
				'slug' => true
			)
		);
		$pattern = '<p data-id="{id}">{slug}</p>';
		$result = '<p data-id="1">One</p>' . '<p data-id="2">array</p>' . '<p data-id="3">object</p>' . '<p data-id="4">true</p>';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion invalid array return empty:
		$array = false;
		$result = '';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test array with one dimension
		$array = array(
			'id' => 1,
			'slug' => 'One'
		);
		$result = '<p data-id="1">One</p>';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test configs
		$array = array(
			0 => array(
				'id' => 1,
				'slug' => 'One',
				'x' => 'ics'
			),
			1 => array(
				0 => 1,
				'id' => 2,
				'slug' => 'Two'
			)
		);
		$result = '<p data-id="1">One</p><p data-id="2">Two</p>';
		$test = AviTools::atos($array, $pattern, false);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test tags config
		$array = array(
			0 => array(
				'id' => 1,
				'slug' => 'One'
			),
			1 => array(
				'id' => 2,
				'slug' => 'Two'
			)
		);
		$pattern = '<p data-id="[[id]]">[[slug]]</p>';
		$result = '<p data-id="1">One</p><p data-id="2">Two</p>';
		$test = AviTools::atos($array, $pattern, array(
			'startTag' => '[[',
			'endTag' => ']]'
		));
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test isPrintFormat config
		$array = array(
			0 => array(
				'id' => 1,
				'slug' => 'One'
			),
			1 => array(
				'id' => 2,
				'slug' => 'Two'
			)
		);
		$pattern = '<p data-id="%s">%s</p>';
		$result = '<p data-id="1">One</p><p data-id="2">Two</p>';
		$test = AviTools::atos($array, $pattern, array(
			'isPrintFormat' => true
		));
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion missing one parameter usage with isPrintFormat:
		$array = array(
			0 => array(
				'id' => 1,
				'slug' => 'One'
			),
			1 => array(
				'id' => 2
			),
			2 => array()
		);
		$pattern = '<p data-id="%s">%s</p>';
		$result = '<p data-id="1">One</p>';
		// $this->expectException();
		$test = AviTools::atos($array, $pattern, array(
			'isPrintFormat' => true
		));
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion extra parameters usage with isPrintFormat:
		$array = array(
			0 => array(
				'id' => 1,
				'slug' => 'One',
				'x' => 'ics'
			),
			1 => array(
				0 => 1,
				'id' => 2,
				'slug' => 'Two'
			)
		);
		$pattern = '<p data-id="%s">%s</p>';
		$result = '<p data-id="1">One</p><p data-id="1">2</p>';
		$test = AviTools::atos($array, $pattern, array(
			'isPrintFormat' => true
		));
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test array with one dimension
		$array = array(
			'id' => 1,
			'slug' => 'One'
		);
		$pattern = '<p data-id="%s">%s</p>';
		$result = '<p data-id="1">One</p>';
		$test = AviTools::atos($array, $pattern, array(
			'isPrintFormat' => true
		));
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// performance test
		$array = array();
		for ($i = 0; $i < 10000; $i ++) {
			$array[] = array(
				'id' => 1,
				'slug' => 'One'
			);
		}
		$pattern = '<p data-id="{id}">{slug}</p>';
		$microtime = microtime(true);
		$test = AviTools::atos($array, $pattern);
		$mt1 = microtime(true) - $microtime;
		echo "\nATOS time for mustash:" . $mt1;

		$pattern = '<p data-id="%s">%s</p>';
		$microtime = microtime(true);
		$test = AviTools::atos($array, $pattern, array(
			'isPrintFormat' => true
		));
		$mt2 = microtime(true) - $microtime;
		echo "\nATOS time for sprintf:" . $mt2;

		$pattern = '<p data-id="{id}">{slug}</p>';
		$microtime = microtime(true);
		$test = AviTools::sprintaa($pattern, $array);
		$mt3 = microtime(true) - $microtime;
		echo "\nATOS time for sprintaa:" . $mt3;

		echo "\n sprintf is " . (int) ($mt1 / $mt2) . "x faster than mustash\n";
	}


	public function testFn_dec(): void {
		//test assertion for normal usage
		$result = 'Aviato Soft';
		$test = AviTools::dec('RnhnWDF3RXduUUF4RVFsOGQ5ancvdz0');
		$this -> assertEquals($result, $test);
		//		var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_enc(): void {
		//test assertion for normal usage
		$result = 'RnhnWDF3RXduUUF4RVFsOGQ5ancvdz0';
		$test = AviTools::enc('Aviato Soft');
		$this -> assertEquals($result, $test);
		//		var_dump($test); // <-- uncomment this line to see the result!
	}


	public function test_Fn_enc_dec(): void {
		$result = 'Aviato';
		$test = AviTools::dec(AviTools::enc($result));
		$this -> assertEquals($result, $test);
	}


	public function testFn_isAjaxCall(): void {
		//test assertion for normal usage
		$result = false;
		$test = AviTools::isAjaxCall();
		$this -> assertEquals($result, $test);
		//		var_dump($test); // <-- uncomment this line to see the result!

		$var = 'get';
		$_REQUEST[$var] = '';
		$result = true;
		$test = AviTools::isAjaxCall($var);
		$this -> assertEquals($result, $test);
		//		var_dump($test); // <-- uncomment this line to see the result!
/*
		//test assertion simulate ajax call
		$_GET['get'] = 'test';
		$result = true;
		$test = AviTools::isAjaxCall('get');
		$this -> assertEquals($result, $test);
		//		var_dump($test); // <-- uncomment this line to see the result!
*/

	}

	public function testFn_Redirect(): void {
		ob_start();
		AviTools::redirect('home', 'html');
		$headersList = headers_list();
		$result = ob_get_clean();
		$test = '';
		$this -> assertEquals($result, $test);
		// var_dump($result);
	}


	public function testFn_mysqlTableFromValues(): void {
		//test assertion normal usage:
		$name = 'Test';
		$values = array(
			array('id' => 1, 'type' => 'Offer'),
			array('id' => 2, 'type' => 'Hotel'),
			array('id' => 3, 'type' => 'Upsell'),
		);
		$result = "(SELECT * FROM (VALUES ROW(1,'Offer'),ROW(2,'Hotel'),ROW(3,'Upsell')) AS `Test` (`id`,`type`)) `Test` ";
		$test = AviTools::mysqlTableFromValues($name, $values);

		$this -> assertEquals($result, $test);
		//		var_dump($test); // <-- uncomment this line to see the result!


	}

}
