<?php
include_once('./lib/utils.php');

function getTeamList($season, $type) {

	$teams = array();

	$file = fopen( './import/'.$season.'/'.$season.$type.'.tms','r');

	$newHexData = '';

	for($i=0;$i<200;$i ++) {
		if($file === false) break;
		$data = str_split(bin2hex(fread($file,254)),2);
		$name = trim(hex2str(join(array_slice($data, 0, 10))));

		if(!$name) {
			continue;
		}
		$teams[] = trim($name);
		continue;

	}

	return $teams;
}
