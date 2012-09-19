<?php
require_once("../../globals.php");
require_once("$srcdir/sql.inc");
require_once("$srcdir/formatting.inc.php");
?>

<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
<style type="text/css">
@import "<?php echo $GLOBALS['webroot'] ?>/library/js/datatables/media/css/demo_page.css";
@import "<?php echo $GLOBALS['webroot'] ?>/library/js/datatables/media/css/demo_table.css";
.mytopdiv { float: left; margin-right: 1em; }
</style>

<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/datatables/media/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/datatables/media/js/jquery.dataTables.min.js"></script>
<!-- this is a 3rd party script -->
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/js/datatables/extras/ColReorder/media/js/ColReorderWithResize.js"></script>
<script>
$(document).ready(function() {
	select_result();
	
});
function call_datatables()
{
	$('#pdf_list').dataTable({
		"iDisplayLength": <?php echo empty($GLOBALS['gbl_pt_list_page_size']) ? '10' : $GLOBALS['gbl_pt_list_page_size']; ?>,
		// language strings are included so we can translate them
		"bSortClasses": false,
		"aaSorting": [[ 6, "desc" ]],
		"oLanguage": {
		"sSearch"      : "<?php echo xla('Search all columns'); ?>:",
		"sLengthMenu"  : "<?php echo xla('Show') . ' _MENU_ ' . xla('entries'); ?>",
		"sZeroRecords" : "<?php echo xla('No matching records found'); ?>",
		"sInfo"        : "<?php echo xla('Showing') . ' _START_ ' . xla('to{{range}}') . ' _END_ ' . xla('of') . ' _TOTAL_ ' . xla('entries'); ?>",
		"sInfoEmpty"   : "<?php echo xla('No reports found'); ?>",
		"sInfoFiltered": "(<?php echo xla('filtered from') . ' _MAX_ ' . xla('total entries'); ?>)",
		"oPaginate": {
		"sFirst"   : "<?php echo xla('First'); ?>",
		"sPrevious": "<?php echo xla('Previous'); ?>",
		"sNext"    : "<?php echo xla('Next'); ?>",
		"sLast"    : "<?php echo xla('Last'); ?>"
		}
		},
		"bDestroy": true
	});
}
function select_result()
{
	$.ajax({
	  type: "POST",
	  url: "oasis_interface_ajax.php",
	  data: {func:"Select"},
	  success:function(data)
			  {
			    $('#result_table').replaceWith(data);
				call_datatables();
			  }
	  
	});
}
function delete_record(id_pk)
{
	$.ajax({
	  type: "POST",
	  url: "oasis_interface_ajax.php",
	  data: {func:"Delete Record",id_pk:id_pk},
	  success:function(data)
			  {
				if(data=="Record Deleted")
				{
					$('#ajax_message').html(data);
					select_result();
				}
				else
				{
					$('#ajax_message').html(data);
				}
			  }
	  
	});
}
function get_b1_text(b1_string,generated_date)
{
	/*$.ajax({
	  type: "POST",
	  url: "oasis_interface_ajax.php",
	  data: {func:"Get B1 Record",b1_string:b1_string},
	  success:function(data)
			  {
				$('#ajax_message').html("Your Download has started");
			  }
	  
	});*/
	newwindow=window.open('oasis_interface_popup.php?b1_string='+b1_string+'&generated_date='+generated_date);
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
<body class="body_top formtable">
Update Information: <span id="ajax_message" style="color:blue;">None</span>
<table cellpadding="0" cellspacing="0" border="0" class="display formtable" id="pdf_list">
	<thead>
		<tr>
			<th>Patient ID</th>
			<th>User ID</th>
			<th>Form Name</th>
			<th>Encounter ID</th>
			<th>Analysis Status</th>
			<th>Analysis PDF</th>
			<th>Generated Data</th>
			<th>Operations</th>
		</tr>
	</thead>
	<tbody id="result_table">
	</tbody>
</table>
</body>