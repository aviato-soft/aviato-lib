<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsInputCheckbox extends TestCase
{

	public function testFn_Construct(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Checks
		$test = implode('', [
			'<div class="form-check">',
			'<input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">',
			'<label class="form-check-label" for="flexCheckDefault">',
			'Default checkbox',
			'</label>',
			'</div>',

			'<div class="form-check">',
			'<input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked>',
			'<label class="form-check-label" for="flexCheckChecked">',
			'Checked checkbox',
			'</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'flexCheckDefault',
				'label' => 'Default checkbox',
				'value' => ''
			])
			->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'flexCheckChecked',
				'checked' => true,
				'label' => 'Checked checkbox',
				'value' => ''
			])->use()
		]);
		$this->assertEquals($test, $result);

		//Indeterminate
		//Checkboxes can utilize the :indeterminate pseudo class when manually set via JavaScript (there is no available HTML attribute for specifying it).

		//Disabled
		$test=implode('', [
			'<div class="form-check">',
			'<input class="form-check-input" id="flexCheckIndeterminateDisabled" type="checkbox" value="" disabled>',
			'<label class="form-check-label" for="flexCheckIndeterminateDisabled">',
			'Disabled indeterminate checkbox',
			'</label>',
			'</div>',

			'<div class="form-check">',
			'<input class="form-check-input" id="flexCheckDisabled" type="checkbox" value="" disabled>',
			'<label class="form-check-label" for="flexCheckDisabled">',
			'Disabled checkbox',
			'</label>',
			'</div>',

			'<div class="form-check">',
			'<input class="form-check-input" id="flexCheckCheckedDisabled" type="checkbox" value="" checked disabled>',
			'<label class="form-check-label" for="flexCheckCheckedDisabled">',
			'Disabled checked checkbox',
			'</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'flexCheckIndeterminateDisabled',
				'label' => 'Disabled indeterminate checkbox',
				'value' => ''
			])
			->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'flexCheckDisabled',
				'label' => 'Disabled checkbox',
				'value' => ''
			])
			->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'checked' => true,
				'disabled' => true,
				'id' => 'flexCheckCheckedDisabled',
				'label' => 'Disabled checked checkbox',
				'value' => ''
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Switches
		$test=implode('', [
			'<div class="form-check form-switch">',
			'<input class="form-check-input" id="flexSwitchCheckDefault" role="switch" type="checkbox">',
			'<label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>',
			'</div>',

			'<div class="form-check form-switch">',
			'<input class="form-check-input" id="flexSwitchCheckChecked" role="switch" type="checkbox" checked>',
			'<label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>',
			'</div>',

			'<div class="form-check form-switch">',
			'<input class="form-check-input" id="flexSwitchCheckDisabled" role="switch" type="checkbox" disabled>',
			'<label class="form-check-label" for="flexSwitchCheckDisabled">Disabled switch checkbox input</label>',
			'</div>',

			'<div class="form-check form-switch">',
			'<input class="form-check-input" id="flexSwitchCheckCheckedDisabled" role="switch" type="checkbox" checked disabled>',
			'<label class="form-check-label" for="flexSwitchCheckCheckedDisabled">Disabled checked switch checkbox input</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'flexSwitchCheckDefault',
				'label' => 'Default switch checkbox input',
				'switch' => true,
				'value' => null
			])
			->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'checked' => true,
				'id' => 'flexSwitchCheckChecked',
				'label' => 'Checked switch checkbox input',
				'switch' => true,
				'value' => null
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'flexSwitchCheckDisabled',
				'label' => 'Disabled switch checkbox input',
				'switch' => true,
				'value' => null
			])
			->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'checked' => true,
				'disabled' => true,
				'id' => 'flexSwitchCheckCheckedDisabled',
				'label' => 'Disabled checked switch checkbox input',
				'switch' => true,
				'value' => null
			])
			->use(),
		]);
		$this->assertEquals($test, $result);


		//Default (stacked)
		//By default, any number of checkboxes and radios that are immediate sibling will be vertically stacked and appropriately spaced with .form-check.
		//no test is required


		//Inline
		$test=implode('', [
			'<div class="form-check form-check-inline">',
			'<input class="form-check-input" id="inlineCheckbox1" type="checkbox" value="option1">',
			'<label class="form-check-label" for="inlineCheckbox1">1</label>',
			'</div>',

			'<div class="form-check form-check-inline">',
			'<input class="form-check-input" id="inlineCheckbox2" type="checkbox" value="option2">',
			'<label class="form-check-label" for="inlineCheckbox2">2</label>',
			'</div>',

			'<div class="form-check form-check-inline">',
			'<input class="form-check-input" id="inlineCheckbox3" type="checkbox" value="option3" disabled>',
			'<label class="form-check-label" for="inlineCheckbox3">3 (disabled)</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'inlineCheckbox1',
				'inline' => true,
				'label' => '1',
				'value' => 'option1',
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'inlineCheckbox2',
				'inline' => true,
				'label' => '2',
				'value' => 'option2',
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'inlineCheckbox3',
				'inline' => true,
				'label' => '3 (disabled)',
				'value' => 'option3',
			])->use(),
		]);
		$this->assertEquals($test, $result);


		//Reverse
		$test=implode('', [
			'<div class="form-check form-check-reverse">',
			'<input class="form-check-input" id="reverseCheck1" type="checkbox" value="">',
			'<label class="form-check-label" for="reverseCheck1">',
			'Reverse checkbox',
			'</label>',
			'</div>',

			'<div class="form-check form-check-reverse">',
			'<input class="form-check-input" id="reverseCheck2" type="checkbox" value="" disabled>',
			'<label class="form-check-label" for="reverseCheck2">',
			'Disabled reverse checkbox',
			'</label>',
			'</div>',

			'<div class="form-check form-check-reverse form-switch">',
			'<input class="form-check-input" id="flexSwitchCheckReverse" role="switch" type="checkbox">',
			'<label class="form-check-label" for="flexSwitchCheckReverse">Reverse switch checkbox input</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'reverseCheck1',
				'label' => 'Reverse checkbox',
				'reverse' => true,
				'value' => ''
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'reverseCheck2',
				'label' => 'Disabled reverse checkbox',
				'reverse' => true,
				'value' => ''
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'flexSwitchCheckReverse',
				'label' => 'Reverse switch checkbox input',
				'reverse' => true,
				'switch' => true,
			])->use()
		]);
		$this->assertEquals($test, $result);


		//Withput labels
		$test=implode('', [
			'<div>',
			'<input aria-label="..." class="form-check-input" id="checkboxNoLabel" type="checkbox" value="">',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsInputCheckbox', [
			'autocomplete' => false,
			'aria-label' => '...',
			'id' => 'checkboxNoLabel',
			'label' => false,
			'value' => ''
		])->use();
		$this->assertEquals($test, $result);


		//Toggle buttons
		$test=implode('', [
			'<input autocomplete="off" class="btn-check" id="btn-check" type="checkbox">',
			'<label class="btn btn-primary" for="btn-check">Single toggle</label>',

			'<input autocomplete="off" class="btn-check" id="btn-check-2" type="checkbox" checked>',
			'<label class="btn btn-primary" for="btn-check-2">Checked</label>',

			'<input autocomplete="off" class="btn-check" id="btn-check-3" type="checkbox" disabled>',
			'<label class="btn btn-primary" for="btn-check-3">Disabled</label>',

			'<input autocomplete="off" class="btn-check" id="btn-check-4" type="checkbox">',
			'<label class="btn" for="btn-check-4">Single toggle</label>',

			'<input autocomplete="off" class="btn-check" id="btn-check-5" type="checkbox" checked>',
			'<label class="btn" for="btn-check-5">Checked</label>',

			'<input autocomplete="off" class="btn-check" id="btn-check-6" type="checkbox" disabled>',
			'<label class="btn" for="btn-check-6">Disabled</label>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'btn-check',
				'label' => 'Single toggle',
				'role' => 'button',
				'variant' => 'primary'
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'checked' => true,
				'id' => 'btn-check-2',
				'label' => 'Checked',
				'role' => 'button',
				'variant' => 'primary'
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'btn-check-3',
				'label' => 'Disabled',
				'role' => 'button',
				'variant' => 'primary'
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'btn-check-4',
				'label' => 'Single toggle',
				'role' => 'button'
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'checked' => true,
				'id' => 'btn-check-5',
				'label' => 'Checked',
				'role' => 'button'
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'disabled' => true,
				'id' => 'btn-check-6',
				'label' => 'Disabled',
				'role' => 'button'
			])->use(),
		]);
		$this->assertEquals($test, $result);


		//outlined styles
		$test=implode('', [
			'<input autocomplete="off" class="btn-check" id="btn-check-outlined" type="checkbox">',
			'<label class="btn btn-outline-primary" for="btn-check-outlined">Single toggle</label>',

			'<input autocomplete="off" class="btn-check" id="btn-check-2-outlined" type="checkbox" checked>',
			'<label class="btn btn-outline-secondary" for="btn-check-2-outlined">Checked</label>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'id' => 'btn-check-outlined',
				'label' => 'Single toggle',
				'outline' => true,
				'role' => 'button',
				'variant' => 'primary'
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'autocomplete' => false,
				'checked' => true,
				'id' => 'btn-check-2-outlined',
				'label' => 'Checked',
				'outline' => true,
				'role' => 'button',
				'variant' => 'secondary'
			])->use()
		]);
		$this->assertEquals($test, $result);
	}
}
