<?php

require_once('../includes/settings.php');
require_once('../includes/dbase.php');

$deliveryid = $_REQUEST['deliveryid'];
$db = new dbconnection();
$db->dbconnect();
$db->query = "select deliveryid,concat(firstname,' ',lastname) as clientname,address,addresscity,addresscounty,addressstate,addresszipcode,ordertype,orderdate,b.tanksize,gallons,concat(permanentdeliveryinstructions,'\n',notes) as notes,pricebreakdown
              from ".TABLE_ORDERS." a inner join ".TABLE_CLIENTS." b on (a.leadid=b.leadid)
              inner join ".TABLE_DELIVERIES." c on (a.orderid=c.orderid)
              where deliveryid=$deliveryid";
$db->execute();
$rowcount = $db->rowcount();
for ($x=0; $x < $rowcount; $x++) {
  $row = $db->fetchrow($x);
}
$db->dbclose();
$body->add_keys($row);
?>