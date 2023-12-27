<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.24
 * @since  2023-12-15 18:03:04
 *
 */
declare(strict_types = 1);
namespace Avi;

use Avi\Tools as AviTools;


class HtmlElement
{

	protected $attributes;

	protected $content;

	protected $tag;

	public $parent;


	public function __construct($tag = 'div')
	{
		$this->tag = strtolower($tag) ?? 'div';
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
		if ($mergeValues) {
			//in case of existing attributes convert them to array
			//$this->attributes = $this->parseAttributesR();

			//merge attrubutes
			$this->attributes = array_merge_recursive($this->attributes ?? [], $attributes);

			//exceptions:
			if ($this->tag === 'input' && isset($attributes['value'])) {
				$this->attributes['value'] = $attributes['value'];
			}
		} else {
			$this->attributes = $attributes;
		}
		return $this;
	}


	/**
	 * Set the element content and return the formated element as a string
	 *
	 * @param array|string|null $content
	 * @return string
	 */
	public function content(array|string|null $content = null, $return = false)
	{
		if(method_exists($this, 'parseElementContent')) {
			$this->content = $this->parseElementContent($content);
		} else {

			if (is_array($this->content)) {
				$this->content[] = $content;
			} else {
				$this->content = $content;
			}
		}

		return ($return) ? $this: $this->use();
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
		$newElement = new $extElement($properties);
		$newElement->parent = $this;
		$newElement->attributes($properties['attr'] ?? []);

		return $newElement;
	}


	/**
	 * Instantiate a new object using tag name
	 *
	 * @param string|null $tag element tag
	 * @return HtmlElement
	 */
	public function tag($tag)
	{
		// create a new instance:
		$newElement = new HtmlElement($tag);

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


	protected function parseParam($key, $default = null)
	{
		if(is_string($this->params)) {
			$this->params = [
				$key => $this->params
			];
		}

		if($this->params === []) {
			$this->params[$key] = $default;
		}

		if(!isset($this->params[$key])) {
			$this->params[$key] = $default;
		}
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
					$atributesAssoc[] = sprintf($pattern, $k, implode(' ', $v));
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
		sort($atributesAssoc);

		//parsing the single atributes (disabled, enabled ... )
		$attributesNumeric = [];
		foreach ($this->attributes as $k => $v) {
			if (!is_countable($v) && is_numeric($k)) {
				$attributesNumeric[] = $v;
			}
		}
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
}
?>