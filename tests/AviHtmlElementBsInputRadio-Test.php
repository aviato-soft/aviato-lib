<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;
use const Avi\AVI_BS_COLOR;

final class testAviatoHtmlElementBsRadio extends TestCase
{

	public function testFn_Construct(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Checks
		$test = implode('', [
			'<div class="form-check">',
			'<input class="form-check-input" id="flexRadioDefault1" name="flexRadioDefault" type="radio">',
			'<label class="form-check-label" for="flexRadioDefault1">',
			'Default radio',
			'</label>',
			'</div>',
			'<div class="form-check">',
			'<input class="form-check-input" id="flexRadioDefault2" name="flexRadioDefault" type="radio" checked>',
			'<label class="form-check-label" for="flexRadioDefault2">',
			'Default checked radio',
			'</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'flexRadioDefault1',
				'label' => 'Default radio',
				'name' => 'flexRadioDefault'
			])
			->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'flexRadioDefault2',
				'checked' => true,
				'label' => 'Default checked radio',
				'name' => 'flexRadioDefault'
			])->use()
		]);
		$this->assertEquals($test, $result);

		//Indeterminate
		//Checkboxes can utilize the :indeterminate pseudo class when manually set via JavaScript (there is no available HTML attribute for specifying it).

		//Disabled
		$test=implode('', [
			'<div class="form-check">',
			'<input class="form-check-input" id="flexRadioDisabled" name="flexRadioDisabled" type="radio" disabled>',
			'<label class="form-check-label" for="flexRadioDisabled">',
			'Disabled radio',
			'</label>',
			'</div>',
			'<div class="form-check">',
			'<input class="form-check-input" id="flexRadioCheckedDisabled" name="flexRadioDisabled" type="radio" checked disabled>',
			'<label class="form-check-label" for="flexRadioCheckedDisabled">',
			'Disabled checked radio',
			'</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputRadio', [
				'disabled' => true,
				'id' => 'flexRadioDisabled',
				'label' => 'Disabled radio',
				'name' => 'flexRadioDisabled'
			])
			->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'checked' => true,
				'disabled' => true,
				'id' => 'flexRadioCheckedDisabled',
				'label' => 'Disabled checked radio',
				'name' => 'flexRadioDisabled'
			])->use()
		]);
		$this->assertEquals($test, $result);

/*
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
				'id' => 'flexSwitchCheckDefault',
				'label' => 'Default switch checkbox input',
				'switch' => true,
				'value' => null
			])
			->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'checked' => true,
				'id' => 'flexSwitchCheckChecked',
				'label' => 'Checked switch checkbox input',
				'switch' => true,
				'value' => null
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'disabled' => true,
				'id' => 'flexSwitchCheckDisabled',
				'label' => 'Disabled switch checkbox input',
				'switch' => true,
				'value' => null
			])
			->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
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
*/

		//Default (stacked)
		//By default, any number of checkboxes and radios that are immediate sibling will be vertically stacked and appropriately spaced with .form-check.
		//no test is required


		//Inline
		$test=implode('', [
			'<div class="form-check form-check-inline">',
			'<input class="form-check-input" id="inlineRadio1" name="inlineRadioOptions" type="radio" value="option1">',
			'<label class="form-check-label" for="inlineRadio1">1</label>',
			'</div>',
			'<div class="form-check form-check-inline">',
			'<input class="form-check-input" id="inlineRadio2" name="inlineRadioOptions" type="radio" value="option2">',
			'<label class="form-check-label" for="inlineRadio2">2</label>',
			'</div>',
			'<div class="form-check form-check-inline">',
			'<input class="form-check-input" id="inlineRadio3" name="inlineRadioOptions" type="radio" value="option3" disabled>',
			'<label class="form-check-label" for="inlineRadio3">3 (disabled)</label>',
			'</div>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'inlineRadio1',
				'inline' => true,
				'label' => '1',
				'name' => 'inlineRadioOptions',
				'value' => 'option1',
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'inlineRadio2',
				'inline' => true,
				'label' => '2',
				'name' => 'inlineRadioOptions',
				'value' => 'option2',
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'disabled' => true,
				'id' => 'inlineRadio3',
				'inline' => true,
				'label' => '3 (disabled)',
				'name' => 'inlineRadioOptions',
				'value' => 'option3',
			])->use(),
		]);
		$this->assertEquals($test, $result);

