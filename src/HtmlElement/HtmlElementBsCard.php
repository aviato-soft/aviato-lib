<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.00
 * @since  2024-02-06 21:30:40
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once __DIR__.'/HtmlElementBsItems.php';

class HtmlElementBsCard extends HtmlElementBsItems
{
	protected $prefix = 'Card';
	protected $tag = 'div';
/*
	//children:
	public $items;
*/
	protected $children = [
		'Body',
		'Footer',
		'Header',
		'Img',
	];

/**
 *
 * @param array $params
 * 			|- htmlElement
 * 			|- Bs[something]
 * 			|- BsCard[$children]
 * @return \Avi\HtmlElementBsCard
 */
	public function __construct($params = [], $parent = null)
	{
		parent::__construct($params);
		return $this;
	}


	protected function parseParams()
	{
		//params are items:
		//$this->params['items'] = $this->params;
		/*
		$this->tag = $this->params['tag'] ?? 'div';
		$this->items = [];

		foreach ($this->params as $param) {
			foreach($param as $type => $element) {
				if (is_a($element, 'Avi\HtmlElement')) {
					$this->items[] = $element;
					//echo $element->use();
				} else {
					if (substr($type, 0, 2) === 'Bs') {
						$this->items[] = $this->element($type, $element);
					} else {
						if (in_array($type, $this->children, true)) {
							$this->items[] = $this->element('BsCard'.ucfirst($type), $element);
						}
					}
				}
			}
		}
		*/
	}


	protected function parseItems()
	{
//		if (($this->params['debug'] ?? false) === true) {
//			print_r($this->params);
//			var_dump($this->items);
//		}
		/*
		$items = [];

		foreach ($this->params as $param) {
			foreach($param as $type => $element) {
				if (is_a($element, 'Avi\HtmlElement')) {
					$this->items[] = $element;
					//echo $element->use();
				} else {
					if (substr($type, 0, 2) === 'Bs') {
						$this->items[] = $this->element($type, $element);
					} else {
						if (in_array($type, $this->children, true)) {
							$this->items[] = $this->element('BsCard'.ucfirst($type), $element);
						}
					}
				}
			}
		}

		$this->items = $items;
		*/
	}


	protected function setAttributes()
	{
		$this->attributes([
			'class' => 'card'
		]);
	}


	protected function setContent()
	{
		parent::setContent();
/*
		$content = [];

		foreach ($this->items as $htmlElement) {
			if (is_a($htmlElement, 'Avi\HtmlElement')) {
				$content[] = $htmlElement->use();
			}
		}

		$this->content = $content;
*/
	}
}
