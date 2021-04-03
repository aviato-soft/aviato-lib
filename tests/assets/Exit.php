<?php
function shutdown()
{
	// This is our shutdown function, in
	// here we can do any last operations
	// before the script is complete.
	$message = ob_get_contents(); // Capture 'Doh'
	ob_end_clean(); // Cleans output buffer

	return $message;
}

register_shutdown_function('shutdown');