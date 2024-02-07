<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.00
 * @since  2024-02-06 21:30:40
 *
 */
declare(strict_types = 1);
namespace Avi;

const AVI_MAJOR = '01';

const AVI_MINOR = '24';

const AVI_PATCH = '00';

const AVI_DATE = '2024-02-06 21:30:40';

const AVI_JS_MD5 = '8ddfd723a45fba2ffe2e8bad5f8f6e54';

/**
 * Version class
 *
 * @author aviato-vasile
 *
 */
class Version
{


	/**
	 *
	 * @return string formated build version using notation {Major}.{Minor}.{Patch}
	 */
	public static function get()
	{
		return AVI_MAJOR.'.'.AVI_MINOR.'.'.AVI_PATCH;
	}


	/**
	 * Return MD5 hash of aviato.js
	 *
	 * @return string
	 */
	public static function getJsMd5()
	{
		return AVI_JS_MD5;
	}
}


?>