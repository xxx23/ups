<?php
	// modify record：山妙
	// 2009/09/27 新增分頁功能
	// 在課程訊息的地方新增了分頁功能。將搜尋出來的頁面以每 $show_page_rows 的筆數來做分類
	// 並且在tpl的地方以數字呈現。
	  
	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
	require_once($RELEATED_PATH . "session.php");
	require_once($RELEATED_PATH."library/common.php");
    require_once($RELEATED_PATH."library/filter.php");

	//update_status ( "編輯課程大綱" );
	//new smarty	
	$tpl = new Smarty();

    $_GET['popular_course_cd'] = required_param("popular_course_cd",PARAM_INT);
        
	//設定一頁要顯示幾筆
	$show_page_rows = 10;
	if(isset($_GET['page']))
		$page_number = $_GET['page'];
	else 
	  	$page_number = 1;
	//從第幾筆開始 然後顯示n筆資料
	$start = ($page_number-1) * $show_page_rows;

	//讀取課程編號
	$popular_course_cd = isset($_GET["popular_course_cd"]) ? $_GET["popular_course_cd"] : $_SESSION['popular_course_cd'];
	$popular_course = db_getAll("SELECT begin_course_cd,begin_course_name, d_course_begin, d_course_end,attribute FROM begin_course WHERE course_property=$popular_course_cd ORDER BY begin_course_cd DESC limit {$start},{$show_page_rows}");

	//要計算一共有幾頁 
	$sql = "select * from begin_course where course_property = {$popular_course_cd}";
	$result = mysql_query($sql);
	$total_query_rows = mysql_num_rows($result);
	
	//計算出來的rows來算出有多少頁面
	$num_pages = intval($total_query_rows / $show_page_rows) + 1;
	//建立數字的連結
	//好吧 我知道這個方法真的也不太好 囧
	$i = 0 ;
	$j = 1 ;
	while($i < $num_pages)
	{
	  	$page_index[$i]['link'] = "<a href='popular_course2_dump.php?popular_course_cd={$popular_course_cd}&page={$j}'>".$j."</a>";
		$page_index[$i]['count'] = $j;
		if(($j % 10) == 0) // 表示是整數
		  $page_index[$i]['link'] = "<a href='popular_course2_dump.php?popular_course_cd={$popular_course_cd}&page={$j}'>".$j."</a><br/>";
		$j++;
		$i++;
	}

	$tpl->assign("page_index",$page_index);

	if($popular_course == null)
	{
	  	echo "此類別無開設課程。<br/>";
		echo "<a href='./popular_course2.php'>回上頁</a>";
		exit(0);
	}
        foreach($popular_course as &$value)
        {
          $value['d_course_end'] = abs((strtotime(date("Y-m-d")) - 
            strtotime($value['d_course_begin']))/86400) < 7 
            ? "<img  src='../images/new.gif'/>" 
            : "&nbsp";
        }
        $tpl->assign('popular_course', $popular_course);
        //$tpl->assign('now', date("Y-m-d H:i:s"));
        $tpl->display("popular_course2_dump.tpl");
	//查出課程資料
/*
	$sql = "SELECT * FROM course_basic WHERE course_cd='".$cur_course_cd."'";
	$res = $DB_CONN->query($sql);
	if($res->numRows() != 0){
		$course_data = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$tpl->assign("audience", $course_data['audience']);
		$tpl->assign("prepare_course", $course_data['prepare_course']);
		$tpl->assign("mster_book", $course_data['mster_book']);
		$tpl->assign("ref_book", $course_data['ref_book']);
		$tpl->assign("ref_url", $course_data['ref_url']);
	}

	$editable = false;
	$tpl->assign("editable",$editable);

	assignTemplate($tpl, "/course/course_intro2.tpl");
 */	
//--------function area-------------
?>
