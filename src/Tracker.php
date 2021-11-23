<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 00.06.06
 * @since  2021-10-15 12:12:24
 *
 */
declare(strict_types = 1);
namespace Avi;

/**
 * Tracker class
 *
 * @author aviato-vasile
 */

class Tracker {
	private $pattern;
	protected $params;

/**
 * @param = array key => value of parameters to be replaced on pattern
 */
	public function __construct(array $params) {
		$this -> params = $params;
	}

/**
 * Get the pattern content from file
 */
	public function setPattern($fileLocation)
	{
		$this -> pattern = file_get_contents($fileLocation);
	}


/**
 * Replace pattern variables with params values
 */
	protected function parse()
	{
		return str_replace(
			array_keys($this -> params),
			array_values($this -> params),
			$this -> pattern
		);
	}


	public function dispatch()
	{
		echo $this -> parse();
	}
}
?>