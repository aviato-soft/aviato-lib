<?php
/**
 * Copyright 2014-present Aviato Soft.
 * All Rights Reserved.
 */
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
// require_once dirname(__FILE__) . '/../src/Log.php';

use PHPUnit\Framework\TestCase;
use Avi\Log as AviLog;

final class testAviatoLog extends TestCase
{


	public function testFn_Construct(): void
	{
		$aviLog = new AviLog();
		$this->assertIsObject($aviLog);
		$this->assertTrue(property_exists($aviLog, 'path'));
//the path:
		$test = realpath(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'src').DIRECTORY_SEPARATOR.'logs';
		$result = $aviLog->path;
		$this->assertEquals($result, $test);

		define('AVI_LOG_PATH', '/');
		$aviLog = new AviLog();
		$this->assertIsObject($aviLog);
		$this->assertTrue(property_exists($aviLog, 'path'));
		$test = AVI_LOG_PATH;
		$result = $aviLog->path;
		$this->assertEquals($result, $test);


		$path = dirname(__FILE__).DIRECTORY_SEPARATOR.'logs';
		// calling construct with properties will test also private setProperties method:
		$aviLog = new AviLog([
			'path' => $path,
			'test' => 'Aviato'
		]);
		$result = $aviLog->path;
		$test = $path;
		$this->assertEquals($result, $test);
	}


	public function testFn_setProperties(): void
	{
		$aviLog = new AviLog(null);
		$test = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'logs';
		$result = $aviLog->path;
//		var_dump($result.PHP_EOL.$test.PHP_EOL); // <-- uncomment this line to see the result!
		$this->assertEquals($result, $test);
	}


	public function testFn_Trace(): void
	{
		$aviLog = new AviLog(
			[
				'path' => dirname(__FILE__).DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'tmp'
			]);
		// test assertion for normal usage
		$message = "Test from Aviato Soft";
		$result = NULL;

		// test message only - default = info;
		$test = $aviLog->trace($message);
		$this->assertEquals($result, $test);
		$result = file_exists($aviLog->path.DIRECTORY_SEPARATOR.'info_'.date('Ymd').'.log');
		$test = true;
		$this->assertEquals($result, $test);

		$logTypes = [
			[
				'id' => 22,
				'prefix' => 'unknonw_'
			],
			[
				'id' => LOG_ALERT,
				'prefix' => 'alert_'
			],
			[
				'id' => LOG_CRIT,
				'prefix' => 'crit_'
			],
			[
				'id' => LOG_DEBUG,
				'prefix' => 'debug_'
			],
			[
				'id' => LOG_ERR,
				'prefix' => 'err_'
			],
			[
				'id' => LOG_EMERG,
				'prefix' => 'emerg_'
			],
			[
				'id' => LOG_INFO,
				'prefix' => 'info_'
			],
			[
				'id' => LOG_NOTICE,
				'prefix' => 'notice_'
			],
			[
				'id' => LOG_WARNING,
				'prefix' => 'warning_'
			],
		];

		// multiple test log to system & alert:
		$aviLog->toSystem = true;
		foreach ($logTypes as $logType) {
			$test = $aviLog->trace($message, $logType['id']);
			$result = file_exists($aviLog->path.DIRECTORY_SEPARATOR.$logType['prefix'].date('Ymd').'.log');
			$this->assertTrue($result);
		}

		$_SERVER['REMOTE_ADDR'] = '0.0.0.0';
		$_SERVER['HTTP_X_FORWARDED_FOR'] = '0.0.0.0';
		$_SERVER['HTTP_CLIENT_IP'] = '0.0.0.0';
		$_SERVER['HTTP_USER_AGENT'] = 'eclipse browser';

		// test random path:
		$rndDir = str_shuffle('aviato-soft');
		$aviLog->path = $aviLog->path.DIRECTORY_SEPARATOR.$rndDir;
		$test = $aviLog->trace([
			$message
		], 22);
		$result = file_exists($aviLog->path.DIRECTORY_SEPARATOR.'unknonw_'.date('Ymd').'.log');
		$test = true;
		$this->assertEquals($result, $test);

		// clear the garbage:
		if ($result) {
			unlink($aviLog->path.DIRECTORY_SEPARATOR.'unknonw_'.date('Ymd').'.log');
			rmdir($aviLog->path);
		}
		array_map('unlink', glob($aviLog->path.DIRECTORY_SEPARATOR.'*_'.date('Ymd').'.log'));

	// var_dump($test); // <-- uncomment this line to see the result!
	}
}
