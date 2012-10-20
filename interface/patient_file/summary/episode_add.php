<?php

// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

 require_once("../../globals.php");

?>

<?php

/*****************************       Insert New Episode Begins      ****************************************/

if($_POST['flag']=='new' && isset($_POST['flag']))
{

$update_epi_num =sqlStatement("UPDATE episode_num SET id=id+1");

$query="INSERT INTO episodes (
episode_number,
description,
episode_start_date,
episode_length,
episode_end_date,
admit_status,
active,
reminder,
pid) VALUES (
(SELECT id FROM episode_num),
'".mysql_real_escape_string($_POST['episode_description'])."',
'".$_POST['episode_start_date']."',
".$_POST['episode_length'].",
'".$_POST['episode_end_date']."',
'".$_POST['episode_admit_status']."',
'".$_POST['episode_active']."',
'".$_POST['episode_set_reminder']."',
".$_SESSION['pid'].")";

$res=sqlStatement($query);

$date = @date("Y-m-d",@strtotime($_POST['episode_start_date']));
$end_date = @date('Y-m-d', @strtotime($date. " + ".$_POST['episode_length']." days"));
$rem_date = @date('Y-m-d', @strtotime($end_date. " - 7 days"));

$currUser = $_SESSION['authUser'];
$curr_id1 = sqlFetchArray(sqlStatement("select id from users where username='".$currUser."'"));


if($_POST['episode_set_reminder']=='Yes')
{
$qry="insert into dated_reminders(
dr_from_ID, 
dr_message_text, 
dr_message_sent_date, 
dr_message_due_date, 
pid, 
message_priority, 
message_processed, 
processed_date, 
dr_processed_by,
episode_id) values(".$curr_id1['id'].",
'Episode - ".$_POST['episode_description']." expires on ".$end_date."',
CURRENT_TIMESTAMP,'".$rem_date."',".$_SESSION['pid'].",3,0,'0000-00-00 00:00:00',0,
(SELECT id FROM episode_num))";

$dt_reminder=sqlStatement($qry);


$chkquery = "select name from gacl_aro_groups where id=(select group_id from gacl_groups_aro_map where aro_id=(select id from gacl_aro where value='".$currUser."'))";
$groupName = sqlStatement($chkquery);
$groupIDRes = sqlFetchArray($groupName);
$accessGroup = $groupIDRes['name'];

$user_qry = sqlStatement("select id from users where username in (select value from gacl_aro where id in ( select aro_id from gacl_groups_aro_map where group_id in ( select id from gacl_aro_groups where name='Administrators')))");

if($accessGroup=='Administrators')
{
while($user_id=sqlFetchArray($user_qry))
{
$qry1 = sqlStatement("insert into dated_reminders_link(dr_id,to_id) values((select MAX(dr_id) from dated_reminders),".$user_id['id'].")");
}
}
else{
while($user_id=sqlFetchArray($user_qry))
{
$qry1 = sqlStatement("insert into dated_reminders_link(dr_id,to_id) values((select MAX(dr_id) from dated_reminders),".$user_id['id'].")");
}
$curr_id = sqlFetchArray(sqlStatement("select id from users where username='".$currUser."'"));
$qry2 = sqlStatement("insert into dated_reminders_link(dr_id,to_id) values((select MAX(dr_id) from dated_reminders),".$curr_id['id'].")");
}
}

header('Location: demographics.php');

}
/*****************************       Insert New Episode Ends        ****************************************/

?>


<html>

<head>
<?php html_header_show();?>
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../library/js/fancybox/jquery.fancybox-1.2.6.css" media="screen" />
<style type="text/css">@import url(../../../library/dynarch_calendar.css);</style>
<script type="text/javascript" src="../../../library/textformat.js"></script>
<script type="text/javascript" src="../../../library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="../../../library/dynarch_calendar_setup.js"></script>
<script type="text/javascript" src="../../../library/dialog.js"></script>
<script type="text/javascript" src="../../../library/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../../../library/js/common.js"></script>
<script type="text/javascript" src="../../../library/js/fancybox/jquery.fancybox-1.2.6.js"></script>



<script type="text/javascript">
function submitform() {

var err_indicator=0;

if(document.getElementById('episode_description').value.length < 1){
$('#episode_description').css({'border':'1px solid red','background-color':'#FBEDBB'});
err_indicator=1;
}
if(document.getElementById('episode_start_date').value.length < 1){
$('#episode_start_date').css({'border':'1px solid red','background-color':'#FBEDBB'});
err_indicator=1;
}
if(document.getElementById('episode_length').value.length < 1){
$('#episode_length').css({'border':'1px solid red','background-color':'#FBEDBB'});
err_indicator=1;
}


if(err_indicator==0)
{
document.getElementById('flag').value='new';
//alert(document.getElementById('flag').value);
document.forms[0].submit();
}

}

