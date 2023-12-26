<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsSpinner extends TestCase
{

	/**
	 * 100% tested: https://getbootstrap.com/docs/5.3/components/spinners/
	 */
	public function testFn_Construct(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//full test:
		$test = implode('', [
			'<div class="spinner-border spinner-border-sm text-primary" role="status">',
			'<span class="visually-hidden">Please wait!</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner', [
			'color' => 'primary', //AVI_BS_COLOR
			'hidden' => false,
			'size' => 'sm', //AVI_BS_SIZE
			'status' => 'child', //child | before | after | none
			'status-hidden' => true,
			'text' => 'Loading!!!',
			'type' => 'border' //border | grow
		])->content('Please wait!');
		$this->assertEquals($test, $result);



		//basic test:
		$test = implode('', [
			'<div class="spinner-border" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner')->use();
		$this->assertEquals($test, $result);


		//basic test:
		$test = implode('', [
			'<div class="spinner-border" role="status">',
			'<span class="visually-hidden">Waiting...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner', 'Waiting...')->use();
		$this->assertEquals($test, $result);

//colors
		$colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
		foreach($colors as $color) {
			$test = implode('', [
				sprintf('<div class="spinner-border text-%s" role="status">', $color),
				'<span class="visually-hidden">Loading...</span>',
				'</div>'
			]);
			$result = $aviHtmlElement->element('BsSpinner', [
				'color' => $color
			])->use();
			$this->assertEquals($test, $result);
		}

//type
		$test = implode('', [
			'<div class="spinner-grow" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner', [
			'type' => 'grow'
		])->use();
		$this->assertEquals($test, $result);

//invalid type
		$test = implode('', [
			'<div class="spinner-border" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner', [
			'type' => 'grown'
		])->use();
		$this->assertEquals($test, $result);


		foreach($colors as $color) {
			$test = implode('', [
				sprintf('<div class="spinner-grow text-%s" role="status">', $color),
				'<span class="visually-hidden">Loading...</span>',
				'</div>'
			]);
			$result = $aviHtmlElement->element('BsSpinner', [
				'color' => $color,
				'type' => 'grow'
			])->use();
			$this->assertEquals($test, $result);
		}

//margin
		$test = implode('', [
			'<div class="m-5 spinner-border" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner')
			->attributes([
				'class' => [
					'm-5'
				]
			])
			->use();
		$this->assertEquals($test, $result);

//placement flex:
		$test = implode('', [
			'<div class="d-flex justify-content-center">',
			'<div class="spinner-border" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
			->attributes([
				'class' => [
					'd-flex',
					'justify-content-center'
				]
			])->content(
				$aviHtmlElement->element('BsSpinner')->use()
			);
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div class="align-items-center d-flex">',
			'<strong role="status">Loading...</strong>',
			'<div aria-hidden="true" class="spinner-border">',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
		->attributes([
			'class' => [
				'd-flex',
				'align-items-center'
			]
		])->content([
			$aviHtmlElement->element('BsSpinner', [
				'status' => 'before',
				'status-tag' => 'strong',
				'status-hidden' => false,
				'text' => 'Loading...'
			])->use()
		]);
		$this->assertEquals($test, $result);

//floats:
		$test = implode('', [
			'<div class="clearfix">',
			'<div class="float-end spinner-border" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
			->attributes([
			'class' => [
				'clearfix'
				]
			])->content($aviHtmlElement->element('BsSpinner')->attributes([
					'class' => [
						'float-end'
					]
				])
				->use());
		$this->assertEquals($test, $result);

//text align
		$test = implode('', [
			'<div class="text-center">',
			'<div class="spinner-border" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div')
			->attributes([
				'class' => [
					'text-center'
				]
			])->content($aviHtmlElement->element('BsSpinner')->use());
		$this->assertEquals($test, $result);

//size
		$test = implode('', [
			'<div class="spinner-border spinner-border-sm" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>',
			'<div class="spinner-grow spinner-grow-sm" role="status">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner', [
			'size' => 'sm'
		])->use().$aviHtmlElement->element('BsSpinner', [
			'size' => 'sm',
			'type' => 'grow'
		])->use();
		$this->assertEquals($test, $result);


//custom size:
		$test = implode('', [
			'<div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>',
			'<div class="spinner-grow" role="status" style="width: 3rem; height: 3rem;">',
			'<span class="visually-hidden">Loading...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner')
		->attributes([
			'style' => 'width: 3rem; height: 3rem;'
		])
		->use()
		.$aviHtmlElement->element('BsSpinner', [
			'type' => 'grow'
		])
		->attributes([
			'style' => 'width: 3rem; height: 3rem;'
		])
		->use();
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<span aria-hidden="true" class="spinner-border spinner-border-sm"></span>',
			'<span class="visually-hidden" role="status">Loading...</span>',
		]);
		$result = $aviHtmlElement->element('BsSpinner', [
			'size' => 'sm',
			'status' => 'after',
			'status-hidden' => true,
			'tag' => 'span'
		])->use();
		$this->assertEquals($test, $result);


//buttons
		$test = implode('', [
			'<button class="btn btn-primary" type="button" disabled>',
			'<span aria-hidden="true" class="spinner-border spinner-border-sm"></span>',
			'<span class="visually-hidden" role="status">Loading...</span>',
			'</button>',
			'<button class="btn btn-primary" type="button" disabled>',
			'<span aria-hidden="true" class="spinner-border spinner-border-sm"></span>',
			'<span role="status">Loading...</span>',
			'</button>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'disabled' => true,
				'variant' => 'primary',
				'text' => $aviHtmlElement->element('BsSpinner', [
					'size' => 'sm',
					'status' => 'after',
					'status-hidden' => true,
					'tag' => 'span'
				])->use()
			])->use(),
			$aviHtmlElement->element('BsButton', [
				'disabled' => true,
				'variant' => 'primary',
				'text' => $aviHtmlElement->element('BsSpinner', [
					'size' => 'sm',
					'status' => 'after',
					'status-hidden' => false,
					'tag' => 'span'
				])->use()
			])->use()
		]);
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<button class="btn btn-primary" type="button" disabled>',
			'<span aria-hidden="true" class="spinner-grow spinner-grow-sm"></span>',
			'<span class="visually-hidden" role="status">Loading...</span>',
			'</button>',
			'<button class="btn btn-primary" type="button" disabled>',
			'<span aria-hidden="true" class="spinner-grow spinner-grow-sm"></span>',
			'<span role="status">Loading...</span>',
			'</button>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'disabled' => true,
				'variant' => 'primary',
				'text' => $aviHtmlElement->element('BsSpinner', [
					'size' => 'sm',
					'status' => 'after',
					'status-hidden' => true,
					'tag' => 'span',
					'type' => 'grow'
				])->use()
			])->use(),
			$aviHtmlElement->element('BsButton', [
				'disabled' => true,
				'variant' => 'primary',
				'text' => $aviHtmlElement->element('BsSpinner', [
					'size' => 'sm',
					'status' => 'after',
					'status-hidden' => false,
					'tag' => 'span',
					'type' => 'grow'
				])->use()
			])->use()
		]);
		$this->assertEquals($test, $result);


//Status text:
		$test = implode('', [
			'<div class="spinner-border" role="status">',
			'<span class="visually-hidden">Please wait...</span>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSpinner', [
			'text' => 'Please wait...'
		])->use();
		$this->assertEquals($test, $result);


//Extra attributes for status after|before:
		$test = implode('', [
			'<div aria-hidden="true" class="d-none spinner-border" data-role="status">',
			'</div>',
			'<span class="d-none visually-hidden" role="status">Spinner</span>'
		]);
		$result = $aviHtmlElement->element('BsSpinner', [
			'hidden' => true,
			'status' => 'after',
			'text' => 'Please wait...'
		])->attributes([
			'data' => [
				'role' => 'status'
			]
		])->content('Spinner');
		$this->assertEquals($test, $result);

	}
}
