<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.01
 * @since  2024-02-07 19:54:26
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsCardBody extends HtmlElement
{
	protected $params;

	public $title;
	public $subtitle;
	public $text;

	/**
	 *
	 * @param array $params
	 * 			|- title
	 * 			|- subtitle
	 * 			|- img
	 * 			|- text
	 * 			|- items = [strings]
	 * @return \Avi\HtmlElementBsCardBody
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
		$this->tag = 'div';

		$this->parseParam('overlay', false);

		$this->child('title', 'html-h5', [
			'class' => [
				'card-title'
			]
		]);

		$this->child('subtitle', 'html-h6', [
			'class' => [
				'card-subtitle'
			]
		]);

		$this->child('text', 'html-p', [
			'class' => [
				'card-text'
			]
		]);

		$this->parseParam('items', []);

	}


	private function setAttributes()
	{
		if ($this->params['overlay'] === 'img') {
			$this->attributes['class'] = ['card-img-overlay'];
		} else {
			$this->attributes['class'] = ['card-body'];
		}
	}


	private function setContent()
	{
		$content = [];

		//title
		if (is_a($this->title, 'Avi\HtmlElement')) {
			if(is_string($this->params['title'])) {
				$content[] = $this->title->content($this->params['title']);
			} else {
				$content[] = $this->title->content($this->params['title']['text']);
			}
		}

		//subtitle
		if (is_a($this->subtitle, 'Avi\HtmlElement')) {
			if (is_string($this->params['subtitle'])) {
				$content[] = $this->subtitle->content($this->params['subtitle']);
			} else {
				$content[] = $this->subtitle->content($this->params['subtitle']['text']);
			}
		}

		//text
		if (is_a($this->text, 'Avi\HtmlElement')) {
			if (is_string($this->params['text'])) {
				$content[] = $this->text->content($this->params['text']);
			} else {
				$content[] = $this->text->content($this->params['text']['text']);
			}

		}

		//items
		$content = array_merge($content, $this->params['items']);

		$this->content = $content;
	}
}
