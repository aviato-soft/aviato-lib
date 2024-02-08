<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.02
 * @since  2024-02-08 14:50:12
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once __DIR__.'/HtmlElementBs.php';

abstract class HtmlElementBsItems extends HtmlElement
{
	protected $params;
	protected $prefix = '';

	public $items;

	protected $child; //= default item type
	protected $children = []; //= list of allowed item type
	protected $tag = 'div';


	public function __construct(array|string $params = '', $parent = null)
	{
		$this->params = $params;
		$this->parent = $parent;
		$this->privateParseParams();
		$this->setAttributes();
		$this->setContent();

		return $this;
	}


	abstract protected function parseItems();
	abstract protected function parseParams();
	abstract protected function setAttributes();


	private function privateParseParams()
	{
		$this->tag = $this->params['tag'] ?? $this->tag;

		$this->parseParams();
		$this->privateParseItems();
		$this->parseItems();
	}


	private function privateParseItems()
	{
		$this->items = [];
		$this->parseParam('items', []);
// - not tested feature
//		if (!is_countable($this->params['items'])) {
//			return;
//		}


		foreach($this->params['items'] as $item) {
			if(!is_array($item)) {
				if(is_a($item, 'Avi\HtmlElement')) {
					$this->items[] = $this->parseItemElement($item);
				}

				continue;
			}

			foreach ($item as $type => $element) {
				if(is_numeric($type)) {
					if(is_a($element, 'Avi\HtmlElement')) {
						$this->items[] = $this->parseItemElement($element);
					}
					continue;
				}

				if (substr($type, 0, 2) === 'Bs') {
					$this->items[] = $this->parseItemElement($this->element($type, $element));
					continue;
				}

				if (in_array(ucfirst($type), $this->children, true)) {
					if(is_string($element)) {
						$element = [
							'content' => $element
						];
					}
					$element['parent'] = $this->params['parent'] ?? null;
					$this->items[] = $this->parseItemElement($this->element('Bs'.$this->prefix.ucfirst($type), $element));
					continue;
				}
			}
		}

		return;
	}


	private function parseItemElement($htmlElement)
	{
		$item = $htmlElement;
		$item->parent = $this;
		return $item;
	}


	protected function parseElementContent($content = null)
	{
		if (is_array($content)) {
			$this->params['items'] = $content;
			$this->privateParseParams();
			$this->setContent();
		}

		return $this->content;
	}


	protected function setContent()
	{
		$content = [];

		foreach ($this->items as $htmlElement) {
			if (is_a($htmlElement, 'Avi\HtmlElement')) {
				$content[] = $htmlElement->use();
			}
		}

		$this->content = $content;
	}

}
