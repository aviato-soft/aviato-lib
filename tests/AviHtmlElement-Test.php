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
		$aviHtmlElement = new AviHtmlElement('br');

		//no attributes:
		$test = '<br>';
		$result = $aviHtmlElement->attributes()->content();
		$this->assertEquals($test, $result);

		//single attributes:
		$test = '<br disabled>';
		$result = $aviHtmlElement->attributes(['disabled'])->content();
		$this->assertEquals($test, $result);

		//default attributes
		$test = '<input>';
		$aviHtmlElement = $aviHtmlElement->tag('input');
		$result = $aviHtmlElement->content();
		$this->assertEquals($test, $result);

		//value attribute overwrite content
		$test = '<input value="test">';
		$result = $aviHtmlElement->content('test');
		$this->assertEquals($test, $result);
		$test = '<input value="test">';
		$result = $aviHtmlElement->content('aviato');
		$test = '<input value="aviato">';
		$result = $aviHtmlElement->attributes(['value' => 'aviato'], false)->content('test');
		$this->assertEquals($test, $result);

		//usual (associative) attributes:
		$test = '<input value="aviato" disabled>';
		$result = $aviHtmlElement->attributes([
			'disabled'
		])->content();
		$this->assertEquals($test, $result);

		//associative keys attributes:
		$test = '<input data-call="submit" data-role="button" value="aviato" disabled>';
		$result = $aviHtmlElement->attributes([
			'data' => [
				'role' => 'button',
				'call' => 'submit'
			]
		])->content();
		$this->assertEquals($test, $result);

		//associative values attributes:
		$test = '<input class="btn btn-primary" data-call="submit" data-role="button" value="aviato" disabled>';
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
		$aviHtmlElement->content([
			$aviHtmlElement->tag('h1')->content('Title'),
			$aviHtmlElement->tag('p')->content('Paragraph')
		], true);
		$result = $aviHtmlElement->content(
			$aviHtmlElement->tag('article')->content('Aviato Soft'));
		$test = '<body><h1>Title</h1><p>Paragraph</p><article>Aviato Soft</article></body>';

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
}

