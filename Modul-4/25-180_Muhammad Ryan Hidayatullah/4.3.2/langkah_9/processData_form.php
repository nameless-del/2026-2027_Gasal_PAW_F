<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { font-family: Verdana, Arial, sans-serif; font-size: 12px; }
        fieldset { background-color: #ddf; width: 520px; }
        .field { clear: both; text-align: left; margin-bottom: 4px; }
        label { float: left; width: 120px; margin-right: 8px; text-align: right; }
        .error { color: #c00; margin-left: 6px; }
    </style>
</head>
<body>
    <h1>Register</h1>
<?php
$errors = array();
if (isset($_POST['surname']))
{
    require 'validate.inc';
    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'passwd');
    validateAddress($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    validateGender($errors, $_POST, 'sex');

    if ($errors)
    {
        echo '<h1>Invalid, correct the following errors:</h1>';

        // tampilkan kembali form beserta isian dan pesan error tiap field
        include 'form.inc';
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
{
    // tampilkan form kosong
    include 'form.inc';
}
?>
</body>
</html>
