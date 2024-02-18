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

require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsButtonClose extends HtmlElementBs
{
	protected $params;

	protected $tag = 'button';


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

		$this->parseParam('text', '');

		$this->parseParam('disabled');
		$this->parseParam('dismiss');
		$this->parseParam('target');
	}


	private function setAttributes()
	{
		$this->setAttributeDisabled();
		$this->setAttributesDismiss();
		$this->setAttributesTarget();

		$this->attributes([
			'aria' => [
				'label' => 'Close'
			],
			'class' => [
				'btn-close'
			],
			'type' => 'button'
		]);
	}


	private function setAttributeDisabled()
	{
		if($this->params['disabled']) {
			$this->attributes([
				'disabled'
			]);
		}
	}


	private function setAttributesDismiss()
	{
		if($this->params['dismiss']) {
			$this->attributes['data']['bs-dismiss'] = $this->params['dismiss'];
		}
	}


	private function setAttributesTarget()
	{
		if($this->params['target']) {
			$this->attributes['data']['bs-target'] = $this->params['target'];
		}
	}


	private function setContent()
	{
		$this->content = $this->params['text'];
	}
}
