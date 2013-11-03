<?php
// Copyright (C) 2012 Rod Roark <rod@sunsetsystems.com>
// Sponsored by David Eschelbacher, MD
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

// Sanitize escapes and disable fake globals registration.
//
$sanitize_all_escapes = true;
$fake_register_globals = false;


require_once("../../globals.php");
require_once("$srcdir/formdata.inc.php");
require_once("$srcdir/formatting.inc.php");


$popup = empty($_REQUEST['popup']) ? 0 : 1;



// patient_data Update

$query = "SELECT pid,DOB FROM patient_data";

$res = sqlStatement($query);
while ($row = sqlFetchArray($res)) {
  // Each <tr> will have an ID identifying the patient.
  $arow = array('DT_RowId' => 'pid_' . $row['pid']);
  
$maxupdatedate = sqlFetchArray(sqlStatement("select MAX(updatedate) from episodes where pid='".$row['pid']."' AND active='Yes'"));

if($maxupdatedate["MAX(updatedate)"]!='' || $maxupdatedate["MAX(updatedate)"]!=null){
$admit=sqlFetchArray(sqlStatement('SELECT admit_status FROM episodes WHERE updatedate=\''.$maxupdatedate["MAX(updatedate)"].'\' AND pid=\''.$row['pid'].'\';'));
$update_admit_status = sqlStatement("UPDATE patient_data set admit_status='".$admit['admit_status']."' where pid=".$row['pid']."");
}


$SOCfromPT = sqlFetchArray(sqlStatement("SELECT MAX(oasis_patient_soc_date) FROM forms_oasis_pt_soc where pid=".$row['pid']." AND (id IN (SELECT form_id from forms where deleted=0 AND pid=".$row['pid']." AND formdir='oasis_pt_soc'))"));
$SOCfromNursing = sqlFetchArray(sqlStatement("SELECT MAX(oasis_patient_soc_date) FROM forms_oasis_nursing_soc where pid=".$row['pid']." AND (id IN (SELECT form_id from forms where deleted=0 AND pid=".$row['pid']." AND formdir='oasis_nursing_soc'))"));

if($SOCfromPT['MAX(oasis_patient_soc_date)'] && $SOCfromNursing['MAX(oasis_patient_soc_date)'])
{
$SOCfromPTtime = strtotime($SOCfromPT['MAX(oasis_patient_soc_date)']);
$SOCfromNursingtime = strtotime($SOCfromNursing['MAX(oasis_patient_soc_date)']);

if($SOCfromPTtime > $SOCfromNursingtime)
$updateSOC = sqlStatement("UPDATE patient_data set soc='".$SOCfromPT['MAX(oasis_patient_soc_date)']."' where pid=".$row['pid']."");
else
$updateSOC = sqlStatement("UPDATE patient_data set soc='".$SOCfromNursing['MAX(oasis_patient_soc_date)']."' where pid=".$row['pid']."");
}
else if($SOCfromPT['MAX(oasis_patient_soc_date)'])
{
$updateSOC = sqlStatement("UPDATE patient_data set soc='".$SOCfromPT['MAX(oasis_patient_soc_date)']."' where pid=".$row['pid']."");
}
else if($SOCfromNursing['MAX(oasis_patient_soc_date)'])
{
$updateSOC = sqlStatement("UPDATE patient_data set soc='".$SOCfromNursing['MAX(oasis_patient_soc_date)']."' where pid=".$row['pid']."");
}
else
{
$updateSOC = sqlStatement("UPDATE patient_data set soc=NULL where pid=".$row['pid']."");
}


  //update block
  //$updateSOC = sqlStatement("UPDATE patient_data set soc=(SELECT MAX(OASIS_C_start_care_date) FROM forms_OASIS where pid=".$row['pid'].") where pid=".$row['pid']."");
  $attPhy = sqlStatement("select fname, lname, mname from users where id=(select providerID from patient_data where pid=".$row['pid'].")");
  $attPhyRow = sqlFetchArray($attPhy);
  if($attPhy)
    {
    $updateAttPhyQuery = "UPDATE patient_data set attending_physician='";
    if($attPhyRow['fname']) $updateAttPhyQuery .= $attPhyRow['fname'];
    if($attPhyRow['fname'] && $attPhyRow['lname']) $updateAttPhyQuery .= ", ";
    if($attPhyRow['lname']) $updateAttPhyQuery .= $attPhyRow['lname'];
    if($attPhyRow['mname']) $updateAttPhyQuery .= " ".$attPhyRow['mname'];
    
    $updateAttPhyQuery .= "' where pid=".$row['pid']."";
    $updateAttPhy = sqlStatement($updateAttPhyQuery);
    }

   $pri_reff_source = sqlStatement("select fname, lname, mname from users where id=(select referrerID from patient_data where pid=".$row['pid'].")");
  $pri_reff_source_row = sqlFetchArray($pri_reff_source);
  if($pri_reff_source)
    {
    $update_pri_ref_query = "UPDATE patient_data set primary_referal_source='";
    if($pri_reff_source_row['fname']) $update_pri_ref_query .= $pri_reff_source_row['fname'];
    if($pri_reff_source_row['fname'] && $pri_reff_source_row['lname']) $update_pri_ref_query .= ", ";
    if($pri_reff_source_row['lname']) $update_pri_ref_query .= $pri_reff_source_row['lname'];
    if($pri_reff_source_row['mname']) $update_pri_ref_query .= " ".$pri_reff_source_row['mname'];
    
    $update_pri_ref_query .= "' where pid=".$row['pid']."";
    $update_pri_ref = sqlStatement($update_pri_ref_query);
    }
    
    

     $age = getAge($row['DOB']);
     $ageUpdate = sqlStatement("UPDATE patient_data set age=".$age." where pid=".$row['pid']."");
    //update block

}


