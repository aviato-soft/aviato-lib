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

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsInputCheckbox extends HtmlElement
{
	public $input;
	public $label;

	protected $params;

	private $types = [
		'button',
		'form-ckeck'
	];



	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}


	private function parseParams()
	{
		$this->parseParam('id', false);
		$this->parseParam('type', 'form-check');
		$this->tag = $this->params['tag'] ?? $this->getTagByType();

		$this->parseParam('checked', false);
		$this->parseParam('disabled', false);
		$this->parseParam('inline', false);
		$this->parseParam('label', 'Checkbox');
		if ($this->params['label'] === false) {
			$this->parseParam('aria-label','Checkbox');
		}
		$this->parseParam('outline', false);
		$this->parseParam('reverse', false);
		$this->parseParam('switch', false);
		$this->parseParam('value');
		$this->parseParam('variant', false);
		$this->params['input']='';


		$this->child('input', 'html-input', [
			'id' => $this->params['id'],
			'type' => 'checkbox'
		]);

		$this->child('label', 'html-label', [
			'for' => $this->params['id']
		]);

	}


	private function getTagByType()
	{
		if(in_array($this->params['type'], ['form-check'], true)) {
			return 'div';
		}

		return '';
	}


	private function setAttributes()
	{

		if($this->params['type'] === 'form-check') {
			$this->setAttributesFormCheck();
		}

		if($this->params['type'] === 'button') {
			$this->setAttributesButton();
		}

		//input
		$this->setAttributesChecked();
		$this->setAttributesDisabled();
		$this->setAttributesInline();
		$this->setAttributesReverse();
		$this->setAttributesSwitch();
		if($this->params['value'] !== null) {
			$this->setAttributesValue();
		}

		//label
		if($this->params['label'] !== null) {
			$this->setAttributesLabel();
		}
	}


	private function setAttributesChecked()
	{
		if($this->params['checked'] === true) {
			$this->input->attributes([
				'checked'
			]);
		}
	}


	private function setAttributesDisabled()
	{
		if($this->params['disabled'] === true) {
			$this->input->attributes([
				'disabled'
			]);
		}
	}


	private function setAttributesButton()
	{
		$this->input->attributes([
			'autocomplete' => 'off',
			'class' => 'btn-check',
		]);

		$class = ['btn'];
		if (in_array($this->params['variant'], AVI_BS_COLOR, true)) {
			$class[] = sprintf('btn%s-%s', $this->params['outline'] ? '-outline' : '', $this->params['variant']);
		}
		$this->label->attributes([
			'class' => $class
		]);
	}


	private function setAttributesFormCheck()
	{
		if ($this->params['label'] !== false) {
			$this->attributes['class'] = ['form-check'];
		} else {
			if ($this->params['aria-label'] !== '') {
				$this->input->attributes([
					'aria' => [
						'label' => $this->params['aria-label']
					]
				]);
			}

		}
		$this->input->attributes([
			'class' => [
				'form-check-input'
			]
		]);
		$this->label->attributes([
			'class' => [
				'form-check-label'
			]
		]);
	}


	private function setAttributesInline()
	{
		if($this->params['inline'] === true) {
			$this->attributes['class'][] = 'form-check-inline';
		}
	}


	private function setAttributesReverse()
	{
		if($this->params['reverse'] === true) {
			$this->attributes['class'][] = 'form-check-reverse';
		}
	}


	private function setAttributesSwitch()
	{
		if($this->params['switch'] === true) {
			$this->attributes['class'][] = 'form-switch';
			$this->input->attributes([
				'role' => 'switch'
			]);
		}
	}


	private function setAttributesLabel()
	{
		if ($this->params['label'] !== false) {
			$this->label->content($this->params['label']);
		}
	}


	private function setAttributesValue()
	{
		$this->input->attributes([
			'value' => $this->params['value']
		]);
	}


	private function setContent()
	{
		$content = [];
		$content[] = $this->input->use();
		if($this->params['label'] !== false) {
			$content[] = $this->label->use();
		}
		$this->content = $content;
	}
}