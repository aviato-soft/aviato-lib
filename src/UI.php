<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 00.07.07
 * @since  2021-12-28 19:54:14
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
	 *        The section content is returned only, not displayed
	 * @return string
	 */
	public function Section($sectionName, $properties = [], $return = false)
	{
		ob_start();

		$properties = AviTools::applyDefault($properties,
			[
				'attributes' => [],
				'class' => 'section',
				'id' => $sectionName,
				'javascript' => [],
				// 'type' => 'php',
				'obj' => 'Sections',
				'type' => 'obj',
				'wrapper' => true,
				'tag' => 'section',
				'close' => true,
				'root' => dirname(__FILE__)
			]);

		// pre-computation:
		$attributes = $properties['attributes'];

		// class:
		if ($properties['class'] === 'section') {
			// $properties['class'] = '';
			$attributes['class'] = [];
		} else {
			$attributes['class'] = [
				$properties['class']
			];
		}

		$attributes['class'][] = 'sec-'.$properties['type'].'-'.$sectionName;

		$attributes['class'] = implode(' ', $attributes['class']);

		// id
		if ($properties['type'] !== 'box') { // depricated condition
			$attributes['id'] = $properties['id'];
		}

		// order attributes a-z
		ksort($attributes);

		// open tag:
		if ($properties['wrapper']) {
			echo '<'.$properties['tag'].' '.AviTools::atoattr($attributes).'>';
		}

		// generate content:
		$path = $properties['root'].DIRECTORY_SEPARATOR.'sections'.DIRECTORY_SEPARATOR.$sectionName.'.'.
			$properties['type'];
		switch ($properties['type']) {
			case 'htm':
			case 'html':
				$content = @file_get_contents($path);
				if ($content === false) {
					$this->log->trace('Missing html file on inclide in [section]: '.$path, LOG_ERR);
				} else {
					echo $content;
				}
				break;

			case 'php':
			case 'phtml':
				if ((@include $path) === false) {
					$this->log->trace('Missing php file on inclide in [section]:'.$path);
				}
				break;

			case 'obj':
				if (isset($properties['params'])  && $properties['params'] !== []) {
					call_user_func_array([
						$properties['obj'],
						$sectionName
					], $properties['params']);
				} else {
					if (method_exists($properties['obj'], $sectionName)) {
						$callObj = new $properties['obj']();
						call_user_func([
							$callObj,
							$sectionName
						]);
					} else {
						if (method_exists($this->response, 'log')) {
							$this->response->log('UI: Missing object definition', 'warning', 251);
						} else {
							$this->log->trace(
								'UI: Missing object definition: '.$properties['obj'].'::'.$sectionName);
						}
					}
				}

				break;
		}

		// close section tag:
		if ($properties['wrapper'] && $properties['close']) {
			echo '</'.$properties['tag'].'>';
		}

		// after content logic
		if (count($properties['javascript']) > 0) {
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
			foreach ($this->content as $content) {
				echo $content;
			}
		}

		// JavaScript before the body end
		echo PHP_EOL;
		if ($opt['includeAviJs']) {
			$this->page['javascript'][99] = [
				'src' => '/vendor/aviato-soft/avi-lib/src/js/aviato-'.AVI_JS_MD5.'-min.js'
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