$(document).ready(function(){
    $("#cancel").click(function() {
		  parent.$.fn.fancybox.close();
	 });

});

</script>




<style type='text/css'>

body,table{
font-size:10pt;
}

td{
height:25px;
}

.label{
/* text-align:left !important; */
}
</style>
</head>

<body class="body_top">


<table><tr><td>
<span class="title">New Episode</span>&nbsp;</td>
<td>
<a class="css_button" name='form_save' id='form_save' href='#' onclick="return submitform()">
	<span>Save</span></a>
<a class="css_button large_button" id='cancel' href='#'>
	<span class='css_button_span large_button_span'>Cancel</span>
</a>
</td></tr></table>


<form name='new_episode' method='post'  target="_parent" action="episode_add.php" onsubmit='return top.restoreSession()'>
<input type="hidden" name="flag" id="flag" value="no" />
<table border=0 cellpadding=0 cellspacing=0 style="width:600px;">
<tbody>

<tr>
<td colspan="2">
<?php xl('Description:','e')?><br />
<textarea name="episode_description" id="episode_description" rows="6" cols="48"></textarea>
</td>
</tr>

<tr>
<td colspan="2">&nbsp;</td>
</tr>

<tr>
<td width="175px">
<?php xl('Episode Start Date:','e')?><br />
</td>
<td align="left">
<input type='text' size='10' name='episode_start_date' id='episode_start_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' readonly onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date1' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"episode_start_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
                        </script>
</td>
</tr>

<tr>
<td width="175px">
<?php xl('Episode Length:','e')?><br />
</td>
<td align="left">
<select name="episode_length" id="episode_length">
<?php
for($i=1;$i<=365;$i++)
{
echo "<option value='".$i."'";
if($i==60)
echo " selected='selected'";
echo ">".$i."</option>";
}
?>
</select>
<?php xl('Days','e')?>
</td>
</tr>

<tr>
<td width="175px">
<?php xl('Episode End Date:','e')?><br />
</td>
<td align="left">
<input type='text' size='10' name='episode_end_date' id='episode_end_date'
                        title='<?php xl('yyyy-mm-dd Visit Date','e'); ?>' readonly onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date2' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"episode_end_date", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
                        </script>
</td>
</tr>

<tr>
<td width="175px">
<?php xl('Admit Status:','e')?><br />
</td>
<td align="left">
<select name="episode_admit_status" id="episode_admit_status">
<option value=""><?php xl('Unassigned','e')?></option>
<?php
$qry3 = sqlStatement("SELECT title FROM list_options WHERE list_id='admit_status'");

while($admit_title=sqlFetchArray($qry3))
{
echo "<option value='".$admit_title['title']."'>".$admit_title['title']."</option>";
}

?>

</select>
</td>
</tr>

<tr>
<td width="175px">
<?php xl('Active:','e')?><br />
</td>
<td align="left">
<select name="episode_active" id="episode_active">

<?php
$qry4 = sqlStatement("SELECT title FROM list_options WHERE list_id='yesno'");

while($yesno=sqlFetchArray($qry4))
{

if($yesno['title']=="NO"){
$val="No";}
else if($yesno['title']=="YES"){
$val="Yes";}
else{
$val=$yesno['title'];
}

echo "<option value='".$val."' ";
if($val=="Yes"){echo " selected='selected'";}
echo ">".$yesno['title']."</option>";
}

?>

</select>
</td>
</tr>

<tr>
<td width="175px">
<?php xl('Set Reminder:','e')?><br />
</td>
<td align="left">
<select name="episode_set_reminder" id="episode_set_reminder">

<?php
$qry5 = sqlStatement("SELECT title FROM list_options WHERE list_id='yesno'");

while($yesno=sqlFetchArray($qry5))
{

if($yesno['title']=="NO"){
$val="No";}
else if($yesno['title']=="YES"){
$val="Yes";}
else{
$val=$yesno['title'];
}

echo "<option value='".$val."' ";
if($yesno['title']=='NO'){echo "selected='selected'";}
echo ">".$yesno['title']."</option>";
}

?>

</select>
</td>
</tr>

</tbody>
</table>

</body>
</html>
<?php


?>