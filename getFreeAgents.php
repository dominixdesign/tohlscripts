<?php
include('./lib/csvImporter.php');
include('./lib/utils.php');
include_once('./lib/ov.php');

$file = fopen( './import/TOHL10/TOHL10pre.ros','r');

$assignedPlayers = array();
$newHexData = '';
for($i=0;$i<5000;$i++) {
	$data = str_split(bin2hex(fread($file,86)),2);
	$name = trim(hex2str(join(array_slice($data, 0, 20))));
	$assignedPlayers[$name] = true;
}

$file = fopen( './import/TOHL10/TOHL10pre.drs','r');

$players = array();
for($i=0;$i<5000;$i++) {
	$data = str_split(bin2hex(fread($file,88)),2);
	$name = trim(hex2str(join(array_slice($data, 2, 22))));

	if(!$name || strlen($name)<=2) {
		echo $i;
		break;
	}

	if(!array_key_exists($name, $assignedPlayers) && hexdec($data[31]) < 30) {
		$players[$name] = array(
			'age' => hexdec($data[31]),
			'pos' => hex2pos($data[24]),
			'nation' => hex2str($data[78] . $data[79] . $data[80]),
			'hand' => (hexdec($data[28])==1) ? 'R' : 'L',
			'height' => round(hexdec($data[29]) * 2.54),
			'weight' => round(hexdec($data[30]) / 2.205),
			'it' => hexdec($data[34]),
			'sp' => hexdec($data[35]),
			'st' => hexdec($data[36]),
			'en' => hexdec($data[37]),
			'du' => hexdec($data[38]),
			'di' => hexdec($data[39]),
			'sk' => hexdec($data[40]),
			'pa' => hexdec($data[41]),
			'pc' => hexdec($data[42]),
			'df' => hexdec($data[43]),
			'sc' => hexdec($data[44]),
			'ex' => hexdec($data[45]),
			'ld' => hexdec($data[46])
		);
	}

}

echo json_encode($players);

fclose($file);
