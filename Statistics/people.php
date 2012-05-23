<?php
define('ROOT', '../');
require_once(ROOT.'config.php');
require_once(ROOT.'session.php');

checkAdmin();

require_once('lib.php');
global $DB_CONN;

//$role_cd = $_SESSION['role_cd'];
$tpl = new Smarty;

$has_data = false;

if (array_key_exists('class_choose', $_POST)) {
    $has_data = true;
    $class_choose = (int) $_POST['class_choose'];
    $tpl->assign('class_choose', $class_choose);
}

$class = -1;
if (array_key_exists('class', $_POST)) {
    $has_data = true;
    $class = (int) $_POST['class'];
    $tpl->assign('class', $class);
}

if (array_key_exists('class_kind', $_POST)) {
    $has_data = true;
    $class_kind = (int) $_POST['class_kind'];
    $tpl->assign('class_kind', $class_kind);
}

if (array_key_exists('class_for', $_POST)) {
    $has_data = true;
    $class_for = (int) $_POST['class_for'];
    $tpl->assign('class_for', $class_for);
}

$date_enable = false;
if (array_key_exists('date_enable', $_POST)) {
    $has_data = true;
    $date_enable = true;

    if (array_key_exists('date_begin', $_POST) && strlen($_POST['date_begin'])) {
        $tpl->assign('date_begin', $_POST['date_begin']);
        $date_begin = date_create($_POST['date_begin']);
    }

    if (array_key_exists('date_end', $_POST) && strlen($_POST['date_end'])) {
        $tpl->assign('date_end', $_POST['date_end']);
        $date_end = date_create($_POST['date_end']);
    }

    $tpl->assign('date_enable', $date_enable);
}

$type_enable = false;
if (array_key_exists('type_enable', $_POST)) {
    $has_data = true;
    $type_enable = true;
    $tpl->assign('type_enable', $type_enable);
    $type = (int) $_POST['type'];
    $tpl->assign('type', $type);
    $type_title = (int) $_POST['type_title'];
    $tpl->assign('type_title', $type_title);
    $type_detail = (int) $_POST['type_detail'];
    $tpl->assign('type_detail', $type_detail);
}

$class_enable = false;
if (array_key_exists('class_enable', $_POST)) {
    $has_data = true;
    $class_enable = (int) $_POST['class_enable'];
    $tpl->assign('class_enable', $class_enable);
}

$location_enable = false;
if (array_key_exists('location_enable', $_POST)) {
    $has_data = true;
    $location_enable = (int) $_POST['location_enable'];
    $type_location = (int) $_POST['type_location'];
    $tpl->assign('type_location', $type_location);
    $type_doc = (int) $_POST['type_doc'];
    $tpl->assign('type_doc', $type_doc);
    $tpl->assign('location_enable', $location_enable);
}
if (array_key_exists('sort', $_POST)) {
    $sort = (int) $_POST['sort'];
    $tpl->assign('sort', $sort);
}

