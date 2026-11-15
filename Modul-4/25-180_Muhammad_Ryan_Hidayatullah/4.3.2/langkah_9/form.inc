<?php
// $errors dibuat oleh processData_form.php; jaga-jaga jika form.inc dipanggil sendiri
if (!isset($errors))
    $errors = array();

// Menampilkan pesan error milik satu field (jika ada)
function showError($errors, $name)
{
    if (isset($errors[$name]))
        echo '<span class="error">' . htmlspecialchars($errors[$name]) . '</span>';
}

// Mengambil nilai isian sebelumnya dari $_POST (kosong jika belum ada)
function old($name)
{
    if (isset($_POST[$name]) && is_string($_POST[$name]))
        return htmlspecialchars($_POST[$name], ENT_QUOTES);
    return '';
}

// Daftar pilihan state (value => teks)
$states = array(
    1 => 'Australian Capital Territory',
    2 => 'Queensland',
    3 => 'Victoria',
    4 => 'New South Wales',
    5 => 'Tasmania',
    6 => 'South Australia',
    7 => 'Western Australia',
    8 => 'Northern Territory'
);
$selectedState = old('state');
?>
<fieldset>
    <legend>Person Details</legend>
    <form name="myForm" action="processData_form.php" method="POST">
        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" name="surname" id="surname" size="31" value="<?php echo old('surname'); ?>"/>
            <?php showError($errors, 'surname'); ?>
        </div>
        <div class="field">
            <label for="email">Email address</label>
            <input type="text" name="email" id="email" size="31" value="<?php echo old('email'); ?>"/>
            <?php showError($errors, 'email'); ?>
        </div>
        <div class="field">
            <label for="passwd">Password</label>
            <input type="password" name="passwd" id="passwd" size="31"/>
            <?php showError($errors, 'passwd'); ?>
        </div>
        <div class="field">
            <label for="address">Street Address</label>
            <textarea name="address" id="address" rows="3" cols="22"><?php echo old('address'); ?></textarea>
            <?php showError($errors, 'address'); ?>
        </div>
        <div class="field">
            <label for="state">State</label>
            <select name="state" id="state">
                <option value="-1" <?php if ($selectedState === '' || $selectedState === '-1') echo 'selected'; ?>>[choose your state]</option>
                <?php foreach ($states as $value => $name) { ?>
                <option value="<?php echo $value; ?>" <?php if ($selectedState === (string)$value) echo 'selected'; ?>><?php echo $name; ?></option>
                <?php } ?>
            </select>
            <?php showError($errors, 'state'); ?>
        </div>
        <div class="field">
            <input type="hidden" name="country" value="Australia"/>
        </div>
        <div class="field">
            <label>Gender</label>
            <input type="radio" name="sex" value="male" <?php if (old('sex') === 'male') echo 'checked'; ?> />Male
            <input type="radio" name="sex" value="female" <?php if (old('sex') === 'female') echo 'checked'; ?> />Female
            <?php showError($errors, 'sex'); ?>
        </div>
        <div class="field">
            <label for="vegetarian">Vegetarian?</label>
            <input type="checkbox" name="vegetarian" id="vegetarian" <?php if (isset($_POST['vegetarian'])) echo 'checked'; ?> />
        </div>
        <div class="field">
            <label>&nbsp;</label>
            <input type="submit" value="Submit" name="submit"/><input type="reset" value="Reset" name="reset"/>
        </div>
    </form>
</fieldset>
