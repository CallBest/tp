<?php

require_once('../includes/settings.php');
require_once('../includes/dbase.php');

$db = new dbconnection();
$db->dbconnect();

$orderid = $_REQUEST['orderid'];
$db->query = "select concat(firstname,' ',lastname) as clientname,disposition,orderdate,ordertype
              from ".TABLE_ORDERS." a inner join ".TABLE_CLIENTS." b on (a.leadid=b.leadid)
              where orderid=$orderid";
$db->execute();
$rowcount = $db->rowcount();
for ($x=0; $x < $rowcount; $x++) {
  $row = $db->fetchrow($x);
}
$db->dbclose();
$body->add_key('sched',Date("Y-m-d"));
$body->add_keys($row);
?>