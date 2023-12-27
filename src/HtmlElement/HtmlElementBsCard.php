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

require_once dirname(__DIR__).'/HtmlElement.php';

class HtmlElementBsCard extends HtmlElement
{
	protected $params;

	//children:
	public $items;

	private $chType = [
		'body',
		'footer',
		'header',
		'img',
	];

/**
 *
 * @param array $params
 * 			|- htmlElement
 * 			|- Bs[something]
 * 			|- BsCard[$chType]
 * @return \Avi\HtmlElementBsCard
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
						if (in_array($type, $this->chType, true)) {
							$this->items[] = $this->element('BsCard'.ucfirst($type), $element);
						}
					}
				}
			}
		}
	}


	private function setAttributes()
	{
		$this->attributes([
			'class' => 'card'
		]);
	}


	private function setContent()
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
