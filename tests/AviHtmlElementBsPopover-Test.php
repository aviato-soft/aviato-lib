<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElementBs as AviHtmlElement;

final class testAviatoHtmlElementBsPopover extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new Avi\HtmlElementBs();
		$test = '<div data-bs-toggle="popover"></div>';
		$result = $aviHtmlElement->popover()->use();
		$this->assertEquals($test, $result);

	}


	/**
	 * @see https://getbootstrap.com/docs/5.3/components/accordion/
	 */
	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new Avi\HtmlElementBs();

		//Live demo
		$test = implode('', [
			'<button class="btn btn-danger btn-lg" data-bs-content="And here\'s some amazing content. It\'s very engaging. Right?" data-bs-title="Popover title" data-bs-toggle="popover" type="button">',
			'Click to toggle popover',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'size' => 'lg',
			'variant' => 'danger'
		])->popover([
			'content' => 'And here\'s some amazing content. It\'s very engaging. Right?',
			'title' => 'Popover title'
		])->content('Click to toggle popover');
		$this->assertEquals($test, $result);


		//Four directions
		$test = implode('', [
			'<button class="btn btn-secondary" data-bs-container="body" data-bs-content="Top popover" data-bs-placement="top" data-bs-toggle="popover" type="button">',
			'Popover on top',
			'</button>',
			'<button class="btn btn-secondary" data-bs-container="body" data-bs-content="Right popover" data-bs-placement="right" data-bs-toggle="popover" type="button">',
			'Popover on right',
			'</button>',
			'<button class="btn btn-secondary" data-bs-container="body" data-bs-content="Bottom popover" data-bs-placement="bottom" data-bs-toggle="popover" type="button">',
			'Popover on bottom',
			'</button>',
			'<button class="btn btn-secondary" data-bs-container="body" data-bs-content="Left popover" data-bs-placement="left" data-bs-toggle="popover" type="button">',
			'Popover on left',
			'</button>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'variant' => 'secondary'
			])
			->popover([
				'container' => 'body',
				'content' => 'Top popover',
				'placement' => 'top',
			])->content('Popover on top'),
			$aviHtmlElement->element('BsButton', [
				'variant' => 'secondary'
			])
			->popover([
				'container' => 'body',
				'content' => 'Right popover',
				'placement' => 'right',
			])->content('Popover on right'),
			$aviHtmlElement->element('BsButton', [
				'variant' => 'secondary'
			])
			->popover([
				'container' => 'body',
				'content' => 'Bottom popover',
				'placement' => 'bottom',
			])->content('Popover on bottom'),
			$aviHtmlElement->element('BsButton', [
				'variant' => 'secondary'
			])
			->popover([
				'container' => 'body',
				'content' => 'Left popover',
				'placement' => 'left',
			])->content('Popover on left')
		]);
		$this->assertEquals($test, $result);


		//Custom popovers\
		$test = implode('', [
			'<button class="btn btn-secondary" ',
			'data-bs-content="This popover is themed via CSS variables." ',
			'data-bs-custom-class="custom-popover" ',
			'data-bs-placement="right" ',
			'data-bs-title="Custom popover" ',
			'data-bs-toggle="popover" ',
			'type="button">',
			'Custom popover',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'variant' => 'secondary'
		])->popover([
			'content' => 'This popover is themed via CSS variables.',
			'custom-class' => 'custom-popover',
			'placement' => 'right',
			'title' => 'Custom popover'

		])->content('Custom popover');
		$this->assertEquals($test, $result);


		//Dismiss on next click
		$test = implode('', [
			'<a ',
			'class="btn btn-danger btn-lg" ',
			'data-bs-content="And here\'s some amazing content. It\'s very engaging. Right?" ',
			'data-bs-title="Dismissible popover" ',
			'data-bs-toggle="popover" ',
			'data-bs-trigger="focus" ',
			'role="button" ',
			'tabindex="0"',
			'>',
			'Dismissible popover',
			'</a>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'size' =>'lg',
			'tag' => 'a',
			'variant' => 'danger'
		])->popover([
			'content' => 'And here\'s some amazing content. It\'s very engaging. Right?',
			'title' => 'Dismissible popover',
			'trigger' => 'focus'
		])->content('Dismissible popover');
		$this->assertEquals($test, $result);

		//Disabled elements
	}

}
