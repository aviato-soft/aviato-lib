<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsButton extends TestCase
{

	public function testFn_HtmlElementBsButton()
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Button full test
		$test = implode('', [
			'<button aria-pressed="true" class="active btn btn-lg btn-primary text-nowrap" data-bs-toggle="button" type="submit" disabled>',
			'<i class="bi bi-airplane"></i>',
			'<span aria-hidden="true" class="d-none spinner-border"></span>',
			'<span class="d-none visually-hidden" role="status">Loading...</span>',
			'<span class="ps-3">Click me!</span>',
			'<span class="badge bg-warning text-bg-dark">10</span>',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'active' => true, //true | false
			'badge' => [
				'bg-color'=>'warning',
				'color'=>'dark',
				'text' => '10'
			],
			'disabled' => true,
			'icon' => 'airplane',
			'nowrap' => true,
			'size' => 'lg',
			'spinner' => [
				'hidden' => true,
				'status' => 'after',
				'tag' => 'span',
				'text' => 'Loading...',
			],
			'tag' => 'button',
			'text' => 'Click me!',
			'toggle' => true,
			'type' => 'submit',
			'variant' => 'primary' // element of AVI_BS_COLOR
		])->use();
		$this->assertEquals($test, $result);


		//button basic
		$test = '<button class="btn" type="button">Base class</button>';
		$result = $aviHtmlElement->element('BsButton')->content('Base class');
		$this->assertEquals($test, $result);


		//invalid attributes
		$test = '<button aria-pressed="true" class="active btn" type="button"><span class="badge">aviato</span>Click me!</button>';
		$result = $aviHtmlElement->element('BsButton', [
				'active' => 'aviato',
				'aviato' => 'soft',
				'badge' => 'aviato',
				'disabled' => 'aviato',
				'tag' => 'aviato',
				'type' => 'aviato'
			])
			->content('Click me!');
		$this->assertEquals($test, $result);


		//variants
		$test = implode('', [
			'<button class="btn btn-primary" type="button">Primary</button>',
			'<button class="btn btn-secondary" type="button">Secondary</button>',
			'<button class="btn btn-success" type="button">Success</button>',
			'<button class="btn btn-danger" type="button">Danger</button>',
			'<button class="btn btn-warning" type="button">Warning</button>',
			'<button class="btn btn-info" type="button">Info</button>',
			'<button class="btn btn-light" type="button">Light</button>',
			'<button class="btn btn-dark" type="button">Dark</button>',
			'<button class="btn btn-link" type="button">Link</button>'
		]);
		$variants = array_merge(AVI_BS_COLOR, ['link']);
		$result = '';
		foreach ($variants as $variant) {
			$result .= $aviHtmlElement->element('BsButton', [
				'variant' => $variant
			])->content(ucfirst($variant));
		}
		$this->assertEquals($test, $result);

		$test = '<button class="btn" type="button"></button>';
		$result = $aviHtmlElement->element('BsButton', [
			'variant' => 'invalid'
		])->use();
		$this->assertEquals($test, $result);


		//disable text wrapping
		$test = '<button class="btn btn-primary text-nowrap" type="button"></button>';
		$result = $aviHtmlElement->element('BsButton', [
			'variant' => 'primary',
			'nowrap' => true
		])->use();
		$this->assertEquals($test, $result);

//Button tags
		$test = implode('', [
			'<a class="btn btn-primary" href="#" role="button">Link</a>',
			'<button class="btn btn-primary" type="submit">Button</button>',
			'<input class="btn btn-primary" type="button" value="Input">',
			'<input class="btn btn-primary" type="submit" value="Submit">',
			'<input class="btn btn-primary" type="reset" value="Reset">'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'href' => '#',
				'tag' => 'a',
				'variant' => 'primary'
			])->content('Link'),
			$aviHtmlElement->element('BsButton', [
				'tag' => 'button',
				'type' => 'submit',
				'variant' => 'primary'
			])->content('Button'),
			$aviHtmlElement->element('BsButton', [
				'tag' => 'input',
				'type' => 'button',
				'variant' => 'primary'
			])->content('Input'),
			$aviHtmlElement->element('BsButton', [
				'tag' => 'input',
				'type' => 'submit',
				'variant' => 'primary'
			])->content('Submit'),
			$aviHtmlElement->element('BsButton', [
				'tag' => 'input',
				'type' => 'reset',
				'variant' => 'primary'
			])->content('Reset'),
		]);
		$this->assertEquals($test, $result);


		//Outline buttons
		$test = implode('', [
			'<button class="btn btn-outline-primary" type="button">Primary</button>',
			'<button class="btn btn-outline-secondary" type="button">Secondary</button>',
			'<button class="btn btn-outline-success" type="button">Success</button>',
			'<button class="btn btn-outline-danger" type="button">Danger</button>',
			'<button class="btn btn-outline-warning" type="button">Warning</button>',
			'<button class="btn btn-outline-info" type="button">Info</button>',
			'<button class="btn btn-outline-light" type="button">Light</button>',
			'<button class="btn btn-outline-dark" type="button">Dark</button>'
		]);
		$result = '';
		foreach (AVI_BS_COLOR as $variant) {
			$result .= $aviHtmlElement->element('BsButton', [
				'outline' => true,
				'variant' => $variant
			])->content(ucfirst($variant));
		}
		$this->assertEquals($test, $result);


		//Sizes
		$test = implode('', [
			'<button class="btn btn-lg btn-primary" type="button">Large button</button>',
			'<button class="btn btn-lg btn-secondary" type="button">Large button</button>'
		]);
		$result = '';
		$result .= $aviHtmlElement->element('BsButton', [
			'size' => 'lg',
			'variant' => 'primary'
		])->content('Large button');
		$result .= $aviHtmlElement->element('BsButton', [
			'size' => 'lg',
			'text' => 'Large button',
			'variant' => 'secondary'
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<button class="btn btn-primary btn-sm" type="button">Small button</button>',
			'<button class="btn btn-secondary btn-sm" type="button">Small button</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'size' => 'sm',
			'variant' => 'primary'
		])->content('Small button');
		$result .= $aviHtmlElement->element('BsButton', [
			'size' => 'sm',
			'text' => 'Small button',
			'variant' => 'secondary'
		])->use();
		$this->assertEquals($test, $result);

		//custom size
		$test = implode('', [
			'<button class="btn btn-primary" ',
			'style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" ',
			'type="button"',
			'>',
			'Custom button',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
//			'attr' => [
//				'style' => '--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;'
//			],
			'variant' => 'primary'
		])
		->attributes([
			'style' => '--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;'
		])
		->content('Custom button');


		//Disabled state
		$test = implode('', [
			'<button class="btn btn-primary" type="button" disabled>Primary button</button>',
			'<button class="btn btn-secondary" type="button" disabled>Button</button>',
			'<button class="btn btn-outline-primary" type="button" disabled>Primary button</button>',
			'<button class="btn btn-outline-secondary" type="button" disabled>Button</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'variant' => 'primary'
		])->content('Primary button');
		$result .= $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'variant' => 'secondary'
		])->content('Button');
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'outline' => true,
			'variant' => 'primary'
		])->content('Primary button');
		$result .= $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'outline' => true,
			'variant' => 'secondary'
		])->content('Button');

		//Disabled buttons using the <a> element
		$test = implode('', [
			'<a aria-disabled="true" class="btn btn-primary disabled" role="button">Primary link</a>',
			'<a aria-disabled="true" class="btn btn-secondary disabled" role="button">Link</a>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'tag' => 'a',
			'text' => 'Primary link',
			'variant' => 'primary'
		])->use();
		$result .= $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'tag' => 'a',
			'text' => 'Link',
			'variant' => 'secondary'
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<a aria-disabled="true" class="btn btn-primary disabled" href="#" role="button" tabindex="-1">Primary link</a>',
			'<a aria-disabled="true" class="btn btn-secondary disabled" href="#" role="button" tabindex="-1">Link</a>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'href' => '#',
			'tag' => 'a',
			'text' => 'Primary link',
			'variant' => 'primary'
		])->use();
		$result .= $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'href' => '#',
			'tag' => 'a',
			'text' => 'Link',
			'variant' => 'secondary'
		])->use();
		$this->assertEquals($test, $result);


		//buton type input
		$test = '<input class="btn btn-secondary" type="reset" value="Click me!" disabled>';
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'tag' => 'input',
			'text' => 'Click me!',
			'type' => 'reset',
			'variant' => 'secondary'
		])->use();
		$this->assertEquals($test, $result);


		//Block button
		$test = implode('', [
			'<div class="d-grid gap-2">',
			'<button class="btn btn-primary" type="button">Button</button>',
			'<button class="btn btn-primary" type="button">Button</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
			->attributes([
				'class' => [
					'd-grid',
					'gap-2'
				]
			])->content([
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->content('Button'),
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->content('Button')
			]);
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="d-grid d-md-block gap-2">',
			'<button class="btn btn-primary" type="button">Button</button>',
			'<button class="btn btn-primary" type="button">Button</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
			->attributes([
				'class' => [
					'd-grid',
					'd-md-block',
					'gap-2'
				]
			])->content([
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->content('Button'),
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->content('Button')
		]);
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="col-6 d-grid gap-2 mx-auto">',
			'<button class="btn btn-primary" type="button">Button</button>',
			'<button class="btn btn-primary" type="button">Button</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
			->attributes([
				'class' => [
					'col-6',
					'd-grid',
					'gap-2',
					'mx-auto'
				]
			])
			->content([
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->content('Button'),
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->content('Button')
		]);
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="d-grid d-md-flex gap-2 justify-content-md-end">',
			'<button class="btn btn-primary me-md-2" type="button">Button</button>',
			'<button class="btn btn-primary" type="button">Button</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
			->attributes([
				'class' => [
					'd-grid',
					'd-md-flex',
					'gap-2',
					'justify-content-md-end'
				]
			])
			->content([
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->attributes(['class' => ['me-md-2']])->content('Button'),
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->content('Button')
			]);
		$this->assertEquals($test, $result);


		//Toggle states
		$test = implode('', [
			'<p class="d-inline-flex gap-1">',
			'<button class="btn" data-bs-toggle="button" type="button">Toggle button</button>',
			'<button aria-pressed="true" class="active btn" data-bs-toggle="button" type="button">Active toggle button</button>',
			'<button class="btn" data-bs-toggle="button" type="button" disabled>Disabled toggle button</button>',
			'</p>',
			'<p class="d-inline-flex gap-1">',
			'<button class="btn btn-primary" data-bs-toggle="button" type="button">Toggle button</button>',
			'<button aria-pressed="true" class="active btn btn-primary" data-bs-toggle="button" type="button">Active toggle button</button>',
			'<button class="btn btn-primary" data-bs-toggle="button" type="button" disabled>Disabled toggle button</button>',
			'</p>'
		]);
		$result = $aviHtmlElement->tag('p')
			->attributes([
				'class' => [
					'd-inline-flex',
					'gap-1'
				]
			])
			->content([
				$aviHtmlElement->element('BsButton', [
					'toggle' => true
				])->content('Toggle button'),
				$aviHtmlElement->element('BsButton', [
					'active' => true,
					'toggle' => true
				])->content('Active toggle button'),
				$aviHtmlElement->element('BsButton', [
					'disabled' => true,
					'toggle' => true
				])->content('Disabled toggle button')
			]);
		$result .= $aviHtmlElement->tag('p')
			->attributes([
				'class' => [
					'd-inline-flex',
					'gap-1'
				]
			])
			->content([
				$aviHtmlElement->element('BsButton', [
					'toggle' => true,
					'variant'=>'primary'
				])->content('Toggle button'),
				$aviHtmlElement->element('BsButton', [
					'active' => true,
					'toggle' => true,
					'variant'=>'primary'
				])->content('Active toggle button'),
				$aviHtmlElement->element('BsButton', [
					'disabled' => true,
					'toggle' => true,
					'variant'=>'primary'
				])->content('Disabled toggle button')
			]);
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<p class="d-inline-flex gap-1">',
			'<a class="btn" data-bs-toggle="button" href="#" role="button">Toggle link</a>',
			'<a aria-pressed="true" class="active btn" data-bs-toggle="button" href="#" role="button">Active toggle link</a>',
			'<a aria-disabled="true" class="btn disabled" data-bs-toggle="button" role="button">Disabled toggle link</a>',
			'</p>',
			'<p class="d-inline-flex gap-1">',
			'<a class="btn btn-primary" data-bs-toggle="button" href="#" role="button">Toggle link</a>',
			'<a aria-pressed="true" class="active btn btn-primary" data-bs-toggle="button" href="#" role="button">Active toggle link</a>',
			'<a aria-disabled="true" class="btn btn-primary disabled" data-bs-toggle="button" role="button">Disabled toggle link</a>',
			'</p>'
		]);
		$result = $aviHtmlElement->tag('p')
			->attributes([
				'class' => [
					'd-inline-flex',
					'gap-1'
				]
			])
			->content([
				$aviHtmlElement->element('BsButton', [
					'href' => '#',
					'tag' => 'a',
					'toggle' => true
				])->content('Toggle link'),
				$aviHtmlElement->element('BsButton', [
					'active' => true,
					'href' => '#',
					'tag' => 'a',
					'toggle' => true
				])->content('Active toggle link'),
				$aviHtmlElement->element('BsButton', [
					'disabled' => true,
					'tag' => 'a',
					'toggle' => true
				])->content('Disabled toggle link')
			]);
		$result .= $aviHtmlElement->tag('p')
			->attributes([
				'class' => [
					'd-inline-flex',
					'gap-1'
				]
			])
			->content([
				$aviHtmlElement->element('BsButton', [
					'href' => '#',
					'tag' => 'a',
					'toggle' => true,
					'variant' => 'primary'
				])->content('Toggle link'),
				$aviHtmlElement->element('BsButton', [
					'active' => true,
					'href' => '#',
					'tag' => 'a',
					'toggle' => true,
					'variant' => 'primary'
				])->content('Active toggle link'),
				$aviHtmlElement->element('BsButton', [
					'disabled' => true,
					'tag' => 'a',
					'toggle' => true,
					'variant' => 'primary'
				])->content('Disabled toggle link')
			]);
		$this->assertEquals($test, $result);


		//buton type submit
		$test = '<button class="btn btn-secondary" type="submit" disabled>Click me!</button>';
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'text' => 'Click me!',
			'type' => 'submit',
			'variant' => 'secondary'
		])->use();
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


		//Bs Button with visible icon and hidden spinner:
		$test = implode('', [
			'<button class="btn btn-primary btn-sm" type="button">',
			'<i class="bi bi-floppy-fill"></i>',
			'<span aria-hidden="true" class="d-none spinner-border spinner-border-sm"></span>',
			'<span class="d-none visually-hidden" role="status">Please wait!...</span>',
			'<span class="ps-2">Save</span>',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'icon' => 'floppy-fill',
			'size' => 'sm',
			'spinner' => [
				'hidden' => true,
				'status' => 'after',
				'size' => 'sm',
				'text' => 'Please wait!...',
				'tag' => 'span'
			],
			'text' => 'Save',
			'variant' => 'primary'
		])->use();
		$this->assertEquals($test, $result);


		$bsSpinner = $aviHtmlElement->element('BsSpinner', [
			'hidden' => true,
			'size' => 'sm',
			'status' => 'after',
			'text' => 'Please wait!...',
			'tag' => 'span'
		]);
		$bsIcon = $aviHtmlElement->element('BsIcon', 'floppy-fill');

		$result = $aviHtmlElement->element('BsButton', [
			'icon' => $bsIcon,
			'size' => 'sm',
			'spinner' => $bsSpinner,
			'text' => 'Save',
			'variant' => 'primary'
		])->use();
		$this->assertEquals($test, $result);


		//usage test
		$bsIcon = $aviHtmlElement->element('BsIcon', 'floppy-fill')
			->attributes([
			'data' => [
				'role' => 'btn-icon'
			]
		]);
		$bsSpinner = $aviHtmlElement->element('BsSpinner', [
			'attr' => [
				'data' => [
					'role' => 'spinner'
				]
			],
			'hidden' => true,
			'size' => 'sm',
			'status' => 'after',
			'text' => 'Please wait!...',
			'tag' => 'span'
		]);


		$test = implode('', [
			'<button class="btn" type="button">',
			'<i class="bi bi-airplane"></i>',
			'<div class="spinner-border" role="status"><span class="visually-hidden">Please wait!</span></div>',
			'<span class="ps-3">Click me!</span>',
			'<span class="badge">99</span>',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', 'Click me!')
			->icon('airplane')
			->spinner('Please wait!')
			->badge('99')
			->use();
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<button class="btn btn-primary btn-sm" ',
			'data-action="widget" data-call="Edit" data-gear="hotel" data-serialize="true" ',
			'data-success="backend.on.success.done" data-verbose="true" data-widget="Gear" ',
			'type="button">',
			'<i class="bi bi-floppy-fill" data-role="btn-icon"></i>',
			'<span aria-hidden="true" class="d-none spinner-border spinner-border-sm" data-role="spinner"></span>',
			'<span class="d-none visually-hidden" role="status">Please wait!...</span>',
			'<span class="ps-2">Save</span></button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'icon' => $bsIcon,
			'size' => 'sm',
			'spinner' => $bsSpinner,
			'text' => 'Save',
			'variant' => 'primary'
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
		$this->assertEquals($test, $result);
	}

}

