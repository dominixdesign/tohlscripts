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



/*
		echo "Position: " . hex2pos($data[24]) . PHP_EOL;
		echo "Nummer: " . hexdec($data[25]) . PHP_EOL;
		echo "Grosse: " . hexdec($data[29]) . PHP_EOL;
		echo "Gewicht: " . hexdec($data[30]) . PHP_EOL;
		echo "Alter: " . hexdec($data[31]) . PHP_EOL;
		echo "IT: " . hexdec($data[34]) . " ";
		echo "SP: " . hexdec($data[35]) . " ";
		echo "ST: " . hexdec($data[36]) . " ";
		echo "EN: " . hexdec($data[37]) . " ";
		echo "DU: " . hexdec($data[38]) . " ";
		echo "DI: " . hexdec($data[39]) . " ";
		echo "SK: " . hexdec($data[40]) . " ";
		echo "PA: " . hexdec($data[41]) . " ";
		echo "PC: " . hexdec($data[42]) . " ";
		echo "DF: " . hexdec($data[43]) . " ";
		echo "SC: " . hexdec($data[44]) . " ";
		echo "EX: " . hexdec($data[45]) . " ";
		echo "LD: " . hexdec($data[46]) . " ". PHP_EOL;
		echo "Salary: " . hexdec($data[50] . $data[49] . $data[48]) . PHP_EOL;
		echo "Contract: " . hexdec($data[52]) . PHP_EOL;
		echo "Country: " . hex2str($data[78] . $data[79] . $data[80]) . PHP_EOL;
		*/
	}

	$newHexData .= implode('',$data);

}

$file2 = fopen( './export/TOHL09pre.drs2','w+');
fwrite($file2, hex2bin($newHexData));
fclose($file);
fclose($file2);
//echo $newHexData;
//var_dump($drafties);
