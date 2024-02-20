<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.07
 * @since  2024-02-20 20:32:40
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';

class HtmlElementBsInputGroupText extends HtmlElement
{
	protected $params;
	protected $tag = 'span';


	/**
	 * use default template:
	 * <i class="bs-icon bs-{slug}"></i>
	 *
	 * @param array|string $params can be a string re[resemting the bootstrap icon slug
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

		$this->parseParam('id', false);
		$this->parseParam('text', false);
	}


	private function setAttributes()
	{
		$this->setAttributeByParam('id');
		$this->setAttrClass('input-group-text');
	}


	private function setContent()
	{
		$this->content = $this->params['text'];

	}

}
