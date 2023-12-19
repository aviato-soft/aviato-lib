<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_BREAKPOINT;
use PhpParser\Node\Stmt\Foreach_;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsListGroup extends TestCase
{

	public function testFn_Construct(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Basic example
		$test = implode('', [
			'<ul class="list-group">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'<li class="list-group-item">A fourth item</li>',
			'<li class="list-group-item">And a fifth one</li>',
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'items' => [
			[
				'text' => 'An item'
			],
			[
				'text' => 'A second item'
			],
			[
				'text' => 'A third item'
			],
			[
				'text' => 'A fourth item'
			],
			[
				'text' => 'And a fifth one'
			]
		]])->use();
		$this->assertEquals($test, $result);


		//items in content
		$result = $aviHtmlElement->element('BsListGroup') ->content([
				[
					'text' => 'An item'
				],
				[
					'text' => 'A second item'
				],
				[
					'text' => 'A third item'
				],
				[
					'text' => 'A fourth item'
				],
				[
					'text' => [
						'And ',
						'a fifth one'
					]
				]
			]);
		$this->assertEquals($test, $result);


		//Active items
		$test = implode('', [
			'<ul class="list-group">',
			'<li aria-current="true" class="active list-group-item">An active item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'<li class="list-group-item">A fourth item</li>',
			'<li class="list-group-item">And a fifth one</li>',
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'items' => [
				[
					'active' => true,
					'text' => 'An active item',
				],
				[
					'text' => 'A second item'
				],
				[
					'text' => 'A third item'
				],
				[
					'text' => 'A fourth item'
				],
				[
					'text' => 'And a fifth one'
				]
			]])->use();
			$this->assertEquals($test, $result);


		//Disabled items
		$test = implode('', [
			'<ul class="list-group">',
			'<li aria-disabled="true" class="disabled list-group-item">A disabled item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'<li class="list-group-item">A fourth item</li>',
			'<li class="list-group-item">And a fifth one</li>',
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'items' => [
				[
					'disabled' => true,
					'text' => 'A disabled item'
				],
				[
					'text' => 'A second item'
				],
				[
					'text' => 'A third item'
				],
				[
					'text' => 'A fourth item'
				],
				[
					'text' => 'And a fifth one'
				]
			]
		])->use();
		$this->assertEquals($test, $result);


		//Links and buttons
		$test = implode('', [
			'<div class="list-group">',
			'<a aria-current="true" class="active list-group-item list-group-item-action" href="#">',
			'The current link item',
			'</a>',
			'<a class="list-group-item list-group-item-action" href="#">A second link item</a>',
			'<a class="list-group-item list-group-item-action" href="#">A third link item</a>',
			'<a class="list-group-item list-group-item-action" href="#">A fourth link item</a>',
			'<a aria-disabled="true" class="disabled list-group-item list-group-item-action">A disabled link item</a>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'items' => [
				[
					'active' => true,
					'href' => '#',
					'tag' => 'a',
					'text' => 'The current link item',

				],
				[
					'href' => '#',
					'tag' => 'a',
					'text' => 'A second link item'
				],
				[
					'href' => '#',
					'tag' => 'a',
					'text' => 'A third link item'
				],
				[
					'href' => '#',
					'tag' => 'a',
					'text' => 'A fourth link item'
				],
				[
					'disabled' => true,
					'tag' => 'a',
					'text' => 'A disabled link item'
				]
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="list-group">',
			'<button aria-current="true" class="active list-group-item list-group-item-action" type="button">',
			'The current button',
			'</button>',
			'<button class="list-group-item list-group-item-action" type="button">A second button item</button>',
			'<button class="list-group-item list-group-item-action" type="button">A third button item</button>',
			'<button class="list-group-item list-group-item-action" type="button">A fourth button item</button>',
			'<button class="list-group-item list-group-item-action" disabled type="button">A disabled button item</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'items' => [
				[
					'active' => true,
					'tag' => 'button',
					'text' => 'The current button',

				],
				[
					'tag' => 'button',
					'text' => 'A second button item'
				],
				[
					'tag' => 'button',
					'text' => 'A third button item'
				],
				[
					'href' => '#',
					'tag' => 'button',
					'text' => 'A fourth button item'
				],
				[
					'tag' => 'button',
					'text' => 'A disabled button item',
					'disabled' => true
				]
			]
		])->use();
		$this->assertEquals($test, $result);


		//flush
		$test = implode('', [
			'<ul class="list-group list-group-flush">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'<li class="list-group-item">A fourth item</li>',
			'<li class="list-group-item">And a fifth one</li>',
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'flush' => true,
			'items' => [
				[
					'text' => 'An item'
				],
				[
					'text' => 'A second item'
				],
				[
					'text' => 'A third item'
				],
				[
					'text' => 'A fourth item'
				],
				[
					'text' => 'And a fifth one'
				]
			]])->use();
		$this->assertEquals($test, $result);

		//numbered
		$test = implode('', [
			'<ol class="list-group list-group-numbered">',
			'<li class="list-group-item">A list item</li>',
			'<li class="list-group-item">A list item</li>',
			'<li class="list-group-item">A list item</li>',
			'</ol>'
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'tag' => 'ol',
			'items' => [
				[
					'text' => 'A list item'
				],
				[
					'text' => 'A list item'
				],
				[
					'text' => 'A list item'
				]
			]])->use();
		$this->assertEquals($test, $result);


		//custom template
		$test = implode('', [
			'<ol class="list-group list-group-numbered">',
			'<li class="align-items-start d-flex justify-content-between list-group-item">',
			'<div class="me-auto ms-2">',
			'<div class="fw-bold">Subheading</div>',
			'Content for list item',
			'</div>',
			'<span class="badge bg-primary rounded-pill">14</span>',
			'</li>',
			'<li class="align-items-start d-flex justify-content-between list-group-item">',
			'<div class="me-auto ms-2">',
			'<div class="fw-bold">Subheading</div>',
			'Content for list item',
			'</div>',
			'<span class="badge bg-primary rounded-pill">14</span>',
			'</li>',
			'<li class="align-items-start d-flex justify-content-between list-group-item">',
			'<div class="me-auto ms-2">',
			'<div class="fw-bold">Subheading</div>',
			'Content for list item',
			'</div>',
			'<span class="badge bg-primary rounded-pill">14</span>',
			'</li>',
			'</ol>'
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'tag' => 'ol',

			'template' => $aviHtmlElement->tag('li')
				->attributes([
					'class' => [
						'align-items-start',
						'd-flex',
						'justify-content-between',
						'list-group-item'
					]
				])->content([
					$aviHtmlElement->tag('div')->attributes([
						'class' => [
							'me-auto',
							'ms-2'
						]
					])->content([
						$aviHtmlElement->tag('div')->attributes([
							'class' => 'fw-bold'
						])->content('{subheading}'),
						'{text}'
					]),
					$aviHtmlElement->element('BsBadge', [
						'bg-color' => 'primary',
						'pill' => true,
						'text' => '{badge}',
					])->use()
				]),

			'items' => [
				[
					'badge' => '14',
					'subheading' => 'Subheading',
					'text' => 'Content for list item'
				],
				[
					'badge' => '14',
					'subheading' => 'Subheading',
					'text' => 'Content for list item'
				],
				[
					'badge' => '14',
					'subheading' => 'Subheading',
					'text' => 'Content for list item'
				]
			]
		])->use();
		$this->assertEquals($test, $result);


		//horizontal
		$test = implode('', [
			'<ul class="list-group list-group-horizontal">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>',
			'<ul class="list-group list-group-horizontal-sm">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>',
			'<ul class="list-group list-group-horizontal-md">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>',
			'<ul class="list-group list-group-horizontal-lg">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>',
			'<ul class="list-group list-group-horizontal-xl">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>',
			'<ul class="list-group list-group-horizontal-xxl">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>'
		]);
		$result = [];
		foreach (AVI_BS_BREAKPOINT as $breakpoint) {
			$result[] = $aviHtmlElement->element('BsListGroup', [
				'horizontal' => $breakpoint,
				'items' => [
					[
						'text' => 'An item'
					],
					[
						'text' => 'A second item'
					],
					[
						'text' => 'A third item'
					]
				]])->use();
		}
		$result = implode('', $result);
		$this->assertEquals($test, $result);


	//variant
		$test = implode('', [
			'<ul class="list-group">',
			'<li class="list-group-item">A simple default list group item</li>',
			'<li class="list-group-item list-group-item-primary">A simple primary list group item</li>',
			'<li class="list-group-item list-group-item-secondary">A simple secondary list group item</li>',
			'<li class="list-group-item list-group-item-success">A simple success list group item</li>',
			'<li class="list-group-item list-group-item-danger">A simple danger list group item</li>',
			'<li class="list-group-item list-group-item-warning">A simple warning list group item</li>',
			'<li class="list-group-item list-group-item-info">A simple info list group item</li>',
			'<li class="list-group-item list-group-item-light">A simple light list group item</li>',
			'<li class="list-group-item list-group-item-dark">A simple dark list group item</li>',
			'</ul>'
		]);
		$items = [
			[
				'text' => 'A simple default list group item'
			]
		];
		foreach (AVI_BS_COLOR as $color) {
			$items[] = [
				'color' => $color,
				'text' => sprintf('A simple %s list group item', $color)
			];
		}
		$result = $aviHtmlElement->element('BsListGroup', [
			'items' => $items
		])->use();
		$this->assertEquals($test, $result);


		//bariant for links and buttons
		$test = implode('', [
			'<div class="list-group">',
			'<a class="list-group-item list-group-item-action" href="#">A simple default list group item</a>',
			'<a class="list-group-item list-group-item-action list-group-item-primary" href="#">A simple primary list group item</a>',
			'<a class="list-group-item list-group-item-action list-group-item-secondary" href="#">A simple secondary list group item</a>',
			'<a class="list-group-item list-group-item-action list-group-item-success" href="#">A simple success list group item</a>',
			'<a class="list-group-item list-group-item-action list-group-item-danger" href="#">A simple danger list group item</a>',
			'<a class="list-group-item list-group-item-action list-group-item-warning" href="#">A simple warning list group item</a>',
			'<a class="list-group-item list-group-item-action list-group-item-info" href="#">A simple info list group item</a>',
			'<a class="list-group-item list-group-item-action list-group-item-light" href="#">A simple light list group item</a>',
			'<a class="list-group-item list-group-item-action list-group-item-dark" href="#">A simple dark list group item</a>',
			'<button class="list-group-item list-group-item-action" type="button">A simple default list group item</button>',
			'<button class="list-group-item list-group-item-action list-group-item-primary" type="button">A simple primary list group item</button>',
			'<button class="list-group-item list-group-item-action list-group-item-secondary" type="button">A simple secondary list group item</button>',
			'<button class="list-group-item list-group-item-action list-group-item-success" type="button">A simple success list group item</button>',
			'<button class="list-group-item list-group-item-action list-group-item-danger" type="button">A simple danger list group item</button>',
			'<button class="list-group-item list-group-item-action list-group-item-warning" type="button">A simple warning list group item</button>',
			'<button class="list-group-item list-group-item-action list-group-item-info" type="button">A simple info list group item</button>',
			'<button class="list-group-item list-group-item-action list-group-item-light" type="button">A simple light list group item</button>',
			'<button class="list-group-item list-group-item-action list-group-item-dark" type="button">A simple dark list group item</button>',
			'</div>'
		]);
		$items = [];
		$items [] =	[
			'tag' => 'a',
			'href' => '#',
			'color' => 'invalid',
			'text' => 'A simple default list group item'
		];
		foreach (AVI_BS_COLOR as $color) {
			$items[] = [
				'color' => $color,
				'href' => '#',
				'tag' => 'a',
				'text' => sprintf('A simple %s list group item', $color)
			];
		}
		$items [] =	[
			'tag' => 'button',
			'color' => 'invalid',
			'text' => 'A simple default list group item'
		];
		foreach (AVI_BS_COLOR as $color) {
			$items[] = [
				'color' => $color,
				'tag' => 'button',
				'text' => sprintf('A simple %s list group item', $color)
			];
		}

		$result = $aviHtmlElement->element('BsListGroup', [
			'items' => $items
		])->use();
		$this->assertEquals($test, $result);



		//With badges
		$test = implode('', [
			'<ul class="list-group">',
			'<li class="align-items-center d-flex justify-content-between list-group-item">',
			'A list item',
			'<span class="badge bg-primary rounded-pill">14</span>',
			'</li>',
			'<li class="align-items-center d-flex justify-content-between list-group-item">',
			'A second list item',
			'<span class="badge bg-primary rounded-pill">2</span>',
			'</li>',
			'<li class="align-items-center d-flex justify-content-between list-group-item">',
			'A third list item',
			'<span class="badge bg-primary rounded-pill">1</span>',
			'</li>',
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'template' => $aviHtmlElement->tag('li')
				->attributes([
					'class' => [
						'align-items-center',
						'd-flex',
						'justify-content-between',
						'list-group-item',
					]
				])
				->content([
					'{text}',
					$aviHtmlElement->element('BsBadge', [
						'bg-color' => 'primary',
						'pill' => true,
					])
					->content('{badge}')
				])
		])->content([
			[
				'badge' => '14',
				'text' => 'A list item',
			],
			[
				'badge' => '2',
				'text' => 'A second list item',
			],
			[
				'badge' => '1',
				'text' => 'A third list item',
			]
		]);
		$this->assertEquals($test, $result);


		//Custom content
		$test = implode('', [
			'<div class="list-group">',
			'<a href="#" class="list-group-item list-group-item-action active" aria-current="true">',
			'<div class="d-flex w-100 justify-content-between">',
			'<h5 class="mb-1">List group item heading</h5>',
			'<small>3 days ago</small>',
			'</div>',
			'<p class="mb-1">Some placeholder content in a paragraph.</p>',
			'<small>And some small print.</small>',
			'</a>',
			'<a href="#" class="list-group-item list-group-item-action">',
			'<div class="d-flex w-100 justify-content-between">',
			'<h5 class="mb-1">List group item heading</h5>',
			'<small class="text-body-secondary">3 days ago</small>',
			'</div>',
			'<p class="mb-1">Some placeholder content in a paragraph.</p>',
			'<small class="text-body-secondary">And some muted small print.</small>',
			'</a>',
			'<a href="#" class="list-group-item list-group-item-action">',
			'<div class="d-flex w-100 justify-content-between">',
			'<h5 class="mb-1">List group item heading</h5>',
			'<small class="text-body-secondary">3 days ago</small>',
			'</div>',
			'<p class="mb-1">Some placeholder content in a paragraph.</p>',
			'<small class="text-body-secondary">And some muted small print.</small>',
			'</a>',
			'</div>'
		]);
		$items = [];
		$items[] = [
			'active' => true,
			'text' => [
				'text-header' => 'List group item heading',
				'text-small' => '3 days ago',
				'text-paragraph' => 'Some placeholder content in a paragraph.',
				'text-sub-paragraph' => 'And some small print.'
			]
		];
		$items[] = [
			'text' => [
				'text-header' => 'List group item heading',
				'text-small' => '3 days ago',
				'text-paragraph' => 'Some placeholder content in a paragraph.',
				'text-sub-paragraph' => 'And some small print.'
			]
		];
		$items[] = [
			'text' => [
				'text-header' => 'List group item heading',
				'text-small' => '3 days ago',
				'text-paragraph' => 'Some placeholder content in a paragraph.',
				'text-sub-paragraph' => 'And some small print.'
			]
		];
		$template = implode('', [
			$aviHtmlElement->tag('div')
				->attributes([
					'class' => [
						'd-flex',
						'justify-content-between',
						'w-100'
					]
				])
				->content([
					$aviHtmlElement->tag('h5')->attributes([
							'class' => 'mb-1'
						])
						->content('{text-header}'),
					$aviHtmlElement->tag('small')->content('{text-small}')
				]),
			$aviHtmlElement->tag('p')
				->attributes([
					'class' => 'mb-1'
				])->content('{text-paragraph}'),
			$aviHtmlElement->tag('small')
				->content('{text-sub-paragraph}')
		]);
		$result = $aviHtmlElement->element('BsListGroup', [
			'template-text' => $template,
			'items' => $items
		])->use();


		//Checkboxes and radios
		$test = implode('', [
			'<ul class="list-group">',
			'<li class="list-group-item">',
			'<input class="form-check-input me-1" id="firstCheckbox" type="checkbox" value="">',
			'<label class="form-check-label" for="firstCheckbox">First checkbox</label>',
			'</li>',
			'<li class="list-group-item">',
			'<input class="form-check-input me-1" id="secondCheckbox" type="checkbox" value="">',
			'<label class="form-check-label" for="secondCheckbox">Second checkbox</label>',
			'</li>',
			'<li class="list-group-item">',
			'<input class="form-check-input me-1" id="thirdCheckbox" type="checkbox" value="">',
			'<label class="form-check-label" for="thirdCheckbox">Third checkbox</label>',
			'</li>',
			'</ul>'
		]);
		$template = implode('', [
			$aviHtmlElement->tag('input')
			->attributes([
				'class' => [
					'form-check-input',
					'me-1'
				],
				'id' => '{item-id}',
				'type' => 'checkbox',
				'value' => ''
			])->use(),
			$aviHtmlElement->tag('label')
			->attributes([
				'class' => [
					'form-check-label'
				],
				'for' => '{item-id}',
			])->content('{label}')
		]);
		$items = [];
		$items[] = [
			'text' => [
				'item-id' => 'firstCheckbox',
				'label' => 'First checkbox'
			]
		];
		$items[] = [
			'text' => [
				'item-id' => 'secondCheckbox',
				'label' => 'Second checkbox'
			]
		];
		$items[] = [
			'text' => [
				'item-id' => 'thirdCheckbox',
				'label' => 'Third checkbox'
			]
		];

		$result = $aviHtmlElement->element('BsListGroup', [
			'template-text' => $template,
			'items' => $items
		])->use();
		$this->assertEquals($test, $result);

		//Checkboxes and radios
		$test = implode('', [
			'<ul class="list-group">',
			'<li class="list-group-item">',
			'<input class="form-check-input me-1" id="firstRadio" name="listGroupRadio" type="radio" value="" checked>',
			'<label class="form-check-label" for="firstRadio">First radio</label>',
			'</li>',
			'<li class="list-group-item">',
			'<input class="form-check-input me-1" id="secondRadio" name="listGroupRadio" type="radio" value="" >',
			'<label class="form-check-label" for="secondRadio">Second radio</label>',
			'</li>',
			'<li class="list-group-item">',
			'<input class="form-check-input me-1" id="thirdRadio" name="listGroupRadio" type="radio" value="" >',
			'<label class="form-check-label" for="thirdRadio">Third radio</label>',
			'</li>',
			'</ul>'
		]);
		$template = implode('', [
			$aviHtmlElement->tag('input')
			->attributes([
				'{checked}',
				'class' => [
					'form-check-input',
					'me-1'
				],
				'id' => '{item-id}',
				'name' => 'listGroupRadio',
				'type' => 'radio',
				'value' => ''
			])->use(),
			$aviHtmlElement->tag('label')
			->attributes([
				'class' => [
					'form-check-label'
				],
				'for' => '{item-id}',
			])->content('{label}')
		]);
		$items = [];
		$items[] = [
			'text' => [
				'checked' => 'checked',
				'item-id' => 'firstRadio',
				'label' => 'First radio'
			]
		];
		$items[] = [
			'text' => [
				'checked' => '',
				'item-id' => 'secondRadio',
				'label' => 'Second radio'
			]
		];
		$items[] = [
			'text' => [
				'checked' => '',
				'item-id' => 'thirdRadio',
				'label' => 'Third radio'
			]
		];
		$result = $aviHtmlElement->element('BsListGroup', [
			'template-text' => $template,
			'items' => $items
		])->use();
		$this->assertEquals($test, $result);


		//Checkboxes and radios
		$test = implode('', [
			'<ul class="list-group">',
			'<li class="list-group-item">',
			'<input class="form-check-input me-1" id="firstCheckboxStretched" type="checkbox" value="">',
			'<label class="form-check-label stretched-link" for="firstCheckboxStretched">First checkbox</label>',
			'</li>',
			'<li class="list-group-item">',
			'<input class="form-check-input me-1" id="secondCheckboxStretched" type="checkbox" value="">',
			'<label class="form-check-label stretched-link" for="secondCheckboxStretched">Second checkbox</label>',
			'</li>',
			'<li class="list-group-item">',
			'<input class="form-check-input me-1" id="thirdCheckboxStretched" type="checkbox" value="">',
			'<label class="form-check-label stretched-link" for="thirdCheckboxStretched">Third checkbox</label>',
			'</li>',
			'</ul>'
		]);
		$template = implode('', [
			$aviHtmlElement->tag('input')
			->attributes([
				'class' => [
					'form-check-input',
					'me-1'
				],
				'id' => '{item-id}',
				'type' => 'checkbox',
				'value' => ''
			])->use(),
			$aviHtmlElement->tag('label')
			->attributes([
				'class' => [
					'form-check-label',
					'stretched-link'
				],
				'for' => '{item-id}',
			])->content('{label}')
		]);
		$items = [];
		$items[] = [
			'text' => [
				'item-id' => 'firstCheckboxStretched',
				'label' => 'First checkbox'
			]
		];
		$items[] = [
			'text' => [
				'checked' => '',
				'item-id' => 'secondCheckboxStretched',
				'label' => 'Second checkbox'
			]
		];
		$items[] = [
			'text' => [
				'checked' => '',
				'item-id' => 'thirdCheckboxStretched',
				'label' => 'Third checkbox'
			]
		];
		$result = $aviHtmlElement->element('BsListGroup', [
			'template-text' => $template,
			'items' => $items
		])->use();
		$this->assertEquals($test, $result);

	}
}
