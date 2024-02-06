<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';
require_once dirname(__FILE__).'/../src/HtmlElement/HtmlElementBs.php';

use PHPUnit\Framework\TestCase;
use \Avi\HtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsTootlip extends TestCase
{

/**
 * @see https://getbootstrap.com/docs/5.3/components/tooltips/
 */
	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElementBs();

		$test = implode('', [
			'<p class="muted">',
			'Placeholder text to demonstrate some ',
			'<a data-bs-title="Default tooltip" data-bs-toggle="tooltip" href="#">inline links</a>',
			' with tooltips. ',
			'This is now just filler, no killer. ',
			'Content placed here just to mimic the presence of ',
			'<a data-bs-title="Another tooltip" data-bs-toggle="tooltip" href="#">real text</a>. ',
			'And all that just to give you an idea of how tooltips would look when used in real-world situations. ',
			'So hopefully you\'ve now seen how ',
			'<a data-bs-title="Another one here too" data-bs-toggle="tooltip" href="#">these tooltips on links</a>',
			' can work in practice, once you use them on ',
			'<a data-bs-title="The last tip!" data-bs-toggle="tooltip" href="#">your own</a> site or project.',
			'</p>'
		]);
		$result = $aviHtmlElement->tag('p')
		->attributes(['class'=>'muted'])
		->content([
			'Placeholder text to demonstrate some ',
			$aviHtmlElement->tag('a', [
				'href' => '#',
			])
			->tooltip([
				'title' => 'Default tooltip'
			])->content('inline links'),
			' with tooltips. ',
			'This is now just filler, no killer. ',
			'Content placed here just to mimic the presence of ',
			$aviHtmlElement->tag('a', [
				'href' => '#'
			])
			->tooltip([
				'title' => 'Another tooltip'
			])
			->content('real text'),
			'. ',
			'And all that just to give you an idea of how tooltips would look when used in real-world situations. ',
			'So hopefully you\'ve now seen how ',
			$aviHtmlElement->tag('a', [
				'href' => '#'
			])
			->tooltip([
				'title' => 'Another one here too'
			])
			->content('these tooltips on links'),
			' can work in practice, once you use them on ',
			$aviHtmlElement->tag('a', [
				'href' => '#'
			])
			->tooltip([
				'title' => 'The last tip!'
			])
			->content('your own'),
			' site or project.'
		]);
		$this->assertEquals($test, $result);


		//Custom Tooltips
		$test = implode('', [
			'<button class="btn btn-secondary" ',
			'data-bs-custom-class="custom-tooltip" ',
			'data-bs-placement="top" ',
			'data-bs-title="This top tooltip is themed via CSS variables." ',
			'data-bs-toggle="tooltip" ',
			'type="button">',
			'Custom tooltip',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'text' => 'Custom tooltip',
			'variant' => 'secondary'
		])
		->tooltip([
			'custom-class' => 'custom-tooltip',
			'placement' => 'top',
			'title' => 'This top tooltip is themed via CSS variables.'
		])->use();
		$this->assertEquals($test, $result);


		//Directions
		$test = implode('', [
			'<button class="btn btn-secondary" data-bs-placement="top" data-bs-title="Tooltip on top" data-bs-toggle="tooltip" type="button">',
			'Tooltip on top',
			'</button>',
			'<button class="btn btn-secondary" data-bs-placement="right" data-bs-title="Tooltip on right" data-bs-toggle="tooltip" type="button">',
			'Tooltip on right',
			'</button>',
			'<button class="btn btn-secondary" data-bs-placement="bottom" data-bs-title="Tooltip on bottom" data-bs-toggle="tooltip" type="button">',
			'Tooltip on bottom',
			'</button>',
			'<button class="btn btn-secondary" data-bs-placement="left" data-bs-title="Tooltip on left" data-bs-toggle="tooltip" type="button">',
			'Tooltip on left',
			'</button>',

			'<button class="btn btn-secondary" data-bs-title="Tooltip on bottom" data-bs-toggle="tooltip" type="button">',
			'Tooltip on bottom',
			'</button>',
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'variant' => 'secondary'
			])
			->tooltip([
				'placement' => 'top',
				'title' => 'Tooltip on top'
			])->content('Tooltip on top'),
			$aviHtmlElement->element('BsButton', [
				'variant' => 'secondary'
			])
			->tooltip([
				'placement' => 'right',
				'title' => 'Tooltip on right'
			])->content('Tooltip on right'),
			$aviHtmlElement->element('BsButton', [
				'variant' => 'secondary'
			])
			->tooltip([
				'placement' => 'bottom',
				'title' => 'Tooltip on bottom'
			])->content('Tooltip on bottom'),
			$aviHtmlElement->element('BsButton', [
				'variant' => 'secondary'
			])
			->tooltip([
				'placement' => 'left',
				'title' => 'Tooltip on left'
			])->content('Tooltip on left'),
			$aviHtmlElement->element('BsButton', [
				'variant' => 'secondary'
			])
			->tooltip([
				'title' => 'Tooltip on bottom'
			])->content('Tooltip on bottom'),
		]);
		$this->assertEquals($test, $result);


		//custom HTML
		$test = implode('', [
			'<button class="btn btn-secondary" data-bs-html="true" data-bs-title="<em>Tooltip</em> <u>with</u> <b>HTML</b>" data-bs-toggle="tooltip" type="button">',
			'Tooltip with HTML',
			'</button>'
		]);
		$result = $aviHtmlElement->element('BsButton', [
			'variant' => 'secondary'
		])
		->tooltip([
			'isHtml' => true,
			'title' => '<em>Tooltip</em> <u>with</u> <b>HTML</b>'
		])
		->content('Tooltip with HTML');

	}
}
