<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.00
 * @since  2024-02-06 21:30:40
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once __DIR__.'/HtmlElementBsInput.php';

class HtmlElementBsInputDatalist extends HtmlElementBsInput
{
	public $datalist;


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


	public function datalist($params)
	{
		$this->params['datalist'] = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}


	protected function parseParams()
	{
		$this->parseParam('datalist', [
			'id' => 'datalist',
			'items' => []
		]);
		$this->child('datalist', 'html-datalist', [
			'id' => $this->params['datalist']['id']
		]);

		parent::parseParams();
	}


	protected function setAttributes()
	{
		parent::setAttributes();

		$this->input->attributes([
			'list' => $this->params['datalist']['id']
		]);
	}


	protected function setContentExtra()
	{
		$this->content[] = $this->datalist->content(
			\Avi\Tools::atos($this->params['datalist']['items'], '<option value="%s">', ['isPrintFormat' => true])
			//vsprintf('<option value="%s">', $this->params['datalist']['items'])
		);
	}
}
