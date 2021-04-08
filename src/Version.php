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

const AVI_PATCH = '02';

const AVI_DATE = '2021-04-08 08:48:41';

const AVI_JS_MD5 = 'd41208fe05121135fcfafd65be89529f';

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