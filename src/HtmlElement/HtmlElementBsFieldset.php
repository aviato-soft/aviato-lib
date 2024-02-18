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

require_once __DIR__.'/HtmlElementBsItems.php';

class HtmlElementBsFieldset extends HtmlElementBsItems
{

	//children:
	public $items;
	public $legend;
	public $params;

	protected $child = '';
	protected $children = [
		'Button',
		'InputCheckbox',
		'InputRadio',
		'Input',
		'Select'
	];
	protected $tag = 'fieldset';

/**
 *
 * @param array $params
 * @return \Avi\HtmlElementBsCard
 */
	public function __construct($params = [], $parent = null)
	{
		parent::__construct($params);
		return $this;
	}


	protected function parseParams()
	{
		$this->parseParam('layout', $this->params['parent']['layout'] ?? false);

		$this->parseParam('disabled');
		$this->parseParam('legend');
		if(is_string($this->params['legend'])) {
			$this->params['legend'] = [
				'text' => $this->params['legend']
			];
		}
		$this->child('legend', 'html-legend');
		$this->setLegendAttributes();

	}


	protected function parseItems()
	{
		if (is_a($this->legend, 'Avi\HtmlElement')) {
			$this->legend->content($this->params['legend']['text']);
			$this->items = array_merge([
				$this->legend
			], $this->items);
		}
	}


	protected function setAttributes()
	{
		$this->setAttributesByLayout();
		$this->setAttributesDisabled();
	}


	private function setLegendAttributes()
	{
		if ($this->params['layout'] === 'row') {
			$breakpoint = explode('-', $this->params['breakpoint']);
			$this->legend->attributes([ //legend
				'class' => [
					'col-form-label',
					sprintf('col-%s-%s', $breakpoint[0], 12 - $breakpoint[1])
				]
			]);
		}
	}


	private function setAttributesByLayout()
	{
/*
		if ($this->params['layout'] === 'margin') {
			$this->setAttrClass('mb-3');
			return;
		}

		if ($this->params['layout'] === 'col') {
			if ($this->params['breakpoint'] === 'auto') {
				$this->setAttrClass('col');
			} else {
				$this->setAttrClass(sprintf('col-%s', $this->params['breakpoint']));
			}
			return;
		}
*/
		if ($this->params['layout'] === 'row') {
			$this->setAttrClass('row');
			$this->setAttrClass('mb-3');

			return;
		}
/*
		if ($this->params['layout'] === 'row-inline') {
			$this->attributes([
				'class' => [
					sprintf('col-%s', $this->params['breakpoint'])
				]
			]);
			return;
		}
*/
	}


	private function setAttributesDisabled()
	{
		if ($this->params['disabled']) {
			$this->attributes([
				'disabled'
			]);
		}
	}


}
