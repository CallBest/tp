<?php

require_once("../includes/cookie.php");
require_once("../includes/template.php");

$body = new Template();
$cookie = new CookieInfo("TP_driver");

// check existing credentials before proceeding with tha application
// redirect to login if no valid credentials found 
if ($cookie->check()) {
  $cookie->getcookies();
  $userid = $cookie->array['userid'];
  $body->add_key('userid',$userid);
	$body->add_key('firstname',$cookie->array['userfn']);
	$body->add_key('lastname',$cookie->array['userln']);
//} else {
//  header('Location: index.php');
}

// set the header menu
$body->set_template("driver/header.html");
echo $body->create();

// set the main content
$page = isset($_REQUEST['show']) ? strtolower(str_replace("'","",$_REQUEST['show'])) : 'dashboard';
$body->add_key('mainpage',$_SERVER['SCRIPT_NAME']);
$body->add_key('workingfolder',$page);
switch($page){
  case 'print':
    $body->set_template("driver/clientinfo.html");
    break;
  default:
    if (isset($_REQUEST['deliveryid'])) {
      $body->set_template("driver/deliverydetails.html");
      include('driver/deliverydetails.php');
    } else {
      $body->set_template("driver/main.html");
      include('driver/main.php');
    }
}
echo $body->create();

// set the footer, if any.
$body->set_template("driver/footer.html");
echo $body->create();