<?php
// LANGKAH 1: membuat validate.inc yang berisi fungsi validateName
// validate.inc - versi 1: fungsi mengembalikan true/false
function validateName($field_list, $field_name)
{
    if (!isset($field_list[$field_name]))
        return false;

    $pattern = "/^[a-zA-Z'-]+$/"; // format nama (alfabet)
    if (!preg_match($pattern, $field_list[$field_name]))
        return false;
    return true;
}
?>
