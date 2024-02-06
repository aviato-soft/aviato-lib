<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsAccordion extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = '<div class="accordion"></div>';
		$result = $aviHtmlElement->element('BsAccordion')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div class="accordion accordion-flush">',
			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="item-1" aria-expanded="false" class="accordion-button collapsed" data-bs-target="#item-1" data-bs-toggle="collapse" type="button">Label 1</button>',
			'</h2>',
			'<div class="accordion-collapse collapse" data-bs-parent="#" id="item-1">',
			'<div class="accordion-body">Text 1</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsAccordion', [
			'flush' => true
		])
		->content([
			[
				'id' => 'item-1',
				'label' => 'Label 1',
				'text' => 'Text 1'
			]
		]);
		$this->assertEquals($test, $result);
	}


	/**
	 * @see https://getbootstrap.com/docs/5.3/components/accordion/
	 */
	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//#Example
		$test = implode('', [
			'<div class="accordion" id="accordionExample">',

			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="collapseOne" aria-expanded="true" class="accordion-button" data-bs-target="#collapseOne" data-bs-toggle="collapse" type="button">',
			'Accordion Item #1',
			'</button>',
			'</h2>',
			'<div class="accordion-collapse collapse show" data-bs-parent="#accordionExample" id="collapseOne">',
			'<div class="accordion-body">',
			'<strong>This is the first item\'s accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="collapseTwo" aria-expanded="false" class="accordion-button collapsed" data-bs-target="#collapseTwo" data-bs-toggle="collapse" type="button">',
			'Accordion Item #2',
			'</button>',
			'</h2>',
			'<div class="accordion-collapse collapse" data-bs-parent="#accordionExample" id="collapseTwo">',
			'<div class="accordion-body">',
			'<strong>This is the second item\'s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="collapseThree" aria-expanded="false" class="accordion-button collapsed" data-bs-target="#collapseThree" data-bs-toggle="collapse" type="button">',
			'Accordion Item #3',
			'</button>',
			'</h2>',
			'<div class="accordion-collapse collapse" data-bs-parent="#accordionExample" id="collapseThree">',
			'<div class="accordion-body">',
			'<strong>This is the third item\'s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
			'</div>',
			'</div>',
			'</div>',

			'</div>'
		]);
		$result = $aviHtmlElement->element('BsAccordion', [
			'id' => 'accordionExample',
			'items' => [
				[
					'expanded' => true,
					'id' => 'collapseOne',
					'label' => 'Accordion Item #1',
					'text' => '<strong>This is the first item\'s accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.'
				],
				[
					'id' => 'collapseTwo',
					'label' => 'Accordion Item #2',
					'text' => '<strong>This is the second item\'s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.'
				],
				[
					'id' => 'collapseThree',
					'label' => 'Accordion Item #3',
					'text' => '<strong>This is the third item\'s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.'
				]
			]
		])->use();
		$this->assertEquals($test, $result);


		//#Flush
		$test = implode('', [
			'<div class="accordion accordion-flush" id="accordionFlushExample">',

			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="flush-collapseOne" aria-expanded="false" class="accordion-button collapsed" data-bs-target="#flush-collapseOne" data-bs-toggle="collapse" type="button">',
			'Accordion Item #1',
			'</button>',
			'</h2>',
			'<div class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample" id="flush-collapseOne">',
			'<div class="accordion-body">',
			'Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item\'s accordion body.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="flush-collapseTwo" aria-expanded="false" class="accordion-button collapsed" data-bs-target="#flush-collapseTwo" data-bs-toggle="collapse" type="button">',
			'Accordion Item #2',
			'</button>',
			'</h2>',
			'<div class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample" id="flush-collapseTwo">',
			'<div class="accordion-body">',
			'Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item\'s accordion body. Let\'s imagine this being filled with some actual content.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="flush-collapseThree" aria-expanded="false" class="accordion-button collapsed" data-bs-target="#flush-collapseThree" data-bs-toggle="collapse" type="button">',
			'Accordion Item #3',
			'</button>',
			'</h2>',
			'<div class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample" id="flush-collapseThree">',
			'<div class="accordion-body">',
			'Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item\'s accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.',
			'</div>',
			'</div>',
			'</div>',

			'</div>'
		]);
		$result = $aviHtmlElement->element('BsAccordion', [
			'flush' => true,
			'id' => 'accordionFlushExample',
			'items' => [

				[
					'id' => 'flush-collapseOne',
					'label' => 'Accordion Item #1',
					'text' => 'Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item\'s accordion body.'
				],

				[
					'id' => 'flush-collapseTwo',
					'label' => 'Accordion Item #2',
					'text' => 'Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item\'s accordion body. Let\'s imagine this being filled with some actual content.'
				],

				[
					'id' => 'flush-collapseThree',
					'label' => 'Accordion Item #3',
					'text' => 'Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item\'s accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.'
				]
			]
		])->use();
		$this->assertEquals($test, $result);


		//#Always open
		$test = implode('', [
			'<div class="accordion" id="accordionPanelsStayOpenExample">',

			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="panelsStayOpen-collapseOne" aria-expanded="true" class="accordion-button" data-bs-target="#panelsStayOpen-collapseOne" data-bs-toggle="collapse" type="button">',
			'Accordion Item #1',
			'</button>',
			'</h2>',
			'<div class="accordion-collapse collapse show" id="panelsStayOpen-collapseOne">',
			'<div class="accordion-body">',
			'<strong>This is the first item\'s accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="panelsStayOpen-collapseTwo" aria-expanded="false" class="accordion-button collapsed" data-bs-target="#panelsStayOpen-collapseTwo" data-bs-toggle="collapse" type="button">',
			'Accordion Item #2',
			'</button>',
			'</h2>',
			'<div class="accordion-collapse collapse" id="panelsStayOpen-collapseTwo">',
			'<div class="accordion-body">',
			'<strong>This is the second item\s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="accordion-item">',
			'<h2 class="accordion-header">',
			'<button aria-controls="panelsStayOpen-collapseThree" aria-expanded="false" class="accordion-button collapsed" data-bs-target="#panelsStayOpen-collapseThree" data-bs-toggle="collapse" type="button">',
			'Accordion Item #3',
			'</button>',
			'</h2>',
			'<div class="accordion-collapse collapse" id="panelsStayOpen-collapseThree">',
			'<div class="accordion-body">',
			'<strong>This is the third item\'s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
			'</div>',
			'</div>',
			'</div>',

			'</div>'
		]);
		$result = $aviHtmlElement->element('BsAccordion', [
			'id' => 'accordionPanelsStayOpenExample',
			'items' => [

				[
					'always-open' => true,
					'expanded' => true,
					'id' => 'panelsStayOpen-collapseOne',
					'label' => 'Accordion Item #1',
					'text' => '<strong>This is the first item\'s accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.'
				],

				[
					'always-open' => true,
					'id' => 'panelsStayOpen-collapseTwo',
					'label' => 'Accordion Item #2',
					'text' => '<strong>This is the second item\s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.'
				],

				[
					'always-open' => true,
					'id' => 'panelsStayOpen-collapseThree',
					'label' => 'Accordion Item #3',
					'text' => '<strong>This is the third item\'s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.'
				]

			]
		])->use();
		$this->assertEquals($test, $result);
	}

}
