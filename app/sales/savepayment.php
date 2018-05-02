<?php

require_once('../../includes/settings.php');
require_once('../../includes/dbase.php');

$leadid = $_REQUEST['leadid'];
$userid = $_REQUEST['userid'];
$user = $_REQUEST['user'];

$db = new dbconnection();
$db->dbconnect();

$db->query = "
  update " . TABLE_ORDERS . "
  set
    $setfields
    userid=$userid,disposition='$disposition',tagdate=now(),remarks='$remarks'
  where leadid=$leadid
  ";
$db->execute();

//callhistory
$db->query = "
  insert into " . TABLE_HISTORY . " (leadid,remarks,disposition,userid,tagdate)
    values (
      $leadid,
      '$remarks',
      '$disposition',
      '$userid',
      now()
    )";
$db->execute();

header("Location: $refererpage");

?>