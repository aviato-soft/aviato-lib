<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.09
 * @since  2024-03-04 12:25:06
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsCardHeader extends HtmlElement
{
	private $position;

	protected $params;
	protected $tag = 'div';

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
		$this->tag = $this->params['tag'] ?? $this->tag;
		$this->parseParam('content');
	}


	private function setAttributes()
	{
		$this->attributes([
			'class' => 'card-header'
		]);
	}

	private function setContent() {
		$this->content = $this->params['content'];
	}
}
