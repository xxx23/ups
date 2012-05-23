<?php
/***
FILE:   
DATE:   
AUTHOR: zqq
**/
$RELEATED_PATH = "../";
require_once($RELEATED_PATH . "config.php");
require_once($RELEATED_PATH . "session.php");
require_once($RELEATED_PATH . "library/common.php");
require_once('lib.php'); 
//update_status ( "確認開課中" );

//new smarty	
$tpl = new Smarty();


if(isset($_GET[begin_course_cd]))
	$_SESSION[begin_course_cd] = $_GET[begin_course_cd];

if($_GET['action'] == "modify"){

	// 修改課程觀看教材的時間	  
	$criteria_content_hour = $_POST['criteria_content_hour_1'].":".$_POST['criteria_content_hour_2'].":00";

	if($_POST['attribute'] == 0)
	{
		//確定要修改後，判斷是否跟原本的課程性質相同
		//如果相同，則不更改，若不相同，將修改後的課程編號 ++
		//先把這堂課原本的course_type找出來
		$or_course_type = db_getOne("SELECT course_property from begin_course where begin_course_cd = {$_POST['begin_course_cd']}");
		if($_POST['course_type'] != $or_course_type)
			get_inner_course($_POST['course_property'],1);

		//重新修改課程階段 course_stage
		//把每一個複選的stage都重新整理，用0101的方式表示。
		if(isset($_POST['course_stage_option1']))
			$check_stage1 = 1;
		else
			$check_stage1 = 0;
		if(isset($_POST['course_stage_option2']))
			$check_stage2 = 1;
		else
			$check_stage2 = 0;
		if(isset($_POST['course_stage_option3']))
			$check_stage3 = 1;
		else
			$check_stage3 = 0;
		if(isset($_POST['course_stage_option4']))
			$check_stage4 = 1;
		else
			$check_stage4 = 0;

		$course_stage_string = $check_stage1.$check_stage2.$check_stage3.$check_stage4;

		// modify by Samuel @ 2009/11/22
		// 修改承辦人電話格式 以方便傳送高師大作認証

		$director_tel = $_POST['director_tel_area']."-".$_POST['director_tel_left'];
		if($_POST['director_tel_ext'] != NULL)
			$director_tel .= "#".$_POST['director_tel_ext'];

		// end of modification @ 2009/11/22

		// 在課程修改的部份，如果是自學式的課程，並不需要輸入這麼多的欄位，只需要輸入使用者會打的欄位即可。
		// modify by Samuel @ 2009/09/26 
		$sql = "UPDATE begin_course
		  SET
		  begin_course_name='{$_POST['begin_course_name']}',
		  inner_course_cd='{$_POST['inner_course_cd']}',
		  course_property='{$_POST['course_property']}',
		  certify='{$_POST['certify']}',
		  begin_unit_cd='{$_POST['begin_unit_cd']}',
		  criteria_total='{$_POST['criteria_total']}',
		  criteria_content_hour='{$criteria_content_hour}',
		  director_name='{$_POST['director_name']}',
		  director_tel='{$director_tel}',
		  director_email='{$_POST['director_email']}',
		  course_duration='{$_POST['course_duration']}',
		  career_stage='{$_POST['career_stage']}',
		  course_stage='{$course_stage_string}',
		  guest_allowed='{$_POST['guest_allowed']}'
		  where
			begin_course_cd = {$_POST['begin_course_cd']}
			";
		
	}
	else
	{
		$sql = 
			"UPDATE begin_course 
			SET 
			begin_course_name='".$_POST[begin_course_name]."',
			inner_course_cd='".$_POST[inner_course_cd]."',
			d_course_begin='".$_POST[d_course_begin]."',
			d_course_end='".$_POST[d_course_end]."',
			d_select_begin='".$_POST[d_select_begin]."',
			d_select_end='".$_POST[d_select_end]."',
			d_public_day='".$_POST[d_public_day]."',
			course_year='".$_POST[course_year]."',
			course_session='".$_POST[course_session]."',
			coursekind='".$_POST[coursekind]."',
			charge_type='".$_POST[charge_type]."',
			subsidizeid='".$_POST[subsidizeid]."',
			locally='".$_POST[locally]."',
			subsidize_money='".$_POST[subsidize_money]."',
			course_type='0',
			take_hour='".$_POST['take_hour']."',
			certify='".$_POST['certify']."',
			is_preview='".$_POST['is_preview']."',
			quantity='".$_POST['quantity']."',
			charge='".$_POST['charge']."',
			charge_discount='".$_POST['charge_discount']."',
			class_city='".$_POST['class_city']."',
			class_place='".$_POST['class_place']."',
			criteria_total='".$_POST['criteria_total']."',
			criteria_score='".$_POST['criteria_score']."',
			criteria_score_pstg='".$_POST['criteria_score_pstg']."',
			criteria_tea_score='".$_POST['criteria_tea_score']."',
			criteria_tea_score_pstg='".$_POST['criteria_tea_score_pstg']."',
			criteria_content_hour='".$_POST['criteria_content_hour']."',
			criteria_finish_survey='".$_POST['criteria_finish_survey']."',
			attribute='".$_POST['attribute']."',
			director_name='".$_POST['director_name']."',
			director_tel='".$_POST['director_tel']."',
			director_email='".$_POST['director_email']."',
			director_fax='".$_POST['director_fax']."',
			auto_admission='".$_POST['auto_admission']."',
			note='".$_POST['note']."',
			course_property='".$_POST['course_property']."',
			article_number='".$_POST['article_number']."',
			career_stage='".$_POST['career_stage']."',
			course_stage='".$_POST['course_stage']."',
			guest_allowed='".$_POST['guest_allowed']."'
		 WHERE
			begin_course_cd='".$_POST['begin_course_cd']."'	
		 ";

	}
	
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());	
	
	//選出course_classify_cd 與 course_classify_parent
	if(isset($_POST[course_classify_4])){
		$course_classify_cd = $_POST[course_classify_4];
		$course_classify_parent = $_POST[course_classify_3];
	}
	else{
		if(isset($_POST[course_classify_3])){
			$course_classify_cd = $_POST[course_classify_3];
			$course_classify_parent = $_POST[course_classify_2];				
		}
		else{ 
			if(isset($_POST[course_classify_2])){
				$course_classify_cd = $_POST[course_classify_2];
				$course_classify_parent = $_POST[course_classify_1];							
			}
		}
	}		
	$sql = "UPDATE
			 begin_course 
			SET 
			 course_classify_cd='".$course_classify_cd."',
			 course_classify_parent='".$course_classify_parent."' 
			WHERE begin_course_cd='".$_POST['begin_course_cd']."'";

	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());
	/*訪客入侵修課*/
	$guest_pid = db_getOne("select personal_id from register_basic where login_id='guest'");
	if($_POST['attribute'] == '0')
	{
		$take_course = db_getOne("select begin_course_cd from take_course where begin_course_cd = $_POST[begin_course_cd] and personal_id = $guest_pid");
		if($guest_pid != NULL && $take_course == NULL)
			db_query("insert into take_course (begin_course_cd, personal_id, allow_course, status_student) values ($_POST[begin_course_cd], $guest_pid, '1', '0')");
	}
	else
	{
		db_query("delete from take_course where begin_course_cd = $_POST[begin_course_cd] and personal_id = $guest_pid");
	}
	echo "<span style=\"color:red\">修改成功</span><br/>";	

} // end if modfiy 
	
	
	//查出begin_course的資料
	$sql = "SELECT * FROM begin_course WHERE begin_course_cd='".$_SESSION[begin_course_cd]."'";
	$res = $DB_CONN->query($sql);
	if (PEAR::isError($res))	die($res->getMessage());	
	$advance_course = $res->fetchRow(DB_FETCHMODE_ASSOC);

	//取出認証閱讀時間 時分秒
	$criteria_content_hour = $advance_course['criteria_content_hour'];
       	$content_time = explode(":",$criteria_content_hour);
	if(isset($_POST['criteria_content_hour_1']))
	  	$tpl->assign('criteria_content_hour_1',$_POST['criteria_content_hour_1']);
	else
		$tpl->assign('criteria_content_hour_1',preg_replace('/0(.+)/i','$1',$content_time[0]));
    //edit by aeil
    //$tpl->assign('criteria_content_hour_1',$content_time[0]);
    //echo preg_replace('/0(.+)/i','$1',$content_time[0]);
	
	if(isset($_POST['criteria_content_hour_2']))
	  	$tpl->assign('criteria_content_hour_2',$_POST['criteria_content_hour_2']);
	else
		$tpl->assign('criteria_content_hour_2',$content_time[1]);	
	
	$tpl->assign('begin_course_cd', $advance_course[begin_course_cd]);
	$tpl->assign('course_cd', $advance_course[course_cd]);
	//研習名稱
	if(isset($_POST['begin_course_name']))
	  	$tpl->assign('begin_course_name',$_POST['begin_course_name']);
	else
		$tpl->assign('begin_course_name', $advance_course['begin_course_name']);
	
	//上課日期
	$tpl->assign('d_course_begin'	, date("Y-n-j", strtotime($advance_course['d_course_begin'])));
	//$tpl->assign('d_course_begin'	, $advance_course[d_course_begin]);
	$tpl->assign('d_course_end'	, date("Y-n-j", strtotime($advance_course['d_course_end'])));
	//報名日期
	$tpl->assign('d_select_begin'	, date("Y-n-j", strtotime($advance_course['d_select_begin'])));
	$tpl->assign('d_select_end'	, date("Y-n-j", strtotime($advance_course['d_select_end'])));
	//課程公開日期
	$tpl->assign('d_public_day'	, date("Y-n-j", strtotime($advance_course['d_public_day'])));
	//學期
	$tpl->assign('course_year'	, $advance_course[course_year]);
	//學年
	$tpl->assign('course_session'	, $advance_course[course_session]);
	
	if(isset($_POST['take_hour']))
		$tpl->assign('take_hour',$_POST['take_hour']);
	else
	  	$tpl->assign('take_hour',$advance_course['take_hour']);

	if(isset($_POST['certify']))
	  	$tpl->assign('certify',$_POST['certify']);
	else
		$tpl->assign('certify',$advance_course['certify']);
	
	if(isset($_POST['is_preview']))
	  	$tpl->assign('is_preview',$_POST['is_preview']);
	else
		$tpl->assign('is_preview',$advance_course['is_preview']);
	
	if(isset($_POST['quantity']))
	  	$tpl->assign('quantity',$_POST['quantity']);
	else
		$tpl->assign('quantity',$advance_course['quantity']);
    
    if(isset($_POST['guest_allowed']))
        $tpl->assign("guest_allowed",$_POST['guest_allowed']);
    else
        $tpl->assign("guest_allowed",$advance_course['guest_allowed']);    

	if(isset($_POST['charge']))
	  	$tpl->assign('charge',$_POST['charge']);
	else
		$tpl->assign('charge',$advance_course['charge']);
	
	if(isset($_POST['charge_discount']))
	  	$tpl->assign('charge_discount',$_POST['charge_discount']);
	else
		$tpl->assign('charge_discount',$advance_course['charge_discount']);
	
	if(isset($_POST['class_city']))
	  	$tpl->assign('class_city',$_POST['class_city']);
	else
		$tpl->assign('class_city',$advance_course['class_city']);
	
	if(isset($_POST['class_place']))
	  	$tpl->assign('class_place',$_POST['class_place']);
	else
		$tpl->assign('class_place',$advance_course['class_place']);
	
	if(isset($_POST['criteria_total']))
	  	$tpl->assign('criteria_total',$_POST['criteria_total']);
	else
		$tpl->assign('criteria_total',$advance_course['criteria_total']);
	
	if(isset($_POST['criteria_score']))
	  	$tpl->assign('criteria_score',$_POST['criteria_score']);
	else
		$tpl->assign('criteria_score',$advance_course['criteria_score']);
	
	if(isset($_POST['criteria_score_pstg']))
	  	$tpl->assign('criteria_score_pstg',$_POST['criteria_score_pstg']);
	else
		$tpl->assign('criteria_score_pstg',$advance_course['criteria_score_pstg']);
	
	if(isset($_POST['criteria_tea_score']))
	  	$tpl->assign('criteria_tea_score',$_POST['criteria_tea_score']);
	else
		$tpl->assign('criteria_tea_score',$advance_course['criteria_tea_score']);
	
	if(isset($_POST['criteria_tea_score_pstg']))
	  	$tpl->assign('criteria_tea_score_pstg',$_POST['criteria_tea_score_pstg']);
	else
		$tpl->assign('criteria_tea_score_pstg',$advance_course['criteria_tea_score_pstg']);
    
	//時間組合起來 @ 2009/09/04
	
	if(isset($_POST['criteria_content_hour']))
	  	$tpl->assign('criteria_content_hour',$_POST['criteria_content_hour']);
	else
		$tpl->assign('criteria_content_hour',$advance_course['criteria_content_hour']);
	
	if(isset($_POST['criteria_finish_survey']))
	 	$tpl->assign('criteria_finish_survey',$_POST['criteria_finish_survey']);
	else
		$tpl->assign('criteria_finish_survey',$advance_course['criteria_finish_survey']);
    
    if(isset($_POST['course_duration']))
        $tpl->assign('course_duration',$_POST['course_duration']);
    else
        $tpl->assign('course_duration',$advance_course['course_duration']);

	if(isset($_POST['director_name']))
	  	$tpl->assign('director_name',$_POST['director_name']);
	else
		$tpl->assign('director_name',$advance_course['director_name']);

    // 因為電話被切成三個部份，所以要重新把值丟過去 
    // 一開始先判斷是否為網頁刷新或是由資料庫抓出來的
    if(isset($_POST['director_tel_area']))
    {
        $tpl->assign("director_tel_area",$_POST['director_tel_area']);
        $tpl->assign("director_tel_left",$_POST['director_tel_left']);
        $tpl->assign("director_tel_ext",$_POST['director_tel_ext']);
    }
    else // 此時網頁還未更新，要把原本的資料切割
    {
        $director_tel = $advance_course['director_tel'];
        $director_result = split('[-,#]',$director_tel);
        //print_r($director_tel);
        if(count($director_result) == 2)
        {
          if($director_result[1] == "-")
          {  
            $director_result = str_split($director_result[0],3);
          }
          $tpl->assign("director_tel_left",$director_result[1]. 
          $director_result[2]);
        }
        else
        {
          $tpl->assign("director_tel_left",$director_result[1]);
          $tpl->assign("director_tel_ext",$director_result[2]);
        }
        $tpl->assign("director_tel_area",$director_result[0]);
        //$tpl->assign("director_tel_left",$director_result[1]. 
          //$director_result[2]);
        //$tpl->assign("director_tel_ext",$director_result[2]);
    }
    // end here

    /*    
	if(isset($_POST['director_tel']))
	  	$tpl->assign('director_tel',$_POST['director_tel']);
	else
		$tpl->assign('director_tel',$advance_course['director_tel']);
     */

	if(isset($_POST['director_email']))
	  	$tpl->assign('director_email',$_POST['director_email']);
	else
		$tpl->assign('director_email',$advance_course['director_email']);
	
	if(isset($_POST['director_fax']))
	  	$tpl->assign('director_fax',$_POST['director_fax']);
	else
		$tpl->assign('director_fax',$advance_course['director_fax']);
	
	if(isset($_POST['attribute']))
	  	$tpl->assign('attribute',$_POST['attribute']);
	else
		$tpl->assign('attribute',$advance_course['attribute']);
	
	if(isset($_POST['auto_admission']))
	  	$tpl->assign('auto_admission',$_POST['auto_admission']);
	else
		$tpl->assign('auto_admission',$advance_course['auto_admission']);
	
	if(isset($_POST['note']))
	  	$tpl->assign('note',$_POST['note']);
	else
		$tpl->assign('note',$advance_course['note']);
    
    // modify by Samuel @ 2009/09/02
    // 這個比較特別，要因為不同的選課課程類別來產生不同的課程號碼
    // 但是如果選擇過後的coure_property跟原本課程的是一樣的話 要把原本的資料紀錄下來傳過去
    if(isset($_POST['course_property']))
    {
        if($_POST['course_property'] == $advance_course['course_property'])
        {
            $tpl->assign("course_property",$_POST['course_property']);
            $tpl->assign("inner_course_cd",$advance_course['inner_course_cd']);
        }
        else
        {
            $tpl->assign('course_property',$_POST['course_property']);
            $tpl->assign("inner_course_cd",get_inner_course($_POST['course_property'],0));
        }
    }
    else
    {
        $tpl->assign('course_property',$advance_course['course_property']);
        $tpl->assign("inner_course_cd",$advance_course['inner_course_cd']);
    }
	
	if(isset($_POST['attribute']))
	  	$tpl->assign('attribute',$_POST['attribute']);
	else
		$tpl->assign('attribute',$advance_course['attribute']);

    if(isset($_POST['course_unit']))
        $tpl->assign('upper_course_type',$course_unit);

	if(isset($_POST['article_number']))
	  	$tpl->assign('article_number',$_POST['article_number']);
	else
		$tpl->assign('article_number', $advance_course['article_number']);
    
	
	
	if( isset($_POST['doc']))
		$tpl->assign('selected_doc', $_POST['doc']) ; 
	else
		$tpl->assign('selected_doc', $advance_course['applycourse_doc'] ); 
		
    // course_stage 修改 @ 2009/10/30
    // 把複選的每一個stage 切開

    if(!isset($_POST['post_state']))
    {
        $check_stage1 = $advance_course['course_stage'][0];
        $check_stage2 = $advance_course['course_stage'][1];
        $check_stage3 = $advance_course['course_stage'][2];
        $check_stage4 = $advance_course['course_stage'][3];
    }
    else
    {
        if(isset($_POST['course_stage_option1']))
            $check_stage1 = 1;
        else
            $check_stage1 = 0;
    
        if(isset($_POST['course_stage_option2']))
            $check_stage2 = 1;
        else    
            $check_stage2 = 0;

        if(isset($_POST['course_stage_option3']))
            $check_stage3 = 1;
        else
            $check_stage3 = 0;

        if(isset($_POST['course_stage_option4']))
            $check_stage4 = 1;
        else
            $check_stage4 = 0;
    }
    
    $tpl->assign("check_stage1",$check_stage1);
    $tpl->assign("check_stage2",$check_stage2);
    $tpl->assign("check_stage3",$check_stage3);
    $tpl->assign("check_stage4",$check_stage4);

    // end modification here @ 2009/10/30

    if(isset($_POST['career_stage']))
	  	$tpl->assign('career_stage',$_POST['career_stage']);
	else
		$tpl->assign('career_stage',$advance_course['career_stage']);

	if(isset($_POST['deliver']))
	  $tpl->assign('deliver',$_POST['deliver']);
	else
	  $tpl->assign('deliver',$advance_course['deliver']);

	//查詢開課單位 modify by Samuel 09/06/05
	// modify by Samuel again => 更改course_unit的顯示方式
	$sql = "SELECT * from lrtunit_basic_ WHERE department = -1 ORDER BY unit_cd";
	$total_course_unit = db_getAll($sql);
	$sql = "SELECT * from lrtunit_basic_ WHERE unit_cd = {$advance_course['begin_unit_cd']}";

	$subunit = db_getRow($sql);

    $upper_course_type = $subunit['department'];
    
    if(isset($_POST['course_unit'])) 
	{
	  	// 如果目前的 課程類別 與 資料庫是相同的話
        $sql = "SELECT * FROM lrtunit_basic_ WHERE department = {$_POST['course_unit']} ORDER BY unit_cd";
        $total_course_subunit = db_getAll($sql);
        $upper_course_type = $_POST['course_unit'];
	}
	else
	{	
	  	// 目前的課程類別 與資料庫的課程類別不同 所以要把其它類別的子類別挖出來
	  	$sql = "SELECT * FROM lrtunit_basic_ WHERE department = {$subunit['department']} ORDER BY unit_cd";
        $total_course_subunit = db_getAll($sql);
        $begin_unit_cd = $advance_course['begin_unit_cd'];
    }
    
    $tpl->assign("upper_course_type",$upper_course_type);
    $tpl->assign("begin_unit_cd",$begin_unit_cd);
	$tpl->assign('total_course_unit',$total_course_unit);
	$tpl->assign('total_course_subunit',$total_course_subunit);
	// end @ 2009/10/07

	//查詢所有的開課類別 modify by Samuel @ 2009/09/02
	$sql = "SELECT * FROM course_property";
	$total_course_property = db_getAll($sql);
	$tpl->assign("total_course_property",$total_course_property);
	
	//確認 開課身份是DOC輔導團 則新增一個欄位為 是為那個doc開的課
	if( $_SESSION['category'] ==  '3') {
	
		$account = db_getOne("SELECT account FROM register_applycourse WHERE no={$_SESSION['no']}") ;  
		$citys = $doc_instructor[ $account ]; //這個輔導團 管哪一些縣市
		$get_docs = " SELECT doc_cd , doc FROM docs " . join_city_where($citys) ; 
		$docs = db_getAll( $get_docs );
		$doc_options[-1] = "無" ;
		foreach( $docs as $v){
			$doc_options[ $v['doc_cd'] ] = $v['doc'] ;
		}
		
		$tpl->assign("doc_options", $doc_options);
		$tpl->assign("is_doc_instructor", true);	
	}	
	
	
	//輸出頁面
	assignTemplate($tpl, "/apply_course/view_course.tpl");	


    //-----function area-------
    function get_inner_course($property_number,$sql_type)
    {
        //找出該類別下目前課程的最大值
        $sql = "select max(course_number) as course_maxi
            FROM generate_inner_course_cd
            WHERE property_type = {$property_number}";

         
        if( db_getOne($sql) == NULL) //表示該屬性還沒有開過課程
            $max_course_number = 1 ;
        else{
            $max_course_number = db_getOne($sql); // 下一筆資料的課程號碼
            $max_course_number ++ ;
        }
        
        //判斷開設課程之後的課程編號是多少
    
        $property=$property_number + 1 ;
        if($max_course_number < 10)
            $inner_course_cd_1 = "010".$property."000".$max_course_number;
        elseif($max_course_number >= 10 && $max_course_number < 100) // 10~99
            $inner_course_cd_1 = "010".$property."00".$max_course_number;
        elseif($max_course_number >= 100 && $max_course_number < 1000) // 100~999
            $inner_course_cd_1 = "010".$property."0".$max_course_number;
        else // 大於1000 有四個數字
            $inner_course_cd_1 = "010".$property."".$max_course_number;

        if($sql_type == 0)
            return $inner_course_cd_1;
        elseif($sql_type == 1)
        {
            if($max_course_number == 1) //表示都還沒有開過課程，把這筆新的資料 再寫回這個資料表
            {
                    $sql = "INSERT INTO generate_inner_course_cd
                              (
                              course_type,
                              property_type,
                              course_number
                               ) VALUES
                               (
                               '1',
                               '{$property_number}',
                               '{$max_course_number}'
                               )";
                    db_query($sql);
            }
            else // 即表示那個屬性 原本已經就有課程了 直接更新成最大值就好了
            {
                    $sql = "UPDATE generate_inner_course_cd
                            SET course_number ='{$max_course_number}'
                            WHERE property_type = {$property_number}";
                    db_query($sql);
            }
        }
    }
	
function join_city_where($citys){
	if( empty( $citys) )
		return '';
	$sql = " WHERE " ; 
	$f_first = true ;
	foreach($citys as $k) {
		if(!$f_first) {
			$sql .=" OR " ;
		}
		$sql .= " city_cd=$k ";
		$f_first = false ;
	}	
	return $sql ; 
}
	

// 不想再寫這又臭又長的php 網頁code了 =____= 
	
?>	