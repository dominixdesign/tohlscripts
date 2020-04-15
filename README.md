
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

## Files
```
sensim.tms - 	TeaMS file; this file records team names, division names, and alignments in the league.
sensim.ros - 	ROSter files for accumulated stats.
sensim.lge - 	LeaGuE file; this is where league settings are stored
sensim.pct - 	ProspeCT file;
sensim.fas - 	Free AgentS file; records who the free agents are and what level.
sensim.scd - 	SCheDule file; this is where the current league schedule is stored.
sensim.dpk - 	Draft PicK; this file holds information about team draft pick ownership and trades.
sensim.pri - 	PRIority filel this is where the priority list for teams in drafts is stored.
sensim.wvr - 	WaiVeR; holds players currently on waivers and claims against them.
sensim.coa - 	COAch data file; stores info about your coaches.
sensim.drs - 	Data RoSter files; source files for player ratings and creating new leagues.
sensim.tra - 	TRAnsactions file; stores the stuff for trades, promotions, demotions, etc.
sensim.plf - 	PLayofF file; stores information about the current state of your playoffs (if underway).
sensim.rec - 	RECords file; not used in 1.x
sensim.csr - 	Cumulative Stats Record; holds a checkpoint of a player's stats when he is traded.
sensim.eml - 	EMaiL file; records email addresses of GMs.
sensim.frm - 	FaRM file; records the farm stats.
sensim.dft - 	DraFT file; this file stores information about the current draft if one is underway.
```

### \*.ros file

Ein Team hat 4.300 Bytes. Also Platz für exakt 50 Spieler.  
Teams kommen sequentiell.
#### Spielerdatensatz hat 86 Bytes
```
43 68 72 69 73 74 69 61 6E 20 50 61 72 61 6C 20
20 20 20 20 20 20 00 18 00 00 00 48 B3 20 C8 64
3C 47 57 4B 47 40 4E 51 4C 3C 56 38 25 00 80 A3
04 00 02 00 00 00 00 00 00 00 00 00 00 00 00 00
00 00 00 00 00 00 00 00 00 00 00 00 47 45 52 00
00 00 00 00 00 00
```


### \*.tms file

#### Teamdatensatz hat 255 Bytes
```
52 41 43 43 4F 4F 4E 53 20 20 53 6C 79 20 20 20
20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20
20 20 20 00 20 20 20 20 20 20 20 20 20 20 20 20
20 20 20 20 20 20 20 20 20 20 00 00 00 52 41 43
45 69 73 68 6F 65 6C 6C 65 20 52 65 69 6E 69 63
6B 65 6E 64 6F 72 66 20 20 20 20 20 20 20 20 4E
10 01 00 65 CC A3 00 52 6F 73 74 69 73 6C 61 76
20 4B 6F 6E 64 69 62 6F 6C 73 6B 79 20 B0 AD 01
00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00
00 00 00 06 00 00 00 00 00 00 00 00 00 00 00 00
00 00 00 00 00 00 00 00 00 00 00 00 00 00 02 1A
00 02 02 00 02 00 1A 00 1A 00 24 2A 15 0F 2A 2A
15 06 0B 04 0A 01 1F 06 06 0B 04 06 06 0B 01 18
01 1F 14 18 02 01 14 0C 01 01 18 09 2B 14 18 FF
FF FF 2B 18 1F 09 09 2B FF FF FF FF FF FF FF 00
00 00 00 00 00 00 00 00 00 6A 0C 01 FF FF
```
