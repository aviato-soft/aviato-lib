<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.20
 * @since  2023-11-23 16:27:51
 *
 */
declare(strict_types = 1);
namespace Avi;

const AVI_MAJOR = '01';

const AVI_MINOR = '23';

const AVI_PATCH = '20';

const AVI_DATE = '2023-11-23 16:27:51';

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