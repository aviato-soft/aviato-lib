<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 00.22.21
 * @since  2022-05-06 13:05:19
 *
 */
declare(strict_types = 1);
namespace Avi;

const AVI_MAJOR = '00';

const AVI_MINOR = '22';

const AVI_PATCH = '21';

const AVI_DATE = '2022-05-06 13:05:19';

const AVI_JS_MD5 = 'caaacccf9e37c184875b8363098ca9b1';

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