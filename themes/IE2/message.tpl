<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />


{literal}
<style type="text/css">
li.tabA	{cursor:pointer;}
</style>


<script type="text/JavaScript">

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function display(option){
	document.getElementById("inner_contentA").style.display="none";

	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	else{
		//document.getElementById("inner_contentB").style.width = "0%";
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	//alert(option);
	}
}


</script>



{/literal}

</head>

<body id="tabA">

<div id="content">
	<div class="area2_title" id="news_title">{$title}</div>
	
		<ul id="tabnav">
		<li class="tabA" onClick="display(1)">{$title}</li>

		</ul>

		<div class="area2" id="news">
			<div class="inner_contentA" id="inner_contentA">
				<font color="red">{$content}</font>
			</div>
		</div>
	</div>
</div>

</body>
</html>
