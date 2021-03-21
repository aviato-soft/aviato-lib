<?php

declare(strict_types=1);

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
	 * @return array with default values
	 * @param $attributes array
	 * @param $defaultAttributes array
	 */
	public function applyDefault($attributes, $defaultAttributes)
	{
		if (!is_array($attributes) || !is_array($defaultAttributes)) {
			return false;
		}

		foreach ($defaultAttributes as $k => $v) {
			if(!array_key_exists($k, $attributes)) {
				$attributes[$k] = $v;
			}
		}
		return($attributes);
	}
}