<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 00.04.07
 * @since  2021-04-27 09:26:50
 *
 */
declare(strict_types = 1);
namespace Avi;

/**
 * Log class
 *
 * @author aviato-vasile
 *
 */
class Log
{

	public $path;

	public $message;

	public $priority = LOG_INFO;

	public $serverInfo = true;

	public $toFile = true;

	public $toSystem = false;


	public function __construct($options = [])
	{
		if ($options === []) {
			$options = array(
				'path' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logs'
			);
		}
		$this->setProperties($options);
	}


	/**
	 * Default method to set properties
	 *
	 * @param array $options
	 */
	private function setProperties($options = null)
	{
		if ($options === null || $options === []) {
			return false;
		}

		$classVars = array_keys(get_class_vars(get_class($this)));

		foreach ($classVars as $key) {
			if (isset($options[$key])) {
				$this->{$key} = $options[$key];
			}
		}
	}


	/**
	 * Format the message
	 *
	 * @param
	 *        	unknown(string | array) $message
	 */
	protected function format($message, $header = false)
	{
		$messageHeader = '>>' . date("Y-m-d H:i:s") . ' - ';

		if ($header) {
			if ($this->serverInfo) {
				// remote address
				if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
					$messageHeader .= $_SERVER['REMOTE_ADDR'];
				}
				$messageHeader .= '|';
				if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
					$messageHeader .= $_SERVER['HTTP_X_FORWARDED_FOR'];
				}
				$messageHeader .= '|';
				if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
					$messageHeader .= $_SERVER['HTTP_CLIENT_IP'];
				}
				$messageHeader .= ' - ';
				if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
					$messageHeader .= $_SERVER['HTTP_USER_AGENT'];
				}
				$messageHeader .= PHP_EOL . '>';
			}

			$backtrace = debug_backtrace();

			$messageHeader .= 'file:' . $backtrace[1]['file'] . ' ' . 'at line:' . $backtrace[1]['line'] . ' ' . PHP_EOL .
				'[class]' . $backtrace[2]['class'] . $backtrace[2]['type'] . $backtrace[2]['function'] . '{' .
				print_r($backtrace[2]['args'], true) . '}' . PHP_EOL;
		}

		if (is_array($message)) {
			$this->message = print_r($message, true);
		} else {
			$this->message = $message;
		}

		$this->message = $messageHeader . $this->message . PHP_EOL . '----------' . PHP_EOL . PHP_EOL;
	}


	/**
	 * Output log to file &/| system
	 *
	 * @param string $message
	 */
	public function trace($message, $priority = false, $header = true)
	{
		if ($priority !== false) {
			$oldPriority = $this->priority;
			$this->priority = $priority;
		}
		$this->format($message, $header);

		if ($this->toFile) {
			$this->toFile();
		}

		if ($this->toSystem) {
			$this->toSystem();
		}

		if ($priority !== false) {
			$this->priority = $oldPriority;
		}
	}


	/**
	 * Output log to file
	 */
	protected function toFile()
	{
		$fileName = '';
		switch ($this->priority) {
			case LOG_EMERG: // system is unusable
				$fileName .= 'emerg_';
				break;
			case LOG_ALERT: // action must be taken immediately
				$fileName .= 'alert_';
				break;
			case LOG_CRIT: // critical conditions
				$fileName .= 'crit_';
				break;
			case LOG_ERR: // error conditions
				$fileName .= 'err_';
				break;
			case LOG_WARNING: // warning conditions
				$fileName .= 'warning_';
				break;
			case LOG_NOTICE: // normal, but significant, condition
				$fileName .= 'notice_';
				break;
			case LOG_INFO: // informational message
				$fileName .= 'info_';
				break;
			case LOG_DEBUG: // debug-level message
				$fileName .= 'debug_';
				break;
			default:
				$fileName .= 'unknonw_';
				break;
		}

		$fileName = $this->path . DIRECTORY_SEPARATOR . $fileName . date('Ymd') . '.log'; // one log file per day

		if (! file_exists($this->path)) {
			mkdir($this->path, 0777, true);
		}

		@file_put_contents($fileName, $this->message, FILE_APPEND | LOCK_EX);
	}


	/**
	 * Output log to system
	 */
	protected function toSystem()
	{
		syslog($this->priority, $this->message);
	}
}