<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.09
 * @since  2024-03-04 12:25:06
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsProgress extends HtmlElement
{
	protected $params;
	protected $tag = 'div';

	public $bar;


	/**
	 * use default template:
	 * <span class="badge {bg-color} {color} {pill}>{content}</span>
	 *
	 *
	 * @param array|string $params can be a string re[resemting the bootstrap icon slug
	 *        |- bg-color = background color = an element of AVI_BS_COLOR
	 *        |- color = textcolor = an element of AVI_BS_COLOR
	 *        |- pill = rounded margins like a pill = true | false
	 *        |- text = string
	 * @return \Avi\HtmlElementBsProgress
	 */
	public function __construct(array|string $params = '')
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();

		return $this;
	}


	public function bar($params)
	{
		$this->params['bar'] = $params;
		$this->parseParams();
		$this->setAttributeLabel();
		$this->setAttributesAnimated();
		$this->setAttributeStriped();
		$this->setAttributeVariant();
		$this->setContent();
		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? $this->tag;

		$this->parseParam('label');

		$this->parseParam('animated');
		$this->parseParam('bar', true);
		$this->parseParam('height');
		$this->parseParam('max', 100);
		$this->parseParam('min', 0);
		$this->parseParam('striped');
		$this->parseParam('value', 0);
		$this->parseParam('variant');

		$this->child('bar', 'html-div', [
			'class' => [
				'progress-bar'
			],
			'style' => sprintf('width:%s%%', $this->params['value'])
		]);



		//for params = string this line will associate the string to param[text]
		//$this->parseParam('text', '');
	}


	private function setAttributes()
	{
		$this->setAttributesAnimated();
		$this->setAttributeHeight();
		$this->setAttributeLabel();
		$this->setAttributeStriped();
		$this->setAttributeVariant();

		$this->attributes['aria']['valuemax'] = $this->params['max'];
		$this->attributes['aria']['valuemin'] = $this->params['min'];
		$this->attributes['aria']['valuenow'] = $this->params['value'];
		$this->attributes['role'] = 'progressbar';
		$this->setAttrClass('progress');

	}

	private function setAttributesAnimated()
	{
		if($this->params['animated']) {
			$this->bar->setAttrClass('progress-bar-animated');
		}
	}

	private function setAttributeHeight()
	{
		if ($this->params['height']) {
			$this->attributes['style'] = sprintf('height:%spx', $this->params['height']);
		}
	}

	private function setAttributeLabel()
	{
		if($this->params['label']) {
			if($this->params['label'] === true) {
				$this->params['label'] = '{value}%';
			}

			$this->bar->content(\Avi\Tools::sprinta($this->params['label'], ['value' => $this->params['value']]));
		}
	}

	private function setAttributeStriped()
	{
		if($this->params['striped']) {
			$this->bar->attributes([
				'class' => [
					'progress-bar-striped'
				]
			]);
		}
	}

	private function setAttributeVariant()
	{
		if(in_array($this->params['variant'], AVI_BS_COLOR, true)) {
			$this->bar->attributes([
				'class' => [
					sprintf('text-bg-%s', $this->params['variant'])
				]
			]);
		}
	}

/*
	private function setAttributeBgColor()
	{
		if (isset($this->params['bg-color']) && in_array($this->params['bg-color'], AVI_BS_COLOR, true)) {
			$this->setAttrClass(sprintf('bg-%s', $this->params['bg-color']));
		}
	}


	private function setAttributeColor()
	{
		if (isset($this->params['color']) && in_array($this->params['color'], AVI_BS_COLOR, true)) {
			$this->setAttrClass(sprintf('text-bg-%s', $this->params['color']));
		}
	}


	private function setAttributePill()
	{
		if (isset($this->params['pill']) && $this->params['pill'] === true) {
			$this->setAttrClass('rounded-pill');
		}
	}
*/

	private function setContent()
	{
		$this->content = $this->bar->use();
//		if (is_array($this->params['text'])) {
//			$this->params['text'] = implode('', $this->params['text']);
//		}

//		$this->content = $this->params['text'];
	}
}
