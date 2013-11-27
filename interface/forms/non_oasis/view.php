<?php
require_once("../../globals.php");
include_once ("functions.php");
include_once("../../calendar.inc");
                
/* include api.inc. also required. */
require_once($GLOBALS['srcdir'].'/api.inc');

/* include our smarty derived controller class. */
require($GLOBALS['fileroot'] . '/interface/clickmap/C_FormPainMap.class.php');
formHeader("Form: non_oasis");
require_once("$srcdir/ESign.class.php");
include_once("$srcdir/sha1.js");
// get the formDir
$formDir = null;
$pathSep = "/";
if(strtolower(php_uname("s")) == "windows"|| strtolower(php_uname("s")) == "windows nt")
    $pathSep = "\\";

$formDirParts = explode($pathSep, __dir__);
$formDir = $formDirParts[count($formDirParts) - 1];

//get the form table -- currently manually set for each form - should be automated.
$formTable = "forms_non_oasis";

if($formDir)
    $registryRow = sqlQuery("select * from registry where directory = '$formDir'");

$esign = new ESign();
$esign->init($id, $formTable);

$sigId = $esign->getNewestUnsignedSignature();
?>
<?php
include_once("$srcdir/api.inc");

$obj = formFetch("forms_non_oasis", $_GET["id"]);

$val = array();
foreach($obj as $k => $v) {
	$key = $k;
	$$key = explode('#',$v);
}

foreach($obj as $key => $value) {
    $obj[$key] = htmlspecialchars($value);
}

$non_oasis_nutrition_eat_patt1 = explode("#",$obj{"non_oasis_nutrition_eat_patt1"});
$non_oasis_nutrition_risks = explode("#",$obj{"non_oasis_nutrition_risks"});
$non_oasis_vital_pulse = explode("#",$obj{"non_oasis_vital_pulse"});
$non_oasis_cardio_breath1 = explode("#",$obj{"non_oasis_cardio_breath1"});
$non_oasis_cardio_heart_sounds = explode("#",$obj{"non_oasis_cardio_heart_sounds"});

$non_oasis_wound_lesion_location = explode("#",$obj{"non_oasis_wound_lesion_location"});
$non_oasis_wound_lesion_type = explode("#",$obj{"non_oasis_wound_lesion_type"});
$non_oasis_wound_lesion_status = explode("#",$obj{"non_oasis_wound_lesion_status"});
$non_oasis_wound_lesion_size_length = explode("#",$obj{"non_oasis_wound_lesion_size_length"});
$non_oasis_wound_lesion_size_width = explode("#",$obj{"non_oasis_wound_lesion_size_width"});
$non_oasis_wound_lesion_size_depth = explode("#",$obj{"non_oasis_wound_lesion_size_depth"});
$non_oasis_wound_lesion_stage = explode("#",$obj{"non_oasis_wound_lesion_stage"});
$non_oasis_wound_lesion_tunneling = explode("#",$obj{"non_oasis_wound_lesion_tunneling"});
$non_oasis_wound_lesion_odor = explode("#",$obj{"non_oasis_wound_lesion_odor"});
$non_oasis_wound_lesion_skin = explode("#",$obj{"non_oasis_wound_lesion_skin"});
$non_oasis_wound_lesion_edema = explode("#",$obj{"non_oasis_wound_lesion_edema"});
$non_oasis_wound_lesion_stoma = explode("#",$obj{"non_oasis_wound_lesion_stoma"});
$non_oasis_wound_lesion_appearance = explode("#",$obj{"non_oasis_wound_lesion_appearance"});
$non_oasis_wound_lesion_drainage = explode("#",$obj{"non_oasis_wound_lesion_drainage"});
$non_oasis_wound_lesion_color = explode("#",$obj{"non_oasis_wound_lesion_color"});
$non_oasis_wound_lesion_consistency = explode("#",$obj{"non_oasis_wound_lesion_consistency"});

$non_oasis_wound = explode("#",$obj{"non_oasis_wound"});
$non_oasis_infusion = explode("#",$obj{"non_oasis_infusion"});
$non_oasis_infusion_purpose = explode("#",$obj{"non_oasis_infusion_purpose"});
$non_oasis_enteral = explode("#",$obj{"non_oasis_enteral"});
$non_oasis_skilled_care = explode("#",$obj{"non_oasis_skilled_care"});


$non_oasis_summary_disciplines = explode("#",$obj{"non_oasis_summary_disciplines"});
$non_oasis_summary_medication_identified = explode("#",$obj{"non_oasis_summary_medication_identified"});
?>

<html>
<head>
<title>OASIS</title>
<style type="text/css">
.bold {
	font-weight: bold;
}
table label, input { display:inline !important; }
a { font-size:12px; }
ul { list-style:none; padding:0; margin:0px; margin:0px 10px; }
#oasis li { padding:5px 0px;}
#oasis li div { border-bottom:1px solid #000000; padding:5px 0px; }
#oasis li a#black { color:#000000; font-weight:bold; font-size:13px; }
#oasis li ul { display:none; }



</style>
<?php html_header_show();?>

<style type="text/css">
@import url(<?php echo $GLOBALS['webroot']?>/library/dynarch_calendar.css);</style>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_en.js"></script>
<script type="text/javascript"
	src="<?php echo $GLOBALS['webroot'] ?>/library/dynarch_calendar_setup.js"></script>
	
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo $GLOBALS['webroot'] ?>/library/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $GLOBALS['webroot'] ?>/library/css/jquery-ui-1.8.21.custom.css" type="text/css" media="all" />
<script type="text/javascript" src="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<script type='text/javascript' src='../../../library/dialog.js'></script>
<link rel="stylesheet" href="../../../library/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<script>

	$(document).ready(function(){
	   $('#oasis li div').click(function(){ $(this).next('ul').slideToggle('fast'); 
		var text = ($(this).children('span').children('a').text() == '(Expand)') ? '(Collapse)' : '(Expand)';
		$(this).children('span').children('a').text(text);
	});

	}); 


	function fonChange(obj,code_type,condition) {
			$("#"+obj.id).autocomplete({
			minLength: 0,
			source: "../../../library/ajax/get_icd9codes.php?code_type="+code_type+"&condition="+condition,
			focus: function( event, ui ) {
			var id=$(this).attr('id');
			
				$(this).val( ui.item.code );
				return false;
			},
			select: function( event, ui ) {
			var id=$(this).attr('id');
			
				$(this).val( ui.item.code );
				return false;
			}
		})
		.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( '<a>'+item.code+'</a>')
				.appendTo( ul );
		};

		}




function select_pain(scale)
    {
        $('input:radio[name=non_oasis_pain_scale]')[scale].checked = true;
       
    }


var tot=<?php echo stripslashes($obj{"nutrition_total"});?>;
tot=parseInt(tot);

function nut_sum(box,valu){
if(box.checked)
{
tot=tot+valu;
$("#nutrition_total").val(tot);
}
else
{
tot=tot-valu;
$("#nutrition_total").val(tot);
}
}

function sum_braden_scale()
    {
            
$("#braden_total").val(
parseInt($("#braden_sensory").val())+
parseInt($("#braden_moisture").val())+
parseInt($("#braden_activity").val())+
parseInt($("#braden_mobility").val())+
parseInt($("#braden_nutrition").val())+
parseInt($("#braden_friction").val()));
    }


</script>

<script type="text/javascript">
  $(document).ready(function($) {
        var status = "";

        $("#signoff").fancybox({
        'scrolling'             : 'no',
        'titleShow'             : false,
        'onClosed'              : function() {
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
                type            : "POST",
                cache   : false,
                url             : "<?php echo $GLOBALS['rootdir'] . "/forms/$formDir/sign.php";?>",
                data            : $(this).serializeArray(),
                success: function(data) {
                        $.fancybox(data);
                }
            });


            return false;
        });
    });

</script>
</head>



<body class="body_top">
		<h3 align="center"><?php xl('Non-Oasis Discharge Assessment','e')?></h3>
<form method="post" id="submitForm"
		action="<?php echo $rootdir?>/forms/non_oasis/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="non_oasis" onSubmit="return top.restoreSession();" enctype="multipart/form-data">




<table width="100%" border="0" class="formtable">
<tr valign="top">
<TD align="left" width="40%">
<?php xl('Patient:','e')?>
<input type="text" name="non_oasis_patient"  size="40" value="<?php patientName(); ?>" readonly />
</TD>
<td align="right">
<?php xl('Caregiver:','e')?>&nbsp;&nbsp;
<input type="text" name="non_oasis_caregiver" value="<?php echo stripslashes($obj{"non_oasis_caregiver"});?>" />
&nbsp;&nbsp;&nbsp;&nbsp;

<?php xl('Start of Care Date:','e')?>
<input type="text" title="<?php xl('Start of Care Date','e') ?>" name="non_oasis_visit_date" id="non_oasis_visit_date" value="<?php echo stripslashes($obj{"non_oasis_visit_date"});?>" readonly/>

<?php if($date_is_blank == 0) { ?>
<img src='../../pic/show_calendar.gif' align='absbottom' width='24' height='22' id='img_curr_date1' border='0' alt='[?]' style='cursor: pointer; cursor: hand' title='<?php xl('Click here to choose a date','e'); ?>' />

<script	LANGUAGE="JavaScript">
Calendar.setup({inputField:"non_oasis_visit_date", ifFormat:"%Y-%m-%d", button:"img_curr_date1"});
</script>
<?php } else {echo '';} ?>

<br />
<?php xl('Time In:','e')?>
<select name="non_oasis_time_in" id="non_oasis_time_in">
<?php timeDropDown(stripslashes($obj{"non_oasis_time_in"}))?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php xl('Time Out:','e')?>
<select name="non_oasis_time_out" id="non_oasis_time_out">
 <?php timeDropDown(stripslashes($obj{"non_oasis_time_out"}))?>
</select>

</td>
</tr>
</table>





		<ul id="oasis">
                <li>
                    <div><a href="#" id="black">Pain &amp; Nutrition</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
                            <h3 align="center"><?php xl('Pain','e')?></h3>




<!-- *************************   Pain    ******************************** -->

<table width="100%" border="1" class="formtable">
<tr valign="top">

<td>
<center><strong><?php xl('SYSTEM REVIEW','e')?></strong></center><br />
<label>
<strong><?php xl('Weight:','e')?></strong>
<input type="checkbox" name="non_oasis_pain_weight" value="reported"  id="non_oasis_pain_weight" 
 <?php if($obj{"non_oasis_pain_weight"}=="reported") echo "checked"; ?> /> <?php xl('Reported','e')?> &nbsp;
</label>
<label>
<input type="checkbox" name="non_oasis_pain_weight" value="actual"  id="non_oasis_pain_weight" 
<?php if($obj{"non_oasis_pain_weight"}=="actual") echo "checked"; ?> /> <?php xl('Actual','e')?> &nbsp;
</label>
    <br />

<strong><?php xl('Blood Sugar (Range):','e')?></strong>
<input type="text" name="non_oasis_pain_blood_sugar" id="non_oasis_pain_blood_sugar" 
 value="<?php echo stripslashes($obj{"non_oasis_pain_blood_sugar"});?>"  style="width:60%"  />
<br />

<strong><?php xl('Bowel:','e')?></strong>
<label><input type="checkbox" name="non_oasis_pain_bowel" value="WNL"  id="non_oasis_pain_bowel" 
<?php if($obj{"non_oasis_pain_bowel"}=="WNL") echo "checked"; ?> /> <?php xl('WNL','e')?></label> &nbsp;

<label><input type="checkbox" name="non_oasis_pain_bowel" value="Other"  id="non_oasis_pain_bowel" 
<?php if($obj{"non_oasis_pain_bowel"}=="Other") echo "checked"; ?> /> <?php xl('Other','e')?></label> &nbsp;

<input type="text" name="non_oasis_pain_bowel_other" id="non_oasis_pain_bowel_other"   style="width:50%"  
 value="<?php echo stripslashes($obj{"non_oasis_pain_bowel_other"});?>" />
<br />
<label><?php xl('Bowel Sounds','e')?>
<input type="text" name="non_oasis_pain_bowel_sounds" id="non_oasis_pain_bowel_sounds"   style="width:60%"  
value="<?php echo stripslashes($obj{"non_oasis_pain_bowel_sounds"});?>" /></label>

