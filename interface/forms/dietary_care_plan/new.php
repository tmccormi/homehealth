<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: dietary_care_plan");
?>

<html>
<head>
<title><?php xl('DIETARY CARE PLAN','e')?></title>
<style type="text/css">
.bold {
	font-weight: bold;
}
.padd { padding-left:20px }
</style>
<style type="text/css">
@import url(<?php echo $GLOBALS['webroot']?>/library/dynarch_calendar.css);</style>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>


</head>

<body>
<form method="post"		action="<?php echo $rootdir;?>/forms/dietary_care_plan/save.php?mode=new" name="dietary_care_plan">
		<h3 align="center"><?php xl('DIETARY CARE PLAN','e')?></h3>
<table cellspacing="0px" width="100%" border="1px solid #000000" Style="border : 0px;" class="formtable" cellpadding="5px" width="100%">
<tr><td style="padding : 0px;">
<table  width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px"  class="formtable"><tr>
<td align="center"><b><?php xl('Last Name','e')?></b></td>
<td><input style="width : 100%;" type="text" name="dietary_care_plan_last_name" value="<?php patientName("lname"); ?>" readonly="readonly" /></td>
<td align="center"><b><?php xl('First Name','e')?></b></td>
<td><input style="width : 100%;" type="text" name="dietary_care_plan_first_name" value="<?php patientName("fname"); ?>" readonly="readonly"></td>
<td align="center"><b><?php xl('Visit Date','e')?></b></td>
<td><input type='text' style="width : 80%;" name='dietary_care_plan_visit_date' value="<?php visitdate(); ?>" readonly="readonly"  /></td>
		
</tr></table>
</td></tr>

<tr><td style="padding : 0px;">
<table width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" class="formtable" cellspacing="0px" width="100%"><tr>
<td align="center"><b><?php xl('DOB','e')?></b></td>
<td><input type='text' size='10' name='dietary_care_plan_dob' id='dietary_care_plan_dob' value="<?php patientName("DOB"); ?>" readonly="readonly"/></td>
<td align="center"><b><?php xl('Sex','e')?></b></td>
<td><input type="text" style="width : 52px;" name="dietary_care_plan_sex" value="<?php patientName("sex"); ?>" readonly="readonly"></td>
<td align="center"><b><?php xl('Weight','e')?></b></td>
<td><input type="text" name="dietary_care_plan_weight"></td>
<td align="center"><b><?php xl('Height','e')?></b></td>
<td><input type="text" name="dietary_care_plan_height"></td>
</tr></table>
</td></tr>

<tr><td><font style="font-size: 13px;"><b><?php xl('DIAGNOSIS RELATED TO DIETARY ISSUES','e')?></b></font></td></tr>

<tr><td>
<b><?php xl('Frequency and Duration: ','e')?></b> <input style="width: 44%;" type="text" name="dietary_care_plan_frequency_and_duration">
</td></tr>

<tr><td>
<b><?php xl('Short Term Goals','e')?></b><br/>
<textarea rows="3" cols="100" name="dietary_care_plan_short_term_goals"></textarea>
</td></tr>

<tr><td>
<b><?php xl('Long Term Goals','e')?></b><br/>
<textarea rows="3" cols="100" name="dietary_care_plan_long_term_goals"></textarea>
</td></tr>

<tr><td>
<b><?php xl('Treatment Plan','e')?></b><br/>
<textarea rows="3" cols="100" name="dietary_care_plan_treatment"></textarea>
</td></tr>

<tr><td style="padding : 0px">
<table width="100%" border="1px solid #000000" Style="border : 0px;" cellspacing="0px" cellpadding="5px" class="formtable"><tr>
<td style="width : 25%;"><b><?php xl('RD Signature','e')?></b></td>
<td style="width : 25%;"></td>
<td style="width : 25%;"><b><?php xl('Date','e')?></b></td>
<td style="width : 25%;"></td>
</tr></table></td></tr>

</table>
<a href="javascript:top.restoreSession();document.dietary_care_plan.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
