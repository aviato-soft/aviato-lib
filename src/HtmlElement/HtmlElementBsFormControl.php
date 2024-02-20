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

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsFormControl extends HtmlElement
{
	public $input;
	public $label;
	public $help;

	protected $feedback = null;


	public function input(array|string $params)
	{
		$this->params['input'] = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}


	protected function parseParams()
	{
		$this->tag = $this->params['tag'] ?? $this->tag;
		$this->parseParam('id');
		$this->parseParam('layout', $this->parent?->params['layout'] ?? false);
		$this->parseParam('group', false);
		$this->tag = $this->getTagByLayout() ?? $this->tag;

		$this->parseParam('aria-label');
		$this->parseParam('autocomplete');
		$this->parseParam('breakpoint', 'auto');
		$this->parseParam('describedby');
		$this->parseParam('disabled');
		$this->parseParam('feedback');
		$this->parseParam('help');
		$this->parseParam('help-id', sprintf('help-%s', $this->params['id'] ?? 'id'));
		$this->parseParam('input', '');
		$this->parseParam('label');
		$this->parseParam('label-hidden');
//		$this->parseParam('label-position', false);
		$this->parseParam('multiple');
		$this->parseParam('name');
		$this->parseParam('required');
		$this->parseParam('size');
		$this->parseParam('value');

		$this->children();
	}


	protected function setAttributes()
	{
		$this->setAttributesByLayout();
		$this->setAttributesAriaLabel();
		$this->setAttributesDisabled();
		$this->setAttributesFeedback();
		$this->setAttributesId();
		$this->setAttributesHelp();
		$this->setAttributesMultiple();
		$this->setAttributesName();
		$this->setAttributesRequired();
		$this->setAttributesValid();
	}


	private function setAttributesAriaLabel()
	{
		if($this->params['aria-label']) {
			$this->input->attributes([
				'aria' => [
					'label' => $this->params['aria-label']
				]
			]);
		}
	}


	private function setAttributesByLayout()
	{
		if ($this->params['layout'] === 'margin') {
			if ($this->params['group'] === false) {
				$this->setAttrClass('mb-3');
			}
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

		if($this->params['layout'] === 'floating-label') {
			$this->setAttrClass('form-floating');
			return;
		}

		if ($this->params['layout'] === 'inline') {
			$this->setAttrClass('row');
			return;
		}

		if ($this->params['layout'] === 'row') {
			$this->setAttrClass('row');
			$this->setAttrClass('mb-3');

			$breakpoint = explode('-', $this->params['breakpoint']);
			$this->label->attributes([
				'class' => [
					(isset($breakpoint[1])) ?
					sprintf('col-%s-%s', $breakpoint[0], 12 - $breakpoint[1]) :
					sprintf('col-%s', $breakpoint[0])
				]
			]);
			return;
		}

		if (
			$this->params['layout'] === 'row-inline'
			&& !in_array($this->params['type'] ?? '', ['checkbox', 'radio'], true)
		){
			$this->attributes([
				'class' => [
					sprintf('col-%s', $this->params['breakpoint'])
				]
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


	private function setAttributesFeedback()
	{
		if(!$this->params['feedback']) {
			return;
		}

		$feedbackType = ['invalid', 'valid'];
		foreach ($feedbackType as $type) {
			if(isset($this->params['feedback'][$type])) {
				if (!$this->feedback) {
					$this->feedback = [];
				}

				$attr = [];
				$style = (isset($this->params['feedback'][$type]['tooltip'])) ? 'tooltip' : 'feedback';
				$attr['class'] = sprintf('%s-%s', $type, $style);

				if(is_string($this->params['feedback'][$type])) {
					$this->params['feedback'][$type] = [
						'text' => $this->params['feedback'][$type]
					];
				}

				if(isset($this->params['feedback'][$type]['id'])) {
					$attr['id'] = $this->params['feedback'][$type]['id'];
					$this->input->attributes([
						'aria-describedby' => [
							$this->params['feedback'][$type]['id']
						]
					]);
				}

				$this->feedback[$type] = $this->tag('div', $attr)->content($this->params['feedback'][$type]['text']);
			}
		}
	}


	private function setAttributesHelp()
	{
		if ($this->params['help']) {
			$this->input->attributes([
				'aria-describedby' => [
					$this->params['help-id']
				]
			]);
		}

		if ($this->params['describedby']) {
			$this->input->attributes([
				'aria-describedby' => [
						$this->params['describedby']
				]
			]);
		}
	}


	private function setAttributesId()
	{
		if($this->params['id']) {
			$this->input->attributes([
				'id' => $this->params['id']
			]);
		}
	}


	private function setAttributesMultiple()
	{
		if ($this->params['multiple'] === true) {
			$this->input->attributes([
				'multiple'
			]);
		}
	}


	private function setAttributesName()
	{
		if($this->params['name']) {
			$this->input->attributes([
				'name' => $this->params['name']
			]);
		}
	}


	private function setAttributesRequired()
	{
		if($this->params['required']) {
			$this->input->attributes([
				'required'
			]);
		}
	}


	protected function setAttributesSize()
	{
		if (in_array($this->params['size'], AVI_BS_SIZE, true)) {
			$this->input->attributes([
				'class' => [
					sprintf('form-control-%s', $this->params['size'])
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


	private function setAttributesValid()
	{
		if($this->params['valid'] === true) {
			$this->input->setAttrClass('is-valid');
			return;
		}

		if($this->params['valid'] === false) {
			$this->input->setAttrClass('is-invalid');
			return;
		}
	}


	protected function setAttributesValue()
	{
		if(is_string($this->params['value'])) {
			$this->input->attributes([
				'value' => $this->params['value']
			]);
		}
	}


	private function children()
	{
		$this->child('input', 'html-input');

		$this->child('label', 'html-label', [
			'for' => $this->params['id']
		]);

		$this->child('help', ($this->params['layout'] === 'inline') ? 'html-span' : 'html-div', [
			'class' => [
				'form-text'
			],
			'id' => $this->params['help-id'],
		]);
	}


	private function getTagByLayout()
	{
		if (in_array($this->params['layout'], ['floating-label'], true)) {
			return 'div';
		}

		if ($this->params['group'] === true) {
			return '';
		}

		if(in_array($this->params['layout'], ['block', 'checkbox', 'col', 'inline', 'margin', 'radio', 'row', 'row-inline'], true)) {
			return 'div';
		}

		return '';
	}
}