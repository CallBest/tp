<?php

require_once("../includes/cookie.php");
require_once("../includes/template.php");

$body = new Template();
$cookie = new CookieInfo("TP_delivery");

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
$body->set_template("delivery/header.html");
echo $body->create();

// set the main content
if (isset($_SERVER['HTTP_REFERER'])) {
  $body->add_key('refererpage',$_SERVER['HTTP_REFERER']);
} else {
  $body->add_key('refererpage','http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
}

$page = isset($_REQUEST['show']) ? strtolower(str_replace("'","",$_REQUEST['show'])) : 'add';
$body->add_key('mainpage',$_SERVER['SCRIPT_NAME']);
$body->add_key('workingfolder',$page);
switch($page){
  case 'billing':
    $body->set_template("delivery/billing.html");
    break;
  case 'view':
    $body->set_template("delivery/schedule.html");
    break;
  case 'add':
    if (isset($_REQUEST['orderid'])) {
      $body->set_template("delivery/adddeliveryschedule.html");
      include('delivery/adddeliveryschedule.php');
    } else {
      $body->set_template("delivery/adddelivery.html");
      include('delivery/adddelivery.php');
    }
    break;
  default:
    $body->set_template("delivery/adddelivery.html");
    include('delivery/adddelivery.php');
}
echo $body->create();

// set the footer, if any.
$body->set_template("delivery/footer.html");
echo $body->create();
