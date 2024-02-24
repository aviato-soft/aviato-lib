<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.08
 * @since  2024-02-24 13:27:06
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';

const AVI_BS_BREAKPOINT = [
	'xs',
	'sm',
	'md',
	'lg',
	'xl',
	'xxl'
];

const AVI_BS_COLOR = [
	'primary',
	'secondary',
	'success',
	'danger',
	'warning',
	'info',
	'light',
	'dark',
];

const AVI_BS_POS_H = [
	'center',
	'end',
	'start'
];

const AVI_BS_POS_V = [
	'down',
	'up'
];

const AVI_BS_SIZE = [
	'sm',
	'lg'
];


class HtmlElementBs extends HtmlElement
{
	public function collapse($params = [])
	{
		$this->setAttrClass('collapse');

		if(isset($params['direction']) && $params['direction'] === 'horizontal') {
			$this->setAttrClass('collapse-horizontal');
		}

		return $this;
	}


	public function popover($params = [])
	{

		$params['toggle'] = 'popover';

		$keys = ['content', 'container', 'custom-class', 'placement', 'title', 'toggle', 'trigger'];
		foreach($keys as $k) {
			if(isset($params[$k])) {
				$this->attributes['data']['bs-'.$k] = $params[$k];
			}
		}

		if (($params['trigger'] ?? false) === 'focus') {
			$this->attributes['tabindex'] = '0';
		}

		return $this;
	}


	public function tag($tag, $attributes = null, $newElement = true, $instance = null)
	{
		if ($instance === null) {
			$instance = $this;
		}
		return parent::tag($tag, $attributes, $newElement, $instance);
	}


	public function toggle($params)
	{
		if(!isset($params['type'])) {
			return $this;
		}

		$this->attributes['data']['bs-toggle'] = $params['type'];

		if (isset($params['target'])) {
			if ($this->tag === 'a') {
				$this->attributes['href'] = $params['target'];
			} else {
				$this->attributes['data']['bs-target'] = $params['target'];
			}

			$this->attributes['aria']['expanded'] = (($params['expanded'] ?? false) === true) ? 'true' : 'false';
			$this->attributes['aria']['controls'] = $params['controls'] ?? $params['target'];
		}

		return $this;
	}


	public function tooltip($data)
	{
		$dataAttr = [
			'bs-toggle' => 'tooltip'
		];

		if (isset($data['custom-class'])) {
			$dataAttr['bs-custom-class'] = $data['custom-class'];
		}

		if (isset($data['isHtml'])) {
			$dataAttr['bs-html'] = 'true';
		}

		if (isset($data['placement']) && in_array($data['placement'], ['bottom', 'left', 'right', 'top'], true)) {
			$dataAttr['bs-placement'] = $data['placement'];
		}

		if (isset($data['title'])) {
			$dataAttr['bs-title'] = $data['title'];
		}

		return $this->attributes([
			'data' => $dataAttr
		]);
	}
}
