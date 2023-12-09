<?php
require_once dirname(__DIR__).'HtmlElement.php';


class HtmlElementBsButton extends HtmlElement
{

	public function __construct($param) {
		$this->tag = 'button';
		$this->attributes([
			'type' => 'button',
			'class' => 'btn'
		]);
	}
}
?>