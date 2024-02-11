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

class HtmlElementBsInput extends HtmlElementBsFormControl
{

	protected $params;
	protected $tag = 'div';

	private $types = [
		'color',
		'email',
		'file',
		'password',
		'range',
		'text',
	];


/**
 *
 * @param array $params
 *
 * @return \Avi\HtmlElementBsInput
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


	protected function parseParams()
	{
		parent::parseParams();


		$this->parseParam('type', 'text');
		$this->parseParam('label-position', false);
		$this->parseParam('placeholder');
		$this->parseParam('plaintext');
		$this->parseParam('readonly');
		$this->parseParam('title');
		$this->parseParam('valid');
//		$this->parseParam('value');

		if ($this->params['type'] === 'range') {
			$this->parseParam('max');
			$this->parseParam('min');
			$this->parseParam('step');
		}

		$this->input->attributes([
			'type' => $this->params['type']
		]);
	}


	protected function setAttributes()
	{
		parent::setAttributes();

		//input
		$this->setAttributesByType();

		$this->setAttributesPlaceholder();
		$this->setAttributesRange();
		$this->setAttributesReadonly();
		$this->setAttributesSize();
		$this->setAttributesTitle();
		$this->setAttributesValue();

		//label
		$this->setAttributesLabel();
	}


	private function setAttributesByType()
	{
		if ($this->params['type'] === 'range') {
			$this->input->attributes([
				'class' => [
					'form-range'
				]
			]);
			return;
		}

		if (in_array($this->params['type'], $this->types, true)) {
			$this->input->attributes([
				'class' => [
					($this->params['plaintext']) ? 'form-control-plaintext' : 'form-control'
				]
			]);
		}

		if ($this->params['type'] === 'color') {
			$this->input->attributes([
				'class' => [
					'form-control-color'
				]
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

		if (
			$this->params['group'] === true
			&& $this->params['type'] !== 'file'
			&& $this->params['layout'] !== 'floating-label'
		) {
			$this->params['label-position'] = null;
		}

		$this->label->setAttrClass($this->getLabelClass());
	}


	private function getLabelClass()
	{
		if (!in_array($this->params['type'], $this->types, true)) {
			return null;
		}

		if ($this->params['type'] === 'file' && $this->params['group'] === true) {
			return 'input-group-text';
		}

		if ($this->params['label-hidden']) {
			return 'visually-hidden';
		}

		if (in_array($this->params['layout'], ['inline', 'row'], true)) {
			return 'col-form-label';
		}

		if($this->params['layout'] === 'floating-label') {
			return null;
		}

		return 'form-label';
	}


	private function setAttributesPlaceholder()
	{
		if (is_string($this->params['placeholder'])) {
			$this->input->attributes([
				'placeholder' => $this->params['placeholder']
			]);
		}
	}


	private function setAttributesRange()
	{
		if ($this->params['type'] === 'range') {
			if ($this->params['max'] !== null) {
				$this->input->attributes([
					'max' => $this->params['max']
				]);
			}

			if ($this->params['min'] !== null) {
				$this->input->attributes([
					'min' => $this->params['min']
				]);
			}

			if ($this->params['step'] !== null) {
				$this->input->attributes([
					'step' => $this->params['step']
				]);
			}
		}
	}


	private function setAttributesReadonly()
	{
		if($this->params['readonly'] === true) {
			$this->input->attributes([
				'readonly'
			]);
		}
	}


	private function setAttributesTitle()
	{
		if($this->params['title']) {
			$this->input->attributes([
				'title' => $this->params['title']
			]);
		}
	}

/*
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
*/

	protected function setContent()
	{
		$this->content = [];
		$content = $this->getContentByLayout();
		$content = $this->getContentByGroup($content);

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
		if ($this->feedback) {
			if(isset($this->feedback['invalid'])) {
				$this->content[] = $this->feedback['invalid'];
			}

			if(isset($this->feedback['valid'])) {
				$this->content[] = $this->feedback['valid'];
			}
		}

		if (method_exists($this, 'setContentExtra')) {
			$this->setContentExtra();
		}
	}


	private function getContentByLayout()
	{
		$content = [
			'help' => null,
			'input' => null,
			'label' => null,
		];

		//input
		$input = $this->input->use();
		if (in_array($this->params['layout'], ['inline', 'row'], true)) {
			$this->params['breakpoint'] = ($this->params['breakpoint'] === false) ? 'auto': $this->params['breakpoint'];
			$content['input'] = $this->tag('div')
				->attributes([
					'class' => [
						sprintf('col-%s', $this->params['breakpoint'])
					]
				])
				->content($input);
		} else {
			$content['input'] = $input;
		}

		//label
		if($this->params['label']) {
			$label = $this->label->content($this->params['label']);
/*
			if ($this->params['label-position'] === false) {
				$this->params['label-position'] = 'start';
			}
*/
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



		//help
		if($this->params['help']) {
			$help = $this->help->content($this->params['help']);

			if($this->params['layout'] === 'inline') {
				$content['help'] = $this->tag('div')
				-> attributes([
					'class' => [
						'col-auto'
					]
				])
				->content($help);
			} else {
				$content['help'] = $help;
			}
		}

		return $content;
	}


	private function getContentByGroup($content)
	{
		if ($this->params['group'] === true) {
			$content['help'] = '';
		}

		return $content;
	}
}