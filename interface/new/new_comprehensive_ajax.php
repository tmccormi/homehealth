<?php
require_once("../globals.php");


function getHospitalDetails($userID){
 $sql ="SELECT phone,street,streetb,city,state,zip FROM users WHERE id=$userID";
$res = sqlStatement($sql);
$hospitalDetails = sqlFetchArray($res);


if($hospitalDetails)
{

foreach($hospitalDetails as $fieldName => $curVal)
{
if($curVal==null)
{
$hospitalDetails[$fieldName]='';
}
}

return json_encode($hospitalDetails);
}
else
{
$nullarray['phone']='';
$nullarray['street']='';
$nullarray['streetb']='';
$nullarray['city']='';
$nullarray['state']='';
$nullarray['zip']='';

return json_encode($nullarray);
}
}

function getAgencyDetails($userID){
 $sql ="SELECT phone,street,streetb,city,state,zip,fax,email FROM users WHERE id=$userID";
$res = sqlStatement($sql);
$agencyDetails = sqlFetchArray($res);

if($agencyDetails)
{

foreach($agencyDetails as $fieldName => $curVal)
{
if($curVal==null)
{
$agencyDetails[$fieldName]='';
}
}

return json_encode($agencyDetails);
}
else
{
$nullarray['phone']='';
$nullarray['street']='';
$nullarray['streetb']='';
$nullarray['city']='';
$nullarray['state']='';
$nullarray['zip']='';
$nullarray['fax']='';
$nullarray['email']='';

return json_encode($nullarray);
}
}

function getRefferrerDetails($userID){
 $sql ="SELECT fname,lname,organization,phone,fax FROM users WHERE id=$userID";
$res = sqlStatement($sql);
$referrerDetails = sqlFetchArray($res);

if($referrerDetails)
{

foreach($referrerDetails as $fieldName => $curVal)
{
if($curVal==null)
{
$referrerDetails[$fieldName]='';
}
}

return json_encode($referrerDetails);
}
else
{
$nullarray['fname']='';
$nullarray['lname']='';
$nullarray['organization']='';
$nullarray['phone']='';
$nullarray['fax']='';

return json_encode($nullarray);
}
}

function getProviderDetails($userID){
 $sql ="SELECT fname,lname,upin,npi,street,streetb,city,state,zip,phone,fax FROM users WHERE id=$userID";
$res = sqlStatement($sql);
$providerDetails = sqlFetchArray($res);



if($providerDetails)
{

foreach($providerDetails as $fieldName => $curVal)
{
if($curVal==null)
{
$providerDetails[$fieldName]='';
}
}

return json_encode($providerDetails);
}
else
{
$nullarray['fname']='';
$nullarray['lname']='';
$nullarray['upin']='';
$nullarray['npi']='';
$nullarray['street']='';
$nullarray['streetb']='';
$nullarray['city']='';
$nullarray['state']='';
$nullarray['zip']='';
$nullarray['phone']='';
$nullarray['fax']='';

return json_encode($nullarray);
}
}

function getTypeUsers($user_type){

if($user_type!=""){
$sql = "SELECT id, fname, lname, specialty FROM users WHERE abook_type = '".$user_type."' ORDER BY lname, fname";
$res = sqlStatement($sql);
$users_list=" ";
while($urow=sqlFetchArray($res))
{
      $uname = htmlspecialchars( $urow['fname'] . ' ' . $urow['lname'], ENT_NOQUOTES);
      $optionId = htmlspecialchars( $urow['id'], ENT_QUOTES);
      $users_list.= "<option value='".$optionId."'>".$uname."</option>";
}
if($users_list)
return json_encode($users_list);
else
{
$no_list="";
return json_encode($no_list);
}
}
else
{
$no_list="";
return json_encode($no_list);
}
}







/* Function calling Statements */
if(isset($_GET['hospitalID']))
{
  echo getHospitalDetails($_GET['hospitalID']);
}
else if(isset($_GET['agencyID']))
{
  echo getAgencyDetails($_GET['agencyID']);
}
else if(isset($_GET['refProviderID']))
{
  echo getRefferrerDetails($_GET['refProviderID']);
}
else if(isset($_GET['primary_ref']))
{
  echo getProviderDetails($_GET['primary_ref']);
}
else if(isset($_GET['otPhyID']))
{
  echo getProviderDetails($_GET['otPhyID']);
}
else if(isset($_GET['attPhyID']))
{
  echo getProviderDetails($_GET['attPhyID']);
}
else if(isset($_GET['type']))
{
  echo getTypeUsers($_GET['type']);
}





?>