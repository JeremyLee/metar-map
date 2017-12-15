<?php

$bbox = '-80,35.49,-71.6,40.3';
$url = 'https://aviationweather.gov/gis/scripts/MetarJSON.php?priority=10&bbox=' . $bbox;

$content = file_get_contents($url);
$data = json_decode($content);
$led_colors = array('VFR' => '0,64,0',
                    'MVFR' => '0,0,64',
                    'IFR' => '64,0,0',
                    'LIFR' => '32,0,32');


//var_dump($data->features[0]);

$display_stations = array('KSHD', 'KCHO', 'KIAD', 'KEKN');

$stations = array();

foreach($data->features as $key => $val) {
  $stations[$val -> properties -> id] = $val -> properties;
}

//var_dump($stations);
$led_values = array();
foreach($display_stations as $key => $val){
//  var_dump($stations["$val"]);
  $led_values[] = $led_colors[$stations["$val"] -> fltcat];
}

exec('sudo python yantest.py ' . implode(' ', $led_values));
