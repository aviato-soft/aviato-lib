<?php
/*
 * License
 *
 * @author Aviato Soft
 * @copyright 2014-present Aviato Soft. All Rights Reserved.
 * @license GNUv3
 * @version 01.23.06
 * @since  2023-02-21 17:01:38
 *
 */
declare(strict_types = 1);
namespace Avi;

const AVI_MAJOR = '01';

const AVI_MINOR = '23';

const AVI_PATCH = '06';

const AVI_DATE = '2023-02-21 17:01:38';

const AVI_JS_MD5 = '316fab9b63196beb9de42c7cac9c7bec';

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