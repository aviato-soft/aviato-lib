<?php
// Copyright 2014-present Aviato Soft. All Rights Reserved.

declare(strict_types = 1);

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Avi\Tracker as AviTracker;

final class testAviatoTracker extends TestCase
{
	public function testFn_Parse(): void
	{
		$patternFile = dirname(__FILE__) . '/assets/tracker-googleTagManagerHead.html';
		$tracker = new AviTracker($patternFile, [], 'invalid');
		$expected = '';
		$result = $tracker -> parse();
		$this->assertEquals($expected, $result);
	}


	public function testFn_Dispatch(): void
	{
		$params = [
			'{GTM-ID}' => 'GTM-AVI123'
		];
		$patternFile = dirname(__FILE__) . '/assets/tracker-googleTagManagerHead.html';
		$expected  = "<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-AVI123');</script>
<!-- End Google Tag Manager -->";

		ob_start();
		$tracker = new AviTracker($patternFile, $params);
		$tracker -> dispatch();

		$result = ob_get_clean();

		$this->assertEquals($expected, $result);
	}
}

?>