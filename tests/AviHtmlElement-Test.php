<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElement extends TestCase
{

	public function testFn_Construct(): void
	{
		$aviHtmlElement = new AviHtmlElement('body');
		$test = '<body></body>';
		$result = $aviHtmlElement->use();

		$this->assertEquals($test, $result);
	}


	public function testFn_Attributes(): void
	{
		//no attributes:
		$aviHtmlElement = new AviHtmlElement('input');

		//no attributes:
		$test = '<input>';
		$result = $aviHtmlElement->attributes()->content();
		$this->assertEquals($test, $result);

		//single attributes:
		$test = '<input disabled>';
		$result = $aviHtmlElement->attributes(['disabled'])->content();
		$this->assertEquals($test, $result);

		//usual (associative) attributes:
		$test = '<input disabled value="aviato">';
		$result = $aviHtmlElement->attributes([
			'value' => 'aviato'
		])->content();
		$this->assertEquals($test, $result);

		//associative keys attributes:
		$test = '<input data-call="submit" data-role="button" disabled value="aviato">';
		$result = $aviHtmlElement->attributes([
			'data' => [
				'role' => 'button',
				'call' => 'submit'
			]
		])->content();
		$this->assertEquals($test, $result);

		//associative values attributes:
		$test = '<input class="btn btn-primary" data-call="submit" data-role="button" disabled value="aviato">';
		$result = $aviHtmlElement->attributes([
			'class' => [
				'btn',
				'btn-primary'
			]
		])->content();
		$this->assertEquals($test, $result);

		//reset the attributes:
		$test = '<input value="new">';
		$result = $aviHtmlElement->attributes(['value' => 'new'], false)->content();
		$this->assertEquals($test, $result);
	}


	public function testFn_Content(): void
	{
		//single element content:
		$aviHtmlElement = new AviHtmlElement('body');
		$result = $aviHtmlElement->content($aviHtmlElement->tag('h1')->content('Title'));
		$test = '<body><h1>Title</h1></body>';

		$this->assertEquals($test, $result);

		//multiple content
		$aviHtmlElement = new AviHtmlElement('body');
		$aviHtmlElement->content([
			$aviHtmlElement->tag('h1')->content('Title'),
			$aviHtmlElement->tag('p')->content('Paragraph')
		], true);
		$result = $aviHtmlElement->content(
			$aviHtmlElement->tag('article')->content('Aviato Soft'));
		$test = '<body><h1>Title</h1><p>Paragraph</p><article>Aviato Soft</article></body>';

		$this->assertEquals($test, $result);
	}


	public function testFn_dispatch()
	{
		$aviHtmlElement = new AviHtmlElement('!doctype');
		ob_start();

		$test = '<!doctype html>';
		$aviHtmlElement->attributes(['html'])->dispatch();
		$result = ob_get_clean();
		$this->assertEquals($test, $result);
	}


	public function testFn_element()
	{
		$aviHtmlElement = new AviHtmlElement('body');
		$result = $aviHtmlElement->content(
			$aviHtmlElement->element('button', ['label' => 'click me!'], dirname(__DIR__).'/tests/assets')
				->attributes([
					'class' => 'btn-primary',
					'type' => 'submit'
				])
				->use());
		$test = '<body><button class="btn btn-primary" type="submit">click me!</button></body>';
		$this->assertEquals($test, $result);
	}


	public function testFn_HtmlElementBsButton()
	{
		//button base class
		$test = '<button class="btn" type="button"></button>';
		$aviHtmlElement = new \Avi\HtmlElement();
		$result = $aviHtmlElement->element('BsButton', [])->use();
		$this->assertEquals($test, $result);

		//variants
		$test = '<button class="btn btn-dark" type="button"></button>';
		$result = $aviHtmlElement->element('BsButton', [
				'variant' => 'dark'
			])->use();
		$this->assertEquals($test, $result);

		//disable text wrapping
		$test = '<button class="btn btn-primary text-nowrap" type="button"></button>';
		$result = $aviHtmlElement->element('BsButton', [
			'variant' => 'primary',
			'nowrap' => true
		])->use();
		$this->assertEquals($test, $result);


		//multiple attributes
		$test = '<button aria-pressed="true" class="active btn btn-outline-dark btn-sm text-nowrap" data-bs-toggle="button" disabled type="button">Button</button>';
		$result = $aviHtmlElement->element('BsButton', [
			'active' => true,
			'disabled' => true,
			'nowrap' => true,
			'outline' => true,
			'size' => 'sm',
			'text' => 'Button',
			'variant' => 'dark',
		])->use();
		$this->assertEquals($test, $result);

		//buton type link
		$test = '<a aria-disabled="true" class="btn disabled" role="button" tab-index="-1">Click me!</a>';
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'tag' => 'a',
			'text' => 'Click me!'
		])->use();
		$this->assertEquals($test, $result);


		//buton type input
		$test = '<input class="btn btn-secondary" disabled type="reset" value="Click me!">';
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'tag' => 'input',
			'text' => 'Click me!',
			'type' => 'reset',
			'variant' => 'secondary'
		])->use();
		$this->assertEquals($test, $result);


		//buton type submit
		$test = '<button class="btn btn-secondary" disabled type="submit">Click me!</button>';
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'text' => 'Click me!',
			'type' => 'submit',
			'variant' => 'secondary'
		])->use();
		$this->assertEquals($test, $result);

		//icon base class
		$test = '<i class="bi bi-airplane"></i>';
		$result = $aviHtmlElement->element('BsIcon', ['slug' => 'airplane'])->use();
		$this->assertEquals($test, $result);

		//button with icon
		$test = '<button class="btn" type="button"><i class="bi bi-airplane"></i><span class="ps-3">Click me!</span></button>';
		$result = $aviHtmlElement->element('BsButton', [
			'icon' => 'airplane',
			'text' => 'Click me!'
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsButton', [
			'icon' => [
				'slug' => 'airplane'
			],
			'text' => 'Click me!'
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsButton', [
			'icon' => $aviHtmlElement->element('BsIcon', ['slug' => 'airplane'])->use(),
			'text' => 'Click me!'
		])->use();
		$this->assertEquals($test, $result);

		//spinner
		$test = implode('', [
			'<div class="spinner-border" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner')->use();
		$this->assertEquals($test, $result);

		//spinner color and size
		$test = implode('', [
			'<div class="spinner-border spinner-border-sm text-danger" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner', [
			'color' => 'danger',
			'size' => 'sm'
		])->use();
		$this->assertEquals($test, $result);

		//spinner type
		$test = implode('', [
			'<div class="spinner-grow text-info" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner', [
			'color' => 'info',
			'type' => 'grow'
		])->use();
		$this->assertEquals($test, $result);


		//Bs Button with icon and spinner:
		$test = implode('', [
			'<button class="btn btn-primary btn-sm" type="button">',
			'<i class="bi bi-floppy-fill"></i>',
			'<span aria-hidden="true" class="spinner-border spinner-border-sm"></span>',
			'<span role="status">Loading...</span>',
			'<span class="ps-2">Save</span>',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'icon' => 'floppy-fill',
			'size' => 'sm',
			'spinner' => true,
			'text' => 'Save',
			'variant' => 'primary'
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsButton', [
			'icon' => 'floppy-fill',
			'size' => 'sm',
			'spinner' => $aviHtmlElement->element('BsSpinner', [
				'size' => 'sm',
				'tag' => ''
			])->use(),
			'text' => 'Save',
			'variant' => 'primary'
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsButton', [
			'icon' => 'floppy-fill',
			'size' => 'sm',
			'spinner' => 'Loading...',
			'text' => 'Save',
			'variant' => 'primary'
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsButton', [
			'icon' => 'floppy-fill',
			'size' => 'sm',
			'spinner' => [
				'size' => 'sm',
				'tag' => ''
			],
			'text' => 'Save',
			'variant' => 'primary'
		])->use();
		$this->assertEquals($test, $result);
/*
		$test = implode('', [
			'<button class="btn btn-primary btn-sm" ',
			'data-action="widget" data-call="Edit" data-gear="hotel" data-serialize="true" data-success="backend.on.success.done" data-verbose="true" data-widget="Gear" ',
			'type="button">',
			'<i class="bi bi-floppy-fill" data-role="btn-icon"></i>',
			'<span aria-hidden="true" class="spinner-border spinner-border-sm d-none" data-role="spinner" role="status"></span>',
			'<span class="visually-hidden">Please wait...</span>',
			'<span class="ps-2">Save</span></button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'icon' => $aviHtmlElement->element('BsIcon', ['floppy-fill'])->attributes([
				'data' => [
					'role' => 'btn-icon'
				]
			])->use(),
			'size' => 'sm',
			'spinner' => true,
			'text' => 'Save',
			'variant' => 'primary',
		])->attributes([
			'data' => [
				'action' => 'widget',
				'call' => 'Edit',
				'gear' => 'hotel',
				'serialize' => 'true',
				'success' => 'backend.on.success.done',
				'verbose' => 'true',
				'widget' => 'Gear',
			]
		])->use();
*/
		$this->assertEquals($test, $result);

	}


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
	}
}

