<?php
declare(strict_types = 1);
namespace Avi;

/**
 * Tools class.
 *
 * @author aviato-vasile
 */
class Tools
{


	/**
	 * Apply default values to the array,
	 * mainly used for arrays which can't have specific default values defined
	 *
	 * @return array with default values
	 * @param $attributes array
	 * @param $defaultAttributes array
	 */
	public function applyDefault($attributes, $defaultAttributes)
	{
		if (! is_array($attributes) || ! is_array($defaultAttributes)) {
			return false;
		}

		foreach ($defaultAttributes as $k => $v) {
			if (! array_key_exists($k, $attributes)) {
				$attributes[$k] = $v;
			}
		}
		return ($attributes);
	}


	/**
	 *
	 * @return string Return a string produced according to the pattern by replaceing {*} with array member
	 * @param string $pattern
	 * @param array $array
	 *
	 * @example | str_suplant('<div id="{id}">{text}</div>', array('id' => 1, 'text' => 'aviato'))
	 *          | will return: <div id="1">aviato</div>
	 */
	public function str_supplant($pattern, $array)
	{
		foreach ($array as $k => $v) {
			$pattern = str_replace(sprintf('{%s}', $k), $v, $pattern);
		}
		return $pattern;
	}


	/**
	 * Alias of str_supplant easy to remember sprinta
	 *
	 * @param string $pattern
	 * @param array $array
	 * @return string
	 */
	public function sprinta($pattern, $array)
	{
		return self::str_supplant($pattern, $array);
	}
}