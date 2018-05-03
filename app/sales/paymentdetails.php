<?php

require_once('../includes/settings.php');
require_once('../includes/dbase.php');

$orderid = $_REQUEST['orderid'];
$db = new dbconnection();
$db->dbconnect();
$db->query = "select a.leadid,orderid,concat(firstname,' ',lastname) as clientname,disposition,orderdate,ordertype,pricebreakdown,paymethod,a.cardtype,a.cardnumber,a.expirationdate,a.cvv
              from ".TABLE_ORDERS." a inner join ".TABLE_CLIENTS." b on (a.leadid=b.leadid)
              where orderid=$orderid";
$db->execute();
$rowcount = $db->rowcount();
for ($x=0; $x < $rowcount; $x++) {
  $row = $db->fetchrow($x);
}
$db->dbclose();
$body->add_keys($row);
?>