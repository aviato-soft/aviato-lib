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

class HtmlElementBsInputTextarea extends HtmlElementBsInput
{

/**
 *
 * @param array $params
 *
 * @return \Avi\HtmlElementBsInputCheckbox
 */
	public function __construct($params = [], $parent = null)
	{
		parent::__construct($params, $parent);
		return $this;
	}


	protected function parseParams()
	{
		parent::parseParams();

		$this->parseParam('cols', false);
		$this->parseParam('rows', false);
		$this->parseParam('text', '');

		$this->child('input', 'html-textarea');
	}


	protected function setAttributes()
	{
		parent::setAttributes();

		$this->setAttributesCols();
		$this->setAttributesRows();
		$this->setAttributesText();
	}


	private function setAttributesCols()
	{
		if ($this->params['cols'] !== false) {
			$this->input->attributes([
				'cols' => $this->params['cols']
			]);
		}
	}

	private function setAttributesRows()
	{
		if ($this->params['rows'] !== false) {
			$this->input->attributes([
				'rows' => $this->params['rows']
			]);
		}
	}

	private function setAttributesText()
	{
		$this->input->content($this->params['text']);
	}


	protected function parseElementContent($content)
	{
		$this->input->content($content);
		$this->setContent();

		return $this->content;
	}
}