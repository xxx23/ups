<?php /* Smarty version 2.6.14, created on 2012-05-28 20:44:29
         compiled from index_news.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'index_news.tpl', 24, false),array('modifier', 'escape', 'index_news.tpl', 25, false),)), $this); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>最新消息</title>
<link href="css/table.css" rel="stylesheet" type="text/css" />
<link href="css/index_news.css" rel="stylesheet" type="text/css" />
<link href="themes/IE2/css/content.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jquery.tip.css" />       

<!-- edit by aeil --> 
<script type='text/javascript' src='script/jquery-1.2.6.pack.js'></script> 
<script src="script/jquery.tip.js" type="text/javascript"></script>   
<!-- END  --> 

</head>

<body backgournd="#FFF">
  <h1>最新消息</h1>
<div class="datatableContainer">

<table class="datatable" >
<tr><th width="20%">公告日期</th><th width="80%">公告標題</th></tr>
<?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['news_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['news_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['news_item']):
        $this->_foreach['news_loop']['iteration']++;
?>
<tr class="<?php echo smarty_function_cycle(array('values' => ",tr2"), $this);?>
">
	<td><span class="jTip" jtip_w="400" jtip="<?php echo ((is_array($_tmp=$this->_tpl_vars['news_item']['content'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"  
		name="<?php echo $this->_tpl_vars['news_item']['date']; ?>
-<?php echo ((is_array($_tmp=$this->_tpl_vars['news_item']['subject'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" 
		id="<?php echo ($this->_foreach['news_loop']['iteration']-1); ?>
"><a><?php echo $this->_tpl_vars['news_item']['date']; ?>
</a>
	</span>	
	</td>
	<td>		<?php echo ((is_array($_tmp=$this->_tpl_vars['news_item']['subject'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

	</td>
</tr>
	<?php endforeach; else: ?>
<tr colspan="2">	
	<td><div style="text-align:center">目前沒有公告</div></td>
</tr>
	<?php endif; unset($_from); ?>
</table>
<p></p>
<div class="describe">欲觀看有對外公開之課程內容，請按左上方訪客進入。</div>

<h1>修課使用說明</h1>
<a href="<?php echo $this->_tpl_vars['tpl_path']; ?>
/manual/20101110take_course.pdf" target="_blank"><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/download_take_course.gif" /></a>
<div class="describe">為保障您的權益使時數正確記錄，修課前請詳閱修課使用說明。</div>

</div>


</body>
</html>