<?php
include('./lib/csvImporter.php');
include_once('./lib/utils.php');
include_once('./lib/getTeamList.php');

/*
echo "Are you sure you want to do this?  Type 'yes' to continue: ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
if(trim($line) != 'yes'){
    echo "ABORTING!\n";
    exit;
}
fclose($handle);
echo "\n";
echo "Thank you, continuing...\n";


die();
*/

$saison = 'TOHL10';
$type = 'pre';

$teams = getTeamList($saison,$type);

$file = fopen( './import/'.$saison.'/'.$saison.$type.'.ros','r');

$newHexData = '';
$plusEX = 0;

for($i=0;$i<5000;$i ++) {
	$data = str_split(bin2hex(fread($file,86)),2);
	$name = trim(hex2str(join(array_slice($data, 0, 20))));


	if($i % 50 == 0) {
		if(!array_key_exists($i/50,$teams)) {
			break;
		}
		echo "------------------------------------------------".PHP_EOL;
		echo $teams[$i/50].PHP_EOL;
		echo "------------------------------------------------".PHP_EOL;
		echo "Wie endete die Saison für dieses Team (f)inale, (p)layoffs oder nichts? ";
		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		$line = trim($line);
		if($line == 'p') {
			$plusEX = 4;
		} elseif($line == 'f') {
			$plusEX = 5;
		} else {
			$plusEX = 3;
		}
	}
	if(!$name) {
		$newHexData .= implode('',$data);
		continue;
	}
	$newEx = hexdec($data[43]) + $plusEX;
	if($newEx > 99) {
		$newEx = 99;
	}
	$data[43] = dechex((int)($newEx));

	$newHexData .= implode('',$data);

}

$file2 = fopen( './export/'.$saison.'/'.$saison.$type.'.ros','w+');
fwrite($file2, hex2bin($newHexData));
fclose($file);
fclose($file2);
