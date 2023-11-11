<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.18
 * @since  2023-11-11 13:10:27
 *
 */
declare(strict_types = 1);
namespace Avi;

use Avi\Log as AviLog;
use Avi\Tools as AviTools;
use Avi\Version as AviVersion;
use const Avi\AVI_JS_MD5;

/**
 * User Interface class.
 *
 * @author aviato-vasile
 */
class UI
{

	// public $head = [];
	public $content = [];

	public $header = [];

	public $page = [
		'stylesheet' => [],
		'javascript' => []
	];

	public $response = '';

	public $log;


	public function __construct($options = [])
	{
		$this->setProperties($options);
		$this->log = new AviLog();
	}


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
	 * Section is the core element of AviUi.
	 * This method generate a section in a form of html element or text
	 *
	 * @param string $sectionName (mandatory) The name of the section
	 * @param array $properties the section properties
	 *        type: obj | html | php
	 *        class: the class atribute of html element
	 *        wrapper: true | false, specify if the section content is wrapped in html element
	 *        tag: section, the html element tag
	 * @param boolean $return (optional) default = false
	 *        If true the section content is returned only, not displayed
	 * @return ?string
	 */
	public function Section($sectionName, $properties = [], $return = false)
	{
		ob_start();

		$properties = AviTools::applyDefault($properties,
			[
				'attributes' => [],
				'class' => 'section',
				'close' => true,
				'folder' => 'sections',
				'id' => $sectionName,
				'javascript' => [],
				'obj' => 'Sections',
				'root' => dirname(__FILE__),
				'tag' => 'section',
				'type' => 'obj',
				'wrapper' => true
			]);

		// pre-computation:
		$attributes = $properties['attributes'];

		// class:
		if ($properties['class'] === 'section') {
			$attributes['class'] = [];
		} else {
			$attributes['class'] = [
				$properties['class']
			];
		}

		if (! \in_array($properties['type'], [
			'script'
		], true)) {
			$attributes['class'][] = 'sec-'.$properties['type'].'-'.$sectionName;
		}

		if (count($attributes['class']) > 0) {
			$attributes['class'] = implode(' ', $attributes['class']);
		} else {
			unset($attributes['class']);
		}

		// id
		if (! \in_array($properties['type'], [
			'box',
			'script'
		], true)) {
			$attributes['id'] = $properties['id'];
		}

		// order attributes a-z
		ksort($attributes);

		// overwrite tag for case of inline script
		if ($properties['type'] === 'script') {
			$properties['wrapper'] = true;
			$properties['tag'] = 'script';
		}
		// open tag:
		if ($properties['wrapper']) {
			echo '<'.$properties['tag'].' '.AviTools::atoattr($attributes).'>';
		}

		// generate content:
		$path = implode(DIRECTORY_SEPARATOR,
			[
				$properties['root'],
				$properties['folder'],
				$sectionName.'.'.$properties['type']
			]);
		switch ($properties['type']) {
			case 'htm':
			case 'html':
				$content = @file_get_contents($path);
				if ($content === false) {
					$this->log->trace('Missing html file on include in [section]: '.$path, LOG_ERR);
				} else {
					echo $content;
				}
				break;

			case 'php':
			case 'phtml':
				if ((@include $path) === false) {
					$message = 'Missing php file on include in [section]:'.$path;
					if (method_exists($this->log, 'trace')) {
						$this->log->trace($message);
					} else {
						echo $message;
					}
				}
				break;

			case 'obj':
				if (isset($properties['params']) && $properties['params'] !== []) {
					call_user_func_array([
						$properties['obj'],
						$sectionName
					], $properties['params']);
				} else {
					if(is_string($sectionName)) {
						if (method_exists($properties['obj'], $sectionName)) {
							$callObj = new $properties['obj']();
							call_user_func([
								$callObj,
								$sectionName
							]);
						} else {
							$message = 'UI: Missing object definition: '.$properties['obj'].'::'.$sectionName;

							if (method_exists($this->response, 'log')) {
								$this->response->log($message, 'warning', 251);
							} else {
								if (method_exists($this->log, 'trace')) {
									$this->log->trace($message);
								} else {
									echo $message;
								}
							}
						}
					}
				}
				break;

			// inline script
			case 'script':
				$path = \str_replace('.script', '.js', $path);
				$content = @file_get_contents($path);
				if ($content === false) {
					$this->log->trace('Missing inline script file to include in [section]: '.$path, LOG_ERR);
				} else {
					echo $content;
				}
				break;
		}

		// close section tag:
		if ($properties['wrapper'] && $properties['close']) {
			echo '</'.$properties['tag'].'>';
		}

		// after content logic
		if (count($properties['javascript']) > 0 && $properties['type'] !== 'script') {
			$this->page['javascript'] = array_merge($this->page['javascript'], $properties['javascript']);
		}

		if ($return) {
			return ob_get_clean();
		}

		ob_get_flush();
	}


