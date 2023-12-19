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
require_once __DIR__.'/HtmlElementBs.php';

class HtmlElementBsButton extends HtmlElement
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
	 * @param array $params the values are optional and must be:
	 *        |- active = true|false
	 *        |- badge = HtmlElementBsSpinner properties
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
		$this->tag = $this->params['tag'] ?? 'button';
		if (!in_array($this->tag, $this->tags, true)) {
			$this->tag = 'button';
		}
//		if ($this->tag === 'a') {
//			$this->parseParam('href', 'javascript:;');
//		}

		$this->parseParam('type', 'button');
		if (!in_array($this->params['type'], $this->type, true)) {
			$this->params['type'] = 'button';
		}

		$this->child('badge', 'BsBadge');
		$this->child('icon', 'BsIcon');
		$this->child('spinner', 'BsSpinner');

		$this->parseParam('active', false);
		$this->parseParam('outline', false);
		$this->parseParam('toggle', false);

/*
		if (isset($this->params['spinner'])) {
			$this->spinner();
		}
*/
	}



/*
	private function icon()
	{
		if (is_string($this->params['icon'])) {
			if (\Avi\Tools::isEnclosedIn($this->params['icon'])) {
				$this->content[] = $this->params['icon'];
			} else {
				$this->icon = $this->element('BsIcon', [
					'slug' => $this->params['icon']
				]);
				$this->content[] = $this->icon->use();
			}
			return;
		}

		if (is_array($this->params['icon'])) {
			$this->content[] = $this->element('BsIcon', $this->params['icon'])->use();
		}
	}
*/


	private function setAttributes()
	{
		$this->setAttributeByTag();
		$this->setAttributeActive();
		$this->setAttributeDisabled();
		$this->setAttributeNowrap();
		$this->setAttributeSize();
		$this->setAttributeToggle();
		$this->setAttributeVariant();

		$this->attributes([
			'class' => 'btn'
		]);
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


	private function setAttributeNowrap()
	{
		if (isset($this->params['nowrap']) && $this->params['nowrap'] === true) {
			$this->attributes([
				'class' => 'text-nowrap'
			]);
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


	private function setAttributeVariant()
	{
		if (isset($this->params['variant'])
			&& in_array($this->params['variant'], array_merge(AVI_BS_COLOR, ['link']), true)
		) {
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

		if (isset($this->params['text'])) {
			if (is_array($this->params['text'])) {
				$this->params['text'] = implode('', $this->params['text']);
			}
			if ($content === []) {
				$content[] = $this->params['text'];
			}
			else {
				$content[] = $this->tag('span')->attributes([
					'class' => sprintf('ps-%s', (isset($this->params['size']) && $this->params['size'] === 'sm') ? 2: 3)
				])->content($this->params['text']);
			}
		} else {
			$content[] = $this->content;
		}

		//badge is the latest element
		if(is_a($this->badge, 'Avi\HtmlElementBsBadge')) {
			$content[] = $this->badge->use();
		}

		$this->content = $content;
	}

/*
	private function spinner()
	{
		if ($this->params['spinner'] === true) {
			$this->content[] = $this->element('BsSpinner', [
				'tag' => 'none',
				'size' => 'sm'
			])->use();
			return;
		}

		if (is_string($this->params['spinner'])) {
			if (\Avi\Tools::isEnclosedIn($this->params['spinner'])) {
				$this->content[] = $this->params['spinner'];
			} else {
				$this->content[] = $this->element('BsSpinner', [
					'tag' => 'none',
					'size' => 'sm',
					'text' => $this->params['spinner']
				])->use();
			}
			return;
		}

		if (is_array($this->params['spinner'])) {
			$this->content[] = $this->element('BsSpinner', $this->params['spinner'])->use();
		}
	}
*/


	private function text()
	{
		if ($this->tag === 'input') {
			$this->attributes([
				'value' => $this->params['text'],
			]);
		} else {
			if (isset($this->params['icon'])) {
				$this->content[] = $this->tag('span')->attributes([
					'class' => sprintf('ps-%s', (isset($this->params['size']) && $this->params['size'] === 'sm') ? 2: 3)
				])->content($this->params['text']);
			} else {
				$this->content[] = $this->params['text'];
			}
		}
	}
}

?>