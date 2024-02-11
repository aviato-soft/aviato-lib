<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.
declare(strict_types = 1);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/'.$_ENV['APP_ENV'].'.php';

use PHPUnit\Framework\TestCase;
use Avi\HtmlElement as AviHtmlElement;

final class testAviatoHtmlElementBsPagination extends TestCase
{
	public function testFn_Empty(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = '<nav><ul class="pagination"></ul></nav>';
		$result = $aviHtmlElement->element('BsPagination')->use();
		$this->assertEquals($test, $result);
	}

	public function testFn_Full(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="disabled page-item"><a class="page-link">Previous</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 1,
			'count' => 3,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);
	}


	public function testFn_Smart(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		// ( 1) 2  3] ... [18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="disabled page-item"><a class="page-link">Previous</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 1,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 (2)  3  4] ... [18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=1">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=4">4</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 2,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 (3) 4 5] ... [18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=2">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=4">4</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=5">5</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=4">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 3,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 (4) 5 6] ... [18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=3">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=4">4</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=5">5</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=6">6</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=5">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 4,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 4 (5) 6 7] ... [18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=4">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=4">4</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=5">5</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=6">6</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=7">7</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=6">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 5,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 | 4 5 (6) 7 8] ... [18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=5">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=4">4</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=5">5</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=6">6</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=7">7</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=8">8</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=7">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 6,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 ] .. [5 6 (7) 8 9] ... [18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=6">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=5">5</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=6">6</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=7">7</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=8">8</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=9">9</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=8">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 7,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 ] .. [12 13 (14) 15 16] .. [18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=13">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=12">12</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=13">13</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=14">14</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=15">15</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=16">16</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=15">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 14,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 ] .. [13 14 (15) 16 17 18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=14">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=13">13</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=14">14</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=15">15</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=16">16</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=17">17</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=16">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 15,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 ] .. [14 15 (16) 17 18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=15">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=14">14</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=15">15</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=16">16</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=17">17</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=17">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 16,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 ] .. [15 16 (17) 18 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=16">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=15">15</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=16">16</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=17">17</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=18">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 17,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 ] .. [16 17 (18) 19 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=17">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=16">16</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=17">17</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 18,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 ] .. [17 18 (19) 20]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=18">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=17">17</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=20">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 19,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

		// [ 1 2 3 ] .. [18 19 (20)]
		$test = implode('', [
			'<nav>',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#page=19">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=1">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=2">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=3">3</a></li>',
			'<li class-fw="bold">&nbsp;...&nbsp;</li>',
			'<li class="page-item"><a class="page-link" href="#page=18">18</a></li>',
			'<li class="page-item"><a class="page-link" href="#page=19">19</a></li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#page=20">20</a></li>',
			'<li class="disabled page-item"><a class="page-link">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'active' => 20,
			'count' => 20,
			'href' => '#page={page}'
		])->use();
		$this->assertEquals($test, $result);

	}


	/**
	 * @see https://getbootstrap.com/docs/5.3/components/breadcrumb/
	 */
	public function testFn_Bootstrap(): void
	{
		$aviHtmlElement = new \Avi\HtmlElement();

		//Overview
		$test = implode('', [
			'<nav aria-label="Page navigation example">',
			'<ul class="pagination">',
			'<li class="page-item"><a class="page-link" href="#">Previous</a></li>',
			'<li class="page-item"><a class="page-link" href="#">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#">3</a></li>',
			'<li class="page-item"><a class="page-link" href="#">Next</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'attr' => [
				'aria' => [
					'label' => 'Page navigation example'
				]
			],
			'count' => 3,
			'href' => '#'
		])->use();
		$this->assertEquals($test, $result);

		$test = implode('', [
			'<nav aria-label="Page navigation example">',
			'<ul class="pagination">',
			'<li class="page-item">',
			'<a aria-label="Previous" class="page-link" href="#">',
			'<span aria-hidden="true">&laquo;</span>',
			'</a>',
			'</li>',
			'<li class="page-item"><a class="page-link" href="#">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#">3</a></li>',
			'<li class="page-item">',
			'<a aria-label="Next" class="page-link" href="#">',
			'<span aria-hidden="true">&raquo;</span>',
			'</a>',
			'</li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'attr' => [
				'aria' => [
					'label' => 'Page navigation example'
				]
			],
			'count' => 3,
			'controlls' => 'icons',
			'href' => '#'
		])->use();
		$this->assertEquals($test, $result);


		//Disabled and active states
		$test = implode('', [
			'<nav aria-label="...">',
			'<ul class="pagination">',
			'<li class="disabled page-item">',
			'<a class="page-link">Previous</a>',
			'</li>',
			'<li aria-current="page" class="active page-item">',
			'<a class="page-link" href="#">1</a>',
			'</li>',
			'<li class="page-item">',
			'<a class="page-link" href="#">2</a>',
			'</li>',
			'<li class="page-item">',
			'<a class="page-link" href="#">3</a>',
			'</li>',
			'<li class="page-item">',
			'<a class="page-link" href="#">Next</a>',
			'</li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'attr' => [
				'aria' => [
					'label' => '...'
				]
			],
			'active' => 1,
			'count' => 3,
			'href' => '#'
		])->use();
		$this->assertEquals($test, $result);


		$test = implode('', [
			'<nav aria-label="...">',
			'<ul class="pagination">',
			'<li class="disabled page-item">',
			'<span class="page-link">Previous</span>',
			'</li>',
			'<li aria-current="page" class="active page-item">',
			'<span class="page-link">1</span>',
			'</li>',
			'<li class="page-item">',
			'<a class="page-link" href="#">2</a>',
			'</li>',
			'<li class="page-item"><a class="page-link" href="#">3</a></li>',
			'<li class="page-item">',
			'<a class="page-link" href="#">Next</a>',
			'</li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'attr' => [
				'aria' => [
					'label' => '...'
				]
			],
			'active' => 1,
			'active-tag' => 'span',
			'count' => 3,
			'href' => '#'
		])->use();
		$this->assertEquals($test, $result);


		//Sizing
		$test = implode('', [
			'<nav aria-label="...">',
			'<ul class="pagination pagination-lg">',
			'<li aria-current="page" class="active page-item">',
			'<span class="page-link">1</span>',
			'</li>',
			'<li class="page-item"><a class="page-link" href="#">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#">3</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'attr' => [
				'aria' => [
					'label' => '...'
				]
			],
			'active' => 1,
			'active-tag' => 'span',
			'controlls' => false,
			'count' => 3,
			'href' => '#',
			'size' => 'lg'
		])->use();
		$this->assertEquals($test, $result);

		//Sizing
		$test = implode('', [
			'<nav aria-label="...">',
			'<ul class="pagination pagination-sm">',
			'<li aria-current="page" class="active page-item">',
			'<span class="page-link">1</span>',
			'</li>',
			'<li class="page-item"><a class="page-link" href="#">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#">3</a></li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'attr' => [
				'aria' => [
					'label' => '...'
				]
			],
			'active' => 1,
			'active-tag' => 'span',
			'controlls' => false,
			'count' => 3,
			'href' => '#',
			'size' => 'sm'
		])->use();
		$this->assertEquals($test, $result);


		//Alignment = center
		$test = implode('', [
			'<nav aria-label="Page navigation example">',
			'<ul class="justify-content-center pagination">',
			'<li class="disabled page-item">',
			'<a class="page-link">Previous</a>',
			'</li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#">3</a></li>',
			'<li class="page-item">',
			'<a class="page-link" href="#">Next</a>',
			'</li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'attr' => [
				'aria' => [
					'label' => 'Page navigation example'
				]
			],
			'active' => 1,
			'align' => 'center',
			'count' => 3,
			'href' => '#',
		])->use();
		$this->assertEquals($test, $result);

		//Alignment = right (end)
		$test = implode('', [
			'<nav aria-label="Page navigation example">',
			'<ul class="justify-content-end pagination">',
			'<li class="disabled page-item">',
			'<a class="page-link">Previous</a>',
			'</li>',
			'<li aria-current="page" class="active page-item"><a class="page-link" href="#">1</a></li>',
			'<li class="page-item"><a class="page-link" href="#">2</a></li>',
			'<li class="page-item"><a class="page-link" href="#">3</a></li>',
			'<li class="page-item">',
			'<a class="page-link" href="#">Next</a>',
			'</li>',
			'</ul>',
			'</nav>'
		]);
		$result = $aviHtmlElement->element('BsPagination', [
			'attr' => [
				'aria' => [
					'label' => 'Page navigation example'
				]
			],
			'active' => 1,
			'align' => 'end',
			'count' => 3,
			'href' => '#',
		])->use();
		$this->assertEquals($test, $result);
	}
}
