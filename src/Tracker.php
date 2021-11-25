<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 00.07.00
 * @since  2021-11-25 16:36:14
 *
 */
declare(strict_types = 1);
namespace Avi;

/**
 * Tracker class
 *
 * @author aviato-vasile
 */
class Tracker
{

	private $pattern;

	protected $params;


	/**
	 *
	 * @param $patternFileLocation string location of the tracker pattern
	 * @param $params array format key => value of parameters to be replaced on pattern
	 */
	public function __construct(string $PatternFileLocation, array $Params)
	{
		$this->params = $Params;
		$this->pattern = file_get_contents($PatternFileLocation);
	}


	/**
	 * Replace pattern variables with params values
	 */
	public function parse()
	{
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