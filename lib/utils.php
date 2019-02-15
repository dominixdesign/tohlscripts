<?php

function hex2str($hex) {
    $str = '';
    for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
    return $str;
}

function str2hex($string){
    $hex='';
    for ($i=0; $i < strlen($string); $i++){
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}

function hex2pos($hex) {
	switch($hex) {
		case '00': return 'C';
		case '01': return 'LW';
		case '02': return 'RW';
		case '03': return 'D';
		case '04': return 'G';
	}
}

function pos2hex($hex) {
	switch($hex) {
		case 'C': return '00';
		case 'LW': return '01';
		case 'RW': return '02';
		case 'D': return '03';
		case 'G': return '04';
	}
}

function sequenceToValue($sequence, $start = 0) {
	return [
		'it' => $sequence[0+$start],
		'sp' => $sequence[1+$start],
		'st' => $sequence[2+$start],
		'en' => $sequence[3+$start],
		'du' => $sequence[4+$start],
		'di' => $sequence[5+$start],
		'sk' => $sequence[6+$start],
		'pa' => $sequence[7+$start],
		'pc' => $sequence[8+$start],
		'df' => $sequence[9+$start],
		'sc' => $sequence[10+$start],
		'ex' => $sequence[11+$start],
		'ld' => $sequence[12+$start],
	];
}


function valuesToSequence($values, &$sequence, $start = 0) {
  $c = 0;
  foreach($values as $v) {
    $sequence[$start + $c++] = $v;
  }
}

function sequenceToDec($sequence) {
	foreach($sequence as $k => $v) {
		$sequence[$k] = hexdec($v);
	}
	return $sequence;
}
