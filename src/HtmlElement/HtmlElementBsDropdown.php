<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.10
 * @since  2024-06-25 19:26:53
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsDropdown extends HtmlElement
{

	private $direction;
	private $directions = [
		'center',
		'end',
		'start'
	];
	private $drop;
	private $drops = [
		'down',
		'end',
		'start',
		'up'
	];

	protected $params;

	public $button;
	public $menu;


	/**
	 *
	 * @param array $params the values are optional and must be:
	 *  |- autoclose = true | inside | outside | false Auto close behavior
	 * 	|- button = the trigger bs button element, arrow in case of split
	 *  |- dark = false | true = menu is dark
	 *  |- direction = the menu display direction
	 *  |- drop = down | end | start | up - the drop direction
	 *  |- menu = the bs element of menu
	 *  	|- align (end | start | end + start responsive)
	 *  	|- items = array of items (type, text, active, disabled)
	 *  		|- button (text, type = button)
	 *  		|- header (text, type = header)
	 *  		|- html (content, type = html)
	 *  		|- link (href, type = link, text)
	 *  		|- separator (tag, type = separator)
	 *  		|- text (text, type = text)
	 * 		|- tag (default is ul - also is set based on item types)
	 *  |- offset = false | $value in pixels
	 *  |- reference = false | parent
	 *  |- split = the bs button split -
	 * @return \Avi\HtmlElementBsDropdown
	 */
	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}


	public function button($params = 'Dropdown button')
	{
		$this->params['button'] = $params;
		$this->parseParams();
		$this->setContent();
		return $this;
	}


	public function menu($params = [])
	{
		$params = \Avi\Tools::applyDefault($params, $this->params['menu']);
		$this->params['menu'] = $params;
		$this->parseParams();
		$this->setContent();
		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? 'div';

		$this->parseParam('button', 'Dropdown button');

		$this->parseParam('autoclose', false);
		$this->parseParam('dark', false);
		$this->parseParam('direction', '');
		$this->direction = (in_array($this->params['direction'], $this->directions, true))? $this->params['direction']: '';
		$this->parseParam('drop', 'down');
		$this->drop = (in_array($this->params['drop'], $this->drops, true))? $this->params['drop']: 'down';
		$this->parseParam('group', false);
		$this->parseParam('menu', []);
		$this->params['menu'] = \Avi\Tools::applyDefault($this->params['menu'], [
			'items' => [],
			'tag' => 'ul'
		]);
		$this->parseParam('offset', false);
		$this->parseParam('reference', false);
		$this->parseParam('split', false);

		$this->child('button', 'BsButton', [
			'aria' => [
				'expanded' => 'false'
			],
			'class' => [
				'dropdown-toggle',
			],
			'data' => $this->buttonData()
		]);

		$this->child(
			'menu',
			sprintf('html-%s', $this->params['menu']['tag'] ?? 'ul'),
			[
				'class' => $this->menuClass()
			]
		);
	}


	private function setAttributes()
	{
		$this->attributes([
			'class' => $this->baseClass()
		]);
	}


	/**
	 */
	private function baseClass()
	{
		if($this->params['group'] === true) {
			$class[] = 'btn-group';
		} else {
			if($this->params['drop'] !== 'up' && $this->params['direction'] !== 'center') {
				$class[] = 'dropdown';
			}
		}

		if($this->params['drop'] !== 'down') {
			$class[] = sprintf('drop%s', $this->params['drop']);
		}

		if($this->params['direction'] === 'center') {
			$class[] = sprintf('drop%s-%s', $this->params['drop'], $this->params['direction']);
		}

		return $class;
	}


	private function buttonData()
	{
		$data = ['bs-toggle' => 'dropdown'];
		if($this->params['autoclose'] !== false) {
			$data['bs-auto-close'] = $this->params['autoclose'];
		}
		if($this->params['offset'] !== false) {
			$data['bs-offset'] = $this->params['offset'];
		}
		if($this->params['reference'] !== false) {
			$data['bs-reference'] = $this->params['reference'];
		}
		return $data;
	}


	private function menuClass()
	{
		$class = [
			'dropdown-menu',
		];
		if ($this->params['dark'] === true) {
			$class[] = sprintf('dropdown-menu-%s', 'dark');
		}
		if (isset($this->params['menu']['align'])) {
			if (in_array(substr($this->params['menu']['align'], 0, 2), AVI_BS_BREAKPOINT, true)) {
				$this->button->attributes([
					'data' => [
						'bs-display' => 'static'
					]
				]);
			}
			$class[] = sprintf('dropdown-menu-%s', $this->params['menu']['align']);
		}

		return $class;
	}


	private function menuItem(array|string $item = [])
	{
		if ($item === []) {
			return '';
		}

		if(is_string($item)) {
			$item = [
				'type' => 'text',
				'text' => $item
			];
		}
		$item['type'] = $item['type'] ?? 'text';

		if (!in_array($item['type'], ['button', 'header', 'html', 'link', 'separator', 'text'], true)) {
			return '';
		}

		if ($item['type'] === 'html') {
			return $item['content'];
		}

		$attr = [
			'class' => []
		];

		//particular attributes for each type
		switch($item['type']) {
			case 'link':
				$tag = 'a';
				$attr['class'][] = 'dropdown-item';
				if ($item['href'] !== false) {
					$attr['href'] = $item['href'] ?? 'javascript:;';
				}
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
				$tag = $item['tag'] ?? 'hr';
				$attr['class'][] = 'dropdown-divider';
				$item['text'] = $item['text'] ?? '';
				break;

			case 'text':
				$tag = 'span';
				$attr['class'][] = 'dropdown-item-text';
				break;

			default:
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

		$content = $this->tag($tag)->attributes($attr)->content($item['text']);
		return ($this->params['menu']['tag'] === 'ul') ? $this->tag('li')->content($content) : $content;
	}


	private function setMenuItems()
	{

		$items = [];
		foreach ($this->params['menu']['items'] as $item) {
			$items[] = $this->menuItem($item);
		}

		$this->menu->content($items, true);

		return $this->menu;
	}


	private function setContent()
	{
		$this->content = [];

//		if(isset($this->params['debug']) && $this->params['debug'] === true) {
//			var_dump($this->parent);
//			var_dump($this->params['layout']);
//		}
		if(isset($this->params['layout']) && in_array($this->params['layout'], ['input-group', 'margin'], true)) {
			$this->tag = '';
		}

		if(is_array($this->params['split'])) {
			$this->params['split'] = $this->element('BsButton', $this->params['split']);
		}
		if(is_a($this->params['split'], 'Avi\HtmlElementBsButton')) {
			//for dropstart the split button is at the end of the content:
			if($this->params['drop'] !== 'start') {
				$this->content[] = $this->params['split']->use();
			}
			//complile the arrow button
			$arrow = $this->tag('span')->attributes([
				'class' => 'visually-hidden'
			])->content($this->button->content);
			$this->button->content = $arrow;
			$this->button->attributes([
				'class' => [
					'dropdown-toggle-split'
				]
			]);
		}

		if(is_a($this->button, 'Avi\HtmlElementBsButton')) {
			$this->content[] = $this->button->use();
		}

		if(is_a($this->menu, 'Avi\HtmlElement')) {
			$this->setMenuItems();
			$this->content[] = $this->menu->use();
		}

		if(is_a($this->params['split'], 'Avi\HtmlElementBsButton')) {
			if($this->params['drop'] === 'start') {
				$this->content[] = $this->params['split']->use();
			}
		}
	}
}
