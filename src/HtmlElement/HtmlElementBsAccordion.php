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

require_once __DIR__.'/HtmlElementBsItems.php';

class HtmlElementBsAccordion extends HtmlElementBsItems
{
	public $items;

//	protected $child = '';
	protected $params;
	protected $tag = 'div';

	/**
 	 *
 	 * @param array $params
	 *
	 * @param array $params
	 * 		|- items
	 * 		| |- id = the item id
	 * 		| |- label = the header of the items always visible
	 * 		| |- text = the item content
	 * 		| |- always-open = [false | true] = this item will not close on opening othe item
	 * 		| |- expanded = [false | true ] = this item is epanded
	 * 		|- flush = [false | true ] = show the other borders
	 * 		|- id = the accordion id
	 *
	 * @param \Avi\HtmlElement|null $parent
	 *
	 * @return \Avi\HtmlElementBsAccordion
	 */
	public function __construct($params = [], $parent = null)
	{
		parent::__construct($params);
	}


	protected function parseParams()
	{
		$this->tag = $this->params['tag'] ?? $this->tag;

		$this->parseParam('items', []);

		$this->parseParam('flush');
		$this->parseParam('id');

		$this->items = [];
	}


	protected function parseItems()
	{
		foreach($this->params['items'] as $param) {

			$param['expanded'] = $param['expanded'] ?? false;

			$header = $this->tag('h2', ['class' => 'accordion-header'])
				->content(
					$this->tag('button', [
						'aria' => [
							'controls' =>  $param['id'],
							'expanded' => ($param['expanded']) ? 'true' : 'false'
						],
						'class' => [
							'accordion-button',
							($param['expanded']) ? null : 'collapsed'
						],
						'data' => [
							'bs-toggle' => 'collapse',
							'bs-target' => sprintf('#%s', $param['id']),
						],
						'type' => 'button'
					])
					->content($param['label'])
				);

			$attrBody = [
				'class' => [
					'accordion-collapse',
					'collapse',
					($param['expanded']) ? 'show' : null
				],
				'id' => $param['id']
			];
			if (($param['always-open'] ?? false) !== true) {
				$attrBody = array_merge($attrBody, [
					'data' => [
						'bs-parent' => sprintf('#%s', $this->params['id'])
					]
				]);
			}
			$body = $this->tag('div', $attrBody)->content(
				$this->tag('div', [
					'class' => 'accordion-body'
				])->content($param['text'])
			);

			$this->items[] = $this->tag('div', [
				'class' => 'accordion-item'

			])
			->content([
					$header,
					$body
				], true
			);
		}
	}


	protected function setAttributes()
	{
		$this->setAttributeByParam('id');
		$this->setAttributeFlush();
		$this->attributes['class'][] = 'accordion';
	}


	private function setAttributeFlush()
	{
		if($this->params['flush']) {
			$this->attributes['class'][] = 'accordion-flush';
		}
	}
}