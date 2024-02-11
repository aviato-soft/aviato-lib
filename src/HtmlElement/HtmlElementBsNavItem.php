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

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsNavItem extends HtmlElement
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
		$this->parseParam('text');
		$this->tag = 'a';

		$this->parseParam('active', false);
		$this->parseParam('disabled', false);
		$this->parseParam('href', 'javascript:;');
	}


	private function setAttributes()
	{
		$this->setAttributeHref();
		$this->setAttributeActive();
		$this->setAttributeDisabled();

		$this->attributes([
			'class' => [
				'nav-link'
			]
		]);
	}


	private function setAttributeActive()
	{
		if ($this->params['active']) {
			$this->attributes([
				'aria' => [
					'current' => 'page'
				],
				'class' => [
					'active'
				]
			]);
		}
	}


	private function setAttributeDisabled()
	{
		if ($this->params['disabled'] === true) {
			$this->attributes([
				'class' => 'disabled',
				'aria' => [
					'disabled' => 'true'
				],
			]);
			if(isset($this->attributes['href'])) {
				$this->attributes['tabindex'] = '-1';
			}
		}
	}


	private function setAttributeHref()
	{
		if ($this->params['href'] !== false) {
			$this->attributes([
				'href' => $this->params['href']
			]);
		}
	}


	private function setContent()
	{
		$this->content = $this->params['text'];
	}
}
