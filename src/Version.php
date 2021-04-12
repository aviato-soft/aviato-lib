<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright Aviato Soft
 * @license GNUv3
 * @version 00.04.03
 * @since  2021-04-12 16:54:26
 *
 */
declare(strict_types = 1);
namespace Avi;

const AVI_MAJOR = '00';

const AVI_MINOR = '04';

const AVI_PATCH = '03';

const AVI_DATE = '2021-04-12 16:54:26';

const AVI_JS_MD5 = 'bfd9bd8aeeebaa0a712ce7b72f115800';

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