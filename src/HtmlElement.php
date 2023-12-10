<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.20
 * @since  2023-11-23 16:27:51
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
			//in case of existing attributes convert them to arrayL
			//$this->attributes = $this->parseAttributesR();

			//merge attrubutes
			$this->attributes = array_merge_recursive($this->attributes ?? [], $attributes);
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
	public function content($content = null)
	{
		$this->content = $content;
		return $this->use();
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
	public function element(string $element, array $properties = [], $root = null)
	{
		$root = $root ?? dirname(__FILE__).'/HtmlElement';
		$extElement = 'HtmlElement'.ucfirst($element);
		require_once $root.'/'.$extElement.'.php';
		return new $extElement($properties);
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

		if (in_array($this->tag, ['!doctype','br','hr','input','link','meta'], true)) {
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
	private function parseAttributes()
	{
		if (is_null($this->attributes) || ! is_countable($this->attributes)) {
			return $this->tag;
		}

		$atributes = [];
		$pattern = '%s="%s"';
		foreach ($this->attributes as $k => $v) {
			if (is_countable($v)) {
				// it is an array do some parsing:
				if (array_is_list($v)) {
					// just list of values
					// e.g. for class atribute: class=>['d-block', 'bg-light']
					sort($v);
					$atributes[] = sprintf($pattern, $k, implode(' ', $v));
				} else {
					// associative array
					// e.g. for data or aria attribute: data=>[role=>'box', content=>'text']
					foreach ($v as $vk => $vv) {
						$atributes[] = sprintf($pattern, $k.'-'.$vk, $vv);
					}
				}
			} else {
				// the attribute is a string
				if (is_numeric($k)) {
					// just a singurlar atribute
					$atributes[] = $v;
				} else {
					// associative attribute:
					$atributes[] = sprintf($pattern, $k, $v);
				}
			}
		}
		sort($atributes);
		$atributes = array_merge([$this->tag], $atributes);
		return implode(' ', $atributes);
	}


	/**
	 * Convert the content from array to string
	 *
	 * @return string|array|string|null
	 */
	private function parseContent()
	{
		if (is_null($this->content)) {
			$this->content = '';
		}

		if (is_countable($this->content)) {
			$this->content = implode('', $this->content);
		}

		return $this->content;
	}
}
?>