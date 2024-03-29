<html>
<head>
<title>教材下載</title>
<meta http-equiv="Content-Type" content="text/html;">
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

{literal}
<script type="text/javascript">
  function notAgree(){
     alert('您必須完成閱讀並且同意條款內容，才可下載教材');
   }
</script>
{/literal}


</head>

<body bgcolor="#ffffff">
<h1>教材下載</h1>
<div class="describe">請詳閱以下教材下載規範，同意遵守後，方可下載。</div>
<table width="669" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td><img src="../images/registration/spacer.gif" width="6" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="23" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="607" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="7" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="22" height="1" border="0" alt=""></td>
   <td><img src="../images/registration/spacer.gif" width="4" height="1" border="0" alt=""></td>
  </tr>

  <tr>
   <td colspan="6"><img name="n001_r1_c1" src="../images/registration/001_r1_c1.jpg" width="669" height="5" border="0" alt=""></td>
  </tr>
  <tr>
   <td><img name="n001_r2_c1" src="../images/registration/001_r2_c1.jpg" width="6" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c2" src="../images/registration/001_r2_c2.jpg" width="23" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c3" src="../images/registration/001_r2_c3_2.jpg" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c4" src="../images/registration/001_r2_c4.jpg" width="7" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c5" src="../images/registration/001_r2_c5.jpg" width="22" height="36" border="0" alt=""></td>
   <td><img name="n001_r2_c6" src="../images/registration/001_r2_c6.jpg" width="4" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td><img name="n001_r3_c1" src="../images/registration/001_r3_c1.jpg" width="6" height="7" border="0" alt=""></td>
   <td rowspan="2" background="../images/registration/001_r3_c2.jpg">&nbsp;</td>
   
   <td colspan="2" rowspan="2"><center>
	   <b></b></center>
	   <div align="center">
		  <form  action="share_output.php?content_cd={$content_cd}&d_type={$d_type}" method="post">

          <table border=0>
			 <tr>
				<td colspan="2">下載教材：<span class="imp">{$contentName}</span><br>授權型態：{$licenseName}
				<hr style="border:1px dashed red; height:1px"> </td>
			   </tr>	
			 {if $license eq 1}
				 <tr>
					<td align="center">版權聲明</td>
					<td align="center"><textarea cols="55" rows="17" readonly="readOnly">{$announce}</textarea></td>
				 </tr>	
				 <tr>
					<td align="center">排除條款</td>
					<td align="center"><textarea cols="55" rows="17" readonly="readOnly">{$rule}</textarea>
					</td>
				 </tr>	
				 <tr>
					<td colspan="2">
						<hr style="border:1px dashed red; height:1px"> <br>
						<input type="submit" class="btn" value="接受" size="30">
						<input type="button" class="btn" value="不接受" onClick="notAgree();">
					</td>
				</tr>

			 {elseif $license eq 9}
                <tr>
                 <td colspan="2"><img src="{$webroot}images/edu_announce.png" border="1" /></td>
                </tr>
                 <tr>
                    <td colspan="2">
                        <hr style="border:1px dashed red; height:1px"> <br>
                        <input type="submit" class="btn" value="接受" size="30">
                        <input type="button" class="btn" value="不接受" onClick="notAgree();">
                    </td>
                </tr>

			 {else}
                <tr>
                     <td colspan="2">觀看條款內容：&nbsp;{$licenseLink}</td>
				</tr>
				<tr>
					<td colspan="2">
						<hr style="border:1px dashed red; height:1px"> <br>
						<input class="btn" type="submit" value="完成觀看並接受" size="30">
						<input type="button" class="btn" value="還沒觀看" onClick="notAgree();">
					</td>
				</tr>

			 {/if}

		  </table>
                <input type="hidden" name="content_cd" value={$content_cd}>
                <input type="hidden" name="d_type" value={$d_type}>
          </form>
		</div> 
	</td>
   <td colspan="2" rowspan="2" background="../images/registration/001_r3_c5.jpg"><img name="n001_r3_c6" src="../images/registration/001_r3_c6.jpg" width="4" height="7" border="0" alt=""></td>
  </tr>
  
  <tr>
   <td rowspan="3">&nbsp;</td>
  </tr>
  
  <tr>
   <td><img name="n001_r5_c2" src="../images/registration/001_r5_c2.jpg" width="23" height="21" border="0" alt=""></td>
   <td colspan="2" background="../images/registration/001_r5_c4.jpg"><img name="n001_r5_c4" src="../images/registration/001_r5_c4.jpg" width="7" height="21" border="0" alt=""></td>
   <td><img name="n001_r5_c5" src="../images/registration/001_r5_c5.jpg" width="22" height="21" border="0" alt=""></td>
   <td><img name="n001_r5_c6" src="../images/registration/001_r5_c6.jpg" width="4" height="21" border="0" alt=""></td>
  </tr>
  
  <tr>
   <td colspan="5">&nbsp;</td>
  </tr>
  
</table>

</body>
</html>
