<?php
include('./lib/csvImporter.php');
include('./lib/utils.php');
include_once('./lib/ov.php');

$importer = new CsvImporter("./import/draft9.csv",false,';');
$data = $importer->get();
$drafties = array();
foreach ($data as $key => $p) {
	$drafties[trim($p[0])] = $p;
}

$file = fopen( './import/TOHL10/TOHL10pre.ros','r');

$newHexData = '';
for($i=0;$i<5000;$i++) {
	$data = str_split(bin2hex(fread($file,86)),2);
	$name = trim(hex2str(join(array_slice($data, 0, 20))));

	if(array_key_exists($name, $drafties)) {
		if(strlen($drafties[$name][17])>3) {
			echo $drafties[$name][17];
		}
		$data[27] = dechex((int)$drafties[$name][19] / 2.54); //groesse in zoll
		$data[28] = dechex((int)$drafties[$name][20] * 2.205); //gewicht in lbs
		$data[29] = dechex((int)$drafties[$name][18]); //alter

		$ov = ov($drafties[$name][1],sequenceToValue($drafties[$name],3));
		$salary = getSalary($ov, hex2pos($data[24]));
		$salaryHex = str_pad(dechex($salary), 6, '0', STR_PAD_LEFT);
		$data[50] = str_pad(dechex(4), 2, '0', STR_PAD_LEFT); //vertrag
		$data[48] = $salaryHex[0] . $salaryHex[1];
		$data[47] = $salaryHex[2] . $salaryHex[3];
		$data[46] = $salaryHex[4] . $salaryHex[5];
		$data[44] = dechex((int)$drafties[$name][15]);
		echo $name .' - ' . $ov . ' - '.$drafties[$name][15]. ' ' . PHP_EOL;
	}

	$newHexData .= implode('',$data);

}

$file2 = fopen( './export/TOHL10/TOHL10pre.ros','w+');
fwrite($file2, hex2bin($newHexData));
fclose($file);
fclose($file2);
