<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 00.22.23
 * @since  2022-08-16 20:48:29
 *
 */
declare(strict_types = 1);
namespace Avi;

use Avi\Tools as AviTools;

/**
 * Tracker class
 *
 * @author aviato-vasile
 */
class Tracker
{
	private $cookie;
	private $pattern;

	protected $params;


	/**
	 *
	 * @param $patternFileLocation string location of the tracker pattern
	 * @param $params array format key => value of parameters to be replaced on pattern
	 * @param $cookie string optional specify the gdpr service cookie
	 */
	public function __construct(string $patternFileLocation, array $params, string $cookie = '')
	{
		$this->params = $params;
		$this->pattern = file_get_contents($patternFileLocation);
		$this -> cookie = $cookie;
	}


	/**
	 * Replace pattern variables with params values
	 */
	public function parse()
	{
		if ($this -> cookie !== '' && !AviTools::isGdprSet($this -> cookie)) {
			return '';
		}

		return str_replace(array_keys($this->params), array_values($this->params), $this->pattern);
	}


	/**
	 * Output the result
	 */
	public function dispatch()
	{
		echo $this->parse();
	}
}
?>