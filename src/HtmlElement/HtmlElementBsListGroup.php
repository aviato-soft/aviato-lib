<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.11
 * @since  2024-06-26 13:20:45
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

	/**
	 *
	 * @param array|string $params can be a string re[resemting the bootstrap icon slug
	 *        |- flush = false | true = remove rounded corners and external border
	 *        |- horizontal = false | AVI_BS_BREAKPOINT - display list horizontally starting with breackpoint
	 *        |- items = [Avi\HtmlElementBsListGroupItem]
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
				$items[] = $item -> attributes([
					'class' => [
						'list-group-item'
					]
				]);
			} else {
				if ($this->params['template-text'] !== false) {
					$item['template'] = $this->params['template-text'];
				}
				$items[] = $this->element('BsListGroupItem', $item);
			}
		}
		return $items;
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


	protected function parseElementContent($content = null)
	{
		if (is_array($content)) {
			$this->params['items'] = $content;
			$this->parseParams();
			$this->setContent();
		}

		return $this->content;
	}


	private function setContent()
	{
		$content = [];

		if ($this->params['template'] !== false) {
			$content = \Avi\Tools::atos($this->params['items'], $this->params['template']);;
		} else {
			foreach ($this->items as $htmlElement) {
				if (is_a($htmlElement, 'Avi\HtmlElement')) {
					$content[] = $htmlElement->use();
				}
			}
		}

		$this->content = $content;
	}
}
