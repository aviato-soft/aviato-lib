<?php
declare(strict_types = 1);

require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;

/***
Test database:
CREATE DATABASE  IF NOT EXISTS `avi-lib-test`;
USE `avi-lib-test`;
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `col_string` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_float` float DEFAULT NULL,
  `col_decimal` decimal(10,0) DEFAULT NULL,
  `col_bit` binary(1) DEFAULT NULL,
  `col_json` json DEFAULT NULL,
  `col_datetime` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
***/


use Avi\Db as AviDb;


final class xDb extends AviDb
{
	public function setOc($v)
	{
		$this->oc = $v;
	}
}


final class testAviatoDb extends TestCase
{

	public function testFn_Construct(): void
	{
		global $_AviDb;
		$_AviDb = $_AviDb ?? new AviDb();
		$this->assertIsObject($_AviDb);
		$this->assertTrue($_AviDb->isOpen());

		//invalid connection:
		$db = new AviDb(['server'=>'db-avi']);
		$this->assertIsObject($db);
		$this->assertFalse($db->isOpen());

		$xDb = new xDb();
		$this->assertIsObject($xDb);
		$xDb->setOc('v');
		$this->assertFalse($xDb->isOpen());

//
	}


	public function testFn_Insert(): void
	{
		global $_AviDb;
		$db = $_AviDb ?? new AviDb();
		$this->assertIsObject($db);
		$this->assertTrue($db->isOpen());

		//insert nothing
		$query = [
			'insert' => 'test',
			'values' => [
			]
		];
		$result = $db->add($query, []);
		$this->assertFalse($result);

		//simple insert without type
		$query['values'] = [
			'col_string' => $db->parseVar('Aviato Soft', '?str#50'),
			'col_float' => $db->parseVar(23.333, 'num')
		];
		$result = $db->parse($query);
		$test = "INSERT INTO `test` (`col_string`,`col_float`) VALUES('Aviato Soft',23.333000)";
		$this->assertEquals($test, $result);

		//simple insert one row without type
		$query['values'] = [[
			'col_string' => $db->parseVar('Aviato Soft', '?str#50'),
			'col_float' => $db->parseVar(23.333, 'num')
		]];
		$result = $db->parse($query);
		$test = "INSERT INTO `test` (`col_string`,`col_float`) VALUES('Aviato Soft',23.333000)";
		$this->assertEquals($test, $result);

		//simple insert with cols and types
		$query['values'] = [
			'col_string' => $db->parseVar('Aviato Soft', '?str#50'),
			'col_float' => $db->parseVar(23.333, 'num')
		];
		$query['columns'] = [
			'col_string',
			'col_float'
		];
		$result = $db->parse($query);
		$test = "INSERT INTO `test` (`col_string`,`col_float`) VALUES('Aviato Soft',23.333000)";
		$this->assertEquals($test, $result);

		//simple insert one row not associative with type
		$query = [
			'insert' => 'test'
		];
		$query['values'] = [
			'Aviato Soft',
			23.333
		];
		$query['columns'] = [
			'col_string',
			'col_float'
		];
		$query['types'] = [
			'?str#50',
			'num'
		];
		$result = $db->parse($query);
		$test = "INSERT INTO `test` (`col_string`,`col_float`) VALUES('Aviato Soft',23.333000)";
		$this->assertEquals($test, $result);

		//simple insert one row not associative without type
		$query = [
			'insert' => 'test'
		];
		$query['values'] = [
			$db->parseVar('Aviato Soft', '?str#50'),
			$db->parseVar(23.333, 'num')
		];
		$query['columns'] = [
			'col_string',
			'col_float'
		];
		$result = $db->parse($query);
		$test = "INSERT INTO `test` (`col_string`,`col_float`) VALUES('Aviato Soft',23.333000)";
		$this->assertEquals($test, $result);



		//insert one row
		$query = [
			'insert' => 'test'
		];
		$query['values'] = [
			'col_string' => 'Aviato Soft',
			'col_float' => 23.333
		];
		$query['types'] = [
			'col_string' => 'str_100',
			'col_float' => 'num',
			'col_decimal' => 'num',
			'col_bit' => 'bool',
			'col_json' => 'json',
			'col_datetime' => 'dtm'
		];
		$result = $db->insert($query, [], true);
		$test = $db->getLastId('test');
		$this->assertEquals($test, $result);


		//insert multiple rows
		$nr = random_int(2, 10);
		$test++; // only one insert
		$query['values'] = [];
		for ($i = 0; $i < $nr; $i++) {
			$decimal = rand() / 100;
			$int = random_int(10, 255);
			$query['values'][] = [
				'col_string' => 'Test '.\Avi\Tools::str_random($int),
				'col_float' => $decimal/10,
				'col_decimal' => $decimal,
				'col_bit' => (bool)($int > 130),
				'col_json' => [
					'str' => \Avi\Tools::str_random(10),
					'dec' => $decimal,
					'int' => $int
				],
				'col_datetime' => mt_rand(1378905255, time())
			];
		}

		//echo $db->parse($query, 'insert');//=> uncomment this line for debug
		$result = $db->insert($query);
		//echo PHP_EOL.'COMPARISON:'.PHP_EOL.'- test:'.$test.PHP_EOL.'- result:'.$result.PHP_EOL.'- rows:'.$nr.PHP_EOL; //=> uncomment this line for debug
		$this->assertEquals($test, $result);

		//insert select
	}


