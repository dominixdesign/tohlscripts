
		echo "Position: " . hex2pos($data[24]) . PHP_EOL;
		echo "Nummer: " . hexdec($data[25]) . PHP_EOL;
		echo "Hand: " . hexdec($data[28]) . PHP_EOL; 0 => L, 1 => R
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
