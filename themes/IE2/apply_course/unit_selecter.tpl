
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
<title>選擇單位</title>
  <script src="../script/jquery-1.3.2.min.js"></script>
  <link rel="stylesheet" href="../css/screen.css" type="text/css" />
  <link rel="stylesheet" href="../css/jquery.treeview.css" type="text/css" />
  <script type="text/javascript" src="../script/jquery.treeview.js"></script>
  <script>
 <!--
{literal}

$(document).ready(function(){
    $("#example").treeview();
  });
   function transferToOpener(id,val,cd)
  {
	window.opener.document.getElementById(id).value =val;
	if(window.opener.document.getElementById("begin_unit_cd"))
		window.opener.document.getElementById("begin_unit_cd").value = cd;
	if(window.opener.document.getElementById("department"))
		window.opener.document.getElementById("department").value = cd;
	window.close();	
  }
{/literal}  
-->
  </script>

</head> 
<body>
{$content}
</body>
</html>
