<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsOffcanvas extends TestCase
{

	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div class="offcanvas offcanvas-start" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" type="button">',
			'</button>',
			'</div>',
			'<div class="offcanvas-body">',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsOffcanvas')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div aria-labelledby="offcanvas-id-label" class="offcanvas offcanvas-start" id="offcanvas-id" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="offcanvas-id-label">',
			'Offcanvas Title',
			'</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas-id" type="button">',
			'</button>',
			'</div>',
			'<div class="offcanvas-body">',
			'Offcanvas content',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsOffcanvas', [
			'body' => 'Offcanvas content',
			'id' => 'offcanvas-id',
			'title' => 'Offcanvas Title',
		])->use();
		$this->assertEquals($test, $result);
	}


	/**
	 * @see https://getbootstrap.com/docs/5.3/components/modal/
	 */
	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//#Offcanvas components
		$test = implode('', [
			'<div aria-labelledby="offcanvas-label" class="offcanvas offcanvas-start show" id="offcanvas" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="offcanvas-label">Offcanvas</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas" type="button"></button>',
			'</div>',
			'<div class="offcanvas-body">',
			'Content for the offcanvas goes here. You can place just about any Bootstrap component or custom elements here.',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsOffcanvas', [
			'id' => 'offcanvas',
			'title' => 'Offcanvas',
			'body' => 'Content for the offcanvas goes here. You can place just about any Bootstrap component or custom elements here.',
		])->attributes([
			'class' => [
				'show' // is visible
			]
		])->use();
		$this->assertEquals($test, $result);


		//Live demo
		$test = implode('', [
			'<a aria-controls="offcanvasExample" class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button">',
			'Link with href',
			'</a>',

			'<button aria-controls="offcanvasExample" class="btn btn-primary" data-bs-target="#offcanvasExample" data-bs-toggle="offcanvas" type="button">',
			'Button with data-bs-target',
			'</button>',

			'<div aria-labelledby="offcanvasExample-label" class="offcanvas offcanvas-start" id="offcanvasExample" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="offcanvasExample-label">Offcanvas</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasExample" type="button"></button>',
			'</div>',
			'<div class="offcanvas-body">',
			'<div>',
			'Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.',
			'</div>',
			'<div class="dropdown mt-3">',
			'<button aria-expanded="false" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown button',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'</ul>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'attr' => [
					'aria' => [
						'controls' => 'offcanvasExample'
					],
					'data' => [
						'bs-toggle' => 'offcanvas'
					]
				],
				'href' => '#offcanvasExample',
				'tag' => 'a',
				'variant' => 'primary'
			])->content('Link with href'),

			$aviHtmlElement->element('BsButton', [
				'attr' => [
					'aria' => [
						'controls' => 'offcanvasExample'
					],
					'data' => [
						'bs-target' => '#offcanvasExample',
						'bs-toggle' => 'offcanvas'
					]
				],
				'variant' => 'primary'
			])->content('Button with data-bs-target'),

			$aviHtmlElement->element('BsOffcanvas', [
				'body' => [
					$aviHtmlElement->tag('div')
					->content('Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.'),
					$aviHtmlElement->element('BsDropdown')
					->attributes([
						'class' => [
							'mt-3'
						]
					])
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
							]
						]
					])->use()
				],
				'id' => 'offcanvasExample',
				'title' => 'Offcanvas'
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Body scrolling
		$test = implode('', [
			'<button aria-controls="offcanvasScrolling" class="btn btn-primary" data-bs-target="#offcanvasScrolling" data-bs-toggle="offcanvas" type="button">Enable body scrolling</button>',

			'<div aria-labelledby="offcanvasScrolling-label" class="offcanvas offcanvas-start" data-bs-backdrop="false" data-bs-scroll="true" id="offcanvasScrolling" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="offcanvasScrolling-label">Offcanvas with body scrolling</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasScrolling" type="button"></button>',
			'</div>',
			'<div class="offcanvas-body">',
			'<p>Try scrolling the rest of the page to see this option in action.</p>',
			'</div>',
			'</div>'
		]);

		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'attr' => [
					'aria' => [
						'controls' => 'offcanvasScrolling'
					],
					'data' => [
						'bs-target' => '#offcanvasScrolling',
						'bs-toggle' => 'offcanvas'
					]
				],
				'variant' => 'primary'
			])->content('Enable body scrolling'),

			$aviHtmlElement->element('BsOffcanvas', [
				'backdrop' => false,
				'body' => $aviHtmlElement->tag('p')
					->content('Try scrolling the rest of the page to see this option in action.'),
				'id' => 'offcanvasScrolling',
				'scroll' => true,
				'title' => 'Offcanvas with body scrolling'
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Body scrolling and backdrop
		$test = implode('', [
			'<button aria-controls="offcanvasWithBothOptions" class="btn btn-primary" data-bs-target="#offcanvasWithBothOptions" data-bs-toggle="offcanvas" type="button">Enable both scrolling & backdrop</button>',

			'<div aria-labelledby="offcanvasWithBothOptions-label" class="offcanvas offcanvas-start" data-bs-scroll="true" id="offcanvasWithBothOptions" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="offcanvasWithBothOptions-label">Backdrop with scrolling</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasWithBothOptions" type="button"></button>',
			'</div>',
			'<div class="offcanvas-body">',
			'<p>Try scrolling the rest of the page to see this option in action.</p>',
			'</div>',
			'</div>'
		]);

		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'attr' => [
					'aria' => [
						'controls' => 'offcanvasWithBothOptions'
					],
					'data' => [
						'bs-target' => '#offcanvasWithBothOptions',
						'bs-toggle' => 'offcanvas'
					]
				],
				'variant' => 'primary'
			])->content('Enable both scrolling & backdrop'),

			$aviHtmlElement->element('BsOffcanvas', [
				'body' => $aviHtmlElement->tag('p'
					)->content('Try scrolling the rest of the page to see this option in action.'),
				'id' => 'offcanvasWithBothOptions',
				'scroll' => true,
				'title' => 'Backdrop with scrolling'
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Static backdrop
		$test = implode('', [
			'<button aria-controls="staticBackdrop" class="btn btn-primary" data-bs-target="#staticBackdrop" data-bs-toggle="offcanvas" type="button">',
			'Toggle static offcanvas',
			'</button>',

			'<div aria-labelledby="staticBackdrop-label" class="offcanvas offcanvas-start" data-bs-backdrop="static" id="staticBackdrop" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="staticBackdrop-label">Offcanvas</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#staticBackdrop" type="button"></button>',
			'</div>',
			'<div class="offcanvas-body">',
			'<div>',
			'I will not close if you click outside of me.',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'attr' => [
					'aria' => [
						'controls' => 'staticBackdrop'
					],
					'data' => [
						'bs-target' => '#staticBackdrop',
						'bs-toggle' => 'offcanvas'
					]
				],
				'variant' => 'primary'
			])->content('Toggle static offcanvas'),

			$aviHtmlElement->element('BsOffcanvas', [
				'backdrop' => 'static',
				'body' => $aviHtmlElement->tag('div'
					)->content('I will not close if you click outside of me.'),
				'id' => 'staticBackdrop',
				'title' => 'Offcanvas'
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Responsive
		$test = implode('', [
			'<button aria-controls="offcanvasResponsive" class="btn btn-primary d-lg-none" data-bs-target="#offcanvasResponsive" data-bs-toggle="offcanvas" type="button">Toggle offcanvas</button>',

			'<div class="alert alert-info d-lg-block d-none" role="alert">Resize your browser to show the responsive offcanvas toggle.</div>',

			'<div aria-labelledby="offcanvasResponsive-label" class="offcanvas-end offcanvas-lg" id="offcanvasResponsive" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="offcanvasResponsive-label">Responsive offcanvas</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" type="button"></button>',
			'</div>',
			'<div class="offcanvas-body">',
			'<p class="mb-0">This is content within an <code>.offcanvas-lg</code>.</p>',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'attr' => [
					'aria' => [
						'controls' => 'offcanvasResponsive'
					],
					'class' => [
						'd-lg-none'
					],
					'data' => [
						'bs-target' => '#offcanvasResponsive',
						'bs-toggle' => 'offcanvas'
					]
				],
				'variant' => 'primary'
			])->content('Toggle offcanvas'),

			$aviHtmlElement->element('BsAlert', [
				'attr' => [
					'class' => [
						'd-none',
						'd-lg-block'
					]
				],
				'variant' => 'info'
			])->content('Resize your browser to show the responsive offcanvas toggle.'),


			$aviHtmlElement->element('BsOffcanvas', [
				'breakpoint' => 'lg',
				'body' => $aviHtmlElement->tag('p', [
					'class' => 'mb-0'
				])->content('This is content within an <code>.offcanvas-lg</code>.'),
				'id' => 'offcanvasResponsive',
				'placement' => 'end',
				'title' => 'Responsive offcanvas'
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Placement
		$test = implode('', [
			'<button aria-controls="offcanvasTop" class="btn btn-primary" data-bs-target="#offcanvasTop" data-bs-toggle="offcanvas" type="button">Toggle top offcanvas</button>',

			'<div aria-labelledby="offcanvasTop-label" class="offcanvas offcanvas-top" id="offcanvasTop" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="offcanvasTop-label">Offcanvas top</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasTop" type="button"></button>',
			'</div>',
			'<div class="offcanvas-body">',
			'...',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'attr' => [
					'aria' => [
						'controls' => 'offcanvasTop'
					],
					'data' => [
						'bs-target' => '#offcanvasTop',
						'bs-toggle' => 'offcanvas'
					]
				],
				'variant' => 'primary'
			])->content('Toggle top offcanvas'),
			$aviHtmlElement->element('BsOffcanvas', [
				'id' => 'offcanvasTop',
				'placement' => 'top',
				'title' => 'Offcanvas top',
			])->content('...')
		]);
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<button aria-controls="offcanvasRight" class="btn btn-primary" data-bs-target="#offcanvasRight" data-bs-toggle="offcanvas" type="button">Toggle right offcanvas</button>',

			'<div aria-labelledby="offcanvasRight-label" class="offcanvas offcanvas-end" id="offcanvasRight" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="offcanvasRight-label">Offcanvas right</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasRight" type="button"></button>',
			'</div>',
			'<div class="offcanvas-body">',
			'...',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'attr' => [
					'aria' => [
						'controls' => 'offcanvasRight'
					],
					'data' => [
						'bs-target' => '#offcanvasRight',
						'bs-toggle' => 'offcanvas'
					]
				],
				'variant' => 'primary'
			])->content('Toggle right offcanvas'),
			$aviHtmlElement->element('BsOffcanvas', [
				'id' => 'offcanvasRight',
				'placement' => 'end',
				'title' => 'Offcanvas right',
			])->content('...')
		]);
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<button aria-controls="offcanvasBottom" class="btn btn-primary" data-bs-target="#offcanvasBottom" data-bs-toggle="offcanvas" type="button">Toggle bottom offcanvas</button>',

			'<div aria-labelledby="offcanvasBottom-label" class="offcanvas offcanvas-bottom" id="offcanvasBottom" tabindex="-1">',
			'<div class="offcanvas-header">',
			'<h5 class="offcanvas-title" id="offcanvasBottom-label">Offcanvas bottom</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasBottom" type="button"></button>',
			'</div>',
			'<div class="offcanvas-body">',
			'...',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'attr' => [
					'aria' => [
						'controls' => 'offcanvasBottom'
					],
					'data' => [
						'bs-target' => '#offcanvasBottom',
						'bs-toggle' => 'offcanvas'
					]
				],
				'variant' => 'primary'
			])->content('Toggle bottom offcanvas'),
			$aviHtmlElement->element('BsOffcanvas', [
				'id' => 'offcanvasBottom',
				'placement' => 'bottom',
				'title' => 'Offcanvas bottom',
			])->content('...')
		]);
		$this->assertEquals($test, $result);



	}

}
