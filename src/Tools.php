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
			$pattern = str_replace(sprintf('{%s}', $k), (string)$v, $pattern);
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
	public static function sprinta($pattern, $array)
	{
		return self::str_supplant($pattern, $array);
	}


	/**
	 * As sprinta, with optional dispatch
	 *
	 * @param string $pattern
	 * @param array $array
	 * @param boolean $returnOnly,
	 *        	(default = false, will echo result)
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
	 * @param boolean $returnOnly,
	 *        	(optional = false result in output the buffer content)
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
	 * @param $array array
	 *        	- the data to be parsed
	 * @param $pattern string
	 *        	- the template
	 * @param $configuration array
	 *        	- optional parameters
	 *        	- isPrintFormat:[true|false] = use sprintf format
	 *        	- startTag:[any char] = the start tag default = '{'
	 *        	- endTag:[any char] = the start tag default = '}'
	 * @example :
	 *          | @param $array = [
	 *          | 	0 => ['id' => 1.0, 'slug' => 'One'],
	 *          | 	1 => ['id' => '2', 'slug' => 'Two']
	 *          | ];
	 *          | @param $pattern = '<p data-id="{id}">{slug}</p>';
	 *          |--> @return '<p data-id="1">One</p><p data-id="2">Two</p>';
	 */
	public static function atos($array, $pattern, $config = [])
	{
		$result = '';

		if (! is_array($array)) {
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
			'isPrintFormat' => false
		]);

		if (! isset($array[0])) {
			$data = [
				0 => $array
			];
		} else {
			$data = $array;
		}

		$keys = array_keys($data[0]);

		foreach ($data as $v) {
			if ($config['isPrintFormat']) {
				try {
					$result .= vsprintf($pattern, $v);
				} catch (\Exception $e) {
					//do nothing...it is fine!
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
						if (is_string($v[$key])) {
							$res = str_replace($config['startTag'] . $key . $config['endTag'], $v[$key], $res);
						} else {
							$res = str_replace($config['startTag'] . $key . $config['endTag'], gettype($v[$key]), $res);
						}
					}
				}
				$result .= $res;
			}
		}

		return ($result);
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
	public static function enc($q, $key = 'B1B2B65B5BBBA13CF5EC756CEF5055E6')
	{
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
	public static function dec($q, $key = 'B1B2B65B5BBBA13CF5EC756CEF5055E6')
	{
		$qDecoded = rtrim(
			openssl_decrypt(base64_decode($q . '='), 'aes-256-cbc', md5($key), 0, substr(md5(md5($key)), 3, 16)), "\0");
		return ($qDecoded);
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
	 * Simple redirect method (shortcut to header('location: [page]'))
	 *
	 * @param string $page
	 *        	- the page name(url, permalink)
	 * @param
	 *        	string [$extension] - the page extension (default is html)
	 */
	public static function redirect($page = '', $extension = '')
	{
		session_write_close();
		header('Location: /' . $page . $extension, true, 302);
		//exit();
	}


	/**
	 * Return an mysql synthax temporary table based on values
	 *
	 * @param string $name
	 *        	- the name of the table
	 * @param array $values
	 *        	- the values of the array
	 * @return string sql
	 *
	 * @example :
	 *          | @param $name = 'test'
	 *          | @param $values = [
	 *          | 	['id' => 1, 'type' => 'Offer'],
	 *          | 	['id' => 2, 'type' => 'Hotel')]
	 *          | 	['id' => 3, 'type' => 'Upsell'],
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
		$columns = array_keys($values[0]);
		$rowPattern = "ROW(";
		foreach ($values[0] as $k => $v) {
			if (is_numeric($v)) {
				$rowPattern .= "{" . $k . "},";
			} else {
				$rowPattern .= "'{" . $k . "}',";
			}
		}
		$rowPattern = substr($rowPattern, 0, - 1) . '),';

		$sql = "(SELECT * FROM (VALUES " . substr(self::atos($values, $rowPattern), 0, - 1) . ") AS `" . $name . "` " .
			"(`" . implode("`,`", $columns) . "`)) `" . $name . "` ";

		return $sql;
	}
}