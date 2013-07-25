<?php
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

require_once("$srcdir/options.inc.php");

$months = array("01","02","03","04","05","06","07","08","09","10","11","12");
$days = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14",
  "15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
$thisyear = date("Y");
$years = array($thisyear-1, $thisyear, $thisyear+1, $thisyear+2);

if ($viewmode) {
  $id = $_REQUEST['id'];
  $result = sqlQuery("SELECT * FROM form_encounter WHERE id = '$id'");
  $encounter = $result['encounter'];
  if ($result['sensitivity'] && !acl_check('sensitivities', $result['sensitivity'])) {
    echo "<body>\n<html>\n";
    echo "<p>" . xl('You are not authorized to see this encounter.') . "</p>\n";
    echo "</body>\n</html>\n";
    exit();
  }
}

// Sort comparison for sensitivities by their order attribute.
function sensitivity_compare($a, $b) {
  return ($a[2] < $b[2]) ? -1 : 1;
}

// get issues
$ires = sqlStatement("SELECT id, type, title, begdate FROM lists WHERE " .
  "pid = $pid AND enddate IS NULL " .
  "ORDER BY type, begdate");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php html_header_show();?>
<title><?php xl('Patient Encounter','e'); ?></title>

<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">

<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/common.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dialog.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/overlib_mini.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js"></script>


<!-- For time picker -->
<link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.ui.timepicker.css?v=0.3.1" type="text/css" />
<link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/css/jquery-ui-1.8.21.custom.css" type="text/css" />
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery.ui.timepicker.js?v=0.3.1"></script>

<!-- pop up calendar -->
<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/ajax/facility_ajax_jav.inc.php"); ?>
<script language="JavaScript">

$(document).ready(function(){
$('#form_time_in, #form_time_out').timepicker({
    minutes: {
        starts: 0,                // First displayed minute
        ends: 59,                 // Last displayed minute
        interval: 1               // Interval of displayed minutes
    }
  });
});


 var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';

 // Process click on issue title.
 function newissue() {
  dlgopen('../../patient_file/summary/add_edit_issue.php', '_blank', 800, 600);
  return false;
 }

 // callback from add_edit_issue.php:
 function refreshIssue(issue, title) {
  var s = document.forms[0]['issues[]'];
  s.options[s.options.length] = new Option(title, issue, true, true);
 }

var appendCount = 0;
var appendCount1 = 0;
var appendCount2 = 0;
var appendCount3 = 0;

 function saveClicked() {
  var f = document.forms[0];


<?php
$pid = $_SESSION['pid'];
$maxupdatedate = sqlFetchArray(sqlStatement("select MAX(updatedate) from episodes where pid='".$pid."' AND active='Yes'"));

if($maxupdatedate["MAX(updatedate)"]!='' || $maxupdatedate["MAX(updatedate)"]!=null)
$curr_episode=sqlFetchArray(sqlStatement('SELECT *FROM episodes WHERE updatedate=\''.$maxupdatedate["MAX(updatedate)"].'\';'));

if(!isset($curr_episode))
{
echo "alert('Please Create an Active Episode to Create an Encounter');";
echo "return;";
echo "location.reload();";
}

?>


var cargivr = $('#form_caregiver').val();
if(cargivr == 0 && appendCount == 0){
$('td select#form_caregiver').parent().append('<font class="error"> * Required</font>');
appendCount++;
}

var tos = $('#form_type_of_service').val();
if(tos == "" && appendCount1 == 0){
$('td select#form_type_of_service').parent().append('<font class="error"> * Required</font>');
appendCount1++;
}

var time_in = $('#form_time_in').val();
if(time_in == "" && appendCount2 == 0){
$('td #form_time_in').parent().append('<font class="error"> * Required</font>');
appendCount2++;
}

var time_out = $('#form_time_out').val();
if(time_out == "" && appendCount3 == 0){
$('td #form_time_out').parent().append('<font class="error"> * Required</font>');
appendCount3++;
}



<?php if (!$GLOBALS['athletic_team']) { ?>
  var category = document.forms[0].pc_catid.value;
  if ( category == '_blank' ) {
   alert("<?php echo xl('You must select a visit category'); ?>");
   return;
  }
<?php } ?>


if(cargivr == 0 || tos == "" || time_in == "" || time_out== ""){
return;
}

<?php if (false /* $GLOBALS['ippf_specific'] */) { // ippf decided not to do this ?>
  if (f['issues[]'].selectedIndex < 0) {
   if (!confirm('There is no issue selected. If this visit relates to ' +
    'contraception or abortion, click Cancel now and then select or ' +
    'create the appropriate issue. Otherwise you can click OK.'))
   {
    return;
   }
  }
<?php } ?>

  top.restoreSession();
  f.submit();
 }

