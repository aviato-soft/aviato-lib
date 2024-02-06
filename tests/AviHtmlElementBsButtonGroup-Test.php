<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsButtonGroup extends TestCase
{

	public function testFn_HtmlElementBsButton()
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Button group full test
/*
		$test = implode('', [
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
		])->use();
		$this->assertEquals($test, $result);
*/

		//button basic
		$test = '<div class="btn-group" role="group"></div>';
		$result = $aviHtmlElement->element('BsButtonGroup')->use();
		$this->assertEquals($test, $result);


		//invalid attributes

		//Basic example
		$test = implode('', [
			'<div aria-label="Basic example" class="btn-group" role="group">',
			'<button class="btn btn-primary" type="button">Left</button>',
			'<button class="btn btn-primary" type="button">Middle</button>',
			'<button class="btn btn-primary" type="button">Right</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'items' => [
				[
					'text' => 'Left',
					'variant' => 'primary'
				],
				$aviHtmlElement->element('BsButton', [
					'text' => 'Middle',
					'variant' => 'primary'
				]),
				[
					'text' => 'Right',
					'variant' => 'primary'
				]
			],
			'label' => 'Basic example'
		])->use();
		$this->assertEquals($test, $result);


		//Basic example with links
		$test = implode('', [
			'<div class="btn-group">',
			'<a aria-current="page" aria-pressed="true" class="active btn btn-primary" href="#" role="button">Active link</a>',
			'<a class="btn btn-primary" href="#" role="button">Link</a>',
			'<a class="btn btn-primary" href="#" role="button">Link</a>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'items' => [
				[
					'active' => true,
					'attr' => [
						'aria' => [
							'current' => 'page'
						]
					],
					'href' => '#',
					'tag' => 'a',
					'text' => 'Active link',
					'variant' => 'primary'
				],
				$aviHtmlElement->element('BsButton', [
					'href' => '#',
					'tag' => 'a',
					'text' => 'Link',
					'variant' => 'primary'
				]),
				[
					'href' => '#',
					'tag' => 'a',
					'text' => 'Link',
					'variant' => 'primary'
				]
			],
			'role' => false
		])->use();
		$this->assertEquals($test, $result);


		//Mixewd styles
		$test = implode('', [
			'<div aria-label="Basic mixed styles example" class="btn-group" role="group">',
			'<button class="btn btn-danger" type="button">Left</button>',
			'<button class="btn btn-warning" type="button">Middle</button>',
			'<button class="btn btn-success" type="button">Right</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'label' => 'Basic mixed styles example'
		])
		->items([
			[
				'text' => 'Left',
				'variant' => 'danger'
			],
			[
				'text' => 'Middle',
				'variant' => 'warning'
			],
			[
				'text' => 'Right',
				'variant' => 'success'
			]
		])
		->use();
		$this->assertEquals($test, $result);


		//Outlined styles
		$test = implode('', [
			'<div aria-label="Basic outlined example" class="btn-group" role="group">',
			'<button class="btn btn-outline-primary" type="button">Left</button>',
			'<button class="btn btn-outline-primary" type="button">Middle</button>',
			'<button class="btn btn-outline-primary" type="button">Right</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'label' => 'Basic outlined example'
		])
		->items([
			[
				'outline' => true,
				'text' => 'Left',
				'variant' => 'primary'
			],
			[
				'outline' => true,
				'text' => 'Middle',
				'variant' => 'primary'
			],
			[
				'outline' => true,
				'text' => 'Right',
				'variant' => 'primary'
			]
		])
		->use();
		$this->assertEquals($test, $result);


		//Checkbox
		$test = implode('', [
			'<div aria-label="Basic checkbox toggle button group" class="btn-group" role="group">',
			'<input autocomplete="off" class="btn-check" id="btncheck1" type="checkbox">',
			'<label class="btn btn-outline-primary" for="btncheck1">Checkbox 1</label>',

			'<input autocomplete="off" class="btn-check" id="btncheck2" type="checkbox">',
			'<label class="btn btn-outline-primary" for="btncheck2">Checkbox 2</label>',

			'<input autocomplete="off" class="btn-check" id="btncheck3" type="checkbox">',
			'<label class="btn btn-outline-primary" for="btncheck3">Checkbox 3</label>',

			'</div>'
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'label' => 'Basic checkbox toggle button group'
		])
		->items([
			$aviHtmlElement->element('BsInputCheckbox', [
				'id' => 'btncheck1',
				'label' => 'Checkbox 1',
				'outline' => true,
				'role' => 'button',
				'variant' => 'primary'
			]),
			$aviHtmlElement->element('BsInputCheckbox', [
				'id' => 'btncheck2',
				'label' => 'Checkbox 2',
				'outline' => true,
				'role' => 'button',
				'variant' => 'primary'
			]),
			$aviHtmlElement->element('BsInputCheckbox', [
				'id' => 'btncheck3',
				'label' => 'Checkbox 3',
				'outline' => true,
				'role' => 'button',
				'variant' => 'primary'
			])
		])->use();
		$this->assertEquals($test, $result);


		//Radio
		$test = implode('', [
			'<div aria-label="Basic radio toggle button group" class="btn-group" role="group">',
			'<input autocomplete="off" class="btn-check" id="btnradio1" name="btnradio" type="radio" checked>',
			'<label class="btn btn-outline-primary" for="btnradio1">Radio 1</label>',

			'<input autocomplete="off" class="btn-check" id="btnradio2" name="btnradio" type="radio">',
			'<label class="btn btn-outline-primary" for="btnradio2">Radio 2</label>',

			'<input autocomplete="off" class="btn-check" id="btnradio3" name="btnradio" type="radio">',
			'<label class="btn btn-outline-primary" for="btnradio3">Radio 3</label>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'label' => 'Basic radio toggle button group'
		])
		->items([
			$aviHtmlElement->element('BsInputRadio', [
				'checked' => true,
				'id' => 'btnradio1',
				'label' => 'Radio 1',
				'name' => 'btnradio',
				'outline' => true,
				'role' => 'button',
				'variant' => 'primary'
			]),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'btnradio2',
				'label' => 'Radio 2',
				'name' => 'btnradio',
				'outline' => true,
				'role' => 'button',
				'variant' => 'primary'
			]),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'btnradio3',
				'label' => 'Radio 3',
				'name' => 'btnradio',
				'outline' => true,
				'role' => 'button',
				'variant' => 'primary'
			]),
		])->use();
		$this->assertEquals($test, $result);


		//Button toolbar
		$test = implode('', [
			'<div aria-label="Toolbar with button groups" class="btn-toolbar" role="toolbar">',
			'<div aria-label="First group" class="btn-group me-2" role="group">',
			'<button class="btn btn-primary" type="button">1</button>',
			'<button class="btn btn-primary" type="button">2</button>',
			'<button class="btn btn-primary" type="button">3</button>',
			'<button class="btn btn-primary" type="button">4</button>',
			'</div>',
			'<div aria-label="Second group" class="btn-group me-2" role="group">',
			'<button class="btn btn-secondary" type="button">5</button>',
			'<button class="btn btn-secondary" type="button">6</button>',
			'<button class="btn btn-secondary" type="button">7</button>',
			'</div>',
			'<div aria-label="Third group" class="btn-group" role="group">',
			'<button class="btn btn-info" type="button">8</button>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
			->attributes([
				'aria' => [
					'label' => 'Toolbar with button groups'
				],
				'class' => 'btn-toolbar',
				'role' => 'toolbar'
			])
			->content([
				$aviHtmlElement->element('BsButtonGroup', [
					'label' => 'First group'
				])
				->attributes([
					'class' => [
						'me-2'
					]
				])
				->items([
					$aviHtmlElement->element('BsButton', [
						'text' => '1',
						'variant' => 'primary'
					]),
					$aviHtmlElement->element('BsButton', [
						'text' => '2',
						'variant' => 'primary'
					]),
					$aviHtmlElement->element('BsButton', [
						'text' => '3',
						'variant' => 'primary'
					]),
					$aviHtmlElement->element('BsButton', [
						'text' => '4',
						'variant' => 'primary'
					]),
				])
				->use(),

				$aviHtmlElement->element('BsButtonGroup', [
					'label' => 'Second group'
				])
				->attributes([
					'class' => [
						'me-2'
					]
				])
				->items([
					$aviHtmlElement->element('BsButton', [
						'text' => '5',
						'variant' => 'secondary'
					]),
					$aviHtmlElement->element('BsButton', [
						'text' => '6',
						'variant' => 'secondary'
					]),
					$aviHtmlElement->element('BsButton', [
						'text' => '7',
						'variant' => 'secondary'
					])
				])
				->use(),

				$aviHtmlElement->element('BsButtonGroup', [
					'label' => 'Third group'
				])
				->items([
					$aviHtmlElement->element('BsButton', [
						'text' => '8',
						'variant' => 'info'
					])
				])
				->use()
			]);
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<div aria-label="Toolbar with button groups" class="btn-toolbar mb-3" role="toolbar">',

			'<div aria-label="First group" class="btn-group me-2" role="group">',
			'<button class="btn btn-outline-secondary" type="button">1</button>',
			'<button class="btn btn-outline-secondary" type="button">2</button>',
			'<button class="btn btn-outline-secondary" type="button">3</button>',
			'<button class="btn btn-outline-secondary" type="button">4</button>',
			'</div>',

			'<div class="input-group">',
			'<div class="input-group-text" id="btnGroupAddon">@</div>',
			'<input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">',
			'</div>',

			'</div>',

			'<div aria-label="Toolbar with button groups" class="btn-toolbar justify-content-between" role="toolbar">',
			'<div aria-label="First group" class="btn-group" role="group">',
			'<button class="btn btn-outline-secondary" type="button">1</button>',
			'<button class="btn btn-outline-secondary" type="button">2</button>',
			'<button class="btn btn-outline-secondary" type="button">3</button>',
			'<button class="btn btn-outline-secondary" type="button">4</button>',
			'</div>',
			'<div class="input-group">',
			'<div class="input-group-text" id="btnGroupAddon2">@</div>',
			'<input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon2">',
			'</div>',

			'</div>'
		]);

		$result = implode('', [
			$aviHtmlElement->tag('div')->attributes([
				'aria' => [
					'label' => 'Toolbar with button groups'
				],
				'class' => [
					'btn-toolbar',
					'mb-3'
				],
				'role' => 'toolbar'
			])
			->content([
				$aviHtmlElement->element('BsButtonGroup', [
					'label' => 'First group'
				])->items([
					$aviHtmlElement->element('BsButton', [
						'outline' => true,
						'text' => '1',
						'variant' => 'secondary'
					]),
					$aviHtmlElement->element('BsButton', [
						'outline' => true,
						'text' => '2',
						'variant' => 'secondary'
					]),
					$aviHtmlElement->element('BsButton', [
						'outline' => true,
						'text' => '3',
						'variant' => 'secondary'
					]),
					$aviHtmlElement->element('BsButton', [
						'outline' => true,
						'text' => '4',
						'variant' => 'secondary'
					]),
				])->attributes(
					['class' => [
						'me-2'
					]
				])->use(),
				implode('', [
					'<div class="input-group">',
					'<div class="input-group-text" id="btnGroupAddon">@</div>',
					'<input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">',
					'</div>'
				])
			]),

			$aviHtmlElement->tag('div')->attributes([
				'aria' => [
					'label' => 'Toolbar with button groups'
				],
				'class' => [
					'btn-toolbar',
					'justify-content-between'
				],
				'role' => 'toolbar'
			])
			->content([
				$aviHtmlElement->element('BsButtonGroup', [
					'label' => 'First group'
				])->items([
					$aviHtmlElement->element('BsButton', [
						'outline' => true,
						'text' => '1',
						'variant' => 'secondary'
					]),
					$aviHtmlElement->element('BsButton', [
						'outline' => true,
						'text' => '2',
						'variant' => 'secondary'
					]),
					$aviHtmlElement->element('BsButton', [
						'outline' => true,
						'text' => '3',
						'variant' => 'secondary'
					]),
					$aviHtmlElement->element('BsButton', [
						'outline' => true,
						'text' => '4',
						'variant' => 'secondary'
					]),
				])->use(),
				implode('', [
					'<div class="input-group">',
					'<div class="input-group-text" id="btnGroupAddon2">@</div>',
					'<input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon2">',
					'</div>'
				])
			])
		]);
		$this->assertEquals($test, $result);


		//Sizing
		$test = implode('', [
			'<div aria-label="Large button group" class="btn-group btn-group-lg" role="group">',
			'<button class="btn btn-outline-primary" type="button">Left</button>',
			'<button class="btn btn-outline-primary" type="button">Middle</button>',
			'<button class="btn btn-outline-primary" type="button">Right</button>',
			'</div>',

			'<div aria-label="Default button group" class="btn-group" role="group">',
			'<button class="btn btn-outline-primary" type="button">Left</button>',
			'<button class="btn btn-outline-primary" type="button">Middle</button>',
			'<button class="btn btn-outline-primary" type="button">Right</button>',
			'</div>',

			'<div aria-label="Small button group" class="btn-group btn-group-sm" role="group">',
			'<button class="btn btn-outline-primary" type="button">Left</button>',
			'<button class="btn btn-outline-primary" type="button">Middle</button>',
			'<button class="btn btn-outline-primary" type="button">Right</button>',
			'</div>'
		]);
		$items = [
			$aviHtmlElement->element('BsButton', [
				'outline' => true,
				'text' => 'Left',
				'variant' => 'primary'
			]),
			$aviHtmlElement->element('BsButton', [
				'outline' => true,
				'text' => 'Middle',
				'variant' => 'primary'
			]),
			$aviHtmlElement->element('BsButton', [
				'outline' => true,
				'text' => 'Right',
				'variant' => 'primary'
			])
		];
		$result = implode('', [
			$aviHtmlElement->element('BsButtonGroup', [
				'label' => 'Large button group',
				'size' => 'lg'
			])->items($items)->use(),
			$aviHtmlElement->element('BsButtonGroup', [
				'label' => 'Default button group',
			])->items($items)->use(),
			$aviHtmlElement->element('BsButtonGroup', [
				'label' => 'Small button group',
				'size' => 'sm'
			])->items($items)->use(),
		]);
		$this->assertEquals($test, $result);


		//Nesting
		$test = implode('', [
			'<div aria-label="Button group with nested dropdown" class="btn-group" role="group">',
			'<button class="btn btn-primary" type="button">1</button>',
			'<button class="btn btn-primary" type="button">2</button>',

			'<div class="btn-group" role="group">',
			'<button aria-expanded="false" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'</ul>',
			'</div>',
			'</div>'
		]);

