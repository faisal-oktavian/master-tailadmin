<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Daftar MIME minimal (cukup untuk upload foto Master Karyawan).
 * Boleh ditimpa dengan application/config/mimes.php bawaan CodeIgniter 3.1.13.
 */
return array(
    'jpg'  => array('image/jpeg', 'image/pjpeg'),
    'jpeg' => array('image/jpeg', 'image/pjpeg'),
    'jpe'  => array('image/jpeg', 'image/pjpeg'),
    'png'  => array('image/png', 'image/x-png'),
    'gif'  => 'image/gif',
    'webp' => 'image/webp',
);
