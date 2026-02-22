<?php

namespace Haski\Models;

/**
 * The exception thrown when the Haski Client recieves an error from the API.
 */
class HaskiException extends \Exception {
	var $message;
	var $httpStatusCode;
	var $haskiApiErrorCode;
}

?>
