<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title><?php echo $heading; ?></title>
<style>
  body{font-family:Outfit,Arial,sans-serif;background:#f9fafb;color:#344054;margin:0;display:flex;min-height:100vh;align-items:center;justify-content:center}
  .box{max-width:520px;padding:40px;background:#fff;border:1px solid #e4e7ec;border-radius:16px;text-align:center}
  h1{margin:0 0 12px;font-size:24px;color:#101828} p{margin:0 0 20px;line-height:1.6}
  a{color:#465fff;text-decoration:none;font-weight:500}
</style>
</head>
<body>
  <div class="box">
    <h1><?php echo $heading; ?></h1>
    <?php echo $message; ?>
    <p><a href="javascript:history.back()">&larr; Kembali</a></p>
  </div>
</body>
</html>
