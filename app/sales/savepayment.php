<?php

require_once('../../includes/settings.php');
require_once('../../includes/dbase.php');

$leadid = $_REQUEST['leadid'];
$orderid = $_REQUEST['orderid'];
$userid = $_REQUEST['userid'];
$status = $_REQUEST['status'];
$paymethod = $_REQUEST['paymethod'];
$cardtype = $_REQUEST['cardtype'];
$cardnumber = $_REQUEST['cardnumber'];
$expirationdate = $_REQUEST['expirationdate'];
$cvv = $_REQUEST['cvv'];
$refererpage = $_REQUEST['refererpage'];

$db = new dbconnection();
$db->dbconnect();

$db->query = "
  update " . TABLE_ORDERS . "
  set
    processedby=$userid,paymentstatus='$status',updated=now(),paymethod='$paymethod',cardtype='$cardtype',cardnumber='$cardnumber',expirationdate='$expirationdate',cvv='$cvv'
  where orderid=$orderid
  ";
$db->execute();

$db->query = "
  update " . TABLE_CLIENTS . "
  set
    disposition='$status',tagdate=now()
  where leadid=$leadid
  ";
$db->execute();

//callhistory
$db->query = "
  insert into " . TABLE_HISTORY . " (leadid,disposition,userid,tagdate)
    values (
      $leadid,
      '$status',
      '$userid',
      now()
    )";
$db->execute();

header("Location: $refererpage");

?>