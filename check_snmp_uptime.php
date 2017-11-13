#!/usr/bin/php
<?php

$host = "";
$help = false;
$version = false;
$salida = 0;
$string_salida = "OK - ";
$string_out = "";

$warning = "";
$critical = "";
$warning_low = "";
$critical_low = "";

foreach ($argv as $arg) {
	if (strpos($arg, "H=") !== false) { $host = str_replace("H=","",$arg); }
	if (strpos($arg, "t=") !== false) { $comunity = str_replace("t=","",$arg); }
	if (strpos($arg, "w=") !== false) { $warning = str_replace("w=","",$arg); }
	if (strpos($arg, "c=") !== false) { $critical = str_replace("c=","",$arg); }
	if (strpos($arg, "W=") !== false) { $warning_low = str_replace("W=","",$arg); }
	if (strpos($arg, "C=") !== false) { $critical_low = str_replace("C=","",$arg); }
	if (strpos($arg, "-h") !== false) { $help = true; }
	if (strpos($arg, "-v") !== false) { $version = true; }
}

if ($version == true) {
	echo "check_snmp_uptime.php Version 0.1.0\n";
	echo "check_snmp_uptime.php -h for help.\n";
}

if ($help == true) {
	echo "check_snmp_uptime.php Version 0.1.0\n\n";
}

$warnings = 0;
$criticals = 0;
if (($version == false) and ($help == false)) {

		$uptime = shell_exec("snmpget -Ovt -c ".$comunity." -v 2c ".$host." SNMPv2-MIB::sysUpTime.0");
		
		
		
		
		
		$valor_final = $uptime/100;

		$valor_final = intval($valor_final);
		$days = floor($valor_final/86400);
		$hours = floor(($valor_final-($days*86400))/3600);
		$minuts = floor(($valor_final-($days*86400)-($hours*3600))/60);
		$seconds = $valor_final-($days*86400)-($hours*3600)-($minuts*60);
		$string_out = "Uptime ".$days." days, ".$hours." hours, ".$minuts." minuts, ".$seconds." second >> ".$valor_final." seconds";
		$value_out = $valor_final;
		$pnp_out = "seconds=".$value_out.";".$warning.";".$critical;
		

	if ($warning != "") { if ($value_out >= $warning) { $salida = 1; $string_salida = "WARNING - "; } }
	if ($critical != "") { if ($value_out >= $critical){ $salida = 2; $string_salida = "CRITICAL - "; } }
	if ($warning_low != "") { if ($value_out <= $warning_low) { $salida = 1; $string_salida = "WARNING - "; } }
	if ($critical_low != "") { if ($value_out <= $critical_low){ $salida = 2; $string_salida = "CRITICAL - "; } }
	echo $string_salida.$string_out." | ".$pnp_out."\n";
		
}




exit($salida)
?>