$(document).ready(function(){
  enable_big_modals();
});
function bill_loc(){
var pid=<?php echo $pid;?>;
var dte=document.getElementById('form_date').value;
var facility=document.forms[0].facility_id.value;
ajax_bill_loc(pid,dte,facility);
}
</script>

<style>
#episode_id{
width: 200;
}

.error{
color:red;
}
</style>


</head>

<?php if ($viewmode) { ?>
<body class="body_top">
<?php } else { ?>
<body class="body_top" onload="javascript:document.new_encounter.reason.focus();">
<?php } ?>

<!-- Required for the popup date selectors -->
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<form method='post' action="<?php echo $rootdir ?>/forms/newpatient/save.php" name='new_encounter'
 <?php if (!$GLOBALS['concurrent_layout']) echo "target='Main'"; ?>>

<div style = 'float:left'>
<?php if ($viewmode) { ?>
<input type=hidden name='mode' value='update'>
<input type=hidden name='id' value='<?php echo $_GET["id"] ?>'>
<span class=title><?php xl('Patient Encounter Form','e'); ?></span>
<?php } else { ?>
<input type='hidden' name='mode' value='new'>
<span class='title'><?php xl('New Encounter Form','e'); ?></span>
<?php } ?>
</div>

<div>
    <div style = 'float:left; margin-left:8px;margin-top:-3px'>
      <a href="javascript:saveClicked();" class="css_button link_submit"><span><?php xl('Save','e'); ?></span></a>
    </div>
      <?php if ($viewmode || !isset($_GET["autoloaded"]) || $_GET["autoloaded"] != "1") { ?>
    <div style = 'float:left; margin-top:-3px'>
  <?php if ($GLOBALS['concurrent_layout']) { ?>
      <a href="<?php echo "$rootdir/patient_file/encounter/encounter_top.php"; ?>"
        class="css_button link_submit" onClick="top.restoreSession()"><span><?php xl('Cancel','e'); ?></span></a>
  <?php } else { ?>
      <a href="<?php echo "$rootdir/patient_file/encounter/patient_encounter.php"; ?>"
        class="css_button link_submit" target='Main' onClick="top.restoreSession()">
      <span><?php xl('Cancel','e'); ?>]</span></a>
  <?php } // end not concurrent layout ?>
  <?php }else{ // end not autoloading ?>
    <div style = 'float:left; margin-top:-3px'>
      <a href="<?php echo "$rootdir/patient_file/history/encounters.php"; ?>"
        class="css_button link_submit" onClick="top.restoreSession()"><span><?php xl('Cancel','e'); ?></span></a>
  <?php } ?>
    </div>

    <div style="float:right; border:1px solid #774828; font-size:12px; padding:5px; width:50%; background-color:#F2DFB0; color:#774828;">
         <span>
<?php 
xl('Note:','e');
if ($viewmode) { 
xl(' Editing this Encounter will create a new visit in Synergy. Make sure to delete the visit in synergy if already created.','e');
}
xl(' Each visit for a patient should have a minimum of 1 day interval for exporting to Synergy.','e');
?>
</span>
      </div>

 </div>

