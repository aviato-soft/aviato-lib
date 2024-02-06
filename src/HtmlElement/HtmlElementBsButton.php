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

require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsButton extends HtmlElementBs
{
	protected $params;
	private $tags = [
		'a',
		'btn',
		'input'
	];
	private $type = [
		'button',
		'submit',
		'reset'
	];

	public $badge;
	public $icon;
	public $spinner;

	/**
	 *
	 * @param array|string $params the values are optional and must be:
	 *        |- active = true|false
	 *        |- badge = HtmlElementBsBadge properties
	 *        |- disabled = true|false
	 *        |- icon = bs icon name | HtmlElementBsIcon properties
	 *        |- nowrap = true|false
	 *        |- size = $size
	 *        |- spinner = HtmlElementBsSpinner properties
	 *        |- tag = $tags
	 *        |- text = string
	 *        |- toggle - true|false
	 *        |- type = $type
	 *        |- variant = BS_COLORS + link
	 */
	public function __construct(array|string $params = [])
	{
		$this->params = $params;
		$this->parseParams();
		$this->setAttributes();
		$this->setContent();
		return $this;
	}


/**
 * Child: badge
 * @param null|string|array $params
 *        |- bg-color = background color = an element of AVI_BS_COLOR
 *        |- color = textcolor = an element of AVI_BS_COLOR
 *        |- pill = rounded margins like a pill = true | false
 *        |- text = string
 * @return \Avi\HtmlElementBsButton
 */
	public function badge(array|string $params)
	{
		$this->params['badge'] = $params;
		$this->parseParams();
		$this->setContent();
		return $this;
	}


	public function icon($params)
	{
		$this->params['icon'] = $params;
		$this->parseParams();
		$this->setContent();
		return $this;
	}


	public function spinner($params)
	{
		$this->params['spinner'] = $params;
		$this->parseParams();
		$this->setContent();
		return $this;
	}


	private function parseParams()
	{
		$this->tag = $this->params['tag'] ?? 'button';
		if (!in_array($this->tag, $this->tags, true)) {
			$this->tag = 'button';
		}

		$this->parseParam('text', '');

//		if ($this->tag === 'a') {
//			$this->parseParam('href', 'javascript:;');
//		}

		$this->parseParam('type', 'button');
		if (!in_array($this->params['type'], $this->type, true)) {
			$this->params['type'] = 'button';
		}

		$this->parseParam('active', false);
		$this->parseParam('id', false);
		$this->parseParam('nowrap', false);
		$this->parseParam('outline', false);
		$this->parseParam('toggle', false);
		$this->parseParam('variant');

		$this->child('badge', 'BsBadge');
		$this->child('icon', 'BsIcon');
		$this->child('spinner', 'BsSpinner');
	}


	private function setAttributes()
	{
		$this->setAttributeByTag();
		$this->setAttributeActive();
		$this->setAttributeDisabled();
		$this->setAttributeId();
		$this->setAttributeNowrap();
		$this->setAttributeSize();
		$this->setAttributeToggle();
		$this->setAttributeVariant();

		$this->attributes([
			'class' => 'btn'
		]);
	}


	private function setAttributeActive()
	{
		if ($this->params['active']) {
			$this->attributes([
				'aria' => [
					'pressed' => 'true'
				],
				'class' => [
					'active'
				]
			]);
		}
	}


	private function setAttributeByTag()
	{
		if ($this->tag === 'a') {
			$this->attributes['role'] = 'button';
			if (isset($this->params['href'])) {
				$this->attributes['href'] = $this->params['href'];
			}
		} else {
			$this->attributes['type'] = $this->params['type'];
		}
	}


	private function setAttributeDisabled()
	{
		if (isset($this->params['disabled']) && $this->params['disabled'] === true) {
			if ($this->tag === 'a') {
				$this->attributes([
					'class' => 'disabled',
					'aria' => [
						'disabled' => 'true'
					],
				]);
				if(isset($this->attributes['href'])) {
					$this->attributes['tabindex'] = '-1';
				}
			} else {
				$this->attributes([
					'disabled'
				]);
			}
		}
	}


	private function setAttributeId()
	{
		if($this->params['id'] !== false) {
			$this->attributes['id'] = $this->params['id'];
		}
	}


	private function setAttributeNowrap()
	{
		if ($this->params['nowrap'] === true) {
			$this->setAttrClass('text-nowrap');
		}
	}


	private function setAttributeSize()
	{
		if (isset($this->params['size']) && in_array($this->params['size'], AVI_BS_SIZE, true)) {
			$this->attributes([
				'class' => sprintf('btn-%s', $this->params['size'])
			]);
		}
	}


	private function setAttributeToggle()
	{
		if ($this->params['toggle']) {
			$this->attributes([
				'data' => [
					'bs-toggle' => 'button'
				]
			]);
		}
	}


	private function setAttributeVariant()
	{
		if ($this->params['variant'] && in_array($this->params['variant'], array_merge(AVI_BS_COLOR, ['link']), true)) {
			$this->attributes([
				'class' => sprintf('btn%s-%s', ($this->params['outline']) ? '-outline' : '', $this->params['variant'])
			]);
		}
	}


	private function setContent()
	{
		$content = [];
		if(is_a($this->icon, 'Avi\HtmlElementBsIcon')) {
			$content[] = $this->icon->use();
		}

		if(is_a($this->spinner, 'Avi\HtmlElementBsSpinner')) {
			$content[] = $this->spinner->use();
		}

		if (isset($this->params['text']) && $this->params['text'] !== '') {
			if (is_array($this->params['text'])) {
				$this->params['text'] = implode('', $this->params['text']);
			}
			if ($content === []) {
				$content[] = $this->params['text'];
			}
			else {
				$content[] = $this->tag('span', null, true, new \Avi\HtmlElement)->attributes([
					'class' => sprintf('ps-%s', (isset($this->params['size']) && $this->params['size'] === 'sm') ? 2: 3)
				])->content($this->params['text']);
			}
		}

		//badge is the latest element
		if(is_a($this->badge, 'Avi\HtmlElementBsBadge')) {
			$content[] = $this->badge->use();
		}

		$this->content = $content;
	}
}

?>