<?php
/**
 * License
 *
 * @author Aviato Soft
 * @copyright Aviato Soft
 * @license GNUv3
 * @version 1.0.0
 * @since 2021
 *
 **/
declare(strict_types = 1);
namespace Avi;

const AVI_MAJOR = '@build-major@';

const AVI_MINOR = '@build-minor@';

const AVI_PATCH = '@build-patch@';

const AVI_DATE = '@datetime@';

const AVI_JS_MD5 = '@js-release-md5@';

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