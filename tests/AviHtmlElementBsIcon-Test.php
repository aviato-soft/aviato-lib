<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsIcon extends TestCase
{

	public function testFn_Construct(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//full test:
		$test = '<span class="bi bi-airplane" data-role="icon"></span>';
		$result = $aviHtmlElement->element('BsIcon', [
			'attr' => [
				'data' => [
					'role' => 'icon'
				]
			],
			'slug' => 'airplane',
			'tag' => 'span'
		])->use();
		$this->assertEquals($test, $result);


		//icon base class
		$test = '<i class="bi bi-bootstrap"></i>';
		$result = $aviHtmlElement->element('BsIcon')->use();
		$this->assertEquals($test, $result);

		$test = '<i class="bi bi-airplane"></i>';
		$result = $aviHtmlElement->element('BsIcon', 'airplane')->use();
		$this->assertEquals($test, $result);

		$test = '<i class="bi bi-airplane"></i>';
		$result = $aviHtmlElement->element('BsIcon', 'bi-airplane')->use();
		$this->assertEquals($test, $result);

		$test = '<i class="bi bi-airplane"></i>';
		$result = $aviHtmlElement->element('BsIcon', [
			'slug' => 'airplane'
		])->use();
		$this->assertEquals($test, $result);

		//Usage on button
		$test = '<button class="btn" type="button"><i class="bi bi-airplane"></i></button>';
		$result = $aviHtmlElement->element('BsButton', [
			'icon' => 'airplane'
		])->use();
		$result = $aviHtmlElement->element('BsButton')->icon('airplane')->use();
		$this->assertEquals($test, $result);

	}
}
