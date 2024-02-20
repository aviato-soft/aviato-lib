<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsInput extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = '<input autocomplete="off" class="form-control" type="text">';
		$result = $aviHtmlElement->element('BsInput')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = '<input autocomplete="off" class="form-control" maxlength="33" type="text">';
		$result = $aviHtmlElement->element('BsInput', [

		])->input([
			'attr' => [
				'maxlength' => 33
			]
		])->use();
		$this->assertEquals($test, $result);
	}
}

