<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.19
 * @since  2023-11-12 08:07:20
 *
 */
declare(strict_types = 1);
namespace Avi;

use Avi\Filter;

/**
 * Response class.
 *
 * @author aviato-vasile
 */
class Response
{

	public $action;

	public $data;

	public $success;

	public $location = null;

	private $default = [];

	private $defines = [
		'action' => [
			'call',
			'section',
			'upload'
		],
		'types' => [
			'array',
			'html',
			'json'
		],
		'logs' => [
			'danger',
			'debug',
			'error',
			'info',
			'primary',
			'success',
			'warning'
		],
		'messages' => [
			// 100..199 - errors:
			100 => 'Undefined action!',

			// 200..299 - warnings:
			200 => 'Missing action!',
			201 => 'Empty response!',
			202 => 'Missing Upload Handler!',
			203 => 'Missing Upload Handler object definition!',
			222 => 'Missing Definition for this message id!'

			// 300..899 - debug:

			// 900..999 - custom:
		]
	];

	protected $type;

	private $log;

	private $filter;

	private $options;


	/**
	 * The Constructor
	 *
	 * @param string $action
	 *        	= the action to do...
	 * @param string $param
	 *        	= the parameter to request in case of action is missing, default value = 'action'
	 */
	public function __construct($action = null, $param = 'action')
	{
		$this->filter = new \Avi\Filter();

		if ($action === null) {
			$this->action = $this->filter->request($param);
		} else {
			$this->action = $action;
		}

		$this->default['types'] = $this->defines['types'][2]; // json
		$this->default['log'] = $this->defines['logs'][3]; // info

		$this->data = [];
		$this->log = [];
		$this->type = $this->default['types'];
		$this->success = null;
	}


	/**
	 * Define/Return the response action
	 *
	 * @param string $action
	 */
	public function action($action = null)
	{
		if ($action !== null) {
			$this->action = $action;

			// remove no action message from log:
			$this->removeLogByMessageId(100);
		}

		return ($this->action);
	}


	/**
	 * Return the response
	 *
	 * @return mixed array json formated
	 */
	public function get($clearLogAfterCall = true)
	{
		// get content based on action:
		switch ($this->action) {
			case 'call':
				if(method_exists($this, 'call')) {
					$this->call();
				}
				break;

			case 'section':
				$page = new UI([
					'response' => &$this
				]);
				$attrSection = [];
				$this->data['params'] = $this->data['params'] ?? $this->filter->request('params');
				if(is_string($this->data['params'])) {
					$attrSection['params'] = explode(',', $this->data['params']);
				}
				$this->data['section'] = $this->data['section'] ?? $this->filter->request('section');
				$this->data = $page->Section($this->data['section'], $attrSection, true);
				$this->success = true;
				break;

			case 'upload':
				/*
				$this->data['req'] = $this->filter->post('data', [
					'regexp' => "/^[a-zA-Z0-9_-]{3,24}$/i"
				]);
				*/
				$this->data['files'] = $_FILES;
				$this->data['handler'] = $this->data['handler'] ?? $this->filter->post('handler', ['regexp' => "/^[a-zA-Z0-9_-]{3,24}$/i"]);
				if (isset($this->data['handler']) && is_string($this->data['handler'] )) {
					if (method_exists($this, $this->data['handler'])) {
						$this->success = call_user_func([
							$this,
							$this->data['handler']
						]);
					} else {
						$this->logMessage(203);
						$this->success = false;
					}
				} else {
					$this->logMessage(202);
					$this->success = false;
				}
				break;
		}

		// validate response
		$this->validate();

		$response = [
			'action' => $this->action,
			'data' => $this->data,
			'log' => $this->log,
			'success' => $this->success
		];

		if (is_string($this -> location)) {
			$response['location'] = $this -> location;
		}

		if ($clearLogAfterCall) {
			$this->clearLog();
		}

		// formatting response based on response type
		if ($this->type === 'json') {
			$response = json_encode($response);
		}

		return $response;
	}


	/**
	 * Get the data response value
	 *
	 * @param string $key
	 * @return array | NULL
	 */
	public function getData($key = null)
	{
		if ($key === null) {
			$return = $this->data;
		} else {
			if (isset($this->data[$key])) {
				$return = $this->data[$key];
			} else {
				$return = null;
			}
		}
		return $return;
	}


	/**
	 * Add message to log
	 *
	 * @param string $message
	 * @param bool|string $type
	 * @param string $isHtml
	 * @param string $pattern
	 * @param int $id
	 */
	public function log($message, $type = false, $id = 999)
	{
		if (! in_array($type, $this->defines['logs'])) {
			$type = $this->default['log'];
		}

		$this->log[] = array(
			'id' => $id,
			'message' => $message,
			'type' => $type,
			'time' => time()
		);
	}


