<?php

require_once("includes/cookie.php");
require_once("includes/template.php");

$body = new Template();
$body->set_template("login.html");
$body->add_key('errmsg','');
echo $body->create();

?>
