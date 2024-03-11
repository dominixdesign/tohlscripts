<?php


$nations = array(
  'Deutschland' => 'GER',
  'Italien' => 'ITA',
  'Portugal' => 'POR',
  'Slowenien' => 'SLO',
  'Kanada' => 'CAN',
  'Tschechien' => 'CZK',
  'Polen' => 'POL',
  'England' => 'ENG',
  'Norwegen' => 'NOR',
  'Australien' => 'AUS',
  'Lettland' => 'LAT',
  'Albanien' => 'ALB',
  'Brunei' => 'BRU',
  'Russland' => 'RUS',
  'Niederlande' => 'NED',
  'Schottland' => 'SCO',
  'Finnland' => 'FIN',
  'Slowakei' => 'SVK',
  'Nordkorea' => 'PRK',
  'Belgien' => 'BEL',
  'Rumänien' => 'ROM',
  'Rum�nien' => 'ROM',
  'Schweiz' => 'SUI',
  'Südafrika' => 'RSA',
  'S�dafrika' => 'RSA',
  'Schweden' => 'SWE',
  'Frankreich' => 'FRA',
  'Kasachstan' => 'KAZ',
  'Zypern' => 'CYP',
  'China' => 'CHN',
  'Litauen' => 'LTU',
  'Iran' => 'IRN',
  'Afghanistan' => 'AFG',
  'Dänemark' => 'DEN',
  'D�nemark' => 'DEN',
  '�sterreich' => 'AUT',
  'Österreich' => 'AUT',
  'Nigeria' => 'NIG',
  'Uruguay' => 'URU',
  'Venezuela' => 'VEN',
  'Indien' => 'IND',
  'Kroatien' => 'CRO',
  'Israel' => 'ISR',
  'Senegal' => 'SEN',
  'Ungarn' => 'HUN',
  'Südkorea' => 'KOR',
  'S�dkorea' => 'KOR',
  'Neuseeland' => 'NZL',
  'Irland' => 'IRL',
  'Estland' => 'EST',
);

$csvdata = file_get_contents("./import/draft14.csv");

foreach ($nations as $nation => $short) {
  $csvdata = str_replace(';' . $nation . ';', ';' . $short . ';', $csvdata);
}

$re = '/;[A-Za-z]{4,};/m';
preg_match_all($re, $csvdata, $matches, PREG_SET_ORDER, 0);

echo "Unbekannte Nationen:" . PHP_EOL;
var_dump($matches);

$csvdata = file_put_contents("./import/draft14.csv", $csvdata);
