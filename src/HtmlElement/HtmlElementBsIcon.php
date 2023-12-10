<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.20
 * @since 2023-11-23 16:27:51
 *
 */
declare(strict_types = 1);

require_once dirname(__DIR__).'/HtmlElement.php';

class HtmlElementBsIcon extends \Avi\HtmlElement
{
	public function __construct($params = ['bootstrap'])
	{
		$this->tag = 'i';
		$this->attributes([
			'class' => 'bi bi-'.$params[0]
		]);
	}
}
