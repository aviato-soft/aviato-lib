<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.00
 * @since  2024-02-06 21:30:40
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once __DIR__.'/HtmlElementBsItems.php';

class HtmlElementBsBreadcrumb extends HtmlElementBsItems
{

	protected $tag = 'nav';
/**
 *
 * @param array $params
 * @return \Avi\HtmlElementBsBreadcrumb
 */
	public function __construct($params = [], $parent = null)
	{
		parent::__construct($params);
		return $this;
	}


	protected function parseParams()
	{
		$this->parseParam('divider');
	}

/**
 * Items:
 * 		|- href
 * 		|- active
 * 		|- text
 * {@inheritDoc}
 * @see \Avi\HtmlElementBsItems::parseItems()
 */
	protected function parseItems()
	{
		$items = [];

		if (!is_countable($this->params['items']) || count($this->params['items']) === 0) {
			return $items;
		}

		foreach($this->params['items'] as $k=>$v) {

			$content = isset($v['href']) ?
				$this->tag('a', [
					'href' => $v['href']
				])->content($v['text']) :
				$v['text'];

			$item = $this->tag('li', [
				'class' => [
					'breadcrumb-item'
				]
			])->content($content, true);
			$items[] = $item;
		}

		//last element is alwais active:
		$items[$k]->attributes([
			'aria' => [
				'current' => 'page'
			],
			'class' => [
				'active'
			]
		]);

		$this->items = $items;
	}


	protected function setAttributes()
	{
		$this->setAttributesDivider();
		$this->attributes['aria']['label'] = 'breadcrumb';
//		$this->setAttributesByLayout();
//		$this->setAttributesDisabled();
	}


	protected function setContent()
	{
		parent::setContent();

		$this->content = $this->tag('ol', [
				'class' => 'breadcrumb'
			])
			->content($this->content);
	}


	private function setAttributesDivider()
	{
		if(is_string($this->params['divider'])) {
			if (strlen($this->params['divider']) <= 1) {
				$this->params['divider'] = sprintf("'%s'", $this->params['divider']);
			}

			$this->attributes([
				'style' => [
					sprintf('--bs-breadcrumb-divider: %s;', $this->params['divider'])
				]
			]);
		}
	}

}