<div style="clear:left; font-size:14px;">
<br />
<?php


$pid = $_SESSION['pid'];
//echo "<script>alert('".$_SESSION['pid']."');</script>";

$maxupdatedate1 = sqlFetchArray(sqlStatement("select MAX(updatedate) from episodes where pid='".$pid."' AND active='Yes'"));

if($maxupdatedate1["MAX(updatedate)"]!='' || $maxupdatedate1["MAX(updatedate)"]!=null)
$curr_episode1=sqlFetchArray(sqlStatement('SELECT *FROM episodes WHERE updatedate=\''.$maxupdatedate1["MAX(updatedate)"].'\''));

$currUser = $_SESSION['authUser'];

$chkquery = "select name from gacl_aro_groups where id=(select group_id from gacl_groups_aro_map where aro_id=(select id from gacl_aro where value='".$currUser."'))";
$groupName = sqlStatement($chkquery);
$groupIDRes = sqlFetchArray($groupName);

$accessGroup = $groupIDRes['name'];

if ($viewmode && $accessGroup=='Administrators') {

$all_episodes=sqlStatement("select id, description from episodes where pid='".$pid."' AND active='Yes'");
$all_episodes_test=sqlStatement("select id, description from episodes where pid='".$pid."' AND active='Yes'");

echo "<strong>Episode: </strong>";
echo "<select name='episode_id' id='episode_id'>";

$test=sqlFetchArray($all_episodes_test);

if($test['id']==''||$test['id']==null)
echo "<option value=''> </option>";

while($all_episodes1=sqlFetchArray($all_episodes))
{
echo "<option value='".$all_episodes1['id']."'";

if($result['episode_id']==$all_episodes1['id']){
echo " selected='selected'";
}
//echo ">".$all_episodes1['description']."</option>"; - Removed as ID is needed as Selection
echo ">".$all_episodes1['id']." - ".$all_episodes1['description']."</option>";
}
echo "</select>";
}
else if ($viewmode && $accessGroup!='Administrators') {

$epi=sqlFetchArray(sqlStatement("SELECT description FROM episodes WHERE id='".$result['episode_id']."'"));

//echo "<p><strong>Episode: </strong>".$epi['description']."</p>"; - Removed as ID is needed as Selection
echo "<p><strong>Episode: </strong>".$result['episode_id']." - ".$epi['description']."</p>";
echo "<input type='hidden' name='episode_id' value='".$result['episode_id']."' />";
}
else{
//echo "<p><strong>Current Episode: </strong>".$_SESSION['current_episode']."</p>"; - Removed as ID is needed as Selection
echo "<p><strong>Current Episode: </strong>".$curr_episode1['id']." - ".$_SESSION['current_episode']."</p>";
echo "<input type='hidden' name='episode_id' value='".$curr_episode1['id']."' />";
}


?>
</div>

<table width='96%'>

 <tr>
  <td width='33%' nowrap class='bold'><?php xl('Consultation Brief Description','e'); ?>:</td>
  <td width='34%' rowspan='2' align='center' valign='center' class='text'>
   <table>

    <tr<?php if ($GLOBALS['athletic_team']) echo " style='visibility:hidden;'"; ?>>
     <td class='bold' nowrap><?php xl('Visit Category:','e'); ?></td>
     <td class='text'>
      <select name='pc_catid' id='pc_catid'>
	<option value='_blank'>-- Select One --</option>
<?php
 $cres = sqlStatement("SELECT pc_catid, pc_catname " .
  "FROM openemr_postcalendar_categories ORDER BY pc_catname");
 while ($crow = sqlFetchArray($cres)) {
  $catid = $crow['pc_catid'];
  if ($catid < 9 && $catid != 5) continue;
  echo "       <option value='$catid'";
  if ($viewmode && $crow['pc_catid'] == $result['pc_catid']) echo " selected";
  echo ">" . xl_appt_category($crow['pc_catname']) . "</option>\n";
 }
