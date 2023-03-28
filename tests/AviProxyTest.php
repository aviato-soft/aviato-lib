<?php
namespace Avi;

require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Avi\Response as AviResponse;
use Psr\Log\Test\TestLogger;

final class testAviatoProxy extends TestCase
{
	public function __construct()
	{
		$filter = new Filter();
		$action = json_decode($filter->get('action'), true);
		//print_r($action);die(); //--uncomment this line for debug

		switch ($action['call'][0]) {
			case 'test-Response_Get':
				require_once dirname(__FILE__).'/assets/Sections.php';
				require_once dirname(__FILE__).'/assets/AviResponseTest.php';

				$response = new Response('section');
				$result = json_decode($response->get(), true);
				$result = $result['data'];
				break;

			default:
				$className = sprintf('%s\%s',__NAMESPACE__,$action['call'][0]);
				$call = new $className();
				$fn = $action['call'][1];
				$args = $action['args'];

				$result =  call_user_func_array([$call, $fn], $args);
				break;
		}

		echo $result;
	}
}

$o = new testAviatoProxy();
