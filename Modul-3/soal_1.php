<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

// Soal 1.1
$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo "fruits = ( \"" . implode("\", \"", $fruits) . "\" )<br>";

$indeksTertinggi = array_key_last($fruits);
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeksTertinggi];

echo "<hr>";

//Soal 1.2
unset($fruits[1]);
echo "Data Blueberry dihapus.<br>";

echo "fruits = ( \"" . implode("\", \"", $fruits) . "\" )<br>";

$indeksTertinggi = array_key_last($fruits);
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeksTertinggi];
?>
