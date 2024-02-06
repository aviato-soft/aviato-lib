<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.25
 * @since  2023-12-27 12:33:50
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsOffcanvas extends HtmlElement
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
	 * @return \Avi\HtmlElementBsOffcanvas
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


//		$this->parseParam('animation', 'fade');
		$this->parseParam('backdrop');
		$this->parseParam('breakpoint');
//		$this->parseParam('centred');
		$this->parseParam('closebutton', true);
//		$this->parseParam('footer');
//		$this->parseParam('fullscreen');
		$this->parseParam('id');
		$this->parseParam('placement');
//		$this->parseParam('size');
		$this->parseParam('title');
		$this->parseParam('scroll');
	}


	private function setAttributes()
	{
//		$this->setAttributesAnimation();
		$this->setAttributesBackdrop();
		$this->setAttributesId();
		$this->setAttributesPlacement();
		$this->setAttributesScroll();

//		$this->attributes['aria']['hidden'] = 'true';
		$this->attributes['class'][] = (in_array($this->params['breakpoint'], AVI_BS_BREAKPOINT, true)) ?
			sprintf('offcanvas-%s', $this->params['breakpoint']) :
			'offcanvas';
		$this->attributes['tabindex'] = '-1';

	}

/*
	private function setAttributesAnimation()
	{
		if($this->params['animation']) {
			$this->attributes['class'][] = $this->params['animation'];
		}
	}

*/
	private function setAttributesBackdrop()
	{
		if(!is_null($this->params['backdrop'])) {
			$this->attributes['data']['bs-backdrop'] = ($this->params['backdrop']) ? $this->params['backdrop'] : 'false';
//			$this->attributes['data']['bs-keyboard'] = 'false';
		}
	}


	private function setAttributesId()
	{
		if($this->params['id']) {
			$this->attributes['id'] = $this->params['id'];
			$this->attributes['aria']['labelledby'] = sprintf('%s-label', $this->params['id']);
		}
	}


	private function setAttributesPlacement()
	{
		if (!(in_array($this->params['placement'], ['start', 'end', 'top', 'bottom'], true))) {
			$this->params['placement'] = 'start';
		}
		$this->attributes['class'][] = sprintf('offcanvas-%s', $this->params['placement']);
	}


	private function setAttributesScroll()
	{
		if(!is_null($this->params['scroll'])) {
			$this->attributes['data']['bs-scroll'] = $this->params['scroll'] ? 'true' : 'false' ;
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
		$title = ($this->params['title']) ?
			$this->tag('h5', array_merge(
				[
					'class' => 'offcanvas-title'
				],
				($this->params['id']) ? [
					'id' => sprintf('%s-label', $this->params['id'])
				] : [])
			)->content($this->params['title']) : null;


		//Header
		$header = $this->tag('div', [
			'class' => [
				'offcanvas-header'
			]
		])->content([
			$title,
			($this->params['closebutton']) ? $this->element('BsButtonClose', array_merge([
				'dismiss' => 'offcanvas'],
				($this->params['id']) ? ['target' => sprintf('#%s', $this->params['id'])] : []
			))->use() : null
		]);


		//Body
		$body = $this->tag('div', [
			'class' => [
				'offcanvas-body'
			]
		])->content($this->params['body']);


		//Footer
//		$footer = ($this->params['footer']) ?
//			$this->tag('div', ['class'=>'modal-footer'])->content($this->params['footer']) :
//			null;


		$this->content = [
			$header,
			$body
		];
	}
}