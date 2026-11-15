<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posted Data</title>
    <style>
        body { font-family: Verdana, Arial, sans-serif; font-size: 12px; }
        h3 { margin-bottom: 8px; }
    </style>
</head>
<body>
    <h3>Posted data: </h3>
<?php
// LANGKAH 5: ubah processData.php agar dapat menampilkan detil pesan error
require 'validate.inc';

foreach ($_POST as $key => $value)
    echo "(" . htmlspecialchars($key) . ") => (" . htmlspecialchars($value) . ")<br/>";

echo '<br/>';

// Validasi field surname, detil error disimpan ke $errors
$errors = array();
validateName($errors, $_POST, 'surname');

if ($errors)
{
    echo 'Errors:<br/>';
    foreach ($errors as $field => $error)
        echo "$field $error<br/>";
}
else
    echo 'Data OK!';

// LANGKAH 6: pengujian - isi surname dengan data benar dan salah (juga dikosongkan), lalu amati hasilnya

?>
</body>
</html>
