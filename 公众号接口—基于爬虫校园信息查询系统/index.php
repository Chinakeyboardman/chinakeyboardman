<?php

@header("http/1.1 404 not found");
@header("status: 404 not found");
@header("X-Powered-By: none");
$filename=explode('/',$_SERVER['PHP_SELF']);
$filename=end($filename);
@header("location: ".str_replace("index", "lndex", $filename));
#lndex.php
exit();

?>