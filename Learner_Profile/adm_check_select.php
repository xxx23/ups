<?php
/***
FILE:
DATE:
AUTHOR: zqq
**/

	$RELEATED_PATH = "../";
	require_once($RELEATED_PATH . "config.php");
    require_once($RELEATED_PATH . "session.php");
    require_once($RELEATED_PATH . "library/Pager.class.php");
    require_once($RELEATED_PATH . "library/filter.php");
	checkAdminAcademic();
	update_status ( "觀看選課名單" );

	//new smarty
	$tpl = new Smarty();


	if(array_key_exists('action', $_GET) && $_GET['action'] == 'output'){
		$tpl->assign("file",1);
		$data = $_POST;
		$path = $COURSE_FILE_PATH;
		$_SESSION['current_path'] = $path;
		for($i=0; $i < sizeof( $data['check'] ); $i++){
			$begin_course_cd = $data['check'][$i];
			$file_n = "s_" . $begin_course_cd .".xls";
			$file_name = $path . $file_n;
			
        //如果檔案存在，就先刪除
        if(file_exists($file_name))	unlink($file_name);
        //開啟檔案
        $fp = fopen($file_name, "w");
			//head iconv("UTF-8","big5",$course['begin_course_name']).
			$head = 	"姓名\t".
						"暱稱\t".
						"身份證字號\t".
						"性別\t".
						"聯絡電話\t".
						"電子信箱\t".
						"郵遞區號\t".
						"通訊住址\t".
						"有興趣的的課程\t".
						"是否接收最新消息\n";

			fwrite($fp,	iconv("UTF-8","big5",$head));

			//列出修課學生
			$sql = "SELECT
						*
					FROM
						take_course t, personal_basic p
					WHERE
						begin_course_cd='".$begin_course_cd."'  and t.personal_id=p.personal_id";

			$res = $DB_CONN->query($sql);
			while( $row = $res->fetchRow(DB_FETCHMODE_ASSOC)){
				//($row['allow_course']==0)?$row['allow']='不核准':$row['allow']='核准'; 
                $row =  fill_empty($row);
                
                $tmp_data =	"{$row['personal_name']}\t".
							"{$row['nickname']}\t".
							"{$row['identify_id']}\t".
							"{$row['sex']}\t".
							"{$row['tel']}\t".
							"{$row['email']}\t".
							"{$row['zone_cd']}\t".
							"{$row['addr']}\t".
							"{$row['interest']}\t".
							"{$row['recnews']}\n".

              fwrite($fp,iconv("UTF-8","big5",$tmp_data));

			}
			fclose($fp);
			$sql = "SELECT * FROM begin_course WHERE begin_course_cd='".$begin_course_cd."'";
			//echo $sql;
			$res = $DB_CONN->query($sql);
			$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
			$row["file"] = "<a href=../library/redirect_file.php?file_name=".$file_n.">檔案下載<a>";
			$tpl->append('output_data', $row);

		}
    }

	$sql =
		"SELECT count(*)
		 FROM
			begin_course bc, lrtunit_basic_ u
		 WHERE
            bc.begin_unit_cd=u.unit_cd  ORDER BY bc.course_type ASC ";
    $total = db_getOne($sql);

    //pager
    $page = optional_param("page",1,PARAM_INT);
    $meta = array("page"=>$page,"per_page"=>15,"data_cnt"=>$total);
    $pager = new Pager($meta);
    $pagerOpt = $pager->getSmartyHtmlOptions();
 
    //查出所有的課程
	$sql =
		"SELECT
			DISTINCT bc.begin_course_cd, bc.begin_course_name, bc.inner_course_cd, u.unit_name, bc.course_type
		FROM
			begin_course bc, lrtunit_basic_ u
		WHERE
			bc.begin_unit_cd=u.unit_cd  ORDER BY bc.course_type ASC {$pager->getSqlLimit()}";

	$result = $DB_CONN->query($sql);
	$num = 0;
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		//查出授課教師
		$sql = "SELECT p.personal_name FROM teach_begin_course tc, personal_basic p WHERE  tc.begin_course_cd='".$row['begin_course_cd']."' and tc.teacher_cd=p.personal_id";
		$res_tch = $DB_CONN->query($sql);
		if($res_tch->numRows()){//有教師
			$row['personal_name'] = '';
			while($tmp_row = $res_tch->fetchRow(DB_FETCHMODE_ASSOC)){
				$row['personal_name'] .= $tmp_row['personal_name']."<br>";
			}
		}
		else{// 沒教師
			$row['personal_name'] = "<font color=red>教師未定</font>";
		}
		//是否為在職進修
		if($row['course_type'] == '1'){
			$row['begin_course_name'] = "<span class=imp>*".$row['begin_course_name']."</span>" ;
		}


		//查出修課 選課
		$sql = "SELECT count(*) as all_num FROM take_course WHERE begin_course_cd='".$row['begin_course_cd']."'";
		$row['all_num'] = $DB_CONN->getOne($sql);
		$sql = "SELECT count(*) as ok_num FROM take_course WHERE begin_course_cd='".$row['begin_course_cd']."' and allow_course=1";
		$row['ok_num'] =$DB_CONN->getOne($sql);
		$row['num'] = $num++;

		$tpl->append('course_data', $row);
	}

        $tpl->assign("page_ids",$pagerOpt['page_ids']);
        $tpl->assign("page_names",$pagerOpt['page_names']);
        $tpl->assign("page_sel",$pagerOpt['page_sel']);
        $tpl->assign("page_cnt",$pager->getPageCnt());
        $tpl->assign("previous_page",$pager->previousPage());
        $tpl->assign("next_page",$pager->nextPage());
	//輸出頁面
	assignTemplate($tpl, "/learner_profile/adm_check_select.tpl");

	//----------------function area ------------------


        function fill_empty($row){
        
                //姓名
                if(trim($row['personal_name']) == "" )
                   $row['personal_name'] = "N/A";
                //暱稱
                if(trim($row['nickname']) == "" )
                   $row['nickname'] = "N/A";
                //身分證
                if(trim($row['identify_id']) == "" )
                   $row['identify_id'] = "N/A";
                //性別
                if(trim($row['sex']) == 0 )
                    $row['sex'] = "女";
                else
                    $row['sex'] = "男";
                //電話
                if(trim($row['tel']) == "" )
                    $row['tel'] = "N/A";
                //郵遞區號 
                if(trim($row['zone_cd']) == "" )
                    $row['zone_cd'] = "N/A"; 
                //地址 
                if(trim($row['addr']) == "" )
                    $row['addr'] = "N/A";
                //email
                if(trim($row['email']) == "" )
                    $row['email'] = "N/A";
                //興趣
                if(trim($row['interest']) == "" )
                    $row['interest'] = "N/A";
                else{
                    $interest = split(",",$row['interest']);
                    for($i = 0 ; $i < count($interest);  $i++){
                         if ($interest[$i] == 0)
                             $str += "電腦入門課程,";                    
                         elseif ($interest[$i] == 1)
                             $str += "資訊技能課程,";
                         elseif ($interest[$i] == 2)
                             $str += "資訊融入教學課程,";
                         elseif ($interest[$i] == 3)
                             $str += "資訊倫理課程,";
                         elseif ($interest[$i] == 4)
                             $str += "資訊安全課程,";
                         else 
                             $str += "{$interest[$i]},";
                    }
                
                }
                //是否接受最新消息
                if(trim($row['recnews']) == "1" )
                    $row['recnews'] = "是";
                else
                    $row['recnews'] = "否";
        
           return $row;      
        }


?>
