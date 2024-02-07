<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.01
 * @since  2024-02-07 19:54:26
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once __DIR__.'/HtmlElementBsItems.php';

class HtmlElementBsInputGroup extends HtmlElementBsItems
{

	private $fileId = false;
	private $help = false;
	private $helpId = false;
	private $label = false;
	private $labelId = false;
	private $inputId = false;
	private $selectId = false;

	//children:
	public $items;
	public $params;

	protected $child = '';
	protected $children = [
		'Button',
		'Dropdown',
		'InputCheckbox',
		'InputGroupText',
		'InputRadio',
		'Input',
		'InputTextarea',
		'Select',
	];
	protected $tag = 'div';

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


	//set params and params for items
	protected function parseParams()
	{
		$this->parseParam('layout', $this->params['parent']['layout'] ?? null);
		$this->parseParam('breakpoint', 'auto');
		$this->parseParam('disabled');
		$this->parseParam('nowrap');
		$this->parseParam('size', false);

		if (!isset($this->params['items'])) {
			return;
		}

		foreach($this->params['items'] as $k => $item) {
			foreach ($item as $type => $element) {
// - not tested
//				if (is_a($this->params['items'][$k], 'Avi\HtmlElement')) {
//					$this->params['items'][$k]->parseParam('group', true);
//				}

				if (is_array($this->params['items'][$k])){
					$this->params['items'][$k][$type]['group'] = true;

					if(ucfirst($type) === 'Button') {
						$this->params['items'][$k][$type] =  \Avi\Tools::applyDefault(
							$this->params['items'][$k][$type],
							[
								'outline' => true,
								'variant' => 'secondary'
							]
						);
					}

					if(ucfirst($type) === 'Dropdown') {
						$this->params['items'][$k][$type]['button'] = \Avi\Tools::applyDefault(
							$this->params['items'][$k][$type]['button'],
							[
								'outline' => true,
								'variant' => 'secondary'
							]
						);
						if(
							isset($this->params['items'][$k][$type]['split'])
							&& is_array($this->params['items'][$k][$type]['split'])
						) {
							$this->params['items'][$k][$type]['split'] = \Avi\Tools::applyDefault(
								$this->params['items'][$k][$type]['split'],
								[
									'outline' => true,
									'variant' => 'secondary'
								]
							);
						}
						$this->params['items'][$k][$type]['layout'] = $this->params['layout'] ?? 'input-group';
					}

					if(ucfirst($type) === 'Select') {
						$this->selectId = $k;
					}

					if(ucfirst($type) === 'Input') {
						$this->inputId = $k;

						if (($this->params['items'][$k][$type]['type'] ?? false) === 'file') {
							$this->fileId = $k;
						}
					}

					if(isset($element['help'])) {
						$this->helpId = $k;
					}

					if(isset($element['label']) && ($element['layout'] ?? false) !== 'floating-label') {
						$this->labelId = $k;
					}
				}
			}
		}
	}

	//set attributes for items
	protected function parseItems()
	{
		if($this->helpId) {
			$this->help = $this->items[$this->helpId]->help;
		}
		if($this->labelId) {
			$this->label = $this->items[$this->labelId]->label;
		}

		if ($this->hasLabelOrHelp() && $this->selectId === false && $this->fileId === false) {
			$this->parseGroupItems();
		}

		if($this->selectId !== false) {
			$this->parseGroupItemSelect();
		}

		if($this->fileId !== false) {
			$this->parseGroupItemInputFile();
		}
	}


	private function hasLabelOrHelp()
	{
		return (is_a($this->help, 'Avi\HtmlElement') || is_a($this->label, 'Avi\HtmlElement'));
	}


	private function parseGroupItems()
	{
		$items = [];
		$group = [];

		foreach($this->items as $k => $item) {
			$group[] = $item->use();
		}

		//add label:
		if(is_a($this->label, 'Avi\HtmlElement')) {
			$items[] = $this->label;
		}

//		if(($this->params['debug']??false) === true) {
//			var_dump($this->params['items'][$k]);
//		}

//		if(is_a((Avi\HtmlElementBsSelect))
		$attrClass = [
			'input-group'
		];
		if(isset($this->params['items'][$k]['input']['feedback'])) {
			$attrClass[] = 'has-validation';
		}
		$items[] = $this
			->tag('div')
			->attributes([
				'class' => $attrClass
			])
			->content($group, true);

		//add help:
		if(is_a($this->help, 'Avi\HtmlElement')) {
			$items[] = $this->help;
		}

		$this->items = $items;
	}


	private function parseGroupItemSelect()
	{
		$this->setAttrClass('input-group');
	}


	private function parseGroupItemInputFile()
	{
		$this->setAttrClass('input-group');
	}



	//set attributes for main
	protected function setAttributes()
	{
		$this->setAttributesByLayout();
//		$this->setAttributesDisabled();
		$this->setAttributeNowrap();
		$this->setAttributeSize();

		if (!$this->hasLabelOrHelp()) {
			$this->setAttrClass('input-group');
		}
	}


	private function setAttributesByLayout()
	{
		if ($this->params['layout'] === 'margin') {
			$this->setAttrClass('mb-3');
			return;
		}

// - not tested feature
//		if ($this->params['layout'] === 'col') {
//			if ($this->params['breakpoint'] === 'auto') {
//				$this->setAttrClass('col');
//			} else {
//				$this->setAttrClass(sprintf('col-%s', $this->params['breakpoint']));
//			}
//			return;
//		}

// - not tested feature
//		if ($this->params['layout'] === 'row') {
//			$this->setAttrClass('row');
//			$this->setAttrClass('mb-3');

//			$breakpoint = explode('-', $this->params['breakpoint']);
//			$this->label->attributes([
//				'class' => [
//					(isset($breakpoint[1])) ?
//					sprintf('col-%s-%s', $breakpoint[0], 12 - $breakpoint[1]) :
//					sprintf('col-%s', $breakpoint[0])
//				]
//			]);
//			return;
//		}

		if ($this->params['layout'] === 'row-inline') {
			$this->attributes([
				'class' => [
					sprintf('col-%s', $this->params['breakpoint'])
				]
			]);
			return;
		}
	}


// - not tested feature
//	private function setAttributesDisabled()
//	{
//		if ($this->params['disabled'] === true) {
//			$this->attributes([
//				'disabled'
//			]);
//		}
//	}


	private function setAttributeNowrap()
	{
		if ($this->params['nowrap'] === true) {
			$this->setAttrClass('flex-nowrap');
		}
	}


	private function setAttributeSize()
	{
		if (in_array($this->params['size'], AVI_BS_SIZE, true)) {
			$this->setAttrClass(sprintf('input-group-%s', $this->params['size']));
		}
	}



}
