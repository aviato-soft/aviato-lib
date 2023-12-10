<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.20
 * @since 2023-11-23 16:27:51
 *
 */
declare(strict_types = 1)
	;

require_once dirname(__DIR__).'/HtmlElement.php';

class HtmlElementBsSpinner extends \Avi\HtmlElement
{
	private $color = [
		'primary',
		'secondary',
		'success',
		'danger',
		'warning',
		'info',
		'light',
		'dark',
	];
	private $params;
	private $size = [
		'sm',
		'lg'
	];
	private $type = [
		'border',
		'glow'
	];

	/**
	 *
	 * @param array $params the values are optional and must be:
	 *        |- color = $color
	 *        |- type = $type
	 *        |- text = string
	 *        |- size = $size
	 * @return HtmlElementBsSpinner
	 */
	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->attributes([
			'role' => 'status',
			'class' => [
				sprintf('spinner-%s', $this->params['type'])
			]
		]);
		return $this;
	}

	private function parseParams()
	{
		if (!isset($this->params['type']) || in_array($this->params['type'], $this->type, true)) {
			$this->params['type'] = 'border';
		}

		if (isset($this->params['color']) && in_array($this->params['color'], $this->color, true)) {
			$this->color();
		}

		if (isset($this->params['text'])) {
			$this->text();
		}
	}

	private function color()
	{
		$this->attributes([
			'class' => [
				sprintf('text-%s', $this->params['color'])
			]
		]);
	}


	private function size()
	{
		$this->attributes([
			'class' => sprintf('btn-%s', $this->params['size'])
		]);
	}


	private function text()
	{
		$this->content[] = $this->tag('span')->attributes([
			'class' => 'visually-hidden'
		])->content($this->params['text']);
	}

}
