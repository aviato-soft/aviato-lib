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

const AVI_MAJOR = '01';

const AVI_MINOR = '24';

const AVI_PATCH = '06';

const AVI_DATE = '2024-02-18 13:08:57';

const AVI_JS_MD5 = '79bf0d6c13fdce3f98bd0a5b2dc86b85';

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