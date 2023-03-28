<?php
/**
 * Test purpose class
 *
 * @author aviato-vasile
 *
 */
class Sections
{


	public static function test()
	{
		echo 'test section';
	}


	public static function test8($a, $b)
	{
		printf('<pre>%s | %s</pre>', $a, $b);
	}
}
?>