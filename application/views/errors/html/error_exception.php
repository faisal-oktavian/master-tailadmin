<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="border:1px solid #fda29b;background:#fef3f2;color:#912018;padding:12px 20px;margin:10px;font-family:monospace;border-radius:8px">
<h4>Exception: <?php echo get_class($exception); ?></h4>
<p>Message: <?php echo $message; ?></p>
<p>Filename: <?php echo $exception->getFile(); ?></p>
<p>Line Number: <?php echo $exception->getLine(); ?></p>
</div>
