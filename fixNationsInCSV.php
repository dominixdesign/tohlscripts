<?php


$nations = array(
  'Afghanistan' => 'AFG',
  'Albanien' => 'ALB',
  'Argentinien'=> 'ARG',
  'Australien' => 'AUS',
  'Belgien' => 'BEL',
  'Brasilien' => 'BRA',
  'Brunei' => 'BRU',
  'Bulgarien'=> 'BUL',
  'Chile' => 'CHI',
  'China' => 'CHN',
  'Dänemark' => 'DEN',
  'Deutschland' => 'GER',
  'D�nemark' => 'DEN',
  'England' => 'ENG',
  'Estland' => 'EST',
  'Finnland' => 'FIN',
  'Frankreich' => 'FRA',
  'Ghana' => 'GHA',
  'Griechenland'=> 'GRE',
  'Indien' => 'IND',
  'Indonesien'=> 'INA',
  'Iran' => 'IRN',
  'Irland' => 'IRL',
  'Island' => 'ISL',
  'Israel' => 'ISR',
  'Italien' => 'ITA',
  'Japan'=> 'JPN',
  'Kanada' => 'CAN',
  'Kasachstan' => 'KAZ',
  'Kolumbien' => 'COL',
  'Kroatien' => 'CRO',
  'Lettland' => 'LAT',
  'Litauen' => 'LTU',
  'Malta' => 'MAL',
  'Mexiko' => 'MEX',
  'Neuseeland' => 'NZL',
  'Niederlande' => 'NED',
  'Nigeria' => 'NIG',
  'Nordkorea' => 'PRK',
  'Norwegen' => 'NOR',
  'Österreich' => 'AUT',
  'Paraguay' => 'PAR',
  'Polen' => 'POL',
  'Portugal' => 'POR',
  'Rumänien' => 'ROM',
  'Rum�nien' => 'ROM',
  'Russland' => 'RUS',
  'Schottland' => 'SCO',
  'Schweden' => 'SWE',
  'Schweiz' => 'SUI',
  'Senegal' => 'SEN',
  'Slowakei' => 'SVK',
  'Slowenien' => 'SLO',
  'Spanien' => 'ESP',
  'Südafrika' => 'RSA',
  'Südkorea' => 'KOR',
  'S�dafrika' => 'RSA',
  'S�dkorea' => 'KOR',
  'Tschechien' => 'CZE',
  'T�rkei'=> 'TUR',
  'Türkei'=> 'TUR',
  'Ukraine' => 'UKR',
  'Ungarn' => 'HUN',
  'Uruguay' => 'URU',
  'Venezuela' => 'VEN',
  'Zypern' => 'CYP',
  '�sterreich' => 'AUT',
);

$csvdata = file_get_contents("./import/filler.csv");

foreach ($nations as $nation => $short) {
  $csvdata = str_replace(';' . $nation . ';', ';' . $short . ';', $csvdata);
}

$re = '/;[A-Za-z]{4,};/m';
preg_match_all($re, $csvdata, $matches, PREG_SET_ORDER, 0);

echo "Unbekannte Nationen:" . PHP_EOL;
var_dump($matches);

$csvdata = file_put_contents("./import/filler.csv", $csvdata);
