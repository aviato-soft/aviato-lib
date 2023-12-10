<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.22
 * @since  2023-12-10 13:59:12
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';

class HtmlElementBsIcon extends HtmlElement
{
	public function __construct($params = ['bootstrap'])
	{
		$this->tag = 'i';
		$this->attributes([
			'class' => 'bi bi-'.$params[0]
		]);
	}
}
