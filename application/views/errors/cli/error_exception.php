<?php defined('BASEPATH') OR exit('No direct script access allowed');
echo "\nException: ", get_class($exception), "\n", $message, "\n", $exception->getFile(), ':', $exception->getLine(), "\n";
