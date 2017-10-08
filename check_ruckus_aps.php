#!/usr/bin/php
<?php

$host = "";
$version = "";
$comunidad = "";
$mode = "";
$option = "";

$warning = "";
$critical = "";
$warning_low = "";
$critical_low = "";

$valor_final = "";
$value_out = 0;
$pnp_out = "";

$salida = 0;
$string_salida = "OK - ";

foreach ($argv as $arg) {
        if (strpos($arg, "H=") !== false) { $host = str_replace("H=","",$arg); }
        if (strpos($arg, "v=") !== false) { $version = str_replace("v=","",$arg); }
        if (strpos($arg, "co=") !== false) { $comunidad = str_replace("co=","",$arg); }

        if (strpos($arg, "m=") !== false) { $mode = str_replace("m=","",$arg); }
        if (strpos($arg, "o=") !== false) { $option = str_replace("o=","",$arg); }

        if (strpos($arg, "w=") !== false) { $warning = str_replace("w=","",$arg); }
        if (strpos($arg, "c=") !== false) { $critical = str_replace("c=","",$arg); }
        if (strpos($arg, "W=") !== false) { $warning_low = str_replace("W=","",$arg); }
        if (strpos($arg, "C=") !== false) { $critical_low = str_replace("C=","",$arg); }
}

if ($mode == "ap_status") {
	$ap_status = shell_exec("snmpwalk -c ".$comunidad." -v ".$version." ".$host." 1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.3");
	$ap_status_total = substr_count($ap_status,"INTEGER: ");
	$ap_status_disconnected = substr_count($ap_status,"INTEGER: 0");
	$ap_status_connect = substr_count($ap_status,"INTEGER: 1");
	$ap_status_approvalPending = substr_count($ap_status,"INTEGER: 2");
	$ap_status_upgradingFirmware = substr_count($ap_status,"INTEGER: 3");
	$ap_status_provisioning = substr_count($ap_status,"INTEGER: 4");

	$ap_status_total = $ap_status_total*1;
	$ap_status_disconnected = $ap_status_disconnected*1;
	$ap_status_connect = $ap_status_connect*1;
	$ap_status_approvalPending = $ap_status_approvalPending*1;
	$ap_status_upgradingFirmware = $ap_status_upgradingFirmware*1;
	$ap_status_provisioning = $ap_status_provisioning*1;

	$ap_status_others = $ap_status_approvalPending + $ap_status_upgradingFirmware + $ap_status_provisioning;
	
	$string_out = "APs total=".$ap_status_total.", APs connected=".$ap_status_connect.", APs disconnected=".$ap_status_disconnected.", APs another state=".$ap_status_others;
	$value_out = $ap_status_disconnected;
	$pnp_out = "disconnect=".$value_out." connect=".$ap_status_connect." other=".$ap_status_others;
}

if ($warning != "") { if ($value_out > $warning) { $salida = 1; $string_salida = "WARNING - "; } }
if ($critical != "") { if ($value_out > $critical) { $salida = 2; $string_salida = "CRITICAL - "; } }
if ($warning_low != "") { if ($value_out < $warning_low) { $salida = 1; $string_salida = "WARNING - "; } }
if ($critical_low != "") { if ($value_out < $critical_low) { $salida = 2; $string_salida = "CRITICAL - "; } }
echo $string_salida.$string_out." | ".$pnp_out."\n";
exit($salida)


?>
