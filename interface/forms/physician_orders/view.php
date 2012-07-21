<?php
include_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
require_once("$srcdir/ESign.class.php");
include_once("$srcdir/sha1.js");
include_once("$srcdir/api.inc");

$obj = formFetch("forms_physician_orders", $_GET["id"]);
$physician_orders_discipline = explode("#",$obj{"physician_orders_discipline"});
$physician_orders_communication = explode("#",$obj{"physician_orders_communication"});



// get the formDir
$formDir = null;
$pathSep = "/";
if(strtolower(php_uname("s")) == "windows"|| strtolower(php_uname("s")) == "windows nt")
    $pathSep = "\\";
    
$formDirParts = explode($pathSep, __dir__);
$formDir = $formDirParts[count($formDirParts) - 1];

//get the form table -- currently manually set for each form - should be automated.
$formTable = "forms_physician_orders";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();

?>
<html><head>
<?php html_header_show();?>
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
	<style type="text/css">@import url(<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.css);</style>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script>
$(document).ready(function() {
        var status = "";
        
	$("#signoff").fancybox({
	'scrolling'		: 'no',
	'titleShow'		: false,
	'onClosed'		: function() {
	    $("#login_prompt").hide();
            
	}
        });

        $("#login_form").bind("submit", function() {

            document.getElementById("login_pass").value = SHA1(document.getElementById("login_pass").value);
            
            if ($("#login_pass").val().length < 1) {
                $("#login_prompt").show();
                $.fancybox.resize();
                return false;
            }

            $.fancybox.showActivity();

            $.ajax({
		type		: "POST",
		cache	: false,
		url		: "<?php echo $GLOBALS['rootdir'] . "/forms/$formDir/sign.php";?>",
		data		: $(this).serializeArray(),
		success: function(data) {
			$.fancybox(data);
		}
            });

            
            return false;
        });
    });


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
<body class="body_top">
<?php
include_once("$srcdir/api.inc");
$obj = formFetch("forms_physician_orders", $_GET["id"]);

?>
<form method="post"		action="<?php echo $rootdir;?>/forms/physician_orders/save.php?mode=update&&id=<?php echo $_GET['id']; ?>" name="physician_orders">
<h3 align="center"><?php xl('PHYSICIAN ORDERS','e') ?></h3>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td width="20%"><b><?php xl('PATIENT NAME','e') ?></b></td>
<td><input type="text" name="physician_orders_patient_name" size="30%" value="<?php patientName(); ?>" readonly="readonly"  /></td>
<td width="10%" align="center" valign="top"><strong><?php xl('MR#','e')?>
                                </strong></td>
                                <td width="15%" align="center" valign="top" class="bold"><input
                                        type="text" name="physician_orders_mr" id="physician_orders_mr"
                                        value="<?php  echo $_SESSION['pid']?>" readonly/></td>
                                <td width="22%" align="center" valign="top">
                                <strong><?php xl('Date of Order','e')?></strong></td>
                                <td width="17%" align="center" valign="top" class="bold">
                                <input type='text' size='10' name='physician_orders_date' id='physician_orders_date'
										value='<?php echo stripslashes($obj{"physician_orders_date"});?>'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
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
<td><input type="text" name="physician_orders_patient_dob" size="33" value="<?php patientDOB(); ?>" readonly="readonly"  /></td>

<td width="20%" align="center" valign="top">
<strong><?php xl('Physician','e')?></strong></td>
<td width="15%" align="center" valign="top" class="bold"><input
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
   <input type="text" id="icd" size="15"/>
<input type="button" value="Search" onclick="javascript:changeICDlist(physician_orders_diagnosis,document.getElementById('icd'),'<?php echo $rootdir; ?>')"/>
<span id="med_icd9">
<?php if ($obj{"physician_orders_diagnosis"} != "")
				{
				echo "<select id='physician_orders_diagnosis' name='physician_orders_diagnosis'>"; 
				echo "<option value=".stripslashes($obj{'physician_orders_diagnosis'}).">". stripslashes($obj{'physician_orders_diagnosis'})."</option>";
				echo "</select>";
				 } 
				 else 
				 { 
				 echo "<select id='physician_orders_diagnosis' name='physician_orders_diagnosis' style='display:none'> </select>";
				 }?>

</span>
<td><b><?php xl('Problem','e') ?></b></td>
<td><input type="text" name="physician_orders_problem" rows="2" style="width:95%"  value="<?php echo $obj{"physician_orders_problem"};?>"/>
</td>
</tr>
</table>
</tr>


