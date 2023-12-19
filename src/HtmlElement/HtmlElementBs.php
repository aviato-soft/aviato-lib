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

use PHPUnit\Framework\ActualValueIsNotAnObjectException;

const AVI_BS_BREAKPOINT = [
	'xs',
	'sm',
	'md',
	'lg',
	'xl',
	'xxl'
];

const AVI_BS_COLOR = [
	'primary',
	'secondary',
	'success',
	'danger',
	'warning',
	'info',
	'light',
	'dark',
];

const AVI_BS_SIZE = [
	'sm',
	'lg'
];


class HtmlElementBs extends HtmlElement
{

}