/*
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
				'id' => 'reverseCheck1',
				'label' => 'Reverse checkbox',
				'reverse' => true,
				'value' => ''
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'disabled' => true,
				'id' => 'reverseCheck2',
				'label' => 'Disabled reverse checkbox',
				'reverse' => true,
				'value' => ''
			])->use(),
			$aviHtmlElement->element('BsInputCheckbox', [
				'id' => 'flexSwitchCheckReverse',
				'label' => 'Reverse switch checkbox input',
				'reverse' => true,
				'switch' => true,
			])->use()
		]);
		$this->assertEquals($test, $result);
*/

		//Withput labels
		$test=implode('', [
			'<div>',
			'<input aria-label="..." class="form-check-input" id="radioNoLabel1" name="radioNoLabel" type="radio" value="">',
			'</div>'
		]);
		$result = $aviHtmlElement->element('BsInputRadio', [
			'aria-label' => '...',
			'id' => 'radioNoLabel1',
			'label' => false,
			'name' => 'radioNoLabel',
			'value' => ''
		])->use();
		$this->assertEquals($test, $result);


		//Toggle buttons
		$test=implode('', [
			'<input autocomplete="off" class="btn-check" id="option1" name="options" type="radio" checked>',
			'<label class="btn btn-secondary" for="option1">Checked</label>',

			'<input autocomplete="off" class="btn-check" id="option2" name="options" type="radio">',
			'<label class="btn btn-secondary" for="option2">Radio</label>',

			'<input autocomplete="off" class="btn-check" id="option3" name="options" type="radio" disabled>',
			'<label class="btn btn-secondary" for="option3">Disabled</label>',

			'<input autocomplete="off" class="btn-check" id="option4" name="options" type="radio">',
			'<label class="btn btn-secondary" for="option4">Radio</label>',

			'<input autocomplete="off" class="btn-check" id="option5" name="options-base" type="radio" checked>',
			'<label class="btn" for="option5">Checked</label>',

			'<input autocomplete="off" class="btn-check" id="option6" name="options-base" type="radio">',
			'<label class="btn" for="option6">Radio</label>',

			'<input autocomplete="off" class="btn-check" id="option7" name="options-base" type="radio" disabled>',
			'<label class="btn" for="option7">Disabled</label>',

			'<input autocomplete="off" class="btn-check" id="option8" name="options-base" type="radio">',
			'<label class="btn" for="option8">Radio</label>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputRadio', [
				'checked' => true,
				'id' => 'option1',
				'label' => 'Checked',
				'name' => 'options',
				'type' => 'button',
				'variant' => 'secondary'
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'option2',
				'label' => 'Radio',
				'name' => 'options',
				'type' => 'button',
				'variant' => 'secondary'
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'disabled' => true,
				'id' => 'option3',
				'label' => 'Disabled',
				'name' => 'options',
				'type' => 'button',
				'variant' => 'secondary'
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'option4',
				'label' => 'Radio',
				'name' => 'options',
				'type' => 'button',
				'variant' => 'secondary'
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'checked' => true,
				'id' => 'option5',
				'label' => 'Checked',
				'name' => 'options-base',
				'type' => 'button'
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'option6',
				'label' => 'Radio',
				'name' => 'options-base',
				'type' => 'button'
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'disabled' => true,
				'id' => 'option7',
				'label' => 'Disabled',
				'name' => 'options-base',
				'type' => 'button'
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'option8',
				'label' => 'Radio',
				'name' => 'options-base',
				'type' => 'button'
			])->use(),

		]);
		$this->assertEquals($test, $result);


		//outlined styles
		$test=implode('', [
			'<input autocomplete="off" class="btn-check" id="success-outlined" name="options-outlined" type="radio" checked>',
			'<label class="btn btn-outline-success" for="success-outlined">Checked success radio</label>',

			'<input autocomplete="off" class="btn-check" id="danger-outlined" name="options-outlined" type="radio">',
			'<label class="btn btn-outline-danger" for="danger-outlined">Danger radio</label>'
		]);
		$result = implode('', [
			$aviHtmlElement->element('BsInputRadio', [
				'checked' => true,
				'id' => 'success-outlined',
				'label' => 'Checked success radio',
				'name' => 'options-outlined',
				'outline' => true,
				'type' => 'button',
				'variant' => 'success'
			])->use(),
			$aviHtmlElement->element('BsInputRadio', [
				'id' => 'danger-outlined',
				'label' => 'Danger radio',
				'name' => 'options-outlined',
				'outline' => true,
				'type' => 'button',
				'variant' => 'danger'
			])->use()
		]);
		$this->assertEquals($test, $result);

	}
}
