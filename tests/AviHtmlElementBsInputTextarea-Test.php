<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsInputTextarea extends TestCase
{

	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = '<textarea class="form-control"></textarea>';
		$result = $aviHtmlElement->element('BsInputTextarea')->use();

		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = '<textarea class="form-control" cols="10" rows="20">Aviato Soft</textarea>';
		$result = $aviHtmlElement->element('BsInputTextarea', [
			'cols' => '10',
			'rows' => '20',
			'text' => 'Aviato Soft'
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsInputTextarea', [
			'cols' => '10',
			'rows' => '20'
		])->content('Aviato Soft');
		$this->assertEquals($test, $result);

	}

}
