<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsCard extends TestCase
{
	public function testFn_HtmlElementBsCard(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div class="card">',
			'<div class="card-body">',
			'This is some text within a card body.',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'body' => [
				'This is some text within a card body.'
			]
		])->use();
		$this->assertEquals($test, $result);

/*
		$test = implode('', [
			'<div class="card">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'<a href="#" class="card-link">Card link</a>',
			'<a href="#" class="card-link">Another link</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'title' => 'Card title',
			'subtitle' => [
				'text' => 'Card subtitle',
				'attr' => [
					'class' => [
						'mb-2',
						'text-body-secondary'
					]
				]
			],
			'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
			'link' => [
				[
					'href' => '#',
					'text' => 'Card link'
				],
				[
					'href' => '#',
					'text' => 'Another link'
				]

			]

		])->use();
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<div class="card">',
			'<img alt="..." class="card-img-top" src="...">',
			'<div class="card-body">',
			'<h5 class="card-title">Card title</h5>',
			'<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>',
			'<a class="btn btn-primary" href="#">Go somewhere</a>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCard', [
			'img' => [
				'attr' => [
					'src' => '...',
					'alt' => '...'
				]
			],
			'title' => 'Card title',
			'text' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
			'body' => [
					$aviHtmlElement->tag('a')->attributes([
						'href' => '#',
						'class' => [
							'btn',
							'btn-primary'
						]
					])->content('Go somewhere')
			]
		])->use();
		$this->assertEquals($test, $result);
	}
*/
	}
}

