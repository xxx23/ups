<?
$DB_USERNAME = "hsng";
$DB_USERPASSWORD = "ringline";

$m = new Mongo();

$admin = $m->admin;
// $range = 10000;
// for($i = 0; $i < 9; $i++)
// {
// 	$split = array(
// 		'split' => 'elearning.login_log',
// 		'middle' => array('p' => ($i + 1) * $range)
// 	);
// 	$res = $admin->command($split);
// 
// 	$shardName = 'shard000' . strval(intval($i % 3));
// 	$move = array(
// 		'moveChunk' => 'elearning.login_log',
// 		'find' => array('p' => ($i + 1) * $range),
// 		'to' => $shardName
// 	);
// 	$res = $admin->command($move);
// }
// for ( var x=97; x<97+26; x++ ){
//   for( var y=97; y<97+26; y+=6 ) {
//     var prefix = String.fromCharCode(x) + String.fromCharCode(y);
//     $admin->command( { split : "myapp.users" , middle : { email : prefix } } );
//   }
// }

for($i = 48; $i <= 90; $i++)
{
	// for($j = 97; $j < 97+26; $j++)
	// {
		$prefix = chr($i);
		if($i >= 65) $prefix = strtolower($prefix);
		$split = array(
			'split' => 'elearning.login_log',
			'middle' => array('_id' => $prefix)
		);
		$res = $admin->command($split);

		$shardName = 'shard000' . strval(intval(($i - 48) % 3));
		$move = array(
			'moveChunk' => 'elearning.login_log',
			'find' => array('_id' => $prefix),
			'to' => $shardName
		);
		$res = $admin->command($move);
	// }
}
