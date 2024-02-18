<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.06
 * @since  2024-02-18 13:08:57
 *
 */
declare(strict_types = 1);
namespace Avi;

require_once __DIR__.'/HtmlElementBsItems.php';

class HtmlElementBsCarousel extends HtmlElementBsItems
{

	protected $tag = 'div';

	private $indicators;
/**
 *
 * @param array $params
 * @return \Avi\HtmlElementBsBreadcrumb
 */
	public function __construct($params = [], $parent = null)
	{
		parent::__construct($params);
		return $this;
	}




	protected function parseParams()
	{
		$this->parseParam('id', 'carousel-id');
		$this->parseParam('autoplay');
		$this->parseParam('controls', true);
		$this->parseParam('fade');
		$this->parseParam('indicators');
		$this->parseParam('touch', true);
	}




/**
 * Items:
 * 		|- href
 * 		|- active
 * 		|- text
 * {@inheritDoc}
 * @see \Avi\HtmlElementBsItems::parseItems()
 */
	protected function parseItems()
	{
		$items = [];
		$indicators = [];

		if (!is_countable($this->params['items']) || count($this->params['items']) === 0) {
			return $items;
		}

		$isActive = false;
		foreach($this->params['items'] as $k => $param) {
			$img = $this->tag('img', [
				'alt' => $param['alt'] ?? sprintf('carousel picture %s', $k),
				'class' => [
					'd-block',
					'w-100'
				],
				'src' => $param['src'],
			]);

			$caption = ($param['caption'] ?? false) ? $this->tag('div', [
				'class' => [
					'carousel-caption',
					'd-none',
					'd-md-block'
				]
			])->content($param['caption']) : null;

			$item = $this->tag('div', [
				'class' => [
					'carousel-item'
				]
			])->content([
				$img->use(),
				$caption
			], true);

			if($param['interval'] ?? false) {
				$item->attributes([
					'data' => [
						'bs-interval' => $param['interval']
					]
				]);
			}

			$indicator = $this->tag('button', [
				'aria' => [
					'label' => sprintf('Slide %s', $k + 1)
				],
				'data' => [
					'bs-slide-to' => $k,
					'bs-target' => '#'.$this->params['id']
				],
				'type' => 'button'
			]);

/* - not needed because alwais the 1st element is visible
			if(($param['active'] ?? false) === true) {
				$isActive = true;
				$item->attributes([
					'class' => [
						'active'
					]
				]);

				$indicator->attributes([
					'aria' => [
						'current' => 'true'
					],
					'class' => [
						'active'
					],
				]);
			}
*/
			$items[] = $item;
			$indicators[] = $indicator;
		}

		//if none is active mark 1st item as active
		if(!$isActive) {
			$items[0]->attributes([
				'class' => [
					'active'
				]
			]);
			$indicators[0]->attributes([
				'aria' => [
					'current' => 'true'
				],
				'class' => [
					'active'
				],
			]);
		}

		$this->items = $items;
		$this->indicators = $indicators;
	}


	protected function setAttributes()
	{
		$this->setAttributeByParam('id');
		$this->setAttributesAutoplay();
		$this->setAttributesFade();
		$this->setAttributesTouch();

		$this->attributes['class'][] = 'carousel';
		$this->attributes['class'][] = 'slide';
	}



	protected function setContent()
	{
		parent::setContent();

		$content = [];

		//indicators
		if(($this->params['indicators'] ?? false) === true) {
			$indicators = [];
			foreach ($this->indicators as $indicator) {
				$indicators[] = $indicator->use();
			}

			$content[] = $this->tag('div', [
				'class' => [
					'carousel-indicators'
				]
			])->content($indicators);
		}

		//inner pictures
		$content[] = $this->tag('div', [
				'class' => 'carousel-inner'
			])
			->content($this->content);

		//controls
		if($this->params['controls'] === true) {
			$content[] = $this->tag('button', [
				'class' => [
					'carousel-control-prev'
				],
				'data' => [
					'bs-target' => '#'.$this->params['id'],
					'bs-slide' => 'prev'
				],
				'type' => 'button'
			])->content([
				$this->tag('span', [
					'aria' => [
						'hidden' => 'true'
					],
					'class' => [
						'carousel-control-prev-icon'
					]
				])->use(),
				$this->tag('span', [
					'class' => [
						'visually-hidden'
					]
				])->content('Previous'),
			]);

			$content[] = $this->tag('button', [
				'class' => [
					'carousel-control-next'
				],
				'data' => [
					'bs-target' => '#'.$this->params['id'],
					'bs-slide' => 'next'
				],
				'type' => 'button'
			])->content([
				$this->tag('span', [
					'aria' => [
						'hidden' => 'true'
					],
				'class' => [
						'carousel-control-next-icon'
					]
				])->use(),
				$this->tag('span', [
					'class' => [
						'visually-hidden'
					]
				])->content('Next'),
			]);
		}

		$this->content = $content;
	}


	private function setAttributesFade()
	{
		if($this->params['fade'] === true) {
			$this->setAttrClass('carousel-fade');
		}
	}


	private function setAttributesAutoplay()
	{
		if($this->params['autoplay']) {
			$this->attributes['data']['bs-ride'] = $this->params['autoplay'];
		}
	}


	private function setAttributesTouch()
	{
		if($this->params['touch'] === false) {
			$this->attributes['data']['bs-touch'] = "false";
		}
	}
}

