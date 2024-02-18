<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.05
 * @since  2024-02-18 11:35:10
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsNav extends HtmlElement
{
	protected $params;

	//children:
	public $items;

/**
 *
 * @param array $params
 * 		|- align: AVI_BS_POS_H
 * 		|- direction: horizontal | vertical | vertical-AVI_BS_BREAKPOINT
 * 		|- fill: fill | justified
 * 		|- interface: tabs | pills | underline
 * 		|- items
 * 			|- Avi\HtmlElement
 * 			|- a [href / active / disabled / text]
 * 		|- tag = nav | ul
 * @return \Avi\HtmlElementBsNav
 */
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
		$this->tag = $this->params['tag'] ?? 'nav';

		$this->parseParam('align', false);
		$this->parseParam('direction', 'horizontal');
		$this->parseParam('fill', false);
		$this->parseParam('interface', false);
		$this->parseParam('items', false);
		$this->items = $this->parseItems();

	}


	private function parseItems()
	{
		$items = [];
		if (!is_countable($this->params['items'])) {
			return $items;
		}

		foreach($this->params['items'] as $item) {
			if (is_a($item, 'Avi\HtmlElement')) {
				$items[] = $item;
			} else {
				if ($this->tag === 'nav') {
					$items[] = $this->element('BsNavItem', $item);
				} else {
					$items[] = $this->tag('li')
						->attributes([
							'class' => [
								'nav-item'
							]
						])
						->content($this->element('BsNavItem', $item)->use(), true);
				}
			}
		}
		return $items;
	}


	private function setAttributes()
	{
		$this->setAttributesAlign();
		$this->setAttributesDirection();
		$this->setAttributesFill();
		$this->setAttributesInterface();
		$this->attributes([
			'class' => [
				'nav'
			]
		]);
	}


	private function setAttributesAlign()
	{
		if(in_array($this->params['align'], AVI_BS_POS_H, true)) {
			$this->attributes([
				'class' => [
					sprintf('justify-content-%s', $this->params['align'])
				]
			]);
		}
	}


	private function setAttributesDirection()
	{
		if ($this->params['direction'] === 'horizontal') {
			return;
		}

		$direction = explode('-', $this->params['direction']);
		if ($direction[0] === 'vertical') {
			if (isset($direction[1]) && in_array($direction[1], AVI_BS_BREAKPOINT)) {
				$direction = sprintf('flex-%s-column', $direction[1]);
			} else {
				$direction = 'flex-column';
			}
			$this->attributes([
				'class' => [
					$direction
				]
			]);
		}

		return;
	}


	private function setAttributesFill()
	{
		if($this->params['fill'] !== false && in_array($this->params['fill'], ['fill', 'justified'], true)) {
			$this->attributes([
				'class' => [
					sprintf('nav-%s', $this->params['fill'])
				]
			]);
		}
	}


	private function setAttributesInterface()
	{
		if($this->params['interface'] !== false && in_array($this->params['interface'], ['tabs', 'pills', 'underline'], true)){
			$this->attributes([
				'class' => [
					sprintf('nav-%s', $this->params['interface'])
				]
			]);
		}
	}


	private function setContent()
	{
		$content = [];

		foreach ($this->items as $htmlElement) {
			if (is_a($htmlElement, 'Avi\HtmlElement')) {
				$content[] = $htmlElement->use();
			}
		}

		$this->content = $content;
	}


}
