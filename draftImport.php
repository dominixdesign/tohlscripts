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

$file = fopen( './import/TOHL10/TOHL10pre.drs','r');

$newHexData = '';
for($i=0;$i<5000;$i++) {
	$data = str_split(bin2hex(fread($file,88)),2);
	$name = trim(hex2str(join(array_slice($data, 2, 22))));

	if(!$name) {
		echo $i;
		break;
	}

	if(array_key_exists($name, $drafties)) {
		if(strlen($drafties[$name][17])>3) {
			echo $drafties[$name][17];
		}
		$c = 0;
	  foreach(sequenceToValue($drafties[$name],3) as $v) {
	    $sequence[34 + $c] = dechex((int)$v);
			$c++;
	  }

		$data[78] = str2hex($drafties[$name][17][0]); //nation 1. zeichen
		$data[79] = str2hex($drafties[$name][17][1]); //nation 2. zeichen
		$data[80] = str2hex($drafties[$name][17][2]); //nation 3. zeichen
		$data[31] = dechex((int)$drafties[$name][18]); //alter
		$data[29] = dechex((int)$drafties[$name][19]); //groesse
		$data[30] = dechex((int)$drafties[$name][20]); //gewicht

		$data[24] = pos2hex($drafties[$name][1]); // Position
		$data[28] = str_pad(dechex($drafties[$name][2]=='R' ? 1 : 0), 2, '0', STR_PAD_LEFT); // Hand

		$ov = ov($drafties[$name][1],sequenceToValue($drafties[$name],3));
		$salary = getSalary($ov, hex2pos($data[24]));
		$salaryHex = str_pad(dechex($salary), 6, '0', STR_PAD_LEFT);
		$data[52] = str_pad(dechex(4), 2, '0', STR_PAD_LEFT);
		$data[50] = $salaryHex[0] . $salaryHex[1];
		$data[49] = $salaryHex[2] . $salaryHex[3];
		$data[48] = $salaryHex[4] . $salaryHex[5];
	}

	$newHexData .= implode('',$data);

}

$file2 = fopen( './export/TOHL10/TOHL10pre.drs','w+');
fwrite($file2, hex2bin($newHexData));
fclose($file);
fclose($file2);
