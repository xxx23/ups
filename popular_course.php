<?php

/*
 * author：Samuel
 * Add date：2009/08/15
 * 程式目的：用來show出目前的平台最熱門的10門課程
 *
 * modify by Samuel @ 2009/10/01
 * 新增在會員的部份 有選課的功能 
 *
 * modify by carlcarl @ 2011/12/09
 * 拿掉多餘的程式, 所有課程加上抓日期範圍
*/
	
	include_once("config.php");
	include_once("library/common.php");
	include_once("session.php");	
	$tpl = new Smarty();

	// 要show出幾門熱門的課程
	$role_cd = $_SESSION['role_cd'];	
    $personal_id = $_SESSION['personal_id'];
    $show_course = 10 ;
    $three_month_ago = date("Y-m-d",time()-3600*24*30*3);
    $tpl->assign("role_cd", $role_cd);


    // modify by Samuel @2009/09/30
    // 要計算出每一個身份別的熱門課程
    // 目前現階段 有 一般民眾、國民中小學課程、高中職課程與大專院校課程

    //先處理訪客和其他角色的熱門課程
    if($role_cd != 4 && $role_cd != 3)
    {
        $sql = "SELECT t.begin_course_cd, count(*) as people_number, bc.begin_course_name,bc.course_cd
            FROM take_course t , begin_course bc
            WHERE t.begin_course_cd = bc.begin_course_cd
            AND t.allow_course = 1
            AND (t.course_begin > '{$three_month_ago}' or t.course_begin IS NULL)
            GROUP BY begin_course_cd
            ORDER BY count(*) DESC limit 0,{$show_course}";
    }
    else if($role_cd != 3)
    {
        // modify by Samuel @2009/11/01 .把bc.guest_allowed加上，不另外對課程做設限
        // 因為要讓使用者去觀看選課需知，但有些選課需知教師並沒有設定。所以只要看course_cd有沒有設定起來就行了。
        // 因此，把bc.course_cd撈出來看。如果有值就顯示選課需知，如果是null，就跳彈跳視窗
        $sql = "select t.begin_course_cd, count(*) as people_number, bc.begin_course_name,bc.guest_allowed,bc.course_cd
            FROM take_course t, begin_course bc
            WHERE t.begin_course_cd = bc.begin_course_cd
            AND t.allow_course = 1
            AND (t.course_begin > '{$three_month_ago}' or t.course_begin IS NULL)
            GROUP BY begin_course_cd
            ORDER BY count(*) DESC limit 0,{$show_course}";
    }
    if($role_cd  != 3)
    {
        $total_hot_course = db_getAll($sql);
        $tpl->assign("popular_course",$total_hot_course);
    }

    //處理學員全部和其他角色的其他種課程
    if($role_cd == 3) // 會員功能
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == "select")
            { 
                    if(isset($_GET['begin_course_cd']))
                        $selection_ok = check_selection($_GET['begin_course_cd']);
                    if($selection_ok == 1)
                    {
                        take_selection($_GET['begin_course_cd'],$personal_id,1);
                        $tpl->assign("select_success",1);
                    }
                    elseif($selection_ok == -1)
                        take_selection($_GET['begin_course_cd'],$personal_id,0);
                    else
                        echo "<div align=\"center\"><font color=\"red\">您不能選擇該課程</font></div><br/>";
            }
        }

        $normal_course = get_popular_course_select(0,$show_course,$personal_id);
        $elementary_course = get_popular_course_select(1,$show_course,$personal_id);
        $high_course = get_popular_course_select(2,$show_course,$personal_id);
        $college_course = get_popular_course_select(3,$show_course,$personal_id);
        $hot_course = get_popular_course_select(-1,$show_course,$personal_id);
        
        $tpl->assign("popular_course",$hot_course);
        $tpl->assign("normal_course",$normal_course);
        $tpl->assign("elementary_course",$elementary_course);
        $tpl->assign("high_course",$high_course);
        $tpl->assign("college_course",$college_course);
    }
    elseif( $role_cd != 4)
    {
        $normal_course = get_popular_course(0,$show_course);
        $elementary_course = get_popular_course(1,$show_course);
        $high_course = get_popular_course(2,$show_course);
        $college_course = get_popular_course(3,$show_course);
    
        $tpl->assign("normal_course",$normal_course);
        $tpl->assign("elementary_course",$elementary_course);
        $tpl->assign("high_course",$high_course);
        $tpl->assign("college_course",$college_course);
    }
    else
    {
        $normal_course = get_popular_course_guest(0,$show_course);
        $elementary_course = get_popular_course_guest(1,$show_course);
        $high_course = get_popular_course_guest(2,$show_course);
        $college_course = get_popular_course_guest(3,$show_course);

        $tpl->assign("normal_course",$normal_course);
        $tpl->assign("elementary_course",$elementary_course);
        $tpl->assign("high_course",$high_course);
        $tpl->assign("college_course",$college_course);
    }

    $tpl->display("popular_course.tpl");
    
    function get_popular_course($type,$limit)
    {
        $today_3_month_ago = date("Y-m-d",time()-3600*24*30*3);
        $sql = "select count(*) as people_number , 
            BC.begin_course_cd, 
            BC.begin_unit_cd , 
            BC.begin_course_name,
            BC.course_cd
            from begin_course BC, take_course TC, lrtunit_basic_ LB
            where BC.begin_unit_cd = LB.unit_cd
                    and LB.department={$type} 
                    and BC.begin_course_cd = TC.begin_course_cd
                    and TC.allow_course = 1
                    and (TC.course_begin > '{$today_3_month_ago}' or TC.course_begin IS NULL)
            Group BY BC.begin_course_cd 
            ORDER BY people_number DESC limit 0,{$limit}";
        return db_getAll($sql);
    }

    function get_popular_course_guest($type,$limit)
    {
        // modify by Samuel @ 2009/11/01 
        // 因為訪客功能，仍然要看到不被允許觀看教材的課程，所以要把一行程式碼去掉
        // 另外，再把guest_allowed撈出來。
        
        $today_3_month_ago = date("Y-m-d",time()-3600*24*30*3);
        $sql = "select count(*) as people_number , 
            BC.begin_course_cd, 
            BC.begin_unit_cd , 
            BC.begin_course_name, 
            BC.guest_allowed, 
            BC.course_cd
             from begin_course BC, take_course TC, lrtunit_basic_ LB
            where BC.begin_unit_cd = LB.unit_cd
                     and LB.department={$type} 
                     and BC.begin_course_cd = TC.begin_course_cd
                     and (TC.course_begin > '{$today_3_month_ago}' or TC.course_begin IS NULL)
             Group BY BC.begin_course_cd
             ORDER BY people_number DESC limit 0,{$limit}";
         
         return db_getAll($sql);
    }

    function get_popular_course_select($type,$limit,$personal_id)
    {
        $today_3_month_ago = date("Y-m-d",time()-3600*24*30*3);
        $today= date("Y-m-d");
        //aeil modify @110119 增加BC.d_select_end > '{$today}'判斷是否超過選課期限
        //這個function是因為會員在熱門課程需要加上選課的功能
        //所以必須增加那名使用者的personal_id來判斷 使用者是否已經修過那堂課或是還沒有修過 新增選課連結
        if($type == -1){
        $sql = "SELECT t.begin_course_cd, count(*) as people_number, bc.begin_course_name, bc.course_cd
                FROM take_course t , begin_course bc
                WHERE t.begin_course_cd = bc.begin_course_cd
                AND t.allow_course = 1
                AND (t.course_begin > '{$today_3_month_ago}' or t.course_begin IS NULL)
                AND bc.d_select_end > '{$today}'
                GROUP BY begin_course_cd
                ORDER BY people_number DESC limit 0,{$limit}";
        }
        else
        {
            $sql = "select count(*) as people_number , BC.begin_course_cd, BC.begin_unit_cd , BC.begin_course_name, BC.course_cd
                from begin_course BC, take_course TC, lrtunit_basic_ LB
                     where BC.begin_unit_cd = LB.unit_cd
                        and LB.department={$type} 
                        and BC.begin_course_cd = TC.begin_course_cd
                        and TC.allow_course = 1
                        and (TC.course_begin > '{$today_3_month_ago}' or TC.course_begin IS NULL)
                        and BC.d_select_end > '{$today}'
                        Group BY BC.begin_course_cd
                        ORDER BY people_number DESC limit 0,{$limit}";

        }
        $popular_course_select = db_getAll($sql);
        
        $i = 0 ;
        $temp = count($popular_course_select);
        while( $i < $temp)
        {
            $begin_course_cd = $popular_course_select[$i]['begin_course_cd'];

            //只會用到pass作確認
            $sql = "SELECT pass from take_course 
                WHERE begin_course_cd = {$begin_course_cd}
                AND personal_id = {$personal_id}";
            $result = db_getOne($sql);
            
            //用來判斷選課的日期是否有超過，做法是先把資料庫裡的課程資料撈出來，看課程的選課期間為何
            $sql_1 = "SELECT d_select_begin, d_select_end FROM begin_course WHERE begin_course_cd = {$begin_course_cd}";
            $result_1 = db_getRow($sql_1);
            $choose_course_begin = explode(" ",$result_1['d_select_begin']);
            
            $choose_course_end = explode(" ",$result_1['d_select_end']);
            $d_select_begin = $choose_course_begin[0];
            $d_select_end = $choose_course_end[0];
            
            $today = date("Y-m-d");

            if(strtotime($today) - strtotime($d_select_begin) >= 0 && 
                strtotime($d_select_end) - strtotime($today) >=0)
                $select_day_ok = 1;
            else
                $select_day_ok = 0;
            
            if($select_day_ok == 1)
            {
                if($result == NULL)
                    $popular_course_select[$i]['select'] = "<a href='./popular_course.php?action=select&begin_course_cd={$popular_course_select[$i]['begin_course_cd']}' onclick=\"return confirm('您確認選擇此熱門課程?');\">選課</a>";
                elseif($result['pass'] == 1) //表示已經過通課程了
                {
                    $popular_course_select[$i]['select'] = "<a href='./popular_course.php' onclick=\"alert('您已通過此課程');\">選課</a>";
                }
                else
                    $popular_course_select[$i]['select'] = "<a href='./popular_course.php' onclick=\"alert('此課程已經存在我的課程中');\">選課</a>"; 
            }
            elseif($select_day_ok == 0)
            {
                $popular_course_select[$i]['select'] = "<a href='./popular_course.php' onclick=\"alert('此課程選課時間已過');\">選課</a>";
            }
            
            $i++;
        }
        return $popular_course_select ; 
    }

    function check_selection($begin_course_cd)
    {
            //可以選課必須該門課程是自學式或是自動審查為1 要去begin_course裡面看課程屬性
            //如果是自學式的課程，直接return 1，但是如果是教導式的課程的話，要判斷選課的日期是幾號，與今天的日期比較
            //如果日期是超過選課期限的話，即不能選課。要return 0;如果時間可以選課的話，要看autoadmission是否有被填過
            //如果auto adminssion是1的話，還是可以直接審核，但是如果autoadmission是0的話，教師還是需要審核才行
            $sql = "SELECT auto_admission, attribute , d_select_begin, d_select_end
                FROM begin_course 
                WHERE begin_course_cd = {$begin_course_cd}";

            $result = db_getRow($sql);
            if($result['attribute'] == 0) //自學式的話 即return 1
                return 1;
            elseif( $result['attribute'] == 1)
            {
                $today = date("Y-m-d");
                $choose_select_begin = explode(" ",$result['d_select_begin']);
                $choose_select_end = explode(" ",$result['d_select_end']);

                $d_select_begin = $choose_select_begin[0];
                $d_select_end = $choose_select_end[0];
                //判斷目前的日期是否為選課期間
                //可使用strcmp(string1,string2)來做比較，如果是負數，表示string1 < string2
                $a = strcmp($d_select_begin,$today);
                $b = strcmp($today,$d_select_end);

                if(strcmp($d_select_begin,$today)<=0 && strcmp($today,$d_select_end)<=0)
                {
                    // 選課時間還沒有過，要看是不是可以直接選，這時候需要判斷auto admission
                    if($result['auto_admission'] == 1)
                        return 1;
                    elseif($result['auto_admission'] == 0)
                        return -1;
                }
                else //是教導式的課程，而且選課時間已經過了。
                    return 0;
            }
    }
    
    function take_selection($begin_course_cd,$personal_id,$type)
    {
        //已確認可以選課 就把這個使用者加到take_course裡面
        $sql = "SELECT course_duration,attribute,d_course_end
            FROM begin_course 
            WHERE begin_course_cd = {$begin_course_cd}";
        $data = db_getRow($sql);
        $course_duration = $data['course_duration'];
        $course_begin_date = date("Y-m-d",time());
        if($data['attribute']==0)//自學
            $course_end_date = date("Y-m-d",time()+$course_duration*31*24*3600);
        else if($data['attribute']==1)
            $course_end_date = $data['d_course_end']; 
        //由輸入的type來決定是否要審核 如果需要審核的話 allow_course = 0，如果不需審核的話 allow_course = 1;
        $allow_course = $type; 

        $sql = "INSERT INTO take_course
            (
                begin_course_cd,
                personal_id,
                allow_course,
                status_student,
                course_begin,
                course_end
            )
            VALUES 
            (
                '{$begin_course_cd}',
                '{$personal_id}',
                '{$allow_course}',
                '1',
                '{$course_begin_date}',
                '{$course_end_date}'
            )";

        db_query($sql);
    }
?>
