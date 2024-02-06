<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
//use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsToast extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div aria-atomic="true" aria-live="assertive" class="toast" role="alert">',
			'<div class="toast-body"></div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsToast')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div ',
			'aria-atomic="true" ',
			'aria-live="assertive" ',
			'class="toast" ',
			'data-bs-autohide="true" ',
			'data-bs-delay="1000" ',
			'role="alert">',
			'<div class="toast-header">',
			'<i class="bi bi-airplane"></i>',
			'<strong class="me-auto">The TITLE</strong>',
			'<small>2 mins. ago</small>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'<div class="toast-body">The body message<br>by Aviato Soft</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsToast', [
			'autohide' => true,
			'body' => 'The body message<br>by Aviato Soft',
			'delay' => 1000,
			'icon' => 'airplane',
			'info' => '2 mins. ago',
			'role' => 'alert', //default
			'title' => 'The TITLE',
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div ',
			'aria-atomic="true" ',
			'aria-live="polite" ',
			'class="toast" ',
			'role="status">',
			'<div class="toast-header">',
			'<i class="bi bi-airplane"></i>',
			'<strong class="me-auto">The TITLE</strong>',
			'<small>2 mins. ago</small>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'<div class="toast-body">The body message<br>by Aviato Soft</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsToast', [
			'autohide' => false, //optional - default is null
			'body' => 'The body message<br>by Aviato Soft',
			'delay' => 1000, //not needed, autohide is false
			'icon' => 'airplane',
			'info' => '2 mins. ago',
			'role' => 'status', //oposed to 'alert'
			'title' => 'The TITLE',
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div ',
			'aria-atomic="true" ',
			'aria-live="assertive" ',
			'class="toast" ',
			'data-bs-autohide="true" ',
			'role="alert">',
			'<div class="toast-header">',
			'<strong class="me-auto"></strong>',
			'<small></small>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'<div class="toast-body"></div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsToast', [
			'autohide' => 'no',
			'body' => false,
			'delay' => 'invalid',
			'icon' => null,
			'info' => true,
			'role' => 'warning', //invalid
			'title' => true
		])->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		//Basic
		$test = implode('', [
			'<div aria-atomic="true" aria-live="assertive" class="toast" role="alert">',
			'<div class="toast-header">',
			//'<img src="..." class="rounded me-2" alt="...">',
			'<i class="bi bi-airplane"></i>',
			'<strong class="me-auto">Bootstrap</strong>',
			'<small>11 mins ago</small>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'<div class="toast-body">',
			'Hello, world! This is a toast message.',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsToast', [
			'body' => 'Hello, world! This is a toast message.',
			'icon' => 'airplane',
			'info' => '11 mins ago',
			'title' => 'Bootstrap'
		])->use();
		$this->assertEquals($test, $result);

		//Live example
		$test = implode('', [
			'<div class="bottom-0 end-0 p-3 position-fixed toast-container">',
			'<div aria-atomic="true" aria-live="assertive" class="toast" id="liveToast" role="alert">',
			'<div class="toast-header">',
//			'<img src="..." class="rounded me-2" alt="...">',
			'<i class="bi bi-airplane"></i>',
			'<strong class="me-auto">Bootstrap</strong>',
			'<small>11 mins ago</small>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'<div class="toast-body">',
			'Hello, world! This is a toast message.',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div', [
			'class' => [
				'toast-container',
				'position-fixed',
				'bottom-0',
				'end-0',
				'p-3'
			]
		])->content(
			$aviHtmlElement->element('BsToast', [
				'attr' => [
					'id' => 'liveToast'
				],
				'body' => 'Hello, world! This is a toast message.',
				'icon' => 'airplane',
				'info' => '11 mins ago',
				'title' => 'Bootstrap'
			])->use()
		);
		$this->assertEquals($test, $result);


		//Translucent
		$test = implode('', [
			'<div aria-atomic="true" aria-live="assertive" class="toast" role="alert">',
			'<div class="toast-header">',
//			'<img src="..." class="rounded me-2" alt="...">',
			'<i class="bi bi-airplane"></i>',
			'<strong class="me-auto">Bootstrap</strong>',
			'<small class="text-body-secondary">11 mins ago</small>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'<div class="toast-body">',
			'Hello, world! This is a toast message.',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsToast', [
			'body' => 'Hello, world! This is a toast message.',
			'icon' => 'airplane',
			'info' => [
				'attr' => [
					'class' => 'text-body-secondary'
				],
				'content' => '11 mins ago'
			],
			'title' => 'Bootstrap'
		])->use();
		$this->assertEquals($test, $result);


		//Stacking
		$test = implode('', [
			'<div class="position-static toast-container">',

			'<div aria-atomic="true" aria-live="assertive" class="toast" role="alert">',
			'<div class="toast-header">',
//			'<img src="..." class="rounded me-2" alt="...">',
			'<i class="bi bi-airplane"></i>',
			'<strong class="me-auto">Bootstrap</strong>',
			'<small class="text-body-secondary">just now</small>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'<div class="toast-body">',
			'See? Just like this.',
			'</div>',
			'</div>',

			'<div aria-atomic="true" aria-live="assertive" class="toast" role="alert">',
			'<div class="toast-header">',
//			'<img src="..." class="rounded me-2" alt="...">',
			'<i class="bi bi-airplane"></i>',
			'<strong class="me-auto">Bootstrap</strong>',
			'<small class="text-body-secondary">2 seconds ago</small>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'<div class="toast-body">',
			'Heads up, toasts will stack automatically',
			'</div>',
			'</div>',

			'</div>'
		]);
		$result = $aviHtmlElement->tag('div', [
			'class' => [
				'toast-container',
				'position-static'
			]
		])->content([
			$aviHtmlElement->element('BsToast', [
				'icon' => 'airplane',
				'info' => [
					'attr' => [
						'class' => 'text-body-secondary'
					],
					'content' => 'just now'
				],
				'title' => 'Bootstrap'
			])->content('See? Just like this.'),
			$aviHtmlElement->element('BsToast', [
				'icon' => 'airplane',
				'info' => [
					'attr' => [
						'class' => 'text-body-secondary'
					],
					'content' => '2 seconds ago'
				],
				'title' => 'Bootstrap'
			])->content('Heads up, toasts will stack automatically'),
		]);
		$this->assertEquals($test, $result);


		//Custom content
		$test = implode('', [
			'<div aria-atomic="true" aria-live="assertive" class="align-items-center toast" role="alert">',
			'<div class="d-flex toast-body">',
			'<span>Hello, world! This is a toast message.</span>',
			'<button aria-label="Close" class="btn-close m-auto me-2" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsToast', [
			'body' => [
				'attr' => [
					'class' => [
						'd-flex'
					]
				],
				'content' => [
					$aviHtmlElement->tag('span')->content('Hello, world! This is a toast message.'),
					$aviHtmlElement->element('BsButtonClose', [
						'attr' => [
							'class' => [
								'm-auto',
								'me-2'
							]
						],
						'dismiss' => 'toast'
					])->use()
				]
			]
		])->attributes([
			'class' => [
				'align-items-center'
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div aria-atomic="true" aria-live="assertive" class="toast" role="alert">',
			'<div class="toast-body">',
			'Hello, world! This is a toast message.',
			'<div class="border-top mt-2 pt-2">',
			'<button class="btn btn-primary btn-sm" type="button">Take action</button>',
			'<button class="btn btn-secondary btn-sm" data-bs-dismiss="toast" type="button">Close</button>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsToast')
		->content(implode('', [
			'Hello, world! This is a toast message.',
			$aviHtmlElement->tag('div', [
				'class' => [
					'mt-2',
					'pt-2',
					'border-top'
				]
			])->content([
				$aviHtmlElement->element('BsButton', [
					'size' => 'sm',
					'text' => 'Take action',
					'variant' => 'primary'
				])->use(),
				$aviHtmlElement->element('BsButton', [
					'attr' => [
						'data' => [
							'bs-dismiss' => 'toast'
						]
					],
					'size' => 'sm',
					'text' => 'Close',
					'variant' => 'secondary'
				])->use()
			])
		]));
		$this->assertEquals($test, $result);


		//Color schemes
		$test = implode('', [
			'<div aria-atomic="true" aria-live="assertive" class="align-items-center border-0 text-bg-primary toast" role="alert">',
			'<div class="d-flex toast-body">',
			'<span>Hello, world! This is a toast message.</span>',
			'<button aria-label="Close" class="btn-close btn-close-white m-auto me-0" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsToast', [
			'body' => [
				'attr' => [
					'class' => [
						'd-flex'
					]
				],
				'content' => [
					$aviHtmlElement->tag('span')->content('Hello, world! This is a toast message.'),
					$aviHtmlElement->element('BsButtonClose', [
						'attr' => [
							'class' => [
								'btn-close-white',
								'm-auto',
								'me-0'
							]
						],
						'dismiss' => 'toast'
					])->use()
				]
			]
		])->attributes([
			'class' => [
				'align-items-center',
				'border-0',
				'text-bg-primary'
			]
		])->use();
		$this->assertEquals($test, $result);


		//Placement
		$test = implode('', [
			'<form>',
			'<div class="mb-3">',
			'<label class="form-label" for="selectToastPlacement">Toast placement</label>',
			'<select class="form-select mt-2" id="selectToastPlacement">',
			'<option selected value="">Select a position...</option>',
			'<option value="top-0 start-0">Top left</option>',
			'<option value="top-0 start-50 translate-middle-x">Top center</option>',
			'<option value="top-0 end-0">Top right</option>',
			'<option value="top-50 start-0 translate-middle-y">Middle left</option>',
			'<option value="top-50 start-50 translate-middle">Middle center</option>',
			'<option value="top-50 end-0 translate-middle-y">Middle right</option>',
			'<option value="bottom-0 start-0">Bottom left</option>',
			'<option value="bottom-0 start-50 translate-middle-x">Bottom center</option>',
			'<option value="bottom-0 end-0">Bottom right</option>',
			'</select>',
			'</div>',
			'</form>',
			'<div aria-atomic="true" aria-live="polite" class="bd-example-toasts bg-body-secondary position-relative rounded-3">',
			'<div class="p-3 toast-container" id="toastPlacement">',
			'<div aria-atomic="true" aria-live="assertive" class="toast" role="alert">',
			'<div class="toast-header">',
//			'<img src="..." class="rounded me-2" alt="...">',
			'<i class="bi bi-airplane"></i>',
			'<strong class="me-auto">Bootstrap</strong>',
			'<small>11 mins ago</small>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="toast" type="button"></button>',
			'</div>',
			'<div class="toast-body">',
			'Hello, world! This is a toast message.',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsForm')
				->content([
				[
					'BsSelect' => [
						'id' => 'selectToastPlacement',
						'input' => [
							'attr' => [
								'class' => [
									'mt-2'
								]
							]
						],
						'label' => 'Toast placement',
						'items' => [
							[
								'selected' => true,
								'text' => 'Select a position...',
								'value' => ''
							],
							[
								'text' => 'Top left',
								'value' => 'top-0 start-0'
							],
							[
								'text' => 'Top center',
								'value' => 'top-0 start-50 translate-middle-x'
							],
							[
								'text' => 'Top right',
								'value' => 'top-0 end-0'
							],
							[
								'text' => 'Middle left',
								'value' => 'top-50 start-0 translate-middle-y'
							],
							[
								'text' => 'Middle center',
								'value' => 'top-50 start-50 translate-middle'
							],
							[
								'text' => 'Middle right',
								'value' => 'top-50 end-0 translate-middle-y'
							],
							[
								'text' => 'Bottom left',
								'value' => 'bottom-0 start-0'
							],
							[
								'text' => 'Bottom center',
								'value' => 'bottom-0 start-50 translate-middle-x'
							],
							[
								'text' => 'Bottom right',
								'value' => 'bottom-0 end-0'
							]
						]
					]
				]
			]),
			$aviHtmlElement->tag('div', [
				'aria' => [
					'atomic' => 'true',
					'live' => 'polite'
				],
				'class' => [
					'bg-body-secondary',
					'position-relative',
					'bd-example-toasts',
					'rounded-3'
				]
			])->content(
				$aviHtmlElement->tag('div', [
					'class' => [
						'toast-container',
						'p-3'
					],
					'id' => 'toastPlacement'
				])->content(
					$aviHtmlElement->element('BsToast', [
						'icon' => 'airplane',
						'info' => '11 mins ago',
						'title' => 'Bootstrap'
					])->content('Hello, world! This is a toast message.')
				)
			)
		]);
		$this->assertEquals($test, $result);


	}

}