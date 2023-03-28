<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\Tools as AviTools;
use Avi\Db;

final class testAviatoTools extends TestCase
{


	public function testFn_applyDefault(): void
	{
		// test assertion for normal usage
		$attributes = [
			'id' => '1',
			'slug' => 'One'
		];
		$defaultAttributes = [
			'name' => 'Aviato Soft'
		];
		$result = [
			'id' => '1',
			'slug' => 'One',
			'name' => 'Aviato Soft'
		];
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
		$array = [
			'id' => 1,
			'text' => 'aviato'
		];
		$result = '<div id="1">aviato</div>';

		$test = AviTools::str_supplant($pattern, $array);

		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_sprinta(): void
	{

		// test assertion for normal usage:
		$pattern = '<div id="{id}">{text}</div>';
		$array = [
			'id' => 1,
			'text' => 'aviato'
		];
		$result = '<div id="1">aviato</div>';

		$test = AviTools::sprinta($pattern, $array);

		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_printa(): void
	{

		// test assertion for normal usage:
		$pattern = '<div id="{id}">{text}</div>';
		$array = [
			'id' => 1,
			'text' => 'aviato'
		];
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
		$array = [
			[
				'id' => 1,
				'text' => 'aviato'
			],
			[
				'id' => 2,
				'text' => 'soft'
			],
			[
				'id' => 3,
				'text' => 'web'
			]
		];
		$result = '<div id="1">aviato</div><div id="2">soft</div><div id="3">web</div>';

		$test = AviTools::sprintaa($pattern, $array);

		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_printaa(): void
	{
		// test assertion for normal usage:
		$pattern = '<div id="{id}">{text}</div>';
		$array = [
			[
				'id' => 1,
				'text' => 'aviato'
			],
			[
				'id' => 2,
				'text' => 'soft'
			],
			[
				'id' => 3,
				'text' => 'web'
			]
		];
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

		// test assertion list usage = NON associative array
		$array = [
			0 => 'apple',
			1 => 'orange',
			2 => 'pear'
		];
		$pattern = '<li>%s</li>';
		$result = '<li>apple</li><li>orange</li><li>pear</li>';
		$test = AviTools::atos($array, $pattern, [
			'isPrintFormat' => true
		]);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion missing one parameter usage:
		$array = [
			'a' => [
				'id' => 1,
				'slug' => 'One'
			],
			'b' => [
				'id' => 2
			],
			'x' => []
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
		$array = [
			0 => [
				'id' => 1,
				'slug' => 'One',
				'x' => 'ics'
			],
			1 => [
				0 => 1,
				'id' => 2,
				'slug' => 'Two'
			]
		];
		$pattern = '<p data-id="{id}">{slug}</p>';
		$result = '<p data-id="1">One</p><p data-id="2">Two</p>';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion invalid parameters types:
		$testDateTime = new DateTime();
		$array = [
			0 => [
				'id' => 1,
				'slug' => 'One'
			],
			1 => [
				'id' => "2",
				'slug' => [
					'Two'
				],
				0 => 7
			],
			2 => [
				'id' => 3.0,
				'slug' => $testDateTime
			],
			3 => [
				'id' => 4,
				'slug' => true
			]
		];
		$pattern = '<p data-id="{id}">{slug}</p>';
		$result = '<p data-id="1">One</p>'.'<p data-id="2">array</p>'.'<p data-id="3">object</p>'.
			'<p data-id="4">true</p>';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion invalid parameters types:
		$testDateTime = new DateTime();
		$array = [
			'a1' => [
				'id' => 1,
				'slug' => 'One'
			],
			'a2' => [
				'id' => "2",
				'slug' => 'Two'
			],
			'a3' => [
				'id' => 3.0,
				'slug' => 'E3E'
			],
			3 => [
				'id' => 4,
				'slug' => true
			]
		];
		$pattern = '<p data-id="{id}">{slug}</p>';
		$result = implode('',
			[
				'<p data-id="1">One</p>',
				'<p data-id="2">Two</p>',
				'<p data-id="3">E3E</p>',
				'<p data-id="4">true</p>'
			]);
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
//		var_dump($test); // <-- uncomment this line to see the result!

		// test assertion invalid array return empty:
		$array = false;
		$result = '';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test array with one dimension
		$array = [
			'id' => 1,
			'slug' => 'One'
		];
		$result = '<p data-id="1">One</p>';
		$test = AviTools::atos($array, $pattern);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test configs
		$array = [
			0 => [
				'id' => 1,
				'slug' => 'One',
				'x' => 'ics'
			],
			1 => [
				0 => 1,
				'id' => 2,
				'slug' => 'Two'
			]
		];
		$result = '<p data-id="1">One</p><p data-id="2">Two</p>';
		$test = AviTools::atos($array, $pattern, false);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test tags config
		$array = [
			0 => [
				'id' => 1,
				'slug' => 'One'
			],
			1 => [
				'id' => 2,
				'slug' => 'Two'
			]
		];
		$pattern = '<p data-id="[[id]]">[[slug]]</p>';
		$result = '<p data-id="1">One</p><p data-id="2">Two</p>';
		$test = AviTools::atos($array, $pattern, [
			'startTag' => '[[',
			'endTag' => ']]'
		]);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test isPrintFormat config
		$array = [
			0 => [
				'id' => 1,
				'slug' => 'One'
			],
			1 => [
				'id' => 2,
				'slug' => 'Two'
			]
		];
		$pattern = '<p data-id="%s">%s</p>';
		$result = '<p data-id="1">One</p><p data-id="2">Two</p>';
		$test = AviTools::atos($array, $pattern, [
			'isPrintFormat' => true
		]);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion missing one parameter usage with isPrintFormat:
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
		$pattern = '<p data-id="%s">%s</p>';
		$result = '<p data-id="1">One</p>';
		// $this->expectException();
		$test = AviTools::atos($array, $pattern, [
			'isPrintFormat' => true,
			'nrArgs' => 2
		]);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion extra parameters usage with isPrintFormat:
		$array = [
			0 => [
				'id' => 1,
				'slug' => 'One',
				'x' => 'ics'
			],
			1 => [
				0 => 1,
				'id' => 2,
				'slug' => 'Two'
			]
		];
		$pattern = '<p data-id="%s">%s</p>';
		$result = '<p data-id="1">One</p><p data-id="1">2</p>';
		$test = AviTools::atos($array, $pattern, [
			'isPrintFormat' => true
		]);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test array with one dimension
		$array = [
			'id' => 1,
			'slug' => 'One'
		];
		$pattern = '<p>%s</p>';
		$result = '<p>1</p><p>One</p>';
		$test = AviTools::atos($array, $pattern, [
			'isPrintFormat' => true
		]);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!


		// test assertion missing one parameter usage with isPrintFormat:
		$array = [
			'x1' => [
				'id' => 1,
				'slug' => '<h1>One</h1>'
			],
			'x2' => [
				'id' => 2,
				'slug' => '<h2>Two</h2>'
			]
		];
		$pattern = '<textarea data-id="{id}">{{slug}}</textarea>';
		$result = implode('', [
			'<textarea data-id="1">&lt;h1&gt;One&lt;/h1&gt;</textarea>',
			'<textarea data-id="2">&lt;h2&gt;Two&lt;/h2&gt;</textarea>'
		]);
		$test = AviTools::atos($array, $pattern, [
			'htmlentities' => true
		]);
		$this->assertEquals($result, $test);
		//var_dump($test); // <-- uncomment this line to see the result!


		// performance test
		$array = [];
		for ($i = 0; $i < 10000; $i ++) {
			$array[] = [
				'id' => 1,
				'slug' => 'One'
			];
		}
		$pattern = '<p data-id="{id}">{slug}</p>';
		$microtime = microtime(true);
		$test = AviTools::atos($array, $pattern);
		$mt1 = microtime(true) - $microtime;
		echo "\nATOS time for mustash:".$mt1;

		$pattern = '<p data-id="%s">%s</p>';
		$microtime = microtime(true);
		$test = AviTools::atos($array, $pattern, array(
			'isPrintFormat' => true
		));
		$mt2 = microtime(true) - $microtime;
		echo "\nATOS time for sprintf:".$mt2;

		$pattern = '<p data-id="{id}">{slug}</p>';
		$microtime = microtime(true);
		$test = AviTools::sprintaa($pattern, $array);
		$mt3 = microtime(true) - $microtime;
		echo "\nATOS time for sprintaa:".$mt3;

		echo "\n sprintf is ".(int) ($mt1 / $mt2)."x faster than mustash\n";
	}


	public function testFn_dec(): void
	{
		// test assertion for normal usage
		$result = 'Aviato Soft';
		$test = AviTools::dec('RnhnWDF3RXduUUF4RVFsOGQ5ancvdz0');
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		// test assertion for normal usage
		$result = 'Aviato Soft';
		$test = AviTools::dec('RnhnWDF3RXduUUF4RVFsOGQ5ancvd');
		//var_dump($test); // <-- uncomment this line to see the result!
		$this->assertEquals(false, $test);
	}


	public function testFn_enc(): void
	{
		// test assertion for normal usage
		$result = 'RnhnWDF3RXduUUF4RVFsOGQ5ancvdz0';
		$test = AviTools::enc('Aviato Soft');
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function test_Fn_enc_dec(): void
	{
		$result = 'Aviato';
		$test = AviTools::dec(AviTools::enc($result));
		$this->assertEquals($result, $test);

		define('AVI_KEY', 'TheSecretKey123');
		$test = AviTools::dec(AviTools::enc($result));
		$this->assertEquals($result, $test);
	}


	public function testFn_isAjaxCall(): void
	{
		// test assertion for normal usage
		$result = false;
		$test = AviTools::isAjaxCall();
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		$var = 'get';
		$_REQUEST[$var] = '';
		$result = true;
		$test = AviTools::isAjaxCall($var);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!
		/*
		 * //test assertion simulate ajax call
		 * $_GET['get'] = 'test';
		 * $result = true;
		 * $test = AviTools::isAjaxCall('get');
		 * $this -> assertEquals($result, $test);
		 * // var_dump($test); // <-- uncomment this line to see the result!
		 */
	}


	public function testFn_isGdprSet(): void
	{
		$service = 'google';
		$result = false; // gdpr cookie is not set => result = false
		$test = AviTools::isGdprSet($service);
		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!

		$_COOKIE['gdpr'] = "invalid value";
		$result = false; // gdpr cookie has not service => result = false
		$test = AviTools::isGdprSet($service);
		$this->assertEquals($result, $test);

		$_COOKIE['gdpr'] = "[]";
		$result = false; // gdpr cookie has not service => result = false
		$test = AviTools::isGdprSet($service);
		$this->assertEquals($result, $test);

		$_COOKIE['gdpr'] = '["aviato","essential","facebook","google","tradetracker"]';

		$result = true; // gdpr cookie has service => result = true
		$test = AviTools::isGdprSet($service);
		$this->assertEquals($result, $test);
	}


	public function testFn_Redirect(): void
	{
		ob_start();
		AviTools::redirect('home', 'html');
		$headersList = headers_list();
		$result = ob_get_clean();
		$test = '';
		$this->assertEquals($result, $test);
		// var_dump($result);
	}


	public function testFn_validateDate(): void
	{
		$test = true;
		$result = AviTools::validateDate('2013-09-11 13:12:11');
		$this->assertEquals($test, $result);
	}


	public function testfn_dtFormatToFormat(): void
	{
		$test = '11.09.2013';
		$result = AviTools::dtFormatToFormat('2013-09-11', 'yyyy-mm-dd', 'dd.mm.yyyy');
		$this->assertEquals($result, $test);

		$test = '2013-09-11';
		$result = AviTools::dtFormatToFormat('2013-09-11', 'yyyy-mm-dd', 'yyyy-mm-dd');
		$this->assertEquals($result, $test);

		$test = false;
		$result = AviTools::dtFormatToFormat('2013-09-11', 'yyyy:mm:dd', 'dd.mm.yyyy');
		$this->assertEquals($result, $test);

		$test = false;
		$result = AviTools::dtFormatToFormat('2013-09-11', 'yyyy-mm-dd', 'dd:mm:yyyy');
		$this->assertEquals($result, $test);
	}


	public function testFn_mysqlTableFromValues(): void
	{
		// test assertion normal usage:
		$name = 'Test';
		$values = [
			[
				'id' => 1,
				'type' => 'Offer'
			],
			[
				'id' => 2,
				'type' => 'Hotel'
			],
			[
				'id' => 3,
				'type' => 'Upsell'
			],
		];
		$result = "(SELECT * FROM (VALUES ROW(1,'Offer'),ROW(2,'Hotel'),ROW(3,'Upsell')) AS `Test` (`id`,`type`)) `Test` ";
		$test = AviTools::mysqlTableFromValues($name, $values);

		$this->assertEquals($result, $test);
		// var_dump($test); // <-- uncomment this line to see the result!
	}


	public function testFn_emailify(): void
	{
		$name = 'John Doe';
		$email = 'john@aviato.ro';
		$test = sprintf('%s <%s>', $name, $email);
		$result = AviTools::emailify($email, $name);

		$this->assertEquals($result, $test);
		// var_dump($result); // <-- uncomment this line to see the result!
	}


	public function testFn_afilterKeyExists(): void
	{
		$values = [
			0 => ['id'=>1, 'name'=>'orange', 'isOkay'=>true],
			1 => ['id'=>2, 'name'=>'apple', 'isOkay'=>false],
			2 => ['id'=>3, 'name'=>'pear'],
			3 => ['id'=>4, 'name'=>'banana', 'isOkay'=>null],
		];
		$test = [
			0 => ['id'=>1, 'name'=>'orange', 'isOkay'=>true],
			1 => ['id'=>2, 'name'=>'apple', 'isOkay'=>false]
		];
		$result = AviTools::afilterKeyExists($values, 'isOkay');

		$this->assertEquals($test, $result);
		// var_dump($result); // <-- uncomment this line to see the result!
	}


	public function testFn_str_random(): void
	{
		$result = AviTools::str_random();
		$this->assertEquals(20, strlen($result));
	}


	public function testFn_atoattr(): void
	{
		$test = 'data-action="call" data-call="widget"';
		$result = AviTools::atoattr([
			'action' => 'call',
			'call' => 'widget'
		], 'data-');
		$this->assertEquals($test, $result);
	}
}
