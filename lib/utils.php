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
