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

class HtmlElementBsButton extends HtmlElement
{
	private $params;
	private $size = [
		'sm',
		'lg'
	];
	private $tags = [
		'a',
		'btn',
		'input'
	];
	private $type = [
		'button',
		'submit',
		'reset'
	];
	private $variants = [
		'primary',
		'secondary',
		'success',
		'danger',
		'warning',
		'info',
		'light',
		'dark',
		'link'
	];

	/**
	 *
	 * @param array $params the values are optional and must be:
	 *        |- active = true|false
	 *        |- disabled = true|false
	 *        |- icon = bs icon name | HtmlElementBsIcon properties
	 *        |- nowrap = true|false
	 *        |- size = $size
	 *        |- spinner = HtmlElementBsSpinner properties
	 *        |- tag = $tags
	 *        |- text = string
	 *        |- type = $type
	 *        |- variant = $variants
	 */
	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->attributes([
			'class' => 'btn'
		]);
		return $this;
	}

	private function parseParams()
	{
		if (!isset($this->params['type']) || !in_array($this->params['type'], $this->type, true)) {
			$this->params['type'] = 'button';
		}

		if (!isset($this->params['tag']) || !in_array($this->params['tag'], $this->tags, true)) {
			$this->params['tag'] = 'button';
		}
		$this->tags();

		if (isset($this->params['active'])) {
			$this->active();
		}

		if (isset($this->params['disabled']) && $this->params['disabled'] === true) {
			$this->disabled();
		}

		if (isset($this->params['icon'])) {
			$this->icon();
		}

		if (isset($this->params['nowrap']) && $this->params['nowrap'] === true) {
			$this->nowrap();
		}

		if (!isset($this->params['outline']) || $this->params['outline'] !== true) {
			$this->params['outline'] = false;
		}

		if (isset($this->params['size']) && in_array($this->params['size'], $this->size, true)) {
			$this->size();
		}

		if (isset($this->params['spinner'])) {
			$this->spinner();
		}

		if (isset($this->params['text'])) {
			$this->text();
		}

		if (isset($this->params['variant']) && in_array($this->params['variant'], $this->variants, true)) {
			$this->variant();
		}
	}

	private function active()
	{
		$this->attributes([
			'data-bs-toggle' => 'button'
		]);
		if ($this->params['active'] === true) {
			$this->attributes([
				'aria' => [
					'pressed' => 'true'
				],
				'class' => [
					'active'
				]
			]);
		}
	}

	private function disabled()
	{
		switch ($this->params['tag']) {
			case 'a':
				$this->attributes([
					'class' => 'disabled',
					'aria' => [
						'disabled' => 'true'
					],
					'tab-index' => '-1'
				]);
				unset($this->attributes['href']);
				break;

			case 'button':
			case 'input':
				$this->attributes([
					'disabled'
				]);
				break;
		}
	}

	private function icon()
	{
		if (is_string($this->params['icon'])) {
			if (\Avi\Tools::isEnclosedIn($this->params['icon'])) {
				$this->content[] = $this->params['icon'];
			} else {
				$this->content[] = $this->element('BsIcon', [
					$this->params['icon']
				])->use();
			}
			return;
		}

		if (is_array($this->params['icon'])) {
			$this->content[] = $this->element('BsIcon', $this->params['icon'])->use();
		}
	}

	private function nowrap()
	{
		$this->attributes([
			'class' => 'text-nowrap'
		]);
	}

	private function size()
	{
		$this->attributes([
			'class' => sprintf('btn-%s', $this->params['size'])
		]);
	}


	private function spinner()
	{
		if ($this->params['spinner'] === true) {
			$this->content[] = $this->element('BsSpinner', [
				'tag' => 'none',
				'size' => 'sm'
			])->use();
			return;
		}

		if (is_string($this->params['spinner'])) {
			if (\Avi\Tools::isEnclosedIn($this->params['spinner'])) {
				$this->content[] = $this->params['spinner'];
			} else {
				$this->content[] = $this->element('BsSpinner', [
					'tag' => 'none',
					'size' => 'sm',
					'text' => $this->params['spinner']
				])->use();
			}
			return;
		}

		if (is_array($this->params['spinner'])) {
			$this->content[] = $this->element('BsSpinner', $this->params['spinner'])->use();
		}
	}

	private function tags()
	{
		$this->tag = $this->params['tag'];
		switch ($this->params['tag']) {
			case 'a':
				if (!isset($this->params['href'])) {
					$this->params['href'] = 'javascript:;';
				}
				$this->attributes([
					'href' => $this->params['href'],
					'role' => 'button'
				]);
				break;

			case 'button':
				$this->attributes([
					'type' => $this->params['type'],
				]);
				break;

			case 'input':
				$this->attributes([
					'type' => $this->params['type'],
				]);
				break;
		}
	}

	private function text()
	{
		if ($this->params['tag'] === 'input') {
			$this->attributes([
				'value' => $this->params['text'],
			]);
		} else {
			if (isset($this->params['icon'])) {
				$this->content[] = $this->tag('span')->attributes([
					'class' => sprintf('ps-%s', (isset($this->params['size']) && $this->params['size'] === 'sm') ? 2: 3)
				])->content($this->params['text']);
			} else {
				$this->content[] = $this->params['text'];
			}
		}
	}

	private function variant()
	{
		$this->attributes([
			'class' => sprintf('btn%s-%s', ($this->params['outline']) ? '-outline' : '', $this->params['variant'])
		]);
	}

}
?>