<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsBadge extends TestCase
{

	public function testFn_Construct(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//full test:
		$test = '<span class="badge bg-primary rounded-pill text-bg-light">New</span>';
		$result = $aviHtmlElement->element('BsBadge', [
			'bg-color' => 'primary', //AVI_BS_COLOR
			'color' => 'light', //AVI_BS_COLOR
			'pill' => true, //true | false
			'text' => 'Aviato'
		])->content('New'); //content overwrite text
		$this->assertEquals($test, $result);



		$test = '<span class="badge">New</span>';
		$result = $aviHtmlElement->element('BsBadge')->content('New');
		$this->assertEquals($test, $result);


		//Headings
		$test = '<h1>Example heading <span class="badge bg-secondary">New</span></h1>';
		$result = $aviHtmlElement->tag('h1')->content([
			'Example heading ',
			$aviHtmlElement->element('BsBadge', [
				'bg-color' => 'secondary'
			])->content('New')
		]);
		$this->assertEquals($test, $result);


		//Buttons
		$test = implode('', [
			'<button class="btn btn-primary" type="button">',
			'Notifications <span class="badge text-bg-secondary">4</span>',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'badge' => [
				'color' => 'secondary',
				'text' => '4'
			],
			'text' => 'Notifications ',
			'variant' => 'primary',
		])->use();
		$this->assertEquals($test, $result);

		//positioned
		$test = implode('', [
			'<button class="btn btn-primary position-relative" type="button">',
			'Inbox ',
			'<span class="badge bg-danger position-absolute rounded-pill start-100 top-0 translate-middle">',
			'99+',
			'<span class="visually-hidden">unread messages</span>',
			'</span>',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'badge' => [
				'attr' => [
					'class' => [
						'top-0',
						'start-100',
						'translate-middle',
						'bg-danger',
						'position-absolute'
					]
				],
				'pill' => true,
				'text' => [
					'99+',
					$aviHtmlElement->tag('span')->attributes([
						'class' => [
							'visually-hidden'
						]
					])->content('unread messages')
				]
			],
			'text' => 'Inbox ',
			'variant' => 'primary'
		])->attributes([
			'class' => [
				'position-relative'
			]
		])->use();
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<button class="btn btn-primary position-relative" type="button">',
			'Profile ',
			'<span class="bg-danger border border-light p-2 position-absolute rounded-circle start-100 top-0 translate-middle">',
			'<span class="visually-hidden">New alerts</span>',
			'</span>',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'variant' => 'primary',
			'text' => [
				'Profile ',
				$aviHtmlElement->tag('span')
				->attributes([
					'class' => [
						'bg-danger',
						'border',
						'border-light',
						'position-absolute',
						'rounded-circle',
						'top-0',
						'start-100',
						'translate-middle',
						'p-2'
					]
				])->content(
					$aviHtmlElement->tag('span')->attributes([
						'class' => [
							'visually-hidden'
					]
					])->content('New alerts')
				),
			],
		])->attributes([
			'class' => [
				'position-relative'
			]
		])->use();
		$this->assertEquals($test, $result);


		//background colors
		$test = implode('', [
			'<span class="badge text-bg-primary">Primary</span>',
			'<span class="badge text-bg-secondary">Secondary</span>',
			'<span class="badge text-bg-success">Success</span>',
			'<span class="badge text-bg-danger">Danger</span>',
			'<span class="badge text-bg-warning">Warning</span>',
			'<span class="badge text-bg-info">Info</span>',
			'<span class="badge text-bg-light">Light</span>',
			'<span class="badge text-bg-dark">Dark</span>'
		]);
		$result = '';
		foreach (AVI_BS_COLOR as $color) {
			$result .= $aviHtmlElement->element('BsBadge', [
				'color' => $color
			])->content(ucfirst($color));
		}
		$this->assertEquals($test, $result);

		//Pill badges
		$test = implode('', [
			'<span class="badge rounded-pill text-bg-primary">Primary</span>',
			'<span class="badge rounded-pill text-bg-secondary">Secondary</span>',
			'<span class="badge rounded-pill text-bg-success">Success</span>',
			'<span class="badge rounded-pill text-bg-danger">Danger</span>',
			'<span class="badge rounded-pill text-bg-warning">Warning</span>',
			'<span class="badge rounded-pill text-bg-info">Info</span>',
			'<span class="badge rounded-pill text-bg-light">Light</span>',
			'<span class="badge rounded-pill text-bg-dark">Dark</span>'
		]);
		$result = '';
		foreach (AVI_BS_COLOR as $color) {
			$result .= $aviHtmlElement->element('BsBadge', [
				'color' => $color,
				'pill' => true
			])->content(ucfirst($color));
		}
		$this->assertEquals($test, $result);

	}
}
