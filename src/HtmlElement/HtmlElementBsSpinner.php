<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.09
 * @since  2024-03-04 12:25:06
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsSpinner extends HtmlElement
{
	private $type = [
		'border',
		'grow'
	];


	protected $params;

	public $status;


	/**
	 *
	 * @param array $params the values are optional and must be:
	 *        |- color = element of AVI_BS_COLOR
	 *        |- hidden = display none
	 *        |- size = element of AVI_BS_SIZE
	 *        |- status = true | false
	 *        |- text = string
	 *        |- type = element of $type
	 * @return \Avi\HtmlElementBsSpinner
	 */
	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? 'div';

		$this->parseParam('text', 'Loading...');

		$this->parseParam('hidden', false);
		$this->parseParam('status', 'child');
		$this->parseParam('status-tag', 'span');
		$this->parseParam('status-hidden', true);
		$this->child('status', 'html-'.$this->params['status-tag']);

		$this->parseParam('type', 'border');
		if (!in_array($this->params['type'], $this->type, true)) {
			$this->params['type'] = 'border';
		}
	}


	private function setAttributes()
	{
//		$this->setAttr();
		$this->setAttributeColor();
		$this->setAttributeHidden();
		$this->setAttributeSize();
		$this->setAttributeStatus();
		$this->setAttributeType();
	}


	private function setAttributeColor()
	{
		if (isset($this->params['color']) && in_array($this->params['color'], AVI_BS_COLOR, true)) {
			$this->attributes([
				'class' => [
					sprintf('text-%s', $this->params['color'])
				]
			]);
		}
	}


	private function setAttributeHidden()
	{
		if ($this->params['hidden']) {
			$this->attributes([
				'class' => [
					'd-none'
				]
			]);
			if ($this->params['status'] !== 'child') {
				$this->status->attributes([
					'class' => [
						'd-none'
					]
				]);
			}
		}
	}


	private function setAttributeSize()
	{
		if (isset($this->params['size']) && in_array($this->params['size'], AVI_BS_SIZE, true)) {
			$this->attributes([
				'class' => [
					sprintf('spinner-%s-%s', $this->params['type'], $this->params['size'])
				]
			]);
		}
	}


	private function setAttributeStatus()
	{
		if ($this->params['status-hidden']) {
			$this->status->attributes([
				'class' => [
					'visually-hidden'
				]
			]);
		}

		switch($this->params['status']) {
			case 'after':
			case 'before':
				$this->status->attributes([
					'role' => 'status'
				]);
				$this->attributes([
					'aria' => [
						'hidden' => 'true'
					]
				]);
				break;

			case 'child':
				$this->attributes([
					'role' => 'status'
				]);
				break;
		}
	}


	private function setAttributeType()
	{
		$this->attributes([
			'class' => [
				sprintf('spinner-%s', $this->params['type'])
			]
		]);
	}

/*
	protected function parseElementContent()
	{
		$this->params['text'] = $this->content;
		$this->setContent();
		return $this->content;
	}
*/

	private function setContent()
	{
		$this->use();

/*
		switch($this->params['status']) {
			case 'after':
				$content = $this->use();
				$this->tag = '';
				$this->content = [
					$content,
					$status
				];
				break;

			case 'before':
				$content = $this->use();
				$this->tag = '';
				$this->content = [
					$status,
					$content
				];
				break;

			case 'child':
				$this->content = $status;
				break;
		}
*/
	}


	public function use()
	{
		//content overwrite text attribute:
		$this->status->content(($this->content === '')? $this->params['text']: $this->content);

		//select template based on status position
		switch($this->params['status']) {
			case 'after':
				$template = '<{attributes}></{tag}>{status}';
				break;

			case 'before':
				$template = '{status}<{attributes}></{tag}>';
				break;

			case 'child':
			default:
				$template = '<{attributes}>{status}</{tag}>';
				break;
		}

		return \Avi\Tools::sprinta(
			$template,
			[
				'attributes' => $this->parseAttributes(),
				'content' => $this->parseContent(),
				'status' => $this->status->use(),
				'tag' => $this->tag
			]);
	}
}