$type_list = array(-1=>'不限','一般民眾','國民中小學教師','高中職教師','大專院校學生','大專院校教師');
$tpl->assign('type_list', $type_list);
$type_title_list = array(-1=>'不限','一般教師', '主任', '校長');
$tpl->assign('type_title_list', $type_title_list);
$type_detail_list = array(-1=>'不限','婦女','銀髮族','新住民','勞工');
$tpl->assign('type_detail_list', $type_detail_list);
$sort_list = array(-1=>'不限','依日期','依人數');
$tpl->assign('sort_list', $sort_list);
$tpl->assign('has_data', $has_data);
if ($has_data) {
    $sql_table = '';
    $sql_where = '';
    if ($class_choose != -1) {
        $sql_where .= ' AND begin_course_cd = ' . $class_choose;
    } else if ($class == 1) { // 依課程性質
        if ($class_kind != -1) {
            $sql_where .= ' AND course_property = ' . $class_kind;
        }
    } else if ($class == 2) { // 依開課對象
        if ($class_for != -1) {
            $sql_where .= ' AND memberkind = ' . $class_for;
        }
    }

    if ($date_enable) {
        if (isset($date_begin)) {
            $sql_where .= ' AND take_course.course_end >= ' . $date_begin->format('\'Y-m-d H:i:s\'');
        }
        if (isset($date_end)) {
            $sql_where .= ' AND take_course.course_begin <= ' . $date_end->format('\'Y-m-d H:i:s\'');
        }
    }

    $need_personal_basic = false;
    if ($type_enable) {
        if ($type != -1) {
            if ($type == 0) { // 一般民眾
                if ($type_detail != -1) {
                    if ($type_detail == 0) { // 婦女
                        $need_personal_basic = true;
                        $sql_where .= ' AND personal_basic.sex = 0 AND personal_basic.d_birthday < DATE_SUB(NOW(), INTERVAL 40 YEAR)';
                    } else if ($type_detail == 1) { // 銀髮族
                        $need_personal_basic = true;
                        $sql_where .= ' AND personal_basic.d_birthday < DATE_SUB(NOW(), INTERVAL 50 YEAR)';
                    } else if ($type_detail == 2) { // 新住民
                        $need_personal_basic = true;
                        $sql_where .= ' AND personal_basic.familysite = 3';
                    } else if ($type_detail == 3) { // 勞工
                        $need_personal_basic = true;
                        $sql_where .= ' AND personal_basic.job = 0';
                    }
                }
            } else if ($type == 1 || $type == 2) { // 教師
                $need_personal_basic = true;
                $sql_where .= ' AND personal_basic.dist_cd = ' . $type;
                if ($type_title != -1) {
                    $sql_where .= ' AND personal_basic.title = ' . $type_title;
                }
            } else if ($type == 3 || $type == 4) { // 大專院校師生
                $need_personal_basic = true;
                $sql_where .= ' AND personal_basic.dist_cd = ' . $type;
            }
        }
    }
    if($location_enable){
        if ($type_location != -1) {
            $need_personal_basic = true;
            $sql_where .= ' AND personal_basic.city_cd = ' . $type_location;
        }
        if ($type_doc != -1) {
            $need_personal_basic = true;
            $sql_where .= ' AND personal_basic.doc_cd = ' . $type_doc;
        }

    }
    if ($need_personal_basic) {
        $sql_table .= ',personal_basic';
        $sql_where .= ' AND take_course.personal_id = personal_basic.personal_id';
    }
    $sub_sql = 'SELECT COUNT(*) FROM take_course' . $sql_table . ' WHERE take_course.begin_course_cd = begin_course.begin_course_cd AND take_course.allow_course = 1' . $sql_where;
    $sql = 'SELECT begin_course_cd,d_course_begin,property_name,begin_course_name,(' . $sub_sql . ') AS C FROM begin_course,course_property WHERE course_property.property_cd = begin_course.course_property HAVING C > 0';
    if ($sort != -1) {
        if ($sort == 0) { //依日期
            $sql .= ' ORDER BY d_course_begin';
        } else if ($sort == 1) { //依人數
            $sql .= ' ORDER BY C DESC';
        }
    }

	//dump_sql($sql,'所有課及修課人數');
    //
    //cho($sql);
    $result = $DB_CONN->query($sql);

    if (PEAR::isError($result)) {
        die($result->getMessage() . '<br/>' . $sql);
    }
    $title = Array();

    $title[] = '年';
    $title[] = '月';
    $title[] = '日';
    $title[] = '課程名稱';
    $title[] = '研習人數';
    $tpl->assign('title', $title);

    $data = Array();

    while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
        $data_row = Array($row['begin_course_cd']);
        $course_begin_date = date_create($row['d_course_begin']);
        $data_row[] = $course_begin_date->format('Y');
        $data_row[] = $course_begin_date->format('m');
        $data_row[] = $course_begin_date->format('d');
        $data_row[] = $row['begin_course_name']; //課程名稱
        $data_row[] = $row['c']; //研習人數
        array_push($data, $data_row);
    }

    $tpl->assign('data', $data);
}


/* fetch 課程類別 */
$course_property = Array();
$course_property['-1'] = "不限";
$sql = 'SELECT property_cd,property_name FROM course_property ORDER BY property_cd ASC';
$result = $DB_CONN->query($sql);
while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $course_property[$row['property_cd']] = $row['property_name'];
}
$tpl->assign('course_property', $course_property);

/* fetch 課程選單 */
$class_list = Array();
$class_list['-1'] = "不限";
$sql = "SELECT begin_course_cd,begin_course_name FROM begin_course";
if($class != -1 && ($class_kind != -1 || $class_for != -1))
{
    $sql .= " WHERE ";
    if($class_kind != -1)
    {
        $sql .= "course_property=$class_kind";
    }
    if($class_for != -1)
    {
        if($class_kind != -1)
        {
            $sql .= " AND ";
        }
        $sql .= "memberkind=$class_for";
    }
}

$result = $DB_CONN->query($sql);
if (PEAR::isError($result)) die($result->getMessage() . '<br/>' . $sql);
while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $class_list[$row['begin_course_cd']] = $row['begin_course_name'];
}
$tpl->assign('class_list', $class_list);

/* fetch 縣市別 */
$location_list = Array();
$sql = 'SELECT city_cd,city FROM location GROUP BY city_cd';
$result = $DB_CONN->query($sql);
if (PEAR::isError($result)) die($result->getMessage() . '<br/>' . $sql);
while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    $location_list[$row['city_cd']] = $row['city'];
}
$tpl->assign('location_list', $location_list);

assignTemplate($tpl, '/statistics/people.tpl');
?>
