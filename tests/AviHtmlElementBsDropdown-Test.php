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
		$result = $aviHtmlElement->element('BsDropdown', [
			'button' => [
				'text' => 'Dropdown button',
				'variant' => 'secondary'
			],
			'menu' => [
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
			]
		])->use();
		$this->assertEquals($test, $result);
/*
		$test = implode('', [
			'<div class="dropdown-center">',
			'<a aria-expanded="false" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" href="javascript:;" role="button">',
			'Dropdown link',
			'</a>',
			'<ul class="dropdown-menu">',
			'<li><h6 class="dropdown-header">The menu header</h6></li>',
			'<li><a aria-current="true" class="active dropdown-item" href="#">Action</a></li>',
			'<li><span class="dropdown-item-text">Non interactive Item</span></li>',
			'<li><button class="dropdown-item" type="button">Another action</button></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a aria-disabled="true" class="disabled dropdown-item" href="#">Something else here</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'button' => [
				'tag' => 'a',
				'text' => 'Dropdown link',
				'variant' => 'primary'
			],
			'direction' => 'center',
			'menu' => [
				'items' => [
					[
						'text' => 'The menu header',
						'type' => 'header'
					],
					[
						'active' => true,
						'href' => '#',
						'text' => 'Action',
						'type' => 'link'
					],
					[
						'text' => 'Non interactive Item',
						'type' => 'text'
					],
					[
						'text' => 'Another action',
						'type' => 'button'
					],
					[
						'type' => 'separator'
					],
					[
						'disabled' => true,
						'href' => '#',
						'text' => 'Something else here',
						'type' => 'link'
					],
				]
			]
		])->use();

		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="dropup dropup-center">',
			'<button aria-expanded="false" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown button',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'button' => [
				'text' => 'Dropdown button',
				'variant' => 'secondary'
			],
			'direction' => 'center',
			'drop' => 'up',
			'menu' => [
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
			],
			'size' => 'sm'
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="dropup">',
			'<button aria-expanded="false" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown button',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'button' => [
				'text' => 'Dropdown button',
				'variant' => 'secondary'
			],
			'drop' => 'up',
			'menu' => [
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
			],
			'size' => 'sm'
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="dropstart">',
			'<button aria-expanded="false" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown button',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'button' => [
				'text' => 'Dropdown button',
				'variant' => 'secondary'
			],
			'direction' => 'start',
			'menu' => [
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
			],
			'size' => 'sm'
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="dropdown">',
			'<button aria-expanded="false" class="btn btn-info dropdown-toggle focus-0" data-bs-auto-close="outside" data-bs-toggle="dropdown" type="button">',
			'Dropdown button',
			'</button>',
			'<div class="dropdown-menu dropdown-menu-end shadow">',
			'<form>',
			'[...]',
			'</form>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsDropdown', [
			'button' => [
				'attr' => [
					'class' => [
						'focus-0'
					],
					'data' => [
						'bs-auto-close' => 'outside'
					]
				],
				'text' => 'Dropdown button',
				'variant' => 'info'
			],
			'menu' => [
				'attr' => [
					'class' => [
						'dropdown-menu-end',
						'shadow'
					]
				],
				'tag' => 'div',
				'items' => [
					[
						'content' => '<form>[...]</form>',
						'type' => 'html'
					]
				]
			],
		])->use();
		$this->assertEquals($test, $result);
*/

	}


}