	public function testFn_Select()
	{
		$db = new AviDb();
		$this->assertIsObject($db);
		$this->assertTrue($db->isOpen());

		$nr = random_int(2, 10);

		//simple test
		$query = [
			'select' => [
				'id',
				'col_string',
				'col_float',
				'col_decimal',
				'col_bit',
				'col_json',
				'col_datetime',
				'created_at',
				'updated_at'
			],
			'from' => 'test',
			'where' => [
				"`id` >= 1",
				"`id` <= ".$db->parseVar($nr, 'int'),
			],
			'order' => "`id`",
		];
		$result1 = $db->get($query);


		//aggregated test
		$query['select'] = "SUM(`col_decimal`) AS `sumDecimal`";
		$result2 = $db->select($query);
		$test = array_sum(array_column($result1, 'col_decimal'));
		$this->assertEquals($test, $result2[0]['sumDecimal']);


		//empty select/where
		$query = [
			'select' => '',
			'from' => 'test',
			'where' => ''
		];
		$result = $db->parse($query);
		$test = 'SELECT * FROM `test`';
		$this->assertEquals($test, $result);


		//empty select/where
		$query = [
			'select' => [],
			'from' => 'test',
			'where' => []
		];
		$result = $db->parse($query);
		$test = 'SELECT * FROM `test`';
		$this->assertEquals($test, $result);


		//error test
		$query = [
			'select' => 'NotExistingColumn',
			'from' => 'test',
			'limit' => 1
		];
		$result = $db->get($query);
		$this->assertFalse($result);

//		print_r($db->getDebug());
	}


	public function testFn_Update(): void
	{
		$db = new AviDb();
		$this->assertIsObject($db);
		$this->assertTrue($db->isOpen());

		$decimal = floatval(random_int(0, 255) / 100);

		$query = [];
		$result = $db->set($query);
		$test = '';
		$this->assertEquals($test, $result);

		$query = [
			'update' => 'test'
		];
		$result = $db->set($query);
		$test = '';
		$this->assertEquals($test, $result);

		$query=[
			'update' => ['test'],
			'values' => [
				'col_decimal' => $decimal
			]
		];
		$test = true;
		$result = $db->update($query);
		$this->assertEquals($test, $result);

		$query=[
			'update' => ['test'],
			'set' => "`col_decimal`=".$db->parseVar($decimal, 'num'),
			'where' => [
				"`id`=7"
			]
		];
		$test = true;
		$result = $db->update($query);
		$this->assertEquals($test, $result);
	}


	public function testFn_Delete(): void
	{
		$db = new AviDb();
		$this->assertIsObject($db);
		$this->assertTrue($db->isOpen());

		$nr = random_int(0, 9);

		$query = [];
		$result = $db->del($query);
		$test = '';
		$this->assertEquals($test, $result);

		$query = [
			'delete' => 'test'
		];
		$result = $db->parse($query, 'delete');
		$test = 'TRUNCATE TABLE `test`';
		$this->assertEquals($test, $result);

		$query = [
			'delete' => 'test',
			'where' => [
				"`id`>1"
			]
		];
		$test = true;
		$result = $db->delete($query);
		$this->assertEquals($test, $result);
	}


