<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 00.05.01
 * @since 2021-07-21 09:04:07
 *
 */
declare(strict_types = 1);
namespace Avi;

use voku\helper\AntiXSS;

/**
 * Filter class
 * @author aviato-vasile
 *
 */
class Filter
{

	private $type;

	private $definition;


/**
 *
 * @param int $type is one of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV
 * @param array $definition is an array of filtering definitions
 */
	public function __construct(int $type, array $definition)
	{
		if (! in_array($type, [
			INPUT_GET,
			INPUT_POST,
			INPUT_COOKIE,
			INPUT_SERVER,
			INPUT_ENV
		])) {
			return false;
		}
		$this->type = $type;
		$this->definition = $definition;
	}


/**
 * Simple wrapper for filter_input_array
 * @param bool $add_empty
 * @return mixed filtered array
 */
	private function validate_input(bool $add_empty = null)
	{
		return filter_input_array($this->type, $this->definition['validate'], $add_empty);
	}


/**
 *
 * @param array $var
 * @return array filtered var by antixss
 */
	private function validate_antixss(array $var)
	{
		$result = [];
		$antiXss = new AntiXSS();
		foreach ($var as $k => $v) {
			$result[$k] = $antiXss->xss_clean($v);
		}

		return $result;
	}


/**
 * /**
 * Wrapper for finlter_var_array
 */
 * @param int $var
 * @param bool $add_empty
 * @return mixed
 */
	private function sanitize_input(int $var, bool $add_empty = null)
	{
		return filter_var_array($var, $this->definition['sanitize'], $add_empty);
	}


	public function funnel($add_empty = null)
	{
		$result = $this->validate_input($add_empty);
		$result = $this->validate_antixss($result);
		$result = $this->sanitize_input($result, $add_empty);

		return $result;
	}
}

?>