<?php

require_once('../includes/settings.php');
require_once('../includes/dbase.php');

$db = new dbconnection();
$db->dbconnect();
$db->query = "select count(orderid) as leadcount from ".TABLE_ORDERS." where ordertype='Regular fill'
              union
              select count(orderid) as leadcount from ".TABLE_ORDERS." where ordertype='Pre-buy'
              union
              select sum(gallons) as leadcount from ".TABLE_ORDERS." where ordertype='Regular fill'
              union
              select sum(gallons) as leadcount from ".TABLE_ORDERS." where ordertype='Pre-buy'
              union
              select '1' as leadcount from ".TABLE_ORDERS."
              union
              select '0' as leadcount from ".TABLE_ORDERS." where expressdelivery=1
              union
              select '2' as leadcount from ".TABLE_ORDERS."
              union
              select round(sum(totalamount),2) as leadcount from ".TABLE_ORDERS." where ordertype='Regular fill'
              union
              select round(sum(totalamount),2) as leadcount from ".TABLE_ORDERS." where ordertype='Pre-buy'
              union
              select round(sum(totalamount),2) as leadcount from ".TABLE_ORDERS;
$db->execute();
$rowcount = $db->rowcount();
$gridvalues = [
  ['Total regular sales'],
  ['Total pre-buys'],
  ['Total regular gallons'],
  ['Total pre-buy gallons'],
  ['Emergency delivery count'],
  ['Expedited delivery count'],
  ['Special delivery count'],
  ['Total amount regular'],
  ['Total amount pre-buy'],
  ['Total']
];
$leadcount = 0;
for ($x=0; $x < $rowcount; $x++) {
  $row = $db->fetchrow($x);
  $gridvalues[$x]['value'] = $row['leadcount'];
}
$db->dbclose();
$body->template_loop('gridvalues',$gridvalues);
?>