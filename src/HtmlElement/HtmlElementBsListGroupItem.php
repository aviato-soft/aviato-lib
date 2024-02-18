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

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsListGroupItem extends HtmlElement
{
	private $position;

	protected $params;

	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();

		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? 'li';
		$this->parseParam('text', '');

		$this->parseParam('active', false);
		$this->parseParam('color', false);
		$this->parseParam('disabled', false);
		$this->parseParam('href', 'javascript:;');
		$this->parseParam('template', false);
	}


	private function setAttributes()
	{
		$this->setAttributeByTag();
		$this->setAttributeHref();
		$this->setAttributeActive();
		$this->setAttributeColor();
		$this->setAttributeDisabled();

		$this->attributes([
			'class' => [
				'list-group-item'
			]
		]);
	}


	private function setAttributeByTag()
	{
		if (in_array($this->tag, ['a', 'button'], true)) {
			$this->attributes([
				'class' => [
					'list-group-item-action'
				]
			]);
		}
		if ($this->tag === 'button') {
			$this->attributes([
				'type' => 'button'
			]);
		}
	}

	private function setAttributeActive()
	{
		if ($this->params['active']) {
			$this->attributes([
				'aria' => [
					'current' => 'true'
				],
				'class' => [
					'active'
				]
			]);
		}
	}


	private function setAttributeColor()
	{
		if(in_array($this->params['color'], AVI_BS_COLOR, true)) {
			$this->attributes([
				'class' => [
					sprintf('list-group-item-%s', $this->params['color'])
				]
			]);
		}
	}


	private function setAttributeDisabled()
	{
		if (isset($this->params['disabled']) && $this->params['disabled'] === true) {
			if (in_array($this->tag, ['a', 'li'], true)) {
				$this->attributes([
					'class' => 'disabled',
					'aria' => [
						'disabled' => 'true'
					],
				]);
				if(isset($this->attributes['href'])) {
					$this->attributes['tabindex'] = '-1';
				}
			} else {
				$this->attributes([
					'disabled'
				]);
			}
		}
	}


	private function setAttributeHref()
	{
		if ($this->tag === 'a') {
			if ($this->params['href'] !== false) {
				$this->attributes([
					'href' => $this->params['href']
				]);
			}
		}
	}


	private function setContent()
	{
		if($this->params['template'] !== false) {
			$this->content = \Avi\Tools::sprinta($this->params['template'], $this->params['text']);
		} else {
			$this->content = $this->params['text'];
		}
	}
}
