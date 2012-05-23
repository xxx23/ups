<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		{literal}
		<script type="text/javascript"><!--
		var bTool = new Boolean( false );
		var bMain = new Boolean( false );

		function main_load(){
			bMain = true;
		}

		function tool_load(){
			bTool = true;
		}

		function delay( n ){
			setTimeout( 'delay(' + n + ');', n );
		}

		function init(){
			if( bTool==true && bMain==true ){
				tools.Tool_OnLoad();
				tools.Main_OnLoad();
			}else
				setTimeout( "init()", 100 );
		}


		//changed
		//if( navigator.userAgent.search( /MSIE [56].[05]/i ) == -1 ){
		if(false){
			alert( '您使用的是 ' + navigator.userAgent + '\n本程式僅適用於 Microsoft Internet Explorer 5.x' );
		}else
			setTimeout( "init()", 100 );
		</script>
		{/literal}
	</head>

	<frameset rows="40,*">
		<frame id="tools" name="tools" scrolling="no" target="main" src="tea_correct.php?view=true&option=tool&homework_no={$homework_no}&pid={$pid}"/>
		<frame id="main" name="main" src="tea_correct.php?view=true&option=context&homework_no={$homework_no}&pid={$pid}"/>
		<noframes>
		<body>
			<p>此網頁使用框架，但是您的瀏覽器並不支援</p>
		</body>
		</noframes>
	</frameset>
</html>
