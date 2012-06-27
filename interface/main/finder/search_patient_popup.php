<html>
<head>
<link rel="stylesheet" href="<?php echo $rootdir;?>/themes/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo $rootdir;?>/themes/style_oemr.css" type="text/css">
<link rel="stylesheet" href="/openemr/interface/themes/style_oemr.css" type="text/css">
<script src="../../../library/js/jquery-1.6.4.min.js"></script>


<script>


		function open_demography(p_id)
		{
		opener.parent.RTop.location.href='../../patient_file/summary/demographics.php?set_pid='+p_id;
		window.close();
				return false;
		}
		function showResult(term)
{

var winheight;
if (term.length<3)
  { 
  document.getElementById("search_result").innerHTML="";
  document.getElementById("search_result").style.border="0px";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("search_result").innerHTML=xmlhttp.responseText;
	winheight=document.getElementById("search_result").offsetHeight;
	//alert(winheight);
	winwidth=0;
	winheight=winheight-100;
	window.resizeTo(600,200);
	window.resizeBy(winwidth,winheight);
    }
  }
xmlhttp.open("GET","../../../library/ajax/search_patient.php?term="+term,true);
xmlhttp.send();

}

</script>
</head>
<body class="body_top">
<center>
	<table>
		<tr>
			<td class="text" width="110px">Patient Search:</td>
			<td width="410px"><input type="text" id="searchbox" style="width:385px;" onkeyup="showResult(this.value);"></td>
		</tr>
		<tr>
			<td colspan="2"><div id="search_result" style="width:500px;"></div></td>
		</tr>
	</table>
</center>
</body>
</html>
