<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.24.09
 * @since  2024-03-04 12:25:06
 *
 */
declare(strict_types = 1);
namespace Avi;

const AVI_MAJOR = '01';

const AVI_MINOR = '24';

const AVI_PATCH = '09';

const AVI_DATE = '2024-03-04 12:25:06';

const AVI_JS_MD5 = '39d3e6b6c1db65809b67b7c260252352';

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