<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.06
 * @since  2024-02-18 13:08:57
 *
 */
declare(strict_types = 1);
namespace Avi;

use Avi\Tools as AviTools;


class HtmlElement
{

	protected $attributes;

	protected $content;

	protected $params;

	protected $tag;

	public $parent;


	public function __construct($tag = 'div', $parent = null)
	{
		$this->tag = strtolower($tag) ?? 'div';
		$this->parent = $parent;
		return $this;
	}


	/**
	 * Add new attributes to element
	 *
	 * @param array|null $attributes The the attributes must be included in one array, each member having any of the following format:
	 *        - single attribute:
	 *        $attributes = ['disabled']
	 *        - associative:
	 *        $atributes = ['type'=>'input', 'value'=>3]
	 *        - associative multiple keys:
	 *        $attributes = ['data' => ['role' => 'content', 'content' => 'button']]
	 *        - assocuative multiple values:
	 *        $attributes = ['class' => 'btn btn-sm']
	 * @param bool $mergeValues - merge new values true | false
	 * @return HtmlElement
	 */
	public function attributes($attributes = [], bool $mergeValues = true)
	{
		$this->attributes = $mergeValues ? array_merge_recursive($this->attributes ?? [], $attributes) : $attributes;
		return $this;
	}


	/**
	 * Set the element content and return the formated element as a string
	 *
	 * @param array|string|null $content
	 * @return string
	 */
	public function content(\Avi\HtmlElement|array|string|null$content = null, $return = false)
	{
		if(method_exists($this, 'parseElementContent')) {
			$this->content = $this->parseElementContent($content);
		} else {

			if(is_a($content, '\Avi\HtmlElement')) {
				$this->content = $content->use();
			} else {
				if (is_array($this->content)) {
					$this->content[] = $content;
				} else {
					$this->content = $content;
				}
			}
		}

		return ($return) ? $this: $this->use();
	}


	public function childContent($name, $return = false)
	{
		$content = (is_string($this->params[$name])) ? $this->params[$name] : $this->params[$name]['content'] ?? '';

		return $this->$name->content($content, $return);
	}


	/**
	 * Display the content
	 *
	 * @param array|string|null $content
	 */
	public function dispatch($content = null)
	{
		echo $this->content($content);
	}


	/**
	 * Call a new class which extend current HtmlElementClass
	 *
	 * @param string $element - defined element
	 * @return object defeined in extended class
	 */
	public function element(string $element, array|string $properties = [], $root = null)
	{
		$root = $root ?? dirname(__FILE__).'/HtmlElement';
		$extElement = 'HtmlElement'.ucfirst($element);
		require_once $root.'/'.$extElement.'.php';
		$extElement = __NAMESPACE__.'\\'.$extElement;
		// create a new instance:
		$newElement = new $extElement(
			(is_array($properties)) ?
				array_merge($properties, [
					'parent' => $this->params ?? []
				]) : $properties,
			$this
		);
		$newElement->attributes($properties['attr'] ?? []);

		return $newElement;
	}


	/**
	 * Instantiate a new object using tag name
	 *
	 * @param string|null $tag element tag
	 * @return HtmlElement
	 */
	public function tag($tag, $attributes = null, $newElement = true, $instance = null)
	{
		if ($newElement) {
		// create a new instance:
			$clsName = ($instance) ? get_class($instance) : get_class();
			$newElement = new $clsName($tag, $this);
		} else {
		// Change existing tag
			$this->tag = $tag;
			$newElement = $this;
		}


		if ($attributes) {
			$newElement->attributes($attributes);
		}

		$newElement->parent = $this;

		return $newElement;
	}


	/**
	 * Return the formated element as a string
	 *
	 * @return string
	 */
	public function use()
	{
		return \Avi\Tools::sprinta(
			$this->getTemplateByTag(),
			[
				'attributes' => $this->parseAttributes(),
				'content' => $this->parseContent(),
				'tag' => $this->tag
			]);
	}


	/**
	 * Instantiate a child element
	 * @param string $name - the child name
	 * @param string $type - the element type | html-tag
	 * @param array $defaultAttributes
	 * @return HtmlElement
	 */
	protected function child(string $name, string $type, array|string $defaultAttributes = []): HtmlElement|null
	{
		if (!isset($this->params[$name])) {
			return null;
		}

		//the child is a HtmlElement
		if (is_a($this->params[$name], 'Avi\HtmlElement'.$type)) {
			$this->$name = $this->params[$name];
		} else {
			//create a new childe as tag | element based on type:
			$this->$name = (substr($type, 0, 4) === 'html') ?
				$this->tag(substr($type, 5))->attributes($this->params[$name]['attr'] ?? []):
				$this->element($type, $this->params[$name]);
		}

		$this->$name->attributes($defaultAttributes);

		return $this->$name;
	}


	public function parseParam($key, $default = null)
	{
		if(is_string($this->params)) {
			$this->params = [
				$key => $this->params
			];
		}
/* - advanced feature - next release
		if($this->params === []) {
			$this->params[$key] = $default;
		}
*/
		if(!isset($this->params[$key])) {
			$this->params[$key] = $default;
		}
	}