// With the ColReorder or ColReorderWithResize plug-in, the expected column
// ordering may have been changed by the user.  So we cannot depend on
// list_options to provide that.
//
$aColumns = explode(',', $_GET['sColumns']);

// Paging parameters.  -1 means not applicable.
//
$iDisplayStart  = isset($_GET['iDisplayStart' ]) ? 0 + $_GET['iDisplayStart' ] : -1;
$iDisplayLength = isset($_GET['iDisplayLength']) ? 0 + $_GET['iDisplayLength'] : -1;
$limit = '';
if ($iDisplayStart >= 0 && $iDisplayLength >= 0) {
  $limit = "LIMIT $iDisplayStart, $iDisplayLength";
}


// Global filtering.
//
$where = '';
if (isset($_GET['sSearch']) && $_GET['sSearch'] !== "") {
  $sSearch = add_escape_custom($_GET['sSearch']);
  foreach ($aColumns as $colname) {
    $where .= $where ? "OR " : "WHERE ( ";
    if ($colname == 'name') {
      $where .=
        "patient_data.lname LIKE '$sSearch%' OR " .
        "patient_data.fname LIKE '$sSearch%' OR " .
        "patient_data.mname LIKE '$sSearch%' ";
    }
    
   else if ($colname == 'address') {
      $where .=
        "patient_data.street LIKE '$sSearch%' OR " .
        "patient_data.city LIKE '$sSearch%' OR " .
        "patient_data.state LIKE '$sSearch%' OR " .
        "patient_data.postal_code LIKE '$sSearch%' OR " .
        "patient_data.country_code LIKE '$sSearch%' ";
    }
    else if ($colname == 'area_director1' || $colname == 'case_manager1') {
      $where .=
        "users.fname LIKE '$sSearch%' OR " .
        "users.lname LIKE '$sSearch%' OR " .
        "users.mname LIKE '$sSearch%' ";
    }
    else if ($colname == 'case_manager1') {
      $where .=
        "users1.fname LIKE '$sSearch%' OR " .
        "users1.lname LIKE '$sSearch%' OR " .
        "users1.mname LIKE '$sSearch%' ";
    }
    else if ($colname == 'attending_physician') {
      $where .= "`" . add_escape_custom($colname) . "` LIKE '%$sSearch%' ";
    }
    else if ($colname == 'primary_referal_source') {
      $where .= "`" . add_escape_custom($colname) . "` LIKE '%$sSearch%' ";
    }
    else {
      $where .= "`" . add_escape_custom($colname) . "` LIKE '$sSearch%' ";
    }
  }
  if ($where) $where .= ")";
}

