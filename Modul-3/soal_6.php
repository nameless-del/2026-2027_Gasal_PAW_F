<?php
// Soal 6.1
function cetakAsosiatif($data) {
    foreach ($data as $kunci => $nilai) {
        echo $kunci . "=> " . $nilai . ", ";
    }
    echo "<br>";
}

$a = array("A");
echo "Array awal: (\"A\")<br>";
array_push($a, "B");
echo "Hasil array_push: " . implode(" ", $a) . "<br><br>";

$a1 = array("A", "B");
$a2 = array("C");
$gabung = array_merge($a1, $a2);
echo "Array awal: (\"A\", \"B\") digabung dengan (\"C\")<br>";
echo "Hasil array_merge: " . implode(" ", $gabung) . "<br><br>";

$asosiatif = array("x" => 1, "y" => 2);
$nilai = array_values($asosiatif);
echo "Array awal: (\"x\" => 1, \"y\" => 2)<br>";
echo "Hasil array_values: " . implode(" ", $nilai) . "<br><br>";

$huruf = array("A", "B", "C");
$indeks = array_search("B", $huruf);
echo "Mencari \"B\" pada array: (\"A\", \"B\", \"C\")<br>";
echo "Hasil array_search: " . $indeks . "<br><br>";

$campur = array(0, 1, false, 2, "", 3, "array");
$hasilFilter = array_filter($campur);
echo "Array awal: (0, 1, false, 2, \"\", 3, \"array\")<br>";
echo "Hasil array_filter: " . implode(" ", $hasilFilter) . "<br><br>";

$angka = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
$urut = $angka;
sort($urut);
echo "Hasil sort: " . implode(" ", $urut) . "<br>";
$urut = $angka;
rsort($urut);
echo "Hasil rsort: " . implode(" ", $urut) . "<br><br>";

$umur = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo "Array awal: (\"Peter\"=>35, \"Ben\"=>37, \"Joe\"=>43)<br>";

$urut = $umur;
asort($urut);
echo "Hasil asort: ";
cetakAsosiatif($urut);

$urut = $umur;
ksort($urut);
echo "Hasil ksort: ";
cetakAsosiatif($urut);

$urut = $umur;
arsort($urut);
echo "Hasil arsort: ";
cetakAsosiatif($urut);

$urut = $umur;
krsort($urut);
echo "Hasil krsort: ";
cetakAsosiatif($urut);
?>
