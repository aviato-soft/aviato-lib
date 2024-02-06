<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsModal extends TestCase
{

	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div aria-hidden="true" class="fade modal" tabindex="-1">',
			'<div class="modal-dialog">',
			'<div class="modal-content">',
			'<div class="modal-header">',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">',
			'</button>',
			'</div>',
			'<div class="modal-body">',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsModal')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = implode('', [
			'<div aria-hidden="true" aria-labelledby="modal-id-label" class="fade modal" data-bs-backdrop="static" data-bs-keyboard="false" id="modal-id" tabindex="-1">',
			'<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-xxl-down modal-xl">',
			'<div class="modal-content">',
			'<div class="modal-header">',
			'<h5 class="modal-title" id="modal-id-label">',
			'The title',
			'</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">',
			'</button>',
			'</div>',
			'<div class="modal-body">',
			'Body content',
			'</div>',
			'<div class="modal-footer">',
			'The footer',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsModal', [
			'animation' => 'fade',
			'backdrop' => 'static',
			'body' => 'Body content',
			'centered' => true,
			'footer' => 'The footer',
			'fullscreen' => 'xxl',
			'id' => 'modal-id',
			'scrollable' => true,
			'size' => 'xl',
			'title' => 'The title',
		])->use();
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<div aria-hidden="true" class="fade modal" tabindex="-1">',
			'<div class="modal-dialog">',
			'<div class="modal-content">',
			'<div class="modal-header">',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">',
			'</button>',
			'</div>',
			'<div class="modal-body">',
			'The body content',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsModal', 'The body content')->use();
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<div aria-hidden="true" aria-labelledby="modal-id-label" class="modal" data-bs-backdrop="static" data-bs-keyboard="false" id="modal-id" tabindex="-1">',
			'<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">',
			'<div class="modal-content">',
			'<div class="modal-header">',
			'<h5 class="modal-title" id="modal-id-label">',
			'The title',
			'</h5>',
			'</div>',
			'<div class="modal-body">',
			'Body content',
			'</div>',
			'<div class="modal-footer">',
			'The footer',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsModal', [
			'animation' => false,
			'backdrop' => 'static',
			'centered' => true,
			'footer' => 'The footer',
			'fullscreen' => true,
			'id' => 'modal-id',
			'closebutton' => false,
			'scrollable' => true,
			'size' => 'xxxl',
			'title' => 'The title',
		])->content('Body content');
		$this->assertEquals($test, $result);
	}


	/**
	 * @see https://getbootstrap.com/docs/5.3/components/modal/
	 */
	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//#Modal components
		$test = implode('', [
			'<div aria-hidden="true" class="modal" tabindex="-1">',
			'<div class="modal-dialog">',
			'<div class="modal-content">',
			'<div class="modal-header">',
			'<h5 class="modal-title">Modal title</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>',
			'</div>',
			'<div class="modal-body">',
			'<p>Modal body text goes here.</p>',
			'</div>',
			'<div class="modal-footer">',
			'<button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>',
			'<button class="btn btn-primary" type="button">Save changes</button>',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsModal', [
			'animation' => false,
			'title' => 'Modal title',
			'body' => $aviHtmlElement->tag('p')->content('Modal body text goes here.'),
			'footer' => implode('', [
				$aviHtmlElement->element('BsButton', [
					'variant' => 'secondary'
				])->attributes([
					'data' => [
						'bs-dismiss' => 'modal'
					]
				])->content('Close'),
				$aviHtmlElement->element('BsButton', [
					'variant' => 'primary'
				])->content('Save changes')
			])
		])->use();
		$this->assertEquals($test, $result);


		//Live demo
		$test = implode('', [
			//<!-- Button trigger modal -->
			'<button class="btn btn-primary" data-bs-target="#exampleModalLive" data-bs-toggle="modal" type="button">',
			'Launch demo modal',
			'</button>',

			//<!-- Modal -->
			'<div aria-hidden="true" aria-labelledby="exampleModalLive-label" class="fade modal" id="exampleModalLive" tabindex="-1">',
			'<div class="modal-dialog">',
			'<div class="modal-content">',
			'<div class="modal-header">',
			'<h5 class="modal-title" id="exampleModalLive-label">Modal title</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>',
			'</div>',
			'<div class="modal-body">',
			'<p>Woo-hoo, you\'re reading this text in a modal!</p>',
			'</div>',
			'<div class="modal-footer">',
			'<button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>',
			'<button class="btn btn-primary" type="button">Save changes</button>',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsButton', [
				'variant' => 'primary'
			])->attributes([
				'data' => [
					'bs-toggle' => 'modal',
					'bs-target' => '#exampleModalLive'
				]
			])->content('Launch demo modal'),
			$aviHtmlElement->element('BsModal', [
				'id' => 'exampleModalLive',
				'title' => 'Modal title',
				'body' => $aviHtmlElement->tag('p')->content('Woo-hoo, you\'re reading this text in a modal!'),
				'footer' => implode('', [
					$aviHtmlElement->element('BsButton', [
						'variant' => 'secondary'
					])->attributes([
						'data' => [
							'bs-dismiss' => 'modal'
						]
					])->content('Close'),
					$aviHtmlElement->element('BsButton', [
						'variant' => 'primary'
					])->content('Save changes')
				])
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Static backdrop
		$test = implode('', [
			//<!-- Button trigger modal -->
			'<button class="btn btn-primary" data-bs-target="#staticBackdrop" data-bs-toggle="modal" type="button">',
			'Launch static backdrop modal',
			'</button>',

			//<!-- Modal -->
			'<div aria-hidden="true" aria-labelledby="staticBackdropLive-label" class="fade modal" data-bs-backdrop="static" data-bs-keyboard="false" id="staticBackdropLive" tabindex="-1">',
			'<div class="modal-dialog">',
			'<div class="modal-content">',
			'<div class="modal-header">',
			'<h5 class="modal-title" id="staticBackdropLive-label">Modal title</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>',
			'</div>',
			'<div class="modal-body">',
			'<p>I will not close if you click outside of me. Don\'t even try to press escape key.</p>',
			'</div>',
			'<div class="modal-footer">',
			'<button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>',
			'<button class="btn btn-primary" type="button">Understood</button>',
			'</div>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = implode('', [

			$aviHtmlElement->element('BsButton', [
				'variant' => 'primary'
			])->attributes([
				'data' => [
					'bs-toggle' => 'modal',
					'bs-target' => '#staticBackdrop'
				]
			])->content('Launch static backdrop modal'),

			$aviHtmlElement->element('BsModal', [
				'backdrop' => 'static',
				'id' => 'staticBackdropLive',
				'title' => 'Modal title',
				'body' => $aviHtmlElement->tag('p')->content('I will not close if you click outside of me. Don\'t even try to press escape key.'),
				'footer' => implode('', [
					$aviHtmlElement->element('BsButton', [
						'variant' => 'secondary'
					])->attributes([
						'data' => [
							'bs-dismiss' => 'modal'
						]
					])->content('Close'),
					$aviHtmlElement->element('BsButton', [
						'variant' => 'primary'
					])->content('Understood')
				])
			])->use()

		]);
		$this->assertEquals($test, $result);


		//Scrolling long content
		/** @see testFn_Full **/

		//Vertically centered
		/** @see testFn_Full **/

		//Tooltips and popovers
		//not relevant it is just body content

		//Using the grid
		//not relevant it is just body content

		//Varying modal content
		//not relevant it is js

		//Toggle between modals
		$test = implode('', [
			'<div aria-hidden="true" aria-labelledby="exampleModalToggle-label" class="fade modal" id="exampleModalToggle" tabindex="-1">',
			'<div class="modal-dialog modal-dialog-centered">',
			'<div class="modal-content">',
			'<div class="modal-header">',
			'<h5 class="modal-title" id="exampleModalToggle-label">Modal 1</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>',
			'</div>',
			'<div class="modal-body">',
			'Show a second modal and hide this one with the button below.',
			'</div>',
			'<div class="modal-footer">',
			'<button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" type="button">Open second modal</button>',
			'</div>',
			'</div>',
			'</div>',
			'</div>',

			'<div aria-hidden="true" aria-labelledby="exampleModalToggle2-label" class="fade modal" id="exampleModalToggle2" tabindex="-1">',
			'<div class="modal-dialog modal-dialog-centered">',
			'<div class="modal-content">',
			'<div class="modal-header">',
			'<h5 class="modal-title" id="exampleModalToggle2-label">Modal 2</h5>',
			'<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>',
			'</div>',
			'<div class="modal-body">',
			'Hide this modal and show the first with the button below.',
			'</div>',
			'<div class="modal-footer">',
			'<button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" type="button">Back to first</button>',
			'</div>',
			'</div>',
			'</div>',
			'</div>',

			'<button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" type="button">Open first modal</button>'
		]);

		$result = implode('', [
			$aviHtmlElement->element('BsModal', [
				'body' => 'Show a second modal and hide this one with the button below.',
				'centered' => true,
				'footer' => $aviHtmlElement->element('BsButton', [
					'attr' => [
						'data' => [
							'bs-target' => '#exampleModalToggle2',
							'bs-toggle' => 'modal'
						]
					],
					'variant' => 'primary'
				])->content('Open second modal'),
				'id' => 'exampleModalToggle',
				'title' => 'Modal 1'
			])->use(),

			$aviHtmlElement->element('BsModal', [
				'body' => 'Hide this modal and show the first with the button below.',
				'centered' => true,
				'footer' => $aviHtmlElement->element('BsButton', [
					'attr' => [
						'data' => [
							'bs-target' => '#exampleModalToggle',
							'bs-toggle' => 'modal'
						]
					],
					'variant' => 'primary'
				])->content('Back to first'),
				'id' => 'exampleModalToggle2',
				'title' => 'Modal 2'

			])->use(),

			$aviHtmlElement->element('BsButton', [
				'variant' => 'primary'
			])->attributes([
				'data' => [
					'bs-target' => '#exampleModalToggle',
					'bs-toggle' => 'modal'
				]
			])->content('Open first modal'),
		]);
		$this->assertEquals($test, $result);


		//Remove animation
		/** @see testFn_Empty */


		//Optional sizes
		/** @see testFn_Full */

		//Fullscreen Modal
		/** @see testFn_Full */

	}

}