<!-- Physician order discipline -->

<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td colspan="6" valign="top" scope="row"><strong> <?php xl('Physician Orders for the following disciplines','e')?>
				</strong> 
<br />
<label> <input type="checkbox"
						name="physician_orders_discipline[]"
						value="<?php xl('Skilled Nursing','e')?>" <?php if(in_array("Skilled Nursing",$physician_orders_discipline)) echo "checked"; ?>/> <?php xl('Skilled Nursing','e')?> </label> 

<label> 
						<input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('PT','e')?>" <?php if(in_array("PT",$physician_orders_discipline)) echo "checked"; ?>/> <?php xl('PT','e')?>
				</label>

 <label> <input type="checkbox"
						name="physician_orders_discipline[]"
						value="<?php xl('OT','e')?>" <?php if(in_array("OT",$physician_orders_discipline)) echo "checked"; ?>/> <?php xl('OT','e')?> </label>

 <label>
						 <input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('ST','e')?>" <?php if(in_array("ST",$physician_orders_discipline)) echo "checked"; ?>/> <?php xl('ST','e')?>
				</label>

 <label> <input type="checkbox"
						name="physician_orders_discipline[]"
						value="<?php xl('MSW','e')?>" <?php if(in_array("MSW",$physician_orders_discipline)) echo "checked"; ?>/> <?php xl('MSW','e')?> </label> 

<label>	<input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('HHA','e')?>" <?php if(in_array("HHA",$physician_orders_discipline)) echo "checked"; ?>/> <?php xl('HHA','e')?>
				</label> 

<label><input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('Dietary','e')?>" <?php if(in_array("Dietary",$physician_orders_discipline)) echo "checked"; ?>/> <?php xl('Dietary','e')?>
				</label> 
<label><input type="checkbox" name="physician_orders_discipline[]" value="<?php xl('Other','e')?>" <?php if(in_array("Other",$physician_orders_discipline)) echo "checked"; ?>/>
				</label> 

<label>	<?php xl('Other','e')?>	</label>&nbsp;<input type="text" style="width:39%" name="physician_orders_discipline_other" value="<?php echo $obj{"physician_orders_discipline_other"}; ?>"/>
				</td>
																						
</tr>
</table>
</tr>

<!-- Specific orders -->
<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td colspan="6" valign="top" scope="row"><strong> <?php xl('SPECIFIC ORDERS','e')?>
</strong><br /><textarea name="physician_orders_specific_orders" rows="3" cols="100"><?php echo $obj{"physician_orders_specific_orders"}; ?></textarea>
				</td>
</tr>
</table>
			</tr>

<!-- Effective date -->

<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td width="17%" align="left" valign="top" colspan="6">
        <strong><?php xl('Effective Date','e')?></strong>
                                <input type='text' size='10' name='physician_orders_effective_date' id='physician_orders_effective_date'
										value='<?php echo stripslashes($obj{"physician_orders_effective_date"});?>'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
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

<!-- communication orders -->

			<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td colspan="6" valign="top" scope="row"><strong> <?php xl('Communication of the orders have been provided to the following:','e')?>
				</strong> 
<br />
<label> <input type="checkbox"
						name="physician_orders_communication[]"
						value="<?php xl('Patient','e')?>" <?php if(in_array("Patient",$physician_orders_communication)) echo "checked"; ?>/> <?php xl('Patient','e')?> </label> <label> 
						<input type="checkbox" name="physician_orders_communication[]" value="<?php xl('Caregiver','e')?>" <?php if(in_array("Caregiver",$physician_orders_communication)) echo "checked"; ?>/> <?php xl('Caregiver','e')?>
				</label> <label> <input type="checkbox"
						name="physician_orders_communication[]"
						value="<?php xl('SN','e')?>" <?php if(in_array("SN",$physician_orders_communication)) echo "checked"; ?>/> <?php xl('SN','e')?> </label> <label>
						 <input type="checkbox" name="physician_orders_communication[]" value="<?php xl('PT/OT/ST','e')?>" <?php if(in_array("PT/OT/ST",$physician_orders_communication)) echo "checked"; ?>/> <?php xl('PT/OT/ST','e')?>
				</label> <label> <input type="checkbox"
						name="physician_orders_communication[]"
						value="<?php xl('HHA','e')?>" <?php if(in_array("HHA",$physician_orders_communication)) echo "checked"; ?>/> <?php xl('HHA','e')?> </label>
						
						<label> <input type="checkbox"
						name="physician_orders_communication[]"
						value="<?php xl('Other','e')?>" <?php if(in_array("Other",$physician_orders_communication)) echo "checked"; ?>/></label>

