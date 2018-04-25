<?php

require_once('../../includes/settings.php');
require_once('../../includes/dbase.php');

$sched = $_REQUEST['sched'];
$outdata = [];
$db = new dbconnection();
$db->dbconnect();
$db->query = "select a.leadid as dclientname,ordertype as dordertype,orderdate as dorderdate,assigneddriver as ddriver,scheduled from deliveries a inner join orders b on (a.leadid=b.leadid)
where scheduled='$sched'";
$db->execute();
$rowcount = $db->rowcount();
for ($x=0; $x < $rowcount; $x++) {
  $outdata[$x] = $db->fetchrow($x);
}
$db->dbclose();

echo json_encode($outdata);
?>