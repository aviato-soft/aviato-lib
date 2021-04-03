<?php
require_once dirname(__FILE__) . '/../../vendor/autoload.php';

use Avi\Response as AviResponse;

/**
 * Test purpose class
 *
 * @author aviato-vasile
 *
 */
class AviResponseTest extends AviResponse
{


	public function call()
	{
		$fns = [
			1,
			2,
			3
		];
		if (! isset($_REQUEST['fn']) || ! in_array($_REQUEST['fn'], $fns)) {
			return false;
		}

		if ($_REQUEST['fn'] === 1) {
			$this->fn1();
		} else if ($_REQUEST['fn'] === 2) {
			$this->fn2();
		} else if ($_REQUEST['fn'] === 3) {
			$this->fn3();
		}

		return true;
	}


	/**
	 * Required only on testing
	 */
	public function getType()
	{
		$this->data['type'] = $this->type;
	}


	/**
	 * Test call for array response
	 */
	private function fn1()
	{
		$this->data = [
			'test data'
		];
	}


	/**
	 * Test call for html response
	 */
	private function fn2()
	{
		$this->data = '<div>Test Data</div>';
	}


	/**
	 * Test object call
	 */
	private function fn3()
	{
		$this->data = [
			1 => 'one',
			'2' => 'two'
		];
	}


	public function fnUpload()
	{
		//do something with: $_FILES;

		$this->log('Upload complete');
	}


	/**
	 * Test purpose function
	 * @param int $id
	 */
	public function testLogMessages($id) {
		$this -> logMessage($id);
		return $id;
	}
}
?>
