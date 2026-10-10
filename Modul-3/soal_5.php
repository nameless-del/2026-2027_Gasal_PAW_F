<?php
// Soal 5.1
function tampilkanStudents($data) {
    echo "students = (<br>";
    $jumlah = count($data);
    for ($i = 0; $i < $jumlah; $i++) {
        echo "(\"" . $data[$i][0] . "\", \"" . $data[$i][1] . "\", \"" . $data[$i][2] . "\")";
        if ($i < $jumlah - 1) {
            echo ",";
        }
        echo "<br>";
    }
    echo ")<br><br>";
}

$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

echo "Data awal:<br>";
tampilkanStudents($students);

$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena", "220405", "0812345622");
$students[] = array("Fiona", "220406", "0812345633");
$students[] = array("Gabe", "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");

echo "Data setelah ditambah 5 data lain:<br>";
tampilkanStudents($students);

echo "<table border='1' cellpadding='3'>";
echo "<tr><th>Name</th><th>NIM</th><th>Mobile</th></tr>";
foreach ($students as $mahasiswa) {
    echo "<tr>";
    foreach ($mahasiswa as $kolom) {
        echo "<td>" . $kolom . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
