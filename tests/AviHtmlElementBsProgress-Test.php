<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsProgress extends TestCase
{

	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" class="progress" role="progressbar">',
			'<div class="progress-bar" style="width:0%"></div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsProgress')->use();
		$this->assertEquals($test, $result);

	}

/*
	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//full test:
		$test = '<span class="badge bg-primary rounded-pill text-bg-light">New</span>';
		$result = $aviHtmlElement->element('BsBadge', [
			'bg-color' => 'primary', //AVI_BS_COLOR
			'color' => 'light', //AVI_BS_COLOR
			'pill' => true, //true | false
			'text' => 'Aviato'
		])->content('New'); //content overwrite text
		$this->assertEquals($test, $result);
	}
*/

	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = [];
		$tplTest = implode('', [
			'<div aria-label="Basic example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="%s" class="progress" role="progressbar">',
			'<div class="progress-bar" style="width:%s%%"></div>',
			'</div>'
		]);
		$result = [];
		for($i = 0; $i <= 100; $i+= 25) {
			$test[] = sprintf($tplTest, $i, $i);
			$result[] = $aviHtmlElement->element('BsProgress', [
				'value' => $i
			])->attributes([
				'aria' => [
					'label' => 'Basic example'
				]
			])->use();
		}
		$this->assertEquals($test, $result);

		//Bar sizing
		// Width
		$test = implode('', [
			'<div aria-label="Basic example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" class="progress" role="progressbar">',
			'<div class="progress-bar" style="width:75%"></div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsProgress', [
			'value' => 75
		])->attributes([
			'aria' => [
				'label' => 'Basic example'
			]
		])->use();
		$this->assertEquals($test, $result);

		//Height
		$test = implode('', [
			'<div aria-label="Example 1px high" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress" role="progressbar" style="height:1px">',
			'<div class="progress-bar" style="width:25%"></div>',
			'</div>',
			'<div aria-label="Example 20px high" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress" role="progressbar" style="height:20px">',
			'<div class="progress-bar" style="width:25%"></div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsProgress', [
				'height' => 1,
				'value' => 25
			])->attributes([
				'aria' => [
					'label' => 'Example 1px high'
				]
			])->use(),
			$aviHtmlElement->element('BsProgress', [
				'height' => 20,
				'value' => 25
			])->attributes([
				'aria' => [
					'label' => 'Example 20px high'
				]
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Labels
		$test = implode('', [
			'<div aria-label="Example with label" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress" role="progressbar">',
			'<div class="progress-bar" style="width:25%">25%</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsProgress', [
			'label' => true,
			'value' => 25
		])->attributes([
			'aria' => [
				'label' => 'Example with label'
			]
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div aria-label="Example with label" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" class="progress" role="progressbar">',
			'<div class="overflow-visible progress-bar text-dark" style="width:10%">Long label text for the progress bar, set to a dark color</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsProgress', [
			'label' => 'Long label text for the progress bar, set to a dark color',
			'value' => 10
		])->attributes([
			'aria' => [
				'label' => 'Example with label'
			]
		])->bar([
			'attr' => [
				'class' => [
					'overflow-visible',
					'text-dark'
				]
			]
		])->use();
		$this->assertEquals($test, $result);


		//Backgrounds
		$test = implode('', [
			'<div aria-label="Success example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress" role="progressbar">',
			'<div class="bg-success progress-bar" style="width:25%"></div>',
			'</div>',
			'<div aria-label="Info example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" class="progress" role="progressbar">',
			'<div class="bg-info progress-bar" style="width:50%"></div>',
			'</div>',
			'<div aria-label="Warning example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" class="progress" role="progressbar">',
			'<div class="bg-warning progress-bar" style="width:75%"></div>',
			'</div>',
			'<div aria-label="Danger example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="100" class="progress" role="progressbar">',
			'<div class="bg-danger progress-bar" style="width:100%"></div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsProgress', [
				'value' => 25
			])->attributes([
				'aria' => [
					'label' => 'Success example'
				]
			])->bar([
				'attr' => [
					'class' => [
						'bg-success'
					]
				]
			])->use(),
			$aviHtmlElement->element('BsProgress', [
				'value' => 50
			])->attributes([
				'aria' => [
					'label' => 'Info example'
				]
			])->bar([
				'attr' => [
					'class' => [
						'bg-info'
					]
				]
			])->use(),
			$aviHtmlElement->element('BsProgress', [
				'value' => 75
			])->attributes([
				'aria' => [
					'label' => 'Warning example'
				]
			])->bar([
				'attr' => [
					'class' => [
						'bg-warning'
					]
				]
			])->use(),
			$aviHtmlElement->element('BsProgress', [
				'value' => 100
			])->attributes([
				'aria' => [
					'label' => 'Danger example'
				]
			])->bar([
				'attr' => [
					'class' => [
						'bg-danger'
					]
				]
			])->use(),
		]);
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<div aria-label="Warning example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" class="progress" role="progressbar">',
			'<div class="progress-bar text-bg-warning" style="width:75%">75%</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsProgress', [
			'label' => true,
			'value' => 75,
			'variant' => 'warning'
		])->attributes([
			'aria' => [
				'label' => 'Warning example'
			]
		])->use();
		$this->assertEquals($test, $result);


		//Multiple bars
		$test = implode('', [
			'<div class="progress-stacked">',
			'<div aria-label="Segment one" aria-valuemax="100" aria-valuemin="0" aria-valuenow="15" class="progress" role="progressbar" style="width:15%">',
			'<div class="progress-bar"></div>',
			'</div>',
			'<div aria-label="Segment two" aria-valuemax="100" aria-valuemin="0" aria-valuenow="30" class="progress" role="progressbar" style="width:30%">',
			'<div class="bg-success progress-bar"></div>',
			'</div>',
			'<div aria-label="Segment three" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" class="progress" role="progressbar" style="width:20%">',
			'<div class="bg-info progress-bar"></div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div', [
			'class' => 'progress-stacked'
		])->content([
			$aviHtmlElement->tag('div', [
				'aria' => [
					'label' => 'Segment one',
					'valuemin' => 0,
					'valuemax' => 100,
					'valuenow' => 15
				],
				'class' => 'progress',
				'role' => 'progressbar',
				'style' => 'width:15%'
			])->content(
				$aviHtmlElement->tag('div', ['class' => 'progress-bar'])
			),
			$aviHtmlElement->tag('div', [
				'aria' => [
					'label' => 'Segment two',
					'valuemin' => 0,
					'valuemax' => 100,
					'valuenow' => 30
				],
				'class' => 'progress',
				'role' => 'progressbar',
				'style' => 'width:30%'
			])->content(
				$aviHtmlElement->tag('div', ['class' => ['bg-success', 'progress-bar']])
			),
			$aviHtmlElement->tag('div', [
				'aria' => [
					'label' => 'Segment three',
					'valuemin' => 0,
					'valuemax' => 100,
					'valuenow' => 20
				],
				'class' => 'progress',
				'role' => 'progressbar',
				'style' => 'width:20%'
			])->content(
				$aviHtmlElement->tag('div', ['class' => ['bg-info', 'progress-bar']])
			)
		]);
		$this->assertEquals($test, $result);


		//Striped
		$test = implode('', [
			'<div aria-label="Default striped example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" class="progress" role="progressbar">',
			'<div class="progress-bar progress-bar-striped" style="width:10%"></div>',
			'</div>',
			'<div aria-label="Success striped example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress" role="progressbar">',
			'<div class="bg-success progress-bar progress-bar-striped" style="width:25%"></div>',
			'</div>',
			'<div aria-label="Info striped example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" class="progress" role="progressbar">',
			'<div class="bg-info progress-bar progress-bar-striped" style="width:50%"></div>',
			'</div>',
			'<div aria-label="Warning striped example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" class="progress" role="progressbar">',
			'<div class="bg-warning progress-bar progress-bar-striped" style="width:75%"></div>',
			'</div>',
			'<div aria-label="Danger striped example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="100" class="progress" role="progressbar">',
			'<div class="bg-danger progress-bar progress-bar-striped" style="width:100%"></div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsProgress', [
				'striped' => true,
				'value' => 10
			])->attributes([
				'aria' => [
					'label' => 'Default striped example'
				]
			])->use(),
			$aviHtmlElement->element('BsProgress', [
				'striped' => true,
				'value' => 25
			])->attributes([
				'aria' => [
					'label' => 'Success striped example'
				]
			])
			->bar([
				'attr' => [
					'class' => [
						'bg-success'
					]
				]
			])->use(),
			$aviHtmlElement->element('BsProgress', [
				'striped' => true,
				'value' => 50
			])->attributes([
				'aria' => [
					'label' => 'Info striped example'
				]
			])
			->bar([
				'attr' => [
					'class' => [
						'bg-info'
					]
				]
			])->use(),
			$aviHtmlElement->element('BsProgress', [
				'striped' => true,
				'value' => 75
			])->attributes([
				'aria' => [
					'label' => 'Warning striped example'
				]
			])
			->bar([
				'attr' => [
					'class' => [
						'bg-warning'
					]
				]
			])->use(),
			$aviHtmlElement->element('BsProgress', [
				'striped' => true,
				'value' => 100
			])->attributes([
				'aria' => [
					'label' => 'Danger striped example'
				]
			])
			->bar([
				'attr' => [
					'class' => [
						'bg-danger'
					]
				]
			])->use(),
		]);
		$this->assertEquals($test, $result);


		//Animated stripes
		$test = implode('', [
			'<div aria-label="Animated striped example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" class="progress" role="progressbar">',
			'<div class="progress-bar progress-bar-animated progress-bar-striped" style="width:75%"></div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsProgress', [
			'animated' => true,
			'attr' => [
				'aria' => [
					'label' => 'Animated striped example'
				]
			],
			'striped' => true,
			'value' => 75
		])->use();
		$this->assertEquals($test, $result);

	}

}
