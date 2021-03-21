<?php
declare(strict_types = 1);
namespace Avi;

/**
 * User Interface class.
 *
 * @author aviato-vasile
 */
class UI
{

	public function __construct($options = [])
	{
		$this->setProperties($options);
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

	public function Section($sectionName, $attributes, $return = false)
	{
		$AviTools = new \Avi\Tools();
		ob_start();

		$attributes = $AviTools->applyDefault($attributes, [
			'class' => 'section',
			'id' => $sectionName,
			'javascript' => [],
			// 'type' => 'php',
			'obj' => 'Sections',
			'type' => 'obj',
			'wrapper' => true,
			'tag' => 'section',
			'close' => true,
			'root' => '/'
		]);

		// pre-computation:
		// class:
		if ($attributes['class'] === 'section') {
			$attributes['class'] = 'sec-' . $attributes['type'] . '-' . $sectionName;
		} else {
			$attributes['class'] .= ' sec-' . $attributes['type'] . '-' . $sectionName;
		}

		// open tag:
		if ($attributes['wrapper']) {
			echo '<' . $attributes['tag'] . ' ';
			if ($attributes['type'] !== 'box') {
				echo 'id="' . $attributes['id'] . '" ';
			}
			echo 'class="' . $attributes['class'] . '">';
		}

		// generate content:
		switch ($attributes['type']) {
			case 'html':
			case 'php':
				include $attributes['root']
					. DIRECTORY_SEPARATOR . 'sections'
					. DIRECTORY_SEPARATOR . $sectionName . $attributes['type'];

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
						$this->response->log('Error: missing object definition', 'error');
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
