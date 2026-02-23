<?php

namespace Haskimail\Models;

/**
 * The exception thrown when the Haskimail Client recieves an error from the API.
 */
class HaskimailException extends \Exception {
	var $message;
	var $httpStatusCode;
	var $haskiApiErrorCode;
}

?>