?>
      </select>
     </td>
    </tr>

    <tr>
     <td class='bold' nowrap><?php xl('Facility:','e'); ?></td>
     <td class='text'>
      <select name='facility_id' onChange="bill_loc()">
<?php

if ($viewmode) {
  $def_facility = $result['facility_id'];
} else {
  $dres = sqlStatement("select facility_id from users where username = '" . $_SESSION['authUser'] . "'");
  $drow = sqlFetchArray($dres);
  $def_facility = $drow['facility_id'];
}
$fres = sqlStatement("select * from facility where service_location != 0 order by name");
if ($fres) {
  $fresult = array();
  for ($iter = 0; $frow = sqlFetchArray($fres); $iter++)
    $fresult[$iter] = $frow;
  foreach($fresult as $iter) {
?>
       <option value="<?php echo $iter['id']; ?>" <?php if ($def_facility == $iter['id']) echo "selected";?>><?php echo $iter['name']; ?></option>
<?php
  }
 }
?>
      </select>
     </td>
    </tr>
	<tr>
		<td class='bold' nowrap><?php echo htmlspecialchars( xl('Billing Facility'), ENT_NOQUOTES); ?>:</td>
		<td class='text'>
			<div id="ajaxdiv">
			<?php
			billing_facility('billing_facility',$result['billing_facility']);
			?>
			</div>
		</td>
     </tr>
    <tr>
<?php
 $sensitivities = acl_get_sensitivities();
 if ($sensitivities && count($sensitivities)) {
  usort($sensitivities, "sensitivity_compare");
?>
     <td class='bold' nowrap><?php xl('Sensitivity:','e'); ?></td>
     <td class='text'>
      <select name='form_sensitivity'>
<?php
  foreach ($sensitivities as $value) {
   // Omit sensitivities to which this user does not have access.
   if (acl_check('sensitivities', $value[1])) {
    echo "       <option value='" . $value[1] . "'";
    if ($viewmode && $result['sensitivity'] == $value[1]) echo " selected";
    echo ">" . xl($value[3]) . "</option>\n";
   }
  }
  echo "       <option value=''";
  if ($viewmode && !$result['sensitivity']) echo " selected";
  echo ">" . xl('None'). "</option>\n";
?>
      </select>
     </td>
<?php
 } else {
?>
     <td colspan='2'><!-- sensitivities not used --></td>
<?php
 }
?>
    </tr>

    <tr<?php if (!$GLOBALS['gbl_visit_referral_source']) echo " style='visibility:hidden;'"; ?>>
     <td class='bold' nowrap><?php xl('Referral Source','e'); ?>:</td>
     <td class='text'>
<?php
  echo generate_select_list('form_referral_source', 'refsource', $viewmode ? $result['referral_source'] : '', '');
?>
     </td>
    </tr>

    <tr>
     <td class='bold' nowrap><?php xl('Date of Service:','e'); ?></td>
     <td class='text' nowrap>
      <input type='text' size='10' name='form_date' id='form_date' <?php echo $disabled ?>
       value='<?php echo $viewmode ? substr($result['date'], 0, 10) : date('Y-m-d'); ?>'
       title='<?php xl('yyyy-mm-dd Date of service','e'); ?>'
       onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
        <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
        id='img_form_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
        title='<?php xl('Click here to choose a date','e'); ?>'>
     </td>
    </tr>

    <tr<?php if ($GLOBALS['ippf_specific'] || $GLOBALS['athletic_team']) echo " style='visibility:hidden;'"; ?>>
     <td class='bold' nowrap><?php xl('Onset/hosp. date:','e'); ?></td>
     <td class='text' nowrap><!-- default is blank so that while generating claim the date is blank. -->
      <input type='text' size='10' name='form_onset_date' id='form_onset_date'
       value='<?php echo $viewmode && $result['onset_date']!='0000-00-00 00:00:00' ? substr($result['onset_date'], 0, 10) : ''; ?>' 
       title='<?php xl('yyyy-mm-dd Date of onset or hospitalization','e'); ?>'
       onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)' />
        <img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22'
        id='img_form_onset_date' border='0' alt='[?]' style='cursor:pointer;cursor:hand'
        title='<?php xl('Click here to choose a date','e'); ?>'>
     </td>
    </tr>	
	
	

