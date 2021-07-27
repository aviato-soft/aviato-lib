<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 00.06.01
 * @since  2021-07-27 15:12:55
 *
 */
declare(strict_types = 1);
namespace Avi;

const AVI_MAJOR = '00';

const AVI_MINOR = '06';

const AVI_PATCH = '01';

const AVI_DATE = '2021-07-27 15:12:55';

const AVI_JS_MD5 = '4195aa75428858c7a06079f785730462';

/**
 * Version class
 *
 * @author aviato-vasile
 *
 */
class Version
{
	public static function get() {
		return AVI_MAJOR.'.'.AVI_MINOR.'.'.AVI_PATCH;
	}
}
?>