	protected function setAttributeByParam($key)
	{
		if (isset($this->params[$key]) && $this->params[$key] !== false) {
			$this->attributes[$key] = $this->params[$key];
		}
	}

/* - advanced feature, next release:
	protected function setAttributeByParam($key, $merge = false)
	{
		if (isset($this->params[$key]) && $this->params[$key] !== false) {
			($merge) ?
				$this->attributes($key, $this->params[$key]) :
				$this->attributes[$key] = $this->params[$key];
		}
	}
*/

	protected function setAttrClass($value, $merge = true) {
		if (is_null($value)) {
			return;
		}

		$this->attributes([
			'class' => [
				$value
			]
		], $merge);
	}


	/**
	 * Return the template use to format the element
	 *
	 * @return string
	 */
	private function getTemplateByTag()
	{
		$templates = [
			'default' => '<{attributes}>{content}</{tag}>',
			'single' => '<{attributes}>',
			'contentOnly' => '{content}'
		];

		if (in_array($this->tag, ['!doctype','br','hr','img', 'input','link','meta'], true)) {
			return $templates['single'];
		}

		if ($this->tag === '' || $this->tag === 'none') {
			return $templates['contentOnly'];
		}

		return $templates['default'];
	}


	/**
	 * Convert Attributes from array to a scring
	 *
	 * @return string
	 */
	protected function parseAttributes()
	{
		if (isset($this->attributes['tag'])) {
			$this->tag = strtolower($this->attributes['tag']);
			unset($this->attributes['tag']);
		}
		//exceptions:
		//use content to input => value attribute if attribute velue not set
		if ($this->tag === 'input' && !is_null($this->content)){
			$this->parseContent();

			if ($this->attributes === null || !isset($this->attributes['value'])) {
				$this->attributes['value'] = $this->content;
			}
		}

		if (is_null($this->attributes) || ! is_countable($this->attributes)) {
			return $this->tag;
		}

		$atributesAssoc = [];
		$pattern = '%s="%s"';
		foreach ($this->attributes as $k => $v) {
			if (is_countable($v)) {
				// it is an array do some parsing:
				if (array_is_list($v)) {
					// just list of values
					// e.g. for class atribute: class=>['d-block', 'bg-light']
					sort($v);
					if($v[0] === null) {
						array_shift($v);
					}
					$atributesAssoc[] = sprintf($pattern, $k, implode(' ', array_unique($v)));
				} else {
					// associative array
					// e.g. for data or aria attribute: data=>[role=>'box', content=>'text']
					foreach ($v as $vk => $vv) {
						$atributesAssoc[] = sprintf($pattern, $k.'-'.$vk, $vv);
					}
				}
			} else {
				// the attribute is a string
				if (!is_numeric($k)) {
					// associative attribute:
					$atributesAssoc[] = sprintf($pattern, $k, $v);
				}
			}
		}
		$atributesAssoc = array_unique($atributesAssoc);
		sort($atributesAssoc);

		//parsing the single atributes (disabled, enabled ... )
		$attributesNumeric = [];
		foreach ($this->attributes as $k => $v) {
			if (!is_countable($v) && is_numeric($k)) {
				$attributesNumeric[] = $v;
			}
		}
		$attributesNumeric = array_unique($attributesNumeric);
		sort($attributesNumeric);
		$atributes = array_merge([$this->tag], $atributesAssoc, $attributesNumeric);
		return implode(' ', $atributes);
	}


	/**
	 * Convert the content from array to string
	 *
	 * @return string|array|string|null
	 */
	protected function parseContent()
	{
		if (is_null($this->content)) {
			$this->content = '';
			return $this->content;
		}

		if (is_countable($this->content)) {
			$this->content = implode('', $this->content);
		}

		return $this->content;
	}

/*
	public function alignAttributes($html)
	{
		$l = strlen($html);
		for($i = 0; $i < $l; $i++) {
			if (substr($html, $i, 1) === '<') {
				for ($j = $i+1; $j < $l; $j++) {
					if (substr($html, $j, 1) === '>') {
						$element = substr($html, $i + 1, $j - $i - 1);
						$aligned = $this->alignAttributesOne($element);
						print_r([
							'start' => $i,
							'element' => $element,
							'alligned' => $aligned,
							'length' => $j-$i
						]);
						$html = substr_replace($html, $aligned, $i + 1, $j - $i - 1);
					}
				}
				$i = $j;
			}
		}
		return $html;
	}

	private function alignAttributesOne($html) {
		$attributes = explode(' ', $html);
		$this->tag = $attributes[0];
		array_shift($attributes);
		$items = [];
		foreach($attributes as $attribute) {
			$attr = explode('=', $attribute);
			$key = $attr[0];
			if (isset($attr[1])) {
				$attr[1] = trim($attr[1], '"');
				$val = explode(' ', $attr[1]);
				$items[] = [
					$key => $val
				];
			} else {
				$items[] = $key;
			}

		}
		$this->attributes = $items;
		print_r($items);
		return $this->parseAttributes();
	}
*/
}
?>