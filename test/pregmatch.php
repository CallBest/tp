<?php
# Extract the number from a date string 
preg_match("/(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})/", "2012-10-20", $results);
print_r($results);
?>