<tr>
     <td class='bold' nowrap><?php xl('Caregiver:','e'); ?></td>
     <td class='text' nowrap><!-- default is blank so that while generating claim the date is blank. -->
		<?php
		$validUsernames = sqlStatement("SELECT username FROM users WHERE active = 1 AND ( info IS NULL OR info NOT LIKE '%Inactive%' ) AND authorized = 1 ORDER BY lname, fname");
		while ($row = sqlFetchArray($validUsernames)) {
		$checkUsers = sqlStatement("select name from gacl_aro_groups where id=(select group_id from gacl_groups_aro_map where aro_id=(select id from gacl_aro where value='".$row['username']."'))");
		while ($currUser = sqlFetchArray($checkUsers)){
		if($currUser['name'] == "Physical Therapist" || $currUser['name'] == "Speech Therapist" || $currUser['name'] == "Nurse" || $currUser['name'] == "Occupational Therapist" || $currUser['name'] == "Social Worker" || $currUser['name'] == "Home Health Aide"){
		if($count==0)
		{
		$userNamesToTake = "'".$row['username']."'";
		$condition = "username IN (".$userNamesToTake.")";
		$count++;
		}
		else{
		$userNamesToTake = $userNamesToTake.",'".$row['username']."'";
		$condition = "username IN (".$userNamesToTake.")";
		}
		}
		else
		{
		if(!$condition)
		$condition = " password = '1'";
		}
		}
		}
		$ures = sqlStatement("SELECT id, fname, lname, specialty FROM users " .
		  "WHERE " .$condition.
		  " ORDER BY lname, fname");
		echo "<select name='form_caregiver' id='form_caregiver' >";
		echo "<option value='0'>" . htmlspecialchars( xl('Unassigned'), ENT_NOQUOTES) . "</option>";
		while ($urow = sqlFetchArray($ures)) {
		  $uname = htmlspecialchars( $urow['fname'] . ' ' . $urow['lname'], ENT_NOQUOTES);
		  $optionId = htmlspecialchars( $urow['id'], ENT_QUOTES);
		  echo "<option value='$optionId'";
		  if($viewmode){
		  if ($urow['id'] == $result['caregiver']){ echo " selected";}
		  }
		  echo ">$uname</option>";
		}
		echo "</select>";
		?>
     </td>
    </tr>
	
	<tr>
     <td class='bold' nowrap><?php xl('Time In:','e'); ?></td>
     <td class='text' nowrap><!-- default is blank so that while generating claim the date is blank. -->
      <input type='text' size='15' name='form_time_in' id='form_time_in'
       value='<?php echo $viewmode ? $result['time_in'] : ''; ?>' 
       title='<?php xl('Time In','e'); ?>' readonly />
     </td>
    </tr>

	<tr>
     <td class='bold' nowrap><?php xl('Time Out:','e'); ?></td>
     <td class='text' nowrap><!-- default is blank so that while generating claim the date is blank. -->
      <input type='text' size='15' name='form_time_out' id='form_time_out'
       value='<?php echo $viewmode ? $result['time_out'] : ''; ?>' 
       title='<?php xl('Time Out','e'); ?>' readonly />
     </td>
    </tr>	
	
	<tr>
     <td class='bold' nowrap><?php xl('Billing Units:','e'); ?></td>
     <td class='text' nowrap><!-- default is blank so that while generating claim the date is blank. -->
      <input type='text' size='15' name='form_billing_units' id='form_billing_units'
       value='<?php echo $viewmode ? $result['billing_units'] : ''; ?>' 
       title='<?php xl('Billing Units','e'); ?>' />
     </td>
    </tr>
	
	<tr>
     <td class='bold' nowrap><?php xl('Bill Insurance:','e'); ?></td>
     <td class='text' nowrap>
		<label><input type='radio' name='form_billing_insurance' value='True' <?php if($viewmode){if($result['billing_insurance']=='True'){echo 'checked';}}else{echo '';} ?>><?php xl('Yes','e'); ?></label>
		<label><input type='radio' name='form_billing_insurance' value='False' <?php if($viewmode){if($result['billing_insurance']=='False'){echo 'checked';}}else{echo '';} ?>><?php xl('No','e'); ?></label>
	 </td>
    </tr>
	
	<tr>
     <td class='bold' nowrap><?php xl('Notes In:','e'); ?></td>
     <td class='text' nowrap>
		<label><input type='radio' name='form_notes_in' value='True' <?php if($viewmode){if($result['notes_in']=='True'){echo 'checked';}}else{echo '';} ?>><?php xl('Yes','e'); ?></label>
		<label><input type='radio' name='form_notes_in' value='False' <?php if($viewmode){if($result['notes_in']=='False'){echo 'checked';}}else{echo '';} ?>><?php xl('No','e'); ?></label>
	 </td>
    </tr>
	
	<tr>
     <td class='bold' nowrap><?php xl('Verified:','e'); ?></td>
     <td class='text' nowrap>
		<label><input type='radio' name='form_verified' value='True' <?php if($viewmode){if($result['verified']=='True'){echo 'checked';}}else{echo '';} ?>><?php xl('Yes','e'); ?></label>
		<label><input type='radio' name='form_verified' value='False' <?php if($viewmode){if($result['verified']=='False'){echo 'checked';}}else{echo '';} ?>><?php xl('No','e'); ?></label>
	 </td>
    </tr>
	
	<tr>
     <td class='bold' nowrap><?php xl('Type of Service:','e'); ?></td>
     <td class='text' nowrap>
		<select name="form_type_of_service" id="form_type_of_service">
			  <?php
			  $res = sqlStatement("select option_id, title from list_options where list_id = 'typeofservice'");
			  print "<option value=''>Unassigned</option>\n";
			  for ($iter = 0;$row = sqlFetchArray($res);$iter++){
			    $op = "<option value='".$row["option_id"]."'";
			    if($viewmode){if($result['type_of_service']==$row["option_id"]){$op .= ' selected';}}
			    $op .= ">" . $row["title"] . "</option>\n";

			    print $op;
			  }
			  ?>
		</select>
	 </td>
    </tr>
	
	<tr>
     <td class='bold' nowrap><?php xl('Modifiers:','e'); ?></td>
     <td class='text' nowrap><?php xl('1','e'); ?><!-- default is blank so that while generating claim the date is blank. -->
      <input type='text' size='1' name='form_modifier_1' id='form_modifier_1'
       value='<?php echo $viewmode ? $result['modifier_1'] : ''; ?>' 
       title='<?php xl('Modifier 1','e'); ?>' />
	   <?php xl('2','e'); ?><!-- default is blank so that while generating claim the date is blank. -->
      <input type='text' size='1' name='form_modifier_2' id='form_modifier_2'
       value='<?php echo $viewmode ? $result['modifier_2'] : ''; ?>' 
       title='<?php xl('Modifier 2','e'); ?>' />
	   <?php xl('3','e'); ?><!-- default is blank so that while generating claim the date is blank. -->
      <input type='text' size='1' name='form_modifier_3' id='form_modifier_3'
       value='<?php echo $viewmode ? $result['modifier_3'] : ''; ?>' 
       title='<?php xl('Modifier 3','e'); ?>' />
	   <?php xl('4','e'); ?><!-- default is blank so that while generating claim the date is blank. -->
      <input type='text' size='1' name='form_modifier_4' id='form_modifier_4'
       value='<?php echo $viewmode ? $result['modifier_4'] : ''; ?>' 
       title='<?php xl('Modifier 4','e'); ?>' />
     </td>
    </tr>
	
	
	
	

    <tr>
     <td class='text' colspan='2' style='padding-top:1em'>