	public function testFn_Parse() : void
	{
		$db = new AviDb();
		$this->assertIsObject($db);
		$this->assertTrue($db->isOpen());


		$nr = random_int(0, 9);

		//raw = no parse
		$this->assertEquals($nr, $db->parseVar($nr, 'raw'));

		//numeric test
		$test = 0;
		$result = $db->parseVar(0, '?int');
		$this->assertEquals($test, $result);

		$test = 0;
		$result = $db->parseVar('0', '?int');
		$this->assertEquals($test, $result);

		$test = 'NULL';
		$result = $db->parseVar('', '?int');
		$this->assertEquals($test, $result);

		$test = 'NULL';
		$result = $db->parseVar(null, '?int');
		$this->assertEquals($test, $result);

		$test = 'NULL';
		$result = $db->parseVar(false, '?int');
		$this->assertEquals($test, $result);

		$test = 'NULL';
		$result = $db->parseVar('NULL', '?int');
		$this->assertEquals($test, $result);

		$test = 65536;
		$result = $db->parseVar('65536', '?int');
		$this->assertEquals($test, $result);

		$test = 0.123;
		$result = $db->parseVar(0.123, 'num');
		$this->assertEquals($test, $result);

		$test = 0.123;
		$result = $db->parseVar(0.123, '?num');
		$this->assertEquals($test, $result);

		$test = 0.123;
		$result = $db->parseVar('0.123', 'num');
		$this->assertEquals($test, $result);


		$result = $db->parseVar(null, '?str');
		$test = 'NULL';
		$this->assertEquals($test, $result);

		$result = $db->parseVar('', 'str');
		$test = '';
		$this->assertEquals($test, $result);

		$result = $db->parseVar('', '?str_0');
		$test = 'NULL';
		$this->assertEquals($test, $result);

		$result = $db->parseVar('123', 'ip');
		$test = 'NULL';
		$this->assertEquals($test, $result);

		$result = $db->parseVar('123.45.67.89', 'ip');
		$test = "INET_ATON('123.45.67.89')";
		$this->assertEquals($test, $result);

		$test = 'abc';
		$result = $db->parseVar($test, 'xyz');
		$this->assertEquals($test, $result);

		$test = 'SELECT * FROM `table`';
		$query = [
			'from' => 'table'
		];
		$result = $db->parse($query);
		$this->assertEquals($test, $result);

		$query = [
			'insert' => 'table',
			'values' => '1,2,3'
		];
		$result = $db->parse($query);
		$test = '';
		$this->assertEquals($test, $result);

		$query['columns'] = 'a,b,c';
		$result = $db->parse($query, 'insert');
		$test='INSERT INTO `table` (`a`,`b`,`c`) VALUES(1,2,3)';
		$this->assertEquals($test, $result);


		$query = [
			'insert' => 'test',
			'values' => [
				'abc' => '{x}'
			]
		];
		$result = $db->parse($query, 'insert', ['x' => $nr]);
		$test = sprintf("INSERT INTO `test` (`abc`) VALUES(%s)", $nr);
		$this->assertEquals($test, $result);

		$test = $test;
		$result = $db->parse($test, 'sql');
		$this->assertEquals($test, $result);

		$query=[
			'from' => [
				"`test`",
				"JOIN `join`"
			],
			'where' => [
				"`id`=0"
			],
			'group' => [
				'test.id',
				'join.name'
			],
			'having' => [
				'SUM(`id`)>0'
			],
			'order' => [
				'`id` DESC',
				'`name` ASC'
			],
			'limit' => [
				0,
				100
			]
		];
		$result = $db->parse($query, 'select');
		$test = 'SELECT * FROM `test` JOIN `join` WHERE (`id`=0) GROUP BY `test`.`id`,`join`.`name` HAVING SUM(`id`)>0 ORDER BY `id` DESC,`name` ASC LIMIT (0,100)';
		$this->assertEquals($test, $result);
	}


	public function testFn_Debug()
	{
		global $_AviDb;
		$db = $_AviDb ?? new AviDb();
		$this->assertIsObject($db);
		$this->assertTrue($db->isOpen());
		$this->assertIsArray($db->getDebug());

		//print_r($db->getDebug());
	}
}