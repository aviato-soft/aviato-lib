<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsDropdown extends TestCase
{
	public function testFn_HtmlElementBsDropdown(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Full params call:
		$test = implode('', [
			'<div class="dropdown" data-aviato="soft">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="true" data-bs-toggle="dropdown" type="button">Button</button>',
			'<ul class="dropdown-menu">',
			'<li><h6 class="dropdown-header">Header</h6></li>',
			'<li><span class="dropdown-item-text">Text</span></li>',
			'<li><span class="dropdown-item-text">Text only item</span></li>',
			'<li><a class="dropdown-item" href="#">Action 1</a></li>',
			'<li><a class="dropdown-item" href="#">Action 2</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><button class="dropdown-item" type="button">Button</button></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'autoclose' => 'true', //true | inside | outside | false
			'dark' => false, // false | true
			'direction' => '', //'' | center | end | start
			'drop' => 'down', //down | end | up | start
			'group' => false, //false | true,
			'offset' => false, // false | $value in pixels
			'reference' => false, // false | reference | parent
			'size' => false, //false | sm | lg
			'split' => false, //false | true

		])
		->button([
			'text' => 'Button',
			'variant' => 'secondary'
		])
		->menu([
			'items' => [
				[
					'type' => 'header',
					'text' => 'Header'
				],
				[
					'type' => 'text',
					'text' => 'Text'
				],
				'Text only item',
				[],
				[
					'type' => 'link',
					'href' => '#',
					'text' => 'Action 1'
				],
				[
					'type' => 'link',
					'href' => '#',
					'text' => 'Action 2'
				],
				[
					'tag' => 'hr',
					'type' => 'separator'
				],
				[
					'type' => 'button',
					'text' => 'Button'
				],
				[
					'type' => 'invalid',
					'text' => 'Warning!'
				],
			],
		])
		->attributes([
			'data' => [
				'aviato' => 'soft'
			]
		])
		->use();
		$this->assertEquals($test, $result);

		//Empty call:
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button">Dropdown button</button>',
			'<ul class="dropdown-menu"></ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')->use();
		$this->assertEquals($test, $result);


		//Single button
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown button',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')
			->button([
				'text' => 'Dropdown button',
				'variant' => 'secondary'
			])
			->menu([
				'items' => [
					[
						'href' => '#',
						'text' => 'Action',
						'type' => 'link'
					],
					[
						'href' => '#',
						'text' => 'Another action',
						'type' => 'link'
					],
					[
						'href' => '#',
						'text' => 'Something else here',
						'type' => 'link'
					],
				]
			])
			->use();
		$this->assertEquals($test, $result);


		//Dropdown link
		$test = implode('', [
			'<div class="dropdown">',
			'<a aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">',
			'Dropdown link'.
			'</a>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')
		->button([
			'href' => '#',
			'tag' => 'a',
			'text' => 'Dropdown link',
			'variant' => 'secondary'
		])
		->menu([
			'items' => [
				[
					'href' => '#',
					'text' => 'Action',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Another action',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Something else here',
					'type' => 'link'
				],
			]
		])
		->use();
		$this->assertEquals($test, $result);


		$items = [
			[
				'href' => '#',
				'text' => 'Action',
				'type' => 'link'
			],
			[
				'href' => '#',
				'text' => 'Another action',
				'type' => 'link'
			],
			[
				'href' => '#',
				'text' => 'Something else here',
				'type' => 'link'
			],
			[
				'type' => 'separator'
			],
			[
				'href' => '#',
				'text' => 'Separated link',
				'type' => 'link'
			],
		];
		//Single danger button
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Action',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'text' => 'Action',
			'variant' => 'danger'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);


		//Split button
		$test = implode('', [
			'<div class="btn-group">',
			'<button class="btn btn-danger" type="button">Action</button>',
			'<button aria-expanded="false" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button">',
			'<span class="visually-hidden">Toggle Dropdown</span>',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true,
			'split' => $aviHtmlElement->element('BsButton', [
				'text' => 'Action',
				'variant' => 'danger'
			])
		])
		->button([
			'text' => 'Toggle Dropdown',
			'variant' => 'danger'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);


		//Sizing
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-lg btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Large button',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'size' => 'lg',
			'text' => 'Large button',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="btn-group">',
			'<button class="btn btn-lg btn-secondary" type="button">',
			'Large split button',
			'</button>',
			'<button aria-expanded="false" class="btn btn-lg btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button">',
			'<span class="visually-hidden">Toggle Dropdown</span>',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true,
			'split' => $aviHtmlElement->element('BsButton', [
				'size' => 'lg',
				'text' => 'Large split button',
				'variant' => 'secondary'
			])
		])
		->button([
			'size' => 'lg',
			'text' => 'Toggle Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Small button',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'size' => 'sm',
			'text' => 'Small button',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="btn-group">',
			'<button class="btn btn-secondary btn-sm" type="button">',
			'Small split button',
			'</button>',
			'<button aria-expanded="false" class="btn btn-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button">',
			'<span class="visually-hidden">Toggle Dropdown</span>',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true,
			'split' => $aviHtmlElement->element('BsButton', [
				'size' => 'sm',
				'text' => 'Small split button',
				'variant' => 'secondary'
			])
		])
		->button([
			'size' => 'sm',
			'text' => 'Toggle Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);


		//Dark dropdown
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown button',
			'</button>',
			'<ul class="dropdown-menu dropdown-menu-dark">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'dark' => true
		])
		->button([
			'text' => 'Dropdown button',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);


/**
 * WIP[...]
 */
		//dropdown inside navbar ...



		//Directions

		//Centered
		$test = implode('', [
			'<div class="dropdown-center">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Centered dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'direction' => 'center'
		])
		->button([
			'text' => 'Centered dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		//dropup
		$test = implode('', [
			'<div class="btn-group dropup">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropup',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'drop' => 'up',
			'group' => true
		])
		->button([
			'text' => 'Dropup',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		//Split dropup button dropup
		$test = implode('', [
			'<div class="btn-group dropup">',
			'<button class="btn btn-secondary" type="button">',
			'Split dropup',
			'</button>',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button">',
			'<span class="visually-hidden">Toggle Dropdown</span>',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'drop' => 'up',
			'group' => true,
			'split' => $aviHtmlElement->element('BsButton', [
				'text' => 'Split dropup',
				'variant' => 'secondary'
			])
		])
		->button([
			'text' => 'Toggle Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		//Dropup centered
		$test = implode('', [
			'<div class="dropup dropup-center">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Centered dropup',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'direction' => 'center',
			'drop' => 'up'
		])
		->button([
			'text' => 'Centered dropup',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);


		//Drop end
		$test = implode('', [
			'<div class="btn-group dropend">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropend',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'drop' => 'end',
			'group' => true,
		])
		->button([
			'text' => 'Dropend',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		//Drop end split
		$test = implode('', [
			'<div class="btn-group dropend">',
			'<button class="btn btn-secondary" type="button">',
			'Split dropend',
			'</button>',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button">',
			'<span class="visually-hidden">Toggle Dropend</span>',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'drop' => 'end',
			'group' => true,
			'split' => $aviHtmlElement->element('BsButton', [
				'text' => 'Split dropend',
				'variant' => 'secondary'
			])
 		])
		->button([
			'text' => 'Toggle Dropend',
			'variant' => 'secondary'
		])
		->menu(['items' => $items])
		->use();
		$this->assertEquals($test, $result);


		//Drop start
		$test = implode('', [
			'<div class="btn-group dropstart">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropstart',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'drop' => 'start',
			'group' => true,
		])
		->button([
			'text' => 'Dropstart',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		//Split dropstart button
		$test = implode('', [
			'<div class="btn-group dropstart">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button">',
			'<span class="visually-hidden">Toggle Dropstart</span>',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'<button class="btn btn-secondary" type="button">',
			'Split dropstart',
			'</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'drop' => 'start',
			'group' => true,
			'split' =>  $aviHtmlElement->element('BsButton', [
				'text' => 'Split dropstart',
				'variant' => 'secondary'
			])
		])
		->button([
			'text' => 'Toggle Dropstart',
			'variant' => 'secondary'
		])
		->menu(['items' => $items])
		->use();
		$this->assertEquals($test, $result);


		//Menu items
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><button class="dropdown-item" type="button">Action</button></li>',
			'<li><button class="dropdown-item" type="button">Another action</button></li>',
			'<li><button class="dropdown-item" type="button">Something else here</button></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')
		->button([
			'text' => 'Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => [
				[
					'text' => 'Action',
					'type' => 'button'
				],
				[
					'text' => 'Another action',
					'type' => 'button'
				],
				[
					'text' => 'Something else here',
					'type' => 'button'
				],
			]
		])
		->use();
		$this->assertEquals($test, $result);

		// non-interactive dropdown items
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><span class="dropdown-item-text">Dropdown item text</span></li>',
			'<li><button class="dropdown-item" type="button">Action</button></li>',
			'<li><button class="dropdown-item" type="button">Another action</button></li>',
			'<li><button class="dropdown-item" type="button">Something else here</button></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')
		->button([
			'text' => 'Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => [
				[
					'text' => 'Dropdown item text',
					'type' => 'text'
				],
				[
					'text' => 'Action',
					'type' => 'button'
				],
				[
					'text' => 'Another action',
					'type' => 'button'
				],
				[
					'text' => 'Something else here',
					'type' => 'button'
				],
			]
		])
		->use();
		$this->assertEquals($test, $result);

		//active
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Regular link</a></li>',
			'<li><a aria-current="true" class="active dropdown-item" href="#">Active link</a></li>',
			'<li><a class="dropdown-item" href="#">Another link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')
		->button([
			'text' => 'Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => [
				[
					'href' => '#',
					'text' => 'Regular link',
					'type' => 'link'
				],
				[
					'active' => true,
					'href' => '#',
					'text' => 'Active link',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Another link',
					'type' => 'link'
				],
			]
		])
		->use();
		$this->assertEquals($test, $result);

		//disabled
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Regular link</a></li>',
			'<li><a aria-disabled="true" class="disabled dropdown-item">Disabled link</a></li>',
			'<li><a class="dropdown-item" href="#">Another link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')
		->button([
			'text' => 'Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => [
				[
					'href' => '#',
					'text' => 'Regular link',
					'type' => 'link'
				],
				[
					'disabled' => true,
					'href' => false,
					'text' => 'Disabled link',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Another link',
					'type' => 'link'
				],
			]
		])
		->use();
		$this->assertEquals($test, $result);


		//Menu alignment
		$items = [
			[
				'text' => 'Action',
				'type' => 'button'
			],
			[
				'text' => 'Another action',
				'type' => 'button'
			],
			[
				'text' => 'Something else here',
				'type' => 'button'
			]
		];
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Right-aligned menu example',
			'</button>',
			'<ul class="dropdown-menu dropdown-menu-end">',
			'<li><button class="dropdown-item" type="button">Action</button></li>',
			'<li><button class="dropdown-item" type="button">Another action</button></li>',
			'<li><button class="dropdown-item" type="button">Something else here</button></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'text' => 'Right-aligned menu example',
			'variant' => 'secondary'
		])
		->menu([
			'align' => 'end',
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		//Responsive alignment
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-display="static" data-bs-toggle="dropdown" type="button">',
			'Left-aligned but right aligned when large screen',
			'</button>',
			'<ul class="dropdown-menu dropdown-menu-lg-end">',
			'<li><button class="dropdown-item" type="button">Action</button></li>',
			'<li><button class="dropdown-item" type="button">Another action</button></li>',
			'<li><button class="dropdown-item" type="button">Something else here</button></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'text' => 'Left-aligned but right aligned when large screen',
			'variant' => 'secondary'
		])
		->menu([
			'align' => 'lg-end',
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		//align left the dropdown menu with the given breakpoint or larger
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-display="static" data-bs-toggle="dropdown" type="button">',
			'Right-aligned but left aligned when large screen',
			'</button>',
			'<ul class="dropdown-menu dropdown-menu-lg-start dropdown-menu-end">',
			'<li><button class="dropdown-item" type="button">Action</button></li>',
			'<li><button class="dropdown-item" type="button">Another action</button></li>',
			'<li><button class="dropdown-item" type="button">Something else here</button></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'text' => 'Right-aligned but left aligned when large screen',
			'variant' => 'secondary'
		])
		->menu([
			'align' => 'lg-start dropdown-menu-end',
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);


		//Alignment options
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'</ul>',
			'</div>'
		]);
		$item = [
			'href' => '#',
			'text' => 'Menu item',
			'type' => 'link'
		];
		$items = [$item,$item,$item];
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'text' => 'Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Right-aligned menu',
			'</button>',
			'<ul class="dropdown-menu dropdown-menu-end">',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'text' => 'Right-aligned menu',
			'variant' => 'secondary'
		])
		->menu([
			'align' => 'end',
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-display="static" data-bs-toggle="dropdown" type="button">',
			'Left-aligned, right-aligned lg',
			'</button>',
			'<ul class="dropdown-menu dropdown-menu-lg-end">',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'text' => 'Left-aligned, right-aligned lg',
			'variant' => 'secondary'
		])
		->menu([
			'align' => 'lg-end',
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-display="static" data-bs-toggle="dropdown" type="button">',
			'Right-aligned, left-aligned lg',
			'</button>',
			'<ul class="dropdown-menu dropdown-menu-lg-start dropdown-menu-end">',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'group' => true
		])
		->button([
			'text' => 'Right-aligned, left-aligned lg',
			'variant' => 'secondary'
		])
		->menu([
			'align' => 'lg-start dropdown-menu-end',
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="btn-group dropstart">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropstart',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'drop' => 'start',
			'group' => true
		])
		->button([
			'text' => 'Dropstart',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="btn-group dropend">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropend',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'drop' => 'end',
			'group' => true
		])
		->button([
			'text' => 'Dropend',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="btn-group dropup">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropup',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'drop' => 'up',
			'group' => true
		])
		->button([
			'text' => 'Dropup',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);


		//Menu content
		//headers
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><h6 class="dropdown-header">Dropdown header</h6></li>',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')
		->button([
			'text' => 'Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => [
				[
					'text' => 'Dropdown header',
					'type' => 'header'
				],
				[
					'href' => '#',
					'text' => 'Action',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Another action',
					'type' => 'link'
				]
			]
		])
		->use();
		$this->assertEquals($test, $result);

		//dividers
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')
		->button([
			'text' => 'Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => [
				[
					'href' => '#',
					'text' => 'Action',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Another action',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Something else here',
					'type' => 'link'
				],
				[
					'type' => 'separator'
				],
				[
					'href' => '#',
					'text' => 'Separated link',
					'type' => 'link'
				],
			]
		])
		->use();
		$this->assertEquals($test, $result);

		//text
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<div class="dropdown-menu p-4 text-body-secondary" style="max-width: 200px;">',
			'<p>',
			'Some example text that\'s free-flowing within the dropdown menu.',
			'</p>',
			'<p class="mb-0">',
			'And this is more example text.',
			'</p>',
			'</div>',
			'</div>'
		]);

		$result = $aviHtmlElement->element('BsDropdown')
		->button([
			'text' => 'Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'attr' => [
				'class' => [
					'p-4',
					'text-body-secondary'
				],
				'style' => 'max-width: 200px;'
			],
			'items' => [
				[
					'content' => implode('', [
						$aviHtmlElement->tag('p')->content('Some example text that\'s free-flowing within the dropdown menu.'),
						$aviHtmlElement->tag('p')->attributes([
							'class' => 'mb-0'
						])->content('And this is more example text.')
					]),
					'type' => 'html'
				]
			],
			'tag' => 'div'
		])
		->use();
		$this->assertEquals($test, $result);


		//Forms
		$form = implode('', [
			'<form class="px-4 py-3">',
			'<div class="mb-3">',
			'<label for="exampleDropdownFormEmail1" class="form-label">Email address</label>',
			'<input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">',
			'</div>',
			'<div class="mb-3">',
			'<label for="exampleDropdownFormPassword1" class="form-label">Password</label>',
			'<input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">',
			'</div>',
			'<div class="mb-3">',
			'<div class="form-check">',
			'<input type="checkbox" class="form-check-input" id="dropdownCheck">',
			'<label class="form-check-label" for="dropdownCheck">',
			'Remember me',
			'</label>',
			'</div>',
			'</div>',
			'<button type="submit" class="btn btn-primary">Sign in</button>',
			'</form>',
		]);
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<div class="dropdown-menu">',
			$form,
			'<div class="dropdown-divider"></div>',
			'<a class="dropdown-item" href="#">New around here? Sign up</a>',
			'<a class="dropdown-item" href="#">Forgot password?</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown')
		->button([
			'text' => 'Dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => [
				[
					'content' => $form,
					'type' => 'html'
				],
				[
					'tag' => 'div',
					'type' => 'separator'
				],
				[
					'href' => '#',
					'text' => 'New around here? Sign up',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Forgot password?',
					'type' => 'link'
				]

			],
			'tag' => 'div'
		])
		->use();
		$this->assertEquals($test, $result);

		$form = implode('', [
			'<div class="mb-3">',
			'<label for="exampleDropdownFormEmail2" class="form-label">Email address</label>',
			'<input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">',
			'</div>',

			'<div class="mb-3">',
			'<label for="exampleDropdownFormPassword2" class="form-label">Password</label>',
			'<input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">',
			'</div>',

			'<div class="mb-3">',
			'<div class="form-check">',
			'<input type="checkbox" class="form-check-input" id="dropdownCheck2">',
			'<label class="form-check-label" for="dropdownCheck2">',
			'Remember me',
			'</label>',
			'</div>',
			'</div>',
			'<button type="submit" class="btn btn-primary">Sign in</button>',
		]);
		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-primary dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown" type="button">',
			'Dropdown form',
			'</button>',
			'<form class="dropdown-menu p-4">',
			$form,
			'</form>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'autoclose' => 'outside'
		])
		->button([
			'text' => 'Dropdown form',
			'variant' => 'primary'
		])
		->menu([
			'attr' => [
				'class' => [
					'p-4'
				]
			],
			'items' => [
				[
					'content' => $form,
					'type' => 'html'
				]
			],
			'tag' => 'form'
		])
		->use();
		$this->assertEquals($test, $result);


		//Options
		$items = implode('', [
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
		]);
		$bsItems = [
			[
				'href' => '#',
				'text' => 'Action',
				'type' => 'link'
			],
			[
				'href' => '#',
				'text' => 'Another action',
				'type' => 'link'
			],
			[
				'href' => '#',
				'text' => 'Something else here',
				'type' => 'link'
			]
		];
		$test = implode('', [
			'<div class="d-flex">',
			'<div class="dropdown me-1">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-offset="10,20" data-bs-toggle="dropdown" type="button">',
			'Offset',
			'</button>',
			'<ul class="dropdown-menu">',
			$items,
			'</ul>',
			'</div>',
			'<div class="btn-group">',
			'<button class="btn btn-secondary" type="button">Reference</button>',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-reference="parent" data-bs-toggle="dropdown" type="button">',
			'<span class="visually-hidden">Toggle Dropdown</span>',
			'</button>',
			'<ul class="dropdown-menu">',
			$items,
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')->attributes([
			'class' => 'd-flex'
		])
		->content([
			$aviHtmlElement->element('BsDropdown', [
				'offset' => '10,20'
			])
			->attributes([
				'class' => 'me-1'])
			->button([
				'text' => 'Offset',
				'variant' => 'secondary'
			])
			->menu([
				'items' => $bsItems
			])
			->use(),
			$aviHtmlElement->element('BsDropdown', [
				'group' => true,
				'reference' => 'parent',
				'split' => $aviHtmlElement->element('BsButton', [
						'text' => 'Reference',
						'variant' => 'secondary'
				])
			])
			->button([
				'text' => 'Toggle Dropdown',
				'variant' => 'secondary'
			])
			->menu([
				'items' => array_merge($bsItems, [
					[
						'type' => 'separator'
					],
					[
						'href' => '#',
						'text' => 'Separated link',
						'type' => 'link'
					]
				])
			])
			->use()
		]);
		$this->assertEquals($test, $result);


		//Auto close behavior
		$items = implode('', [
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>',
			'<li><a class="dropdown-item" href="#">Menu item</a></li>'

		]);
		$bsItem = [
			'href' => '#',
			'text' => 'Menu item',
			'type' => 'link'
		];
		$bsItems = [$bsItem, $bsItem, $bsItem];

		//default
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="true" data-bs-toggle="dropdown" type="button">',
			'Default dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			$items,
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'autoclose' => 'true',
			'group' => true
		])
		->button([
			'text' => 'Default dropdown',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $bsItems
		])
		->use();
		$this->assertEquals($test, $result);

		//Clickable inside
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="inside" data-bs-toggle="dropdown" type="button">',
			'Clickable inside',
			'</button>',
			'<ul class="dropdown-menu">',
			$items,
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'autoclose' => 'inside',
			'group' => true
		])
		->button([
			'text' => 'Clickable inside',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $bsItems
		])
		->use();
		$this->assertEquals($test, $result);

		//Clickable outside
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown" type="button">',
			'Clickable outside',
			'</button>',
			'<ul class="dropdown-menu">',
			$items,
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'autoclose' => 'outside',
			'group' => true
		])
		->button([
			'text' => 'Clickable outside',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $bsItems
		])
		->use();
		$this->assertEquals($test, $result);

		//Manual close
		$test = implode('', [
			'<div class="btn-group">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="false" data-bs-toggle="dropdown" type="button">',
			'Manual close',
			'</button>',
			'<ul class="dropdown-menu">',
			$items,
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'autoclose' => 'false',
			'group' => true
		])
		->button([
			'text' => 'Manual close',
			'variant' => 'secondary'
		])
		->menu([
			'items' => $bsItems
		])
		->use();
		$this->assertEquals($test, $result);

	}
}

