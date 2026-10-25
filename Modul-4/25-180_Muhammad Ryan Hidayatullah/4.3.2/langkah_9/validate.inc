<?php
// LANGKAH 9: tambahkan validasi server-side untuk field masukan yang lain,

// Mengambil nilai field sebagai string (kosong jika tidak ada)
function fieldValue($field_list, $field_name, $trim = true)
{
    if (!isset($field_list[$field_name]) || !is_string($field_list[$field_name]))
        return '';
    return $trim ? trim($field_list[$field_name]) : $field_list[$field_name];
}

function validateName(&$errors, $field_list, $field_name)
{
    $pattern = "/^[a-zA-Z'-]+$/"; // format surname (alfabet)
    $value = fieldValue($field_list, $field_name);

    if ($value === '')
        $errors[$field_name] = 'Surname is required';
    else if (!preg_match($pattern, $value))
        $errors[$field_name] = 'Surname may only contain letters, apostrophes and hyphens';
}

function validateEmail(&$errors, $field_list, $field_name)
{
    $value = fieldValue($field_list, $field_name);

    if ($value === '')
        $errors[$field_name] = 'Email address is required';
    else if (!filter_var($value, FILTER_VALIDATE_EMAIL))
        $errors[$field_name] = 'Email address is not valid (example: j.smith@gmail.com)';
}

function validatePassword(&$errors, $field_list, $field_name)
{
    // Password tidak di-trim agar spasi yang disengaja tetap dihitung
    $value = fieldValue($field_list, $field_name, false);

    if ($value === '')
        $errors[$field_name] = 'Password is required';
    else if (strlen($value) < 6)
        $errors[$field_name] = 'Password must be at least 6 characters';
}

function validateAddress(&$errors, $field_list, $field_name)
{
    $value = fieldValue($field_list, $field_name);

    if ($value === '')
        $errors[$field_name] = 'Street address is required';
}

function validateState(&$errors, $field_list, $field_name)
{
    $value = fieldValue($field_list, $field_name);
    $allowed = array('1', '2', '3', '4', '5', '6', '7', '8');

    if (!in_array($value, $allowed, true))
        $errors[$field_name] = 'Please choose a state';
}

function validateGender(&$errors, $field_list, $field_name)
{
    $value = fieldValue($field_list, $field_name);

    if (!in_array($value, array('male', 'female'), true))
        $errors[$field_name] = 'Please select a gender';
}

?>
