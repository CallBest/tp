<?php

require_once('../includes/settings.php');
require_once('../includes/dbase.php');

$db = new dbconnection();
$db->dbconnect();
$db->query = "select orderid,concat(firstname,' ',lastname) as clientname,disposition,orderdate,ordertype,pricebreakdown
              from ".TABLE_ORDERS." a inner join ".TABLE_CLIENTS." b on (a.leadid=b.leadid)
              where disposition='Order Placed'";
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