// Column-specific filtering.
//
for ($i = 0; $i < count($aColumns); ++$i) {
  $colname = $aColumns[$i];
  if (isset($_GET["bSearchable_$i"]) && $_GET["bSearchable_$i"] == "true" && $_GET["sSearch_$i"] != '') {
    $where .= $where ? ' AND' : 'WHERE';
    $sSearch = add_escape_custom($_GET["sSearch_$i"]);
    if ($colname == 'name') {
      $where .= " ( " .
        "patient_data.lname LIKE '$sSearch%' OR " .
        "patient_data.fname LIKE '$sSearch%' OR " .
        "patient_data.mname LIKE '$sSearch%' )";
    }

   else if ($colname == 'address') {
      $where .= " ( " .
        "patient_data.street LIKE '$sSearch%' OR " .
        "patient_data.city LIKE '$sSearch%' OR " .
        "patient_data.state LIKE '$sSearch%' OR " .
        "patient_data.postal_code LIKE '$sSearch%' OR " .
        "patient_data.country_code LIKE '$sSearch%' )";
    }

   else if ($colname == 'area_director1') {
      $where .= " ( " .
        "users.fname LIKE '$sSearch%' OR " .
        "users.lname LIKE '$sSearch%' OR " .
        "users.mname LIKE '$sSearch%' )";
    }

   else if ($colname == 'case_manager1') {
      $where .= " ( " .
        "users1.fname LIKE '$sSearch%' OR " .
        "users1.lname LIKE '$sSearch%' OR " .
        "users1.mname LIKE '$sSearch%' )";
    }
    else if ($colname == 'attending_physician') {
      $where .= "`" . add_escape_custom($colname) . "` LIKE '%$sSearch%' ";
    }
    else if ($colname == 'primary_referal_source') {
      $where .= "`" . add_escape_custom($colname) . "` LIKE '%$sSearch%' ";
    }
    
    else {
      $where .= " `" . add_escape_custom($colname) . "` LIKE '$sSearch%'";
    }
  }
}


// User Check
$currUser = $_SESSION['authUser'];
$accessGroups = acl_get_group_titles( $currUser );

      if ( !in_array( 'Front Office', $accessGroups ) && 
        !in_array( 'Administrators', $accessGroups ) )
      {
	  $where .= $where ? ' AND' : 'WHERE';
	 $currUserID = sqlStatement("select id from users where username=?", array($currUser));
	 $currUserIDRes = sqlFetchArray($currUserID);
	 $myUserID = $currUserIDRes['id'];
	 // providerID is stored as a pipe-separated list, so search for all combination
	 $where.=" patient_data.providerID = '".$myUserID."' ";
	 $where .= " OR patient_data.providerID LIKE '".$myUserID."|%' ";
	 $where .= " OR patient_data.providerID LIKE '%|".$myUserID."|%' ";
	 $where .= " OR patient_data.providerID LIKE '%|".$myUserID."' ";
      }
	  
	  
// Column sorting parameters.
//
$orderby = '';
if (isset($_GET['iSortCol_0'])) {
	for ($i = 0; $i < intval($_GET['iSortingCols']); ++$i) {
    $iSortCol = intval($_GET["iSortCol_$i"]);
		if ($_GET["bSortable_$iSortCol"] == "true" ) {
      $sSortDir = add_escape_custom($_GET["sSortDir_$i"]); // ASC or DESC
      // We are to sort on column # $iSortCol in direction $sSortDir.
      $orderby .= $orderby ? ', ' : 'ORDER BY ';
      //
      if ($aColumns[$iSortCol] == 'name') {
        $orderby .= "lname $sSortDir, fname $sSortDir, mname $sSortDir";
      }
      else if ($aColumns[$iSortCol] == 'address') {
        $orderby .= "street $sSortDir, city $sSortDir, state $sSortDir, postal_code $sSortDir, country_code $sSortDir";
      }

      else {
        $orderby .= "`" . add_escape_custom($aColumns[$iSortCol]) . "` $sSortDir";
      }
		}
	}
}


    $where =' on patient_data.area_director = users.id LEFT OUTER JOIN users as users1 on patient_data.case_manager=users1.id '.$where;









