<?php 
$process_num = 20;
print "老爸：我是老爸，我要生{$process_num}個小孩。\n";
$children = array();

$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

$start=microtime();
$start=explode(" ",$start);
$start=$start[1]+$start[0]; 

for($i = 1; $i <= $process_num; $i++) 
{
	$pid = pcntl_fork();
	if($pid == -1) 
	{
		exit(1);
	} 
	else if($pid) 
	{
		/*這是老爸專區*/
		$children[] = $pid; //紀錄下每個孩子的編號
		// print "老爸：生了一個第{$i}個孩子，pid是{$pid}\n";
	} 
	else 
	{
		/*這是小朋友區*/
		break; //直接出迴圈
	}
}
if($pid) 
{ /* 老爸會在這裡休息 */
	$status = null;
	/********************************************************
	 * 下面這行的存在意義是：
	 *  就算是等所有孩子先行離開以後
	 *  父程序才開始等子程序
	 *  父程序仍然會知道子程序已離開
	 **********************************************************/
	// sleep(8); 
	foreach($children as $pid) 
	{ //要等每個孩子都離開才離開
		pcntl_waitpid($pid, $status); 
		// print "老爸：pid是{$pid}的那個孩子，回去時他告訴我他的狀況是{$status}\n";
	}
	// print '老爸也要走了'."\n";
	$end=microtime();
	$end=explode(" ",$end);
	$end=$end[1]+$end[0];
	printf("three shards: %f seconds\n",$end-$start);
} 
else 
{
	/*以下是小朋友遊樂區*/
	// print "我是第{$i}個小朋友，我要睡{$i}秒\n";
	// sleep($i);
	// print "我是第{$i}個小朋友，要走了\n";
	// exit(0);
	$m = new Mongo("mongodb://${DB_USERNAME}:${DB_USERPASSWORD}@localhost/elearning");
	$db = $m->elearning;
	$online_number_s = $db->online_number_s;
	for($i = 0; $i < 10000; $i++)
	{
		$c = $online_number_s->find(array('_id' => intval(rand(1,2000000))));
		// $c->getNext();
		foreach($c as $r)
		{
			// print($r['pid'] . "\n");
		}
	}
}
?>