<?php if ($GLOBALS['athletic_team']) { ?>
      <p><i>Click [Add Issue] to add a new issue if:<br />
      New injury likely to miss &gt; 1 day<br />
      New significant illness/medical<br />
      New allergy - only if nil exist</i></p>
<?php } ?>
     </td>
    </tr>

   </table>

  </td>

  <td class='bold' width='33%' nowrap>
    <div style='float:left'>
   <?php xl('Issues (Injuries/Medical/Allergy)','e'); ?>
    </div>
    <div style='float:left;margin-left:8px;margin-top:-3px'>
<?php if ($GLOBALS['athletic_team']) { // they want the old-style popup window ?>
      <a href="#" class="css_button_small link_submit"
       onclick="return newissue()"><span><?php echo htmlspecialchars(xl('Add')); ?></span></a>
<?php } else { ?>
      <a href="../../patient_file/summary/add_edit_issue.php" class="css_button_small link_submit iframe"
       onclick="top.restoreSession()"><span><?php echo htmlspecialchars(xl('Add')); ?></span></a>
<?php } ?>
    </div>
  </td>
 </tr>

 <tr>
  <td class='text' valign='top'>
   <textarea name='reason' cols='40' rows='12' wrap='virtual' style='width:96%'
    ><?php echo $viewmode ? htmlspecialchars($result['reason']) : $GLOBALS['default_chief_complaint']; ?></textarea>
  </td>
  <td class='text' valign='top'>
   <select multiple name='issues[]' size='8' style='width:100%'
    title='<?php xl('Hold down [Ctrl] for multiple selections or to unselect','e'); ?>'>