/*
 * WIP[...]
 */
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'label' => 'Button group with nested dropdown'
		])->items([
			$aviHtmlElement->element('BsButton', [
				'text' => '1',
				'variant' => 'primary'
			]),
			$aviHtmlElement->element('BsButton', [
				'text' => '2',
				'variant' => 'primary'
			]),
			$aviHtmlElement->element('BsDropdown', [
				'group' => true
			])
			->button([
				'text' => 'Dropdown',
				'variant' => 'primary'
			])
			->menu([
				'items' => [
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
				]
			])
			->attributes([
				'role' => 'group'
			])
		])->use();
		$this->assertEquals($test, $result);



		//Vertical variation
		$test = implode('', [
			'<div aria-label="Vertical button group" class="btn-group-vertical" role="group">',
			'<button class="btn btn-primary" type="button">Button</button>',
			'<button class="btn btn-primary" type="button">Button</button>',
			'<button class="btn btn-primary" type="button">Button</button>',
			'<button class="btn btn-primary" type="button">Button</button>',
			'</div>'
		]);
		$button = $aviHtmlElement->element('BsButton', [
			'text' => 'Button',
			'variant' => 'primary'
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'label' => 'Vertical button group',
			'vertical' => true
		])->items([
			$button,
			$button,
			$button,
			$button
		])->use();
		$this->assertEquals($test, $result);

