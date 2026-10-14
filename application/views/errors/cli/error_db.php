<?php defined('BASEPATH') OR exit('No direct script access allowed');
echo "\nERROR: ", isset($heading) ? $heading : 'Error', "\n\n", isset($message) ? strip_tags($message) : '', "\n";