	/**
	 * Dispach a page structure based on class parameters and call attributes
	 *
	 * @param array $attributes
	 */
	public function Page($attributes = [])
	{
		$defaults = [
			'options' => [
				'ie8encoding' => true,
				'xssProtection' => true,
				'includeAviJs' => true, // require jQuery
				'htmlAttributes' => []
			],
			'favico' => '//www.aviato.ro/favicon.ico',
			'lang' => 'en-EN',
			'meta' => [
				// charset
				1 => [
					'charset' => 'UTF-8'
				],

				// content
				// 2 => ['content' => 'text'],

				// http-equiv
				31 => [
					'http-equiv' => 'content-type',
					'content' => 'text/html'
				],
				// 32 => ['http-equiv' => 'content-security-policy', content=>'default-src \'self\''],
				// 33 => ['http-equiv' => 'default-style', 'content' => '/css/aviato.css'],
				// 34 => ['http-equiv' => 'refresh', 'content' => '300'],

				// name
				41 => [
					'name' => 'application-name',
					'content' => 'AviLib'
				],
				42 => [
					'name' => 'author',
					'content' => 'Aviato Soft'
				],
				43 => [
					'name' => 'description',
					'content' => 'Web dust library v.'.AviVersion::get()
				],
				44 => [
					'name' => 'generator',
					'content' => 'AviatoWebBuilder'
				],
				45 => [
					'name' => 'keywords',
					'content' => 'Aviato, Aviato Soft, Aviato Web'
				],
				46 => [
					'name' => 'viewport',
					'content' => 'width=device-width, initial-scale=1.0'
				],
			],
			'title' => 'website'
		];

		if (isset($attributes['meta'])) {
			$attributes['meta'] = AviTools::applyDefault($attributes['meta'], $defaults['meta']);
			ksort($attributes['meta']);
		}
		$attributes = AviTools::applyDefault($attributes, $defaults);
		$attributes['options'] = AviTools::applyDefault($attributes['options'], $defaults['options']);

		$opt = $attributes['options'];
		$opt['htmlAttr']['lang'] = $opt['htmlAttr']['lang'] ?? $attributes['lang'];
		$this->page = AviTools::applyDefault($this->page, $attributes);

		// ie-8+ encoding:
		if ($opt['ie8encoding']) {
			header('Content-Type:text/html utf-8');
		}

		// xss protection
		if ($opt['xssProtection']) {
			header('x-content-type-options: nosniff');
			header('x-frame-options: SAMEORIGIN');
			header('x-xss-protection: 1; mode=block');
		}

		echo '<!DOCTYPE html>'.PHP_EOL;
		echo '<html '.AviTools::atoattr($opt['htmlAttr']).'>'.PHP_EOL;

		// head
		echo '<head>';

		// -meta
		foreach ($this->page['meta'] as $meta) {
			echo '<meta ';
			echo AviTools::atoattr($meta);
			echo '>';
		}

		// -title
		echo PHP_EOL.'<title>'.$this->page['title'].'</title>'.PHP_EOL;

		// -favico
		echo '<link ';
		echo AviTools::atoattr([
			'rel' => 'shortcut icon',
			'href' => $this->page['favico']
		]);
		echo '/>';

		// - cascading style sheets
		foreach ($this->page['stylesheet'] as $stylesheet) {
			$stylesheet['rel'] = 'stylesheet';
			$stylesheet['type'] = 'text/css';
			echo '<link ';
			echo AviTools::atoattr($stylesheet);
			echo '/>';
		}

		// - reserved for custom header content (analitycs, trackers, ads, etc)
		if (count($this->header) > 0) {
			foreach ($this->header as $header) {
				echo $header;
			}
		}
		// end header
		echo '</head>'.PHP_EOL;

		// start body content
		if (isset($this->page['class'])) {
			echo '<body class="'.$this->page['class'].'">'.PHP_EOL;
		} else {
			echo '<body>'.PHP_EOL;
		}

		// - content
		if (count($this->content) > 0) {
			echo implode('', $this->content);
		}

		// JavaScript before the body end
		echo PHP_EOL;
		if ($opt['includeAviJs']) {
			$this->page['javascript']['99avi'] = [
				'src' => '/vendor/aviato-soft/avi-lib/src/js/aviato-'.AviVersion::getJsMd5().'-min.js'
			];
		}
		ksort($this->page['javascript']);
		foreach ($this->page['javascript'] as $javascript) {
			echo '<script ';
			echo AviTools::atoattr($javascript);
			echo '></script>'.PHP_EOL;
		}

		// end body
		echo '</body>'.PHP_EOL;
		echo '</html>';
	}
}
