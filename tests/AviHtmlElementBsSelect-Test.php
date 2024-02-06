<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsInputSelect extends TestCase
{

	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = '<select class="form-select"></select>';
		$result = $aviHtmlElement->element('BsSelect')->use();

		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = implode('', [
			'<div class="row">',
			'<label class="col-form-label" for="select-id">',
			'Please choose:',
			'</label>',
			'<select aria-describedby="help-select-id" class="form-select form-select-sm" id="select-id">',
			'<option value="1">One</option>',
			'<option selected value="2">Two</option>',
			'<option value="3">Three</option>',
			'</select>',
			'<span class="form-text" id="help-select-id">Help for select</span>',
			'<div class="valid-feedback">The selection is valid</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSelect', [
			'feedback' => [
				'valid' => 'The selection is valid'
			],
			'help' => 'Help for select',
			'id' => 'select-id',
			'items' => [
				[
					'text' => 'One',
					'value' => '1'
				],
				[
					'text' => 'Two',
					'value' => '2',
				],
				[
					'text' => 'Three',
					'value' => '3'
				]
			],
			'label' => 'Please choose:',
			'layout' => 'inline',
			'size' => 'sm',
			'value' => '2'
		])->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->element('BsSelect', [
			'feedback' => [
				'valid' => 'The selection is valid'
			],
			'help' => 'Help for select',
			'id' => 'select-id',
			'label' => 'Please choose:',
			'layout' => 'inline',
			'size' => 'sm',
			'value' => '2'
		])->content([
			[
				'text' => 'One',
				'value' => '1'
			],
			[
				'text' => 'Two',
				'value' => '2',
			],
			[
				'text' => 'Three',
				'value' => '3'
			]
		]);
		$this->assertEquals($test, $result);
	}

}
