<?php

require_once('../../includes/settings.php');
require_once('../../includes/dbase.php');

//$indata = json_decode(file_get_contents("php://input"));
//$sched = $indata->sched;
$outdata = [];
$db = new dbconnection();
$db->dbconnect();
$db->query = "select a.leadid as dclientname,ordertype as dordertype,orderdate as dorderdate,assigneddriver as ddriver,delivereddate from deliveries a inner join orders b on (a.leadid=b.leadid)";
// where scheduled='$sched'";
$db->execute();
$rowcount = $db->rowcount();
for ($x=0; $x < $rowcount; $x++) {
  $outdata[$x] = $db->fetchrow($x);
}
$db->dbclose();

echo json_encode($outdata);
?>