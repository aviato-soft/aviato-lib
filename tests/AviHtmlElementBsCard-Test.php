<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsCard extends TestCase
{

	public function testFn_empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = '<div class="card"></div>';
		$result = $aviHtmlElement->element('BsCard')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = implode('', [
			'<div class="card">',
			'<img alt="image for [...]" class="card-img-top" src="...">',
			'<div class="card-header">Card header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Body title</h5>',
			'<h6 class="card-subtitle">Body subtitle</h6>',
			'<p class="card-text">Body text</p>',
			'A simple text',
			'Another simple text',
			'</div>',
			'<div class="card-footer">Card footer</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'Img' => [
						'src' => '...'
					]
				],
				[
					'Header' => 'Card header'
				],
				[
					'Body' => [
						'title' => 'Body title',
						'subtitle' => 'Body subtitle',
						'text' => 'Body text',
						'items' => [
							'A simple text',
							'Another simple text',
						]
					]
				],
				[
					'Footer' => 'Card footer'
				],
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="card">',
			'<img alt="image for ..." class="card-img-top" src="...">',
			'<div class="card-header">Card header</div>',
			'<div class="card-body">',
			'<h5 class="card-title" data-role="card title">Body title</h5>',
			'<h6 class="card-subtitle" data-role="card subtitle">Body subtitle</h6>',
			'<p class="card-text" data-role="card text">Body text</p>',
			'A simple text',
			'Another simple text',
			'</div>',
			'<div class="card-footer">Card footer</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'img' => [
						'alt' => 'image for ...',
						'position' => 'top',
						'src' => '...'
					]
				],
				[
					'header' => 'Card header'
				],
				[
					'body' => [
						'title' => [
							'attr' => [
								'data' => [
									'role'=>'card title'
								]
							],
							'text' => 'Body title',
						],
						'subtitle' => [
							'attr' => [
								'data' => [
									'role'=>'card subtitle'
								]
							],
							'text' => 'Body subtitle',
						],
						'text' => [
							'attr' => [
								'data' => [
									'role'=>'card text'
								]
							],
							'text' => 'Body text',
						],
						'items' => [
							'A simple text',
							'Another simple text',
						]
					]
				],
				[
					'footer' => 'Card footer'
				]
			]
		])
		->use();
		$this->assertEquals($test, $result);
	}

	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();


		//basic card
		$test = implode('', [
			'<div class="card" style="width: 18rem;">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'<a class="btn btn-primary" href="#" role="button">Go somewhere</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'img' => [
						'alt' => '...',
						'src' => '...'
					]
				],
				[
					'body' => [
						'title' => 'Card title',
//						'subtitle' => 'Card sub title',
						'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
						'items' => [
							$aviHtmlElement->element('BsButton', [
								'href' => '#',
								'tag' => 'a',
								'text' => 'Go somewhere',
								'variant' => 'primary'
							])
							->use()
						]
					]
				]
			]
		])
		->attributes([
			'style' => 'width: 18rem;'
		])
		->use();
		$this->assertEquals($test, $result);


		//Content types
		//Content types: Body
		$test = implode('', [
			'<div class="card">',
			'<div class="card-body">',
			'This is some text within a card body.',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'body' => [
						'items' => [
							'This is some text within a card body.'
						]
					]
				]
			]
		])
		->use();
		$this->assertEquals($test, $result);

		//Content types:Titles, text, and links
		$test = implode('', [
			'<div class="card" style="width: 18rem;">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'<a class="card-link" href="#">Card link</a>',
			'<a class="card-link" href="#">Another link</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'body' => [
						'title' => 'Card title',
						'subtitle' => [
							'attr' => [
								'class' => [
									'mb-2',
									'text-body-secondary'
								]
							],
							'text' => 'Card subtitle'
						],
						'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
						'items' => [
							$aviHtmlElement->tag('a')
							->attributes([
								'href' => '#',
								'class' => 'card-link',
							])
							->content('Card link'),
							$aviHtmlElement->tag('a')
							->attributes([
								'href' => '#',
								'class' => 'card-link',
							])
							->content('Another link')
						]
					]
				]
			]
		])
		->attributes([
			'style'=>'width: 18rem;'
		])
		->use();
		$this->assertEquals($test, $result);


		//Content types: Images
		$test = implode('', [
			'<div class="card" style="width: 18rem;">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard',[
			'items' => [
				[
					'img' => [
						'alt' => '...',
						'src' => '...'
					]
				],
				[
					'body' => [
						'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'
					]
				]
			]
		])
		->attributes([
			'style'=>'width: 18rem;'
		])
		->use();
		$this->assertEquals($test, $result);


		//Content types: List groups
		$test = implode('', [
			'<div class="card" style="width: 18rem;">',
			'<ul class="list-group list-group-flush">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'BsListGroup' => [
						'flush' => true,
						'items' => [
							'An item',
							'A second item',
							'A third item'
						]
					]
				]
			]
		])
			->attributes([
				'style'=>'width: 18rem;'
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="card" style="width: 18rem;">',
			'<div class="card-header">',
			'Featured',
			'</div>',
			'<ul class="list-group list-group-flush">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'header' => 'Featured'
				],
				[
					'BsListGroup' => [
						'flush' => true,
						'items' => [
							'An item',
							'A second item',
							'A third item'
						]
					]
				]
			]
		])
		->attributes([
			'style'=>'width: 18rem;'
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="card" style="width: 18rem;">',
			'<ul class="list-group list-group-flush">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>',
			'<div class="card-footer">',
			'Card footer',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'BsListGroup' => [
						'flush' => true,
						'items' => [
							'An item',
							'A second item',
							'A third item'
						]
					]
				],
				[
					'footer' => 'Card footer'
				]
			]
		])
		->attributes([
			'style'=>'width: 18rem;'
		])
		->use();
		$this->assertEquals($test, $result);


		//Kitchen sink
		$test = implode('', [
			'<div class="card" style="width: 18rem;">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'<ul class="list-group list-group-flush">',
			'<li class="list-group-item">An item</li>',
			'<li class="list-group-item">A second item</li>',
			'<li class="list-group-item">A third item</li>',
			'</ul>',
			'<div class="card-body">',
			'<a class="card-link" href="#">Card link</a>',
			'<a class="card-link" href="#">Another link</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'img' => [
						'alt' => '...',
						'src' => '...'
					]
				],
				[
					'body' => [
						'title' => 'Card title',
						'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'
					]
				],
				[
					'BsListGroup' => [
						'flush' => true,
						'items' => [
							'An item',
							'A second item',
							'A third item'
						]
					]
				],
				[
					'body' => [
						'items' => [
							$aviHtmlElement->tag('a')
								->attributes([
									'href' => '#',
									'class' => 'card-link',
								])
							->content('Card link'),
							$aviHtmlElement->tag('a')
								->attributes([
									'href' => '#',
									'class' => 'card-link',
								])
								->content('Another link')
						]
					]
				]
			]
		])
		->attributes([
			'style'=>'width: 18rem;'
		])
		->use();
		$this->assertEquals($test, $result);


		//Header and footer
		$test = implode('', [
			'<div class="card">',
			'<div class="card-header">',
			'Featured',
			'</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Special title treatment</h5>',
			'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>',
			'<a class="btn btn-primary" href="#">Go somewhere</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'header' => 'Featured'
				],
				[
					'body' => [
						'title' => 'Special title treatment',
						'text' => 'With supporting text below as a natural lead-in to additional content.',
						'items' => [
							$aviHtmlElement->tag('a')
							->attributes([
								'class' => [
									'btn',
									'btn-primary'
								],
								'href' => '#',
							])
							->content('Go somewhere')
						]
					]
				]
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="card">',
			'<h5 class="card-header">Featured</h5>',
			'<div class="card-body">',
			'<h5 class="card-title">Special title treatment</h5>',
			'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>',
			'<a class="btn btn-primary" href="#">Go somewhere</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'header' => [
						'content' => 'Featured',
						'tag' => 'h5'
					]
				],
				[
					'body' => [
						'title' => 'Special title treatment',
						'text' => 'With supporting text below as a natural lead-in to additional content.',
						'items' => [
							$aviHtmlElement->tag('a')
							->attributes([
								'class' => [
									'btn',
									'btn-primary'
								],
								'href' => '#',
							])
							->content('Go somewhere')
						]
					]
				]
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="card">',
			'<div class="card-header">',
			'Quote',
			'</div>',
			'<div class="card-body">',
			'<blockquote class="blockquote mb-0">',
			'<p>A well-known quote, contained in a blockquote element.</p>',
			'<footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>',
			'</blockquote>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'header' => 'Quote',
				],
				[
					'body' => [
						'items' => [
							$aviHtmlElement->tag('blockquote')
							->attributes([
								'class' => [
									'blockquote',
									'mb-0'
								]
							])
							->content([
								$aviHtmlElement->tag('p')->content('A well-known quote, contained in a blockquote element.'),
								$aviHtmlElement->tag('footer')
								->attributes([
									'class' => 'blockquote-footer'
								])
								->content('Someone famous in <cite title="Source Title">Source Title</cite>')
							])
						]
					]
				]
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="card text-center">',
			'<div class="card-header">',
			'Featured',
			'</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Special title treatment</h5>',
			'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>',
			'<a class="btn btn-primary" href="#">Go somewhere</a>',
			'</div>',
			'<div class="card-footer text-body-secondary">',
			'2 days ago',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'header' => 'Featured'
				],
				[
					'body' => [
						'title' => 'Special title treatment',
						'text' => 'With supporting text below as a natural lead-in to additional content.',
						'items' => [
							$aviHtmlElement->tag('a')
							->attributes([
								'class' => [
									'btn',
									'btn-primary'
								],
								'href' => '#'
							])
							->content('Go somewhere')
						]
					]
				],
				[
					'footer' => [
						'attr' => [
							'class' => [
								'text-body-secondary'
							]
						],
						'content' => '2 days ago'
					]
				]
			]
		])
		->attributes([
			'class' => [
				'text-center'
			]
		])
		->use();
		$this->assertEquals($test, $result);


		//Sizing
		$card = implode('', [
			'<div class="card">',
			'<div class="card-body">',
			'<h5 class="card-title">Special title treatment</h5>',
			'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>',
			'<a class="btn btn-primary" href="#">Go somewhere</a>',
			'</div>',
			'</div>',
		]);
		$bScard = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'body' => [
						'title' => 'Special title treatment',
						'text' => 'With supporting text below as a natural lead-in to additional content.',
						'items' => [
							$aviHtmlElement->tag('a')
							->attributes([
								'class' => [
									'btn',
									'btn-primary'
								],
								'href' => '#'
							])
							->content('Go somewhere')
						]
					]
				]
			]
		]);
		$test = implode('', [
			'<div class="row">',
			'<div class="col-sm-6 mb-3 mb-sm-0">',
			$card,
			'</div>',
			'<div class="col-sm-6">',
			$card,
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
		->attributes([
			'class' => 'row'
		])
		->content([
			$aviHtmlElement->tag('div')
			->attributes([
				'class' => [
					'col-sm-6',
					'mb-3',
					'mb-sm-0'
				]
			])
			->content([
				$bScard->use()
			]),
			$aviHtmlElement->tag('div')
			->attributes([
				'class' => [
					'col-sm-6'
				]
			])
			->content([
				$bScard->use()
			]),
		]);
		$this->assertEquals($test, $result);


		//Using utilities
		$bsCardBody = [
			'items' => [
				[
					'body' => [
						'title' => 'Card title',
						'text' => 'With supporting text below as a natural lead-in to additional content.',
						'items' => [
							$aviHtmlElement->tag('a')
							->attributes([
								'class' => [
									'btn',
									'btn-primary'
								],
								'href' => '#'
							])
							->content('Button')
						]
					]
				]
			]
		];

		$cardBody = implode('', [
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>',
			'<a class="btn btn-primary" href="#">Button</a>',
			'</div>'
		]);
		$test = implode('', [
			'<div class="card mb-3 w-75">',
			$cardBody,
			'</div>',
			'<div class="card w-50">',
			$cardBody,
			'</div>',
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsCard', $bsCardBody)
			->attributes([
				'class' => [
					'mb-3',
					'w-75'
				]
			])->use(),
			$aviHtmlElement->element('BsCard', $bsCardBody)
			->attributes([
				'class' => [
					'w-50'
				]
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Using custom CSS
		$test = implode('', [
			'<div class="card" style="width: 18rem;">',
			'<div class="card-body">',
			'<h5 class="card-title">Special title treatment</h5>',
			'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>',
			'<a class="btn btn-primary" href="#">Go somewhere</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'body' => [
						'title' => 'Special title treatment',
						'text' => 'With supporting text below as a natural lead-in to additional content.',
						'items' => [
							$aviHtmlElement->tag('a')
							->attributes([
								'class' => [
									'btn',
									'btn-primary'
								],
								'href' => '#'
							])
							->content('Go somewhere')
						]
					]
				]
			]
		])
		->attributes([
			'style' => 'width: 18rem;'
		])
		->use();
		$this->assertEquals($test, $result);


		//Text alignment
		$bsCardBody = [
			'items' => [
				[
					'body' => [
						'title' => 'Special title treatment',
						'text' => 'With supporting text below as a natural lead-in to additional content.',
						'items' => [
							$aviHtmlElement->tag('a')
							->attributes([
								'class' => [
									'btn',
									'btn-primary'
								],
								'href' => '#'
							])
							->content('Go somewhere')
						]
					]
				]
			]
		];
		$cardBody = implode('', [
			'<div class="card-body">',
			'<h5 class="card-title">Special title treatment</h5>',
			'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>',
			'<a class="btn btn-primary" href="#">Go somewhere</a>',
			'</div>'
		]);
		$test = implode('', [
			'<div class="card mb-3" style="width: 18rem;">',
			$cardBody,
			'</div>',

			'<div class="card mb-3 text-center" style="width: 18rem;">',
			$cardBody,
			'</div>',

			'<div class="card text-end" style="width: 18rem;">',
			$cardBody,
			'</div>',
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsCard', $bsCardBody)
			->attributes([
				'class' => 'mb-3',
				'style' => 'width: 18rem;'
			])
			->use(),
			$aviHtmlElement->element('BsCard', $bsCardBody)
			->attributes([
				'class' => [
					'mb-3',
					'text-center'
				],
				'style' => 'width: 18rem;'
			])
			->use(),
			$aviHtmlElement->element('BsCard', $bsCardBody)
			->attributes([
				'class' => [
					'text-end'
				],
				'style' => 'width: 18rem;'
			])
			->use()
		]);
		$this->assertEquals($test, $result);


		//Navigation
		$test = implode('', [
			'<div class="card text-center">',
			'<div class="card-header">',
			'<ul class="card-header-tabs nav nav-tabs">',
			'<li class="nav-item">',
			'<a aria-current="page" class="active nav-link" href="#">Active</a>',
			'</li>',
			'<li class="nav-item">',
			'<a class="nav-link" href="#">Link</a>',
			'</li>',
			'<li class="nav-item">',
			'<a aria-disabled="true" class="disabled nav-link">Disabled</a>',
			'</li>',
			'</ul>',
			'</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Special title treatment</h5>',
			'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>',
			'<a class="btn btn-primary" href="#" role="button">Go somewhere</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'header' => $aviHtmlElement->element('BsNav', [
						'interface' => 'tabs',
						'items' => [
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
								'disabled' => true,
								'href' => false,
								'text' => 'Disabled'
							]
						],
						'tag' => 'ul'
					])
					->attributes([
						'class' => [
							'card-header-tabs'
						]
					])
					->use()
				],
				[
					'body' => [
						'title' => 'Special title treatment',
						'text' => 'With supporting text below as a natural lead-in to additional content.',
						'items' => [
							$aviHtmlElement->element('BsButton', [
								'href' => '#',
								'tag' => 'a',
								'text' => 'Go somewhere',
								'variant' => 'primary'
							])->use()
						]
					]
				]
			]
		])
		->attributes([
			'class' => [
				'text-center'
			]
		])
		->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="card text-center">',
			'<div class="card-header">',
			'<ul class="card-header-pills nav nav-pills">',
			'<li class="nav-item">',
			'<a aria-current="page" class="active nav-link" href="#">Active</a>',
			'</li>',
			'<li class="nav-item">',
			'<a class="nav-link" href="#">Link</a>',
			'</li>',
			'<li class="nav-item">',
			'<a aria-disabled="true" class="disabled nav-link">Disabled</a>',
			'</li>',
			'</ul>',
			'</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Special title treatment</h5>',
			'<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>',
			'<a class="btn btn-primary" href="#" role="button">Go somewhere</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'header' => $aviHtmlElement->element('BsNav', [
						'interface' => 'pills',
						'items' => [
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
								'disabled' => true,
								'href' => false,
								'text' => 'Disabled'
							]
						],
						'tag' => 'ul'
					])
					->attributes([
						'class' => [
							'card-header-pills'
						]
					])
					->use()
				],
				[
					'body' => [
						'title' => 'Special title treatment',
						'text' => 'With supporting text below as a natural lead-in to additional content.',
						'items' => [
							$aviHtmlElement->element('BsButton', [
								'href' => '#',
								'tag' => 'a',
								'text' => 'Go somewhere',
								'variant' => 'primary'
							])->use()
						]
					]
				]
			]
		])
		->attributes([
			'class' => [
				'text-center'
			]
		])
		->use();
		$this->assertEquals($test, $result);


		//Images
		$body = implode('', [
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>',
			'</div>'
		]);
		$bsCardBody = [
			'title' => 'Card title',
			'text' => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
			'items' => [
				$aviHtmlElement
				->tag('p')
				->attributes([
					'class' => 'card-text'
				])
				->content(
					$aviHtmlElement
					->tag('small')
					->attributes([
						'class' => 'text-body-secondary'
					])
					->content('Last updated 3 mins ago')
				)
			]
		];
		$test = implode('', [
			'<div class="card mb-3">',
			'<img alt="..." class="card-img-top" src="...">',
			$body,
			'</div>',
			'<div class="card">',
			$body,
			'<img alt="..." class="card-img-bottom" src="...">',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsCard', [
				'items' => [
					[
						'img' => [
							'alt' => '...',
							'src' => '...'
						]
					],
					[
						'body' => $bsCardBody
					]
				]
			])
			->attributes([
				'class' => [
					'mb-3'
				]
			])
			->use(),
			$aviHtmlElement->element('BsCard', [
				'items' => [
					[
						'body' => $bsCardBody
					],
					[
						'img' => [
							'alt' => '...',
							'position' => 'bottom',
							'src' => '...'
						]
					]
				]
			])
			->use()
		]);
		$this->assertEquals($test, $result);


		//mage overlays
		$test = implode('', [
			'<div class="card text-bg-dark">',
			'<img alt="..." class="card-img" src="...">',
			'<div class="card-img-overlay">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'<p class="card-text"><small>Last updated 3 mins ago</small></p>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
				[
					'img' => [
						'alt' => '...',
						'position' => false,
						'src' => '...'
					]
				],
				[
					'body' => [
						'overlay' => 'img',
						'title' => 'Card title',
						'text' => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
						'items' => [
							$aviHtmlElement
							->tag('p')
							->attributes([
								'class' => 'card-text'
							])
							->content([
								$aviHtmlElement
								->tag('small')
								->content('Last updated 3 mins ago')
							])
						]
					]
				]
			]
		])
		->attributes([
			'class' => [
				'text-bg-dark'
			]
		])
		->use();
		$this->assertEquals($test, $result);

		//Horizontal
		$test = implode('', [
			'<div class="card mb-3" style="max-width: 540px;">',
			'<div class="g-0 row">',

			'<div class="col-md-4">',
			'<img alt="..." class="img-fluid rounded-start" src="...">',
			'</div>',

			'<div class="col-md-8">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
			[
				$aviHtmlElement->tag('div')
				->attributes([
					'class' => [
						'g-0',
						'row'
					]
				])
				->content([
					$aviHtmlElement->tag('div')
					->attributes([
						'class' => [
							'col-md-4',
						]
					])
					->content([
						$aviHtmlElement->tag('img')
						->attributes([
							'alt' => '...',
							'class' => [
								'img-fluid rounded-start'
							],
							'src' => '...'
						])
						->use()
					]),
					$aviHtmlElement->tag('div')
					->attributes([
						'class' => [
							'col-md-8',
						]
					])
					->content(
						$aviHtmlElement->tag('div')
						->attributes([
							'class' => [
								'card-body',
							]
						])
						->content([
							$aviHtmlElement->tag('h5')
							->attributes([
								'class' => 'card-title'
							])
							->content('Card title'),
							$aviHtmlElement->tag('p')
							->attributes([
								'class' => 'card-text'
							])
							->content('This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.'),
							$aviHtmlElement->tag('p')
							->attributes([
								'class' => 'card-text'
							])
							->content(
								$aviHtmlElement->tag('small')
								->attributes([
									'class' => 'text-body-secondary'
								])
								->content('Last updated 3 mins ago')
							)
						])
					)
				], true)
			]]
		])
		->attributes([
			'class' => [
				'mb-3'
			],
			'style' => 'max-width: 540px;'
		])
		->use();
		$this->assertEquals($test, $result);


		//Card styles
		//Background and color
		$test = implode('', [
			'<div class="card mb-3 text-bg-primary" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Primary card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',
			'<div class="card mb-3 text-bg-secondary" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Secondary card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',
			'<div class="card mb-3 text-bg-success" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Success card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',
			'<div class="card mb-3 text-bg-danger" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Danger card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',
			'<div class="card mb-3 text-bg-warning" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Warning card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',
			'<div class="card mb-3 text-bg-info" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Info card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',
			'<div class="card mb-3 text-bg-light" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Light card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',
			'<div class="card mb-3 text-bg-dark" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Dark card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',
		]);

		$result = [];
		foreach (AVI_BS_COLOR as $color) {
			$result[] = $aviHtmlElement->element('BsCard', [
				'items' => [
				[
					'header' => 'Header'
				],
				[
					'body' => [
						'title' => sprintf('%s card title', ucfirst($color)),
						'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'
					]
				]]
			])
			->attributes([
				'class' => [
					'mb-3',
					sprintf('text-bg-%s', $color)
				],
				'style' => 'max-width: 18rem;'
			])
			->use();
		}
		$this->assertEquals($test, implode('', $result));


		//Border
		$test = implode('', [
			'<div class="border-primary card mb-3" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body text-primary">',
			'<h5 class="card-title">Primary card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',

			'<div class="border-secondary card mb-3" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body text-secondary">',
			'<h5 class="card-title">Secondary card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',

			'<div class="border-success card mb-3" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body text-success">',
			'<h5 class="card-title">Success card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',

			'<div class="border-danger card mb-3" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body text-danger">',
			'<h5 class="card-title">Danger card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',

			'<div class="border-warning card mb-3" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Warning card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',

			'<div class="border-info card mb-3" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Info card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',

			'<div class="border-light card mb-3" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Light card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>',

			'<div class="border-dark card mb-3" style="max-width: 18rem;">',
			'<div class="card-header">Header</div>',
			'<div class="card-body">',
			'<h5 class="card-title">Dark card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'</div>'
		]);
		$result = [];
		foreach (['primary', 'secondary', 'success', 'danger'] as $color) {
			$result[] = $aviHtmlElement->element('BsCard', [
				'items' => [
				[
					'header' => 'Header'
				],
				[
					'body' => [
						'attr' => [
							'class' => [
								sprintf('text-%s', $color)
							]
						],
						'title' => sprintf('%s card title', ucfirst($color)),
						'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'
					]
				]]
			])
			->attributes([
				'class' => [
					'mb-3',
					sprintf('border-%s', $color)
				],
				'style' => 'max-width: 18rem;'
			])
			->use();
		}
		foreach (['warning', 'info', 'light', 'dark'] as $color) {
			$result[] = $aviHtmlElement->element('BsCard', [
				'items' => [
				[
					'header' => 'Header'
				],
				[
					'body' => [
						'title' => sprintf('%s card title', ucfirst($color)),
						'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'
					]
				]]
			])
			->attributes([
				'class' => [
					'mb-3',
					sprintf('border-%s', $color)
				],
				'style' => 'max-width: 18rem;'
			])
			->use();
		}
		$this->assertEquals($test, implode('', $result));



	//Mixins utilities
		$test = implode('', [
			'<div class="border-success card mb-3" style="max-width: 18rem;">',
			'<div class="bg-transparent border-success card-header">Header</div>',
			'<div class="card-body text-success">',
			'<h5 class="card-title">Success card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'</div>',
			'<div class="bg-transparent border-success card-footer">Footer</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'items' => [
			[
				'header' => [
					'attr' => [
						'class' => [
							'bg-transparent',
							'border-success'
						]
					],
					'content' => 'Header'
				]
			],
			[
				'body' => [
					'attr' => [
						'class' => [
							'text-success'
						]
					],
					'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
					'title' => 'Success card title'
				]

			],
			[
				'footer' => [
					'attr' => [
						'class' => [
							'bg-transparent',
							'border-success'
						]
					],
					'content' => 'Footer'
				]
			]]
		])
		->attributes([
			'class' => [
				'border-success',
				'mb-3'
			],
			'style' => 'max-width: 18rem;'
		])
		->use();
		$this->assertEquals($test, $result);


		//Card layout
		//Card groups
		$card = function($htmlElement, $text) {
			return $htmlElement->element('BsCard', [
				'items' => [
				[
					'img' => [
						'alt' => '...',
						'src' => '...'
					]
				],
				[
					'body' => [
						'title' => 'Card title',
						'text' => $text,
						'items' => [
							$htmlElement->tag('p')
							->attributes([
								'class' => 'card-text'
							])
							->content(
								$htmlElement->tag('small')
								->attributes([
									'class' => 'text-body-secondary'
								])
								->content('Last updated 3 mins ago')
							)
						]
					]
				]]
			])->use();
		};

		$test = implode('', [
			'<div class="card-group">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>',
			'</div>',
			'</div>',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>',
			'<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>',
			'</div>',
			'</div>',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>',
			'<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
			->attributes([
				'class' => 'card-group'
			])
			->content([
				$card($aviHtmlElement, 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.'),
				$card($aviHtmlElement, 'This card has supporting text below as a natural lead-in to additional content.'),
				$card($aviHtmlElement, 'This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.'),
			]);
		$this->assertEquals($test, $result);

		//group cards with footer
		$card = function($htmlElement, $text) {
			return $htmlElement->element('BsCard', [
				'items' => [
				[
					'img' => [
						'alt' => '...',
						'src' => '...'
					]
				],
				[
					'body' => [
						'title' => 'Card title',
						'text' => $text,
					]
				],
				[
					'footer' => $htmlElement->tag('small')
						->attributes(['class' => 'text-body-secondary'])
						->content('Last updated 3 mins ago')
				]]
			])->use();
		};
		$test = implode('', [
			'<div class="card-group">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'<div class="card-footer">',
			'<small class="text-body-secondary">Last updated 3 mins ago</small>',
			'</div>',
			'</div>',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>',
			'</div>',
			'<div class="card-footer">',
			'<small class="text-body-secondary">Last updated 3 mins ago</small>',
			'</div>',
			'</div>',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>',
			'</div>',
			'<div class="card-footer">',
			'<small class="text-body-secondary">Last updated 3 mins ago</small>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
		->attributes([
			'class' => 'card-group'
		])
		->content([
			$card($aviHtmlElement, 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.'),
			$card($aviHtmlElement, 'This card has supporting text below as a natural lead-in to additional content.'),
			$card($aviHtmlElement, 'This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.')
		]);
		$this->assertEquals($test, $result);


		//grid cards
		$card = function($htmlElement, $text) {
			return $htmlElement->tag('div')
			->attributes([
				'class' => 'col'
			])
			->content(
				$htmlElement->element('BsCard', [
					'items' => [
					[
						'img' => [
							'alt' => '...',
							'src' => '...'
						]
					],
					[
						'body' => [
							'title' => 'Card title',
							'text' => $text,
						]
					]]
				])->use()
			);
		};
		$test = implode('', [
			'<div class="g-4 row row-cols-1 row-cols-md-2">',
			'<div class="col">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement
		->tag('div')
		->attributes([
			'class' => [
				'g-4',
				'row',
				'row-cols-1',
				'row-cols-md-2'
			]
		])
		->content([
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.'),
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.'),
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content.'),
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.')
		]);
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<div class="g-4 row row-cols-1 row-cols-md-3">',
			'<div class="col">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement
		->tag('div')
		->attributes([
			'class' => [
				'g-4',
				'row',
				'row-cols-1',
				'row-cols-md-3'
			]
		])
		->content([
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.'),
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.'),
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content.'),
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.')
		]);
		$this->assertEquals($test, $result);


		$card = function($htmlElement, $text) {
			return $htmlElement->tag('div')
			->attributes([
				'class' => 'col'
			])
			->content(
				$htmlElement->element('BsCard', [
					'items' => [
					[
						'img' => [
							'alt' => '...',
							'src' => '...'
						]
					],
					[
						'body' => [
							'title' => 'Card title',
							'text' => $text,
						]
					]]
				])
				->attributes([
					'class' => [
						'h-100'
					]
				])
				->use()
				);
		};
		$test = implode('', [
			'<div class="g-4 row row-cols-1 row-cols-md-3">',
			'<div class="col">',
			'<div class="card h-100">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card h-100">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a short card.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card h-100">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card h-100">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement
		->tag('div')
		->attributes([
			'class' => [
				'g-4',
				'row',
				'row-cols-1',
				'row-cols-md-3'
			]
		])
		->content([
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.'),
			$card($aviHtmlElement, 'This is a short card.'),
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content.'),
			$card($aviHtmlElement, 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.')
		]);
		$this->assertEquals($test, $result);


		$card = function($htmlElement, $text) {
			return $htmlElement->tag('div')
			->attributes([
				'class' => 'col'
			])
			->content(
				$htmlElement->element('BsCard', [
					'items' => [
					[
						'img' => [
							'alt' => '...',
							'src' => '...'
						]
					],
					[
						'body' => [
							'title' => 'Card title',
							'text' => $text,
						]
					],
					[
						'footer' => $htmlElement->tag('small')
							->attributes([
								'class' => 'text-body-secondary'
							])
							->content('Last updated 3 mins ago')
					]]
				])
				->attributes([
					'class' => [
						'h-100'
					]
				])
				->use()
				);
		};
		$test = implode('', [
			'<div class="g-4 row row-cols-1 row-cols-md-3">',
			'<div class="col">',
			'<div class="card h-100">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>',
			'</div>',
			'<div class="card-footer">',
			'<small class="text-body-secondary">Last updated 3 mins ago</small>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card h-100">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>',
			'</div>',
			'<div class="card-footer">',
			'<small class="text-body-secondary">Last updated 3 mins ago</small>',
			'</div>',
			'</div>',
			'</div>',
			'<div class="col">',
			'<div class="card h-100">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>',
			'</div>',
			'<div class="card-footer">',
			'<small class="text-body-secondary">Last updated 3 mins ago</small>',
			'</div>',
			'</div>',
			'</div>',
			'</div>',
		]);
		$result = $aviHtmlElement
		->tag('div')
		->attributes([
			'class' => [
				'g-4',
				'row',
				'row-cols-1',
				'row-cols-md-3'
			]
		])
		->content([
			$card($aviHtmlElement, 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.'),
			$card($aviHtmlElement, 'This card has supporting text below as a natural lead-in to additional content.'),
			$card($aviHtmlElement, 'This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.')
		]);
		$this->assertEquals($test, $result);
	}
}
