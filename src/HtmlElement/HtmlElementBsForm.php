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

require_once __DIR__.'/HtmlElementBsItems.php';

class HtmlElementBsForm extends HtmlElementBsItems
{

	// children:
	public $items;
	public $params;
	protected $child = '';
	protected $children = [
		'Button',
		'Fieldset',
		'Input',
		'InputCheckbox',
		'InputGroup',
		'InputRadio',
		'InputTextarea',
		'Select',
	];
	protected $tag = 'form';

	/**
	 *
	 * @param array $params
	 * @return \Avi\HtmlElementBsCard
	 */
	public function __construct($params = [], $parent = null)
	{
		parent::__construct($params);
	}

	protected function parseParams()
	{
		$this->parseParam('layout', 'margin');
		$this->parseParam('novalidate');
	}

	protected function parseItems()
	{
		if ($this->params['layout'] === 'row-inline') {
			foreach ($this->items as $k => $item) {
				if (
					is_a($item, 'Avi\HtmlElementBsInputCheckbox') 
					|| is_a($item, 'Avi\HtmlElementBsButton')
				) {
					$params = array_values($this->params['items'][$k])[0] ?? [];

					$this->items[$k] = $this->tag('div', [
						'class' => [
							sprintf('col-%s', $params['breakpoint'] ?? 'auto')
						]
					])->content($item, true);
				}
			}
			return;
		}

		if ($this->params['layout'] === 'row') {
			foreach ($this->items as $k => $item) {
				if (is_a($item, 'Avi\HtmlElementBsButton')) {
					$params = array_values($this->params['items'][$k])[0] ?? [];

					if (is_a($params, 'Avi\HtmlElementBsButton')) {
						return;
					}

					if (($params['breakpoint'] ?? false) !== false) {
						$breakpoint = explode('-', $params['breakpoint']);
					}

					$this->items[$k] = $this->tag('div', [
						'class' => [
							'row'
						]
					])->content(
						$this->tag('div', [
							'class' => [
								sprintf('offset-%s-%s col-%s-%s',
									$breakpoint[0],
									12-$breakpoint[1],
									$breakpoint[0],
									$breakpoint[1]
								)
							]
						])->content($item),
						true
					);
				}
			}
			return;
		}

	}

	protected function setAttributes()
	{
		$this->setAttributesByLayout();
		$this->setAttributesNovalidate();
	}

	private function setAttributesByLayout()
	{
		if (in_array($this->params['layout'], [
			'row-inline'
		], true)) {
			$this->setAttrClass('row');
		}
	}

	private function setAttributesNovalidate()
	{
		if ($this->params['novalidate'] === true) {
			$this->attributes([
				'novalidate'
			]);
		}
	}

}
