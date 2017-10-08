#!/usr/bin/php
<?php
$salida = 0;

$shortopts = "H:u:p:d:m:o:hvti"; 
$options = getopt($shortopts);

if ($options["H"] !== "") { $host = $options["H"]; } else { $host == "false"; }
$user = $options["u"];
$pass = $options["p"];
$domain = $options["d"];

$mode = $options["m"];

$option = $options["o"];

$version = $options["v"];
$test = $options["t"];
$help = $options["h"];
$info = $options["i"];

echo "host:".$host."\n";
echo "user:".$user."\n";
echo "pass:".$pass."\n";
echo "domain:".$domain."\n";
echo "mode:".$mode."\n";
echo "option:".$option."\n";
echo "host:".$host."\n";
echo "version:".$version."\n";
echo "test:".$test."\n";
echo "info:".$info."\n";

var_dump($options);
echo "\n";

#if ($warning != "") { if ($value_out > $warning) { $salida = 1; $string_salida = "WARNING - "; } }
#if ($critical != "") { if ($value_out > $critical) { $salida = 2; $string_salida = "CRITICAL - "; } }
#if ($warning_low != "") { if ($value_out < $warning_low) { $salida = 1; $string_salida = "WARNING - "; } }
#if ($critical_low != "") { if ($value_out < $critical_low) { $salida = 2; $string_salida = "CRITICAL - "; } }
#echo $string_salida.$string_out." | ".$pnp_out."\n";

exit($salida)


?>
