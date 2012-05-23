<?php
define('ROOT', '../');
require_once(ROOT.'config.php');
require_once(ROOT.'session.php');
require_once(ROOT.'library/jpgraph/jpgraph.php');
require_once(ROOT.'library/jpgraph/jpgraph_pie.php');
require_once(ROOT.'library/jpgraph/jpgraph_pie3d.php');
global $DB_CONN;

if (!array_key_exists('id', $_GET)) {
    die('argument error!');
}
$id = (int) $_GET['id'];

$data = Array();
$legend = Array();

$sql = 'SELECT';
$sep = false;
//fetch class name
$name_sql = "SELECT begin_course_name FROM begin_course WHERE begin_course_cd=". $id;
$name_result = $DB_CONN->query($name_sql);

$name_row =& $name_result->fetchRow(DB_FETCHMODE_ASSOC);
$class_name = $name_row['begin_course_name'];

//依身份
if($_GET['style']==1){
	if (array_key_exists('type', $_GET)) {
		$type_descript = Array( '一般民眾', '國民中小學教師', '高中職教師', '大專院校教師', '大專院校學生');
		foreach($_GET['type'] as $value) {
			if ($sep)
				$sql .= ',';
			$sep = true;
			$sql .= ' (SELECT COUNT(*) FROM personal_basic,take_course WHERE take_course.begin_course_cd = ' . $id .' AND take_course.personal_id = personal_basic.personal_id AND personal_basic.dist_cd = ' . $value . ') AS ' . $type_descript[$value];
		}
	}
	//$sql .= ' FROM take_course WHERE take_course.begin_course_cd = ' . $id;

	//echo($sql);
	$result = $DB_CONN->query($sql);

	if (PEAR::isError($result)) {
		die($result->getMessage() . '<br/>' . $sql);
	}

	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		foreach ($row as $key=>$value) {
			array_push($legend, $key);
			array_push($data, (int)$value);
		}
	}

	$graph = new PieGraph(700,400);
	//$graph->SetShadow();

	$graph->title->Set($class_name);
	$graph->title->SetFont(FF_CHINESE, FS_NORMAL, 18);
	$graph->legend->SetFont(FF_CHINESE, FS_NORMAL, 12);
	$graph->legend->SetShadow(false);
	$graph->legend->SetFrameWeight(0);
	$graph->legend->SetLayout(LEGEND_HOR);
	$graph->legend->SetPos(0.5, 0.95, 'center', 'bottom');

	$p1 = new PiePlot3D($data);
	//$p1->ExplodeSlice(0);
	$p1->SetSize(0.4);
	$p1->SetLegends($legend);
	$p1->SetLabelType(PIE_VALUE_ABS);
	$p1->value->SetFont(FF_CHINESE, FS_NORMAL, 12);
	$p1->value->SetFormat('%d 人');

	$graph->Add($p1);
	$graph->Stroke();
}

//依縣市
if($_GET['style']==2){
	$location_list = Array();
	$sql = 'SELECT city_cd,city FROM location GROUP BY city_cd';
	$result = $DB_CONN->query($sql);
	if (PEAR::isError($result)) die($result->getMessage() . '<br/>' . $sql);
	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$location_list[$row['city_cd']] = $row['city'];
	}
	$sql = "SELECT";
	$row = NULL;
	$result = NULL;
	if (array_key_exists('location', $_GET)) {
		foreach($_GET['location'] as $value) {
			if ($sep)
				$sql .= ',';
			$sep = true;
			$sql .= ' (SELECT COUNT(*) FROM personal_basic,take_course WHERE take_course.begin_course_cd = ' . $id .' AND take_course.personal_id = personal_basic.personal_id AND personal_basic.city_cd = ' . $value . ') AS ' . $location_list[$value];
		}
	}
	//$sql .= ' FROM take_course WHERE take_course.begin_course_cd = ' . $id;

	//echo($sql);
	$result = $DB_CONN->query($sql);

	if (PEAR::isError($result)) {
		die($result->getMessage() . '<br/>' . $sql);
	}

	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		foreach ($row as $key=>$value) {
			array_push($legend, $key);
			array_push($data, (int)$value);
		}
	}

	$graph = new PieGraph(700,400);
	//$graph->SetShadow();

	$graph->title->Set($class_name);
	$graph->title->SetFont(FF_CHINESE, FS_NORMAL, 18);
	$graph->legend->SetFont(FF_CHINESE, FS_NORMAL, 12);
	$graph->legend->SetShadow(false);
	$graph->legend->SetFrameWeight(0);
	$graph->legend->SetLayout(LEGEND_VERT);
	$graph->legend->SetColumns(2);
	$graph->legend->SetPos(0.025, 0.5, 'left', 'center');

	$p1 = new PiePlot3D($data);
	//$p1->ExplodeSlice(0);
	$p1->SetSize(0.4);
	$p1->SetCenter(0.6, 0.5);
	$p1->SetLegends($legend);
	$p1->SetLabelType(PIE_VALUE_ABS);
	$p1->value->SetFont(FF_CHINESE, FS_NORMAL, 12);
	$p1->value->SetFormat('%d 人');

	$graph->Add($p1);
	$graph->Stroke();
}
?>
