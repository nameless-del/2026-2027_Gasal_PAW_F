<?php

function tampilkanArray($nama, $data) {
    $pasangan = array();
    foreach ($data as $kunci => $nilai) {
        $pasangan[] = "\"" . $kunci . "\"=>\"" . $nilai . "\"";
    }
    echo $nama . " = (" . implode(", ", $pasangan) . ")<br>";
}

// Soal 3.1
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["David"]  = "180";
$height["Ethan"]  = "172";
$height["Frank"]  = "168";
$height["George"] = "175";
$height["Harry"]  = "182";

tampilkanArray("height", $height);
$kunciTerakhir = array_key_last($height);
echo "Nilai dengan indeks terakhir: " . $height[$kunciTerakhir] . "<br><br>";

unset($height["Barry"]);

tampilkanArray("height", $height);
$kunciTerakhir = array_key_last($height);
echo "Nilai dengan indeks terakhir setelah dihapus: " . $height[$kunciTerakhir];

echo "<hr>";

// Soal 3.2
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");
tampilkanArray("weight", $weight);

$nilaiWeight = array_values($weight);
echo "Data kedua: " . $nilaiWeight[1];
?>