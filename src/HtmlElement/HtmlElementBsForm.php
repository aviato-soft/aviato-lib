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

class HtmlElementBsForm extends HtmlElementBsItems
{

	//children:
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

		if($this->params['layout'] === 'row-inline') {
			foreach($this->items as $k => $item) {
				if (
					is_a($item, 'Avi\HtmlElementBsInputCheckbox')
					|| is_a($item, 'Avi\HtmlElementBsButton')
				) {
/*
					if(($this->params['debug'] ?? false) === true){

						print_r(key($this->params['items'][$k]));
						print_r(array_values($this->params['items'][$k]));
					}
*/
					$params = array_values($this->params['items'][$k])[0] ?? [];

//					if(($this->params['debug'] ?? false) === true){
//						var_dump($params);
//					}
					$this->items[$k] = $this->tag('div', [
						'class' => [
							sprintf('col-%s', $params['breakpoint'] ?? 'auto')
						]
					])
					->content($item, true);
				}
			}
		}

//		if(($this->params['debug'] ?? false) === true) {
//			var_dump($this->items);
//		}
	}

	protected function setAttributes()
	{
		$this->setAttributesByLayout();
		$this->setAttributesNovalidate();
	}


	private function setAttributesByLayout()
	{
		if(in_array($this->params['layout'], ['row-inline'], true)) {
			$this->setAttrClass('row');
		}
	}


	private function setAttributesNovalidate()
	{
		if($this->params['novalidate'] === true) {
			$this->attributes([
				'novalidate'
			]);
		}
	}



}
