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

class HtmlElementBsCardImg extends HtmlElement
{
	private $position;

	protected $params;

	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		return $this;
	}


	private function parseParams()
	{
		$this->tag = 'img';

		$this->parseParam('alt', sprintf('image for [%s]', $this->params['src']));
		$this->parseParam('position', 'top');
	}


	private function setAttributes()
	{
		$class = [];
		if ($this->params['position'] === false) {
			$class[] = 'card-img';
		} else {
			$class[] = sprintf('card-img-%s', $this->params['position']);
		}
		$this->attributes([
			'alt' => $this->params['alt'],
			'src' => $this->params['src'],
			'class' => $class
		]);
	}
}
