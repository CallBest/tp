<?php

require_once('../../includes/settings.php');
require_once('../../includes/dbase.php');

function cleanstring($string) {
  $newstring = "";
  $newstring = str_replace("'","''",$string);
  $newstring = str_replace("--","_",$newstring);
  //$newstring = preg_replace("/'/", "\&#39;", $newstring);
  $newstring = strtoupper($newstring);
  $newstring = stripslashes($newstring);
  return $newstring;
}

$leadid = $_REQUEST['leadid'];
$userid = $_REQUEST['userid'];
$user = $_REQUEST['user'];
$disposition = $_REQUEST['disposition'];
$remarks = $_REQUEST['remarks'];
$refererpage = $_REQUEST['refererpage'];

$db = new dbconnection();
$db->dbconnect();

$datafields = array (
  'lastname',
  'firstname',
	'phone',
	'address',
	'addresscity',
	'addresscounty',
	'addressstate',
  'addresszipcode',
  'email',
  'accountnumber',
  'referralcode',
  'referralcredit',
  'markdrivewaydifficult',
  'marknoservice',
  'problemcustomer',
  'tankownership',
  'tanksize',
  'cardtype',
  'cardnumber',
  'expirationdate',
  'cvv',
  'permanentdeliveryinstructions',
  'haspricecap',
  'haspricecapppg',
  'haspricecapexp',
  'haslockin',
  'haslockinppg',
  'haslockinexp',
  'tiergalloncoverage',
  'restrictedprebuygallons',
  'taxexempt',
  'hasprebuyannualfee',
  'prebuyfeestartdate',
  'serialnumber',
  'tankannualmaintenancefee',
  'maintenancefeestartdate',
  'onbudgetprogram',
  'twelvemonthtankprogram'
);

$setfields = "";
foreach ($datafields as $key => $value) {
  if (!(($value=='email') || ($value=='cardnumber'))) {
    $curfield = cleanstring($_POST["$value"]);
    $$value = $curfield;
  } else {
    $curfield = $_POST["$value"];
    $$value = $curfield;
  }
  if (($value=='cardnumber') && (substr($cardnumber,0,14)!='XXXX-XXXX-XXXX')) {
    $setfields .= "$value='$curfield',";
  } else if (($value=='cardnumber') && (substr($cardnumber,0,14)=='XXXX-XXXX-XXXX')) {
    //do not overwrite card number if there is an existing card num
  } else {
    $setfields .= "$value='$curfield',";
  }
}

//masterfile
$db->query = "
  update " . TABLE_CLIENTS . "
  set
    $setfields
    userid=$userid,disposition='$disposition',tagdate=now(),remarks='$remarks'
  where leadid=$leadid
  ";
$db->execute();

//orders
if ($disposition == 'Order Placed') {
  if ((isset($_REQUEST['newtankorder'])) && (isset($_REQUEST['buytank']))) {
    $ordertype = 'Tank';
    $tanksize = $_REQUEST['buytank'];
  }
  if (isset($_REQUEST['newprebuyorder'])) {
    $ordertype = 'Pre-buy';
  } else if (isset($_REQUEST['newfillorder'])) {
    $ordertype = 'Regular fill';
  }
  $gallons = $_REQUEST['gallons'];
  $ppg = $_REQUEST['ppg'];
  if (isset($_REQUEST['expressdelivery'])) {
    $expressdelivery = '1';
  } else {
    $expressdelivery = "0";
  }
  if (isset($_REQUEST['paywithcc'])) {
    $paymethod = 'Credit card';
  } else {
    $paymethod = "Check";
  }
  if (isset($_REQUEST['cardnumber'])) {
    if (substr($_REQUEST['cardnumber'],0,4) == 'XXXX') {
      $db->query = "select cardnumber from ".TABLE_CLIENTS." where leadid=$leadid";
      $db->execute();
      $row = $db->fetchrow(0);
      $cardnumber = $row['cardnumber'];
    } else {
      $cardnumber = $_REQUEST['cardnumber'];
    }
  }
  $datafields = array (
    'pricebreakdown',
    'billingaddress',
    'billingcity',
    'billingcounty',
    'billingstate',
    'billingzipcode',
    'cardtype',
    'expirationdate',
    'cvv',
    'creditcardzip',
    'totalamount'
  );

  $setfields = "";
  foreach ($datafields as $key => $value) {
    $curfield = $_POST["$value"];
    $$value = $curfield;
    $setfields .= "'$curfield',";
  }

  $db->query = "insert into ".TABLE_ORDERS." (leadid,ordertype,tanksize,gallons,ppg,expressdelivery,paymethod,pricebreakdown,billingaddress,billingcity,billingcounty,billingstate,billingzipcode,cardtype,expirationdate,cvv,creditcardzip,totalamount,cardnumber,orderdate)
      values ($leadid,'$ordertype','$tanksize','$gallons','$ppg','$expressdelivery','$paymethod',$setfields '$cardnumber',now())";
  $db->execute();
}

//callhistory
$db->query = "
  insert into " . TABLE_HISTORY . " (leadid,remarks,disposition,userid,tagdate)
    values (
      $leadid,
      '$remarks',
      '$disposition',
      '$userid',
      now()
    )";
$db->execute();

header("Location: $refererpage");

?>