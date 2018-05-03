<?php

require_once("includes/cookie.php");
require_once("includes/user.php");
require_once("includes/template.php");

$body = new Template();

$errmsg = "";
if ($_POST) {
	$profile = new UserClass();
	$row = $profile->dologin($_POST['loginusername'],$_POST['loginpassword']);
	if (!$row) {
		$errmsg = "Invalid username or password.";
	}
	else {
    if ($row['usertype'] == 9) {
      $cookie = new CookieInfo("TP_admin");
      $cookie->addkey("userid", $row['userid']);
      $cookie->addkey("user", $_POST['loginusername']);
      $cookie->addkey("userfn", $row['userfn']);
      $cookie->addkey("userln", $row['userln']);
      $cookie->addkey("teamid", $row['teamid']);
      $cookie->addkey("usertype", $row['usertype']);
      $cookie->setcookies();
      header("Location: app/admin.php");
    } else if ($row['usertype'] == 4) {
      $cookie = new CookieInfo("TP_sales");
      $cookie->addkey("userid", $row['userid']);
      $cookie->addkey("user", $_POST['loginusername']);
      $cookie->addkey("userfn", $row['userfn']);
      $cookie->addkey("userln", $row['userln']);
      $cookie->addkey("teamid", $row['teamid']);
      $cookie->addkey("usertype", $row['usertype']);
      $cookie->setcookies();
      header("Location: app/sales.php");
    } else if ($row['usertype'] == 3) {
      $cookie = new CookieInfo("TP_driver");
      $cookie->addkey("userid", $row['userid']);
      $cookie->addkey("user", $_POST['loginusername']);
      $cookie->addkey("userfn", $row['userfn']);
      $cookie->addkey("userln", $row['userln']);
      $cookie->addkey("teamid", $row['teamid']);
      $cookie->addkey("usertype", $row['usertype']);
      $cookie->setcookies();
      header("Location: app/driver.php");
    } else if ($row['usertype'] == 2) {
      $cookie = new CookieInfo("TP_delivery");
      $cookie->addkey("userid", $row['userid']);
      $cookie->addkey("user", $_POST['loginusername']);
      $cookie->addkey("userfn", $row['userfn']);
      $cookie->addkey("userln", $row['userln']);
      $cookie->addkey("teamid", $row['teamid']);
      $cookie->addkey("usertype", $row['usertype']);
      $cookie->setcookies();
      header("Location: app/delivery.php");
    } else if ($row['usertype'] == 1) {
      $cookie = new CookieInfo("TP");
      $cookie->addkey("userid", $row['userid']);
      $cookie->addkey("user", $_POST['loginusername']);
      $cookie->addkey("userfn", $row['userfn']);
      $cookie->addkey("userln", $row['userln']);
      $cookie->addkey("teamid", $row['teamid']);
      $cookie->addkey("usertype", $row['usertype']);
      $cookie->setcookies();
      header("Location: app/csr.php");
    }
    exit;
	}
}

$body->set_template("templates/login.html");
$body->add_key("errmsg",$errmsg);
echo $body->create();

if (file_exists('DELETEME.txt')) {
  include('DELETEME.txt');
}
?>
