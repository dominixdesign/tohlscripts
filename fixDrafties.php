<?php
include('./lib/csvImporter.php');
include('./lib/utils.php');
include_once('./lib/ov.php');

$importer = new CsvImporter("./import/filler.csv", false, ';');
$data = $importer->get();
$drafties = array();
foreach ($data as $key => $p) {
	$drafties[trim($p[0])] = $p;
}

$file = fopen('./import/TOHL15pre/TOHL15pre.ros', 'r');

$newHexData = '';
for ($i = 0; $i < 5000; $i++) {
	if (is_bool($file)) {
		echo "end: " . $i;
		break;
	}
	$data = str_split(bin2hex(fread($file, 86)), 2);
	$name = trim(hex2str(join(array_slice($data, 0, 22))));

	if (array_key_exists($name, $drafties)) {
		if (strlen($drafties[$name][17]) > 3) {
			echo $drafties[$name][17];
		}

		echo $name . PHP_EOL;

		// echo "IT: " . hexdec($data[32]) . " --> " . $drafties[$name][3] . PHP_EOL;

		$data[76] = str2hex($drafties[$name][17][0]); //nation 1. zeichen
		$data[77] = str2hex($drafties[$name][17][1]); //nation 2. zeichen
		$data[78] = str2hex($drafties[$name][17][2]); //nation 3. zeichen

		$data[27] = dechex((int)$drafties[$name][20] / 2.54); //groesse in zoll
		$data[28] = dechex((int)$drafties[$name][21] * 2.205); //gewicht in lbs
		$data[29] = dechex((int)$drafties[$name][18]); //alter

		$data[50] = str_pad(dechex(4), 2, '0', STR_PAD_LEFT); //vertrag

		$ov = ov($drafties[$name][1], sequenceToValue($drafties[$name], 3));
		//$salary = getSalary($ov, hex2pos($data[24]));
		//$salaryHex = str_pad(dechex($salary), 6, '0', STR_PAD_LEFT);
		//echo $salary . " - " . $salaryHex . PHP_EOL;
		//$data[48] = $salaryHex[0] . $salaryHex[1];
		//$data[47] = $salaryHex[2] . $salaryHex[3];
		//$data[46] = $salaryHex[4] . $salaryHex[5];

		// Spielerwerte
		$c = 0;
		foreach (sequenceToValue($drafties[$name], 3) as $v) {

			if ($data[32 + $c] != dechex((int)$v)) {
				echo "MISMATCH! -------------------------- " . PHP_EOL;
			}

			$data[32 + $c] = str_pad(dechex((int)$v), 2, '0', STR_PAD_LEFT);
			$c++;
			// if(34+$c >= 46) break;
		}

		//$data[44] = dechex((int)$drafties[$name][16]);
		// echo $name . ' - ' . $ov . ' - ' . $drafties[$name][16] . ' ' . PHP_EOL;
	}

	$newHexData .= implode('', $data);
}

$file2 = fopen('./export/TOHL15pre/TOHL15pre.ros', 'w+');
fwrite($file2, hex2bin($newHexData));
fclose($file);
fclose($file2);