<?php
while ($irow = sqlFetchArray($ires)) {
  $list_id = $irow['id'];
  $tcode = $irow['type'];
  if ($ISSUE_TYPES[$tcode]) $tcode = $ISSUE_TYPES[$tcode][2];

  if ($viewmode) {
    echo "    <option value='$list_id'";
    $perow = sqlQuery("SELECT count(*) AS count FROM issue_encounter WHERE " .
      "pid = '$pid' AND encounter = '$encounter' AND list_id = '$list_id'");
    if ($perow['count']) echo " selected";
    echo ">$tcode: " . $irow['begdate'] . " " .
      htmlspecialchars(substr($irow['title'], 0, 40)) . "</option>\n";
  }
  else {
    echo "    <option value='$list_id'>$tcode: ";
    echo $irow['begdate'] . " " . htmlspecialchars(substr($irow['title'], 0, 40)) . "</option>\n";
  }
}
?>
   </select>

   <p><i><?php xl('To link this encounter/consult to an existing issue, click the '
   . 'desired issue above to highlight it and then click [Save]. '
   . 'Hold down [Ctrl] button to select multiple issues.','e'); ?></i></p>

  </td>
 </tr>

</table>

</form>

</body>

<script language="javascript">
/* required for popup calendar */
Calendar.setup({inputField:"form_date", ifFormat:"%Y-%m-%d", button:"img_form_date"});
Calendar.setup({inputField:"form_onset_date", ifFormat:"%Y-%m-%d", button:"img_form_onset_date"});
<?php
if (!$viewmode) {
  $erow = sqlQuery("SELECT count(*) AS count " .
    "FROM form_encounter AS fe, forms AS f WHERE " .
    "fe.pid = '$pid' AND fe.date = '" . date('Y-m-d 00:00:00') . "' AND " .
    "f.formdir = 'newpatient' AND f.form_id = fe.id AND f.deleted = 0");
  if ($erow['count'] > 0) {
    echo "alert('" . xl('Warning: A visit was already created for this patient today! Synergy will not accept this Visit data') . "');\n";
  }
}
?>
</script>

</html>
