<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.10
 * @since  2024-06-25 19:26:53
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once __DIR__.'/HtmlElementBsInput.php';

class HtmlElementBsInputRadio extends HtmlElementBsInput
{

	private $roles = [
		'button',
		'form-ckeck'
	];


/**
 *
 ** @param array $params
 *
 * @return \Avi\HtmlElementBsInputRadio
 */
	public function __construct($params = [], $parent = null)
	{
		parent::__construct($params, $parent);
		return $this;
	}


	protected function parseParams()
	{
		$this->parseParam('layout', $this->params['parent']['layout'] ?? 'radio');
		$this->parseParam('name', 'radio');
		$this->parseParam('role', 'form-check');
		$this->params['type'] = 'radio';
		$this->parseParam('label-position', 'end');

		parent::parseParams();

		$this->tag = ($this->params['group'] === true) ? 'div' : $this->tag;
		$this->tag = ($this->params['role'] === 'form-check') ? $this->tag : '';

		$this->parseParam('checked', false);
		$this->parseParam('inline', false);
		$this->parseParam('outline', false);
		$this->parseParam('variant', false);
	}


	protected function setAttributes()
	{
		parent::setAttributes();

		$this->setAttributesByGroup();

		if($this->params['role'] === 'form-check') {
			$this->setAttributesFormCheck();
		}

		if($this->params['role'] === 'button') {
			$this->setAttributesButton();
		}

		//input
		$this->setAttributesChecked();
		$this->setAttributesInline();
	}


	private function setAttributesByGroup()
	{
		if($this->params['group'] === true) {
			$this->setAttrClass('input-group-text');

			$this->input->attributes([
				'class' => [
					'mt-0'
				]
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


	private function setAttributesChecked()
	{
		if($this->params['checked'] === true) {
			$this->input->attributes([
				'checked'
			]);
		}
	}



	private function setAttributesFormCheck()
	{
		if ($this->params['label']) {
			$this->setAttrClass('form-check');
		}

		$this->input->attributes([
			'class' => [
				'form-check-input'
			]
		]);

		if ($this->params['label']) {
			$this->label->attributes([
				'class' => [
					'form-check-label'
				]
			]);
		}
	}


	private function setAttributesInline()
	{
		if($this->params['inline'] === true) {
			$this->attributes['class'][] = 'form-check-inline';
		}
	}
}