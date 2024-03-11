<?php
/*
dieses script fügt neue spieler hinzu.
es werden (hoffentlich) keine alten spieler beeinflusst.
*/
include('./lib/csvImporter.php');
include('./lib/utils.php');
include_once('./lib/ov.php');

$importer = new CsvImporter("./import/draft14.csv", false, ';');
$drafties = $importer->get();
/*
$drafties = array();
foreach ($data as $key => $p) {
	$drafties[trim($p[0])] = $p;
}
*/

$file = fopen('./import/TOHL15pre/TOHL15pre.drs', 'r');

$newHexData = '';
$currentDraftie = 1;
for ($i = 0; $i < 2000; $i++) {
	$data = str_split(bin2hex(fread($file, 88)), 2);
	echo $drafties[$currentDraftie][0] . PHP_EOL;
	if (array_sum(array_map(function ($a) {
		return hexdec($a);
	}, $data)) > 0) {
		$newHexData .= implode('', $data);
		continue;
	}
	$data = array_fill(0, 88, '00');

	if (strlen($drafties[$currentDraftie][0]) > 3) {
		echo $currentDraftie . '  ' . $drafties[$currentDraftie][0] . PHP_EOL;
	} else {
		break;
	}

	// $data[0] = 'FF';
	// $data[1] = 'FF';

	// Name in 22 Bytes
	for ($n = 0; $n < 22; $n++) {
		$data[2 + $n] = str2hex($drafties[$currentDraftie][0][$n]);
	}

	// Spielerwerte
	$c = 0;
	foreach (sequenceToValue($drafties[$currentDraftie], 3) as $v) {
		$data[34 + $c] = str_pad(dechex((int)$v), 2, '0', STR_PAD_LEFT);
		$c++;
		// if(34+$c >= 46) break;
	}

	$data[78] = str2hex($drafties[$currentDraftie][17][0]); //nation 1. zeichen
	$data[79] = str2hex($drafties[$currentDraftie][17][1]); //nation 2. zeichen
	$data[80] = str2hex($drafties[$currentDraftie][17][2]); //nation 3. zeichen
	$data[31] = dechex((int)$drafties[$currentDraftie][18]); //alter
	$data[29] = dechex((int)$drafties[$currentDraftie][19] / 2.54); //groesse
	$data[30] = dechex((int)$drafties[$currentDraftie][20] * 2.205); //gewicht

	$data[24] = pos2hex($drafties[$currentDraftie][1]); // Position
	$data[28] = str_pad(dechex($drafties[$currentDraftie][2] == 'R' ? 1 : 0), 2, '0', STR_PAD_LEFT); // Hand

	$ov = ov($drafties[$currentDraftie][1], sequenceToValue($drafties[$currentDraftie], 3));
	$salary = getSalary($ov, hex2pos($data[24]));
	$salaryHex = str_pad(dechex($salary), 6, '0', STR_PAD_LEFT);
	$data[52] = str_pad(dechex(4), 2, '0', STR_PAD_LEFT);
	$data[50] = $salaryHex[0] . $salaryHex[1];
	$data[49] = $salaryHex[2] . $salaryHex[3];
	$data[48] = $salaryHex[4] . $salaryHex[5];
	$currentDraftie++;

	$data = array_map(function ($v) {
		if (strlen($v) != 2) {
			return '00';
		}
		return $v;
	}, $data);
	$newHexData .= implode('', $data);
}

$file2 = fopen('./export/TOHL15/TOHL15pre.drs', 'w+');
fwrite($file2, hex2bin($newHexData));
fclose($file);
fclose($file2);
