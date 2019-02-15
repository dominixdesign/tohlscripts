<?php

function ov($position, $v) {
if($position == 'G') {
	//goalie
	$ov=round(($v['it']*0.0945)+($v['sp']*0.3215)+($v['st']*0.0755)+($v['en']*0.0565)+($v['du']*0.0188)+($v['di']*0.0187)+($v['sk']*0.1325)+($v['pa']*0.0565)+($v['pc']*0.151)+($v['ex']*0.0187)+($v['ld']*0.0188)+(-1*0.475));
} elseif($position=='D') {
	if(($v['sc']+$v['pa']) > ($v['st']+$v['df'])) {
		$ov=round(($v['it']*0.059)+($v['sp']*0.1175)+($v['st']*0.059)+($v['en']*0.044)+($v['du']*0.0148)+($v['di']*0.0147)+($v['sk']*0.1175)+($v['pa']*0.162)+($v['pc']*0.132)+($v['df']*0.089)+($v['sc']*0.161)+($v['ex']*0.0147)+($v['ld']*0.0148)+(1*4.51));
	} else {
		$ov=round(($v['it']*0.1175)+($v['sp']*0.0735)+($v['st']*0.147)+($v['en']*0.044)+($v['du']*0.0148)+($v['di']*0.0147)+($v['sk']*0.0885)+($v['pa']*0.118)+($v['pc']*0.088)+($v['df']*0.191)+($v['sc']*0.0735)+($v['ex']*0.0147)+($v['ld']*0.0148)+(1*4.505));
	}
} else {
	// stürmer allgemein
	$ov=round(($v['it']*0.0735)+($v['sp']*0.0735)+($v['st']*0.103)+($v['en']*0.044)+($v['du']*0.0148)+($v['di']*0.0147)+($v['sk']*0.089)+($v['pa']*0.147)+($v['pc']*0.1175)+($v['df']*0.1025)+($v['sc']*0.191)+($v['ex']*0.0147)+($v['ld']*0.0148)+(1*4.505));
}
return (int)$ov;
}

function getSalary($ov, $position) {

	if($position=='G') {
		$new = 1000*floor((17*pow(($ov-43),3) - 610*pow(($ov-43),2) + 9000*($ov-43) + 8000)/1000);
	} else {
		$new = 1000*floor((17*pow(($ov-45),3) - 610*pow(($ov-45),2) + 9000*($ov-45) + 8000)/1000);
	}
	return ($new<25000) ? 25000 : $new;

}
