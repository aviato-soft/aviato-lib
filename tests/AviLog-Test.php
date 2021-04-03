<?php
/**     .___
 * /\\///\|0
 */
declare(strict_types = 1);

require_once dirname(__FILE__) . '/../vendor/autoload.php';
//require_once dirname(__FILE__) . '/../src/Log.php';

use PHPUnit\Framework\TestCase;
use Avi\Log as AviLog;

final class testAviatoLog extends TestCase
{
	public function testFn_Construct(): void
	{
		$aviLog = new AviLog();

		$test = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../src');
		$test .= DIRECTORY_SEPARATOR . 'logs';
		$result = $aviLog -> path;
		$this -> assertEquals($result, $test);
//		var_dump($test);
//		var_dump($result);

		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logs';
		//calling construct with properties will test also private setProperties method:
		$aviLog = new AviLog([
			'path' => $path,
			'test' => 'Aviato'
		]);
		$result = $aviLog -> path;
		$test = $path;
		$this -> assertEquals($result, $test);

	}


	public function testFn_setProperties(): void
	{
		$aviLog = new AviLog(null);
		$test = '';
		$result = $aviLog -> path;
		$this -> assertEquals($result, $test);
	}


	public function testFn_Trace(): void
	{
		$aviLog = new AviLog([
			'path' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'tmp'
		]);
		// test assertion for normal usage
		$message = "Test from Aviato Soft";
		$result = NULL;

		//test message only - default = info;
		$test = $aviLog -> trace($message);
		$this -> assertEquals($result, $test);
		$result = file_exists($aviLog -> path . DIRECTORY_SEPARATOR . 'info_' . date('Ymd') .'.log');
		$test = true;
		$this -> assertEquals($result, $test);

		//test log to system & alert:
		$aviLog -> toSystem = true;
		$test = $aviLog -> trace($message, LOG_ALERT);
		$result = file_exists($aviLog -> path . DIRECTORY_SEPARATOR . 'alert_' . date('Ymd') .'.log');
		$test = true;
		$this -> assertEquals($result, $test);

		//test priority
		$aviLog -> toSystem = false;
		$test = $aviLog -> trace($message, LOG_ERR);
		$result = file_exists($aviLog -> path . DIRECTORY_SEPARATOR . 'err_' . date('Ymd') .'.log');
		$test = true;
		$this -> assertEquals($result, $test);

		//test priority
		$test = $aviLog -> trace($message, LOG_EMERG);
		$result = file_exists($aviLog -> path . DIRECTORY_SEPARATOR . 'emerg_' . date('Ymd') .'.log');
		$test = true;
		$this -> assertEquals($result, $test);

		//test priority
		$test = $aviLog -> trace($message, LOG_WARNING);
		$result = file_exists($aviLog -> path . DIRECTORY_SEPARATOR . 'warning_' . date('Ymd') .'.log');
		$test = true;
		$this -> assertEquals($result, $test);

		//test priority
		$test = $aviLog -> trace($message, LOG_NOTICE);
		$result = file_exists($aviLog -> path . DIRECTORY_SEPARATOR . 'notice_' . date('Ymd') .'.log');
		$test = true;
		$this -> assertEquals($result, $test);

		//test priority
		$test = $aviLog -> trace($message, LOG_CRIT);
		$result = file_exists($aviLog -> path . DIRECTORY_SEPARATOR . 'crit_' . date('Ymd') .'.log');
		$test = true;
		$this -> assertEquals($result, $test);

		//test priority
		$test = $aviLog -> trace([$message], 22);
		$result = file_exists($aviLog -> path . DIRECTORY_SEPARATOR . 'unknonw_' . date('Ymd') .'.log');
		$test = true;
		$this -> assertEquals($result, $test);

		//test random path:
		$rndDir = str_shuffle('aviato-soft');
		$aviLog -> path = $aviLog -> path . DIRECTORY_SEPARATOR . $rndDir;
		$test = $aviLog -> trace([$message], 22);
		$result = file_exists($aviLog -> path . DIRECTORY_SEPARATOR . 'unknonw_' . date('Ymd') .'.log');
		$test = true;
		$this -> assertEquals($result, $test);

		//clear the garbage:
		if($result) {
			unlink($aviLog -> path . DIRECTORY_SEPARATOR . 'unknonw_' . date('Ymd') .'.log');
			rmdir($aviLog -> path);
		}
		array_map('unlink', glob($aviLog -> path . DIRECTORY_SEPARATOR . '*_' . date('Ymd') .'.log'));





//		var_dump($test); // <-- uncomment this line to see the result!
	}

}
