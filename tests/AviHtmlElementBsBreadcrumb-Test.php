<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsBreadcrumb extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = '<nav aria-label="breadcrumb"><ol class="breadcrumb"></ol></nav>';
		$result = $aviHtmlElement->element('BsBreadcrumb')->use();
		$this->assertEquals($test, $result);
	}

	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<nav aria-label="breadcrumb">',
			'<ol class="breadcrumb">',
			'<li class="breadcrumb-item"><a href="#1">Home</a></li>',
			'<li class="breadcrumb-item"><a href="#11">Category</a></li>',
			'<li aria-current="page" class="active breadcrumb-item">Aviato Soft</li>',
			'</ol>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsBreadcrumb', [
			'items' => [
				[
					'href' => '#1',
					'text' => 'Home'
				],
				[
					'href' => '#11',
					'text' => 'Category'
				],
				[
					'text' => 'Aviato Soft'
				]
			]
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsBreadcrumb')
		->content([
			[
				'href' => '#1',
				'text' => 'Home'
			],
			[
				'href' => '#11',
				'text' => 'Category'
			],
			[
				'text' => 'Aviato Soft'
			]
		]);
		$this->assertEquals($test, $result);

	}


	/**
	 * @see https://getbootstrap.com/docs/5.3/components/breadcrumb/
	 */
	public function testFn_Bootstrap(): void
	{
		//Example
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = implode('', [
			'<nav aria-label="breadcrumb">',
			'<ol class="breadcrumb">',
			'<li aria-current="page" class="active breadcrumb-item">Home</li>',
			'</ol>',
			'</nav>',

			'<nav aria-label="breadcrumb">',
			'<ol class="breadcrumb">',
			'<li class="breadcrumb-item"><a href="#">Home</a></li>',
			'<li aria-current="page" class="active breadcrumb-item">Library</li>',
			'</ol>',
			'</nav>',

			'<nav aria-label="breadcrumb">',
			'<ol class="breadcrumb">',
			'<li class="breadcrumb-item"><a href="#">Home</a></li>',
			'<li class="breadcrumb-item"><a href="#">Library</a></li>',
			'<li aria-current="page" class="active breadcrumb-item">Data</li>',
			'</ol>',
			'</nav>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsBreadcrumb', [
				'items' => [
					[
						'text' => 'Home'
					]
				]
			])->use(),
			$aviHtmlElement->element('BsBreadcrumb')
			->content([
				[
					'href' => '#',
					'text' => 'Home'
				],
				[
					'text' => 'Library'
				]
			]),
			$aviHtmlElement->element('BsBreadcrumb')
			->content([
				[
					'href' => '#',
					'text' => 'Home'
				],
				[
					'href' => '#',
					'text' => 'Library'
				],
				[
					'text' => 'Data'
				]
			])
		]);
		$this->assertEquals($test, $result);


		//Dividers
		$test = implode('', [
			'<nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: \'>\';">',
			'<ol class="breadcrumb">',
			'<li class="breadcrumb-item"><a href="#">Home</a></li>',
			'<li aria-current="page" class="active breadcrumb-item">Library</li>',
			'</ol>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsBreadcrumb', [
			'divider' => '>',
			'items' => [
				[
					'href' => '#',
					'text' => 'Home'
				],
				[
					'text' => 'Library'
				]
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'8\' height=\'8\'%3E%3Cpath d=\'M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z\' fill=\'%236c757d\'/%3E%3C/svg%3E&#34;);">',
			'<ol class="breadcrumb">',
			'<li class="breadcrumb-item"><a href="#">Home</a></li>',
			'<li aria-current="page" class="active breadcrumb-item">Library</li>',
			'</ol>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsBreadcrumb', [
			'divider' => "url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;)",
			'items' => [
				[
					'href' => '#',
					'text' => 'Home'
				],
				[
					'text' => 'Library'
				]
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: \'\';">',
			'<ol class="breadcrumb">',
			'<li class="breadcrumb-item"><a href="#">Home</a></li>',
			'<li aria-current="page" class="active breadcrumb-item">Library</li>',
			'</ol>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsBreadcrumb', [
			'divider' => '',
			'items' => [
				[
					'href' => '#',
					'text' => 'Home'
				],
				[
					'text' => 'Library'
				]
			]
		])->use();
		$this->assertEquals($test, $result);
	}
}
