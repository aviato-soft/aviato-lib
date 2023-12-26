<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsNav extends TestCase
{

	public function testFn_Construct(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//full test:
		$test = implode('', [
			'<nav class="justify-content-start nav nav-fill nav-tabs">',
			'<a class="nav-link" href="javascript:;">First Item</a>',
			'<a aria-current="page" class="active nav-link" href="#">Active</a>',
			'<a aria-disabled="true" class="disabled nav-link" href="#" tabindex="-1">Disabled</a>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'align' => 'start',
			'direction' => 'horizontal',
			'fill' => 'fill',
			'interface' => 'tabs',
			'items' => [
				[
					'text' => 'First Item'
				],
				[
					'active' => true,
					'href' => '#',
					'text' => 'Active'
				],
				[
					'disabled' => true,
					'href' => '#',
					'text' => 'Disabled'
				]
			],
			'tag' => 'nav'
		])->use();
		$this->assertEquals($test, $result);


		//empty
		$test = '<nav class="nav"></nav>';
		$result = $aviHtmlElement->element('BsNav')->use();
		$this->assertEquals($test, $result);


		//Base nav
		$testItemsLi = implode('', [
			'<li class="nav-item">',
			'<a aria-current="page" class="active nav-link" href="#">Active</a>',
			'</li>',
			'<li class="nav-item">',
			'<a class="nav-link" href="#">Link</a>',
			'</li>',
			'<li class="nav-item">',
			'<a class="nav-link" href="#">Link</a>',
			'</li>',
			'<li class="nav-item">',
			'<a aria-disabled="true" class="disabled nav-link">Disabled</a>',
			'</li>',
		]);
		$test = implode('', [
			'<ul class="nav">',
			$testItemsLi,
			'</ul>'
		]);
		$testItemsBs = [
			[
				'active' => true,
				'href' => '#',
				'text' => 'Active'
			],
			[
				'href' => '#',
				'text' => 'Link'
			],
			[
				'href' => '#',
				'text' => 'Link'
			],
			[
				'disabled' => true,
				'href' => false,
				'text' => 'Disabled'
			],
		];
		$result = $aviHtmlElement->element('BsNav', [
			'items' => $testItemsBs,
			'tag' => 'ul'
		])
		->use();
		$this->assertEquals($test, $result);


		$testItemsA = implode('', [
			'<a aria-current="page" class="active nav-link" href="#">Active</a>',
			'<a class="nav-link" href="#">Link</a>',
			'<a class="nav-link" href="#">Link</a>',
			'<a aria-disabled="true" class="disabled nav-link">Disabled</a>'
		]);
		$test = implode('', [
			'<nav class="nav">',
			$testItemsA,
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'items' => $testItemsBs
		])
		->use();
		$this->assertEquals($test, $result);


		//Horizontal alignment
		$test = implode('', [
			'<ul class="justify-content-center nav">',
			$testItemsLi,
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'align' => 'center',
			'items' => $testItemsBs,
			'tag' => 'ul'
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<ul class="justify-content-end nav">',
			$testItemsLi,
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'align' => 'end',
			'items' => $testItemsBs,
			'tag' => 'ul'
		])->use();
		$this->assertEquals($test, $result);


		//Vertical
		$test = implode('', [
			'<ul class="flex-column nav">',
			$testItemsLi,
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'direction' => 'vertical',
			'items' => $testItemsBs,
			'tag' => 'ul'
		])->use();
		$test = implode('', [
			'<nav class="flex-md-column nav">',
			$testItemsA,
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'direction' => 'vertical-md',
			'items' => $testItemsBs
		])
		->use();
		$this->assertEquals($test, $result);


		//Tabs
		$test = implode('', [
			'<ul class="nav nav-tabs">',
			$testItemsLi,
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'tabs',
			'items' => $testItemsBs,
			'tag' => 'ul'
		])->use();
		$this->assertEquals($test, $result);


		//Pills
		$test = implode('', [
			'<ul class="nav nav-pills">',
			$testItemsLi,
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'pills',
			'items' => $testItemsBs,
			'tag' => 'ul'
		])->use();
		$this->assertEquals($test, $result);


		//Underline
		$test = implode('', [
			'<ul class="nav nav-underline">',
			$testItemsLi,
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'underline',
			'items' => $testItemsBs,
			'tag' => 'ul'
		])->use();
		$this->assertEquals($test, $result);


		//Fill
		$test = implode('', [
			'<ul class="nav nav-fill nav-pills">',
			$testItemsLi,
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'pills',
			'fill' => 'fill',
			'items' => $testItemsBs,
			'tag' => 'ul'
		])->use();
		$this->assertEquals($test, $result);
		$test = implode('', [
			'<nav class="nav nav-fill nav-pills">',
			$testItemsA,
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'pills',
			'fill' => 'fill',
			'items' => $testItemsBs
		])
		->use();
		$this->assertEquals($test, $result);

		//Fill justified
		$test = implode('', [
			'<ul class="nav nav-justified nav-pills">',
			$testItemsLi,
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'pills',
			'fill' => 'justified',
			'items' => $testItemsBs,
			'tag' => 'ul'
		])->use();
		$test = implode('', [
			'<nav class="nav nav-justified nav-pills">',
			$testItemsA,
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'pills',
			'fill' => 'justified',
			'items' => $testItemsBs
		])
		->use();
		$this->assertEquals($test, $result);


		//Working with flex utilities
		$test = implode('', [
			'<nav class="flex-column flex-sm-row nav nav-pills">',
			'<a aria-current="page" class="active flex-sm-fill nav-link text-sm-center" href="#">Active</a>',
			'<a class="flex-sm-fill nav-link text-sm-center" href="#">Longer nav link</a>',
			'<a class="flex-sm-fill nav-link text-sm-center" href="#">Link</a>',
			'<a aria-disabled="true" class="disabled flex-sm-fill nav-link text-sm-center">Disabled</a>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'pills',
			'items' => [
				[
					'active' => true,
					'attr' => [
						'class' => [
							'flex-sm-fill',
							'text-sm-center'
						]
					],
					'href' => '#',
					'text' => 'Active'
				],
				[
					'attr' => [
						'class' => [
							'flex-sm-fill',
							'text-sm-center'
						]
					],
					'href' => '#',
					'text' => 'Longer nav link'
				],
				[
					'attr' => [
						'class' => [
							'flex-sm-fill',
							'text-sm-center'
						]
					],
					'href' => '#',
					'text' => 'Link'
				],
				[
					'attr' => [
						'class' => [
							'flex-sm-fill',
							'text-sm-center'
						]
					],
					'disabled' => true,
					'href' => false,
					'text' => 'Disabled'
				]
			]
		])
		->attributes([
			'class' => [
				'flex-column',
				'flex-sm-row'
			]
		])
		->use();
		$this->assertEquals($test, $result);


		//Using dropdowns
		$test = implode('', [
			'<ul class="nav nav-tabs">',
			'<li class="nav-item">',
			'<a aria-current="page" class="active nav-link" href="#">Active</a>',
			'</li>',
			'<li class="dropdown nav-item">',
			'<a aria-expanded="false" class="btn dropdown-toggle nav-link" data-bs-toggle="dropdown" href="#" role="button">Dropdown</a>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</li>',
			'<li class="nav-item">',
			'<a class="nav-link" href="#">Link</a>',
			'</li>',
			'<li class="nav-item">',
			'<a aria-disabled="true" class="disabled nav-link">Disabled</a>',
			'</li>',
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'tabs',
			'tag' => 'ul',
			'items' => [
				[
					'active' => true,
					'href' => '#',
					'text' => 'Active'
				],
				$aviHtmlElement->element('BsDropdown', [
					'tag' => 'li',
				])
				->button([
					'attr' => [
						'class' => [
							'nav-link'
						]
					],
					'href' => '#',
					'tag' => 'a',
					'text' => 'Dropdown'
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
						]
					]
				])
				->attributes([
					'class' => [
						'nav-item'
					]
				]),
				[
					'href' => '#',
					'text' => 'Link'
				],
				[
					'disabled' => true,
					'href' => false,
					'text' => 'Disabled'
				],
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<ul class="nav nav-pills">',
			'<li class="nav-item">',
			'<a aria-current="page" class="active nav-link" href="#">Active</a>',
			'</li>',
			'<li class="dropdown nav-item">',
			'<a aria-expanded="false" class="btn dropdown-toggle nav-link" data-bs-toggle="dropdown" href="#" role="button">Dropdown</a>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</li>',
			'<li class="nav-item">',
			'<a class="nav-link" href="#">Link</a>',
			'</li>',
			'<li class="nav-item">',
			'<a aria-disabled="true" class="disabled nav-link" href="javascript:;" tabindex="-1">Disabled</a>',
			'</li>',
			'</ul>'
		]);
		$result = $aviHtmlElement->element('BsNav', [
			'interface' => 'pills',
			'tag' => 'ul',
			'items' => [
				[
					'active' => true,
					'href' => '#',
					'text' => 'Active'
				],
				$aviHtmlElement->element('BsDropdown', [
					'tag' => 'li',
				])
				->button([
					'attr' => [
						'class' => [
							'nav-link'
						]
					],
					'href' => '#',
					'tag' => 'a',
					'text' => 'Dropdown'
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
						]
					]
				])
				->attributes([
					'class' => [
						'nav-item'
					]
				]),
				[
					'href' => '#',
					'text' => 'Link'
				],
				[
					'disabled' => true,
					'text' => 'Disabled'
				],
			]
		])->use();
		$this->assertEquals($test, $result);

	}
}
