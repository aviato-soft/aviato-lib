<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.03
 * @since  2024-02-11 16:44:25
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsAlert extends HtmlElement
{
	protected $params;

	protected $tag = 'div';

	private $buttonClose = null;


	/**
	 * use default template:
	 * <i class="bs-icon bs-{slug}"></i>
	 *
	 * @param array|string $params can be a string re[resemting the bootstrap icon slug
	 * @return \Avi\HtmlElementBsIcon
	 */
	public function __construct(array|string $params = '')
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? $this->tag;

		$this->parseParam('dismissible');
		if($this->params['dismissible']) {
			$this->buttonClose = $this->element('BsButtonClose', [
				'dismiss' => 'alert'
			]);
		}
		$this->parseParam('text');
		$this->parseParam('variant');
	}


	private function setAttributes()
	{
		$this->setAttributesDismissible();
		$this->setAttributesVariant();
		$this->attributes([
			'class' => [
				'alert'
			],
			'role' => 'alert'
		]);
	}


	private function setAttributesDismissible()
	{
		if(!$this->params['dismissible']) {
			return;
		}

		$this->attributes([
			'class' => [
				'alert-dismissible',
				'fade',
				'show'
			]
		]);
	}


	private function setAttributesVariant()
	{
		if ($this->params['variant'] && in_array($this->params['variant'], array_merge(AVI_BS_COLOR, ['link']), true)) {
			$this->attributes([
				'class' => sprintf('alert-%s', $this->params['variant'])
			]);
		}
	}


	protected function parseElementContent($content)
	{
		$this->params['text'] = $content;
		$this->setContent();

		return $this->content;
	}


	private function setContent()
	{
		$content = (is_countable($this->params['text'])) ? $this->params['text'] : [$this->params['text']];

		if($this->params['dismissible']) {
			$content[] = $this->buttonClose->use();
		}

//		if (($this->params['debug'] ?? false) === true) {
//			var_dump($content);
//		}

		$this->content = implode('', $content);
	}
}
