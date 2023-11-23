<?php
use Avi\HtmlElement;

class HtmlElementButton extends HtmlElement
{
	private $properties;

	public function __construct(array $properties)
	{
		$this->tag = 'button';
		$this->properties = $properties;
		$this->attributes([
			'class' => 'btn'
		], false);

		$this->content = implode('', [
			$this->properties['label']
		]);
	}
}
?>