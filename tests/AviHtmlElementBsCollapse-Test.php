<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElementBs as AviHtmlElement;

final class testAviatoHtmlElementBsCollapse extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new Avi\HtmlElementBs();
		$test = '<div class="collapse"></div>';
		$result = $aviHtmlElement->collapse()->use();
		$this->assertEquals($test, $result);

		$result = $aviHtmlElement->toggle([])->use();
		$this->assertEquals($test, $result);
	}


	/**
	 * @see https://getbootstrap.com/docs/5.3/components/accordion/
	 */
	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new Avi\HtmlElementBs();

		//#Example
		$test = implode('', [
			'<p class="d-inline-flex gap-1">',
			'<a aria-controls="#collapseExample" aria-expanded="false" class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button">',
			'Link with href',
			'</a>',
			'<button aria-controls="#collapseExample" aria-expanded="false" class="btn btn-primary" data-bs-target="#collapseExample" data-bs-toggle="collapse" type="button">',
			'Button with data-bs-target',
			'</button>',
			'</p>',
			'<div class="collapse" id="collapseExample">',
			'<div class="card card-body">',
			'Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->tag('p', [
				'class' => [
					'd-inline-flex',
					'gap-1'
				]
			])->content([
				$aviHtmlElement->element('BsButton', [
					'tag' => 'a',
					'variant' => 'primary'
				])->toggle([
					'type' => 'collapse',
					'target' => '#collapseExample'
				])
				->content('Link with href'),
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->toggle([
					'type' => 'collapse',
					'target' => '#collapseExample'
				])
				->content('Button with data-bs-target')
			]),
			$aviHtmlElement->tag('div', [
				'id' => 'collapseExample'
			])->collapse()
			->content(
				$aviHtmlElement->tag('div', [
					'class' => [
						'card',
						'card-body'
					]
				])->content('Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.')
			)
		]);

		$this->assertEquals($test, $result);


		//Horizontal
		$test = implode('', [
			'<p>',
			'<button aria-controls="#collapseWidthExample" aria-expanded="false" class="btn btn-primary" data-bs-target="#collapseWidthExample" data-bs-toggle="collapse" type="button">',
			'Toggle width collapse',
			'</button>',
			'</p>',
			'<div style="min-height: 120px;">',
			'<div class="collapse collapse-horizontal" id="collapseWidthExample">',
			'<div class="card card-body" style="width: 300px;">',
			'This is some placeholder content for a horizontal collapse. It\'s hidden by default and shown when triggered.',
			'</div>',
			'</div>',
			'</div>',
		]);
		$result = implode('', [
			$aviHtmlElement->tag('p')
				->content(
					$aviHtmlElement->element('BsButton', [
						'variant' => 'primary'
					])->toggle([
						'type' => 'collapse',
						'target' => '#collapseWidthExample'
					])
					->content('Toggle width collapse')
				),
			$aviHtmlElement->tag('div', [
					'style' => 'min-height: 120px;'
			])->content([
				$aviHtmlElement->tag('div', [
						'id' => 'collapseWidthExample'
					])->collapse([
						'direction' => 'horizontal'
					])->content(
						$aviHtmlElement->tag('div', [
							'class' => [
								'card',
								'card-body'
							],
							'style' => 'width: 300px;'
						])->content('This is some placeholder content for a horizontal collapse. It\'s hidden by default and shown when triggered.')
					)
				])
		]);
		$this->assertEquals($test, $result);


		//Multiple toggles and targets
		$test = implode('', [
			'<p class="d-inline-flex gap-1">',
			'<a aria-controls="#multiCollapseExample1" aria-expanded="false" class="btn btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button">Toggle first element</a>',
			'<button aria-controls="#multiCollapseExample2" aria-expanded="false" class="btn btn-primary" data-bs-target="#multiCollapseExample2" data-bs-toggle="collapse" type="button">Toggle second element</button>',
			'<button aria-controls="multiCollapseExample1 multiCollapseExample2" aria-expanded="false" class="btn btn-primary" data-bs-target=".multi-collapse" data-bs-toggle="collapse" type="button">Toggle both elements</button>',
			'</p>',

			'<div class="row">',

			'<div class="col">',
			'<div class="collapse multi-collapse" id="multiCollapseExample1">',
			'<div class="card card-body">',
			'Some placeholder content for the first collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="col">',
			'<div class="collapse multi-collapse" id="multiCollapseExample2">',
			'<div class="card card-body">',
			'Some placeholder content for the second collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.',
			'</div>',
			'</div>',
			'</div>',

			'</div>'

		]);

		$result = implode('', [
			$aviHtmlElement->tag('p', [
				'class' => [
					'd-inline-flex',
					'gap-1'
				]
			])->content([
				$aviHtmlElement->element('BsButton', [
					'tag' => 'a',
					'variant' => 'primary'
				])->toggle([
					'type' => 'collapse',
					'target' => '#multiCollapseExample1'
				])->content('Toggle first element'),

				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->toggle([
					'type' => 'collapse',
					'target' => '#multiCollapseExample2'
				])->content('Toggle second element'),

				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary',
				])->toggle([
					'controls' => implode(' ', [
						'multiCollapseExample1',
						'multiCollapseExample2'
					]),
					'target' => '.multi-collapse',
					'type' => 'collapse'
				])->content('Toggle both elements')
			]),

			$aviHtmlElement->tag('div', [
				'class' => 'row'
			])->content([
				$aviHtmlElement->tag('div', [
					'class' => 'col'
				])->content(
					$aviHtmlElement->tag('div', [
						'id' => 'multiCollapseExample1',
						'class' => [
							'multi-collapse'
						]
					])->collapse()
					->content(
						$aviHtmlElement->tag('div', [
							'class' => [
								'card',
								'card-body'
							]
						])->content('Some placeholder content for the first collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.')
					)
				),

				$aviHtmlElement->tag('div', [
					'class' => 'col'
				])->content(
					$aviHtmlElement->tag('div', [
						'id' => 'multiCollapseExample2',
						'class' => [
							'multi-collapse'
						]
					])->collapse()
					->content(
						$aviHtmlElement->tag('div', [
							'class' => [
								'card',
								'card-body'
							]
						])->content('Some placeholder content for the second collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.')
					)
				)
			])
		]);

		$this->assertEquals($test, $result);
	}

}
