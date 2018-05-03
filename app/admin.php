<?php

require_once("../includes/cookie.php");
require_once("../includes/template.php");

$body = new Template();
$cookie = new CookieInfo("TP_admin");

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
$body->set_template("admin/header.html");
echo $body->create();

//set the main content
$page = isset($_REQUEST['show']) ? strtolower(str_replace("'","",$_REQUEST['show'])) : 'dashboard';
switch($page){
  case 'price_setting':
    $body->set_template("admin/price.html");
    break;
  case 'price_history':
    $body->set_template("admin/price.html");
    break;
  case 'set_advisory':
    $body->set_template("admin/price.html");
    break;
  case 'sales_daily':
    $body->set_template("admin/sales.html");
    break;
  case 'sales_weekly':
    $body->set_template("admin/sales.html");
    break;
  case 'sales_monthly':
    $body->set_template("admin/sales.html");
    break;
  case 'staff_csr':
    $body->set_template("admin/staff_csr.html");
    break;
  case 'staff_delivery':
    $body->set_template("admin/staff.html");
    break;
  case 'staff_driver':
    $body->set_template("admin/staff.html");
    break;
  case 'staff_sales':
    $body->set_template("admin/staff.html");
    break;
  case 'staff_admin':
    $body->set_template("admin/staff.html");
    break;
  case 'branch':
    $body->set_template("admin/staff.html");
    break;
  case 'report_call':
    $body->set_template("admin/report_call.html");
    include("admin/report_call.php");
    break;
  case 'report_sales':
    $body->set_template("admin/report_sales.html");
    include("admin/report_sales.php");
    break;
  default:
    $body->set_template("admin/cpanel.html");
}
echo $body->create();

// set the footer, if any.
$body->set_template("admin/footer.html");
echo $body->create();