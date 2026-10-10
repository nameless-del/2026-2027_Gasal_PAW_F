<?php

function tampilkanArray($nama, $data) {
    $pasangan = array();
    foreach ($data as $kunci => $nilai) {
        $pasangan[] = "\"" . $kunci . "\"=>\"" . $nilai . "\"";
    }
    echo $nama . " = (" . implode(", ", $pasangan) . ")<br>";
}

// Soal 4.1
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["David"]  = "180";
$height["Ethan"]  = "172";
$height["Frank"]  = "168";
$height["George"] = "175";
$height["Harry"]  = "182";

tampilkanArray("height", $height);
echo "<br>";

foreach ($height as $nama => $tinggi) {
    echo $nama . " is " . $tinggi . " cm tall.<br>";
}

echo "<hr>";

// Soal 4.2
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

tampilkanArray("weight", $weight);
echo "<br>";

$kunci = array_keys($weight);
$jumlah = count($kunci);

for ($i = 0; $i < $jumlah; $i++) {
    echo $kunci[$i] . " is " . $weight[$kunci[$i]] . " kg.<br>";
}
?>
