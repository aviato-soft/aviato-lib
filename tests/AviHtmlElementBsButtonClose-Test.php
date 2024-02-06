<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsButtonClose extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = '<button aria-label="Close" class="btn-close" type="button"></button>';
		$result = $aviHtmlElement->element('BsButtonClose')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = '<button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button" disabled></button>';
		$result = $aviHtmlElement->element('BsButtonClose', [
			'disabled' => true,
			'dismiss' => 'alert'
		])->use();
		$this->assertEquals($test, $result);
	}
}

