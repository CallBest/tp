<?php

require_once("../includes/cookie.php");
require_once("../includes/template.php");

$body = new Template();
$cookie = new CookieInfo("TP_sales");

// check existing credentials before proceeding with tha application
// redirect to login if no valid credentials found 
if ($cookie->check()) {
  $cookie->getcookies();
  $userid = $cookie->array['userid'];
  $body->add_key('userid',$userid);
	$body->add_key('firstname',$cookie->array['firstname']);
	$body->add_key('lastname',$cookie->array['lastname']);
//} else {
//  header('Location: index.php');
}

// set the header menu
$body->set_template("sales/header.html");
echo $body->create();

// set the main content
$page = isset($_REQUEST['show']) ? strtolower(str_replace("'","",$_REQUEST['show'])) : 'billing';
$body->add_key('mainpage',$_SERVER['SCRIPT_NAME']);
$body->add_key('workingfolder',$page);
switch($page){
  case 'process_payments':
    if (isset($_REQUEST['orderid'])) {
      $body->set_template("sales/paymentdetails.html");
      include('sales/paymentdetails.php');
    } else {
      $body->set_template("sales/processpayments.html");
      include('sales/processpayments.php');
    }
    break;
  default:
    $body->set_template("sales/main.html");
}
echo $body->create();

// set the footer, if any.
$body->set_template("sales/footer.html");
echo $body->create();