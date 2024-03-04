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

require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsModal extends HtmlElement
{
	protected $params;
	protected $tag = 'div';

	/**
 	 *
 	 * @param array $params
	 *
	 * @param array $params
	 *
	 * @param \Avi\HtmlElement|null $parent
	 *
	 * @return \Avi\HtmlElementBsModal
	 */
	public function __construct($params = [], $parent = null)
	{
		$this->params = $params;
		$this->parent = $parent;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();

		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? $this->tag;

		$this->parseParam('body');

		$this->parseParam('animation', 'fade');
		$this->parseParam('backdrop');
		$this->parseParam('centred');
		$this->parseParam('closebutton', true);
		$this->parseParam('footer');
		$this->parseParam('fullscreen');
		$this->parseParam('id');
		$this->parseParam('size');
		$this->parseParam('title');
		$this->parseParam('scrollable');
	}


	private function setAttributes()
	{
		$this->setAttributesAnimation();
		$this->setAttributesBackdrop();
		$this->setAttributesId();

		$this->attributes['aria']['hidden'] = 'true';
		$this->attributes['class'][] = 'modal';
		$this->attributes['tabindex'] = '-1';

	}


	private function setAttributesAnimation()
	{
		if($this->params['animation']) {
			$this->attributes['class'][] = $this->params['animation'];
		}
	}


	private function setAttributesBackdrop()
	{
		if($this->params['backdrop']) {
			$this->attributes['data']['bs-backdrop'] = $this->params['backdrop'];
			$this->attributes['data']['bs-keyboard'] = 'false';
		}
	}


	private function setAttributesId()
	{
		if($this->params['id']) {
			$this->attributes['id'] = $this->params['id'];
			$this->attributes['aria']['labelledby'] = sprintf('%s-label', $this->params['id']);
		}
	}


	protected function parseElementContent($content = null)
	{
		if ($content) {
			$this->params['body'] = $content;
			$this->parseParams();
			$this->setContent();
		}

		return $this->content;
	}


	private function setContent()
	{
		//Title
		if ($this->params['title']) {
			$title = $this->tag('h5', [
				'class' => 'modal-title'
			]);

			if ($this->params['id']) {
				$title->attributes([
					'id' => sprintf('%s-label', $this->params['id'])
				]);
			}

			$title = $title->content($this->params['title']);

		} else {
			$title = null;
		}


		//Header
		$header = $this->tag('div', [
			'class' => [
				'modal-header'
			]
		])->content([
			$title,
			($this->params['closebutton']) ? $this->element('BsButtonClose', [
				'dismiss' => 'modal'
			])->use() : null
		]);


		//Body
		$body = $this->tag('div', [
			'class' => [
				'modal-body'
			]
		])->content($this->params['body']);


		//Footer
		$footer = ($this->params['footer']) ?
			$this->tag('div', ['class'=>'modal-footer'])->content($this->params['footer']) :
			null;


		//Dialog
		$this->content = $this->tag('div', [
			'class' => array_merge(
					['modal-dialog'],
					(($this->params['centered'] ?? false) === true) ? ['modal-dialog-centered'] : [],
					(($this->params['fullscreen'] ?? false) === true) ? ['modal-fullscreen'] : [],
					(in_array(($this->params['fullscreen'] ?? false), AVI_BS_BREAKPOINT, true)) ? [sprintf('modal-fullscreen-%s-down', $this->params['fullscreen'])] : [],
					(($this->params['scrollable'] ?? false) === true) ? ['modal-dialog-scrollable'] : [],
					(in_array(($this->params['size'] ?? false), ['sm', 'lg', 'xl'], true)) ? [sprintf('modal-%s', $this->params['size'])] : []
			)
		])->content($this->tag('div', [
			'class' => 'modal-content'
		])->content([$header, $body, $footer])
		);
	}
}