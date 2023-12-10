<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElement extends TestCase
{

	public function testFn_Construct(): void
	{
		$aviHtmlElement = new AviHtmlElement('body');
		$test = '<body></body>';
		$result = $aviHtmlElement->use();

		$this->assertEquals($test, $result);
	}


	public function testFn_Attributes(): void
	{
		//no attributes:
		$aviHtmlElement = new AviHtmlElement('input');

		//no attributes:
		$test = '<input>';
		$result = $aviHtmlElement->attributes()->content();
		$this->assertEquals($test, $result);

		//single attributes:
		$test = '<input disabled>';
		$result = $aviHtmlElement->attributes(['disabled'])->content();
		$this->assertEquals($test, $result);

		//usual (associative) attributes:
		$test = '<input disabled value="aviato">';
		$result = $aviHtmlElement->attributes([
			'value' => 'aviato'
		])->content();
		$this->assertEquals($test, $result);

		//associative keys attributes:
		$test = '<input data-call="submit" data-role="button" disabled value="aviato">';
		$result = $aviHtmlElement->attributes([
			'data' => [
				'role' => 'button',
				'call' => 'submit'
			]
		])->content();
		$this->assertEquals($test, $result);

		//associative values attributes:
		$test = '<input class="btn btn-primary" data-call="submit" data-role="button" disabled value="aviato">';
		$result = $aviHtmlElement->attributes([
			'class' => [
				'btn',
				'btn-primary'
			]
		])->content();
		$this->assertEquals($test, $result);

		//reset the attributes:
		$test = '<input value="new">';
		$result = $aviHtmlElement->attributes(['value' => 'new'], false)->content();
		$this->assertEquals($test, $result);
	}


	public function testFn_Content(): void
	{
		//single element content:
		$aviHtmlElement = new AviHtmlElement('body');
		$result = $aviHtmlElement->content($aviHtmlElement->tag('h1')->content('Title'));
		$test = '<body><h1>Title</h1></body>';

		$this->assertEquals($test, $result);

		//multiple content
		$aviHtmlElement = new AviHtmlElement('body');
		$result = $aviHtmlElement->content([
			$aviHtmlElement->tag('h1')->content('Title'),
			$aviHtmlElement->tag('p')->content('Paragraph')
		]);
		$test = '<body><h1>Title</h1><p>Paragraph</p></body>';

		$this->assertEquals($test, $result);
	}


	public function testFn_dispatch()
	{
		$aviHtmlElement = new AviHtmlElement('!doctype');
		ob_start();

		$test = '<!doctype html>';
		$aviHtmlElement->attributes(['html'])->dispatch();
		$result = ob_get_clean();
		$this->assertEquals($test, $result);
	}


	public function testFn_element()
	{
		$aviHtmlElement = new AviHtmlElement('body');
		$result = $aviHtmlElement->content(
			$aviHtmlElement->element('button', ['label' => 'click me!'], dirname(__DIR__).'/tests/assets')
				->attributes([
					'class' => 'btn-primary',
					'type' => 'submit'
				])
				->use());
		$test = '<body><button class="btn btn-primary" type="submit">click me!</button></body>';
		$this->assertEquals($test, $result);
	}


	public function testFn_HtmlElementBsButton()
	{
		//button base class
		$test = '<button class="btn" type="button"></button>';
		$aviHtmlElement = new AviHtmlElement();
		$result = $aviHtmlElement->element('BsButton', [])->use();
		$this->assertEquals($test, $result);

		//variants
		$test = '<button class="btn btn-dark" type="button"></button>';
		$result = $aviHtmlElement->element('BsButton', [
				'variant' => 'dark'
			])->use();
		$this->assertEquals($test, $result);

		//disable text wrapping
		$test = '<button class="btn btn-primary text-nowrap" type="button"></button>';
		$result = $aviHtmlElement->element('BsButton', [
			'variant' => 'primary',
			'nowrap' => true
		])->use();
		$this->assertEquals($test, $result);


		//multiple attributes
		$test = '<button aria-pressed="true" class="active btn btn-outline-dark btn-sm text-nowrap" data-bs-toggle="button" disabled type="button">Button</button>';
		$result = $aviHtmlElement->element('BsButton', [
			'active' => true,
			'disabled' => true,
			'nowrap' => true,
			'outline' => true,
			'size' => 'sm',
			'text' => 'Button',
			'variant' => 'dark',
		])->use();
		$this->assertEquals($test, $result);

		//buton type link
		$test = '<a aria-disabled="true" class="btn disabled" role="button" tab-index="-1">Click me!</a>';
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'tag' => 'a',
			'text' => 'Click me!'
		])->use();
		$this->assertEquals($test, $result);


		//buton type input
		$test = '<input class="btn btn-secondary" disabled type="reset" value="Click me!">';
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'tag' => 'input',
			'text' => 'Click me!',
			'type' => 'reset',
			'variant' => 'secondary'
		])->use();
		$this->assertEquals($test, $result);


		//buton type submit
		$test = '<button class="btn btn-secondary" disabled type="submit">Click me!</button>';
		$result = $aviHtmlElement->element('BsButton', [
			'disabled' => true,
			'text' => 'Click me!',
			'type' => 'submit',
			'variant' => 'secondary'
		])->use();
		$this->assertEquals($test, $result);

		//icon base class
		$test = '<i class="bi bi-airplane"></i>';
		$result = $aviHtmlElement->element('BsIcon', ['airplane'])->use();
		$this->assertEquals($test, $result);

		//button with icon
		$test = '<button class="btn" type="button"><i class="bi bi-airplane"></i><span class="ps-2">Click me!</span></button>';
		$result = $aviHtmlElement->element('BsButton', [
			'icon' => 'airplane',
			'text' => 'Click me!'
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsButton', [
			'icon' => ['airplane'],
			'text' => 'Click me!'
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsButton', [
			'icon' => $aviHtmlElement->element('BsIcon', ['airplane'])->use(),
			'text' => 'Click me!'
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<button class="btn btn-sm btn-primary" ',
			'data-action="widget" data-widget="Gear" data-success="backend.on.success.done" data-serialize="true" data-call="Edit" data-gear="hotel" data-verbose="true" ',
			'type="button">',
			'<i class="bi bi-floppy-fill" data-role="btn-icon"></i>',
			'<span class="spinner-border spinner-border-sm d-none" data-role="spinner" role="status" aria-hidden="true"></span>',
			'<span class="visually-hidden">Please wait...</span>',
			'<span class="ps-2">Save</span></button>'
		]);

	}

}
