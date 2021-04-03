<?php
declare(strict_types = 1);
namespace Avi;

use Avi\Log as AviLog;
use Avi\Tools as AviTools;

/**
 * User Interface class.
 *
 * @author aviato-vasile
 */
class UI
{

	// public $head = [];

	// public $content = [];
	// public $header = [];
	public $page = [
		'style' => [],
		'javascript' => []
	];

	public $response;

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
	 * Generate a section
	 *
	 * @param string $sectionName
	 * @param array $attributes
	 * @param boolean $return
	 * @return string
	 */
	public function Section($sectionName, $attributes = [], $return = false)
	{
		ob_start();

		$attributes = AviTools::applyDefault($attributes,
			[
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
		// class:
		if ($attributes['class'] === 'section') {
			$attributes['class'] = '';
		}
		if (strlen($attributes['class']) > 0) {
			$attributes['class'] .= ' ';
		}
		$attributes['class'] .= 'sec-' . $attributes['type'] . '-' . $sectionName;

		// open tag:
		if ($attributes['wrapper']) {
			echo '<' . $attributes['tag'] . ' ';
			if ($attributes['type'] !== 'box') { // depricated condition
				echo 'id="' . $attributes['id'] . '" ';
			}
			echo 'class="' . $attributes['class'] . '">';
		}

		// generate content:
		$path = $attributes['root'] . DIRECTORY_SEPARATOR . 'sections' . DIRECTORY_SEPARATOR . $sectionName . '.' .
			$attributes['type'];
		$this->log->trace($path, LOG_DEBUG);
		switch ($attributes['type']) {
			case 'htm':
			case 'html':
				$content = @file_get_contents($path);
				if ($content === false) {
					$this->log->trace('Missing html file on inclide in [section]: ' . $path, LOG_ERR);
				} else {
					echo $content;
				}
				break;

			case 'php':
			case 'phtml':
				if ((@include $path) === false) {
					$this->log->trace('Missing php file on inclide in [section]:' . $path);
				}
				break;

			case 'obj':
				if (isset($attributes['params'])) {
					call_user_func_array([
						$attributes['obj'],
						$sectionName
					], $attributes['params']);
				} else {
					if (method_exists($attributes['obj'], $sectionName)) {
						call_user_func([
							$attributes['obj'],
							$sectionName
						]);
					} else {
						if (method_exists($this->response, 'log')) {
							$this->response->log('UI: Missing object definition', 'warning', 251);
						}
					}
				}

				break;
		}

		// close section tag:
		if ($attributes['wrapper'] && $attributes['close']) {
			echo '</' . $attributes['tag'] . '>';
		}

		// after content logic
		if (count($attributes['javascript']) > 0) {
			$this->page['javascript'] = array_merge($this->page['javascript'], $attributes['javascript']);
		}

		if ($return) {
			return ob_get_clean();
		}

		ob_get_flush();
	}
}
