<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
include_once("$srcdir/api.inc");
formHeader("Form: physician_orders");
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

<script type="text/javascript">

function pullAjax(){
    var a;
    try{
      a=new XMLHttpRequest();
    }
    catch(b)
    {
      try
      {
        a=new ActiveXObject("Msxml2.XMLHTTP");
      }catch(b)
      {
        try
        {
          a=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(b)
        {
         return false;
        }
      }
    }
    return a;
  }


function changeICDlist(dx,code,rootdir)
          {
            site_root = rootdir; 
            Dx = dx.name;
            icd9code = code.value;                 
            obj=pullAjax();        
            obj.onreadystatechange=function()
            {
              if(obj.readyState==4)
              { 
                 eval("result = "+obj.responseText);
                 med_icd9.innerHTML= result['res'];
                 return true;                          
              }
            };
            obj.open("GET",site_root+"/forms/physician_orders/functions.php?code="+icd9code+"&Dx="+Dx,true);    
            obj.send(null);
          }      
        </script>

</head>

<body>
<form method="post"		action="<?php echo $rootdir;?>/forms/physician_orders/save.php?mode=new" name="physician_orders">
		<h3 align="center"><?php xl('PHYSICIAN ORDERS','e') ?></h3>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td width="20%"><b><?php xl('PATIENT NAME','e') ?></b></td>
<td><input type="text" name="physician_orders_patient_name" size="30%" value="<?php patientName(); ?>" readonly  /></td>
<td width="10%" align="center" valign="top"><strong><?php xl('MR#','e')?>
                                </strong></td>
                                <td width="15%" align="center" valign="top" class="bold"><input
                                        type="text" name="physician_orders_mr" id="physician_orders_mr"
                                        value="<?php  echo $_SESSION['pid']?>" readonly/></td>
                                <td width="22%" align="center" valign="top">
                                <strong><?php xl('Date of Order','e')?></strong></td>
                                <td width="17%" align="center" valign="top" class="bold">
                                <input type='text' size='10' name='physician_orders_date' id='physician_orders_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"physician_orders_date", ifFormat:"%Y-%m-%d", button:"img_curr_date"});
   </script>
                                </td>
</tr>

<!-- Patient DOB and Physician -->
<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td><b><?php xl('Patient Date of Birth','e') ?></b></td>
<td colspan="2"><input type="text" name="physician_orders_patient_dob" size="33" value="<?php patientDOB(); ?>" readonly /></td>

<td width="20%" align="center" valign="top">
<strong><?php xl('Physician','e')?></strong></td>
<td width="15%" align="center" valign="top" class="bold" colspan="2"><input
                                        type="text" size="33" name="physician_orders_physician" id="physician_orders_physician"
                                        value="<?php doctorname(); ?>" readonly/></td>
</tr>
</table>
</tr>



<!-- Diagnosis and Problem -->
<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
    <td scope="row" width="50%"><strong><?php xl('Diagnosis','e');?> </strong>
   <input type="text" id="physician_orders_diagnosis" name="physician_orders_diagnosis" style="width:100%;"/>
<td><b><?php xl('Problem','e') ?></b></td>
<td><input type="text" name="physician_orders_problem" style="width:95%"  value=""/></td>
</tr>
</table>
</tr>



<!-- Physician Order Discipline -->
<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
	<td colspan="6" valign="top" scope="row"><strong> <?php xl('Physician Orders for the following disciplines','e')?>
				</strong>
<br />
 
<label><input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('Skilled Nursing','e')?>" /><?php xl('Skilled Nursing','e')?> </label>

<label><input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('PT','e')?>" /> <?php xl('PT','e')?></label> 

<label><input type="checkbox"	name="physician_orders_discipline[]" value="<?php xl('OT','e')?>" /><?php xl('OT','e')?> </label>

<label><input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('ST','e')?>" /> <?php xl('ST','e')?>

</label> <label> <input type="checkbox"	name="physician_orders_discipline[]" value="<?php xl('MSW','e')?>" />
<?php xl('MSW','e')?> </label>

<label><input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('HHA','e')?>" /> <?php xl('HHA','e')?>
</label>

<label><input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('Dietary','e')?>" /> <?php xl('Dietary','e')?>
</label>
<label><input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('Other','e')?>" />
</label>
<label><?php xl('Other','e')?></label>&nbsp;
<input type="text" style="width:41%" name="physician_orders_discipline_other" />
			
</td>
</tr>
</table>
</tr>


<!-- specific orders -->

<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
			<td colspan="6" valign="top" scope="row"><strong> <?php xl('Specific Orders','e')?>
				</strong><br /><textarea name="physician_orders_specific_orders" rows="3" cols="100"></textarea>
				</td>
</tr>
</table>
	</tr>


<!-- Effective Date -->
<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td width="22%" align="left" valign="top" colspan="6">
        <strong><?php xl('Effective Date','e')?></strong>
  <input type='text' size='10' name='physician_orders_effective_date' id='physician_orders_effective_date'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
  <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date1' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"physician_orders_effective_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
   </script>
                                </td>
</tr>
</table>
</tr>


<!-- Communication Order -->

<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td colspan="6" valign="top" scope="row"><strong>
<?php xl('Communication of the orders have been provided to the following:','e')?></strong>
<br />

<label><input type="checkbox" name="physician_orders_communication[]" value="<?php xl('Patient','e')?>" /><?php xl('Patient','e')?>
</label>

<label><input type="checkbox" name="physician_orders_communication[]" value="<?php xl('Caregiver','e')?>" /> <?php xl('Caregiver','e')?>
</label> 

<label><input type="checkbox" name="physician_orders_communication[]" value="<?php xl('SN','e')?>" /><?php xl('SN','e')?> </label>

<label><input type="checkbox" name="physician_orders_communication[]" value="<?php xl('PT','e')?>" /> <?php xl('PT','e')?></label>

<label><input type="checkbox" name="physician_orders_communication[]" value="<?php xl('OT','e')?>" /> <?php xl('OT','e')?></label>

<label><input type="checkbox" name="physician_orders_communication[]" value="<?php xl('ST','e')?>" /> <?php xl('ST','e')?></label>

<label><input type="checkbox" name="physician_orders_communication[]" value="<?php xl('MSW','e')?>" /> <?php xl('MSW','e')?></label>

<label><input type="checkbox" name="physician_orders_communication[]" value="<?php xl('HHA','e')?>" /> <?php xl('HHA','e')?>
</label>

<label><input type="checkbox" name="physician_orders_communication[]" value="<?php xl('Other','e')?>" />
</label>

<label><?php xl('Other','e')?></label>&nbsp;
<input type="text" style="width:51%" name="physician_orders_communication_other" />
			
</td>
</tr>
</table>
</tr>

<!-- Physician Signature, Date -->

<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td width="60%"><label><strong><?php xl('Physician Signature','e')?></strong></label>
<input type="text" style="width:70%" name="physician_orders_physician_signature" /></td>

<td width="40%" align="left" valign="top">
        <strong><?php xl('DATE','e')?></strong>
  <input type='text' size='10' name='physician_orders_date1' id='physician_orders_date1'
                                        title='<?php xl('Date','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
  <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date2' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"physician_orders_date1", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
                                </td></tr>
</table>
</tr>

<!-- Clinician Name, elec signature -->

<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
	<td colspan="3" valign="top" scope="row" width="50%"><strong><?php xl('Clinician Name/Title','e')?>
	</strong></td>
	<td colspan="3" valign="top" width="50%"><strong><?php xl('Electronic Signature','e')?>
	</strong></td>
</tr>
</table>
</tr>


</table>




<a href="javascript:top.restoreSession();document.physician_orders.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B" onClick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
</body>
</html>
