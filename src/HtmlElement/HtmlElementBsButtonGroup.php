<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.08
 * @since  2024-02-24 13:27:06
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once dirname(__DIR__).'/HtmlElement.php';
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsButtonGroup extends HtmlElement
{
	protected $params;

	public $items = [];

	/**
	 *
	 * @param array $params the values are optional and must be:

	 */
	public function __construct($params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}


	public function items($params)
	{
		$this->params['items'] = $params;
		$this->parseParams();
		$this->setContent();
		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? 'div';

		$this->parseParam('items', []);
		$this->parseItems();
		$this->parseParam('label', false);
		$this->parseParam('role', 'group');
		$this->parseParam('vertical', false);
	}


	private function parseItems()
	{
		foreach ($this->params['items'] as $bsButton) {
			if (is_a($bsButton, 'Avi\HtmlElement')) {
				$this->items[] = $bsButton;
			} else {
				if (is_countable($bsButton) || is_string($bsButton)) {
					$this->items[] = $this->element('BsButton', $bsButton);
				}
			}
		}
	}


	private function setAttributes()
	{
		$this->setAttributeLabel();
		$this->setAttributeRole();
		$this->setAttributeSize();

		$this->attributes([
			'class' => sprintf('btn-group%s', ($this->params['vertical'])? '-vertical': '')
		]);
	}


	private function setAttributeLabel()
	{
		if ($this->params['label'] !== false) {
			$this->attributes['aria']['label'] = $this->params['label'];
		}
	}


	private function setAttributeRole()
	{
		if($this->params['role'] !== false) {
			$this->attributes['role'] = $this->params['role'];
		}
	}


	private function setAttributeSize()
	{
		if (isset($this->params['size']) && in_array($this->params['size'], AVI_BS_SIZE, true)) {
			$this->attributes([
				'class' => sprintf('btn-group-%s', $this->params['size'])
			]);
		}
	}


	private function setContent()
	{
		$content = [];
		foreach ($this->items as $bsButton) {
			$content[] = $bsButton->use();
		}

		$this->content = $content;
	}
}

?>