	/**
	 * Return the result
	 *
	 * @param boolean $success
	 * @param boolean $returnOnly
	 * @return string
	 */
	public function result($success = null, $returnOnly = false)
	{
		if ($success === null) {
			$success = $this->success();
		}

		$result = $this->get();

		if ($returnOnly) {
			return $result;
		}

		switch ($this->type) {
			case 'array':
				print_r($this->data);
				break;

			case 'html':
				echo ($this->data);
				break;

			case 'json':
			default:
				header('Content-type: application/json');
				echo ($result);
				break;
		}

		return $result;
	}


	/**
	 * Set the response type
	 */
	public function type($type = null)
	{
		if (! in_array($type, $this->defines['types'])) {
			$this->type = $this->default['types'];
		} else {
			$this->type = $type;
		}
	}


	/**
	 * Set and get the Success value
	 *
	 * @param boolean $success
	 * @return boolean
	 */
	public function success($success = null)
	{
		if ($success !== null && is_bool($success)) {
			$this->success = $success;
		}

		// because it is forced to be true, logs: error -> warnings
		if ($this->success === true) {
			if ($this->action === null) {
				$this->action = '';
			}
			foreach ($this->log as $k => $v) {
				if ($v['type'] === 'error') {
					$this->log[$k]['type'] = 'warning';
				}
			}
			$this->response['log'] = $this->log;
		}

		return $this->success;
	}


	/**
	 * Clear the log - usefull in case of multiple object calls.
	 * @return void
	 */
	private function clearLog()
	{
		$this->log = [];
	}


	/**
	 * Perform a log clean up, by deleting duplicates and ordering messages
	 *
	 * @return void
	 */
	private function cleanupLog()
	{
		// resort the log
		$this->log = array_values($this->log);

		// remove log duplicates
		$iMax = is_countable($this->log)?count($this->log):0;
		for ($i = 0; $i < $iMax; $i ++) {
			if (isset($this->log[$i])) {
				if (is_array($this->log[$i]) && isset($this->log[$i]['id']) && $this->log[$i]['id'] !== 999) {
					for ($j = $i + 1; $j < $iMax; $j ++) {
						if (isset($this->log[$j])) {
							if (is_array($this->log[$j]) && isset($this->log[$j]['id']) && $this->log[$i]['id'] === $this->log[$j]['id']) {
								unset($this->log[$j]);
							}
						}
					}
				}
			}
		}

		// resort the log
		$this->log = array_values($this->log);
	}


	/**
	 * Return the message text corresponding with message id
	 *
	 * @param integer $messageId
	 * @return string
	 */
	private function getMessage($messageId = 222)
	{
		if (isset($this->defines['messages'][$messageId])) {
			return $this->defines['messages'][$messageId];
		} else {
			return $this->defines['messages'][222];
		}
	}


	/**
	 * Generate a log from a message id
	 *
	 * @param integer $messageId
	 */
	protected function logMessage($messageId)
	{
		// get type:
		if ($messageId < 200) {
			$type = 'error';
		} else if ($messageId >= 200 && $messageId < 300) {
			$type = 'warning';
		} else if ($messageId >= 300) {
			$type = 'info';
		}

		// get message:
		$message = $this->getMessage($messageId);

		$this->log($message, $type, $messageId);
	}


	/**
	 * Remove log message by it's ID
	 *
	 * @param integer $messageId
	 */
	private function removeLogByMessageId($messageId)
	{
		foreach ($this->log as $k => $v) {
			if ($messageId === $v['id']) {
				unset($this->log[$k]);
			}
		}
	}


	/**
	 * Validate response object and create log message based on that
	 *
	 * @return boolean
	 */
	private function validate()
	{
		// raise error on missing action:
		$this->validityLog(($this->action === null), 100);

		// raise warning on empty action:
		$this->validityLog(($this->action === ''), 200);

		// raise warning in case of empty data:
		$this->validityLog(($this->data === []), 201);

		// check if we have at least one error and set success as false in this case:
		foreach ($this->log as $v) {
			if ($v['id'] < 200) {
				$this->success = false;
				break;
			}
		}

		$this->cleanupLog();

		return $this->success;
	}


	/**
	 * Add or remove log on specified condition
	 *
	 * @param boolean $condition
	 * @param integer $logId
	 */
	private function validityLog($condition, $logId)
	{
		if ($condition) {
			$this->logMessage($logId);
		} else {
			$this->removeLogByMessageId($logId);
		}
	}
}
