<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
formHeader("Form: IDT_care");
?>

<html>
<head>
<title><?php xl('CARE PLAN','e')?></title>
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
<form method="post"		action="<?php echo $rootdir;?>/forms/IDT_care/save.php?mode=new" name="IDT_care">
		<h3 align="center"><?php xl('IDT-CARE COORDINATION NOTE','e') ?></h3>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td><b><?php xl('PATIENT NAME','e') ?></b></td>
<td><input type="text" name="idt_care_patient_name" size="40" value="<?php patientName(); ?>" readonly  /></td>
<td width="10%" align="center" valign="top"><strong><?php xl('MR#','e')?>
                                </strong></td>
                                <td width="15%" align="center" valign="top" class="bold"><input
                                        type="text" name="idt_care_mr" id="idt_care_mr"
                                        value="<?php  echo $_SESSION['pid']?>" readonly/></td>
                                <td width="7%" align="center" valign="top">
                                <strong><?php xl('DATE','e')?></strong></td>
                                <td width="17%" align="center" valign="top" class="bold">
                                <input type='text' size='10' name='idt_care_date' id='idt_care_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"idt_care_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
                                </td>
</tr>

<tr>
	<td colspan="6" valign="top" scope="row"><strong> <?php xl('CARE COORDINATION INVOLVED IN THE FOLLOWING DISCIPLINE(S)','e')?>
				</strong>
				</td>
			</tr>
			<tr><td colspan="6">
			<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
			<tr>
				<td valign="top" scope="row" width="33%"><label> <input
				type="checkbox" name="idt_care_care_coordination_involved_discipline[]" value="<?php xl('Skilled Nursing','e')?>"/> <?php xl('Skilled Nursing','e')?>
				</label> <br /> <label> <input type="checkbox" name="idt_care_care_coordination_involved_discipline[]" value="<?php xl('Physical Therapy','e')?>"/> <?php xl('Physical Therapy','e')?> </label>

					<br /> <label> <input type="checkbox" name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Occupational Therapy','e')?>"/> <?php xl('Occupational Therapy','e')?> </label>
					<br />	</td>
				<td valign="top">
					<p>
						<label> <input type="checkbox" name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Home Health Aide','e')?>"/> <?php xl('Home Health Aide','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Medical Social Worker','e')?>"/> <?php xl('Medical Social Worker','e')?>
						</label> <br /> <label> <input type="checkbox"
							name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Speech Language Pathologist','e')?>"/> <?php xl('Speech Language Pathologist','e')?><br />
				</td>
				<td valign="top">
					<p>
						<label> <input type="checkbox" name="idt_care_care_coordination_involved_discipline[]"  value="<?php xl('Dietician','e')?>"/> <?php xl('Dietician','e')?></label>
					</p>
					<p>
						<?php xl(' Other','e')?> <input type="text"
							name="idt_care_care_coordination_involved_other" rows="2" style="width:75%"  value=""/>
					</p>

				</td> </tr>
				</table></td>
			</tr>

<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('CARE COMMUNICATED VIA','e')?>
				</strong> <label> <input type="checkbox"
						name="idt_care_care_communicated_via"
						value="<?php xl('IDT Meeting','e')?>" /> <?php xl('IDT Meeting','e')?> </label> <label> 
						<input type="checkbox" name="idt_care_care_communicated_via" value="<?php xl('1:1 Clinician/Clinical Supervisor','e')?>" /> <?php xl('1:1 Clinician/Clinical Supervisor','e')?>
				</label> <label> <input type="checkbox"
						name="idt_care_care_communicated_via"
						value="<?php xl('Phone Conference','e')?>" /> <?php xl('Phone Conference','e')?> </label> <label>
						 <input type="checkbox" name="idt_care_care_communicated_via"
						 value="<?php xl('Electronic Medical Records','e')?>" /> <?php xl('Electronic Medical Records','e')?>
				</label> <label> <input type="checkbox"
						name="idt_care_care_communicated_via"
						value="<?php xl('Fax','e')?>" /> <?php xl('Fax','e')?> </label> <label>
						<input type="checkbox" name="idt_care_care_communicated_via" value="<?php xl('Mail','e')?>" /> <?php xl('Mail','e')?>
				</label><label>&nbsp;&nbsp;
						<?php xl('Other','e')?>
				</label> <input type="text" style="width:81%" name="idt_care_care_communicated_via_other"  value=""/>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('TOPIC FOR DISCUSSION(Check all that apply)','e')?>
				</strong>
<br />
 <label> <input type="checkbox"
						name="idt_care_topic_for_discussion[]"
						value="<?php xl('Review Patient Current Status','e')?>" /> <?php xl('Review Patient Current Status','e')?> </label> <label> 
						<input type="checkbox" name="idt_care_topic_for_discussion[]" value="<?php xl('Patient Change of Condition','e')?>" /> <?php xl('Patient Change of Condition','e')?>
				</label> <label> <input type="checkbox"
						name="idt_care_topic_for_discussion[]"
						value="<?php xl('Update Plan of Care','e')?>" /> <?php xl('Update Plan of Care','e')?> </label> <label>
						 <input type="checkbox" name="idt_care_topic_for_discussion[]" value="<?php xl('Coordination between Disciplines','e')?>" /> <?php xl('Coordination between Disciplines','e')?>
				</label> <label> <input type="checkbox"
						name="idt_care_topic_for_discussion[]"
						value="<?php xl('Recertification','e')?>" /> <?php xl('Recertification','e')?> </label> <label>
						<input type="checkbox" name="idt_care_topic_for_discussion[]" value="<?php xl('Discharge Plans','e')?>" /> <?php xl('Discharge Plans','e')?>
				</label> <label> &nbsp;&nbsp;&nbsp;
						<?php xl('Other','e')?>
				</label> <input type="text" style="width:65%" name="idt_care_topic_for_discussion_other" />
				</td>
			</tr>

<!--Details for discussion, resolution, people -->

			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('DETAILS OF DISCUSSION','e')?>
				</strong><br /><textarea name="idt_care_details_of_discussion" rows="3" cols="98"></textarea>
				</td>
			</tr>
			
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('DETAILS FOR RESOLUTIONS/FOLLOW-UP','e')?>
				</strong><br /><textarea name="idt_care_details_for_resolutions" rows="4" cols="98"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="6" valign="top" scope="row"><strong> <?php xl('PEOPLE/DISCIPLINES ATTENDING','e')?>
				</strong><br /><textarea name="idt_care_people_descipline_attending" rows="3" cols="98"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="top" scope="row"><strong><?php xl('Clinician Name/Title Completing Note','e')?>
				</strong><input type="text" name="idt_care_clinical_name_title_completing" value=""></td>
				<td colspan="3" valign="top"><strong><?php xl('Electronic Signature','e')?>
				</strong></td>
			</tr>


</table>




<a href="javascript:top.restoreSession();document.IDT_care.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
