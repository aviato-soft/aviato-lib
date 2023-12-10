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

class HtmlElementBsDropdown extends HtmlElement
{
	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->attributes([
			'class' => 'dropdown'
		]);
		return $this;
	}


	private function parseParams()
	{
		if(isset($this->params['button'])) {
			$this->content[] = $this->button()->use();
		}

		if(isset($this->params['menu'])) {
			$this->content[] = $this->menu()->use();
		}
	}


	private function button()
	{
		return $this
			->element('BsButton', $this->params['button'])
			->attributes([
				'aria' => [
					'expanded' => 'false'
				],
				'class' => [
					'dropdown-toggle'
				],
				'data' => [
					'bs-toggle' => 'dropdown'
				]
			]);
	}


	private function menu()
	{
		$tplMenuItem = $this->tag('li')->content(
			$this->tag('a')->attributes([
				'href' => '{href}',
				'class' => [
					'dropdown-item'
				]
			])->content('{text}'));

		return $this->tag('ul')
			->attributes([
				'class' => [
					'dropdown-menu'
				]
			])
			->content(\Avi\Tools::atos($this->params['menu']['items'], $tplMenuItem));
	}
}

