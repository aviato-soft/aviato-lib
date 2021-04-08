<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright Aviato Soft
 * @license GNUv3
 * @version 00.04.02
 * @since  2021-04-08 08:48:41
 *
 */
declare(strict_types = 1);
namespace Avi;

const AVI_MAJOR = '00';

const AVI_MINOR = '04';

const AVI_PATCH = '01';

const AVI_DATE = '2021-04-07 23:02:58';

const AVI_JS_MD5 = '5536d9b3b0e82aa4f53c2f1919157363';

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