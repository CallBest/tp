<?php

require_once('../includes/settings.php');
require_once('../includes/dbase.php');

$db = new dbconnection();
$db->dbconnect();
$db->query = "select a.disposition,count(leadid) as leadcount
              from ".TABLE_DISPO." a left join ".TABLE_CLIENTS." b on (a.disposition=b.disposition) where usertype = 0
              group by disposition order by dispoid
              ";
$db->execute();
$rowcount = $db->rowcount();
$gridvalues = [];
$leadcount = 0;
for ($x=0; $x < $rowcount; $x++) {
  $row = $db->fetchrow($x);
  $gridvalues[$x] = $row;
  $leadcount += $row['leadcount'];
}
foreach ($gridvalues as $key=>$value) {
  $gridvalues[$key]['rate'] = number_format(($gridvalues[$key]['leadcount'] / $leadcount) * 100, 2, '.', '') . ' %';
}
$db->dbclose();
$body->template_loop('gridvalues',$gridvalues);
?>