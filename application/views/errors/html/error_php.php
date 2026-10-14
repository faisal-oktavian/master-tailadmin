<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="border:1px solid #fda29b;background:#fef3f2;color:#912018;padding:12px 20px;margin:10px;font-family:monospace;border-radius:8px">
<h4>Terjadi error PHP</h4>
<p>Severity: <?php echo $severity; ?></p>
<p>Message: <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>
</div>
