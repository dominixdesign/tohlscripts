<?php
include('./lib/csvImporter.php');
include_once('./lib/utils.php');
include_once('./lib/ov.php');
include_once('./lib/getTeamList.php');

$saison = 'TOHL10';
$type = 'pre';

$contracts = array();
$files = scandir('./import/'.$saison.'/contracts/');
foreach($files as $file) {
	$ct = json_decode(@file_get_contents('./import/'.$saison.'/contracts/'.$file),true);
	if($ct) {
		$contracts = array_merge($contracts,$ct);
	}
}

$newHexData = '';
$plusEX = 0;

$file = fopen( './import/'.$saison.'/'.$saison.$type.'.ros','r');
for($i=0;$i<5000;$i ++) {
	$data = str_split(bin2hex(fread($file,86)),2);
	$name = trim(hex2str(join(array_slice($data, 0, 20))));

	if(!$name) {
		$newHexData .= implode('',$data);
		continue;
	}
	$name = str_replace(' ','_',$name);
	if(array_key_exists($name,$contracts) && $contracts[$name] > 0) {
		$ov = ov(hex2pos($data[22]),sequenceToValue(sequenceToDec($data),32));
		$salary = getSalary($ov, hex2pos($data[22]));
		$salaryHex = str_pad(dechex($salary), 6, '0', STR_PAD_LEFT);

		echo $name. ' ('.$ov.') '. hex2pos($data[22])." => ".$contracts[$name]." $".$salary."
		";
		$data[50] = str_pad(dechex((int)($contracts[$name])), 2, '0', STR_PAD_LEFT);
		$data[48] = $salaryHex[0] . $salaryHex[1];
		$data[47] = $salaryHex[2] . $salaryHex[3];
		$data[46] = $salaryHex[4] . $salaryHex[5];
	}

	$newHexData .= implode('',$data);

}

$file2 = fopen( './export/'.$saison.'/'.$saison.$type.'.ros','w+');
fwrite($file2, hex2bin($newHexData));
fclose($file);
fclose($file2);
