<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.24
 * @since  2023-12-15 18:03:04
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';

class HtmlElementBsIcon extends HtmlElement
{
	public function __construct($params = [])
	{
		$params = \Avi\Tools::applyDefault($params, [
			'slug' => 'bootstrap',
			'tag' => 'i'
		]);
		$this->tag = $params['tag'];
		$this->attributes([
			'class' => 'bi bi-'.$params['slug']
		]);

		return $this;
	}
}
