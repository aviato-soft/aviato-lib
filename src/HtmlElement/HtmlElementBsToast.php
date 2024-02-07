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

class HtmlElementBsToast extends HtmlElement
{
	protected $params;
	protected $tag = 'div';

	public $body;
	public $header;
	public $title;
	public $info;
	public $icon;


	public function __construct(array|string $params = '')
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}

/*
	public function info($params)
	{
		$this->params['info'] = $params;
		$this->parseParams();
		$this->setContent();
		return $this;
	}
*/

	protected function parseElementContent($content = null)
	{
		if ($content) {
			$this->params['body'] = $content;
			$this->parseParams();
			$this->setContent();
		}
		return $this->content;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? $this->tag;

		$this->parseParam('body', '');

		$this->parseParam('autohide');
		$this->parseParam('delay');
		$this->parseParam('header', '');
		$this->parseParam('role', 'alert');

		$this->child('body', 'html-div', [
			'class' => 'toast-body'
		]);
		$this->child('header', 'html-div', [
			'class' => 'toast-header'
		]);
		$this->child('icon', 'BsIcon');
		$this->child('info', 'html-small');
		$this->child('title', 'html-strong', [
			'class' => 'me-auto'
		]);
	}


	private function setAttributes()
	{
		$this->setAttributesAutohide();
		$this->setAttributesRole();
		$this->setAttributesTimeoutDelay();

		$this->attributes['aria']['atomic'] = 'true';
		$this->attributes['class'][] = 'toast';
	}


	private function setAttributesAutohide()
	{
		if($this->params['autohide']) {
			$this->attributes['data']['bs-autohide'] = 'true';
		}
	}


	private function setAttributesRole()
	{
		if (!in_array($this->params['role'], ['alert', 'status'])) {
			$this->params['role'] = 'alert';
		}
		$this->attributes['role'][] = $this->params['role'];

		$this->attributes['aria']['live'] = ($this->params['role'] === 'alert') ? 'assertive': 'polite';
	}


	private function setAttributesTimeoutDelay()
	{
		if ($this->params['autohide'] && is_int($this->params['delay'])) {
			$this->attributes['data']['bs-delay'] = strval($this->params['delay']);
		}
	}


	private function setContent()
	{
		$content = [];

		$header = [];
		if(is_a($this->icon, 'Avi\HtmlElementBsIcon')) {
			$header[] = $this->icon->use();
		}
		if(is_a($this->title, 'Avi\HtmlElement')) {
			$header[] = $this->childContent('title');
		}
		if(is_a($this->info, 'Avi\HtmlElement')) {
			$header[] = $this->childContent('info');
		}
		if ($header !== []) {
			$header[] = $this->element('BsButtonClose', [
				'dismiss' => 'toast'
			])->use();

			$content[] = $this->header->content($header);
		}

		$content[] = $this->childContent('body');

		$this->content = $content;
	}
}