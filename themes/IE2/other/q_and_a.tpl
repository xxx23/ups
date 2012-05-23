<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../themes/IE2/css/content.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="../css/jquery/jquery-ui-1.7.2.custom_1.css" rel="stylesheet" />
<script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../script/jquery-ui-1.7.2.custom.min.js"></script>
        
<script type="text/javascript">
{literal}
      $(document).ready(function(){
            $("#accordion").accordion();
            $("#test").accordion();  
     });
{/literal}
</script>


<title>Q and A</title>
</head>
<body>
<h1>常見問題</h1>

<div id="accordion">
    {foreach item=QA_data from=$QA_datas}
    <h3><a href = "#"><img src="../images/144.gif" width="23" height="23" border="0" />[Question] {$QA_data.question}</a></h3>
    <div><p>[Answer] {$QA_data.answer}</p></div>     
    {/foreach}
</div>
</body>
</html>
