<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.25
 * @since  2023-12-27 12:33:50
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once __DIR__.'/HtmlElementBsItems.php';

class HtmlElementBsPagination extends HtmlElementBsItems
{

	protected $tag = 'nav';
/**
 *
 * @param array $params
 * @return \Avi\HtmlElementBsPagination
 */
	public function __construct($params = [], $parent = null)
	{
		parent::__construct($params);
		return $this;
	}


	protected function parseParams()
	{
		$this->parseParam('active');
		$this->parseParam('active-tag', 'a');
		$this->parseParam('align', 'start'); // start | center | end
		$this->parseParam('count', 1);
		$this->parseParam('controlls', true); //true | false | icons
		$this->parseParam('previous-label', 'Previous');
		$this->parseParam('next-label', 'Next');
		$this->parseParam('size');
		$this->parseParam('smart', true);

//		$this->parseParam('divider');
/*
		$this->parseParam('layout', $this->params['parent']['layout'] ?? false);

		$this->parseParam('disabled', false);
		$this->parseParam('legend', false);
		if(is_string($this->params['legend'])) {
			$this->params['legend'] = [
				'text' => $this->params['legend']
			];
		}
		$this->child('legend', 'html-legend');
		$this->setLegendAttributes();
*/
	}

/**
 * Items:
 * 		|- href
 * 		|- active
 * 		|- disabled
 * @see \Avi\HtmlElementBsItems::parseItems()
 */
	protected function parseItems()
	{
		$items = [];

		if ($this->params['count'] <= 1) {
			return $items;
		}

		$items[] = $this->parseControl('previous');

		if ($this->params['smart'] && $this->params['count'] > 11) {
			$items = array_merge($items, $this->parseItemsSmart());
		} else {
			for($i = 1; $i <= $this->params['count']; $i++) {
				$items[] = $this->parseItem($i);
			}
		}

		$items[] = $this->parseControl('next');

		$this->items = $items;
	}


	private function parseItemsSmart()
	{
		$items = [];
		/*
		 * 01 02 03 04 05 06 07 08 09 10 11 12 13 14 15 ... 98 99
		 *
		 * (01)02 03]..                           [98 99]
		 * [01(02)03 04]..                        [98 99]
		 * |01 02(03) 04 05]..                    [98 99]
		 * [01|02 03(04)05 06]..                  [98 99]
		 * [01 02|03 04(05)06 07]...              [98 99]
		 * [01 02]..[04 05(06)07 08]...           [98 99]
		 * [01 02]..   [05 06(07)08 09]...        [98 99]
		 * [01 02]..      [06 07(08)09 10]...     [98 99]
		 *
		 * [01 02]..            [92 93(94)95 96]..[98 99]
		 * [01 02]..               [93 94(95)96 97|98 99]
		 * [01 02]..                  [94 95(96)97 98|99]
		 * [01 02]..                     [95 96(97)98 99|
		 * [01 02]..                        [96 97(98)99]
		 * [01 02]..                           [97 98(99)
		 */
		// 1st section:
		// 1 2 3 ...
		$start = 1;
		$end = 3;
		for ($i = $start; $i <= $end; $i++) {
			$items[] = $this->parseItem($i);
		}
		// 1st separator
		if ($this->params['active'] > 6) {
			$items[] = $this->parseItemDivider();
		}

		// 2nd section
		// ... [i-2 i-1 (i) i+1 i+2] ...
		$start = max(4, $this->params['active'] - 2);
		$end = min($this->params['active'] + 2, $this->params['count'] - 3);
		for ($i = $start; $i <= $end; $i++) {
			$items[] = $this->parseItem($i);
		}
		// 2nd separator
		if ($this->params['active'] < $this->params['count'] - 5) {
			$items[] = $this->parseItemDivider();
		}

		// 3rd section:
		// ... n-2 n-1 n
		$start = $this->params['count'] - 2;
		$end = $this->params['count'];
		for ($i = $start; $i <= $end; $i++) {
			$items[] = $this->parseItem($i);
		}

		return $items;
	}


	private function parseItemDivider()
	{
		return $this->tag('li', [
			'class' => [
				'fw' => 'bold'
			]
		])->content('&nbsp;...&nbsp;', true);
	}


	private function parseItem($page)
	{
		$label = strval($page);

		$link = $this->tag('a', [
			'class' => [
				'page-link'
			]
		]);

		if($this->params['active'] === $page && $this->params['active-tag'] === 'span') {
			$link->tag('span', null, false);
		} else {
			$link->attributes([
				'href' => $this->parseItemHref($page)
			]);
		}

		$item = $this->tag('li', [
			'class' => [
				'page-item'
			]
		]);

		//active link:
		if($this->params['active'] === $page) {
			$item->attributes([
				'aria' => [
					'current' => 'page'
				],
				'class' => [
					'active'
				]
			]);
		}

		$item->content($link->content($label));

		return $item;
	}


	private function parseItemHref($page)
	{
		return \Avi\Tools::sprinta(
			$this->params['href'],
			[
			'page' => $page
		]);
	}


	private function parseControl($type)
	{
		if ($this->params['controlls'] === false) {
			return '';
		}

		$page = $this->params['active'] + (($type === 'previous') ? -1 : +1);


		$label = ($this->params['controlls'] === 'icons') ?
		$this->tag('span', [
			'aria' => [
				'hidden' => 'true'
			]
			])->content(($type === 'previous') ? '&laquo;' : '&raquo;') :
		$this->params[$type.'-label'];

		$link = $this->tag('a', [
			'class' => 'page-link'
		]);

		//href only if not disable
		$isDisabled = false;
		$isDisabled = $isDisabled || ($type === 'previous' && $this->params['active'] === 1);
		$isDisabled = $isDisabled || ($type === 'next' && $this->params['active'] === $this->params['count']);

		if($isDisabled) {
			if($this->params['active-tag'] === 'span') {
				$link->tag('span', null, false);
			}
		} else {
			$link->attributes([
				'href' => $this->parseItemHref($page)
			]);
		}

		//arrows instead of labels:
		if ($this->params['controlls'] === 'icons') {
			$link->attributes([
				'aria' => [
					'label' => $this->params[$type.'-label']
				]
			]);
		}

		$link->content($label);

		$item = $this->tag('li', [
			'class' => [
				'page-item'
			]
		])->content($link->use(), true);

		if($isDisabled) {
			$item->attributes([
				'class' => 'disabled'
			]);
		}

		return $item;
	}



	protected function setAttributes()
	{
//		$this->setAttributesDivider();
//		$this->attributes['aria']['label'] = 'breadcrumb';
//		$this->setAttributesByLayout();
//		$this->setAttributesDisabled();
	}


	protected function setContent()
	{
		parent::setContent();

		$list = $this->tag('ul', [
			'class' => 'pagination'
		]);

		//Size
		if (in_array($this->params['size'], AVI_BS_SIZE, true)) {
			$list->attributes([
				'class' => sprintf('pagination-%s', $this->params['size'])
			]);
		}

		//Align
		if (in_array($this->params['align'], ['center', 'end'], true)) {
			$list->attributes([
				'class' => sprintf('justify-content-%s', $this->params['align'])
			]);
		}


		$this->content = $list->content($this->content);

	}

/*
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
*/
}

