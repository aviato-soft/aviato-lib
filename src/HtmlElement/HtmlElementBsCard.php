<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.24
 * @since  2023-12-15 18:03:04
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';

class HtmlElementBsCard extends HtmlElement
{
	protected $params;

	//children:
	public $img;
	public $body;
	public $title;
	public $text;
	public $subtitle;
	public $link;


	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();

		$this->attributes([
			'class' => 'card'
		]);
		$this->setContent();
//		$this->use();
		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? 'div';

		$this->child('img', 'html-img', [
			'class' => [
				'card-img-top'
			]
		]);

		$this->child('body', 'html-div', [
			'class' => [
				'card-body'
			]
		]);

		$this->child('title', 'html-h5', [
			'class' => [
				'card-title'
			]
		]);

		$this->child('text', 'html-p', [
			'class' => [
				'card-text'
			]
		]);
	}


	private function setContent()
	{
		$this->content = [];

		if(is_a($this->img, 'Avi\HtmlElement')) {
			$this->content[] = $this->img->use();
		}

		$bodyContent = [];

		if(is_a($this->title, 'Avi\HtmlElement')) {
			$bodyContent[] = $this->title->content($this->params['title']);
		}

		if(is_a($this->text, 'Avi\HtmlElement')) {
			$bodyContent[] = $this->text->content($this->params['text']);
		}

//		print_r($bodyContent);
		if(is_a($this->body, 'Avi\HtmlElement')) {
			$bodyContent[] = implode('', $this->params['body']);
			$this->content[] = $this->body->content($bodyContent);
		} else {
			$this->content[] = implode('', $bodyContent);
		}

	}


}
