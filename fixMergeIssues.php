<?php
include('./lib/csvImporter.php');
include('./lib/utils.php');
include_once('./lib/ov.php');

$file = fopen( './import/TOHL11/TOHL11pre.ros','r');
$oldData = array();

$newHexData = '';
for($i=0;$i<5000;$i++) {
	$data = str_split(bin2hex(fread($file,86)),2);
	$name = trim(hex2str(join(array_slice($data, 0, 20))));

	if(hexdec($data[28]) > 0 && hexdec($data[27]) > 0 ) {
		$oldData[$name] = $data;
	}
}

$file2 = fopen( './import/TOHL11broken/TOHL11pre.ros','r');
$newHexData = '';
for($i=0;$i<5000;$i++) {
	$data = str_split(bin2hex(fread($file2,86)),2);
	$name = trim(hex2str(join(array_slice($data, 0, 20))));

	if(count($data)<=1) {
		break;
	}
	// alter check
	if($data[29] != $oldData[$name][29] && $data[29] != '00' && $oldData[$name][29] != '') {
		echo $name . ' (Alter)' .  PHP_EOL;
		$data[29] = $oldData[$name][29];
	}

	// werte check
	$temp = $data;
	$c = 0;
	for($i=32;$i<=44;$i++) {
		if(hexdec($data[$i]) < hexdec($oldData[$name][$i])) {
			$data[$i] = $oldData[$name][$i];
			$ii = $i;
			$c++;
		}
	}
	if($c>0) {
		$newHexData .= implode('',$data);
		echo $name . ' (Werte)'. PHP_EOL;
	} else {
		$newHexData .= implode('',$temp);
	}

	// if(hexdec($data[28]) < 100 && hexdec($data[27]) > 100 ) {
	// 	// übernehme alte daten, außer alter, contract und salary
	// 	$alter = $data[29];
	// 	$vertrag = $data[50];
	// 	$salary1 = $data[46];
	// 	$salary2 = $data[47];
	// 	$salary3 = $data[48];
	//
	// 	$data = $oldData[$name];
	//
	// 	$data[29] = $alter;
	// 	$data[50] = $vertrag;
	// 	$data[46] = $salary1;
	// 	$data[47] = $salary2;
	// 	$data[48] = $salary3;
	//
	// }

	$newHexData .= implode('',$data);
}

// $file3 = fopen( './export/TOHL11/TOHL11pre.ros','w+');
//fwrite($file3, hex2bin($newHexData));
//fclose($file3);
fclose($file);
fclose($file2);
