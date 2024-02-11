<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.03
 * @since  2024-02-11 16:44:25
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsBadge extends HtmlElement
{
	protected $params;
	protected $tag = 'span';


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
	 * @return \Avi\HtmlElementBsIcon
	 */
	public function __construct(array|string $params = '')
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();

		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? $this->tag;

		//for params = string this line will associate the string to param[text]
		$this->parseParam('text', '');
	}


	private function setAttributes()
	{
		$this->setAttributeBgColor();
		$this->setAttributeColor();
		$this->setAttributePill();
		$this->setAttrClass('badge');
	}


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


	private function setContent()
	{
		if (is_array($this->params['text'])) {
			$this->params['text'] = implode('', $this->params['text']);
		}

		$this->content = $this->params['text'];
	}
}