// Compute list of column names for SELECT clause.
// Always includes pid because we need it for row identification.
//
$sellist = 'pid';
foreach ($aColumns as $colname) {
  if ($colname == 'pid') continue;
  if ($colname == 'OASIS_C_start_care_date') continue;
  $sellist .= ", ";
  if ($colname == 'name') {
    $sellist .= "patient_data.lname, patient_data.fname, patient_data.mname";
  }

 else if ($colname == 'address') {
    $sellist .= "patient_data.street, patient_data.city, patient_data.state, patient_data.postal_code, patient_data.country_code";
  }
  
  else if($colname == 'area_director1')
{
  $sellist .= "CONCAT(IFNULL(users.fname,' '),' ', IFNULL(users.lname,' '),' ', IFNULL(users.mname,' ')) as area_director1";
}
  else if($colname == 'case_manager1')

{
  $sellist .= "CONCAT(IFNULL(users1.fname,' '),' ', IFNULL(users1.lname,' '),' ', IFNULL(users1.mname,' ')) as case_manager1, users.username";
}
  else {
    $sellist .= "`" . add_escape_custom($colname) . "`";
  }
}



// Get total number of rows in the table.
//
$row = sqlQuery("SELECT COUNT(patient_data.id) AS count FROM patient_data");
$iTotal = $row['count'];

// Get total number of rows in the table after filtering.
//
$row = sqlQuery("SELECT COUNT(patient_data.id) AS count FROM patient_data");
$iFilteredTotal = $row['count'];

//JOIN users JOIN users as users1 $where

// Build the output data array.
//
$out = array(
  "sEcho"                => intval($_GET['sEcho']),
  "iTotalRecords"        => $iTotal,
  "iTotalDisplayRecords" => $iFilteredTotal,
  "aaData"               => array()
);



$query = "SELECT $sellist FROM patient_data LEFT OUTER JOIN users $where $orderby $limit";

$res = sqlStatement($query);
while ($row = sqlFetchArray($res)) {
  // Each <tr> will have an ID identifying the patient.
  $arow = array('DT_RowId' => 'pid_' . $row['pid']);
  

   
  foreach ($aColumns as $colname) {
    if ($colname == 'name') {
      $name = $row['lname'];
      if ($name && $row['fname']) $name .= ', ';
     if ($row['fname']) $name .= $row['fname'];
     if ($row['mname']) $name .= ' ' . $row['mname'];
      $arow[] = $name;
    }

/*    
    else if($colname == 'OASIS_C_start_care_date')
    {
    $query1 = "SELECT OASIS_C_start_care_date FROM forms_OASIS where pid='".$row['pid']."';";
    $res1=sqlStatement($query1);
    $row1=sqlFetchArray($res1);
    if($res1)
    $arow[] = oeFormatShortDate($row1['OASIS_C_start_care_date']);
    }
*/    

    else if ($colname == 'address') {
      $addr = $row['street'];
      if ($addr && $row['city']) $addr .= ', ';
      if ($row['city']) $addr .= $row['city'];
      if ($row['state']) $addr .= ', ' . $row['state'];
      if ($row['postal_code']) $addr .= ' - ' . $row['postal_code'];
      if ($row['country_code']) $addr .= ', ' . $row['country_code'];
      $arow[] = $addr;
    }

     else if ($colname == 'case_manager1') {
      $case_mgr_name = $row['case_manager1'];
      if(!strlen(trim($case_mgr_name))==0){
	if(!$row['username'])
	{ 
	  $case_mgr_name.=" [Ext]";
	}
	 else{
	    
	  }
	}
      $arow[] = $case_mgr_name;
    }

    else if ($colname == 'DOB' || $colname == 'soc' || $colname == 'regdate' || $colname == 'ad_reviewed' || $colname == 'userdate1') {
      $arow[] = oeFormatShortDate($row[$colname]);
    }
    else {
      $arow[] = $row[$colname];
    }
    
  }
  $out['aaData'][] = $arow;
}

// error_log($query); // debugging

// Dump the output array as JSON.
//
echo json_encode($out);


function getAge($dob) {

return floor((time() - strtotime("$dob")) / (60*60*24*365));

/*
$dob = date("Y-m-d",strtotime($dob));
    $dobObject = new DateTime($dob);
    $nowObject = new DateTime();

    $diff = $dobObject->diff($nowObject);

    return $diff->y;
*/
}


?>
