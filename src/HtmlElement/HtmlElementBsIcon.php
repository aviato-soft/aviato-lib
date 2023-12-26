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

require_once dirname(__DIR__).'/HtmlElement.php';

class HtmlElementBsIcon extends HtmlElement
{
	protected $params;


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

		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? 'i';

		$this->parseParam('slug', 'bootstrap');

		if (substr($this->params['slug'], 0, 3) === 'bi-') {
			$this->params['slug'] = substr($this->params['slug'], 3);
		}
	}


	private function setAttributes()
	{
		$this->attributes([
			'class' => 'bi bi-'.$this->params['slug']
		]);
	}
}
