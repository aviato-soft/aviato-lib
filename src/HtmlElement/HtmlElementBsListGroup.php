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
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsListGroup extends HtmlElement
{
	protected $params;

	public $items;

	private $tplItem = [
		'a' => [
			'<a ',
			'{aria-active}{aria-disabled}',
			'class="{class-active}{class-disabled}list-group-item list-group-item-action{list-group-color}"',
			'{href}',
			'>',
			'{text}',
			'</a>'
		],
		'button' => [
			'<button ',
			'{aria-active}',
			'class="{class-active}list-group-item list-group-item-action{list-group-color}" ',
			'{class-disabled}type="button">',
			'{text}',
			'</button>'
		],
		'li' => [
			'<li ',
			'{aria-active}{aria-disabled}',
			'class="{class-active}{class-disabled}list-group-item{list-group-color}"',
			'>',
			'{text}',
			'</li>'
		]
	];
	/**
	 *
	 * @param array|string $params can be a string re[resemting the bootstrap icon slug
	 *        |- flush = false | true = remove rounded corners and external border
	 *        |- horizontal = false | AVI_BS_BREAKPOINT - display list horizontally starting with breackpoint
	 *        |- items = array
	 *        |- template = false | string = custom template for items
	 *        |- template-text = false | string = custom template for item / text
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
		$this->tag = $this->params['tag'] ?? 'ul';

		$this->parseParam('flush', false);
		$this->parseParam('horizontal', false);
		$this->parseParam('items', false);
		$this->parseParam('template', false);
		$this->parseParam('template-text', false);
	}


	private function parseItemsbyTemplate()
	{
		return \Avi\Tools::atos($this->items, $this->params['template']);
	}


	private function parseItems()
	{
		if (!is_countable($this->items)) {
			return '';
		}
		$content = [];
		foreach($this->items as $item) {
			if (is_string($item)) {
				$item = [
					'text' => $item
				];
			}

			if(isset($item['tag']) && $item['tag'] !== 'li') {
				$this->tag = 'div';
			}

			if(isset($item['active']) && $item['active'] === true) {
				$item['class-active'] = 'active ';
				$item['aria-active'] = 'aria-current="true" ';
			} else {
				$item['class-active'] = '';
				$item['aria-active'] = '';
			}

			if(isset($item['color']) && in_array($item['color'], AVI_BS_COLOR, true)) {
				$item['list-group-color'] = sprintf(' list-group-item-%s', $item['color']);
			} else {
				$item['list-group-color'] = '';
			}

			if(isset($item['disabled']) && $item['disabled'] === true) {
				$item['class-disabled'] = 'disabled ';
				$item['aria-disabled'] = 'aria-disabled="true" ';
			} else {
				$item['class-disabled'] = '';
				$item['aria-disabled'] = '';
			}

			if(isset($item['tag']) && $item['tag'] === 'a') {
				if (isset($item['href'])) {
					$item['href'] = sprintf(' href="%s"', $item['href']);
				} else {
					$item['href'] = '';
				}
			}

			if(is_string($this->params['template-text'])) {
				$item['text'] = \Avi\Tools::sprinta($this->params['template-text'], $item['text']);
			}

			if (is_array($item['text'])) {
				$item['text'] = implode('', $item['text']);
			}

			$tplItem = implode('', $this->tplItem[$item['tag'] ?? 'li']);
			$content[] = \Avi\Tools::sprinta($tplItem, $item);
		}
		return implode('', $content);
	}


	private function setAttributes()
	{
		$this->setAttributeFlush();
		$this->setAttributeHorizontal();
		$this->attributes([
			'class' => 'list-group'
		]);
		if ($this->tag === 'ol') {
			$this->attributes([
				'class' => 'list-group-numbered'
			]);
		}
	}


	private function setAttributeFlush()
	{
		if($this->params['flush']) {
			$this->attributes([
				'class' => [
					'list-group-flush'
				]
			]);
		}
	}


	private function setAttributeHorizontal()
	{
		if($this->params['horizontal'] === true || $this->params['horizontal'] === 'xs') {
			$this->attributes([
				'class' => [
					'list-group-horizontal'
				]
			]);
			return;
		}

		if(in_array($this->params['horizontal'], AVI_BS_BREAKPOINT, true)) {
			$this->attributes([
				'class' => [
					sprintf('list-group-horizontal-%s',$this->params['horizontal'])
				]
			]);
		}
	}


	protected function parseElementContent()
	{
		if (is_array($this->content)) {
			$this->items = $this->content;
		}
		$this->setContent();
		return $this->content;
	}


	private function setContent()
	{
		$this->items = ($this->params['items'] === false)? $this->content: $this->params['items'];
		$this->content = (is_string($this->params['template'])) ? $this->parseItemsbyTemplate(): $this->parseItems();
	}
}
