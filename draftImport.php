<?php
include('./lib/csvImporter.php');
include('./lib/utils.php');

$importer = new CsvImporter("./import/draft.csv",false,';');
$data = $importer->get();
$drafties = array();
foreach ($data as $key => $p) {
	$drafties[trim($p[1])] = $p;
}

$file = fopen( './import/TOHL09pre.drs','r');

$newHexData = '';

for($i=0;$i<5000;$i++) {
	$data = str_split(bin2hex(fread($file,88)),2);
	$name = trim(hex2str(join(array_slice($data, 2, 22))));

	if(!$name) {
		echo $i;
		break;
	}

	if(array_key_exists($name, $drafties)) {
		$data[30] = dechex((int)$drafties[$name][21]); //gewicht
		$data[29] = dechex((int)$drafties[$name][22]); //groesse
		$data[78] = str2hex($drafties[$name][18][0]); //nation 1. zeichen
		$data[79] = str2hex($drafties[$name][18][1]); //nation 2. zeichen
		$data[80] = str2hex($drafties[$name][18][2]); //nation 3. zeichen
	}

	$newHexData .= implode('',$data);

}

$file2 = fopen( './export/TOHL09pre.drs2','w+');
fwrite($file2, hex2bin($newHexData));
fclose($file);
fclose($file2);
//echo $newHexData;
//var_dump($drafties);