<label><?php xl('Other','e')?>&nbsp;</label> <input type="text" style="width:51%" name="physician_orders_communication_other" value="<?php echo $obj{"physician_orders_communication_other"}; ?>"/>
				</td>
</tr>
</table>
			</tr>

<!-- Physician Signature, Date -->
<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td width="60%">
<label><strong><?php xl('Physician Signature','e')?></strong></label> <input type="text" style="width:70%" name="physician_orders_physician_signature" value="<?php echo $obj{"physician_orders_physician_signature"}; ?>"/>
				</td>
<td width="40%" align="left" valign="top" colspan="6">
        <strong><?php xl('Date','e')?></strong>
                                <input type='text' size='10' name='physician_orders_date1' id='physician_orders_date1'
										value='<?php echo stripslashes($obj{"physician_orders_date1"});?>'
                                        title='<?php xl('yyyy-mm-dd Date of Birth','e'); ?>'
                                        onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly/>
                                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                                        height='22' id='img_curr_date2' border='0' alt='[?]'
                                        style='cursor: pointer; cursor: hand'
                                        title='<?php xl('Click here to choose a date','e'); ?>'>
                                        <script LANGUAGE="JavaScript">
    Calendar.setup({inputField:"physician_orders_date1", ifFormat:"%Y-%m-%d", button:"img_curr_date2"});
   </script>
                                </td>
</tr>
</table>
</tr>

<!-- Clinician Name, elec signature -->

<tr>
<table class="formtable" width="100%" border="1px solid #000000" Style="border : 0px;" cellpadding="5px" cellspacing="0px">
<tr>
<td colspan="3" width="50%">
<label><strong><?php xl('Clinician Name/Title','e')?></strong></label>
				</td>
<td colspan="3" valign="top" width="50%"><strong><?php xl('Electronic Signature','e')?>
	</strong></td>
</tr>
</table>
</tr>





<!-- End of form -->


</table>
<a href="javascript:top.restoreSession();document.physician_orders.submit();"
                        class="link_submit"><?php xl(' [Save]','e')?></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $GLOBALS['form_exit_url']; ?>" class="link" style="color: #483D8B"
 onclick="top.restoreSession()">[<?php xl('Don\'t Save','e'); ?>]</a>

</form>
<center>
        <table>
            <tr>
                <td align="center">
                    <?php if($action == "edit") { ?>
                    <input type="submit" name="Submit" value="Save Form" > &nbsp;&nbsp;
                    <? } ?>
                    </form>
                    <input type="button" value="Back" onclick="top.restoreSession();window.location='<?php echo $GLOBALS['webroot'] ?>/interface/patient_file/encounter/encounter_top.php';"/>&nbsp;&nbsp;
                    <?php if($action == "review") { ?>
                    <input type="button" value="Sign" id="signoff" href="#login_form" <?php echo $signDisabled;?> />
                    <? } ?>
                </td>
            </tr>
            <tr><td>

                    <div id="signature_log" name="signature_log">
                        <?php $esign->getDefaultSignatureLog(true);?>
                    </div>
                </td></tr>
            </table>
        </center>
    </body>
    <div style="display:none">
	<form id="login_form" method="post" action="">
            <p><center><span style="font-size:small;">
                        <p id="login_prompt" style="font-size:small;">Enter your password to sign:</p>
                        <input type="hidden" name="sig_status" value="approved" />
                        <input type="hidden" id="tid" name="tid" value="<?php echo $id;?>"/>
                        <input type="hidden" id="table_name" name="table_name" value="<?php echo $formTable;?>"/>
			<input type="hidden" id="signature_uid" name="signature_uid" value="<?php echo $_SESSION['authUserID'];?>"/>
                        <input type="hidden" id="signature_id" name="signature_id" value="<?php echo $sigId->getId();?>" />
                        <input type="hidden" id="exam_name" name="exam_name" value="<?php echo $registryRow['nickname'];?>" />
                        <input type="hidden" id="exam_pid" name="exam_pid" value="<?php echo $obj['pid'];?>" />
                        <input type="hidden" id="exam_date" name="exam_date" value="<?php echo $obj['date'];?>" />
			<label for="login_pass">Password: </label>
			<input type="password" id="login_pass" name="login_pass" size="10" />
                    </span>
                </center></p>
		<p>
			<input type="submit" value="Sign" />
		</p>
	</form>
</div>

</body>
</html>

	