<br />
<strong>
<?php xl('Bladder:','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_pain_bladder" value="WNL"  id="non_oasis_pain_bladder" 
<?php if($obj{"non_oasis_pain_bladder"}=="WNL") echo "checked"; ?> /> <?php xl('WNL','e')?> &nbsp;
</label>
<label>
<input type="checkbox" name="non_oasis_pain_bladder" value="Other"  id="non_oasis_pain_bladder" 
<?php if($obj{"non_oasis_pain_bladder"}=="Other") echo "checked"; ?> /> <?php xl('Other','e')?> &nbsp;
</label>
<input type="text" name="non_oasis_pain_bladder_other" id="non_oasis_pain_bladder_other" 
value="<?php echo stripslashes($obj{"non_oasis_pain_bladder_other"});?>"  style="width:48%" />

<br />
<strong>
<?php xl('Urinary Output:','e')?></strong>
<label><input type="checkbox" name="non_oasis_pain_urinary_output" value="WNL"  id="non_oasis_pain_urinary_output" 
<?php if($obj{"non_oasis_pain_urinary_output"}=="WNL") echo "checked"; ?> /> <?php xl('WNL','e')?></label> &nbsp;<br />
<label><input type="checkbox" name="non_oasis_pain_urinary_output" value="Foley catheter change with French Inflated Baloon with mL"  id="non_oasis_pain_urinary_output" 
<?php if($obj{"non_oasis_pain_urinary_output"}=="Foley catheter change with French Inflated Baloon with mL") echo "checked"; ?> /> <?php xl('Foley catheter change with French Inflated Baloon with mL','e')?></label> &nbsp;
<br />
</label><input type="checkbox" name="non_oasis_pain_urinary_output" value="Suprapubic"  id="non_oasis_pain_urinary_output" 
 <?php if($obj{"non_oasis_pain_urinary_output"}=="Suprapubic") echo "checked"; ?> /> <?php xl('Suprapubic','e')?></label> &nbsp;
    <br />

<br />
<strong>
<?php xl('Tolerated procedure well:','e')?></strong>
<label><input type="radio" name="non_oasis_pain_tolerated_procedure" value="Yes"  id="non_oasis_pain_tolerated_procedure"
 <?php if($obj{"non_oasis_pain_tolerated_procedure"}=="Yes") echo "checked"; ?> /> <?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_pain_tolerated_procedure" value="No"  id="non_oasis_pain_tolerated_procedure"
 <?php if($obj{"non_oasis_pain_tolerated_procedure"}=="No") echo "checked"; ?> /> <?php xl('No','e')?></label> &nbsp;<br />
</label><input type="checkbox" name="non_oasis_pain_tolerated_procedure_ot" value="Other"  id="non_oasis_pain_tolerated_procedure_ot" 
<?php if($obj{"non_oasis_pain_tolerated_procedure_ot"}=="Other") echo "checked"; ?> /> <?php xl('Other (Specify)','e')?></label> &nbsp;
<br /><textarea name="non_oasis_pain_tolerated_procedure_other" rows="6" cols="48" >
<?php echo stripslashes($obj{"non_oasis_pain_tolerated_procedure_other"});?></textarea>

<br />

</TD>

<td>
            <table border="0" cellspacing="0" align="center" class="formtable">
                <tr>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/non_oasis/templates/scale_0.png" border="0" onClick="select_pain(0)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/non_oasis/templates/scale_2.png" border="0" onClick="select_pain(1)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/non_oasis/templates/scale_4.png" border="0" onClick="select_pain(2)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/non_oasis/templates/scale_6.png" border="0" onClick="select_pain(3)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/non_oasis/templates/scale_8.png" border="0" onClick="select_pain(4)">
                    </td>
                    <td>
                        <img src="<?php echo $GLOBALS['webroot'] ?>/interface/forms/non_oasis/templates/scale_10.png" border="0" onClick="select_pain(5)">
                 </td>
                </tr>
</table>

      <strong><br /><u><?php xl('Pain Rating Scale:','e')?></u></strong>
                        <label><input type="radio" 
name="non_oasis_pain_scale" id="painscale_1" value="0"
 <?php if($obj{"non_oasis_pain_scale"}=="0") echo "checked"; ?> ><?php xl('0-No Pain ','e')?></label>
                        <label><input type="radio" 
name="non_oasis_pain_scale" id="painscale_2" value="2"
 <?php if($obj{"non_oasis_pain_scale"}=="2") echo "checked"; ?> ><?php xl('2-Little Pain ','e')?></label>
                        <label><input type="radio" 
name="non_oasis_pain_scale" id="painscale_4" value="4"
 <?php if($obj{"non_oasis_pain_scale"}=="4") echo "checked"; ?> 50><?php xl('4-Little More Pain ','e')?></label>
                        <label><input type="radio" 
name="non_oasis_pain_scale" id="painscale_6" value="6"
 <?php if($obj{"non_oasis_pain_scale"}=="6") echo "checked"; ?> ><?php xl('6-Even More Pain ','e')?></label>
                        <label><input type="radio" 
name="non_oasis_pain_scale" id="painscale_8" value="8"
 <?php if($obj{"non_oasis_pain_scale"}=="8") echo "checked"; ?> ><?php xl('8-Lots of Pain ','e')?></label>
                        <label><input type="radio" 
name="non_oasis_pain_scale" id="painscale_10" value="10"
 <?php if($obj{"non_oasis_pain_scale"}=="10") echo "checked"; ?> ><?php xl('10-Worst Pain ','e')?></label>

            <br>
           
            <strong><u><?php xl('Location:','e')?></u></strong> <?php 
xl('Cause:','e')?>
            <input type="text" name="non_oasis_pain_location_cause" 
value="<?php echo stripslashes($obj{"non_oasis_pain_location_cause"});?>" style="width:50%;" ><br>
           
            <strong><u><?php xl('Description:','e')?></u></strong><br>
            <label><input type="checkbox" 
name="non_oasis_pain_description" value="<?php xl("sharp","e");?>"
<?php if($obj{"non_oasis_pain_description"}=="sharp") echo "checked"; ?> ><?php xl('sharp','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_description" value="<?php xl("dull","e");?>"
<?php if($obj{"non_oasis_pain_description"}=="dull") echo "checked"; ?> ><?php xl('dull','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_description" value="<?php xl("cramping","e");?>"
<?php if($obj{"non_oasis_pain_description"}=="cramping") echo "checked"; ?> ><?php xl('cramping','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_description" value="<?php xl("aching","e");?>"
 <?php if($obj{"non_oasis_pain_description"}=="aching") echo "checked"; ?> ><?php xl('aching','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_description" value="<?php xl("burning","e");?>"
 <?php if($obj{"non_oasis_pain_description"}=="burning") echo "checked"; ?> ><?php xl('burning','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_description" value="<?php xl("tingling","e");?>"
 <?php if($obj{"non_oasis_pain_description"}=="tingling") echo "checked"; ?> ><?php xl('tingling','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_description" value="<?php 
xl("throbbing","e");?>"
 <?php if($obj{"non_oasis_pain_description"}=="throbbing") echo "checked"; ?> ><?php xl('throbbing','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_description" value="<?php 
xl("shooting","e");?>"
 <?php if($obj{"non_oasis_pain_description"}=="shooting") echo "checked"; ?> ><?php xl('shooting','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_description" value="<?php 
xl("pinching","e");?>"
 <?php if($obj{"non_oasis_pain_description"}=="pinching") echo "checked"; ?> ><?php xl('pinching','e')?></label><br>
           
            <strong><u><?php xl('Frequency:','e')?></u></strong><br>
            <label><input type="checkbox" 
name="non_oasis_pain_frequency" value="<?php xl('occasional','e');?>"
 <?php if($obj{"non_oasis_pain_frequency"}=="occasional") echo "checked"; ?> ><?php xl('occasional','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_frequency" value="<?php xl("intermittent","e");?>"
 <?php if($obj{"non_oasis_pain_frequency"}=="intermittent") echo "checked"; ?> ><?php xl('intermittent','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_frequency" value="<?php xl("continuous","e");?>"
 <?php if($obj{"non_oasis_pain_frequency"}=="continuous") echo "checked"; ?> ><?php xl('continuous','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_frequency" value="<?php xl('at rest','e');?>"
 <?php if($obj{"non_oasis_pain_frequency"}=="at rest") echo "checked"; ?> ><?php xl('at rest','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_frequency" value="<?php xl('at night','e');?>"
 <?php if($obj{"non_oasis_pain_frequency"}=="at night") echo "checked"; ?> ><?php xl('at night','e')?></label><br>
           
            <strong><u><?php xl('Aggravating factors:','e')?></u></strong><br>
            <label>
<input type="checkbox" name="non_oasis_pain_aggravating_factors" value="<?php xl("movement","e");?>"
 <?php if($obj{"non_oasis_pain_aggravating_factors"}=="movement") echo "checked"; ?> ><?php xl('movement','e')?></label>

  <label><input type="checkbox" name="non_oasis_pain_aggravating_factors" value="<?php xl('time of day','e');?>"
 <?php if($obj{"non_oasis_pain_aggravating_factors"}=="time of day") echo "checked"; ?> ><?php xl('time of day','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_aggravating_factors" value="<?php 
xl("posture","e");?>"
 <?php if($obj{"non_oasis_pain_aggravating_factors"}=="posture") echo "checked"; ?> ><?php xl('posture','e')?></label>
            
<label><input type="checkbox" 
name="non_oasis_pain_aggravating_factors" value="<?php 
xl("other","e");?>"
 <?php if($obj{"non_oasis_pain_aggravating_factors"}=="other") echo "checked"; ?> ><?php xl('other','e')?></label>
<input type="text" name="non_oasis_pain_aggravating_factors_other" style="width:50%;" 
value="<?php echo stripslashes($obj{"non_oasis_pain_aggravating_factors_other"});?>"  ><br>
           
            <strong><u><?php xl('Relieving factors:','e')?></u></strong><br>
            <label><input type="checkbox" 
name="non_oasis_pain_relieving_factors" value="<?php 
xl("medication","e");?>"
 <?php if($obj{"non_oasis_pain_relieving_factors"}=="medication") echo "checked"; ?> ><?php xl('medication','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_relieving_factors" value="<?php 
xl("rest","e");?>"
 <?php if($obj{"non_oasis_pain_relieving_factors"}=="rest") echo "checked"; ?> ><?php xl('rest','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_relieving_factors" value="<?php 
xl("heat","e");?>"
 <?php if($obj{"non_oasis_pain_relieving_factors"}=="heat") echo "checked"; ?> ><?php xl('heat','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_relieving_factors" value="<?php 
xl("ice","e");?>"
 <?php if($obj{"non_oasis_pain_relieving_factors"}=="ice") echo "checked"; ?> ><?php xl('ice','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_relieving_factors" value="<?php 
xl("massage","e");?>"
 <?php if($obj{"non_oasis_pain_relieving_factors"}=="massage") echo "checked"; ?> ><?php xl('massage','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_relieving_factors" value="<?php 
xl("repositioning","e");?>"
 <?php if($obj{"non_oasis_pain_relieving_factors"}=="repositioning") echo "checked"; ?> ><?php xl('repositioning','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_pain_relieving_factors" value="<?php xl("diversion","e");?>"
 <?php if($obj{"non_oasis_pain_relieving_factors"}=="diversion") echo "checked"; ?> ><?php xl('diversion','e')?></label>
<br />
            <label><input type="checkbox" 
name="non_oasis_pain_relieving_factors" value="<?php 
xl("other","e");?>"
 <?php if($obj{"non_oasis_pain_relieving_factors"}=="other") echo "checked"; ?> ><?php xl('other','e')?></label>
<input type="text" name="non_oasis_pain_relieving_factors_other" style="width:70%;" 
value="<?php echo stripslashes($obj{"non_oasis_pain_relieving_factors_other"});?>"  ><br>
           
            <strong><u><?php xl('Activities 
limited:','e')?></u></strong><br>

<textarea name="non_oasis_pain_activities_limited" rows="2" cols="48">
<?php echo stripslashes($obj{"non_oasis_pain_activities_limited"});?>
</textarea>
</td>

</tr>
</TABLE>






<!-- ******************** nutrition  ****************************** -->

                            <h3 align="center"><?php xl('Nutrition','e')?></h3>

<table width="100%" border="1" class="formtable">
<tr valign="top">


<td width="50%">
<center><strong><?php xl('NUTRITIONAL STATUS','e')?></strong>
<label><input type="checkbox" name="non_oasis_nutrition_status_prob" value="No Problem"  id="non_oasis_nutrition_status_prob" 
<?php if($obj{"non_oasis_nutrition_status_prob"}=="No Problem") echo "checked"; ?>  /> <?php xl('No Problem','e')?></label> &nbsp;<br /></center>
<label><input type="checkbox" name="non_oasis_nutrition_status" value="NAS"  id="non_oasis_nutrition_status" 
<?php if($obj{"non_oasis_nutrition_status"}=="NAS") echo "checked"; ?>  /> <?php xl('NAS','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_status" value="NPO"  id="non_oasis_nutrition_status" 
<?php if($obj{"non_oasis_nutrition_status"}=="NPO") echo "checked"; ?>  /> <?php xl('NPO','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_status" value="No Concentrated Sweets"  id="non_oasis_nutrition_status" 
 <?php if($obj{"non_oasis_nutrition_status"}=="No Concentrated Sweets") echo "checked"; ?>  /> <?php xl('No Concentrated Sweets','e')?>
</label> <br/>
<label><input type="checkbox" name="non_oasis_nutrition_status" value="Other"  id="non_oasis_nutrition_status" 
 <?php if($obj{"non_oasis_nutrition_status"}=="Other") echo "checked"; ?> /> <?php xl('Other','e')?></label> &nbsp;

<input type="text" name="non_oasis_nutrition_status_other" id="non_oasis_nutrition_status_other" 
style="width:80%" 
value="<?php echo stripslashes($obj{"non_oasis_nutrition_status_other"});?>" />
<br />
<strong>
<?php xl('Nutritional Requirements (diet)','e')?></strong><br />
<label><input type="checkbox" name="non_oasis_nutrition_requirements" value="Increase fluids amt"  id="non_oasis_nutrition_requirements"
 <?php if($obj{"non_oasis_nutrition_requirements"}=="Increase fluids amt") echo "checked"; ?>  /> <?php xl('Increase fluids amt','e')?>
</label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_requirements" value="Restrict fluids amt"  id="non_oasis_nutrition_requirements" 
 <?php if($obj{"non_oasis_nutrition_requirements"}=="Restrict fluids amt") echo "checked"; ?> /> <?php xl('Restrict fluids amt','e')?></label>&nbsp;

<br />
<strong><?php xl('Appetite','e')?></strong>
<label><input type="radio" name="non_oasis_nutrition_appetite" value="Good"  id="non_oasis_nutrition_appetite" 
 <?php if($obj{"non_oasis_nutrition_appetite"}=="Good") echo "checked"; ?> /> <?php xl('Good','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_nutrition_appetite" value="Fair"  id="non_oasis_nutrition_appetite" 
 <?php if($obj{"non_oasis_nutrition_appetite"}=="Fair") echo "checked"; ?> /> <?php xl('Fair','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_nutrition_appetite" value="Poor"  id="non_oasis_nutrition_appetite" 
 <?php if($obj{"non_oasis_nutrition_appetite"}=="Poor") echo "checked"; ?> /> <?php xl('Poor','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_nutrition_appetite" value="Anorexic"  id="non_oasis_nutrition_appetite" 
 <?php if($obj{"non_oasis_nutrition_appetite"}=="Anorexic") echo "checked"; ?> /> <?php xl('Anorexic','e')?></label> &nbsp;



<br />
<strong><?php xl('Eating Patterns','e')?></strong>
<br /><textarea name="non_oasis_nutrition_eat_patt" rows="2" cols="48" >
<?php echo stripslashes($obj{"non_oasis_nutrition_eat_patt"});?></textarea>
<br /><br />
<label><input type="checkbox" name="non_oasis_nutrition_eat_patt1[]" value="Nausea/Vomiting"  id="non_oasis_nutrition_eat_patt1" 
 <?php if(in_array("Nausea/Vomiting",$non_oasis_nutrition_eat_patt1)) echo "checked"; ?> />
<?php xl('Nausea/Vomiting: ','e')?></label> &nbsp;
<label><?php xl('Frequency','e')?><input type="text" name="non_oasis_nutrition_eat_patt_freq" id="non_oasis_nutrition_eat_patt_freq" size="8" 
value="<?php echo stripslashes($obj{"non_oasis_nutrition_eat_patt_freq"});?>" /></label> &nbsp;
<label><?php xl('Amount','e')?><input type="text" name="non_oasis_nutrition_eat_patt_amt" id="non_oasis_nutrition_eat_patt_amt" size="8" 
value="<?php echo stripslashes($obj{"non_oasis_nutrition_eat_patt_amt"});?>" /></label> &nbsp;
<br />
<label><input type="checkbox" name="non_oasis_nutrition_eat_patt1[]" value="Heartburn (food intolerance)"  id="non_oasis_nutrition_eat_patt1"
 <?php if(in_array("Heartburn (food intolerance)",$non_oasis_nutrition_eat_patt1)) echo "checked"; ?>  />
<?php xl('Heartburn (food intolerance)','e')?></label> &nbsp;
<br />
<label><input type="checkbox" name="non_oasis_nutrition_eat_patt1[]" value="Weight Change:"  id="non_oasis_nutrition_eat_patt1" 
 <?php if(in_array("Weight Change:",$non_oasis_nutrition_eat_patt1)) echo "checked"; ?> />
<?php xl('Weight Change:','e')?></label> &nbsp;
<strong>
<?php xl('Gain','e')?></strong>
<input type="text" name="non_oasis_nutrition_patt_gain" id="non_oasis_nutrition_patt_gain" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_nutrition_patt_gain"});?>" />
<?php xl('lb. X','e')?>
&nbsp;
<label><input type="radio" name="non_oasis_nutrition_eat_patt1_gain_time" value="wk./"  id="non_oasis_nutrition_eat_patt1_gain_time" 
 <?php if($obj{"non_oasis_nutrition_eat_patt1_gain_time"}=="wk./") echo "checked"; ?> />
<?php xl('wk./','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_nutrition_eat_patt1_gain_time" value="mo./"  id="non_oasis_nutrition_eat_patt1_gain_time" 
 <?php if($obj{"non_oasis_nutrition_eat_patt1_gain_time"}=="mo./") echo "checked"; ?> />
<?php xl('mo./','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_nutrition_eat_patt1_gain_time" value="yr."  id="non_oasis_nutrition_eat_patt1_gain_time" 
 <?php if($obj{"non_oasis_nutrition_eat_patt1_gain_time"}=="yr.") echo "checked"; ?> />
<?php xl('yr.','e')?></label> &nbsp;<br />
<label><input type="checkbox" name="non_oasis_nutrition_eat_patt1[]" value="Other(Specify including history)"  id="non_oasis_nutrition_eat_patt1" 
  <?php if(in_array("Other(Specify including history)",$non_oasis_nutrition_eat_patt1)) echo "checked"; ?>  />
<?php xl('Other(Specify including history)','e')?></label> &nbsp;
<input type="text" name="non_oasis_nutrition_patt1_other" id="non_oasis_nutrition_patt1_other"  style="width:42%"  
value="<?php echo stripslashes($obj{"non_oasis_nutrition_patt1_other"});?>" />
<br /><br />
<center><strong><?php xl('NUTRITIONAL REQUIREMENTS','e')?></strong></center><br />
<label><input type="checkbox" name="non_oasis_nutrition_req" value="Regular Diet"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="Regular Diet") echo "checked"; ?> />
<?php xl('Regular Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_req" value="Diet as Tolerated"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="Diet as Tolerated") echo "checked"; ?> />
<?php xl('Diet as Tolerated','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_req" value="Soft Diet"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="Soft Diet") echo "checked"; ?> />
<?php xl('Soft Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_req" value="NCS"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="NCS") echo "checked"; ?> />
<?php xl('NCS','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_req" value="Diabetic Diet # Calorie ADA"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="Diabetic Diet # Calorie ADA") echo "checked"; ?> />
<?php xl('Diabetic Diet # Calorie ADA','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_req" value="Pureed Diet"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="Pureed Diet") echo "checked"; ?> />
<?php xl('Pureed Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_req" value="NAS"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="NAS") echo "checked"; ?> />
<?php xl('NAS','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_req" value="Low Salt Gram Sodium"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="Low Salt Gram Sodium") echo "checked"; ?> />
<?php xl('Low Salt Gram Sodium','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_req" value="Low Fat/Low Cholestrol Diet"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="Low Fat/Low Cholestrol Diet") echo "checked"; ?> />
<?php xl('Low Fat/Low Cholestrol Diet','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_nutrition_req" value="Other Special Diet"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_req"}=="Other Special Diet") echo "checked"; ?> />
<?php xl('Other Special Diet','e')?></label> &nbsp;
<br />
<textarea name="non_oasis_nutrition_req_other" rows="2" cols="48" >
<?php echo stripslashes($obj{"non_oasis_nutrition_req_other"});?></textarea>

</td>

<!-- **************************** Implode this  *********************************** -->

<td>
<center><strong><?php xl('NUTRITION','e')?></strong></center><br />
<strong><?php xl('Directions: Check each area with "yes" to assessment, then see total score to determine additional risk.','e')?></strong>
<TABLE width="100%" border="0"  class="formtable">
<tr>
<TD width="90%"></TD>
<td width="5%"></td>
<td width="5%"><strong><?php echo "YES"; ?></strong></td>
</tr>
<tr>
<TD width="90%"><?php xl('Has an illness or condition that changed the kind and/or amount of food eaten','e')?></TD>
<td width="5%"><?php xl('2','e')?></td>
<td width="5%"><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Has an illness or condition that changed the kind and/or amount of food eaten"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,2)" 
 <?php if(in_array("Has an illness or condition that changed the kind and/or amount of food eaten",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Eats fewer than 2 meals per day','e')?></td>
<td><?php xl('3','e')?></td>
<td><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Eats fewer than 2 meals per day"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,3)" 
 <?php if(in_array("Eats fewer than 2 meals per day",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Eats few fruits, vegetables or milk products','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Eats few fruits, vegetables or milk products"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,2)" 
 <?php if(in_array("Eats few fruits, vegetables or milk products",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Has 3 or more drinks of beer, liquor or wine almost everyday','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Has 3 or more drinks of beer, liquor or wine almost everyday"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,2)" 
 <?php if(in_array("Has 3 or more drinks of beer, liquor or wine almost everyday",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Has tooth or mouth problems that make it hard to eat','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Has tooth or mouth problems that make it hard to eat"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,2)" 
 <?php if(in_array("Has tooth or mouth problems that make it hard to eat",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Does not always have the enough money to buy the food needed','e')?></td>
<td><?php xl('4','e')?></td>
<td><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Does not always have the enough money to buy the food needed"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,4)" 
 <?php if(in_array("Does not always have the enough money to buy the food needed",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Eats alone most of the time','e')?></td>
<td><?php xl('1','e')?></td>
<td><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Eats alone most of the time"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,1)" 
 <?php if(in_array("Eats alone most of the time",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Takes 3 or more different prescribed or over-the-counter drugs a day','e')?></td>
<td><?php xl('1','e')?></td>
<td><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Takes 3 or more different prescribed or over-the-counter drugs a day"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,1)" 
 <?php if(in_array("Takes 3 or more different prescribed or over-the-counter drugs a day",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Without warning to, has lost or gained 10 pounds in the last 6 months','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Without warning to, has lost or gained 10 pounds in the last 6 months"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,2)" 
 <?php if(in_array("Without warning to, has lost or gained 10 pounds in the last 6 months",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr>
<td><?php xl('Not always physically able to shop, cook and/or feed self','e')?></td>
<td><?php xl('2','e')?></td>
<td><input type="checkbox" name="non_oasis_nutrition_risks[]" value="Not always physically able to shop, cook and/or feed self"  id="non_oasis_nutrition_risk" onChange="nut_sum(this,2)" 
 <?php if(in_array("Not always physically able to shop, cook and/or feed self",$non_oasis_nutrition_risks)) echo "checked"; ?> /></td>
</tr>
<tr valign="top">
<TD colspan="2" align="right" width="70%">
<label><input type="checkbox" name="non_oasis_nutrition_risks_MD" value="MD aware or MD notified"  id="non_oasis_nutrition_req" 
 <?php if($obj{"non_oasis_nutrition_risks_MD"}=="MD aware or MD notified") echo "checked"; ?> />
<?php xl('MD aware or MD notified','e')?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php xl('TOTAL','e')?></strong></label>
</TD>
<td width="30%">
<label><input type="text" name="nutrition_total" id="nutrition_total" size="2" 
value="<?php echo stripslashes($obj{"nutrition_total"});?>" readonly/></label>
</td>
</tr>
</TABLE>
<strong><?php xl('INTERPRETATION: 0-2 Good. As appropriate reassess and/or provide information based on situation.','e')?><br />
<?php xl('3-5 Moderate risk. Educate, refer, monitor and reevaluate based on patient situation and organization policy.','e')?><br />
<?php xl('6 or more High risk. Coordinate with physician, dietitian, social service professional or nurse about how to improve nutritional health. Describe at risk intervention:','e')?>
<input type="text" name="non_oasis_nutrition_describe" id="non_oasis_nutrition_describe" style="width:95%" 
value="<?php echo stripslashes($obj{"non_oasis_nutrition_describe"});?>" /><br />
</strong>
</td>

</tr>
</TABLE>



                        </li>
                    </ul>
                </li>

<li>
                    <div><a href="#" id="black">Vital Signs, Cardiopulmonary &amp; Braden Scale</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
<!-- *********************  Vital Signs, Cardiopulmonary and Braden Scale   ******************** -->
                        <li>
                            <h3 align="center"><?php xl('Vital Signs','e')?></h3>



<!-- **********************  Vital Signs  ************************ -->

<table width="100%" border="1" class="formtable">
<tr>

<td width="50%">
<TABLE width="100%" border="0"  class="formtable">
<tr valign="top">
<TD align="center"><strong><?php xl('Blood Pressure:','e')?></strong></TD>
<td align="center"><?php xl('Right','e')?></td>
<td align="center"><?php xl('Left','e')?></td>
</tr>

<tr>
<TD align="center"><?php xl('Lying','e')?></TD>
<td align="center"><input type="text" name="non_oasis_vital_lying_right" id="non_oasis_vital_lying_right" size="15" 
value="<?php echo stripslashes($obj{"non_oasis_vital_lying_right"});?>" /></td>
<td align="center"><input type="text" name="non_oasis_vital_lying_left" id="non_oasis_vital_lying_left" size="15" 
value="<?php echo stripslashes($obj{"non_oasis_vital_lying_left"});?>" /></td>
</tr>
<tr>
<TD align="center"><?php xl('Sitting','e')?></TD>
<td align="center"><input type="text" name="non_oasis_vital_sitting_right" id="non_oasis_vital_sitting_right" size="15" 
value="<?php echo stripslashes($obj{"non_oasis_vital_sitting_right"});?>" /></td>
<td align="center"><input type="text" name="non_oasis_vital_sitting_left" id="non_oasis_vital_sitting_left" size="15" 
value="<?php echo stripslashes($obj{"non_oasis_vital_sitting_left"});?>" /></td>
</tr>
<tr>
<TD align="center"><?php xl('Standing','e')?></TD>
<td align="center"><input type="text" name="non_oasis_vital_standing_right" id="non_oasis_vital_standing_right" size="15" 
value="<?php echo stripslashes($obj{"non_oasis_vital_standing_right"});?>" /></td>
<td align="center"><input type="text" name="non_oasis_vital_standing_left" id="non_oasis_vital_standing_left" size="15" 
value="<?php echo stripslashes($obj{"non_oasis_vital_standing_left"});?>" /></td>
</tr>
</TABLE>

<strong><?php xl('Temperature: °F','e')?></strong>&nbsp;&nbsp;
<label><input type="radio" name="non_oasis_vital_temp" value="Oral"  id="non_oasis_vital_temp" 
<?php if($obj{"non_oasis_vital_temp"}=="Oral") echo "checked"; ?> />
<?php xl('Oral','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_temp" value="Axillary"  id="non_oasis_vital_temp" 
<?php if($obj{"non_oasis_vital_temp"}=="Axillary") echo "checked"; ?> />
<?php xl('Axillary','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_temp" value="Rectal"  id="non_oasis_vital_temp" 
<?php if($obj{"non_oasis_vital_temp"}=="Rectal") echo "checked"; ?> />
<?php xl('Rectal','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_temp" value="Tympanic"  id="non_oasis_vital_temp" 
<?php if($obj{"non_oasis_vital_temp"}=="Tympanic") echo "checked"; ?> />
<?php xl('Tympanic','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_temp" value="Temporal"  id="non_oasis_vital_temp" 
<?php if($obj{"non_oasis_vital_temp"}=="Temporal") echo "checked"; ?> />
<?php xl('Temporal','e')?></label> &nbsp;

</TD>

<td>

<strong><?php xl('Pulse:','e')?></strong>
<br />
<label><input type="radio" name="non_oasis_vital_pulse[]" value="At Rest"  id="non_oasis_vital_pulse" 
<?php if(in_array("At Rest",$non_oasis_vital_pulse)) echo "checked"; ?> />
<?php xl('At Rest','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_pulse[]" value="Activity/Exercise"  id="non_oasis_vital_pulse" 
<?php if(in_array("Activity/Exercise",$non_oasis_vital_pulse)) echo "checked"; ?> />
<?php xl('Activity/Exercise','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_pulse[]" value="Regular"  id="non_oasis_vital_pulse" 
<?php if(in_array("Regular",$non_oasis_vital_pulse)) echo "checked"; ?> />
<?php xl('Regular','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_pulse[]" value="Irregular"  id="non_oasis_vital_pulse" 
<?php if(in_array("Irregular",$non_oasis_vital_pulse)) echo "checked"; ?> />
<?php xl('Irregular','e')?></label> &nbsp;
<br />
<label><input type="checkbox" name="non_oasis_vital_pulse[]" value="Radial"  id="non_oasis_vital_pulse" 
<?php if(in_array("Radial",$non_oasis_vital_pulse)) echo "checked"; ?> /> <?php xl('Radial','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_vital_pulse[]" value="Carotid"  id="non_oasis_vital_pulse" 
<?php if(in_array("Carotid",$non_oasis_vital_pulse)) echo "checked"; ?> /> <?php xl('Carotid','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_vital_pulse[]" value="Apical"  id="non_oasis_vital_pulse" 
<?php if(in_array("Apical",$non_oasis_vital_pulse)) echo "checked"; ?> /> <?php xl('Apical','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_vital_pulse[]" value="Brachial"  id="non_oasis_vital_pulse" 
<?php if(in_array("Brachial",$non_oasis_vital_pulse)) echo "checked"; ?> /> <?php xl('Brachial','e')?></label> &nbsp;
<br />
<strong><?php xl('Respiratory Rate:','e')?></strong>&nbsp;&nbsp;&nbsp;
<label><input type="radio" name="non_oasis_vital_resp_rate" value="Normal"  id="non_oasis_vital_resp_rate" 
<?php if($obj{"non_oasis_vital_resp_rate"}=="Normal") echo "checked"; ?> />
<?php xl('Normal','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_resp_rate" value="Cheynes Stokes"  id="non_oasis_vital_resp_rate" 
<?php if($obj{"non_oasis_vital_resp_rate"}=="Cheynes Stokes") echo "checked"; ?> />
<?php xl('Cheynes Stokes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_resp_rate" value="Death rattle"  id="non_oasis_vital_resp_rate" 
<?php if($obj{"non_oasis_vital_resp_rate"}=="Death rattle") echo "checked"; ?> />
<?php xl('Death rattle','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_vital_resp_rate" value="Apnea/sec"  id="non_oasis_vital_resp_rate" 
<?php if($obj{"non_oasis_vital_resp_rate"}=="Apnea/sec") echo "checked"; ?> />
<?php xl('Apnea/sec','e')?></label> &nbsp;

</td>
</tr>
</TABLE>



<!-- **************************  Cardiopulmonary  ********************************** -->

<h3 align="center"><?php xl('Cardiopulmonary','e')?></h3>



<table width="100%" border="1" class="formtable">
<tr valign="top">
<td colspan="2">
<center><strong><?php xl('CARDIOPULMONARY','e')?></strong>&nbsp;&nbsp;
<label><input type="checkbox" name="non_oasis_cardio" value="No Problem"  id="non_oasis_cardio" 
<?php if($obj{"non_oasis_cardio"}=="No Problem") echo "checked"; ?> /> <?php xl('No Problem','e')?></label> &nbsp;
</center>
</td>
</tr>
<tr>
<TD width="50%">
<strong>
<?php xl('Breath Sounds:','e')?></strong><br />
<label><input type="radio" name="non_oasis_cardio_breath" value="Clear"  id="non_oasis_cardio_breath" 
<?php if($obj{"non_oasis_cardio_breath"}=="Clear") echo "checked"; ?> />
<?php xl('Clear','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_cardio_breath" value="Crackles/Rales"  id="non_oasis_cardio_breath" 
<?php if($obj{"non_oasis_cardio_breath"}=="Crackles/Rales") echo "checked"; ?> />
<?php xl('Crackles/Rales','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_cardio_breath" value="Wheezes/Rhonchi"  id="non_oasis_cardio_breath" 
<?php if($obj{"non_oasis_cardio_breath"}=="Wheezes/Rhonchi") echo "checked"; ?> />
<?php xl('Wheezes/Rhonchi','e')?></label> &nbsp;<br />
<label><input type="radio" name="non_oasis_cardio_breath" value="Diminished"  id="non_oasis_cardio_breath" 
<?php if($obj{"non_oasis_cardio_breath"}=="Diminished") echo "checked"; ?> />
<?php xl('Diminished','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_cardio_breath" value="Absent"  id="non_oasis_cardio_breath" 
<?php if($obj{"non_oasis_cardio_breath"}=="Absent") echo "checked"; ?> />
<?php xl('Absent','e')?></label> &nbsp;<br />


<label><input type="checkbox" name="non_oasis_cardio_breath1[]" value="Anterior:"  id="non_oasis_cardio_breath1" 
<?php if(in_array("Anterior:",$non_oasis_cardio_breath1)) echo "checked"; ?> />
<strong><?php xl('Anterior:','e')?></strong></label> &nbsp;
	<label><input type="checkbox" name="non_oasis_cardio_breath_anterior" value="Right"  id="non_oasis_cardio_breath_anterior" 
<?php if($obj{"non_oasis_cardio_breath_anterior"}=="Right") echo "checked"; ?> />
	<?php xl('Right','e')?></label> &nbsp;
	<label><input type="checkbox" name="non_oasis_cardio_breath_anterior" value="Left"  id="non_oasis_cardio_breath_anterior" 
<?php if($obj{"non_oasis_cardio_breath_anterior"}=="Left") echo "checked"; ?> />
	<?php xl('Left','e')?></label> &nbsp;
	<label><input type="checkbox" name="non_oasis_cardio_breath_anterior" value="O2 saturation"  id="non_oasis_cardio_breath_anterior" 
<?php if($obj{"non_oasis_cardio_breath_anterior"}=="O2 saturation") echo "checked"; ?> />
	<?php xl('O2 saturation','e')?></label> &nbsp;<br />
<label><input type="checkbox" name="non_oasis_cardio_breath1[]" value="Posterior:"  id="non_oasis_cardio_breath1" 
<?php if(in_array("Posterior:",$non_oasis_cardio_breath1)) echo "checked"; ?> />
<strong><?php xl('Posterior:','e')?></strong></label> &nbsp;
	<label><input type="checkbox" name="non_oasis_cardio_breath_posterior" value="Right Upper"  id="non_oasis_cardio_breath_posterior" 
<?php if($obj{"non_oasis_cardio_breath_posterior"}=="Right Upper") echo "checked"; ?> />
	<?php xl('Right Upper','e')?></label> &nbsp;
	<label><input type="checkbox" name="non_oasis_cardio_breath_posterior" value="Right Lower"  id="non_oasis_cardio_breath_posterior" 
<?php if($obj{"non_oasis_cardio_breath_posterior"}=="Right Lower") echo "checked"; ?> />
	<?php xl('Right Lower','e')?></label> &nbsp;
	<label><input type="checkbox" name="non_oasis_cardio_breath_posterior" value="Left Upper"  id="non_oasis_cardio_breath_posterior" 
<?php if($obj{"non_oasis_cardio_breath_posterior"}=="Left Upper") echo "checked"; ?> />
	<?php xl('Left Upper','e')?></label> &nbsp;
	<label><input type="checkbox" name="non_oasis_cardio_breath_posterior" value="Left Lower"  id="non_oasis_cardio_breath_posterior" 
<?php if($obj{"non_oasis_cardio_breath_posterior"}=="Left Lower") echo "checked"; ?> />
	<?php xl('Left Lower','e')?></label> &nbsp;<br />

<label><input type="checkbox" name="non_oasis_cardio_breath1[]" value="O2 saturation %"  id="non_oasis_cardio_breath1" 
<?php if(in_array("O2 saturation %",$non_oasis_cardio_breath1)) echo "checked"; ?> />
<?php xl('O2 saturation %','e')?></label> &nbsp;
<input type="text" name="non_oasis_cardio_o2_sat" id="non_oasis_cardio_o2_sat" size="15" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_o2_sat"});?>" /><br />

<label><input type="checkbox" name="non_oasis_cardio_breath1[]" value="Accessory muscles used"  id="non_oasis_cardio_breath1"
<?php if(in_array("Accessory muscles used",$non_oasis_cardio_breath1)) echo "checked"; ?>  />
<?php xl('Accessory muscles used','e')?></label> &nbsp;
<input type="text" name="non_oasis_cardio_acc_muscles" id="non_oasis_cardio_acc_muscles" size="15" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_acc_muscles"});?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<label><input type="checkbox" name="non_oasis_cardio_breath1[]" value="O2"  id="non_oasis_cardio_breath1" 
<?php if(in_array("O2",$non_oasis_cardio_breath1)) echo "checked"; ?> />
<?php xl('O2','e')?></label> &nbsp;
<input type="text" name="non_oasis_cardio_o2" id="non_oasis_cardio_o2" size="6" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_o2"});?>" />
<?php xl('LPM per','e')?> &nbsp;
<input type="text" name="non_oasis_cardio_lpm_per" id="non_oasis_cardio_lpm_per" size="6" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_lpm_per"});?>" />

<br />
<label><input type="checkbox" name="non_oasis_cardio_breath1[]" value="Pulse Oximetry per Symptomology"  id="non_oasis_cardio_breath1" 
<?php if(in_array("Pulse Oximetry per Symptomology",$non_oasis_cardio_breath1)) echo "checked"; ?> />
<?php xl('Pulse Oximetry per Symptomology','e')?></label> &nbsp;
<br />

<?php xl('Does this patient have a trach?','e')?>
<label><input type="radio" name="non_oasis_cardio_trach" value="Yes"  id="non_oasis_cardio_trach"
<?php if($obj{"non_oasis_cardio_trach"}=="Yes") echo "checked"; ?>  />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_cardio_trach" value="No"  id="non_oasis_cardio_trach" 
<?php if($obj{"non_oasis_cardio_trach"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;

<br />
<?php xl('Who manages?','e')?>
<label><input type="radio" name="non_oasis_cardio_manages" value="Self"  id="non_oasis_cardio_manages" 
<?php if($obj{"non_oasis_cardio_manages"}=="Self") echo "checked"; ?> />
<?php xl('Self','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_cardio_manages" value="RN"  id="non_oasis_cardio_manages" 
<?php if($obj{"non_oasis_cardio_manages"}=="RN") echo "checked"; ?> />
<?php xl('RN','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_cardio_manages" value="Caregiver/family"  id="non_oasis_cardio_manages" 
<?php if($obj{"non_oasis_cardio_manages"}=="Caregiver/family") echo "checked"; ?> />
<?php xl('Caregiver/family','e')?></label> &nbsp;
<br />

<label><input type="checkbox" name="non_oasis_cardio_breath1[]" value="Cough:"  id="non_oasis_cardio_breath1" 
<?php if(in_array("Cough:",$non_oasis_cardio_breath1)) echo "checked"; ?> />
<strong><?php xl('Cough:','e')?></strong></label> &nbsp;
<label><input type="checkbox" name="non_oasis_cardio_breath_cough" value="Dry"  id="non_oasis_cardio_breath_cough" 
<?php if($obj{"non_oasis_cardio_breath_cough"}=="Dry") echo "checked"; ?> />
<?php xl('Dry','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_cardio_breath_cough" value="Acute"  id="non_oasis_cardio_breath_cough" 
<?php if($obj{"non_oasis_cardio_breath_cough"}=="Acute") echo "checked"; ?> />
<?php xl('Acute','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_cardio_breath_cough" value="Chronic"  id="non_oasis_cardio_breath_cough" 
<?php if($obj{"non_oasis_cardio_breath_cough"}=="Chronic") echo "checked"; ?> />
<?php xl('Chronic','e')?></label> &nbsp;


<br />
<label><input type="checkbox" name="non_oasis_cardio_breath1[]" value="Productive:"  id="non_oasis_cardio_breath1" 
<?php if(in_array("Productive:",$non_oasis_cardio_breath1)) echo "checked"; ?> />
<strong><?php xl('Productive:','e')?></strong></label> &nbsp;
<label><input type="checkbox" name="non_oasis_cardio_breath_productive" value="Thick"  id="non_oasis_cardio_breath_productive" 
<?php if($obj{"non_oasis_cardio_breath_productive"}=="Thick") echo "checked"; ?> />
<?php xl('Thick','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_cardio_breath_productive" value="Thin"  id="non_oasis_cardio_breath_productive" 
<?php if($obj{"non_oasis_cardio_breath_productive"}=="Thin") echo "checked"; ?> />
<?php xl('Thin','e')?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><?php xl('Color','e')?>
<input type="text" name="non_oasis_cardio_breath_color" id="non_oasis_cardio_breath_color" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_breath_color"});?>" />
</label> &nbsp;
<label><?php xl('Amount','e')?>
<input type="text" name="non_oasis_cardio_breath_amt" id="non_oasis_cardio_breath_amt" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_breath_amt"});?>" />
</label> &nbsp;
<br />

<label><input type="checkbox" name="non_oasis_cardio_breath1[]" value="Dyspnea:"  id="non_oasis_cardio_breath1" 
<?php if(in_array("Dyspnea:",$non_oasis_cardio_breath1)) echo "checked"; ?> />
<strong><?php xl('Dyspnea:','e')?></strong></label> &nbsp;
<label><input type="checkbox" name="non_oasis_cardio_breath_dyspnea" value="Rest"  id="non_oasis_cardio_breath_dyspnea" 
<?php if($obj{"non_oasis_cardio_breath_dyspnea"}=="Rest") echo "checked"; ?> />
<?php xl('Rest','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_cardio_breath_dyspnea" value="Exertion"  id="non_oasis_cardio_breath_dyspnea" 
<?php if($obj{"non_oasis_cardio_breath_dyspnea"}=="Exertion") echo "checked"; ?> />
<?php xl('Exertion','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_cardio_breath_dyspnea" value="Ambulation feet"  id="non_oasis_cardio_breath_dyspnea" 
<?php if($obj{"non_oasis_cardio_breath_dyspnea"}=="Ambulation feet") echo "checked"; ?> />
<?php xl('Ambulation feet','e')?></label> &nbsp;<br />
<label><input type="checkbox" name="non_oasis_cardio_breath_dyspnea" value="During ADLs"  id="non_oasis_cardio_breath_dyspnea" 
<?php if($obj{"non_oasis_cardio_breath_dyspnea"}=="During ADLs") echo "checked"; ?> />
<?php xl('During ADLs','e')?></label> &nbsp;
<label><input type="checkbox" name="non_oasis_cardio_breath_dyspnea" value="Orthopnea"  id="non_oasis_cardio_breath_dyspnea" 
<?php if($obj{"non_oasis_cardio_breath_dyspnea"}=="Orthopnea") echo "checked"; ?> />
<?php xl('Orthopnea','e')?></label> <br>
<label><input type="checkbox" name="non_oasis_cardio_breath_dyspnea" value="Other"  id="non_oasis_cardio_breath_dyspnea" 
<?php if($obj{"non_oasis_cardio_breath_dyspnea"}=="Other") echo "checked"; ?> />
<?php xl('Other','e')?></label> &nbsp;
<input type="text" name="non_oasis_cardio_breath_dyspnea_other" id="non_oasis_cardio_breath_dyspnea_other" size="46" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_breath_dyspnea_other"});?>" />


</td>

<!-- ***********************************  Second Column  ********************************* -->



<td>
            <strong><?php xl('Heart Sounds:','e')?></strong><br>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_type" value="Regular" 
<?php if($obj{"non_oasis_cardio_heart_sounds_type"}=="Regular") echo "checked"; ?> /><?php xl('Regular','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_type" value="Irregular" 
<?php if($obj{"non_oasis_cardio_heart_sounds_type"}=="Irregular") echo "checked"; ?> /><?php xl('Irregular','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_type" value="Murmur" 
<?php if($obj{"non_oasis_cardio_heart_sounds_type"}=="Murmur") echo "checked"; ?> /><?php xl('Murmur','e')?></label><br>
            <label><input type="checkbox" name="non_oasis_cardio_heart_sounds[]" value="Pacemaker" 
<?php if(in_array("Pacemaker",$non_oasis_cardio_heart_sounds)) echo "checked"; ?> /><?php xl('Pacemaker:','e')?></label>
                <input type="text" name="non_oasis_cardio_heart_sounds_pacemaker" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_heart_sounds_pacemaker"});?>" >&nbsp;&nbsp;
                <?php xl('Date:','e')?><input type='text' size='10' name='non_oasis_cardio_heart_sounds_pacemaker_date' id='non_oasis_cardio_heart_sounds_pacemaker_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly
value="<?php echo stripslashes($obj{"non_oasis_cardio_heart_sounds_pacemaker_date"});?>" 

/>
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date7' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'>
                        <script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_cardio_heart_sounds_pacemaker_date", ifFormat:"%Y-%m-%d", button:"img_curr_date7"});
                        </script>


                <?php xl('Type:','e')?><input type="text" name="non_oasis_cardio_heart_sounds_pacemaker_type" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_heart_sounds_pacemaker_type"});?>" ><br>
            <label><input type="checkbox" name="non_oasis_cardio_heart_sounds[]" value="Chest Pain"
<?php if(in_array("Chest Pain",$non_oasis_cardio_heart_sounds)) echo "checked"; ?> ><strong><?php xl('Chest Pain:','e')?></strong></label><br />
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_chest_pain" value="Anginal" 
<?php if($obj{"non_oasis_cardio_heart_sounds_chest_pain"}=="Anginal") echo "checked"; ?> /><?php xl('Anginal','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_chest_pain" value="Postural" 
<?php if($obj{"non_oasis_cardio_heart_sounds_chest_pain"}=="Postural") echo "checked"; ?> /><?php xl('Postural','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_chest_pain" value="Localized" 
<?php if($obj{"non_oasis_cardio_heart_sounds_chest_pain"}=="Localized") echo "checked"; ?> /><?php xl('Localized','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_chest_pain" value="Substernal" 
<?php if($obj{"non_oasis_cardio_heart_sounds_chest_pain"}=="Substernal") echo "checked"; ?> /><?php xl('Substernal','e')?></label><br>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_chest_pain" value="Radiating" 
<?php if($obj{"non_oasis_cardio_heart_sounds_chest_pain"}=="Radiating") echo "checked"; ?> /><?php xl('Radiating','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_chest_pain" value="Dull" 
<?php if($obj{"non_oasis_cardio_heart_sounds_chest_pain"}=="Dull") echo "checked"; ?> /><?php xl('Dull','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_chest_pain" value="Ache" 
<?php if($obj{"non_oasis_cardio_heart_sounds_chest_pain"}=="Ache") echo "checked"; ?> /><?php xl('Ache','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_chest_pain" value="Sharp" 
<?php if($obj{"non_oasis_cardio_heart_sounds_chest_pain"}=="Sharp") echo "checked"; ?> /><?php xl('Sharp','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_chest_pain" value="Vise-like" 
<?php if($obj{"non_oasis_cardio_heart_sounds_chest_pain"}=="Vise-like") echo "checked"; ?> /><?php xl('Vise-like','e')?></label><br>


            <?php xl('Associated with:','e')?>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_associated_with" value="Shortness of breath" 
<?php if($obj{"non_oasis_cardio_heart_sounds_associated_with"}=="Shortness of breath") echo "checked"; ?> /><?php xl('Shortness of breath','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_associated_with" value="Activity" 
<?php if($obj{"non_oasis_cardio_heart_sounds_associated_with"}=="Activity") echo "checked"; ?> /><?php xl('Activity','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_associated_with" value="Sweats" 
<?php if($obj{"non_oasis_cardio_heart_sounds_associated_with"}=="Sweats") echo "checked"; ?> /><?php xl('Sweats','e')?></label><br>
            <?php xl('Frequency/duration:','e')?>


                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_frequency" value="Palpitations" 
<?php if($obj{"non_oasis_cardio_heart_sounds_frequency"}=="Palpitations") echo "checked"; ?> /><?php xl('Palpitations','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_frequency" value="Fatigue" 
<?php if($obj{"non_oasis_cardio_heart_sounds_frequency"}=="Fatigue") echo "checked"; ?> /><?php xl('Fatigue','e')?></label><br>


            <label><input type="checkbox" name="non_oasis_cardio_heart_sounds[]" value="Edema" 
<?php if(in_array("Edema",$non_oasis_cardio_heart_sounds)) echo "checked"; ?> /><strong><?php xl('Edema:','e')?></strong></label><br />
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_edema" value="Pedal Right/Left" 
<?php if($obj{"non_oasis_cardio_heart_sounds_edema"}=="Pedal Right/Left") echo "checked"; ?> /><?php xl('Pedal Right/Left','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_edema" value="Sacral" 
<?php if($obj{"non_oasis_cardio_heart_sounds_edema"}=="Sacral") echo "checked"; ?> /><?php xl('Sacral','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_edema" value="Dependent" 
<?php if($obj{"non_oasis_cardio_heart_sounds_edema"}=="Dependent") echo "checked"; ?> /><?php xl('Dependent:','e')?></label>


                <label><input type="radio" name="non_oasis_cardio_heart_sounds_edema_dependent" value="Pitting +1" 
<?php if($obj{"non_oasis_cardio_heart_sounds_edema_dependent"}=="Pitting +1") echo "checked"; ?> /><?php xl('Pitting +1','e')?></label>
                <label><input type="radio" name="non_oasis_cardio_heart_sounds_edema_dependent" value="Pitting +2" 
<?php if($obj{"non_oasis_cardio_heart_sounds_edema_dependent"}=="Pitting +2") echo "checked"; ?> /><?php xl('Pitting +2','e')?></label>
                <label><input type="radio" name="non_oasis_cardio_heart_sounds_edema_dependent" value="Pitting +3" 
<?php if($obj{"non_oasis_cardio_heart_sounds_edema_dependent"}=="Pitting +3") echo "checked"; ?> /><?php xl('Pitting +3','e')?></label>
                <label><input type="radio" name="non_oasis_cardio_heart_sounds_edema_dependent" value="Pitting +4" 
<?php if($obj{"non_oasis_cardio_heart_sounds_edema_dependent"}=="Pitting +4") echo "checked"; ?> /><?php xl('Pitting +4','e')?></label>
                <label><input type="radio" name="non_oasis_cardio_heart_sounds_edema_dependent" value="Non-pitting" 
<?php if($obj{"non_oasis_cardio_heart_sounds_edema_dependent"}=="Non-pitting") echo "checked"; ?> /><?php xl('Non-pitting','e')?></label><br>




            <?php xl("Site","e");?>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_site" value="Cramps" 
<?php if($obj{"non_oasis_cardio_heart_sounds_site"}=="Cramps") echo "checked"; ?> /><?php xl('Cramps','e')?></label>
                <label><input type="checkbox" name="non_oasis_cardio_heart_sounds_site" value="Claudication" 
<?php if($obj{"non_oasis_cardio_heart_sounds_site"}=="Claudication") echo "checked"; ?> /><?php xl('Claudication','e')?></label><br>




            <?php xl("Capillary refill","e");?>
                <label><input type="radio" name="non_oasis_cardio_heart_sounds_capillary" value="less than 3 sec" 
<?php if($obj{"non_oasis_cardio_heart_sounds_capillary"}=="less than 3 sec") echo "checked"; ?> /><?php xl('less than 3 sec','e')?></label>
                <label><input type="radio" name="non_oasis_cardio_heart_sounds_capillary" value="greater than 3 sec" 
<?php if($obj{"non_oasis_cardio_heart_sounds_capillary"}=="greater than 3 sec") echo "checked"; ?> /><?php xl('greater than 3 sec','e')?></label><br>



            <label><input type="checkbox" name="non_oasis_cardio_heart_sounds[]" value="Other" 
<?php if(in_array("Other",$non_oasis_cardio_heart_sounds)) echo "checked"; ?> /><?php xl('Other:','e')?></label>
                <input type="text" name="non_oasis_cardio_heart_sounds_other" 
value="<?php echo stripslashes($obj{"non_oasis_cardio_heart_sounds_other"});?>" ><br>
            <label><input type="checkbox" name="non_oasis_cardio_heart_sounds[]" value="Weigh patient" 
<?php if(in_array("Weigh patient",$non_oasis_cardio_heart_sounds)) echo "checked"; ?> /><?php xl('Weigh patient','e')?></label><br>
            <label><input type="checkbox" name="non_oasis_cardio_heart_sounds[]" value="Notify MD of weight variations of" 
<?php if(in_array("Notify MD of weight variations of",$non_oasis_cardio_heart_sounds)) echo "checked"; ?> />
<?php xl('Notify MD of weight variations of','e')?></label>
<input type="text" name="non_oasis_cardio_heart_sounds_notify" id="non_oasis_cardio_heart_sounds_notify" style="width:100%" value="<?php echo stripslashes($obj{"non_oasis_cardio_heart_sounds_notify"});?>" />
               
               
        </td>

</tr>
</TABLE>






<h3 align="center"><?php xl('Braden Scale','e')?></h3>




<!-- ********************************  Braden Scale   ************************************** -->



  <table border="1px" cellspacing="0" class="formtable">
                <tr>
                    <td align="center" colspan="6">
       <strong><?php xl("BRADEN SCALE - For Predicting Pressure Sore Risk","e");?></strong><br>
                        <?php xl("*Fill out per organizational policy","e");?>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <?php xl("<strong>HIGH RISK:</strong> Total score less than or equal to 12","e") ?>&nbsp;&nbsp;&nbsp;
 <?php xl("<strong>MODERATE RISK:</strong> Total score 13 - 14","e") ?>&nbsp;&nbsp;&nbsp;
 <?php xl("<strong>LOW RISK:</strong> Total score 15 - 18","e") ?>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <strong><?php xl("RISK FACTOR","e");?></strong>
                    </td>
                    <td align="center" colspan="4">
                        <strong><?php xl("DESCRIPTION","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("SCORE","e");?></strong>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <strong><?php xl("SENSORY 
PERCEPTION","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("1. COMPLETELY 
LIMITED","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("2. VERY LIMITED","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("3. SLIGHTLY 
LIMITED","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("4. NO IMPAIRMENT","e");?></strong>
                    </td>
                    <td align="center">
                        <input type="text" 
name="non_oasis_braden_scale_sensory" onKeyUp="sum_braden_scale()" 
id="braden_sensory" 
value="<?php echo stripslashes($obj{"non_oasis_braden_scale_sensory"});?>" />
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <strong><?php xl("MOISTURE","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("1. CONSTANTLY 
MOIST","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("2. OFTEN MOIST","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("3. OCCASIONALLY 
MOIST","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("4. RARELY MOIST","e");?></strong>
                    </td>
                    <td align="center">
                        <input type="text" 
name="non_oasis_braden_scale_moisture" onKeyUp="sum_braden_scale()" 
id="braden_moisture" value="<?php echo stripslashes($obj{"non_oasis_braden_scale_moisture"});?>" >
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <strong><?php xl("ACTIVITY","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("1. BEDFAST","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("2. CHAIRFAST","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("3. WALKS 
OCCASIONALLY","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("4. WALKS 
FREQUENTLY","e");?></strong>
                    </td>
                    <td align="center">
                        <input type="text" 
name="non_oasis_braden_scale_activity" onKeyUp="sum_braden_scale()" 
id="braden_activity" value="<?php echo stripslashes($obj{"non_oasis_braden_scale_activity"});?>" >
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <strong><?php xl("MOBILITY","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("1. COMPLETELY 
IMMOBILE","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("2. VERY LIMITED","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("3. SLIGHTLY 
LIMITED","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("4. NO 
LIMITATIONS","e");?></strong>
                    </td>
                    <td align="center">
                        <input type="text" 
name="non_oasis_braden_scale_mobility" onKeyUp="sum_braden_scale()" 
id="braden_mobility" value="<?php echo stripslashes($obj{"non_oasis_braden_scale_mobility"});?>" >
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <strong><?php xl("NUTRITION","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("1. VERY POOR","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("2. PROBABLY 
INADEQUATE","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("3. ADEQUATE","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("4. EXCELLENT","e");?></strong>
                    </td>
                    <td align="center">
                        <input type="text" 
name="non_oasis_braden_scale_nutrition" onKeyUp="sum_braden_scale()" 
id="braden_nutrition" value="<?php echo stripslashes($obj{"non_oasis_braden_scale_nutrition"});?>" >
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <strong><?php xl("FRICTION AND 
SHEAR","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("1. PROBLEM","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("2. POTENTIAL 
PROBLEM","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("3. NO APPARENT 
PROBLEM","e");?></strong>
                    </td>
                    <td align="center">&nbsp;
                       
                    </td>
                    <td align="center">
                        <input type="text" 
name="non_oasis_braden_scale_friction" onKeyUp="sum_braden_scale()" 
id="braden_friction" value="<?php echo stripslashes($obj{"non_oasis_braden_scale_friction"});?>" >
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="4">
                        <strong><?php xl("Total score of 12 or less represents HIGH RISK","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("TOTAL SCORE:","e");?></strong>
                    </td>
                    <td align="center">
               <input type="text" name="non_oasis_braden_scale_total" id="braden_total" value="<?php echo stripslashes($obj{"non_oasis_braden_scale_total"});?>" readonly>
                    </td>
                </tr>
            </table>


                        </li>
                    </ul>
                </li>
<li>
                    <div><a href="#" id="black">Wound/Lesion &amp; Integumentary Status</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
<!-- *********************  Wound/Lesion and Integumentary Status   ******************** -->
                        <li>
                            <h3 align="center"><?php xl('Wound/Lesion','e')?></h3>





<!-- **********************************   Wound/Lesion     ************************************ -->

            <table border="1px" cellspacing="0" class="formtable" width="100%">
			<tr><td colspan="4">
			<?php


                /* Create a form object. */
                $c = new C_FormPainMap('non_oasis','bodymap_man.png');

                /* Render a 'new form' page. */
                echo $c->view_action($_GET['id']);
          ?>
			</td></tr>
                <tr>
                    <td align="center">
                        <strong><?php xl("WOUND/LESION (specify)","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("1","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("2","e");?></strong>
                    </td>
                    <td align="center">
                        <strong><?php xl("3","e");?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Location","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_location[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_location[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_location[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_location[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_location[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_location[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Type","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_type[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_type[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_type[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_type[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_type[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_type[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Status","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_status[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_status[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_status[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_status[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_status[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_status[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Size (cm)","e");?>
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" 
name="non_oasis_wound_lesion_size_length[]" size="5" 
value="<?php echo stripslashes($non_oasis_wound_lesion_size_length[0]);?>" >
                        <?php xl("Width","e");?>
                        <input type="text" 
name="non_oasis_wound_lesion_size_width[]" size="5" 
value="<?php echo stripslashes($non_oasis_wound_lesion_size_width[0]);?>" >
                        <?php xl("Depth","e");?>
                        <input type="text" 
name="non_oasis_wound_lesion_size_depth[]" size="5" 
value="<?php echo stripslashes($non_oasis_wound_lesion_size_depth[0]);?>" >
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" 
name="non_oasis_wound_lesion_size_length[]" size="5" 
value="<?php echo stripslashes($non_oasis_wound_lesion_size_length[1]);?>" >
                        <?php xl("Width","e");?>
                        <input type="text" 
name="non_oasis_wound_lesion_size_width[]" size="5" 
value="<?php echo stripslashes($non_oasis_wound_lesion_size_width[1]);?>" >
                        <?php xl("Depth","e");?>
                        <input type="text" 
name="non_oasis_wound_lesion_size_depth[]" size="5" 
value="<?php echo stripslashes($non_oasis_wound_lesion_size_depth[1]);?>" >
                    </td>
                    <td>
                        <?php xl("Length","e");?>
                        <input type="text" 
name="non_oasis_wound_lesion_size_length[]" size="5" 
value="<?php echo stripslashes($non_oasis_wound_lesion_size_length[2]);?>" >
                        <?php xl("Width","e");?>
                        <input type="text" 
name="non_oasis_wound_lesion_size_width[]" size="5" 
value="<?php echo stripslashes($non_oasis_wound_lesion_size_width[2]);?>" >
                        <?php xl("Depth","e");?>
                        <input type="text" 
name="non_oasis_wound_lesion_size_depth[]" size="5" 
value="<?php echo stripslashes($non_oasis_wound_lesion_size_depth[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Stage (pressure ulcers only)","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_stage[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_stage[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_stage[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_stage[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_stage[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_stage[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Tunneling/Undermining","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_tunneling[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_tunneling[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_tunneling[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_tunneling[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_tunneling[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_tunneling[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Odor","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_odor[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_odor[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_odor[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_odor[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_odor[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_odor[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Surrounding Skin","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_skin[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_skin[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_skin[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_skin[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_skin[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_skin[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Edema","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_edema[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_edema[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_edema[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_edema[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_edema[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_edema[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Stoma","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_stoma[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_stoma[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_stoma[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_stoma[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_stoma[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_stoma[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Appearance of the Wound Bed","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_appearance[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_appearance[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_appearance[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_appearance[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_appearance[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_appearance[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Drainage Amount","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_drainage[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_drainage[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_drainage[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_drainage[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_drainage[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_drainage[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Color","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_color[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_color[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_color[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_color[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_color[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_color[2]);?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php xl("Consistency","e");?>
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_consistency[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_consistency[0]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_consistency[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_consistency[1]);?>" >
                    </td>
                    <td>
                        <input type="text" 
name="non_oasis_wound_lesion_consistency[]" 
value="<?php echo stripslashes($non_oasis_wound_lesion_consistency[2]);?>" >
                    </td>
                </tr>
            </table>




<!-- ****************************  Integumentary Status   ******************************** -->


<h3 align="center"><?php xl('Integumentary Status','e')?></h3>


<table border="1px" cellspacing="0" class="formtable" width="100%">
<tr>

<td>
            <center><strong>
                <?php xl('INTEGUMENTARY STATUS','e')?>
                <label><input type="checkbox" 
name="non_oasis_integumentary_status_problem" value="<?php xl('No Problem',"e");?>" 
<?php if($obj{"non_oasis_integumentary_status_problem"}=="No Problem") echo "checked"; ?> ><?php xl('No Problem','e')?></label>
            </strong></center>
            <?php xl('Wound care done:','e')?>  
            <label><input type="radio" 
name="non_oasis_wound_care_done" value="Yes" 
<?php if($obj{"non_oasis_wound_care_done"}=="Yes") echo "checked"; ?> ><?php xl(' Yes 
','e')?></label>
            <label><input type="radio" 
name="non_oasis_wound_care_done" value="No" 
<?php if($obj{"non_oasis_wound_care_done"}=="No") echo "checked"; ?> ><?php xl(' No 
','e')?></label><br>
           
            <?php xl('Location(s) if patient has more than one wound site:','e')?>
            <input type="text" name="non_oasis_wound_location" 
 value="<?php echo stripslashes($obj{"non_oasis_wound_location"});?>" style="width:70%" ><br>
            <label><input type="checkbox" name="non_oasis_wound[]" value="<?php xl("Soiled dressing removed","e");?>"
<?php if(in_array("Soiled dressing removed",$non_oasis_wound)) echo "checked"; ?> ><?php xl('Soiled 
dressing removed','e')?></label>    
            <?php xl('By:','e')?>
            <label><input type="checkbox" 
name="non_oasis_wound_soiled_dressing_by" value="<?php 
xl("Patient","e");?>"
<?php if($obj{"non_oasis_wound_soiled_dressing_by"}=="Patient") echo "checked"; ?> ><?php xl('Patient','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_wound_soiled_dressing_by" value="<?php 
xl("Family/caregiver","e");?>"
<?php if($obj{"non_oasis_wound_soiled_dressing_by"}=="Family/caregiver") echo "checked"; ?> ><?php xl('Family/caregiver','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_wound_soiled_dressing_by" value="<?php 
xl("RN/PT","e");?>"
<?php if($obj{"non_oasis_wound_soiled_dressing_by"}=="RN/PT") echo "checked"; ?> ><?php xl('RN/PT','e')?></label>
            <br>
           
            <?php xl('Technique:','e')?>
            <label><input type="checkbox" 
name="non_oasis_wound_soiled_technique" value="<?php 
xl("Sterile","e");?>"
<?php if($obj{"non_oasis_wound_soiled_technique"}=="Sterile") echo "checked"; ?> ><?php xl('Sterile','e')?></label>
            <label><input type="checkbox" 
name="non_oasis_wound_soiled_technique" value="<?php 
xl("Clean","e");?>"
<?php if($obj{"non_oasis_wound_soiled_technique"}=="Clean") echo "checked"; ?> ><?php xl('Clean','e')?></label>
            <br>
           
            <label><input type="checkbox" name="non_oasis_wound[]" 
value="<?php xl("Wound cleaned with (specify):","e");?>"
<?php if(in_array("Wound cleaned with (specify):",$non_oasis_wound)) echo "checked"; ?>  ><?php xl('Wound 
cleaned with (specify):','e')?></label>
            <input type="text" name="non_oasis_wound_cleaned" 
 value="<?php echo stripslashes($obj{"non_oasis_wound_cleaned"});?>"  style="width:70%" ><br>
            <label><input type="checkbox" name="non_oasis_wound[]" 
value="<?php xl("Wound irrigated with (specify):","e");?>"
<?php if(in_array("Wound irrigated with (specify):",$non_oasis_wound)) echo "checked"; ?>  ><?php 
xl('Wound irrigated with (specify):','e')?></label>
            <input type="text" name="non_oasis_wound_irrigated" 
 value="<?php echo stripslashes($obj{"non_oasis_wound_irrigated"});?>"  style="width:70%" ><br>
            <label><input type="checkbox" name="non_oasis_wound[]" 
value="<?php xl("Wound packed with (specify):","e");?>"
<?php if(in_array("Wound packed with (specify):",$non_oasis_wound)) echo "checked"; ?>   ><?php xl('Wound 
packed with (specify):','e')?></label>
            <input type="text" name="non_oasis_wound_packed" 
 value="<?php echo stripslashes($obj{"non_oasis_wound_packed"});?>"  style="width:70%" ><br>
            <label><input type="checkbox" name="non_oasis_wound[]" 
value="<?php xl("Wound dressing applied (specify):","e");?>"
<?php if(in_array("Wound dressing applied (specify):",$non_oasis_wound)) echo "checked"; ?>   ><?php 
xl('Wound dressing applied (specify):','e')?></label>
            <input type="text" name="non_oasis_wound_dressing_apply" 
 value="<?php echo stripslashes($obj{"non_oasis_wound_dressing_apply"});?>"  style="width:70%" ><br>
            <label><input type="checkbox" name="non_oasis_wound[]" 
value="<?php xl("Patient tolerated procedure well","e");?>"
<?php if(in_array("Patient tolerated procedure well",$non_oasis_wound)) echo "checked"; ?> ><?php 
xl('Patient tolerated procedure well','e')?></label><br />
            <label><input type="checkbox" name="non_oasis_wound[]" 
value="<?php xl("Incision care with (specify):","e");?>"
<?php if(in_array("Incision care with (specify):",$non_oasis_wound)) echo "checked"; ?>  ><?php 
xl('Incision care with (specify):','e')?></label>
            <input type="text" name="non_oasis_wound_incision" 
 value="<?php echo stripslashes($obj{"non_oasis_wound_incision"});?>"  style="width:70%" ><br>
            <label><input type="checkbox" name="non_oasis_wound[]" 
value="<?php xl("Staples present","e");?>"
<?php if(in_array("Staples present",$non_oasis_wound)) echo "checked"; ?> ><?php xl('Staples 
present','e')?></label><br>
            <?php xl("Comments:","e");?>
            <textarea name="non_oasis_wound_comment" style="width:100%" rows="3"  >
<?php echo stripslashes($obj{"non_oasis_wound_comment"});?></textarea><br>
           
            <?php xl('Satisfactory return demo:','e')?>  
            <label><input type="radio" 
name="non_oasis_satisfactory_return_demo" value="Yes"
<?php if($obj{"non_oasis_satisfactory_return_demo"}=="Yes") echo "checked"; ?> ><?php xl(' Yes 
','e')?></label>
            <label><input type="radio" 
name="non_oasis_satisfactory_return_demo" value="No"
<?php if($obj{"non_oasis_satisfactory_return_demo"}=="No") echo "checked"; ?> ><?php xl(' No 
','e')?></label><br>
            <?php xl('Education: ','e')?>
            <label><input type="checkbox" name="non_oasis_wound_education" value="<?php xl("Yes","e");?>"
<?php if($obj{"non_oasis_wound_education"}=="Yes") echo "checked"; ?> ><?php xl('Yes','e')?></label><br>
            <?php xl("Comments:","e");?>
            <textarea name="non_oasis_wound_education_comment" 
rows="3" style="width:100%;"><?php echo stripslashes($obj{"non_oasis_wound_education_comment"});?></textarea>
        </td>
</tr>
</table>




                        </li>
                    </ul>
                </li>
              
<li>
                    <div><a href="#" id="black">Infusion, Enteral Feedings - Access Device & Skilled Care Provided This Visit</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
<!-- *********************  Infusion, enternal feeding and skilled care   ******************** -->
                        <li>
                            <h3 align="center"><?php xl('Infusion','e')?></h3>




<!-- ********************** Infusion  ************************ -->

<table width="100%" border="1" class="formtable">
<tr>
<td colspan="2">
<center><strong><?php xl('INFUSION','e')?></strong></center>
</TD>
</TR>
<TR>
<td width="50%">
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Peripheral: (specify)"  id="non_oasis_infusion" 
<?php if(in_array("Peripheral: (specify)",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Peripheral: (specify)','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_peripheral" id="non_oasis_infusion_peripheral" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_peripheral"});?>" /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="PICC: (specify, size, brand)"  id="non_oasis_infusion" 
<?php if(in_array("PICC: (specify, size, brand)",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('PICC: (specify, size, brand)','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_PICC" id="non_oasis_infusion_PICC" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_PICC"});?>" /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Central"  id="non_oasis_infusion" 
<?php if(in_array("Central",$non_oasis_infusion)) echo "checked"; ?> /><?php xl('Central','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Midline/Midclavicular"  id="non_oasis_infusion" 
<?php if(in_array("Midline/Midclavicular",$non_oasis_infusion)) echo "checked"; ?> /><?php xl('Midline/Midclavicular','e')?></label><br />
&nbsp;&nbsp;&nbsp;&nbsp;
<label><input type="radio" name="non_oasis_infusion_central" value="Single lumen"  id="non_oasis_infusion_central" 
<?php if($obj{"non_oasis_infusion_central"}=="Single lumen") echo "checked"; ?> />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_central" value="Double lumen"  id="non_oasis_infusion_central" 
<?php if($obj{"non_oasis_infusion_central"}=="Double lumen") echo "checked"; ?> />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_central" value="Triple lumen"  id="non_oasis_infusion_central" 
<?php if($obj{"non_oasis_infusion_central"}=="Triple lumen") echo "checked"; ?> />
<?php xl('Triple lumen','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;

<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_central_date' id='non_oasis_infusion_central_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly 
value="<?php echo stripslashes($obj{"non_oasis_infusion_central_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date8' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_central_date", ifFormat:"%Y-%m-%d", button:"img_curr_date8"});
                        </script>
<br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="X-ray verification:"  id="non_oasis_infusion" 
<?php if(in_array("X-ray verification:",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('X-ray verification:','e')?></strong></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_xray" value="Yes"  id="non_oasis_infusion_xray" 
<?php if($obj{"non_oasis_infusion_xray"}=="Yes") echo "checked"; ?> />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_xray" value="No"  id="non_oasis_infusion_xray" 
<?php if($obj{"non_oasis_infusion_xray"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;

<br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Mid arm circumference in/cm"  id="non_oasis_infusion" 
<?php if(in_array("Mid arm circumference in/cm",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Mid arm circumference in/cm','e')?></label> &nbsp;
<input type="text" name="non_oasis_infusion_circum" id="non_oasis_infusion_circum" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_circum"});?>" /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="External catheter length in/cm"  id="non_oasis_infusion" 
<?php if(in_array("External catheter length in/cm",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('External catheter length in/cm','e')?></label> &nbsp;
<input type="text" name="non_oasis_infusion_length" id="non_oasis_infusion_length" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_length"});?>" /><br />
<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Hickman"  id="non_oasis_infusion" 
<?php if(in_array("Hickman",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Hickman','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Broviac"  id="non_oasis_infusion" 
<?php if(in_array("Broviac",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Broviac','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Groshong"  id="non_oasis_infusion" 
<?php if(in_array("Groshong",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Groshong','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Jugular"  id="non_oasis_infusion" 
<?php if(in_array("Jugular",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Jugular','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Subclavian"  id="non_oasis_infusion" 
<?php if(in_array("Subclavian",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Subclavian','e')?></label> &nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
<label><input type="radio" name="non_oasis_infusion_hickman" value="Single lumen"  id="non_oasis_infusion_hickman" 
<?php if($obj{"non_oasis_infusion_hickman"}=="Single lumen") echo "checked"; ?> />
<?php xl('Single lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_hickman" value="Double lumen"  id="non_oasis_infusion_hickman" 
<?php if($obj{"non_oasis_infusion_hickman"}=="Double lumen") echo "checked"; ?> />
<?php xl('Double lumen','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_hickman" value="Triple lumen"  id="non_oasis_infusion_hickman" 
<?php if($obj{"non_oasis_infusion_hickman"}=="Triple lumen") echo "checked"; ?> />
<?php xl('Triple lumen','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_hickman_date' id='non_oasis_infusion_hickman_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly
value="<?php echo stripslashes($obj{"non_oasis_infusion_hickman_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date9' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_hickman_date", ifFormat:"%Y-%m-%d", button:"img_curr_date9"});
                        </script>
<br />



<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Epidural catheter"  id="non_oasis_infusion" 
<?php if(in_array("Epidural catheter",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Epidural catheter','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Tunneled"  id="non_oasis_infusion" 
<?php if(in_array("Tunneled",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Tunneled','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Port1"  id="non_oasis_infusion" 
<?php if(in_array("Port1",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Port','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_epidural_date' id='non_oasis_infusion_epidural_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly
value="<?php echo stripslashes($obj{"non_oasis_infusion_epidural_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date10' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_epidural_date", ifFormat:"%Y-%m-%d", button:"img_curr_date10"});
                        </script>
<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Implanted VAD"  id="non_oasis_infusion" 
<?php if(in_array("Implanted VAD",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Implanted VAD','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Venous"  id="non_oasis_infusion" 
<?php if(in_array("Venous",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Venous','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Arterial"  id="non_oasis_infusion" 
<?php if(in_array("Arterial",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Arterial','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Peritoneal"  id="non_oasis_infusion" 
<?php if(in_array("Peritoneal",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Peritoneal','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_implanted_date' id='non_oasis_infusion_implanted_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly
value="<?php echo stripslashes($obj{"non_oasis_infusion_implanted_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date11' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_implanted_date", ifFormat:"%Y-%m-%d", button:"img_curr_date11"});
                        </script>
<br />



<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Intrathecal"  id="non_oasis_infusion" 
<?php if(in_array("Intrathecal",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Intrathecal','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Port2"  id="non_oasis_infusion" 
<?php if(in_array("Port2",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Port','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Reservoir"  id="non_oasis_infusion" 
<?php if(in_array("Reservoir",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Reservoir','e')?></label> &nbsp;
<br />
<?php xl('Date of placement:','e')?><input type='text' size='10' name='non_oasis_infusion_intrathecal_date' id='non_oasis_infusion_intrathecal_date'
                        title='<?php xl('Date','e'); ?>' onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc);' readonly
value="<?php echo stripslashes($obj{"non_oasis_infusion_intrathecal_date"});?>" />
                        <img src='../../pic/show_calendar.gif' align='absbottom' width='24'
                        height='22' id='img_curr_date12' border='0' alt='[?]'
                        style='cursor: pointer; cursor: hand'
                        title='<?php xl('Click here to choose a date','e'); ?>'><script    LANGUAGE="JavaScript">
                            Calendar.setup({inputField:"non_oasis_infusion_intrathecal_date", ifFormat:"%Y-%m-%d", button:"img_curr_date12"});
                        </script>
<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Medication administered1"  id="non_oasis_infusion" 
<?php if(in_array("Medication administered1",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_med1_admin" id="non_oasis_infusion_med1_admin" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_admin"});?>" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_name" id="non_oasis_infusion_med1_name" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_name"});?>" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_dose" id="non_oasis_infusion_med1_dose" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_dose"});?>" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_dilution" id="non_oasis_infusion_med1_dilution" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_dilution"});?>" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_route" id="non_oasis_infusion_med1_route" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_route"});?>" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_frequency" id="non_oasis_infusion_med1_frequency" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_frequency"});?>" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med1_duration" id="non_oasis_infusion_med1_duration" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med1_duration"});?>" />
</label>



<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Medication administered2"  id="non_oasis_infusion" 
<?php if(in_array("Medication administered2",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_med2_admin" id="non_oasis_infusion_med2_admin" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_admin"});?>" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_name" id="non_oasis_infusion_med2_name" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_name"});?>" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_dose" id="non_oasis_infusion_med2_dose" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_dose"});?>" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_dilution" id="non_oasis_infusion_med2_dilution" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_dilution"});?>" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_route" id="non_oasis_infusion_med2_route" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_route"});?>" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_frequency" id="non_oasis_infusion_med2_frequency" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_frequency"});?>" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med2_duration" id="non_oasis_infusion_med2_duration" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med2_duration"});?>" />
</label>


<br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Medication administered3"  id="non_oasis_infusion" 
<?php if(in_array("Medication administered3",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Medication(s) administered:','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_med3_admin" id="non_oasis_infusion_med3_admin" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_admin"});?>" />
<br />
<label><?php xl('(name of drug)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_name" id="non_oasis_infusion_med3_name" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_name"});?>" /><br />
</label>
<label><?php xl('Dose','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_dose" id="non_oasis_infusion_med3_dose" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_dose"});?>" />
</label>
<label><?php xl('Dilution','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_dilution" id="non_oasis_infusion_med3_dilution" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_dilution"});?>" />
</label>
<label><?php xl('Route','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_route" id="non_oasis_infusion_med3_route" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_route"});?>" /><br />
</label>
<label><?php xl('Frequency','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_frequency" id="non_oasis_infusion_med3_frequency" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_frequency"});?>" />
</label>
<label><?php xl('Duration of therapy','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_med3_duration" id="non_oasis_infusion_med3_duration" size="10" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_med3_duration"});?>" />
</label>

</td>

<td valign="top">

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Pump:(type, specify)"  id="non_oasis_infusion" 
<?php if(in_array("Pump:(type, specify)",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Pump:(type, specify)','e')?></strong></label> &nbsp;
<input type="text" name="non_oasis_infusion_pump" id="non_oasis_infusion_pump" size="25" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_pump"});?>" />
<br />
<strong><?php xl('Administered by:','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_infusion_admin_by" value="Self"  id="non_oasis_infusion_admin_by" 
<?php if($obj{"non_oasis_infusion_admin_by"}=="Self") echo "checked"; ?>  />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_admin_by" value="Caregiver"  id="non_oasis_infusion_admin_by" 
<?php if($obj{"non_oasis_infusion_admin_by"}=="Caregiver") echo "checked"; ?>  />
<?php xl('Caregiver','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_admin_by" value="RN"  id="non_oasis_infusion_admin_by" 
<?php if($obj{"non_oasis_infusion_admin_by"}=="RN") echo "checked"; ?>  />
<?php xl('RN','e')?></label> &nbsp;
<label><br />
<input type="checkbox" name="non_oasis_infusion_admin_by" value="Other"  id="non_oasis_infusion_admin_by" 
<?php if($obj{"non_oasis_infusion_admin_by"}=="Other") echo "checked"; ?>  />
<?php xl('Other','e')?></label> &nbsp;
<input type="text" name="non_oasis_infusion_admin_by_other" id="non_oasis_infusion_admin_by_other" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_admin_by_other"});?>" />

<br />
<strong><?php xl('Purpose of Intravenous Access:','e')?></strong></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Antibiotic therapy"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Antibiotic therapy",$non_oasis_infusion_purpose)) echo "checked"; ?>  />
<?php xl('Antibiotic therapy','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Pain Control"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Pain Control",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Pain Control','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Chemotherapy"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Chemotherapy",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Chemotherapy','e')?></label> &nbsp;
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Maintain venous access"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Maintain venous access",$non_oasis_infusion_purpose)) echo "checked"; ?>  />
<?php xl('Maintain venous access','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Hydration"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Hydration",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Hydration','e')?></label> &nbsp;
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Parenteral nutrition"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Parenteral nutrition",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Parenteral nutrition','e')?></label> &nbsp;
<br />
<label>
<input type="checkbox" name="non_oasis_infusion_purpose[]" value="Other"  id="non_oasis_infusion_purpose" 
<?php if(in_array("Other",$non_oasis_infusion_purpose)) echo "checked"; ?> />
<?php xl('Other','e')?></label> &nbsp;
<br />
<textarea name="non_oasis_infusion_purpose_other" rows="2" cols="48">
<?php echo stripslashes($obj{"non_oasis_infusion_purpose_other"});?></textarea>
<br /><br />
<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Infusion care provided during visit"  id="non_oasis_infusion" 
<?php if(in_array("Infusion care provided during visit",$non_oasis_infusion)) echo "checked"; ?> />
<?php xl('Infusion care provided during visit','e')?></label> &nbsp;
<br />
<textarea name="non_oasis_infusion_care_provided" rows="2" cols="48">
<?php echo stripslashes($obj{"non_oasis_infusion_care_provided"});?></textarea>
<br /><br />

<label>
<input type="checkbox" name="non_oasis_infusion[]" value="Dressing change:"  id="non_oasis_infusion" 
<?php if(in_array("Dressing change:",$non_oasis_infusion)) echo "checked"; ?> />
<strong><?php xl('Dressing change:','e')?></strong></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_dressing" value="Sterile"  id="non_oasis_infusion_dressing" 
<?php if($obj{"non_oasis_infusion_dressing"}=="Sterile") echo "checked"; ?> />
<?php xl('Sterile','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_infusion_dressing" value="Clean"  id="non_oasis_infusion_dressing" 
<?php if($obj{"non_oasis_infusion_dressing"}=="Clean") echo "checked"; ?> />
<?php xl('Clean','e')?></label> &nbsp;
<br />

<strong><?php xl('Performed by:','e')?></strong> &nbsp;&nbsp;&nbsp;&nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="Self"  id="non_oasis_infusion_performed_by" 
<?php if($obj{"non_oasis_infusion_performed_by"}=="Self") echo "checked"; ?>  />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="RN"  id="non_oasis_infusion_performed_by" 
<?php if($obj{"non_oasis_infusion_performed_by"}=="RN") echo "checked"; ?>  />
<?php xl('RN','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="Caregiver"  id="non_oasis_infusion_performed_by" 
<?php if($obj{"non_oasis_infusion_performed_by"}=="Caregiver") echo "checked"; ?>  />
<?php xl('Caregiver','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_infusion_performed_by" value="Other"  id="non_oasis_infusion_performed_by" 
<?php if($obj{"non_oasis_infusion_performed_by"}=="Other") echo "checked"; ?>  />
<?php xl('Other','e')?></label> &nbsp;
<br />

<label><?php xl('Frequency (specify)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_frequency" id="non_oasis_infusion_frequency" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_frequency"});?>" />
</label>
<br />
<label><?php xl('Injection cap change (specify frequency)','e')?> &nbsp;
<input type="text" name="non_oasis_infusion_injection" id="non_oasis_infusion_injection" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_infusion_injection"});?>" />
</label>
<br />
<extarea><?php xl('Labs drawn','e')?> &nbsp;
<br />
<textarea name="non_oasis_infusion_labs_drawn" rows="2" cols="48">
<?php echo stripslashes($obj{"non_oasis_infusion_labs_drawn"});?></textarea>
</label>
<br />
<label><?php xl('Interventions/Instructions/Comments','e')?> &nbsp;
<br />
<textarea name="non_oasis_infusion_interventions" rows="2" cols="48">
<?php echo stripslashes($obj{"non_oasis_infusion_interventions"});?></textarea>
</label>


</td>

</tr>
</TABLE>



		<h3 align="center"><?php xl('Enteral Feedings & Skilled Care','e')?></h3>


<!-- Enteral and Skilled -->

<TABLE width="100%" border="1"  class="formtable">
<tr>
<td width="50%">
<center><strong><?php xl('ENTERAL FEEDINGS - ACCESS DEVICE','e')?></strong></center>
<br />
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Nasogastric"  id="non_oasis_enteral" 
<?php if(in_array("Nasogastric",$non_oasis_enteral)) echo "checked"; ?> />
<?php xl('Nasogastric','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Gastrostomy"  id="non_oasis_enteral" 
<?php if(in_array("Gastrostomy",$non_oasis_enteral)) echo "checked"; ?> />
<?php xl('Gastrostomy','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Jejunostomy"  id="non_oasis_enteral" 
<?php if(in_array("Jejunostomy",$non_oasis_enteral)) echo "checked"; ?> />
<?php xl('Jejunostomy','e')?></label> &nbsp;<br />
<label>
<input type="checkbox" name="non_oasis_enteral[]" value="Other (specify)"  id="non_oasis_enteral" 
<?php if(in_array("Other (specify)",$non_oasis_enteral)) echo "checked"; ?> />
<?php xl('Other (specify)','e')?></label> &nbsp;

<input type="text" name="non_oasis_enteral_other" id="non_oasis_enteral_other" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_enteral_other"});?>" />
<br />

<label><strong><?php xl('Pump: (type/specify)','e')?></strong> &nbsp;
<input type="text" name="non_oasis_enteral_pump" id="non_oasis_enteral_pump" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_enteral_pump"});?>" />
</label>
<br />

<strong><?php xl('Feedings:','e')?></strong> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_feedings" value="Bolus"  id="non_oasis_enteral_feedings" 
<?php if($obj{"non_oasis_enteral_feedings"}=="Bolus") echo "checked"; ?>  />
<?php xl('Bolus','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_feedings" value="Continuous"  id="non_oasis_enteral_feedings" 
<?php if($obj{"non_oasis_enteral_feedings"}=="Continuous") echo "checked"; ?>  />
<?php xl('Continuous','e')?></label> &nbsp;

<label><?php xl('Rate:','e')?> &nbsp;
<input type="text" name="non_oasis_enteral_rate" id="non_oasis_enteral_rate" size="14" 
value="<?php echo stripslashes($obj{"non_oasis_enteral_rate"});?>" />
</label>
<br />

<label>
<strong><?php xl('Flush Protocol: (amt./specify)','e')?></strong> &nbsp;
<textarea name="non_oasis_enteral_flush" rows="2" cols="48" >
<?php echo stripslashes($obj{"non_oasis_enteral_flush"});?></textarea>
</label>
<br />


<strong><?php xl('Performed by:','e')?></strong> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="Self"  id="non_oasis_enteral_performed_by" 
<?php if($obj{"non_oasis_enteral_performed_by"}=="Self") echo "checked"; ?>  />
<?php xl('Self','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="RN"  id="non_oasis_enteral_performed_by" 
<?php if($obj{"non_oasis_enteral_performed_by"}=="RN") echo "checked"; ?>  />
<?php xl('RN','e')?></label> &nbsp;
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="Caregiver"  id="non_oasis_enteral_performed_by" 
<?php if($obj{"non_oasis_enteral_performed_by"}=="Caregiver") echo "checked"; ?>  />
<?php xl('Caregiver','e')?></label> &nbsp;<br>
<label>
<input type="checkbox" name="non_oasis_enteral_performed_by" value="Other"  id="non_oasis_enteral_performed_by" 
<?php if($obj{"non_oasis_enteral_performed_by"}=="Other") echo "checked"; ?>  />
<?php xl('Other','e')?></label> &nbsp;

<input type="text" name="non_oasis_enteral_performed_by_other" id="non_oasis_enteral_performed_by_other" size="45" 
value="<?php echo stripslashes($obj{"non_oasis_enteral_performed_by_other"});?>" />
<br />

<label>
<strong><?php xl('Dressing/Site care:(specify)','e')?></strong> &nbsp;
<textarea name="non_oasis_enteral_dressing" rows="2" cols="48" >
<?php echo stripslashes($obj{"non_oasis_enteral_dressing"});?></textarea>
</label>
<br />

<label><?php xl('Interventions/Instructions/Comments','e')?> &nbsp;
<textarea name="non_oasis_enteral_interventions" rows="2" cols="48" >
<?php echo stripslashes($obj{"non_oasis_enteral_interventions"});?></textarea>
</label>
<br />


</td>

<td>

<center><strong><?php xl('SKILLED CARE PROVIDED THIS VISIT','e')?></strong></center>
<br />
<strong><?php xl('CARE COORDINATION:','e')?></strong> &nbsp;
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="RN"  id="non_oasis_skilled_care" 
<?php if(in_array("RN",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('RN','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="PT"  id="non_oasis_skilled_care" 
<?php if(in_array("PT",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('PT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="OT"  id="non_oasis_skilled_care" 
<?php if(in_array("OT",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('OT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="ST"  id="non_oasis_skilled_care" 
<?php if(in_array("ST",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('ST','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="MSW"  id="non_oasis_skilled_care" 
<?php if(in_array("MSW",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('MSW','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_skilled_care[]" value="Aide"  id="non_oasis_skilled_care" 
<?php if(in_array("Aide",$non_oasis_skilled_care)) echo "checked"; ?> />
<?php xl('Aide','e')?>
</label>



</td>
</tr>
</TABLE>




                        </li>
                    </ul>
                </li>

<li>
                    <div><a href="#" id="black">Summary</a> <span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>



<!-- *********************  Summary   ******************** -->
                        <li>
                            <h3 align="center"><?php xl('Summary','e')?></h3>



<table width="100%" border="1"  class="formtable">

<tr>
<TD>
<strong><?php xl('DISCIPLINES INVOLVED:','e')?></strong> &nbsp;<br />
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="SN"  id="non_oasis_summary_disciplines" 
<?php if(in_array("SN",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('SN','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="PT"  id="non_oasis_summary_disciplines" 
<?php if(in_array("PT",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('PT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="OT"  id="non_oasis_summary_disciplines" 
<?php if(in_array("OT",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('OT','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="ST"  id="non_oasis_summary_disciplines" 
<?php if(in_array("ST",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('ST','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="MSW"  id="non_oasis_summary_disciplines" 
<?php if(in_array("MSW",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('MSW','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="CHHA"  id="non_oasis_summary_disciplines" 
<?php if(in_array("CHHA",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('CHHA','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_disciplines[]" value="Other"  id="non_oasis_summary_disciplines" 
<?php if(in_array("Other",$non_oasis_summary_disciplines)) echo "checked"; ?> />
<?php xl('Other','e')?>
</label>
<input type="text" name="non_oasis_summary_disciplines_other" id="non_oasis_summary_disciplines_other" size="20" 
value="<?php echo stripslashes($obj{"non_oasis_summary_disciplines_other"});?>" />
<br />

<strong><?php xl('PHYSICIAN NOTIFIED:','e')?></strong> &nbsp;
<label><input type="radio" name="non_oasis_summary_physician" value="Yes"  id="non_oasis_summary_physician" 
<?php if($obj{"non_oasis_summary_physician"}=="Yes") echo "checked"; ?> >
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_physician" value="No"  id="non_oasis_summary_physician" 
<?php if($obj{"non_oasis_summary_physician"}=="No") echo "checked"; ?> >
<?php xl('No','e')?></label> &nbsp;
</TD>
</tr>

<tr>
<TD>
<center><strong><?php xl('Complete this Section for Discharge Purposes (unless Summary is written elsewhere','e')?></strong>
<input type="checkbox" name="non_oasis_summary_elsewhere" value="Yes"  id="non_oasis_summary_elsewhere" 
<?php if($obj{"non_oasis_summary_elsewhere"}=="Yes") echo "checked"; ?>  />
<strong><?php xl(')','e')?></strong>
</center><br />

<label>
<strong><?php xl('REASON FOR ADMISSION / SUMMARY:','e')?></strong><br />
<textarea name="non_oasis_summary_reason" rows="10" style="width:100%" >
<?php echo stripslashes($obj{"non_oasis_summary_reason"});?></textarea>
</label>
</TD>
</tr>



<tr>
<TD>
<strong><?php xl('MEDICATION STATUS','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_summary_medication" value="Medication regimen reviewed"  id="non_oasis_summary_medication" 
<?php if($obj{"non_oasis_summary_medication"}=="Medication regimen reviewed") echo "checked"; ?>  />
<?php xl('Medication regimen reviewed','e')?>
</label>
<br />

<?php xl('Check if any of the following were identified:','e')?>
<br />

<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Potential adverse effects/drug reactions"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Potential adverse effects/drug reactions",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Potential adverse effects/drug reactions','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Ineffective drug therapy"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Ineffective drug therapy",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Ineffective drug therapy','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Significant side effects"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Significant side effects",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Significant side effects','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Significant drug interactions"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Significant drug interactions",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Significant drug interactions','e')?>
</label>
<br />

<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Duplicate drug therapy"  id="non_oasis_summary_medication_identified"  <?php if(in_array("Duplicate drug therapy",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Duplicate drug therapy','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="Non compliance with drug therapy"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("Non compliance with drug therapy",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('Non compliance with drug therapy','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_medication_identified[]" value="No change"  id="non_oasis_summary_medication_identified" 
<?php if(in_array("No change",$non_oasis_summary_medication_identified)) echo "checked"; ?> />
<?php xl('No change','e')?>
</label>
<label>

</TD>
</tr>

<tr>
<TD>
<strong><?php xl('INDICATE REASON FOR DISCHARGE','e')?></strong> &nbsp; &nbsp; &nbsp; &nbsp;
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient/Family request"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient/Family request") echo "checked"; ?>  />
<?php xl('Patient/Family request','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Failure to maintain services of an attending physician"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Failure to maintain services of an attending physician") echo "checked"; ?>  />
<?php xl('Failure to maintain services of an attending physician','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient-centered goals achieved"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient-centered goals achieved") echo "checked"; ?>  />
<?php xl('Patient-centered goals achieved','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Physician request"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Physician request") echo "checked"; ?>  />
<?php xl('Physician request','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Agency/Organization decision"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Agency/Organization decision") echo "checked"; ?>  />
<?php xl('Agency/Organization decision','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient expired"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient expired") echo "checked"; ?>  />
<?php xl('Patient expired','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Repeatedly not home/not found"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Repeatedly not home/not found") echo "checked"; ?>  />
<?php xl('Repeatedly not home/not found','e')?>
</label>
<label>
<?php xl('Explain:','e')?>
<input type="text" name="non_oasis_summary_reason_discharge_explain" id="non_oasis_summary_reason_discharge_explain" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_summary_reason_discharge_explain"});?>" />
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Geographic relocation"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Geographic relocation") echo "checked"; ?>  />
<?php xl('Geographic relocation','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient refused to accept care/treatments as ordered"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient refused to accept care/treatments as ordered") echo "checked"; ?>  />
<?php xl('Patient refused to accept care/treatments as ordered','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Patient refused further care"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Patient refused further care") echo "checked"; ?>  />
<?php xl('Patient refused further care','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Persistent noncompliance with POC"  id="non_oasis_summary_reason_discharge"  <?php if($obj{"non_oasis_summary_reason_discharge"}=="Persistent noncompliance with POC") echo "checked"; ?>  />
<?php xl('Persistent noncompliance with POC','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="No longer home bound"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="No longer home bound") echo "checked"; ?>  />
<?php xl('No longer home bound','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reason_discharge" value="Other (specify)"  id="non_oasis_summary_reason_discharge" 
<?php if($obj{"non_oasis_summary_reason_discharge"}=="Other (specify)") echo "checked"; ?>  />
<?php xl('Other (specify)','e')?>
</label>
<input type="text" name="non_oasis_summary_reason_discharge_other" id="non_oasis_summary_reason_discharge_other" size="30" 
value="<?php echo stripslashes($obj{"non_oasis_summary_reason_discharge_other"});?>" />
</TD>
</tr>

<tr><TD>
<label>
<strong>
<?php xl('DISCHARGE INSTRUCTIONS','e')?></strong>
<?php xl('(specify future follow-up, referrals, etc.)','e')?>
<textarea name="non_oasis_summary_discharge_inst" rows="7" style="width:100%">
<?php echo stripslashes($obj{"non_oasis_summary_discharge_inst"});?></textarea>
</label>
<br />


<strong><?php xl('Reviewed:','e')?></strong>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Home safety"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Home safety") echo "checked"; ?>  />
<?php xl('Home safety','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Fall safety"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Fall safety") echo "checked"; ?>  />
<?php xl('Fall safety','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Medication safety"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Medication safety") echo "checked"; ?>  />
<?php xl('Medication safety','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="When to contact physician"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="When to contact physician") echo "checked"; ?>  />
<?php xl('When to contact physician','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Next appointment physician"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Next appointment physician") echo "checked"; ?>  />
<?php xl('Next appointment physician','e')?>
</label>
<br />
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Standard precautions"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Standard precautions") echo "checked"; ?>  />
<?php xl('Standard precautions','e')?>
</label>
<label>
<input type="checkbox" name="non_oasis_summary_reviewed" value="Other (describe)"  id="non_oasis_summary_reviewed" 
<?php if($obj{"non_oasis_summary_reviewed"}=="Other (describe)") echo "checked"; ?>  />
<?php xl('Other (describe)','e')?>
</label>
<input type="text" name="non_oasis_summary_reviewed_other" id="non_oasis_summary_reviewed_other" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_summary_reviewed_other"});?>" />
<br />

<strong><?php xl('Immunizations current:','e')?> &nbsp;</strong>
<label><input type="radio" name="non_oasis_summary_immunization" value="Yes"  id="non_oasis_summary_immunization" 
<?php if($obj{"non_oasis_summary_immunization"}=="Yes") echo "checked"; ?> />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_immunization" value="No"  id="non_oasis_summary_immunization" 
<?php if($obj{"non_oasis_summary_immunization"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;
<label>
<?php xl('explain','e')?></label> &nbsp;
<input type="text" name="non_oasis_summary_immun_explain" id="non_oasis_summary_immun_explain" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_summary_immun_explain"});?>" />
</label>
<br />


<strong><?php xl('Written instructions given to patient/caregiver:','e')?> &nbsp;</strong>
<label><input type="radio" name="non_oasis_summary_written" value="Yes"  id="non_oasis_summary_written" 
<?php if($obj{"non_oasis_summary_written"}=="Yes") echo "checked"; ?> />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_written" value="No"  id="non_oasis_summary_written" 
<?php if($obj{"non_oasis_summary_written"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;
<label>
<?php xl('explain','e')?></label> &nbsp;
<input type="text" name="non_oasis_summary_written_explain" id="non_oasis_summary_written_explain" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_summary_written_explain"});?>" />
</label>
<br />


<strong><?php xl('Patient/Caregiver demonstrates understanding of instructions:','e')?></strong> &nbsp;
<label><input type="radio" name="non_oasis_summary_demonstrates" value="Yes"  id="non_oasis_summary_demonstrates" 
<?php if($obj{"non_oasis_summary_demonstrates"}=="Yes") echo "checked"; ?> />
<?php xl('Yes','e')?></label> &nbsp;
<label><input type="radio" name="non_oasis_summary_demonstrates" value="No"  id="non_oasis_summary_demonstrates" 
<?php if($obj{"non_oasis_summary_demonstrates"}=="No") echo "checked"; ?> />
<?php xl('No','e')?></label> &nbsp;
<label>
<?php xl('explain','e')?></label> &nbsp;
<input type="text" name="non_oasis_summary_demonstrates_explain" id="non_oasis_summary_demonstrates_explain" style="width:100%" 
value="<?php echo stripslashes($obj{"non_oasis_summary_demonstrates_explain"});?>" />
</label>
<br />

</TD></tr>


</TABLE>



                        </li>
                    </ul>
                </li>



<!--
		<li>
		   <div><a href="#" id="black">Outcome and Assessment Information Set (OASIS-C draft)</a>
<span id="mod"><a href="#">(Expand)</a></span></div>
                    <ul>
                        <li>
						<center>
		<h3 align="center"><?php xl('Outcome and Assessment Information Set (OASIS-C draft)','e')?></h3>
		<h3 align="center"><?php xl('Items to be Used at Specific Time Points','e')?></h3></center>














                        </li>
                    </ul>
                </li>
            
-->


</ul>
<br>

      <a id="btn_save" href="javascript:void(0)"
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
                    <input type="button" value="Back" onClick="top.restoreSession();window.location='<?php echo $GLOBALS['webroot'] ?>/interface/patient_file/encounter/encounter_top.php';"/>&nbsp;&nbsp;
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
        <form id="login_form" method="post" action="" style="width:166px;">
            <center>
                        <div id="login_prompt" style="font-size:small;">Enter your password to sign:</div>
                        <input type="hidden" name="sig_status" value="approved" />
                        <input type="hidden" id="tid" name="tid" value="<?php echo $id;?>"/>
                        <input type="hidden" id="table_name" name="table_name" value="<?php echo $formTable;?>"/>
                        <input type="hidden" id="signature_uid" name="signature_uid" value="<?php echo $_SESSION['authUserID'];?>"/>
                        <input type="hidden" id="signature_id" name="signature_id" value="<?php echo $sigId->getId();?>" />
                        <input type="hidden" id="exam_name" name="exam_name" value="<?php echo $registryRow['nickname'];?>" />
                        <input type="hidden" id="exam_pid" name="exam_pid" value="<?php echo $obj['pid'];?>" />
                        <input type="hidden" id="exam_date" name="exam_date" value="<?php echo $obj['date'];?>" /><br>
                        <table><tr><td><label for="login_pass" style="font-size:small;">Password:</label></td><td> <input type="password" id="login_pass" name="login_pass" size="10" /></td></tr></table><br>



                        <input type="submit" value="Sign" />

                </center>
        </form>
</div>

</body>
</html>
