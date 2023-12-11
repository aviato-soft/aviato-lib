<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.23
 * @since  2023-12-11 14:57:31
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';

class HtmlElementBsDropdown extends HtmlElement
{

	private $direction = '';
	private $directions = [
		'center',
		'end',
		'start'
	];
	private $drop = 'down';
	private $drops = [
		'down',
		'up'
	];
	private $params;
	private $size = [
		'sm',
		'lg'
	];

	protected $button = '';
	protected $menu = '';

	/**
	 *
	 * @param array $params the values are optional and must be:
	 * 	|- button
	 *  |- direction
	 *  |- menu
	 *  |- size = $size
	 * @return \Avi\HtmlElementBsDropdown
	 */
	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->attributes([
			'class' => $this->baseClass()
		]);
		$this->getContent();
		$this->use();
		return $this;
	}


	private function parseParams()
	{
		$this->tag = 'div';

		if(isset($this->params['button'])) {
			$this->button();
		}

		if (isset($this->params['direction']) && in_array($this->params['direction'], $this->directions, true)) {
			$this->direction = $this->params['direction'];
		}

		if (isset($this->params['drop']) && in_array($this->params['drop'], $this->drops, true)) {
			$this->drop = $this->params['drop'];
		}

		if (isset($this->params['size']) && in_array($this->params['size'], $this->size, true)) {
			$this->size();
		}

		if(isset($this->params['menu'])) {
			$this->content[] = $this->menu();
		}
	}


	private function button()
	{
		$this->button = $this
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


	/**
	 * drop[down]
	 * drop[start]
	 * drop[end]
	 * drop[up]
	 *
	 * dropup dropup-center
	 * dropdown-center
	 *
	 */
	private function baseClass()
	{
		$drop = $this->drop;
		if (in_array($this->direction, ['end', 'start'], true)) {
			$drop = $this->direction;
		}

		if ($this->direction === 'center') {
			$drop = ($this->drop === 'up') ? 'up dropup-center': 'down-center';
		}

		return 'drop'.$drop;
	}


	private function menuItem(array $item)
	{
		$attr = [
			'class' => []
		];

		if ($item['type'] === 'html') {
			return $item['content'];
		}

		//particular attributes for each type
		switch($item['type']) {
			case 'link':
				$tag = 'a';
				$attr['class'][] = 'dropdown-item';
				$attr['href'] = $item['href'] ?? 'javascript:;';
				break;

			case 'button':
				$tag = 'button';
				$attr['class'][] = 'dropdown-item';
				$attr['type'] = 'button';
				break;

			case 'header':
				$tag = 'h6';
				$attr['class'][] = 'dropdown-header';
				break;

			case 'separator':
				$tag = 'hr';
				$attr['class'][] = 'dropdown-divider';
				$item['text'] = $item['text'] ?? '';
				break;

			case 'text':
				$tag = 'span';
				$attr['class'][] = 'dropdown-item-text';
				break;
		}


		//common attributes
		//active
		if (isset($item['active']) && $item['active'] === true) {
			$attr['aria']['current'] = 'true';
			$attr['class'][] = 'active';
		}

		//disabled
		if (isset($item['disabled']) && $item['disabled'] === true) {
			$attr['aria']['disabled'] = 'true';
			$attr['class'][] = 'disabled';
		}


		return $this->tag('li')->content(
			$this->tag($tag)->attributes($attr)->content($item['text']));
	}


	private function menu()
	{
		$tag = $this->params['menu']['tag'] ?? 'ul';

		$cls = $this->params['menu']['class'] ?? [];
		$cls[] = 'dropdown-menu';

		$items = [];
		foreach ($this->params['menu']['items'] as $item) {
			$items[] = $this->menuItem($item);
		}

		$this->menu = $this->tag($tag)
			->attributes([
				'class' => $cls
			])
			->content($items, true);
	}


	private function getContent()
	{
		$this->content = [];

//		var_dump($this->button);
		if(is_a($this->button, 'Avi\HtmlElementBsButton')) {
			$this->content[] = $this->button->use();
		}

		if(is_a($this->menu, 'Avi\HtmlElement')) {
			$this->content[] = $this->menu->use();
		}
		return $this->content;
	}


	private function size()
	{
		$this->button->attributes([
			'class' => sprintf('btn-%s', $this->params['size'])
		]);
	}



}

