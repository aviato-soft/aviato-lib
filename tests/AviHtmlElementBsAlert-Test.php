<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsAlert extends TestCase
{

	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = '<div class="alert" role="alert"></div>';
		$result = $aviHtmlElement->element('BsAlert')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Valid params
		$test = implode('', [
			'<div class="alert alert-dismissible alert-primary fade show" role="alert">',
			'Alert!',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"></button>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsAlert', [
			'dismissible' => true,
			'text' => 'Alert!',
			'variant' => 'primary'
		])->use();
		$this->assertEquals($test, $result);

		//text in content:
		$result = $aviHtmlElement->element('BsAlert', [
			'dismissible' => true,
			'variant' => 'primary'
		])
		->content('Alert!');
		$this->assertEquals($test, $result);


		//Invalid params
		$test = '<div class="alert" role="alert"></div>';
		$result = $aviHtmlElement->element('BsAlert', [
			'variant' => 'black'
		])->use();
		$this->assertEquals($test, $result);

	}

/**
 * @see https://getbootstrap.com/docs/5.3/components/alerts/
 */
	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = '<div class="alert" role="alert"></div>';
		$result = $aviHtmlElement->element('BsAlert')->use();
		$this->assertEquals($test, $result);

		//#Examples
		$test = implode('', [
			'<div class="alert alert-primary" role="alert">',
			'A simple primary alert—check it out!',
			'</div>',
			'<div class="alert alert-secondary" role="alert">',
			'A simple secondary alert—check it out!',
			'</div>',
			'<div class="alert alert-success" role="alert">',
			'A simple success alert—check it out!',
			'</div>',
			'<div class="alert alert-danger" role="alert">',
			'A simple danger alert—check it out!',
			'</div>',
			'<div class="alert alert-warning" role="alert">',
			'A simple warning alert—check it out!',
			'</div>',
			'<div class="alert alert-info" role="alert">',
			'A simple info alert—check it out!',
			'</div>',
			'<div class="alert alert-light" role="alert">',
			'A simple light alert—check it out!',
			'</div>',
			'<div class="alert alert-dark" role="alert">',
			'A simple dark alert—check it out!',
			'</div>'
		]);
		$result = [];
		foreach(AVI_BS_COLOR as $color) {
			$result[] = $aviHtmlElement->element('BsAlert', [
				'text' => sprintf('A simple %s alert—check it out!', $color),
				'variant' => $color
			])->use();
		}
		$result = implode('', $result);
		$this->assertEquals($test, $result);


		//#Link color
		$test = implode('', [
			'<div class="alert alert-primary" role="alert">',
			'A simple primary alert with <a class="alert-link" href="#">an example link</a>. Give it a click if you like.',
			'</div>',
			'<div class="alert alert-secondary" role="alert">',
			'A simple secondary alert with <a class="alert-link" href="#">an example link</a>. Give it a click if you like.',
			'</div>',
			'<div class="alert alert-success" role="alert">',
			'A simple success alert with <a class="alert-link" href="#">an example link</a>. Give it a click if you like.',
			'</div>',
			'<div class="alert alert-danger" role="alert">',
			'A simple danger alert with <a class="alert-link" href="#">an example link</a>. Give it a click if you like.',
			'</div>',
			'<div class="alert alert-warning" role="alert">',
			'A simple warning alert with <a class="alert-link" href="#">an example link</a>. Give it a click if you like.',
			'</div>',
			'<div class="alert alert-info" role="alert">',
			'A simple info alert with <a class="alert-link" href="#">an example link</a>. Give it a click if you like.',
			'</div>',
			'<div class="alert alert-light" role="alert">',
			'A simple light alert with <a class="alert-link" href="#">an example link</a>. Give it a click if you like.',
			'</div>',
			'<div class="alert alert-dark" role="alert">',
			'A simple dark alert with <a class="alert-link" href="#">an example link</a>. Give it a click if you like.',
			'</div>'
		]);
		$result = [];
		$content = implode('', [
			'A simple %s alert with ',
			$aviHtmlElement->tag('a', [
				'href' => '#',
				'class' => 'alert-link'
			])
			->content('an example link'),
			'. ',
			'Give it a click if you like.'
		]);
		foreach(AVI_BS_COLOR as $color) {
			$result[] = $aviHtmlElement->element('BsAlert', [
				'variant' => $color
			])
			->content(
				sprintf($content, $color)
			);
		}
		$result = implode('', $result);
		$this->assertEquals($test, $result);


		//#Additional content
		$test = implode('', [
			'<div class="alert alert-success" role="alert">',
			'<h4 class="alert-heading">Well done!</h4>',
			'<p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>',
			'<hr>',
			'<p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsAlert', [
			'variant' => 'success'
		])
		->content([
			$aviHtmlElement->tag('h4', [
				'class' => 'alert-heading'
			])->content('Well done!'),
			$aviHtmlElement->tag('p')
			->content('Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.'),
			$aviHtmlElement->tag('hr')->use(),
			$aviHtmlElement->tag('p', [
				'class' => 'mb-0'
			])->content('Whenever you need to, be sure to use margin utilities to keep things nice and tidy.')
		]);
		$this->assertEquals($test, $result);


		//Icons
		$test = implode('', [
			'<div class="alert alert-primary align-items-center d-flex" role="alert">',
			'<i aria-label="Info:" class="bi bi-info-fill flex-shrink-0 me-2" role="img"></i>',
			'<div>',
			'An example alert with an icon',
			'</div>',
			'</div>',
			'<div class="alert alert-success align-items-center d-flex" role="alert">',
			'<i aria-label="Success:" class="bi bi-check-circle-fill flex-shrink-0 me-2" role="img"></i>',
			'<div>',
			'An example success alert with an icon',
			'</div>',
			'</div>',
			'<div class="alert alert-warning align-items-center d-flex" role="alert">',
			'<i aria-label="Warning:" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" role="img"></i>',
			'<div>',
			'An example warning alert with an icon',
			'</div>',
			'</div>',
			'<div class="alert alert-danger align-items-center d-flex" role="alert">',
			'<i aria-label="Danger:" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" role="img"></i>',
			'<div>',
			'An example danger alert with an icon',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsAlert', [
				'variant' => 'primary'
			])->attributes([
				'class' => [
					'd-flex',
					'align-items-center'
				]
			])->content([
				$aviHtmlElement->element('BsIcon', [
					'slug' => 'info-fill'
				])->attributes([
					'aria-label' => 'Info:',
					'class' => [
						'flex-shrink-0',
						'me-2'
					],
					'role' => 'img'
				])->use(),
				$aviHtmlElement->tag('div')
				->content('An example alert with an icon')
			]),
			$aviHtmlElement->element('BsAlert', [
				'variant' => 'success'
			])->attributes([
				'class' => [
					'd-flex',
					'align-items-center'
				]
			])->content([
				$aviHtmlElement->element('BsIcon', [
					'slug' => 'bi-check-circle-fill'
				])->attributes([
					'aria-label' => 'Success:',
					'class' => [
						'flex-shrink-0',
						'me-2'
					],
					'role' => 'img'
				])->use(),
				$aviHtmlElement->tag('div')
				->content('An example success alert with an icon')
			]),
			$aviHtmlElement->element('BsAlert', [
				'variant' => 'warning'
			])->attributes([
				'class' => [
					'd-flex',
					'align-items-center'
				]
			])->content([
				$aviHtmlElement->element('BsIcon', [
					'slug' => 'exclamation-triangle-fill'
				])->attributes([
					'aria-label' => 'Warning:',
					'class' => [
						'flex-shrink-0',
						'me-2'
					],
					'role' => 'img'
				])->use(),
				$aviHtmlElement->tag('div')
				->content('An example warning alert with an icon')
			]),
			$aviHtmlElement->element('BsAlert', [
				'variant' => 'danger'
			])->attributes([
				'class' => [
					'd-flex',
					'align-items-center'
				]
			])->content([
				$aviHtmlElement->element('BsIcon', [
					'slug' => 'exclamation-triangle-fill'
				])->attributes([
					'aria-label' => 'Danger:',
					'class' => [
						'flex-shrink-0',
						'me-2'
					],
					'role' => 'img'
				])->use(),
				$aviHtmlElement->tag('div')
				->content('An example danger alert with an icon')
			])
		]);
		$this->assertEquals($test, $result);


		//#Dismissing
		$test = implode('', [
			'<div class="alert alert-dismissible alert-warning fade show" role="alert">',
			'<strong>Holy guacamole!</strong> You should check in on some of those fields below.',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"></button>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsAlert', [
			'debug' => true,
			'dismissible' => true,
			'variant' => 'warning'
		])->content([
			$aviHtmlElement->tag('strong')->content('Holy guacamole!'),
			' You should check in on some of those fields below.'
		]);
		$this->assertEquals($test, $result);
	}
}