/**
 * WIP[...]
 */
		$test = implode('', [
			'<div aria-label="Vertical button group" class="btn-group-vertical" role="group">',
			'<button class="btn btn-primary" type="button">Button</button>',
			'<button class="btn btn-primary" type="button">Button</button>',
			'<div class="btn-group" role="group">',
			'<button aria-expanded="false" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'</ul>',
			'</div>',
			'<div class="btn-group dropstart" role="group">',
			'<button aria-expanded="false" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'</ul>',
			'</div>',
			'<div class="btn-group dropend" role="group">',
			'<button aria-expanded="false" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'</ul>',
			'</div>',
			'<div class="btn-group dropup" role="group">',
			'<button aria-expanded="false" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" type="button">',
			'Dropdown',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'<li><a class="dropdown-item" href="#">Dropdown link</a></li>',
			'</ul>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'label' => 'Vertical button group',
			'vertical' => true
		])->items([
			$button,
			$button,
			$aviHtmlElement->element('BsDropdown', [
				'group' => true
			])
			->button([
				'text' => 'Dropdown',
				'variant' => 'primary'
			])
			->menu([
				'items' => [
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
				]
			])
			->attributes([
				'role' => 'group'
			]),
			$aviHtmlElement->element('BsDropdown', [
				'drop' => 'start',
				'group' => true
			])
			->button([
				'text' => 'Dropdown',
				'variant' => 'primary'
			])
			->menu([
				'items' => [
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
				]
			])
			->attributes([
				'role' => 'group'
			]),
			$aviHtmlElement->element('BsDropdown', [
				'drop' => 'end',
				'group' => true
			])
			->button([
				'text' => 'Dropdown',
				'variant' => 'primary'
			])
			->menu([
				'items' => [
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
				]
			])
			->attributes([
				'role' => 'group'
			]),
			$aviHtmlElement->element('BsDropdown', [
				'drop' => 'up',
				'group' => true
			])
			->button([
				'text' => 'Dropdown',
				'variant' => 'primary'
			])
			->menu([
				'items' => [
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
					[
						'href' => '#',
						'text' => 'Dropdown link',
						'type' => 'link'
					],
				]
			])
			->attributes([
				'role' => 'group'
			])
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div aria-label="Vertical radio toggle button group" class="btn-group-vertical" role="group">',
			'<input autocomplete="off" class="btn-check" id="vbtn-radio1" name="vbtn-radio" type="radio" checked>',
			'<label class="btn btn-outline-danger" for="vbtn-radio1">Radio 1</label>',
			'<input autocomplete="off" class="btn-check" id="vbtn-radio2" name="vbtn-radio" type="radio">',
			'<label class="btn btn-outline-danger" for="vbtn-radio2">Radio 2</label>',
			'<input autocomplete="off" class="btn-check" id="vbtn-radio3" name="vbtn-radio" type="radio">',
			'<label class="btn btn-outline-danger" for="vbtn-radio3">Radio 3</label>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsButtonGroup', [
			'label' => 'Vertical radio toggle button group',
			'vertical' => true
		])
		->items([
			$aviHtmlElement->element('BsInputRadio', [
				'checked' => true,
				'id' => 'vbtn-radio1',
				'label' => 'Radio 1',
				'name' => 'vbtn-radio',
				'outline' => true,
				'role' => 'button',
				'variant' => 'danger'
			]),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'vbtn-radio2',
				'label' => 'Radio 2',
				'name' => 'vbtn-radio',
				'outline' => true,
				'role' => 'button',
				'variant' => 'danger'
			]),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'vbtn-radio3',
				'label' => 'Radio 3',
				'name' => 'vbtn-radio',
				'outline' => true,
				'role' => 'button',
				'variant' => 'danger'
			])
		])
		->use();
		$this->assertEquals($test, $result);
	}
}

