<?php

require_once('../includes/settings.php');
require_once('../includes/dbase.php');

$db = new dbconnection();
$db->dbconnect();
$db->query = "select deliveryid,concat(firstname,' ',lastname) as clientname,ordertype,gallons,paymentstatus
              from ".TABLE_DELIVERIES." a inner join ".TABLE_CLIENTS." b on (a.leadid=b.leadid)
              inner join ".TABLE_ORDERS." c on (a.orderid=c.orderid)
              where actiontaken='Scheduled delivery'";
$db->execute();
$rowcount = $db->rowcount();
$gridvalues = [];
for ($x=0; $x < $rowcount; $x++) {
  $row = $db->fetchrow($x);
  $gridvalues[$x] = $row;
}
$db->dbclose();
$body->template_loop('gridvalues',$gridvalues);
?>