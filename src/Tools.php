<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.11
 * @since  2024-06-26 13:20:45
 *
 */
declare(strict_types = 1);
namespace Avi;

use phpDocumentor\Reflection\Types\Boolean;

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
	 * @return bool|array with default values
	 * @param $attributes array
	 * @param $defaultAttributes array
	 */
	public static function applyDefault($attributes, $defaultAttributes)
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
	 * Set an array item to a given value using "dot" notation or other separator.
	 *
	 * If no key is given to the method, the entire array will be replaced.
	 *
	 * @param  array  $array
	 * @param  string|int|null  $key
	 * @param  mixed  $value
	 * @param  string $separator
	 * @return array
	 * extended method of laravel/framework/src/Illuminate/Collections/Arr.php
	 */
	public static function array_set(&$array, $key, $value, $separator = '.')
	{
		if (is_null($key)) {
			return $array = $value;
		}

		$keys = explode($separator, $key);

		foreach ($keys as $i => $key) {
			if (count($keys) === 1) {
				break;
			}

			unset($keys[$i]);

			// If the key doesn't exist at this depth, we will just create an empty array
			// to hold the next value, allowing us to create the arrays to hold final
			// values at the correct depth. Then we'll keep digging into the array.
			if (! isset($array[$key]) || ! is_array($array[$key])) {
				$array[$key] = [];
			}

			$array = &$array[$key];
		}

		$array[array_shift($keys)] = $value;

		return $array;
	}
	/**
	 *
	 * @return string Return a string produced according to the pattern by replaceing {*} with array member
	 * @param string $pattern
	 * @param array $array
	 *
	 * @example | str_suplant('<div id="{id}">{text}</div>', ['id' => 1, 'text' => 'aviato'])
	 *          | will return: <div id="1">aviato</div>
	 */
	public static function str_supplant($pattern, $array)
	{
		foreach ($array as $k => $v) {
			if (is_string($v) || is_numeric($v) || is_null($v)) {
				$pattern = str_replace(sprintf('{%s}', $k), (string) ($v ?? ''), $pattern);
			}
		}
		return $pattern;
	}


	/**
	 *
	 * @param string $string to be check
	 * @param string $start the start limit
	 * @param string $end the end limit
	 * @return boolean if string is enclosed in start ... end
	 */
	public static function isEnclosedIn(string $string, string $start = '<', string $end = '>') {
		$lStart = strlen($start);
		$lEnd = strlen($end);
		return (substr($string, 0, $lStart) === $start && substr($string, -$lEnd, $lEnd) === $end);
	}

