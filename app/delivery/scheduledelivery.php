<?php

require_once('../../includes/settings.php');
require_once('../../includes/dbase.php');

$leadid = $_REQUEST['leadid'];
$orderid = $_REQUEST['orderid'];
$userid = $_REQUEST['userid'];
$sched = $_REQUEST['sched'];
$driver = $_REQUEST['driver'];
$refererpage = $_REQUEST['refererpage'];

$db = new dbconnection();
$db->dbconnect();

$db->query = "
  insert into deliveries (orderid,leadid,entereddate,scheduled,assigneddriver)
    values
    ($orderid,$leadid,now(),'$sched','$driver')
  ";
$db->execute();

$db->query = "
  update orders set actiontaken='Scheduled Delivery' where orderid=$orderid
  ";
$db->execute();


//callhistory
$db->query = "
  insert into " . TABLE_HISTORY . " (leadid,disposition,userid,tagdate)
    values (
      $leadid,
      'Scheduled Delivery',
      '$userid',
      now()
    )";
$db->execute();

header("Location: $refererpage");

?>