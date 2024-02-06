<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsCarousel extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div class="carousel slide" id="carousel-id">',

			'<div class="carousel-inner"></div>',

			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carousel-id" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',

			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carousel-id" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',

			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCarousel')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{

		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div class="carousel slide" id="carousel-id">',

			'<div class="carousel-inner"></div>',

			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carousel-id" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',

			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carousel-id" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',

			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCarousel')->use();
		$this->assertEquals($test, $result);
	}


	/**
	 * @see https://getbootstrap.com/docs/5.3/components/carousel/
	 */
	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Example
		$test = implode('', [
			'<div class="carousel slide" id="carouselExample">',
			'<div class="carousel-inner">',
			'<div class="active carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'</div>',
			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExample" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',
			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExample" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsCarousel', [
			'id' => 'carouselExample',
			'items' => [
				[
					'alt' => '...',
					'src' => '...'
				],
				[
					'alt' => '...',
					'src' => '...'
				],
				[
					'alt' => '...',
					'src' => '...'
				],
			]
		])->use();
		$this->assertEquals($test, $result);


		//Indicators
		$test = implode('', [
			'<div class="carousel slide" id="carouselExampleIndicators">',

			'<div class="carousel-indicators">',
			'<button aria-current="true" aria-label="Slide 1" class="active" data-bs-slide-to="0" data-bs-target="#carouselExampleIndicators" type="button"></button>',
			'<button aria-label="Slide 2" data-bs-slide-to="1" data-bs-target="#carouselExampleIndicators" type="button"></button>',
			'<button aria-label="Slide 3" data-bs-slide-to="2" data-bs-target="#carouselExampleIndicators" type="button"></button>',
			'</div>',

			'<div class="carousel-inner">',
			'<div class="active carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'</div>',

			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleIndicators" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',

			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleIndicators" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',

			'</div>'
		]);

		$result = $aviHtmlElement->element('BsCarousel', [
			'id' => 'carouselExampleIndicators',
			'indicators' => true,
			'items' => [
				[
					'alt' => '...',
					'src' => '...'
				],
				[
					'alt' => '...',
					'src' => '...'
				],
				[
					'alt' => '...',
					'src' => '...'
				],
			]
		])->use();
		$this->assertEquals($test, $result);


		//Captions
		$test = implode('', [
			'<div class="carousel slide" id="carouselExampleCaptions">',
			'<div class="carousel-indicators">',
			'<button aria-current="true" aria-label="Slide 1" class="active" data-bs-slide-to="0" data-bs-target="#carouselExampleCaptions" type="button"></button>',
			'<button aria-label="Slide 2" data-bs-slide-to="1" data-bs-target="#carouselExampleCaptions" type="button"></button>',
			'<button aria-label="Slide 3" data-bs-slide-to="2" data-bs-target="#carouselExampleCaptions" type="button"></button>',
			'</div>',
			'<div class="carousel-inner">',
			'<div class="active carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'<div class="carousel-caption d-md-block d-none">',
			'<h5>First slide label</h5>',
			'<p>Some representative placeholder content for the first slide.</p>',
			'</div>',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'<div class="carousel-caption d-md-block d-none">',
			'<h5>Second slide label</h5>',
			'<p>Some representative placeholder content for the second slide.</p>',
			'</div>',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'<div class="carousel-caption d-md-block d-none">',
			'<h5>Third slide label</h5>',
			'<p>Some representative placeholder content for the third slide.</p>',
			'</div>',
			'</div>',
			'</div>',
			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleCaptions" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',
			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleCaptions" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',
			'</div>'
		]);

		$result = $aviHtmlElement->element('BsCarousel', [
			'id' => 'carouselExampleCaptions',
			'indicators' => true,
			'items' => [
				[
					'alt' => '...',
					'src' => '...',
					'caption' => [
						$aviHtmlElement->tag('h5')->content('First slide label'),
						$aviHtmlElement->tag('p')->content('Some representative placeholder content for the first slide.')
					]
				],
				[
					'alt' => '...',
					'src' => '...',
					'caption' => [
						$aviHtmlElement->tag('h5')->content('Second slide label'),
						$aviHtmlElement->tag('p')->content('Some representative placeholder content for the second slide.')
					]
				],
				[
					'alt' => '...',
					'src' => '...',
					'caption' => [
						$aviHtmlElement->tag('h5')->content('Third slide label'),
						$aviHtmlElement->tag('p')->content('Some representative placeholder content for the third slide.')
					]
				],
			]
		])->use();
		$this->assertEquals($test, $result);


		//Crossfade
		$test = implode('', [
			'<div class="carousel carousel-fade slide" id="carouselExampleFade">',

			'<div class="carousel-inner">',

			'<div class="active carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',

			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',

			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',

			'</div>',

			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleFade" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',

			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleFade" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',

			'</div>'
		]);

		$result = $aviHtmlElement->element('BsCarousel', [
			'fade' => true,
			'id' => 'carouselExampleFade',
		])->content([
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
		]);
		$this->assertEquals($test, $result);


		//Autoplaying carousels
		$test = implode('', [
			'<div class="carousel slide" data-bs-ride="carousel" id="carouselExampleAutoplaying">',

			'<div class="carousel-inner">',
			'<div class="active carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'</div>',

			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleAutoplaying" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',

			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleAutoplaying" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',
			'</div>',
		]);

		$result = $aviHtmlElement->element('BsCarousel', [
			'autoplay' => 'carousel',
			'id' => 'carouselExampleAutoplaying',
		])->content([
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
		]);
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<div class="carousel slide" data-bs-ride="true" id="carouselExampleRide">',
			'<div class="carousel-inner">',
			'<div class="active carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'</div>',

			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleRide" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',

			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleRide" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',
			'</div>'
		]);

		$result = $aviHtmlElement->element('BsCarousel', [
			'autoplay' => 'true',
			'id' => 'carouselExampleRide',
		])->content([
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
		]);
		$this->assertEquals($test, $result);


		//interval
		$test = implode('', [
			'<div class="carousel slide" data-bs-ride="carousel" id="carouselExampleInterval">',
			'<div class="carousel-inner">',
			'<div class="active carousel-item" data-bs-interval="10000">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item" data-bs-interval="2000">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'</div>',
			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleInterval" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',

			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleInterval" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',

			'</div>'
		]);

		$result = $aviHtmlElement->element('BsCarousel', [
			'autoplay' => 'carousel',
			'id' => 'carouselExampleInterval',
		])->content([
			[
				'alt' => '...',
				'interval' => '10000',
				'src' => '...'
			],
			[
				'alt' => '...',
				'interval' => '2000',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
		]);
		$this->assertEquals($test, $result);



	//Autoplaying carousels without controls
		$test = implode('', [
			'<div class="carousel slide" data-bs-ride="carousel" id="carouselExampleSlidesOnly">',
			'<div class="carousel-inner">',
			'<div class="active carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'</div>',
			'</div>'
		]);

		$result = $aviHtmlElement->element('BsCarousel', [
			'autoplay' => 'carousel',
			'controls' => false,
			'id' => 'carouselExampleSlidesOnly',
		])->content([
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
		]);
		$this->assertEquals($test, $result);


		//Disable touch swiping
		$test = implode('', [
			'<div class="carousel slide" data-bs-touch="false" id="carouselExampleControlsNoTouching">',
			'<div class="carousel-inner">',
			'<div class="active carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'<div class="carousel-item">',
			'<img alt="..." class="d-block w-100" src="...">',
			'</div>',
			'</div>',
			'<button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleControlsNoTouching" type="button">',
			'<span aria-hidden="true" class="carousel-control-prev-icon"></span>',
			'<span class="visually-hidden">Previous</span>',
			'</button>',

			'<button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleControlsNoTouching" type="button">',
			'<span aria-hidden="true" class="carousel-control-next-icon"></span>',
			'<span class="visually-hidden">Next</span>',
			'</button>',
			'</div>'
		]);

		$result = $aviHtmlElement->element('BsCarousel', [
			'touch' => false,
			'id' => 'carouselExampleControlsNoTouching',
		])->content([
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
			[
				'alt' => '...',
				'src' => '...'
			],
		]);
		$this->assertEquals($test, $result);

	}
}
