<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.07
 * @since  2024-02-20 20:32:40
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
		$this->setAttributesAutocomplete();
		$this->setAttributesSize();


		//label
		$this->setAttributesLabel();
	}


	private function setAttributesAutocomplete()
	{
		if ($this->params['autocomplete'] === false) {
			return;
		}

		if ($this->params['autocomplete']) {
			$this->input->attributes([
				'autocomplete' => $this->params['autocomplete']
			]);
		}
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

		if ($this->params['layout'] === 'row') {
				$this->label->attributes([
					'class' => [
						sprintf('col-form-label-%s', $this->params['size'])
					]
				]);
			}
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
		$this->content = [];
		$content = $this->getContentByLayout();

		//label
		if($this->params['label-position'] === 'start') {
			$this->content[] = $content['label'];
		}

		$this->content[] = $content['input'];

		//put the label after the input for button type:
		if($this->params['label-position'] === 'end') {
			$this->content[] = $content['label'];
		}

		//help
		if($this->params['help']) {
			$this->content[] = $content['help'];
		}

		//validation feedback
		if($this->params['feedback']) {
			$this->content[] = $content['feedback'];
		}

	}


	private function getContentByLayout()
	{
		$content = [
			'feedback' => null,
			'help' => null,
			'input' => null,
			'label' => null,
		];

		if ($this->feedback) {
			if(isset($this->feedback['invalid'])) {
				$content['feedback'] = $this->feedback['invalid'];
			}

			if(isset($this->feedback['valid'])) {
				$content['feedback'] = $this->feedback['valid'];
			}
		}

		//help
		if($this->params['help']) {
			$content['help'] = $this->help->content($this->params['help']);
		}

		//select
		$input = $this->input->content($this->parseItems());
		if (in_array($this->params['layout'], ['inline', 'row'], true)) {
			$input .= ($content['help'] ?? '').($content['feedback'] ?? '');
			$this->params['breakpoint'] = $this->params['breakpoint'] ?? 'auto' ;
			$content['input'] = $this->tag('div')
				->attributes([
					'class' => [
						sprintf('col-%s', $this->params['breakpoint'])
					]
				])
				->content($input);
			$content['feedback'] = null;
			$content['help'] = null;
		} else {
			$content['input'] = $input;
		}

		//label
		if($this->params['label']) {
			$label = $this->label->content($this->params['label']);

			if($this->params['layout'] === 'inline') {
				$content['label'] = $this->tag('div')
					->attributes([
						'class' => [
							'col-auto'
						]
					])
					->content($label);
			} else {
				$content['label'] = $label;
			}
		} else {
			$this->params['label-position'] = false;
		}

		return $content;
	}


	private function parseItems()
	{
		$this->items = [];
		foreach($this->params['items'] as $item) {
			$attr = [];
			if (($item['disabled'] ?? false) === true) {
				$attr[] = 'disabled';
			}
			if (($this->itemIsSelected($item))) {
				$attr[] = 'selected';
			}
			if (isset($item['value'])) {
				$attr['value'] = $item['value'];
			}
			$this->items[] = $this->tag('option', $attr)->content($item['text'] ?? $item['value'] ?? '');
		}

		return $this->items;
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