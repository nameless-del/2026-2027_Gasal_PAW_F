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
        <!-- LANGKAH 2: processData.php menampilkan data yang dikirim dari processData_form.html -->
    <!-- LANGKAH 3: pengujian lewat browser (F12 > Network), bandingkan method GET dan POST -->
    <h3>Posted data: </h3>
<?php
foreach ($_POST as $key => $value)
    echo "(" . htmlspecialchars($key) . ") => (" . htmlspecialchars($value) . ")<br/>";

//$surname = $_POST['surname'];
?>
</body>
</html>
