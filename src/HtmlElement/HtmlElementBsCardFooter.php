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

class HtmlElementBsCardFooter extends HtmlElement
{
	private $position;

	protected $params;

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
		$this->tag = 'div';

		$this->parseParam('text');
	}


	private function setAttributes()
	{
		$this->attributes([
			'class' => 'card-footer'
		]);
	}

	private function setContent() {
		$this->content = $this->params['text'];
	}
}