/**
 * Generate a random string
 * @param int $length - the length of the needed string
 * @param string $chr - the set of characters used for generating the string
 * @return string
 */
	public static function str_random(
		int $length = 20,
		string $chr = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ '
	): string
	{
		$chrlen = strlen($chr);
		$result = [];
		for($i = 0; $i < $length; $i++) {
			$result[] = $chr[random_int(0, $chrlen - 1)];
		}
		return implode('', $result);
	}

	/**
	 * Alias of str_supplant easy to remember sprinta
	 *
	 * @param string $pattern
	 * @param array $array
	 * @return string
	 */
	public static function sprinta($pattern, $array)
	{
		return self::str_supplant($pattern, $array);
	}


	/**
	 * As sprinta, with optional dispatch
	 *
	 * @param string $pattern
	 * @param array $array
	 * @param boolean $returnOnly, (default = false, will echo result)
	 * @return string
	 */
	public static function printa($pattern, $array, $returnOnly = false)
	{
		$result = self::sprinta($pattern, $array);
		if (! $returnOnly) {
			echo $result;
		}
		return $result;
	}


	/**
	 * Aplay sprinta to a 2 dimensional array
	 *
	 * @param string $pattern
	 * @param array $array
	 */
	public static function sprintaa($pattern, $array)
	{
		$result = '';
		foreach ($array as $k => $v) {
			if (! isset($v['index'])) {
				$v['index'] = $k;
			}
			$result .= self::sprinta($pattern, $v, true);
		}
		return $result;
	}


	/**
	 * As sprintaa with optional output dispatch
	 *
	 * @param string $pattern
	 * @param array $array
	 * @param boolean $returnOnly, (optional = false result in output the buffer content)
	 * @return string
	 */
	public static function printaa($pattern, $array, $returnOnly = false)
	{
		$result = self::sprintaa($pattern, $array);
		if (! $returnOnly) {
			echo $result;
		}
		return $result;
	}


	/**
	 * atos = Array TO String
	 *
	 * @return string formated using a loop trough $array and apply $pattern
	 * @param $array array - the data to be parsed
	 * @param $pattern string - the template
	 * @param $configuration array - optional parameters
	 *        - isPrintFormat:[true|false] = use sprintf format
	 *        - startTag:[any char] = the start tag default = '{'
	 *        - endTag:[any char] = the start tag default = '}'
	 * @example :
	 *          | @param $array = [
	 *          | 0 => ['id' => 1.0, 'slug' => 'One'],
	 *          | 1 => ['id' => '2', 'slug' => 'Two']
	 *          | ];
	 *          | @param $pattern = '<p data-id="{id}">{slug}</p>';
	 *          |--> @return '<p data-id="1">One</p><p data-id="2">Two</p>';
	 */
	public static function atos($array, $pattern, $config = [])
	{
		$result = '';

		if (! is_array($array) || count($array) === 0) {
			return $result;
		}

		if (! is_string($pattern)) {
			return $result;
		}

		if (! is_array($config)) {
			$config = [];
		}

		$config = self::applyDefault($config, [
			'startTag' => '{',
			'endTag' => '}',
			'isPrintFormat' => false,
			'htmlentities' => false
		]);

		if (! $config['isPrintFormat']) {
			if (count($array, 0) === count($array, 1) || \is_string(current($array))) {
				$data = [
					0 => $array
				];
			} else {
				$data = $array;
			}
			$keys = array_keys(current($data));
		} else {
			$data = array_values($array);
			if (! isset($config['nrArgs'])) {
				if (count($array, 0) === count($array, 1)) {
					$config['nrArgs'] = 1;
				} else {
					$config['nrArgs'] = count(current($data));
				}
			}
		}

		foreach ($data as $v) {
			if ($config['isPrintFormat']) {
				if (is_array($v)) {
					if (count($v) === $config['nrArgs']) {
						$result .= vsprintf($pattern, $v);
					}
				}
				else {
					if ($config['nrArgs'] === 1) {
						$result .= sprintf($pattern, $v);
					}
				}
			} else {
				$res = $pattern;
				foreach ($keys as $key) {
					if (isset($v[$key])) {
						if (is_integer($v[$key]) || is_double($v[$key])) {
							$v[$key] = (string) $v[$key];
						} else {
							if (is_bool($v[$key])) {
								$v[$key] = $v[$key] ? 'true' : 'false';
							}
						}
						if (!is_string($v[$key])) {
							$value = \gettype($v[$key]);
						}
						else {
							$value = $v[$key];
						}

						if ($config['htmlentities']){
							$res = str_replace(
								$config['startTag'].$config['startTag'].$key.$config['endTag'].$config['endTag'],
								\htmlentities($value, ENT_QUOTES, "UTF-8"),
								$res
							);
						}
						$res = str_replace($config['startTag'].$key.$config['endTag'], $value, $res);
					}
				}
				$result .= $res;
			}
		}

		return ($result);
	}


	/**
	 * KISS function which convert an array to attributes
	 *
	 * @param array $array - the array of values
	 * @param string $prefix - the prefix, need on some specific cases like data- or aria-
	 * @return string - the resutled string of attributes+values concatenated by space.
	 */
	public static function atoattr($array = [], $prefix = '')
	{
		$result = '';
		foreach ($array as $k => $v) {
			$result .= $prefix.$k.'="'.$v.'" ';
		}
		$result = rtrim($result, ' ');
		return $result;
	}


	/**
	 * Perform a filter for a multidimensional array and return only vaues with specific keys
	 * @param array $array = array to be filtered
	 * @param string $key = the key searching for
	 * @return array = filtered array
	 *
	 * @example
	 * array = [
	 * [0 => [id=>1, name=>'orange', isOkay=>true]]
	 * [1 => [id=>2, name=>'apple', isOkay=>false]]
	 * [2 => [id=>3, name=>'pear']]
	 * [3 => [id=>4, name=>'banana', isOkay=>null]]
	 * ]
	 *
	 * filter for key: isOkay,
	 * result = [
	 * [0 => [id=>1, name=>'orange', isOkay=>true]]
	 * [1 => [id=>2, name=>'apple', isOkay=>false]]
	 * [3 => [id=>4, name=>'banana', isOkay=>null]]
	 * ]
	 */
	public static function afilterKeyExists(array $array = [], string $key = ''): array
	{
		return array_filter($array, function($v, $k) use ($key) {;return isset($v[$key]);}, ARRAY_FILTER_USE_BOTH);
	}


	/**
	 * Perform a sorting a list array by refference using specified key
	 * @param array $array the array to be sorted
	 * @param string $key	the key compared for sorting
	 * @param bool $ascending true = sort ascending, false = descending
	 */
	public static function asortByKey(array &$array, string $key, bool $ascending = true): void
	{
		usort($array, function($a, $b) use($key, $ascending) {
			if (is_string($a[$key])) {
				if($ascending) {
					return strcmp($a[$key], $b[$key]);
				} else {
					return (strcmp($a[$key], $b[$key]) === -1) ? 1 : -1;
				}
			} else {
				if($ascending) {
					return ($a[$key] > $b[$key]) ? 1 : -1;
				} else {
					return ($a[$key] > $b[$key]) ? -1 : 1;
				}
			}
		});
	}


	/**
	 * Safety encrypt function
	 *
	 * @credit: https://stackoverflow.com/questions/15194663/encrypt-and-decrypt-md5
	 * @param string $q
	 * @param string $key
	 * @return string
	 *
	 * @see https://linuxconfig.org/how-to-install-mcrypt-php-module-on-ubuntu-18-04-linux for cli
	 */
	public static function enc(string $q, ?string $key = null): string
	{
		if ($key === null) {
			if (defined('AVI_KEY')) {
				$key = AVI_KEY;
			} else {
				$key = 'B1B2B65B5BBBA13CF5EC756CEF5055E6';
			}
		}
		$qEncoded = substr(
			base64_encode(openssl_encrypt($q, 'aes-256-cbc', md5($key), 0, substr(md5(md5($key)), 3, 16))), 0, - 1);
		return ($qEncoded);
	}


	/**
	 * Safety decrypt function
	 *
	 * @param string $q
	 * @param string $key
	 * @return string
	 */
	public static function dec(string $q, ?string $key = null): ?string
	{
		if ($key === null) {
			if (defined('AVI_KEY')) {
				$key = AVI_KEY;
			} else {
				$key = 'B1B2B65B5BBBA13CF5EC756CEF5055E6';
			}
		}
		$qDecoded = openssl_decrypt(base64_decode($q.'='), 'aes-256-cbc', md5($key), 0, substr(md5(md5($key)), 3, 16));
		if ($qDecoded === false) {
			return null;
		}
		return rtrim($qDecoded, "\0");
	}


	/**
	 * Just test ajax Aviato Request/Response rule:
	 * If page has action parameter, it is come from ajax call
	 *
	 * @return boolean
	 */
	public static function isAjaxCall($param = 'action')
	{
		if (isset($_REQUEST[$param])) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Return true if gdpr cookie is enabled for specific service
	 *
	 * @param $service string Service enabled or disabled on $_COOKIE['gdpr']
	 * @example $_COOKIE['gdpr']='["esential","google"]'
	 */
	public static function isGdprSet(string $service)
	{
		if (! isset($_COOKIE['gdpr']) || ! $_COOKIE['gdpr']) {
			return false;
		}

		$gdpr = json_decode($_COOKIE['gdpr']);
		if (! \is_array($gdpr)) {
			return false;
		}

		return (in_array($service, $gdpr, true));
	}


	/**
	 * Simple redirect method (shortcut to header('location: [page]'))
	 *
	 * @param string $page - the page name(url, permalink)
	 * @param string [$extension] - the page extension (default is html)
	 */
	public static function redirect($page = '', $extension = '')
	{
		session_write_close();
		header('Location: /'.$page.$extension, true, 302);
		// exit();
	}


	/**
	 * Short validator for datetime using DateTime native class
	 *
	 * @param string $date - the string to be validated
	 * @param string $format - optional the format of $date
	 * @return boolean - is format valid yes/no
	 *
	 * @author glavic at gmail dot com
	 * @example https://www.php.net/manual/en/function.checkdate.php#113205
	 */
	public static function validateDate(string $date, string $format = 'Y-m-d H:i:s')
	{
		$d = \DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}


	/**
	 * Convert 2 strings representing dates from one format to another
	 *
	 * @param string $date = date to be formated
	 * @param string $format = the format of initial date
	 * @param string $formatResult = the format of the result
	 * @param array $separator = the permited separators
	 * @return bool|string representing the date in new format or false on error
	 *         or false on invalid parameters
	 *
	 *         exampe: Avi\Tools::dtFormatToFormat('2013-09-11', 'y-m-d', 'd/m/y') will return '11/09/2013'
	 */
	public static function dtFormatToFormat($date, $format, $formatResult, $separator = [
		'/',
		'-',
		'.'
	])
	{
		if ($formatResult === $format) {
			return $date;
		}
		$dateSeparator = false;
		$resultDateSeparator = false;

		// get date separator
		foreach ($separator as $v) {
			if (strpos($format, $v) !== false) {
				$dateSeparator = $v;
				break;
			}
		}
		// invalid date separator
		if ($dateSeparator === false) {
			return false;
		}

		// get result date separator
		foreach ($separator as $v) {
			if (strpos($formatResult, $v) !== false) {
				$resultDateSeparator = $v;
				break;
			}
		}
		// invalid result date separator
		if ($resultDateSeparator === false) {
			return false;
		}

		// strings to arrays
		$arDate = [
			explode($dateSeparator, $date),
			explode($dateSeparator, $format)
		];
		$iMax = count($arDate[0]);
		for ($i = 0; $i < $iMax; $i ++) {
			$arDate[2][$arDate[1][$i]] = $arDate[0][$i];
		}
		$arDate = $arDate[2];
		$arNewDate = [
			explode($resultDateSeparator, $formatResult),
			[]
		];
		$iMax = count($arNewDate[0]);
		for ($i = 0; $i < $iMax; $i ++) {
			$arNewDate[1][$i] = $arDate[$arNewDate[0][$i]];
		}

		return (implode($resultDateSeparator, $arNewDate[1]));
	}


	/**
	 * Return an mysql synthax temporary table based on values
	 *
	 * @param string $name - the name of the table
	 * @param array $values - the values of the array
	 * @return string sql
	 *
	 * @example :
	 *          | @param $name = 'test'
	 *          | @param $values = [
	 *          | ['id' => 1, 'type' => 'Offer'],
	 *          | ['id' => 2, 'type' => 'Hotel')]
	 *          | ['id' => 3, 'type' => 'Upsell'],
	 *          | ];
	 *          | @return "(SELECT * FROM (VALUES
	 *          | ROW(1,'Offer'),
	 *          | ROW(2,'Hotel'),
	 *          | ROW(3,'Upsell')) AS `Test` (`id`,`type`)) `Test`"
	 *          |
	 *          |
	 */
	public static function mysqlTableFromValues($name, $values)
	{
		$AviDb = new \Avi\Db();
		return $AviDb->parseTableFromValues($name, $values);
	}


	/**
	 * Build an email address using name + email
	 * @param string $email - valid email address
	 * @param string $name - optional name
	 * @return string email
	 */
	public static function emailify($email, $name = null) {
		//Sanitize email
		$email = preg_replace("/[^a-zA-Z0-9_.@-]/u", '', $email);

		//Sanitize name:
		if (\is_string($name)) {
			$name = preg_replace("/[^a-zA-Z0-9-_ ]/u", '', $name);
			$email = sprintf('%s <%s>', $name, $email);
		}

		return $email;
	}
}