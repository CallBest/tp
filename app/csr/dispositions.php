<?php
$db->query = "select disposition from " . TABLE_DISPO . " where selectable=1 and usertype in (0,$usertype)";
$db->execute();
$rowcount = $db->rowcount();
$dispo = [];
if ($rowcount>0) {
  for ($x=0; $x < $rowcount; $x++) {
    $row = $db->fetchrow($x);
    $dispo[$x] = $row;
  }
}

$body->template_loop('dispositions',$dispo);

?>