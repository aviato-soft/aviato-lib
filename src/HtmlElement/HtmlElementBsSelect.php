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

require_once dirname(__DIR__).'/HtmlElement/HtmlElementBsFormControl.php';

class HtmlElementBsSelect extends HtmlElementBsFormControl
{
	public $items;
//	public $select;

	protected $params;
	protected $tag = 'div';

	private $types = [
		'select',
	];


/**
 *
 * @param array $params
 *
 * @return \Avi\HtmlElementBsInputCheckbox
 */
	public function __construct($params = [], $parent = null)
	{
		$this->params = $params;
		$this->parent = $parent;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}


	public function select($params)
	{
		$this->input->attributes($params);
		$this->setContent();
		return $this;
	}


	protected function parseParams()
	{
		parent::parseParams();

		$this->parseParam('items', []);
		$this->parseParam('label-position', false);
		$this->parseParam('size', false);
		$this->parseParam('valid');
//		$this->parseParam('value');


		$this->input->tag('select', [
			'class' => [
				'form-select'
			]
		], false);
	}





	protected function setAttributes()
	{
		parent::setAttributes();

		//select
		$this->setAttributesSize();

		//label
		$this->setAttributesLabel();
	}


	private function setAttributesLabel()
	{
		if (!$this->params['label']) {
			return;
		}

		if ($this->params['label-position'] === false) {
			if ($this->params['layout'] === 'floating-label') {
				$this->params['label-position'] = 'end';
			} else {
				$this->params['label-position'] = 'start';
			}
		}

		$this->label->setAttrClass($this->getLabelClass());
	}


	private function getLabelClass()
	{
		if ($this->params['label-hidden']) {
			return 'visually-hidden';
		}

		if (in_array($this->params['layout'], ['inline', 'row'], true)) {
			return 'col-form-label';
		}

		if($this->params['layout'] === 'floating-label') {
			return null;
		}

		if($this->params['group'] === true) {
			return 'input-group-text';
		}

		return 'form-label';
	}


	protected function setAttributesSize()
	{
		if (in_array($this->params['size'], AVI_BS_SIZE, true)) {
			$this->input->attributes([
				'class' => [
					sprintf('form-select-%s', $this->params['size'])
				]
			]);

// -feature not tested
//		if ($this->params['layout'] === 'row') {
//				$this->label->attributes([
//					'class' => [
//						sprintf('col-form-label-%s', $this->params['size'])
//					]
///				]);
//			}
		}
	}


	protected function parseElementContent($items = null)
	{
		$this->params['items'] = $items ?? $this->params['items'];
//		$this->parseParams();
		$this->setContent();

		return $this->content;
	}


	private function setContent()
	{
		$content = [];
		if($this->params['label']) {
			$label = $this->label->content($this->params['label']);

			if($this->params['label-position'] === 'start') {
				$content[] = $label;
			}
		}
		$this->parseItems();
		$content[] = $this->input->content(\Avi\Tools::atos($this->items, '<option{disabled}{selected}{value}>{text}</option>'));

		if($this->params['label']) {
			if($this->params['label-position'] === 'end') {
				$content[] = $label;
			}
		}

		if($this->params['help']) {
			$content[] = $this->help->content($this->params['help']);
		}

		//validation feedback
		if ($this->feedback) {
			if(isset($this->feedback['invalid'])) {
				$content[] = $this->feedback['invalid'];
			}

			if(isset($this->feedback['valid'])) {
				$content[] = $this->feedback['valid'];
			}
		}


		$this->content = $content;
	}


	private function parseItems()
	{
		$this->items = [];
		foreach($this->params['items'] as $item) {
			$this->items[] = [
				'disabled' => (isset($item['disabled']) && $item['disabled'] === true) ? ' disabled': '',
				'selected' => ($this->itemIsSelected($item)) ? ' selected' : '',
				'text' => $item['text'] ?? $item['value'] ?? '',
				'value' => isset($item['value']) ? sprintf(' value="%s"', $item['value']): '',
			];
		}
	}


	private function itemIsSelected($item): bool
	{
		if (isset($item['selected']) && $item['selected'] === true) {
			return true;
		}

		if(!isset($item['value'])) {
			return false;
		}

		if (is_null($this->params['value'])) {
			return false;
		}

		if ($this->params['value'] === $item['value']) {
			return true;
		}

		return false;
	}
}