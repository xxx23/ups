<?php

$DB_TYPE = "mysql";
$DB_HOST = "mysql1";
$DB_NAME = "elearning";
$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

// $DB_HOST = 'mysql-proxy';
$DB_CONN = new mysqli($DB_HOST, $DB_USERNAME, $DB_USERPASSWORD, $DB_NAME);
if($DB_CONN->connect_errno) 
{
	printf("Connect failed: %s\n", $DB_CONN->connect_error);
	die();
}

//appended by puppy for avoiding encoding problem
if ($DB_TYPE == "mysql")
	$DB_CONN->query("SET NAMES 'utf8'");

$sql = "select * from news, news_target where news.news_cd = news_target.news_cd";

$newsList = $DB_CONN->query($sql);

while($row = $newsList->fetch_assoc())
{
	$news_cd = $row['news_cd'];
	$dom = new DOMDocument('1.0');
	$dom->encoding = 'UTF-8';
	$fs = $dom->appendChild($dom->createElement('files'));
	$sql = "select * from news_upload where news_cd = $news_cd";
	$files = $DB_CONN->query($sql);
	while($file = $files->fetch_assoc())
	{
		for($i = 0; $i < 25; $i++)
		{
			$f = $fs->appendChild($dom->createElement('file'));
			$file_cd = $f->appendChild($dom->createElement('file_cd'));
			$file_cd->appendChild($dom->createTextNode($file['file_cd']));
			$file_name = $f->appendChild($dom->createElement('file_name'));
			$file_name->appendChild($dom->createTextNode($file['file_name']));
			$file_type = $f->appendChild($dom->createElement('file_type'));
			$file_type->appendChild($dom->createTextNode($file['file_type']));
			$news_file = $f->appendChild($dom->createElement('news_file'));
			$news_file->appendChild($dom->createTextNode($file['news_file']));
			$file_url = $f->appendChild($dom->createElement('file_url'));
			$file_url->appendChild($dom->createTextNode($file['file_url']));
			$if_url = $f->appendChild($dom->createElement('if_url'));
			$if_url->appendChild($dom->createTextNode($file['if_url']));
		}
	}
	$xmlString = $dom->saveXML();
	// $sql = "insert into news2 (news_cd, subject, personal_id, d_news_begin, d_news_end, content, important, frequency, d_cycle, week_cycle, handle, mtime, if_news, role_cd, begin_course_cd, course_type, file) values({$row['news_cd']}, {$row['subject']}, {$row['personal_id']}, {$row['d_news_begin']}, {$row['d_news_end']}, {$row['content']}, {$row['important']}, {$row['frequency']}, {$row['d_cycle']}, {$row['week_cycle']}, {$row['handle']}, {$row['mtime']}, {$row['if_news']}, {$row['role_cd']}, {$row['begin_course_cd']}, {$row['course_type']}, {$xmlString})";

	$sql = "insert into news2 (news_cd, subject, personal_id, d_news_begin, d_news_end, content, important, frequency, d_cycle, week_cycle, handle, mtime, if_news, role_cd, begin_course_cd, course_type, file) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	if(!$stmt = $DB_CONN->prepare($sql))
	{
		die('prepare error');
	}
	if(!$stmt->bind_param('isisssiisssisiiis', $row['news_cd'], $row['subject'], $row['personal_id'], $row['d_news_begin'], $row['d_news_end'], $row['content'], $row['important'], $row['frequency'], $row['d_cycle'], $row['week_cycle'], $row['handle'], $row['mtime'], $row['if_news'], $row['role_cd'], $row['begin_course_cd'], $row['course_type'], $xmlString))
	{
		die('bind error');
	}
	$stmt->execute();
	$stmt->close();
	$files->close();
}

$newsList->close();

$DB_CONN->close();

?>
