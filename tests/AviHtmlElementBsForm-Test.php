<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsForm extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = '<form></form>';
		$result = $aviHtmlElement->element('BsForm')->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();
		$test = implode('', [
			'<form>',
			'<div class="row">',
			'<div class="offset-sm-3 col-sm-9">',
			'<button class="btn btn-primary" type="button">Click me!</button>',
			'</div>',
			'</div>',
			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'row',
			'items' => [
				[
					'Button' => [
						'breakpoint' => 'sm-9',
						'layout' => 'row',
						'text' => 'Click me!',
						'variant' => 'primary'
					]
				]
				/*,
				[
					'Fieldset' => []
				],
				[
					'Input' => []
				],
				[
					'InputCheckbox' => []
				],
				[
					'InputGroup' => []
				],
				[
					'InputRadio' => []
				],
				[
					'InputTextarea' => []
				],
				[
					'Select' => []
				],*/
			],
		])->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Overview(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Overview
		$test = implode('', [
			'<form>',
			'<div class="mb-3">',
			'<label class="form-label" for="exampleInputEmail1">Email address</label>',
			'<input aria-describedby="help-exampleInputEmail1" class="form-control" id="exampleInputEmail1" type="email">',
			'<div class="form-text" id="help-exampleInputEmail1">We\'ll never share your email with anyone else.</div>',
			'</div>',
			'<div class="mb-3">',
			'<label class="form-label" for="exampleInputPassword1">Password</label>',
			'<input class="form-control" id="exampleInputPassword1" type="password">',
			'</div>',
			'<div class="form-check mb-3">',
			'<input class="form-check-input" id="exampleCheck1" type="checkbox">',
			'<label class="form-check-label" for="exampleCheck1">Check me out</label>',
			'</div>',
			'<div class="mb-3">',
			'<input class="form-control" id="disabledInput" placeholder="Disabled input here..." type="text" disabled>',
			'</div>',
			'<button class="btn btn-primary" type="submit">Submit</button>',
			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'items' => [
				[
					'Input' => [
						'autocomplete' => false,
						'help' => 'We\'ll never share your email with anyone else.',
						'id' => 'exampleInputEmail1',
						'label' => 'Email address',
						'type' => 'email'
					]
				],
				[
					'BsInput' => [
						'autocomplete' => false,
						'id' => 'exampleInputPassword1',
						'label' => 'Password',
						'type' => 'password'
					]
				],
				[
					'InputCheckbox' => [
						'autocomplete' => false,
						'id' => 'exampleCheck1',
						'label' => 'Check me out'
						//'layout' => 'margin'
					]
				],
				[
					'Input' => [
						'autocomplete' => false,
						'disabled' => true,
						'id' => 'disabledInput',
						'placeholder' => 'Disabled input here...',
						'type' => 'text'
					]
				],
				$aviHtmlElement->element('BsButton', [
					'type' => 'submit',
					'variant' => 'primary'
				])
				->content('Submit', true)
			],
			'layout' => 'margin'
		])
		->use();
		$this->assertEquals($test, $result);


		//Disabled forms
		//Disabled fieldset example
		$test = implode('', [
			'<form>',
			'<fieldset disabled>',
			'<legend>Disabled fieldset example</legend>',
			'<div class="mb-3">',
			'<label class="form-label" for="disabledTextInput">Disabled input</label>',
			'<input class="form-control" id="disabledTextInput" placeholder="Disabled input" type="text">',
			'</div>',
			'<div class="mb-3">',
			'<label class="form-label" for="disabledSelect">Disabled select menu</label>',
			'<select class="form-select" id="disabledSelect">',
			'<option>Disabled select</option>',
			'</select>',
			'</div>',
			'<div class="form-check mb-3">',
			'<input class="form-check-input" id="disabledFieldsetCheck" type="checkbox" disabled>',
			'<label class="form-check-label" for="disabledFieldsetCheck">',
			'Can\'t check this',
			'</label>',
			'</div>',
			'<button class="btn btn-primary" type="submit">Submit</button>',
			'</fieldset>',
			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'items' => [
				[
					'BsFieldset' => [
						'disabled' => true,
						'legend' => 'Disabled fieldset example',
						'items' => [
							[
								'Input' => [
									'autocomplete' => false,
									'id' => 'disabledTextInput',
									'label' => 'Disabled input',
									'layout' => 'margin',
									'placeholder' => 'Disabled input'
								]
							],
							[
								'Select' => [
									'autocomplete' => false,
									'id' => 'disabledSelect',
									'label' => 'Disabled select menu',
									'layout' => 'margin',
									'items' => [
										[
											'text' => 'Disabled select'
										]
									]
								]
							],
							[
								'InputCheckbox' => [
									'autocomplete' => false,
									'disabled' => true,
									'id' => 'disabledFieldsetCheck',
									'label' => 'Can\'t check this',
									'layout' => 'margin',
								]
							],
							[
								'BsButton' => [
									'text' => 'Submit',
									'type' => 'submit',
									'variant' => 'primary'
								]
							]
						]
					]
				]
			],
			'layout' => false
		])
		->use();
		$this->assertEquals($test, $result);

	}


	public function testFn_FormControl(): void
	{

		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<div class="mb-3">',
			'<label class="form-label" for="exampleFormControlInput1">Email address</label>',
			'<input class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" type="email">',
			'</div>',
			'<div class="mb-3">',
			'<label class="form-label" for="exampleFormControlTextarea1">Example textarea</label>',
			'<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'exampleFormControlInput1',
				'label' => 'Email address',
				'layout' => 'margin',
				'placeholder' => 'name@example.com',
				'type' => 'email'
			])->use(),
			$aviHtmlElement->element('BsInputTextarea', [
				'autocomplete' => false,
				'id' => 'exampleFormControlTextarea1',
				'label' => 'Example textarea',
				'layout' => 'margin',
				'rows' => '3'
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Sizing
		$test = implode('', [
			'<input aria-label=".form-control-lg example" class="form-control form-control-lg" placeholder=".form-control-lg" type="text">',
			'<input aria-label="default input example" class="form-control" placeholder="Default input" type="text">',
			'<input aria-label=".form-control-sm example" class="form-control form-control-sm" placeholder=".form-control-sm" type="text">'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'aria-label' => '.form-control-lg example',
				'placeholder' => '.form-control-lg',
				'size' => 'lg'
			])
			->use(),
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'aria-label' => 'default input example',
				'placeholder' => 'Default input'
			])
			->use(),
			$aviHtmlElement->element('BsInput', [
				'aria-label' => '.form-control-sm example',
				'autocomplete' => false,
				'placeholder'=>'.form-control-sm',
				'size' => 'sm'
			])
			->use()
		]);
		$this->assertEquals($test, $result);


		//Form text
		$test = implode('', [
			'<label class="form-label" for="inputPassword5">Password</label>',
			'<input aria-describedby="help-inputPassword5" class="form-control" id="inputPassword5" type="password">',
			'<div class="form-text" id="help-inputPassword5">',
			'Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsInput', [
			'autocomplete' => false,
			'help' => 'Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.',
			'id' => 'inputPassword5',
			'label' => 'Password',
			'type' => 'password'
		])->use();
		$this->assertEquals($test, $result);

		//Form text inline
		$test = implode('', [
			'<div class="align-items-center g-3 row">',
			'<div class="col-auto">',
			'<label class="col-form-label" for="inputPassword6">Password</label>',
			'</div>',
			'<div class="col-auto">',
			'<input aria-describedby="passwordHelpInline" class="form-control" id="inputPassword6" type="password">',
			'</div>',
			'<div class="col-auto">',
			'<span class="form-text" id="passwordHelpInline">',
			'Must be 8-20 characters long.',
			'</span>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsInput', [
			'autocomplete' => false,
			'breakpoint' => 'auto',
			'label' => 'Password',
			'help' => 'Must be 8-20 characters long.',
			'help-id' => 'passwordHelpInline',
			'id' => 'inputPassword6',
			'layout' => 'inline',
			'type' => 'password'
		])
		->attributes([
			'class' => [
				'g-3',
				'align-items-center'
			]
		])
		->use();
		$this->assertEquals($test, $result);


		//Disabled
		$test = implode('', [
			'<input aria-label="Disabled input example" class="form-control" placeholder="Disabled input" type="text" disabled>',
			'<input aria-label="Disabled input example" class="form-control" type="text" value="Disabled readonly input" disabled readonly>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'aria-label' => 'Disabled input example',
				'disabled' => true,
				'placeholder' => 'Disabled input',
			])->use(),
			$aviHtmlElement->element('BsInput', [
				'aria-label' => 'Disabled input example',
				'autocomplete' => false,
				'disabled' => true,
				'readonly' => true,
				'value' => 'Disabled readonly input'
			])->use(),
		]);
		$this->assertEquals($test, $result);


		//Readonly
		$test  = '<input aria-label="readonly input example" class="form-control" type="text" value="Readonly input here..." readonly>';
		$result = $aviHtmlElement->element('BsInput', [
			'autocomplete' => false,
			'aria-label' => 'readonly input example',
			'readonly' => true,
			'value' => 'Readonly input here...'
		])
		->use();
		$this->assertEquals($test, $result);


		//Readonly plain text
		$test = implode('', [
			'<div class="mb-3 row">',
			'<label class="col-form-label col-sm-2" for="staticEmail">Email</label>',
			'<div class="col-sm-10">',
			'<input class="form-control-plaintext" id="staticEmail" type="text" value="email@example.com" readonly>',
			'</div>',
			'</div>',
			'<div class="mb-3 row">',
			'<label class="col-form-label col-sm-2" for="inputPassword">Password</label>',
			'<div class="col-sm-10">',
			'<input class="form-control" id="inputPassword" type="password">',
			'</div>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'breakpoint' => 'sm-10',
				'id' => 'staticEmail',
				'label' => 'Email',
				'layout' => 'row',
				'plaintext' => true,
				'readonly' => true,
				'value' => 'email@example.com'
			])
			->use(),
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'breakpoint' => 'sm-10',
				'id' => 'inputPassword',
				'label' => 'Password',
				'layout' => 'row',
				'type' => 'password'
			])
			->use()
		]);
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<form class="g-3 row">',
			'<div class="col-auto">',
			'<label class="visually-hidden" for="staticEmail2">Email</label>',
			'<input class="form-control-plaintext" id="staticEmail2" type="text" value="email@example.com" readonly>',
			'</div>',
			'<div class="col-auto">',
			'<label class="visually-hidden" for="inputPassword2">Password</label>',
			'<input class="form-control" id="inputPassword2" placeholder="Password" type="password">',
			'</div>',
			'<div class="col-auto">',
			'<button class="btn btn-primary mb-3" type="submit">Confirm identity</button>',
			'</div>',
			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'row-inline'
		])
		->attributes([
			'class' => [
				'g-3'
			]
		])
		->content([
			[
				'input' => [
					'autocomplete' => false,
					'id' => 'staticEmail2',
					'label' => 'Email',
					'label-hidden' => true,
					'plaintext' => true,
					'readonly' => true,
					'value' => 'email@example.com'
				],
			],
			[
				'input' => [
					'autocomplete' => false,
					'id' => 'inputPassword2',
					'label' => 'Password',
					'label-hidden' => true,
					'placeholder' => 'Password',
					'type' => 'password'
				],
			],
			[
				$aviHtmlElement->tag('div')
				->attributes([
					'class' => [
						'col-auto'
					]
				])
				->content(
					$aviHtmlElement->element('BsButton', [
						'text' => 'Confirm identity',
						'type' => 'submit',
						'variant' => 'primary'
					])
					->attributes([
						'class' => [
							'mb-3'
						]
					])
					->use(),
					true
				)
			]
		]);
		$this->assertEquals($test, $result);


		//File input
		$test = implode('', [

			'<div class="mb-3">',
			'<label class="form-label" for="formFile">Default file input example</label>',
			'<input class="form-control" id="formFile" type="file">',
			'</div>',

			'<div class="mb-3">',
			'<label class="form-label" for="formFileMultiple">Multiple files input example</label>',
			'<input class="form-control" id="formFileMultiple" type="file" multiple>',
			'</div>',

			'<div class="mb-3">',
			'<label class="form-label" for="formFileDisabled">Disabled file input example</label>',
			'<input class="form-control" id="formFileDisabled" type="file" disabled>',
			'</div>',

			'<div class="mb-3">',
			'<label class="form-label" for="formFileSm">Small file input example</label>',
			'<input class="form-control form-control-sm" id="formFileSm" type="file">',
			'</div>',

			'<div>',
			'<label class="form-label" for="formFileLg">Large file input example</label>',
			'<input class="form-control form-control-lg" id="formFileLg" type="file">',
			'</div>'

		]);
		$result = implode('', [

			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'formFile',
				'label' => 'Default file input example',
				'layout' => 'margin',
				'type' => 'file'
			])
			->use(),

			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'formFileMultiple',
				'label' => 'Multiple files input example',
				'layout' => 'margin',
				'multiple' => true,
				'type' => 'file'
			])
			->use(),

			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'formFileDisabled',
				'label' => 'Disabled file input example',
				'layout' => 'margin',
				'disabled' => true,
				'type' => 'file'
			])
			->use(),

			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'formFileSm',
				'label' => 'Small file input example',
				'layout' => 'margin',
				'size' => 'sm',
				'type' => 'file'
			])
			->use(),

			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'formFileLg',
				'label' => 'Large file input example',
				'layout' => 'block',
				'size' => 'lg',
				'type' => 'file'
			])
			->use(),
		]);
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<label class="form-label" for="exampleColorInput">Color picker</label>',
			'<input class="form-control form-control-color" id="exampleColorInput" title="Choose your color" type="color" value="#563d7c">'
		]);
		$result = $aviHtmlElement->element('BsInput', [
			'autocomplete' => false,
			'id' => 'exampleColorInput',
			'label' => 'Color picker',
			'title' => 'Choose your color',
			'type' => 'color',
			'value' => '#563d7c'
		])->use();
		$this->assertEquals($test, $result);


		//Datalist
		$test = implode('', [
			'<label class="form-label" for="exampleDataList">Datalist example</label>',
			'<input class="form-control" id="exampleDataList" list="datalistOptions" placeholder="Type to search..." type="text">',
			'<datalist id="datalistOptions">',
			'<option value="San Francisco">',
			'<option value="New York">',
			'<option value="Seattle">',
			'<option value="Los Angeles">',
			'<option value="Chicago">',
			'</datalist>'
		]);
		$result = $aviHtmlElement->element('BsInputDatalist', [
			'datalist' => [
				'id' => 'datalistOptions',
				'items' => [
					'San Francisco',
					'New York',
					'Seattle',
					'Los Angeles',
					'Chicago'
				]
			],
			'autocomplete' => false,
			'id' => 'exampleDataList',
			'label' => 'Datalist example',
			'placeholder' => 'Type to search...'
		])
		->use();
		$this->assertEquals($test, $result);
		$result = $aviHtmlElement->element('BsInputDatalist', [
			'autocomplete' => false,
			'id' => 'exampleDataList',
			'label' => 'Datalist example',
			'placeholder' => 'Type to search...'
		])
		->datalist([
			'id' => 'datalistOptions',
			'items' => [
				'San Francisco',
				'New York',
				'Seattle',
				'Los Angeles',
				'Chicago'
			]
		])
		->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Select(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$options = $test = implode('', [
			'<option selected>Open this select menu</option>',
			'<option value="1">One</option>',
			'<option value="2">Two</option>',
			'<option value="3">Three</option>'
		]);
		$test = implode('', [
			'<select aria-label="Default select example" class="form-select">',
			$options,
			'</select>'
		]);
		$items = [
			[
				'selected' => true,
				'text' => 'Open this select menu',
			],
			[
				'text' => 'One',
				'value' => '1'
			],
			[
				'text' => 'Two',
				'value' => '2'
			],
			[
				'text' => 'Three',
				'value' => '3'
			]
		];
		$result = $aviHtmlElement->element('BsSelect', [
			'autocomplete' => false,
			'aria-label' => 'Default select example',
			'items' => $items
		])
		->use();
		$this->assertEquals($test, $result);


		//Sizing
		$test = implode('', [
			'<select aria-label="Large select example" class="form-select form-select-lg mb-3">',
			$options,
			'</select>',

			'<select aria-label="Small select example" class="form-select form-select-sm">',
			$options,
			'</select>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsSelect', [
				'aria-label' => 'Large select example',
				'items' => $items,
				'size' => 'lg'
			])
			->select([
				'class' => [
					'mb-3'
				]
			])
			->use(),
			$aviHtmlElement->element('BsSelect', [
				'aria-label' => 'Small select example',
				'items' => $items,
				'size' => 'sm'
			])
			->use()
		]);
		$this->assertEquals($test, $result);


		//Disabled
		$test = implode('', [
			'<select aria-label="Disabled select example" class="form-select" disabled>',
			$options,
			'</select>'
		]);
		$result = $aviHtmlElement->element('BsSelect', [
			'aria-label' => 'Disabled select example',
			'disabled' => true,
			'items' => $items
		])->use();
		$this->assertEquals($test, $result);
	}


	//Input check and radio has its own test

	public function testFn_Range(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<label class="form-label" for="customRange1">Example range</label>',
			'<input class="form-range" id="customRange1" type="range">'
		]);
		$result = $aviHtmlElement->element('BsInput', [
			'id' => 'customRange1',
			'label' => 'Example range',
			'type' => 'range'
		])
		->use();
		$this->assertEquals($test, $result);


		//disabled
		$test = implode('', [
			'<label class="form-label" for="disabledRange">Disabled range</label>',
			'<input class="form-range" id="disabledRange" type="range" disabled>'
		]);
		$result = $aviHtmlElement->element('BsInput', [
			'disabled' => true,
			'id' => 'disabledRange',
			'label' => 'Disabled range',
			'type' => 'range'
		])
		->use();
		$this->assertEquals($test, $result);


		//Min and max
		$test = implode('', [
			'<label class="form-label" for="customRange2">Example range</label>',
			'<input class="form-range" id="customRange2" max="5" min="0" type="range">'
		]);
		$result = $aviHtmlElement->element('BsInput', [
			'id' => 'customRange2',
			'label' => 'Example range',
			'min' => '0',
			'max' => '5',
			'type' => 'range'
		])
		->use();
		$this->assertEquals($test, $result);

		//Steos
		$test = implode('', [
			'<label class="form-label" for="customRange3">Example range</label>',
			'<input class="form-range" id="customRange3" max="5" min="0" step="0.5" type="range">'
		]);
		$result = $aviHtmlElement->element('BsInput', [
			'id' => 'customRange3',
			'label' => 'Example range',
			'min' => '0',
			'max' => '5',
			'step' => '0.5',
			'type' => 'range'
		])
		->use();
		$this->assertEquals($test, $result);

	}


	public function testFn_InputGroup(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();


		$test = implode('', [

			'<div class="input-group mb-3">',
			'<span class="input-group-text" id="text-addon1">@</span>',
			'<input aria-describedby="text-addon1" aria-label="Username" class="form-control" id="addon1" placeholder="Username" type="text">',
			'</div>',

			'<div class="input-group mb-3">',
			'<input aria-describedby="text-addon2" aria-label="Recipient\'s username" class="form-control" placeholder="Recipient\'s username" type="text">',
			'<span class="input-group-text" id="text-addon2">@example.com</span>',
			'</div>',

			'<div class="mb-3">',
			'<label class="form-label" for="basic-url">Your vanity URL</label>',
			'<div class="input-group">',
			'<span class="input-group-text" id="basic-addon3">https://example.com/users/</span>',
			'<input aria-describedby="basic-addon3 help-basic-url" class="form-control" id="basic-url" type="text">',
			'</div>',
			'<div class="form-text" id="help-basic-url">Example help text goes outside the input group.</div>',
			'</div>',

			'<div class="input-group mb-3">',
			'<span class="input-group-text">$</span>',
			'<input aria-label="Amount (to the nearest dollar)" class="form-control" type="text">',
			'<span class="input-group-text">.00</span>',
			'</div>',

			'<div class="input-group mb-3">',
			'<input aria-label="Username" class="form-control" placeholder="Username" type="text">',
			'<span class="input-group-text">@</span>',
			'<input aria-label="Server" class="form-control" placeholder="Server" type="text">',
			'</div>',

			'<div class="input-group">',
			'<span class="input-group-text">With textarea</span>',
			'<textarea aria-label="With textarea" class="form-control"></textarea>',
			'</div>'
		]);
		$result = implode('', [

			//text before input, items in properties
			$aviHtmlElement->element('BsInputGroup', [
				'items' => [
					[
						'inputGroupText' => [
							'id' => 'text-addon1',
							'text' => '@'
						]
					],
					[
						'input' => [
							'aria-label' => 'Username',
							'autocomplete' => false,
							'describedby' => 'text-addon1',
							'id' => 'addon1',
							'placeholder' => 'Username'
						]
					]
				],
				'layout' => 'margin'
			])
			->use(),

			//text after input, items in content:
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin'
			])
			->content([
				[
					'input' => [
						'aria-label' => 'Recipient\'s username',
						'autocomplete' => false,
						'describedby' => 'text-addon2',
						'placeholder' => 'Recipient\'s username'
					]
				],
				[
					'inputGroupText' => [
						'id' => 'text-addon2',
						'text' => '@example.com'
					]
				]
			]),

			//text before input, contain label and help
			$aviHtmlElement->element('BsInputGroup', [
				'items' => [
					[
						'inputGroupText' => [
							'id' => 'basic-addon3',
							'text' => 'https://example.com/users/'
						]
					],
					[
						'input' => [
							'describedby' => 'basic-addon3',
							'autocomplete' => false,
							'id' => 'basic-url',
							'help' => 'Example help text goes outside the input group.',
							'label' => 'Your vanity URL',
						]
					]
				],
				'layout' => 'margin'
			])->use(),

			//text before and after the input
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin'
			])->content([
				[
					'inputGroupText' => [
						'text' => '$'
					]
				],
				[
					'input' => [
						'aria-label'=>'Amount (to the nearest dollar)',
						'autocomplete' => false
					]
				],
				[
					'inputGroupText' => [
						'text' => '.00'
					]
				]
			]),

			//input - text - input
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin'
			])->content([
				[
					'input' => [
						'aria-label' => 'Username',
						'autocomplete' => false,
						'placeholder' => 'Username'
					]
				],
				[
					'inputGroupText' => [
						'text' => '@'
					]
				],
				[
					'input' => [
						'aria-label'=>'Server',
						'autocomplete' => false,
						'placeholder' => 'Server'
					]
				]
			]),

			//text - textarea
			$aviHtmlElement->element('BsInputGroup')->content([
				[
					'inputGroupText' => [
						'text' => 'With textarea'
					]
				],
				[
					'inputTextarea' => [
						'autocomplete' => false,
						'aria-label'=>'With textarea',
					]
				]
			])
		]);

		$this->assertEquals($test, $result);


		//Wrapping
		$test = implode('', [
			'<div class="flex-nowrap input-group">',
			'<span class="input-group-text" id="addon-wrapping">@</span>',
			'<input aria-describedby="addon-wrapping" aria-label="Username" class="form-control" placeholder="Username" type="text">',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsInputGroup', [
			'nowrap' => true
		])
		->content([
			[
				'inputGroupText' => [
					'id' => 'addon-wrapping',
					'text' => '@'
				]
			],
			[
				'input' => [
					'aria-label' => 'Username',
					'autocomplete' => false,
					'describedby' => 'addon-wrapping',
					'placeholder' => 'Username'
				]
			]
		]);
		$this->assertEquals($test, $result);


		//Sizing
		$test = implode('', [
			'<div class="input-group input-group-sm mb-3">',
			'<span class="input-group-text" id="inputGroup-sizing-sm">Small</span>',
			'<input aria-describedby="inputGroup-sizing-sm" aria-label="Sizing example input" class="form-control" type="text">',
			'</div>',

			'<div class="input-group mb-3">',
			'<span class="input-group-text" id="inputGroup-sizing-default">Default</span>',
			'<input aria-describedby="inputGroup-sizing-default" aria-label="Sizing example input" class="form-control" type="text">',
			'</div>',

			'<div class="input-group input-group-lg">',
			'<span class="input-group-text" id="inputGroup-sizing-lg">Large</span>',
			'<input aria-describedby="inputGroup-sizing-lg" aria-label="Sizing example input" class="form-control" type="text">',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'size' => 'sm'
			])
			->content([
				[
					'inputGroupText' => [
						'id' => 'inputGroup-sizing-sm',
						'text' => 'Small'
					]
				],
				[
					'input' => [
						'aria-label' => 'Sizing example input',
						'autocomplete' => false,
						'describedby' => 'inputGroup-sizing-sm'
					]
				]
			]),
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin'
			])
			->content([
				[
					'inputGroupText' => [
						'id' => 'inputGroup-sizing-default',
						'text' => 'Default'
					]
				],
				[
					'input' => [
						'aria-label' => 'Sizing example input',
						'autocomplete' => false,
						'describedby' => 'inputGroup-sizing-default'
					]
				]
			]),
			$aviHtmlElement->element('BsInputGroup', [
				'size' => 'lg'
			])
			->content([
				[
					'inputGroupText' => [
						'id' => 'inputGroup-sizing-lg',
						'text' => 'Large'
					]
				],
				[
					'input' => [
						'aria-label' => 'Sizing example input',
						'autocomplete' => false,
						'describedby' => 'inputGroup-sizing-lg'
					]
				]
			])
		]);
		$this->assertEquals($test, $result);


		//Checkboxes and radios
		$test = implode('', [
			'<div class="input-group mb-3">',
			'<div class="input-group-text">',
			'<input aria-label="Checkbox for following text input" class="form-check-input mt-0" type="checkbox" value="">',
			'</div>',
			'<input aria-label="Text input with checkbox" class="form-control" type="text">',
			'</div>',

			'<div class="input-group">',
			'<div class="input-group-text">',
			'<input aria-label="Radio button for following text input" class="form-check-input mt-0" type="radio" value="">',
			'</div>',
			'<input aria-label="Text input with radio button" class="form-control" type="text">',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin'
			])
			->content([
				[
					'inputCheckbox' => [
						'autocomplete' => false,
						'aria-label' => 'Checkbox for following text input',
						'value' => ''
					]
				],
				[
					'input' => [
						'autocomplete' => false,
						'aria-label' => 'Text input with checkbox'
					]
				]
			]),
			$aviHtmlElement->element('BsInputGroup')
			->content([
				[
					'inputRadio' => [
						'autocomplete' => false,
						'aria-label' => 'Radio button for following text input',
						'name' => false,
						'value' => ''
					]
				],
				[
					'input' => [
						'autocomplete' => false,
						'aria-label' => 'Text input with radio button'
					]
				]
			])
		]);
		$this->assertEquals($test, $result);


		//Multiple inputs
		$test = implode('', [
			'<div class="input-group">',
			'<span class="input-group-text">First and last name</span>',
			'<input aria-label="First name" class="form-control" type="text">',
			'<input aria-label="Last name" class="form-control" type="text">',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsInputGroup')
		->content([
			[
				'inputGroupText' => [
					'text' => 'First and last name'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'aria-label' => 'First name'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'aria-label' => 'Last name'
				]
			]
		]);
		$this->assertEquals($test, $result);


		//Multiple addons
		$test = implode('', [
			'<div class="input-group mb-3">',
			'<span class="input-group-text">$</span>',
			'<span class="input-group-text">0.00</span>',
			'<input aria-label="Dollar amount (with dot and two decimal places)" class="form-control" type="text">',
			'</div>',

			'<div class="input-group">',
			'<input aria-label="Dollar amount (with dot and two decimal places)" class="form-control" type="text">',
			'<span class="input-group-text">$</span>',
			'<span class="input-group-text">0.00</span>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin'
			])
			->content([
				[
					'inputGroupText' => [
						'text' => '$'
					]
				],
				[
					'inputGroupText' => [
						'text' => '0.00'
					]
				],
				[
					'input' => [
						'autocomplete' => false,
						'aria-label' => 'Dollar amount (with dot and two decimal places)'
					]
				]
			]),
			$aviHtmlElement->element('BsInputGroup')
			->content([
				[
					'input' => [
						'autocomplete' => false,
						'aria-label' => 'Dollar amount (with dot and two decimal places)'
					]
				],
				[
					'inputGroupText' => [
						'text' => '$'
					]
				],
				[
					'inputGroupText' => [
						'text' => '0.00'
					]
				]
			])
		]);
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<div class="input-group mb-3">',
			'<button class="btn btn-outline-secondary" id="button-addon1" type="button">Button</button>',
			'<input aria-describedby="button-addon1" aria-label="Example text with button addon" class="form-control" placeholder="" type="text">',
			'</div>',

			'<div class="input-group mb-3">',
			'<input aria-describedby="button-addon2" aria-label="Recipient\'s username" class="form-control" placeholder="Recipient\'s username" type="text">',
			'<button class="btn btn-outline-secondary" id="button-addon2" type="button">Button</button>',
			'</div>',

			'<div class="input-group mb-3">',
			'<button class="btn btn-outline-secondary" type="button">Button</button>',
			'<button class="btn btn-outline-secondary" type="button">Button</button>',
			'<input aria-label="Example text with two button addons" class="form-control" placeholder="" type="text">',
			'</div>',

			'<div class="input-group">',
			'<input aria-label="Recipient\'s username with two button addons" class="form-control" placeholder="Recipient\'s username" type="text">',
			'<button class="btn btn-outline-secondary" type="button">Button</button>',
			'<button class="btn btn-outline-secondary" type="button">Button</button>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' =>[
					[
						'button' => [
							'id' => 'button-addon1',
							'outline' => true,
							'text' => 'Button',
							'variant' => 'secondary'
						]
					],
					[
						'input' => [
							'autocomplete' => false,
							'aria-label' => 'Example text with button addon',
							'describedby' => 'button-addon1',
							'placeholder' => ''
						]
					]
				]
			])->use(),
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' =>[
					[
						'input' => [
							'autocomplete' => false,
							'aria-label' => 'Recipient\'s username',
							'describedby' => 'button-addon2',
							'placeholder' => 'Recipient\'s username'
						]
					],
					[
						'button' => [
							'id' => 'button-addon2',
							'outline' => true,
							'text' => 'Button',
							'variant' => 'secondary'
						]
					]
				]
			])->use(),
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' =>[
					[
						'button' => [
							'outline' => true,
							'text' => 'Button',
							'variant' => 'secondary'
						],
					],
					[
						'button' => [
							'outline' => true,
							'text' => 'Button',
							'variant' => 'secondary'
						]
					],
					[
						'input' => [
							'autocomplete' => false,
							'aria-label' => 'Example text with two button addons',
							'placeholder' => ''
						]
					]
				]
			])->use(),
			$aviHtmlElement->element('BsInputGroup')
			->content([
				[
					'input' => [
						'autocomplete' => false,
						'aria-label' => 'Recipient\'s username with two button addons',
						'placeholder' => 'Recipient\'s username'
					]
				],
				[
					'button' => [
						'outline' => true,
						'text' => 'Button',
						'variant' => 'secondary'
					]
				],
				[
					'button' => [
						'outline' => true,
						'text' => 'Button',
						'variant' => 'secondary'
					]
				]
			])
		]);
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<div class="input-group mb-3">',
			'<button aria-expanded="false" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">Dropdown</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'<input aria-label="Text input with dropdown button" class="form-control" type="text">',
			'</div>',

			'<div class="input-group mb-3">',
			'<input aria-label="Text input with dropdown button" class="form-control" type="text">',
			'<button aria-expanded="false" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" type="button">Dropdown</button>',
			'<ul class="dropdown-menu dropdown-menu-end">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>',

			'<div class="input-group">',
			'<button aria-expanded="false" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">Dropdown</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action before</a></li>',
			'<li><a class="dropdown-item" href="#">Another action before</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'<input aria-label="Text input with 2 dropdown buttons" class="form-control" type="text">',
			'<button aria-expanded="false" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" type="button">Dropdown</button>',
			'<ul class="dropdown-menu dropdown-menu-end">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$dropdownMenu = [
			'items' => [
				[
					'href' => '#',
					'text' => 'Action',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Another action',
					'type' => 'link'
				],
				[
					'href' => '#',
					'text' => 'Something else here',
					'type' => 'link'
				],
				[
					'type' => 'separator'
				],
				[
					'href' => '#',
					'text' => 'Separated link',
					'type' => 'link'
				]
			]
		];
		$dropdownMenuBefore = $dropdownMenu;
		$dropdownMenuBefore['items'][0]['text'] = 'Action before';
		$dropdownMenuBefore['items'][1]['text'] = 'Another action before';
		$result = implode('', [

			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' => [
					[
						'dropdown' => [
							'button' => [
								'outline' => true,
								'text' => 'Dropdown',
								'variant' => 'secondary'
							],
							'menu' => $dropdownMenu
						]
					],
					[
						'input' => [
							'autocomplete' => false,
							'aria-label' => 'Text input with dropdown button'
						]
					]
				]
			])->use(),

			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' => [
					[
						'input' => [
							'autocomplete' => false,
							'aria-label' => 'Text input with dropdown button'
						]
					],
					[
						'dropdown' => [
							'button' => [
								'outline' => false,
								'text' => 'Dropdown',
								'variant' => 'primary'
							],
							'menu' => array_merge($dropdownMenu, ['align' => 'end'])
						]
					],

				]
			])->use(),

			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'input-group'
			])
			->content([
				[
					'dropdown' => [
						'button' => [
							'text' => 'Dropdown'
						],
						'menu' => $dropdownMenuBefore
					]
				],
				[
					'input' => [
						'autocomplete' => false,
						'aria-label' => 'Text input with 2 dropdown buttons'
					]
				],
				[
					'dropdown' => [
						'button' => [
							'text' => 'Dropdown'
						],
						'menu' => array_merge($dropdownMenu, ['align' => 'end'])
					]
				],
			])
		]);
		$this->assertEquals($test, $result);


		//Segmented buttons
		$test = implode('', [

			'<div class="input-group mb-3">',
			'<button class="btn btn-outline-secondary" type="button">Action</button>',
			'<button aria-expanded="false" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button">',
			'<span class="visually-hidden">Toggle Dropdown</span>',
			'</button>',
			'<ul class="dropdown-menu">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'<input aria-label="Text input with segmented dropdown button" class="form-control" type="text">',
			'</div>',

			'<div class="input-group">',
			'<input aria-label="Text input with segmented dropdown button" class="form-control" type="text">',
			'<button class="btn btn-outline-secondary" type="button">Action</button>',
			'<button aria-expanded="false" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" type="button">',
			'<span class="visually-hidden">Toggle Dropdown</span>',
			'</button>',
			'<ul class="dropdown-menu dropdown-menu-end">',
			'<li><a class="dropdown-item" href="#">Action</a></li>',
			'<li><a class="dropdown-item" href="#">Another action</a></li>',
			'<li><a class="dropdown-item" href="#">Something else here</a></li>',
			'<li><hr class="dropdown-divider"></li>',
			'<li><a class="dropdown-item" href="#">Separated link</a></li>',
			'</ul>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin'
			])
			->content([
				[
					'dropdown' => [
						'button' => [
							'text' => 'Toggle Dropdown'
						],
						'group' => true,
						'menu' => $dropdownMenu,
						'split' => [
							'text' => 'Action',
						]
					]
				],
				[
					'input' => [
						'autocomplete' => false,
						'aria-label' => 'Text input with segmented dropdown button'
					]
				]
			]),
			$aviHtmlElement->element('BsInputGroup')
			->content([
				[
					'input' => [
						'autocomplete' => false,
						'aria-label' => 'Text input with segmented dropdown button'
					]
				],
				[
					'dropdown' => [
						'button' => [
							'text' => 'Toggle Dropdown'
						],
						'group' => true,
						'menu' => array_merge($dropdownMenu, ['align' => 'end']),
						'split' => [
							'text' => 'Action',
						]
					]
				]
			])
		]);
		$this->assertEquals($test, $result);


		//Custom forms
		//Custom select
		$options = implode('', [
			'<option selected>Choose...</option>',
			'<option value="1">One</option>',
			'<option value="2">Two</option>',
			'<option value="3">Three</option>',
		]);
		$test = implode('', [

			'<div class="input-group mb-3">',
			'<label class="input-group-text" for="inputGroupSelect01">Options</label>',
			'<select class="form-select" id="inputGroupSelect01">',
			$options,
			'</select>',
			'</div>',

			'<div class="input-group mb-3">',
			'<select class="form-select" id="inputGroupSelect02">',
			$options,
			'</select>',
			'<label class="input-group-text" for="inputGroupSelect02">Options</label>',
			'</div>',

			'<div class="input-group mb-3">',
			'<button class="btn btn-outline-secondary" type="button">Button</button>',
			'<select aria-label="Example select with button addon" class="form-select" id="inputGroupSelect03">',
			$options,
			'</select>',
			'</div>',

			'<div class="input-group">',
			'<select aria-label="Example select with button addon" class="form-select" id="inputGroupSelect04">',
			$options,
			'</select>',
			'<button class="btn btn-outline-secondary" type="button">Button</button>',
			'</div>',

		]);
		$options = implode('', [
			'<option selected>Choose...</option>',
			'<option value="1">One</option>',
			'<option value="2">Two</option>',
			'<option value="3">Three</option>',
		]);
		$bsOptions = [
			[
				'selected' => true,
				'text' => 'Choose...'
			],
			[
				'text' => 'One',
				'value' => '1'
			],
			[
				'text' => 'Two',
				'value' => '2'
			],
			[
				'text' => 'Three',
				'value' => '3'
			],
		];
		$result = implode('', [

			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' => [
					[
						'select' => [
							'id' => 'inputGroupSelect01',
							'label' => 'Options',
							'items' => $bsOptions
						]
					]
				]
			])->use(),

			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' => [
					[
						'select' => [
							'id' => 'inputGroupSelect02',
							'label' => 'Options',
							'label-position' => 'end',
							'items' => $bsOptions
						]
					]
				]
			])->use(),

			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' => [
					[
						'button' => [
							'outline' => true,
							'text' => 'Button',
							'variant' => 'secondary'
						]
					],
					[
						'select' => [
							'aria-label' => 'Example select with button addon',
							'id' => 'inputGroupSelect03',
							'items' => $bsOptions
						]
					]
				]
			])->use(),

			$aviHtmlElement->element('BsInputGroup')
			->content([
				[
					'select' => [
						'aria-label' => 'Example select with button addon',
						'id' => 'inputGroupSelect04',
						'items' => $bsOptions
					]
				],
				[
					'button' => [
						'text' => 'Button',
					]
				]
			])
		]);
		$this->assertEquals($test, $result);


		//Custom file input
		$test = implode('', [
			'<div class="input-group mb-3">',
			'<label class="input-group-text" for="inputGroupFile01">Upload</label>',
			'<input class="form-control" id="inputGroupFile01" type="file">',
			'</div>',

			'<div class="input-group mb-3">',
			'<input class="form-control" id="inputGroupFile02" type="file">',
			'<label class="input-group-text" for="inputGroupFile02">Upload</label>',
			'</div>',

			'<div class="input-group mb-3">',
			'<button class="btn btn-outline-secondary" id="inputGroupFileAddon03" type="button">Button</button>',
			'<input aria-describedby="inputGroupFileAddon03" aria-label="Upload" class="form-control" id="inputGroupFile03" type="file">',
			'</div>',

			'<div class="input-group">',
			'<input aria-describedby="inputGroupFileAddon04" aria-label="Upload" class="form-control" id="inputGroupFile04" type="file">',
			'<button class="btn btn-outline-secondary" id="inputGroupFileAddon04" type="button">Button</button>',
			'</div>'
		]);
		$result = implode('', [

			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' => [
					[
						'input' => [
							'id' => 'inputGroupFile01',
							'label' => 'Upload',
							'type' => 'file'
						]
					]
				]
			])->use(),

			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' => [
					[
						'input' => [
							'id' => 'inputGroupFile02',
							'label' => 'Upload',
							'label-position' => 'end',
							'type' => 'file'
						]
					]
				]
			])->use(),

			$aviHtmlElement->element('BsInputGroup', [
				'layout' => 'margin',
				'items' => [
					[
						'button' => [
							'id' => 'inputGroupFileAddon03',
							'text' => 'Button'
						]
					],
					[
						'input' => [
							'aria-label' => 'Upload',
							'describedby' => 'inputGroupFileAddon03',
							'id' => 'inputGroupFile03',
							'type' => 'file'
						]
					]
				]
			])->use(),

			$aviHtmlElement->element('BsInputGroup')
			->content([
				[
					'input' => [
						'aria-label' => 'Upload',
						'describedby' => 'inputGroupFileAddon04',
						'id' => 'inputGroupFile04',
						'type' => 'file'
					]
				],
				[
					'button' => [
						'id' => 'inputGroupFileAddon04',
						'text' => 'Button'
					]
				]
			])
		]);
		$this->assertEquals($test, $result);

	}



	public function testFn_FloatingLabels(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Example
		$test = implode('', [
			'<div class="form-floating mb-3">',
			'<input class="form-control" id="floatingInput" placeholder="name@example.com" type="email">',
			'<label for="floatingInput">Email address</label>',
			'</div>',

			'<div class="form-floating">',
			'<input class="form-control" id="floatingPassword" placeholder="Password" type="password">',
			'<label for="floatingPassword">Password</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'floatingInput',
				'label' => 'Email address',
				'layout' => 'floating-label',
				'placeholder' => 'name@example.com',
				'type' => 'email'
			])
			->attributes([
				'class' => [
					'mb-3'
				]
			])
			->use(),
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'floatingPassword',
				'label' => 'Password',
				'layout' => 'floating-label',
				'placeholder' => 'Password',
				'type' => 'password'
			])
			->use(),
		]);
		$this->assertEquals($test, $result);


		//Already defined value:
		$test = implode('', [
			'<form>',
			'<div class="form-floating">',
			'<input class="form-control" id="floatingInputValue" placeholder="name@example.com" type="email" value="test@example.com">',
			'<label for="floatingInputValue">Input with value</label>',
			'</div>',
			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'floating-label'
		])
		->content([
			[
				'input' => [
					'autocomplete' => false,
					'id' => 'floatingInputValue',
					'label' => 'Input with value',
					'placeholder' => 'name@example.com',
					'type' => 'email',
					'value' => 'test@example.com'
				]
			]
		]);
		$this->assertEquals($test, $result);

		//including validation
		$test = implode('', [
			'<form>',
			'<div class="form-floating">',
			'<input class="form-control is-invalid" id="floatingInputInvalid" placeholder="name@example.com" type="email" value="test@example.com">',
			'<label for="floatingInputInvalid">Invalid input</label>',
			'</div>',
			'</form>',
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'floating-label'
		])
		->content([
			[
				'input' => [
					'autocomplete' => false,
					'id' => 'floatingInputInvalid',
					'valid' => false,
					'label' => 'Invalid input',
					'placeholder' => 'name@example.com',
					'type' => 'email',
					'value' => 'test@example.com'
				]
			]
		]);
		$this->assertEquals($test, $result);


		//Textareas
		$test = implode('', [
			'<div class="form-floating">',
			'<textarea class="form-control" id="floatingTextarea" placeholder="Leave a comment here"></textarea>',
			'<label for="floatingTextarea">Comments</label>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsInputTextarea', [
			'autocomplete' => false,
			'id' => 'floatingTextarea',
			'label' => 'Comments',
			'layout' => 'floating-label',
			'placeholder' => 'Leave a comment here',
		])->use();
		$this->assertEquals($test, $result);


		//Selects
		$options = implode('', [
			'<option selected>Open this select menu</option>',
			'<option value="1">One</option>',
			'<option value="2">Two</option>',
			'<option value="3">Three</option>',
		]);
		$items = [
			[
				'selected' => true,
				'text' => 'Open this select menu'
			],
			[
				'text' => 'One',
				'value' => '1'
			],
			[
				'text' => 'Two',
				'value' => '2'
			],
			[
				'text' => 'Three',
				'value' => '3'
			]
		];
		$test = implode('', [
			'<div class="form-floating">',
			'<select aria-label="Floating label select example" class="form-select" id="floatingSelect">',
			$options,
			'</select>',
			'<label for="floatingSelect">Works with selects</label>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsSelect', [
			'aria-label' => 'Floating label select example',
			'id' => 'floatingSelect',
			'items' => $items,
			'label' => 'Works with selects',
			'layout' => 'floating-label',
		])
		->use();
		$this->assertEquals($test, $result);


		//Disabled
		$test = implode('', [
			'<div class="form-floating mb-3">',
			'<input class="form-control" id="floatingInputDisabled" placeholder="name@example.com" type="email" disabled>',
			'<label for="floatingInputDisabled">Email address</label>',
			'</div>',

			'<div class="form-floating mb-3">',
			'<textarea class="form-control" id="floatingTextareaDisabled" placeholder="Leave a comment here" disabled></textarea>',
			'<label for="floatingTextareaDisabled">Comments</label>',
			'</div>',

			'<div class="form-floating mb-3">',
			'<textarea class="form-control" id="floatingTextarea2Disabled" placeholder="Leave a comment here" style="height: 100px" disabled>Disabled textarea with some text inside</textarea>',
			'<label for="floatingTextarea2Disabled">Comments</label>',
			'</div>',

			'<div class="form-floating">',
			'<select aria-label="Floating label disabled select example" class="form-select" id="floatingSelectDisabled" disabled>',
			$options,
			'</select>',
			'<label for="floatingSelectDisabled">Works with selects</label>',
			'</div>'

		]);
		$result = implode('', [

			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'floatingInputDisabled',
				'label' => 'Email address',
				'layout' => 'floating-label',
				'placeholder' => 'name@example.com',
				'type' => 'email'
			])
			->attributes([
				'class' => [
					'mb-3'
				]
			])
			->use(),

			$aviHtmlElement->element('BsInputTextarea', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'floatingTextareaDisabled',
				'label' => 'Comments',
				'layout' => 'floating-label',
				'placeholder' => 'Leave a comment here'
			])
			->attributes([
				'class' => [
					'mb-3'
				]
			])
			->use(),

			$aviHtmlElement->element('BsInputTextarea', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'floatingTextarea2Disabled',
				'input' => [
					'attr' => [
						'style' => 'height: 100px'
					]
				],
				'label' => 'Comments',
				'layout' => 'floating-label',
				'placeholder' => 'Leave a comment here',
				'text' => 'Disabled textarea with some text inside',
			])
			->attributes([
				'class' => [
					'mb-3'
				]
			])->use(),

			$aviHtmlElement->element('BsSelect', [
				'autocomplete' => false,
				'aria-label' => 'Floating label disabled select example',
				'disabled' => true,
				'id' => 'floatingSelectDisabled',
				'label' => 'Works with selects',
				'layout' => 'floating-label',
			])
			->content($items)
		]);
		$this->assertEquals($test, $result);


		//Readonly plaintext
		$test = implode('', [
			'<div class="form-floating mb-3">',
			'<input class="form-control-plaintext" id="floatingEmptyPlaintextInput" placeholder="name@example.com" type="email" readonly>',
			'<label for="floatingEmptyPlaintextInput">Empty input</label>',
			'</div>',

			'<div class="form-floating mb-3">',
			'<input class="form-control-plaintext" id="floatingPlaintextInput" placeholder="name@example.com" type="email" value="name@example.com" readonly>',
			'<label for="floatingPlaintextInput">Input with value</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'attr' => [
					'class' => [
						'mb-3'
					]
				],
				'id' => 'floatingEmptyPlaintextInput',
				'label' => 'Empty input',
				'layout' => 'floating-label',
				'placeholder' => 'name@example.com',
				'plaintext' => true,
				'readonly' => true,
				'type' => 'email'
			])
			->use(),
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'attr' => [
					'class' => [
						'mb-3'
					]
				],
				'id' => 'floatingPlaintextInput',
				'label' => 'Input with value',
				'layout' => 'floating-label',
				'placeholder' => 'name@example.com',
				'plaintext' => true,
				'readonly' => true,
				'type' => 'email',
				'value' => 'name@example.com'
			])
			->use()
		]);
		$this->assertEquals($test, $result);


		//Input groups
		$test = implode('', [
			'<div class="input-group mb-3">',
			'<span class="input-group-text">@</span>',
			'<div class="form-floating">',
			'<input class="form-control" id="floatingInputGroup1" placeholder="Username" type="text">',
			'<label for="floatingInputGroup1">Username</label>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsInputGroup', [
			'items' => [
				[
					'inputGroupText' => [
						'text' => '@'
					]
				],
				[
					'input' => [
						'autocomplete' => false,
						'debug' => true,
						'id' => 'floatingInputGroup1',
						'label' => 'Username',
						'layout' => 'floating-label',
						'placeholder' => 'Username',
					]
				]
			],
			'layout' => 'margin'
		])
		->use();
		$this->assertEquals($test, $result);

		//Input groups + validation
		$test = implode('', [
			'<div class="input-group has-validation">',
			'<span class="input-group-text">@</span>',
			'<div class="form-floating is-invalid">',
			'<input type="text" class="form-control is-invalid" id="floatingInputGroup2" placeholder="Username" required>',
			'<label for="floatingInputGroup2">Username</label>',
			'</div>',
			'<div class="invalid-feedback">',
			'Please choose a username.',
			'</div>',
			'</div>'
		]);
		$result = $result = $aviHtmlElement->element('BsInputGroup', [
			'items' => [
				[
					'inputGroupText' => [
						'text' => '@'
					]
				],
				[
					'input' => [
						'autocomplete' => false,
						'debug' => true,
						'feedback' => 'Please choose a username.',
						'id' => 'floatingInputGroup2',
						'label' => 'Username',
						'layout' => 'floating-label',
						'placeholder' => 'Username',
						'required' => true,
						'valid' => false
					]
				]
			],
			'layout' => 'margin'
		])
		->use();;
		//$this->assertEquals($test, $result);

//TODO
		//Layout
		$test = implode('', [
			'<div class="g-2 row">',

			'<div class="col-md">',
			'<div class="form-floating">',
			'<input class="form-control" id="floatingInputGrid" placeholder="name@example.com" type="email" value="mdo@example.com">',
			'<label for="floatingInputGrid">Email address</label>',
			'</div>',
			'</div>',

			'<div class="col-md">',
			'<div class="form-floating">',
			'<select class="form-select" id="floatingSelectGrid">',
			$options,
			'</select>',
			'<label for="floatingSelectGrid">Works with selects</label>',
			'</div>',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement->tag('div', [
			'class' => [
				'row',
				'g-2'
			]
		])->content([
			$aviHtmlElement->tag('div', [
				'class' => [
					'col-md'
				]
			])->content(
				$aviHtmlElement->element('BsInput', [
					'autocomplete' => false,
					'id' => 'floatingInputGrid',
					'label' => 'Email address',
					'layout' => 'floating-label',
					'placeholder' => 'name@example.com',
					'type' => 'email',
					'value' => 'mdo@example.com',
				])->use()
			),
			$aviHtmlElement->tag('div', [
				'class' => [
					'col-md'
				]
			])->content(
				$aviHtmlElement->element('BsSelect', [
					'id' => 'floatingSelectGrid',
					'items' => $items,
					'label' => 'Works with selects',
					'layout' => 'floating-label',
				])->use()
			)
		]);
		$this->assertEquals($test, $result);

	}



	public function testFn_FormLayout(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Margin Layout
		$test = implode('', [
			'<div class="mb-3">',
			'<label class="form-label" for="formGroupExampleInput">Example label</label>',
			'<input class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" type="text">',
			'</div>',
			'<div class="mb-3">',
			'<label class="form-label" for="formGroupExampleInput2">Another label</label>',
			'<input class="form-control" id="formGroupExampleInput2" placeholder="Another input placeholder" type="text">',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'formGroupExampleInput',
				'label' => 'Example label',
				'layout' => 'margin',
				'placeholder' => 'Example input placeholder'
			])
			->use(),
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'id' => 'formGroupExampleInput2',
				'label' => 'Another label',
				'layout' => 'margin',
				'placeholder' => 'Another input placeholder'
			])
			->use()
		]);
		$this->assertEquals($test, $result);


		//Grid layout = col
		$test = implode('', [
			'<div class="row">',
			'<div class="col">',
			'<input aria-label="First name" class="form-control" placeholder="First name" type="text">',
			'</div>',
			'<div class="col">',
			'<input aria-label="Last name" class="form-control" placeholder="Last name" type="text">',
			'</div>',
			'</div>'
		]);
		$result = $aviHtmlElement
		->tag('div')
		->attributes([
			'class' => 'row'
		])
		->content([
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'aria-label' => 'First name',
				'layout' => 'col',
				'placeholder' => 'First name'
			])->use(),
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'aria-label' => 'Last name',
				'layout' => 'col',
				'placeholder' => 'Last name'
			])->use()
		]);
		$this->assertEquals($test, $result);

		//Gutters
		$test = implode('', [
			'<div class="g-3 row">',
			'<div class="col">',
			'<input aria-label="First name" class="form-control" placeholder="First name" type="text">',
			'</div>',
			'<div class="col">',
			'<input aria-label="Last name" class="form-control" placeholder="Last name" type="text">',
			'</div>',
			'</div>'
		]);

		$result = $aviHtmlElement
		->tag('div')
		->attributes([
			'class' => [
				'g-3',
				'row'
			]
		])
		->content([
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'aria-label' => 'First name',
				'layout' => 'col',
				'placeholder' => 'First name'
			])->use(),
			$aviHtmlElement->element('BsInput', [
				'autocomplete' => false,
				'aria-label' => 'Last name',
				'layout' => 'col',
				'placeholder' => 'Last name'
			])->use()
		]);
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<form class="g-3 row">',

			'<div class="col-md-6">',
			'<label class="form-label" for="inputEmail4">Email</label>',
			'<input class="form-control" id="inputEmail4" type="email">',
			'</div>',

			'<div class="col-md-6">',
			'<label class="form-label" for="inputPassword4">Password</label>',
			'<input class="form-control" id="inputPassword4" type="password">',
			'</div>',

			'<div class="col-12">',
			'<label class="form-label" for="inputAddress">Address</label>',
			'<input class="form-control" id="inputAddress" placeholder="1234 Main St" type="text">',
			'</div>',

			'<div class="col-12">',
			'<label class="form-label" for="inputAddress2">Address 2</label>',
			'<input class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" type="text">',
			'</div>',

			'<div class="col-md-6">',
			'<label class="form-label" for="inputCity">City</label>',
			'<input class="form-control" id="inputCity" type="text">',
			'</div>',
			'<div class="col-md-4">',
			'<label class="form-label" for="inputState">State</label>',
			'<select class="form-select" id="inputState">',
			'<option selected>Choose...</option>',
			'<option>...</option>',
			'</select>',
			'</div>',
			'<div class="col-md-2">',
			'<label class="form-label" for="inputZip">Zip</label>',
			'<input class="form-control" id="inputZip" type="text">',
			'</div>',
			'<div class="col-12">',
			'<div class="form-check">',
			'<input class="form-check-input" id="gridCheck" type="checkbox">',
			'<label class="form-check-label" for="gridCheck">',
			'Check me out',
			'</label>',
			'</div>',
			'</div>',
			'<div class="col-12">',
			'<button class="btn btn-primary" type="submit">Sign in</button>',
			'</div>',
			'</form>'
		]);
		$result = $aviHtmlElement
		->element('BsForm', [
			'layout' => 'col' //the elements will inherit this.
		])
		->attributes([
			'class' => [
				'row',
				'g-3'
			]
		])
		->content([
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-6',
					'id' => 'inputEmail4',
					'label' => 'Email',
					'type' => 'email'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-6',
					'id' => 'inputPassword4',
					'label' => 'Password',
					'type' => 'password'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => '12',
					'id' => 'inputAddress',
					'label' => 'Address',
					'placeholder' => '1234 Main St'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => '12',
					'id' => 'inputAddress2',
					'label' => 'Address 2',
					'placeholder' => 'Apartment, studio, or floor'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-6',
					'id' => 'inputCity',
					'label' => 'City',
				]
			],
			[
				'select' => [
					'autocomplete' => false,
					'breakpoint' => 'md-4',
					'id' => 'inputState',
					'label' => 'State',
					'items' => [
						[
							'selected' => true,
							'text' => 'Choose...'
						],
						[
							'text' => '...'
						]
					]
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-2',
					'id' => 'inputZip',
					'label' => 'Zip',
				]
			],
			[
				$aviHtmlElement
				->tag('div')
				->attributes([
					'class' => 'col-12'
				])
				->content(
					$aviHtmlElement->element('BsInputCheckbox', [
						'autocomplete' => false,
						'id' => 'gridCheck',
						'label' => 'Check me out'
					])->use(), true)
			],
			[
				$aviHtmlElement
				->tag('div')
				->attributes([
					'class' => 'col-12'
				])
				->content(
					$aviHtmlElement->element('BsButton', [
						'variant' => 'primary',
						'text' => 'Sign in',
						'type' => 'submit'
					])->use() , true)
			]
		]);
		$this->assertEquals($test, $result);


		//Horizontal form
		$test = implode('', [
			'<form>',

			'<div class="mb-3 row">',
			'<label class="col-form-label col-sm-2" for="inputEmail3">Email</label>',
			'<div class="col-sm-10">',
			'<input class="form-control" id="inputEmail3" type="email">',
			'</div>',
			'</div>',

			'<div class="mb-3 row">',
			'<label class="col-form-label col-sm-2" for="inputPassword3">Password</label>',
			'<div class="col-sm-10">',
			'<input class="form-control" id="inputPassword3" type="password">',
			'</div>',
			'</div>',

			'<fieldset class="mb-3 row">',
			'<legend class="col-form-label col-sm-2 pt-0">Radios</legend>',

			'<div class="col-sm-10">',

			'<div class="form-check">',
			'<input class="form-check-input" id="gridRadios1" name="gridRadios" type="radio" value="option1" checked>',
			'<label class="form-check-label" for="gridRadios1">',
			'First radio',
			'</label>',
			'</div>',

			'<div class="form-check">',
			'<input class="form-check-input" id="gridRadios2" name="gridRadios" type="radio" value="option2">',
			'<label class="form-check-label" for="gridRadios2">',
			'Second radio',
			'</label>',
			'</div>',

			'<div class="form-check">',
			'<input class="form-check-input" id="gridRadios3" name="gridRadios" type="radio" value="option3" disabled>',
			'<label class="form-check-label" for="gridRadios3">',
			'Third disabled radio',
			'</label>',

			'</div>',
			'</div>',
			'</fieldset>',

			'<div class="mb-3 row">',
			'<div class="col-sm-10 offset-sm-2">',
			'<div class="form-check">',
			'<input class="form-check-input" id="gridCheck1" type="checkbox">',
			'<label class="form-check-label" for="gridCheck1">',
			'Example checkbox',
			'</label>',
			'</div>',
			'</div>',
			'</div>',

			'<button class="btn btn-primary" type="submit">Sign in</button>',

			'</form>'
		]);

		$result = $aviHtmlElement
		->element('BsForm', [
			'layout' => 'row' //the elements will inherit this.
		])
		->content([
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'sm-10',
					'id' => 'inputEmail3',
					'label' => 'Email',
					'type' => 'email'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'sm-10',
					'id' => 'inputPassword3',
					'label' => 'Password',
					'type' => 'password'
				]
			],
			[
				'fieldset' => [
					'breakpoint' => 'sm-10',
					'legend' => [
						'attr' => [
							'class' => [
								'pt-0'
							]
						],
						'text' => 'Radios'
					],
					'items' => [
						[
							$aviHtmlElement
							->tag('div')
							->attributes([
								'class' => [
									'col-sm-10'
								]
							])
							->content([
								$aviHtmlElement->element('BsInputRadio', [
									'autocomplete' => false,
									'checked' => true,
									'id' => 'gridRadios1',
									'label' => 'First radio',
									'name' => 'gridRadios',
									'value' => 'option1'
								])->use(),
								$aviHtmlElement->element('BsInputRadio', [
									'autocomplete' => false,
									'id' => 'gridRadios2',
									'label' => 'Second radio',
									'name' => 'gridRadios',
									'value' => 'option2'
								])->use(),
								$aviHtmlElement->element('BsInputRadio', [
									'autocomplete' => false,
									'disabled' => true,
									'id' => 'gridRadios3',
									'label' => 'Third disabled radio',
									'name' => 'gridRadios',
									'value' => 'option3'
								])->use()
							], true)
						]
					]
				]
			],
			[
				$aviHtmlElement
				->tag('div')
				->attributes([
					'class' => [
						'mb-3',
						'row'
					]
				])
				->content([
					$aviHtmlElement
					->tag('div')
					->attributes([
						'class' => [
							'col-sm-10',
							'offset-sm-2'
						]
					])
					->content(
						$aviHtmlElement->element('BsInputCheckbox', [
							'autocomplete' => false,
							'id' => 'gridCheck1',
							'label' => 'Example checkbox'
						])
						->use()
						)
				], true)
			],
			[
				$aviHtmlElement->element('BsButton', [
					'text' => 'Sign in',
					'type' => 'submit',
					'variant' => 'primary'
				])
			]
		]);
		$this->assertEquals($test, $result);


		//Horizontal form label sizing
		$test = implode('', [
			'<form>',

			'<div class="mb-3 row">',
			'<label class="col-form-label col-form-label-sm col-sm-2" for="colFormLabelSm">Email</label>',
			'<div class="col-sm-10">',
			'<input class="form-control form-control-sm" id="colFormLabelSm" placeholder="col-form-label-sm" type="email">',
			'</div>',
			'</div>',

			'<div class="mb-3 row">',
			'<label class="col-form-label col-sm-2" for="colFormLabel">Email</label>',
			'<div class="col-sm-10">',
			'<input class="form-control" id="colFormLabel" placeholder="col-form-label" type="email">',
			'</div>',
			'</div>',

			'<div class="mb-3 row">',
			'<label class="col-form-label col-form-label-lg col-sm-2" for="colFormLabelLg">Email</label>',
			'<div class="col-sm-10">',
			'<input class="form-control form-control-lg" id="colFormLabelLg" placeholder="col-form-label-lg" type="email">',
			'</div>',
			'</div>',

			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'row'
		])
		->content([
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'sm-10',
					'id' => 'colFormLabelSm',
					'label' => 'Email',
					'placeholder' => 'col-form-label-sm',
					'size' => 'sm',
					'type' => 'email'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'sm-10',
					'id' => 'colFormLabel',
					'label' => 'Email',
					'placeholder' => 'col-form-label',
					'type' => 'email'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'sm-10',
					'id' => 'colFormLabelLg',
					'label' => 'Email',
					'placeholder' => 'col-form-label-lg',
					'size' => 'lg',
					'type' => 'email'
				]
			]
		]);
		$this->assertEquals($test, $result);



		//Column sizing
		$test = implode('', [
			'<form class="g-3 row">',
			'<div class="col-sm-7">',
			'<input aria-label="City" class="form-control" placeholder="City" type="text">',
			'</div>',
			'<div class="col-sm">',
			'<input aria-label="State" class="form-control" placeholder="State" type="text">',
			'</div>',
			'<div class="col-sm">',
			'<input aria-label="Zip" class="form-control" placeholder="Zip" type="text">',
			'</div>',
			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'row-inline'
		])
		->attributes([
			'class' => [
				'g-3',
			]
		])
		->content([
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'sm-7',
					'aria-label' => 'City',
					'placeholder' => 'City'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'sm',
					'aria-label' => 'State',
					'placeholder' => 'State'
				]
			],
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'sm',
					'aria-label' => 'Zip',
					'placeholder' => 'Zip'
				]
			]
		]);
		$this->assertEquals($test, $result);


		//Auto-sizing
		$test = implode('', [
			'<form class="align-items-center gx-3 gy-2 row">',

			'<div class="col-auto">',
			'<label class="visually-hidden" for="autoSizingInput">Name</label>',
			'<input class="form-control" id="autoSizingInput" placeholder="Jane Doe" type="text">',
			'</div>',

			'<div class="col-auto">',
			'<label class="visually-hidden" for="autoSizingInputGroup">Username</label>',
			'<div class="input-group">',
			'<div class="input-group-text">@</div>',
			'<input class="form-control" id="autoSizingInputGroup" placeholder="Username" type="text">',
			'</div>',
			'</div>',

			'<div class="col-auto">',
			'<label class="visually-hidden" for="autoSizingSelect">Preference</label>',
			'<select class="form-select" id="autoSizingSelect">',
			'<option selected>Choose...</option>',
			'<option value="1">One</option>',
			'<option value="2">Two</option>',
			'<option value="3">Three</option>',
			'</select>',
			'</div>',

			'<div class="col-auto">',
			'<div class="form-check">',
			'<input class="form-check-input" id="autoSizingCheck" type="checkbox">',
			'<label class="form-check-label" for="autoSizingCheck">',
			'Remember me',
			'</label>',
			'</div>',
			'</div>',

			'<div class="col-auto">',
			'<button class="btn btn-primary" type="submit">Submit</button>',
			'</div>',

			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'row-inline'
		])
		->attributes([
			'class' => [
				'align-items-center',
				'gx-3',
				'gy-2'
			]
		])
		->content([

			[
				'input' => [
					'autocomplete' => false,
					'id' => 'autoSizingInput',
					'label' => 'Name',
					'label-hidden' => true,
					'placeholder' => 'Jane Doe',
				]
			],

			[
				'inputGroup' => [
					'items' => [
						[
							'inputGroupText' => [
								'tag' => 'div',
								'text' => '@'
							]
						],
						[
							'input' => [
								'autocomplete' => false,
								'id' => 'autoSizingInputGroup',
								'label' => 'Username',
								'label-hidden' => true,
								'placeholder' => 'Username'
							]
						]
					]
				]
			],

			[
				'select' => [
					'autocomplete' => false,
					'id' => 'autoSizingSelect',
					'items' => [
						[
							'selected' => true,
							'text' => 'Choose...'
						],
						[
							'text' => 'One',
							'value' => '1'
						],
						[
							'text' => 'Two',
							'value' => '2'
						],
						[
							'text' => 'Three',
							'value' => '3'
						]
					],
					'label' => 'Preference',
					'label-hidden' => true,
				]
			],

			[
				'inputCheckbox' => [
					'autocomplete' => false,
					'id' => 'autoSizingCheck',
					'label' => 'Remember me'
				]
			],
			/*
			[
				$aviHtmlElement->element('BsInputCheckbox', [
					'id' => 'autoSizingCheck',
					'label' => 'Remember me'
				])
			],
			*/

			[
				'Button' => [
					'text' => 'Submit',
					'type' => 'submit',
					'variant' => 'primary'
				]
			]

		]);
		$this->assertEquals($test, $result);


		//Inline forms
		$test = implode('', [
			'<form class="align-items-center g-3 row row-cols-lg-auto">',

			'<div class="col-12">',
			'<label class="visually-hidden" for="inlineFormInputGroupUsername">Username</label>',
			'<div class="input-group">',
			'<div class="input-group-text">@</div>',
			'<input class="form-control" id="inlineFormInputGroupUsername" placeholder="Username" type="text">',
			'</div>',
			'</div>',

			'<div class="col-12">',
			'<label class="visually-hidden" for="inlineFormSelectPref">Preference</label>',
			'<select class="form-select" id="inlineFormSelectPref">',
			'<option selected>Choose...</option>',
			'<option value="1">One</option>',
			'<option value="2">Two</option>',
			'<option value="3">Three</option>',
			'</select>',
			'</div>',

			'<div class="col-12">',
			'<div class="form-check">',
			'<input class="form-check-input" id="inlineFormCheck" type="checkbox">',
			'<label class="form-check-label" for="inlineFormCheck">',
			'Remember me',
			'</label>',
			'</div>',
			'</div>',

			'<div class="col-12">',
			'<button class="btn btn-primary" type="submit">Submit</button>',
			'</div>',

			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm' , [
//			'debug' => true,
			'layout' => 'row-inline'
		])->attributes([
			'class' => [
				'row-cols-lg-auto',
				'g-3',
				'align-items-center'
			]
		])->content([
			[
				'inputGroup' => [
					'breakpoint' => '12',
					'items' => [
						[
							'inputGroupText' => [
								'tag' => 'div',
								'text' => '@'
							]
						],
						[
							'input' => [
								'autocomplete' => false,
								'id' => 'inlineFormInputGroupUsername',
								'label' => 'Username',
								'label-hidden' => true,
								'placeholder' => 'Username'
							]
						]
					]
				]
			],
			[
				'select' => [
					'autocomplete' => false,
					'breakpoint' => '12',
					'id' => 'inlineFormSelectPref',
					'items' => [
						[
							'selected' => true,
							'text' => 'Choose...'
						],
						[
							'text' => 'One',
							'value' => '1'
						],
						[
							'text' => 'Two',
							'value' => '2'
						],
						[
							'text' => 'Three',
							'value' => '3'
						]
					],
					'label' => 'Preference',
					'label-hidden' => true,
				]
			],
			[
				'inputCheckbox' => [
					'autocomplete' => false,
					'breakpoint' => '12',
					'debug' => true,
					'id' => 'inlineFormCheck',
					'label' => 'Remember me'
				]
			],

			[
				'Button' => [
					'breakpoint' => '12',
					'text' => 'Submit',
					'type' => 'submit',
					'variant' => 'primary'
				]
			]
		]);
		$this->assertEquals($test, $result);
	}


	public function testFn_FormValidation(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();


		//Custom styles
		$test = implode('', [
			'<form class="g-3 needs-validation row" novalidate>',

			'<div class="col-md-4">',
			'<label class="form-label" for="validationCustom01">First name</label>',
			'<input class="form-control" id="validationCustom01" type="text" value="Mark" required>',
			'<div class="valid-feedback">',
			'Looks good!',
			'</div>',
			'</div>',

			'<div class="col-md-4">',
			'<label class="form-label" for="validationCustom02">Last name</label>',
			'<input class="form-control" id="validationCustom02" type="text" value="Otto" required>',
			'<div class="valid-feedback">',
			'Looks good!',
			'</div>',
			'</div>',

			'<div class="col-md-4">',
			'<label class="form-label" for="validationCustomUsername">Username</label>',
			'<div class="has-validation input-group">',
			'<span class="input-group-text" id="inputGroupPrepend">@</span>',
			'<input aria-describedby="inputGroupPrepend" class="form-control" id="validationCustomUsername" type="text" required>',
			'<div class="invalid-feedback">',
			'Please choose a username.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="col-md-6">',
			'<label class="form-label" for="validationCustom03">City</label>',
			'<input class="form-control" id="validationCustom03" type="text" required>',
			'<div class="invalid-feedback">',
			'Please provide a valid city.',
			'</div>',
			'</div>',

			'<div class="col-md-3">',
			'<label class="form-label" for="validationCustom04">State</label>',
			'<select class="form-select" id="validationCustom04" required>',
			'<option value="" disabled selected>Choose...</option>',
			'<option>...</option>',
			'</select>',
			'<div class="invalid-feedback">',
			'Please select a valid state.',
			'</div>',
			'</div>',

			'<div class="col-md-3">',
			'<label class="form-label" for="validationCustom05">Zip</label>',
			'<input class="form-control" id="validationCustom05" type="text" required>',
			'<div class="invalid-feedback">',
			'Please provide a valid zip.',
			'</div>',
			'</div>',

			'<div class="col-12">',
			'<div class="form-check">',
			'<input class="form-check-input" id="invalidCheck" type="checkbox" value="" required>',
			'<label class="form-check-label" for="invalidCheck">',
			'Agree to terms and conditions',
			'</label>',
			'<div class="invalid-feedback">',
			'You must agree before submitting.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="col-12">',
			'<button class="btn btn-primary" type="submit">Submit form</button>',
			'</div>',

			'</form>'
		]);

		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'row-inline',
			'novalidate' => true
		])
		->attributes([
			'class' => [
				'g-3',
				'needs-validation' // this is just a part of example not needed
			]
		])
		->content([
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-4',
					'feedback' => [
						'valid' => 'Looks good!'
					],
					'id' => 'validationCustom01',
					'label' => 'First name',
					'required' => true,
					'value' => 'Mark'
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-4',
					'feedback' => [
						'valid' => 'Looks good!'
					],
					'id' => 'validationCustom02',
					'label' => 'Last name',
					'required' => true,
					'value' => 'Otto'
				]
			],

			[
				'inputGroup' => [
					'breakpoint' => 'md-4',
					'debug' => true,
					'items' => [
						[
							'inputGroupText' => [
								'id' => 'inputGroupPrepend',
								'text' => '@'
							]
						],
						[
							'input' => [
								'autocomplete' => false,
								'describedby' => 'inputGroupPrepend',
								'feedback' => [
									'invalid' => 'Please choose a username.'
								],
								'id' => 'validationCustomUsername',
								'label' => 'Username',
								'required' => true
							]
						]
					]
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-6',
					'feedback' => [
						'invalid' => 'Please provide a valid city.'
					],
					'id' => 'validationCustom03',
					'label' => 'City',
					'required' => true
				]
			],

			[
				'select' => [
					'autocomplete' => false,
					'breakpoint' => 'md-3',
					'feedback' => [
						'invalid' => 'Please select a valid state.'
					],
					'id' => 'validationCustom04',
					'items' => [
						[
							'disabled' => true,
							'selected' => true,
							'text' => 'Choose...',
							'value' => ''
						],
						[
							'text' => '...'
						]
					],
					'label' => 'State',
					'required' => true
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-3',
					'feedback' => [
						'invalid' => 'Please provide a valid zip.'
					],
					'id' => 'validationCustom05',
					'label' => 'Zip',
					'required' => true
				]
			],
			[
				'inputCheckbox' => [
					'autocomplete' => false,
					'breakpoint' => '12',
					'feedback' => [
						'invalid' => 'You must agree before submitting.'
					],
					'id' => 'invalidCheck',
					'label' => 'Agree to terms and conditions',
					'required' => 'true',
					'value' => ''
				]
			],
			[
				'button' => [
					'breakpoint' => '12',
					'text' => 'Submit form',
					'type' => 'submit',
					'variant' => 'primary'
				]
			]
		]);
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<form class="g-3 row">',

			'<div class="col-md-4">',
			'<label class="form-label" for="validationDefault01">First name</label>',
			'<input class="form-control" id="validationDefault01" type="text" value="Mark" required>',
			'</div>',

			'<div class="col-md-4">',
			'<label class="form-label" for="validationDefault02">Last name</label>',
			'<input class="form-control" id="validationDefault02" type="text" value="Otto" required>',
			'</div>',

			'<div class="col-md-4">',
			'<label class="form-label" for="validationDefaultUsername">Username</label>',
			'<div class="input-group">',
			'<span class="input-group-text" id="inputGroupPrepend2">@</span>',
			'<input aria-describedby="inputGroupPrepend2" class="form-control" id="validationDefaultUsername" type="text" required>',
			'</div>',
			'</div>',

			'<div class="col-md-6">',
			'<label class="form-label" for="validationDefault03">City</label>',
			'<input class="form-control" id="validationDefault03" type="text" required>',
			'</div>',

			'<div class="col-md-3">',
			'<label class="form-label" for="validationDefault04">State</label>',
			'<select class="form-select" id="validationDefault04" required>',
			'<option value="" disabled selected>Choose...</option>',
			'<option>...</option>',
			'</select>',
			'</div>',

			'<div class="col-md-3">',
			'<label class="form-label" for="validationDefault05">Zip</label>',
			'<input class="form-control" id="validationDefault05" type="text" required>',
			'</div>',

			'<div class="col-12">',
			'<div class="form-check">',
			'<input class="form-check-input" id="invalidCheck2" type="checkbox" value="" required>',
			'<label class="form-check-label" for="invalidCheck2">',
			'Agree to terms and conditions',
			'</label>',
			'</div>',
			'</div>',

			'<div class="col-12">',
			'<button class="btn btn-primary" type="submit">Submit form</button>',
			'</div>',

			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'row-inline'
		])
		->attributes([
			'class' => [
				'g-3'
			]
		])
		->content([

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-4',
					'id' => 'validationDefault01',
					'label' => 'First name',
					'required' => true,
					'value' => 'Mark'

				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-4',
					'id' => 'validationDefault02',
					'label' => 'Last name',
					'required' => true,
					'value' => 'Otto'

				]
			],

			[
				'inputGroup' => [
					'breakpoint' => 'md-4',
					'debug' => true,
					'items' => [
						[
							'inputGroupText' => [
								'id' => 'inputGroupPrepend2',
								'text' => '@'
							]
						],
						[
							'input' => [
								'autocomplete' => false,
								'describedby' => 'inputGroupPrepend2',
								'id' => 'validationDefaultUsername',
								'label' => 'Username',
								'required' => true
							]
						]
					]
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-6',
					'id' => 'validationDefault03',
					'label' => 'City',
					'required' => true
				]
			],

			[
				'select' => [
					'autocomplete' => false,
					'breakpoint' => 'md-3',
					'id' => 'validationDefault04',
					'items' => [
						[
							'disabled' => true,
							'selected' => true,
							'text' => 'Choose...',
							'value' => ''
						],
						[
							'text' => '...'
						]
					],
					'label' => 'State',
					'required' => true
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-3',
					'id' => 'validationDefault05',
					'label' => 'Zip',
					'required' => true
				]
			],

			[
				'inputCheckbox' => [
					'autocomplete' => false,
					'breakpoint' => '12',
					'id' => 'invalidCheck2',
					'label' => 'Agree to terms and conditions',
					'required' => 'true',
					'value' => ''
				]
			],

			[
				'button' => [
					'breakpoint' => '12',
					'text' => 'Submit form',
					'type' => 'submit',
					'variant' => 'primary'
				]
			]

		]);
		$this->assertEquals($test, $result);


		//Server-side
		$test = implode('', [
			'<form class="g-3 row">',

			'<div class="col-md-4">',
			'<label class="form-label" for="validationServer01">First name</label>',
			'<input class="form-control is-valid" id="validationServer01" type="text" value="Mark" required>',
			'<div class="valid-feedback">',
			'Looks good!',
			'</div>',
			'</div>',

			'<div class="col-md-4">',
			'<label class="form-label" for="validationServer02">Last name</label>',
			'<input class="form-control is-valid" id="validationServer02" type="text" value="Otto" required>',
			'<div class="valid-feedback">',
			'Looks good!',
			'</div>',
			'</div>',

			'<div class="col-md-4">',
			'<label class="form-label" for="validationServerUsername">Username</label>',
			'<div class="has-validation input-group">',
			'<span class="input-group-text" id="inputGroupPrepend3">@</span>',
			'<input aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" class="form-control is-invalid" id="validationServerUsername" type="text" required>',
			'<div class="invalid-feedback" id="validationServerUsernameFeedback">',
			'Please choose a username.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="col-md-6">',
			'<label class="form-label" for="validationServer03">City</label>',
			'<input aria-describedby="validationServer03Feedback" class="form-control is-invalid" id="validationServer03" type="text" required>',
			'<div class="invalid-feedback" id="validationServer03Feedback">',
			'Please provide a valid city.',
			'</div>',
			'</div>',

			'<div class="col-md-3">',
			'<label class="form-label" for="validationServer04">State</label>',
			'<select aria-describedby="validationServer04Feedback" class="form-select is-invalid" id="validationServer04" required>',
			'<option value="" disabled selected>Choose...</option>',
			'<option>...</option>',
			'</select>',
			'<div class="invalid-feedback" id="validationServer04Feedback">',
			'Please select a valid state.',
			'</div>',
			'</div>',

			'<div class="col-md-3">',
			'<label class="form-label" for="validationServer05">Zip</label>',
			'<input aria-describedby="validationServer05Feedback" class="form-control is-invalid" id="validationServer05" type="text" required>',
			'<div class="invalid-feedback" id="validationServer05Feedback">',
			'Please provide a valid zip.',
			'</div>',
			'</div>',

			'<div class="col-12">',
			'<div class="form-check">',
			'<input aria-describedby="invalidCheck3Feedback" class="form-check-input is-invalid" id="invalidCheck3" type="checkbox" value="" required>',
			'<label class="form-check-label" for="invalidCheck3">',
			'Agree to terms and conditions',
			'</label>',
			'<div class="invalid-feedback" id="invalidCheck3Feedback">',
			'You must agree before submitting.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="col-12">',
			'<button class="btn btn-primary" type="submit">Submit form</button>',
			'</div>',

			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'row-inline'
		])
		->attributes([
			'class' => [
				'g-3'
			]
		])
		->content([
			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-4',
					'feedback' => [
						'valid' => 'Looks good!'
					],
					'id' => 'validationServer01',
					'label' => 'First name',
					'required' => true,
					'valid' => true,
					'value' => 'Mark'
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-4',
					'feedback' => [
						'valid' => 'Looks good!'
					],
					'id' => 'validationServer02',
					'label' => 'Last name',
					'required' => true,
					'valid' => true,
					'value' => 'Otto'
				]
			],

			[
				'inputGroup' => [
					'breakpoint' => 'md-4',
					'debug' => true,
					'items' => [
						[
							'inputGroupText' => [
								'id' => 'inputGroupPrepend3',
								'text' => '@'
							]
						],
						[
							'input' => [
								'autocomplete' => false,
//								'debug' => true,
								'describedby' => 'inputGroupPrepend3',
								'feedback' => [
									'invalid' => [
										'id' => 'validationServerUsernameFeedback',
										'text' => 'Please choose a username.'
									]
								],
								'id' => 'validationServerUsername',
								'label' => 'Username',
								'required' => true,
								'valid' => false
							]
						]
					]
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-6',
					'feedback' => [
						'invalid' => [
							'id' => 'validationServer03Feedback',
							'text' => 'Please provide a valid city.'
						]
					],
					'id' => 'validationServer03',
					'label' => 'City',
					'required' => true,
					'valid' => false
				]
			],

			[
				'select' => [
					'autocomplete' => false,
					'breakpoint' => 'md-3',
					'feedback' => [
						'invalid' => [
							'id' => 'validationServer04Feedback',
							'text' => 'Please select a valid state.'
						]
					],
					'id' => 'validationServer04',
					'items' => [
						[
							'disabled' => true,
							'selected' => true,
							'text' => 'Choose...',
							'value' => ''
						],
						[
							'text' => '...'
						]
					],
					'label' => 'State',
					'required' => true,
					'valid' => false
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'breakpoint' => 'md-3',
					'feedback' => [
						'invalid' => [
							'id' => 'validationServer05Feedback',
							'text' => 'Please provide a valid zip.'
						]
					],
					'id' => 'validationServer05',
					'label' => 'Zip',
					'required' => true,
					'valid' => false
				]
			],

			[
				'inputCheckbox' => [
					'autocomplete' => false,
					'breakpoint' => '12',
					'feedback' => [
						'invalid' => [
							'id' => 'invalidCheck3Feedback',
							'text' => 'You must agree before submitting.'
						]
					],
					'id' => 'invalidCheck3',
					'autocomplete' => false,
					'label' => 'Agree to terms and conditions',
					'required' => 'true',
					'valid' => false,
					'value' => ''
				]
			],

			[
				'button' => [
					'breakpoint' => '12',
					'text' => 'Submit form',
					'type' => 'submit',
					'variant' => 'primary'
				]
			]

		]);
		$this->assertEquals($test, $result);


		//Supported elements
		$test = implode('', [
			'<form class="was-validated">',

			'<div class="mb-3">',
			'<label class="form-label" for="validationTextarea">Textarea</label>',
			'<textarea class="form-control" id="validationTextarea" placeholder="Required example textarea" required></textarea>',
			'<div class="invalid-feedback">',
			'Please enter a message in the textarea.',
			'</div>',
			'</div>',

			'<div class="form-check mb-3">',
			'<input class="form-check-input" id="validationFormCheck1" type="checkbox" required>',
			'<label class="form-check-label" for="validationFormCheck1">Check this checkbox</label>',
			'<div class="invalid-feedback">Example invalid feedback text</div>',
			'</div>',

			'<div class="form-check">',
			'<input class="form-check-input" id="validationFormCheck2" name="radio-stacked" type="radio" required>',
			'<label class="form-check-label" for="validationFormCheck2">Toggle this radio</label>',
			'</div>',

			'<div class="form-check mb-3">',
			'<input class="form-check-input" id="validationFormCheck3" name="radio-stacked" type="radio" required>',
			'<label class="form-check-label" for="validationFormCheck3">Or toggle this other radio</label>',
			'<div class="invalid-feedback">More example invalid feedback text</div>',
			'</div>',

			'<div class="mb-3">',
			'<select aria-label="select example" class="form-select" required>',
			'<option value="">Open this select menu</option>',
			'<option value="1">One</option>',
			'<option value="2">Two</option>',
			'<option value="3">Three</option>',
			'</select>',
			'<div class="invalid-feedback">Example invalid select feedback</div>',
			'</div>',

			'<div class="mb-3">',
			'<input aria-label="file example" class="form-control" type="file" required>',
			'<div class="invalid-feedback">Example invalid form file feedback</div>',
			'</div>',

			'<div class="mb-3">',
			'<button class="btn btn-primary" type="submit" disabled>Submit form</button>',
			'</div>',

			'</form>'
		]);
		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'margin'
		])
		->attributes([
			'class' => [
				'was-validated'
			]
		])
		->content([
			[
				'inputTextarea' => [
					'autocomplete' => false,
					'feedback' => [
						'invalid' => 'Please enter a message in the textarea.'
					],
					'id' => 'validationTextarea',
					'label' => 'Textarea',
					'placeholder' => 'Required example textarea',
					'required' => true
				]
			],

			[
				'inputCheckbox' => [
					'autocomplete' => false,
					'feedback' => [
						'invalid' => 'Example invalid feedback text'
					],
					'id' => 'validationFormCheck1',
					'label' => 'Check this checkbox',
					'required' => true

				]
			],

			[
				'inputRadio' => [
					'autocomplete' => false,
					'id' => 'validationFormCheck2',
					'label' => 'Toggle this radio',
					'layout' => 'block',
					'name' => 'radio-stacked',
					'required' => true

				]
			],

			[
				'inputRadio' => [
					'autocomplete' => false,
					'feedback' => [
						'invalid' => 'More example invalid feedback text'
					],
					'id' => 'validationFormCheck3',
					'label' => 'Or toggle this other radio',
					'name' => 'radio-stacked',
					'required' => true
				]
			],

			[
				'select' => [
					'autocomplete' => false,
					'aria-label' => 'select example',
					'feedback' => [
						'invalid' => 'Example invalid select feedback'
					],
					'items' => [
						[
							'text' => 'Open this select menu',
							'value' => ''
						],
						[
							'text' => 'One',
							'value' => '1'
						],
						[
							'text' => 'Two',
							'value' => '2'
						],
						[
							'text' => 'Three',
							'value' => '3'
						]
					],
					'required' => true
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'aria-label' => 'file example',
					'feedback' => [
						'invalid' => 'Example invalid form file feedback'
					],
					'required' => true,
					'type' => 'file'
				]
			],

			[
				$aviHtmlElement->tag('div', [
					'class' => 'mb-3'
				])
				->content([
					$aviHtmlElement->element('BsButton', [
					'disabled' => true,
					'text' => 'Submit form',
					'type' => 'submit',
					'variant' => 'primary'
					])->use()
				], true)
			]
		]);
		$this->assertEquals($test, $result);


		//Tooltips
		$test = implode('', [
			'<form class="g-3 needs-validation row" novalidate>',

			'<div class="col-md-4 position-relative">',
			'<label class="form-label" for="validationTooltip01">First name</label>',
			'<input class="form-control" id="validationTooltip01" type="text" value="Mark" required>',
			'<div class="valid-tooltip">',
			'Looks good!',
			'</div>',
			'</div>',

			'<div class="col-md-4 position-relative">',
			'<label class="form-label" for="validationTooltip02">Last name</label>',
			'<input class="form-control" id="validationTooltip02" type="text" value="Otto" required>',
			'<div class="valid-tooltip">',
			'Looks good!',
			'</div>',
			'</div>',

			'<div class="col-md-4 position-relative">',
			'<label class="form-label" for="validationTooltipUsername">Username</label>',
			'<div class="has-validation input-group">',
			'<span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>',
			'<input aria-describedby="validationTooltipUsernamePrepend" class="form-control" id="validationTooltipUsername" type="text" required>',
			'<div class="invalid-tooltip">',
			'Please choose a unique and valid username.',
			'</div>',
			'</div>',
			'</div>',

			'<div class="col-md-6 position-relative">',
			'<label class="form-label" for="validationTooltip03">City</label>',
			'<input class="form-control" id="validationTooltip03" type="text" required>',
			'<div class="invalid-tooltip">',
			'Please provide a valid city.',
			'</div>',
			'</div>',

			'<div class="col-md-3 position-relative">',
			'<label class="form-label" for="validationTooltip04">State</label>',
			'<select class="form-select" id="validationTooltip04" required>',
			'<option value="" disabled selected>Choose...</option>',
			'<option>...</option>',
			'</select>',
			'<div class="invalid-tooltip">',
			'Please select a valid state.',
			'</div>',
			'</div>',

			'<div class="col-md-3 position-relative">',
			'<label class="form-label" for="validationTooltip05">Zip</label>',
			'<input class="form-control" id="validationTooltip05" type="text" required>',
			'<div class="invalid-tooltip">',
			'Please provide a valid zip.',
			'</div>',
			'</div>',

			'<div class="col-12">',
			'<button class="btn btn-primary" type="submit">Submit form</button>',
			'</div>',

			'</form>'
		]);

		$result = $aviHtmlElement->element('BsForm', [
			'layout' => 'row-inline',
			'novalidate' => true
		])
		->attributes([
			'class' => [
				'g-3',
				'needs-validation'
			]
		])
		->content([

			[
				'input' => [
					'autocomplete' => false,
					'attr' => [
						'class' => [
							'position-relative'
						]
					],
					'breakpoint' => 'md-4',
					'feedback' => [
						'valid' => [
							'text' => 'Looks good!',
							'tooltip' => true
						]
					],
					'id' => 'validationTooltip01',
					'label' => 'First name',
					'required' => true,
					'value' => 'Mark'
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'attr' => [
						'class' => [
							'position-relative'
						]
					],
					'breakpoint' => 'md-4',
					'feedback' => [
						'valid' => [
							'text' => 'Looks good!',
							'tooltip' => true
						]
					],
					'id' => 'validationTooltip02',
					'label' => 'Last name',
					'required' => true,
					'value' => 'Otto'
				]
			],

			[
				'inputGroup' => [
					'attr' => [
						'class' => [
							'position-relative'
						]
					],
					'breakpoint' => 'md-4',
					'items' => [
						[
							'inputGroupText' => [
								'id' => 'validationTooltipUsernamePrepend',
								'text' => '@'
							]
						],
						[
							'input' => [
								'autocomplete' => false,
								'describedby' => 'validationTooltipUsernamePrepend',
								'feedback' => [
									'invalid' => [
										'text' => 'Please choose a unique and valid username.',
										'tooltip' => true
									]
								],
								'id' => 'validationTooltipUsername',
								'label' => 'Username',
								'required' => true
							]
						]
					]
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'attr' => [
						'class' => [
							'position-relative'
						]
					],
					'breakpoint' => 'md-6',
					'feedback' => [
						'invalid' => [
							'text' => 'Please provide a valid city.',
							'tooltip' => true
						]
					],
					'id' => 'validationTooltip03',
					'label' => 'City',
					'required' => true
				]
			],

			[
				'select' => [
					'autocomplete' => false,
					'attr' => [
						'class' => [
							'position-relative'
						]
					],
					'breakpoint' => 'md-3',
					'feedback' => [
						'invalid' => [
							'text' => 'Please select a valid state.',
							'tooltip' => true
						]
					],
					'id' => 'validationTooltip04',
					'items' => [
						[
							'disabled' => true,
							'selected' => true,
							'text' => 'Choose...',
							'value' => ''
						],
						[
							'text' => '...'
						]
					],
					'label' => 'State',
					'required' => true
				]
			],

			[
				'input' => [
					'autocomplete' => false,
					'attr' => [
						'class' => [
							'position-relative'
						]
					],
					'breakpoint' => 'md-3',
					'feedback' => [
						'invalid' => [
							'text' => 'Please provide a valid zip.',
							'tooltip' => true
						]
					],
					'id' => 'validationTooltip05',
					'label' => 'Zip',
					'required' => true
				]
			],

			[
				$aviHtmlElement->tag('div', [
					'class' => 'col-12'
				])
				->content([
					$aviHtmlElement->element('BsButton', [
						'text' => 'Submit form',
						'type' => 'submit',
						'variant' => 'primary'
					])->use()
				], true)
			]
		]);
		$this->assertEquals($test, $result);
	}
}


