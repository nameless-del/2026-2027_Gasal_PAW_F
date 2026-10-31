<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'penjualan';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = mysqli_connect($host, $user, $pass, $db);
    mysqli_set_charset($koneksi, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('Koneksi database gagal. Pastikan MySQL aktif dan database "penjualan" sudah diimport (file penjualan.sql).');
}

$halaman = basename($_SERVER['SCRIPT_NAME']);


// KODE HTML

function tampilHeader($judul)
{
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($judul); ?></title>
    <style>
        body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 14px; color: #333; margin: 0; }
        .container { width: 900px; max-width: 94%; margin: 20px auto; }
        h1 { font-size: 24px; font-weight: normal; color: #337ab7; margin: 0; }
        .judul { overflow: hidden; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 18px; }
        .judul h1 { float: left; }
        .judul .btn { float: right; }

        .btn { display: inline-block; padding: 6px 12px; font-size: 13px; font-family: inherit; color: #fff;
               border: 1px solid transparent; border-radius: 3px; cursor: pointer; text-decoration: none; }
        .btn-tambah, .btn-simpan { background: #5cb85c; border-color: #4cae4c; }
        .btn-edit { background: #e8590c; border-color: #d9480f; }
        .btn-hapus, .btn-batal { background: #d9232d; border-color: #c21b25; }
        .btn:hover { opacity: 0.85; }

        table { width: 100%; border-collapse: collapse; }
        th { background: #d9edf7; text-align: left; padding: 8px; border: 1px solid #ddd; }
        td { padding: 8px; border: 1px solid #ddd; vertical-align: middle; }
        form.inline { display: inline; }

        .alert { padding: 10px 14px; border-radius: 3px; margin-bottom: 14px; }
        .alert ul { margin: 0; padding-left: 18px; }
        .sukses { background: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; }
        .gagal { background: #f2dede; color: #a94442; border: 1px solid #ebccd1; }

        .form-baris { overflow: hidden; margin-bottom: 14px; }
        .form-baris label { float: left; width: 150px; text-align: right; font-weight: bold; padding: 8px 15px 0 0; }
        .form-baris input { width: 340px; padding: 6px 12px; border: 1px solid #ccc; border-radius: 3px;
                            font-size: 14px; font-family: inherit; }
        .form-tombol { margin-left: 165px; }
    </style>
</head>
<body>
<div class="container">
<?php
}

function tampilFooter()
{
    ?>
</div>
</body>
</html>
<?php
}

function validasiSupplier($nama, $telp, $alamat)
{
    $errors = [];
    if ($nama === '') {
        $errors[] = 'Nama wajib diisi.';
    } elseif (strlen($nama) > 100) {
        $errors[] = 'Nama maksimal 100 karakter.';
    }
    if ($telp === '') {
        $errors[] = 'Telp wajib diisi.';
    } elseif (!preg_match('/^[0-9]{1,12}$/', $telp)) {
        $errors[] = 'Telp hanya boleh berisi angka (maksimal 12 digit).';
    }
    if ($alamat === '') {
        $errors[] = 'Alamat wajib diisi.';
    }
    return $errors;
}


$aksi = (isset($_GET['aksi']) && is_string($_GET['aksi'])) ? $_GET['aksi'] : '';


// SOAL 4 : HALAMAN TAMBAH DATA BARU                     

if ($aksi === 'tambah') {
    $judul  = 'Tambah Data Master Supplier Baru';
    $errors = [];
    $nama = $telp = $alamat = '';

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama   = isset($_POST['nama'])   && is_string($_POST['nama'])   ? trim($_POST['nama'])   : '';
        $telp   = isset($_POST['telp'])   && is_string($_POST['telp'])   ? trim($_POST['telp'])   : '';
        $alamat = isset($_POST['alamat']) && is_string($_POST['alamat']) ? trim($_POST['alamat']) : '';

        $errors = validasiSupplier($nama, $telp, $alamat);

        if (!$errors) {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'sss', $nama, $telp, $alamat);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header('Location: ' . $halaman . '?pesan=tersimpan');
            exit;
        }
    }

    tampilHeader($judul);
    ?>
<div class="judul">
    <h1>Tambah Data Master Supplier Baru</h1>
</div>

<?php if ($errors) { ?>
    <div class="alert gagal">
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<form action="<?php echo $halaman; ?>?aksi=tambah" method="POST">
    <div class="form-baris">
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" placeholder="Nama" maxlength="100"
               value="<?php echo htmlspecialchars($nama); ?>">
    </div>
    <div class="form-baris">
        <label for="telp">Telp</label>
        <input type="text" name="telp" id="telp" placeholder="telp" maxlength="12"
               value="<?php echo htmlspecialchars($telp); ?>">
    </div>
    <div class="form-baris">
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" id="alamat" placeholder="alamat"
               value="<?php echo htmlspecialchars($alamat); ?>">
    </div>
    <div class="form-tombol">
        <button type="submit" class="btn btn-simpan">Simpan</button>
        <a href="<?php echo $halaman; ?>" class="btn btn-batal">Batal</a>
    </div>
</form>
<?php
    tampilFooter();
    exit;
}


// SOAL 5 : HALAMAN EDIT DATA                            

if ($aksi === 'edit') {
    $judul  = 'Edit Data Master Supplier';
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
    } else {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
    }
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id === false || $id < 1) {
        header('Location: ' . $halaman . '?pesan=tidakada');
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "SELECT nama, telp, alamat FROM supplier WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if (!$data) {
        header('Location: ' . $halaman . '?pesan=tidakada');
        exit;
    }
    $nama   = $data['nama'];
    $telp   = $data['telp'];
    $alamat = $data['alamat'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama   = isset($_POST['nama'])   && is_string($_POST['nama'])   ? trim($_POST['nama'])   : '';
        $telp   = isset($_POST['telp'])   && is_string($_POST['telp'])   ? trim($_POST['telp'])   : '';
        $alamat = isset($_POST['alamat']) && is_string($_POST['alamat']) ? trim($_POST['alamat']) : '';

        $errors = validasiSupplier($nama, $telp, $alamat);

        if (!$errors) {
            $stmt = mysqli_prepare($koneksi, "UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'sssi', $nama, $telp, $alamat, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header('Location: ' . $halaman . '?pesan=diperbarui');
            exit;
        }
    }

    tampilHeader($judul);
    ?>
<div class="judul">
    <h1>Edit Data Master Supplier</h1>
</div>

<?php if ($errors) { ?>
    <div class="alert gagal">
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<form action="<?php echo $halaman; ?>?aksi=edit" method="POST">
    <input type="hidden" name="id" value="<?php echo (int)$id; ?>">
    <div class="form-baris">
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" placeholder="Nama" maxlength="100"
               value="<?php echo htmlspecialchars($nama); ?>">
    </div>
    <div class="form-baris">
        <label for="telp">Telp</label>
        <input type="text" name="telp" id="telp" placeholder="telp" maxlength="12"
               value="<?php echo htmlspecialchars($telp); ?>">
    </div>
    <div class="form-baris">
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" id="alamat" placeholder="alamat"
               value="<?php echo htmlspecialchars($alamat); ?>">
    </div>
    <div class="form-tombol">
        <button type="submit" class="btn btn-simpan">Update</button>
        <a href="<?php echo $halaman; ?>" class="btn btn-batal">Batal</a>
    </div>
</form>
<?php
    tampilFooter();
    exit;
}



// SOAL 6 : PROSES HAPUS DATA                            

if ($aksi === 'hapus') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . $halaman);
        exit;
    }

    $id = filter_var(isset($_POST['id']) ? $_POST['id'] : '', FILTER_VALIDATE_INT);
    if ($id === false || $id < 1) {
        header('Location: ' . $halaman . '?pesan=tidakada');
        exit;
    }

    try {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM supplier WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $jumlah = mysqli_stmt_affected_rows($stmt);   
        mysqli_stmt_close($stmt);

        header('Location: ' . $halaman . '?pesan=' . ($jumlah > 0 ? 'terhapus' : 'tidakada'));
    } catch (mysqli_sql_exception $e) {
        header('Location: ' . $halaman . '?pesan=' . ($e->getCode() == 1451 ? 'gagalhapus' : 'gagal'));
    }
    exit;
}


// SOAL 3 : TAMPILAN DAN AMBIL DATA DARI DATABASE        

$judul = 'Data Master Supplier';

$daftarPesan = [
    'tersimpan'  => ['sukses', 'Data supplier berhasil ditambahkan.'],
    'diperbarui' => ['sukses', 'Data supplier berhasil diperbarui.'],
    'terhapus'   => ['sukses', 'Data supplier berhasil dihapus.'],
    'gagalhapus' => ['gagal',  'Supplier tidak dapat dihapus karena masih dipakai oleh data barang.'],
    'tidakada'   => ['gagal',  'Data supplier tidak ditemukan.'],
    'gagal'      => ['gagal',  'Terjadi kesalahan saat memproses data.']
];
$kode  = (isset($_GET['pesan']) && is_string($_GET['pesan'])) ? $_GET['pesan'] : '';
$pesan = isset($daftarPesan[$kode]) ? $daftarPesan[$kode] : null;

$hasil = mysqli_query($koneksi, "SELECT id, nama, telp, alamat FROM supplier ORDER BY id ASC");

tampilHeader($judul);
?>
<div class="judul">
    <h1>Data Master Supplier</h1>
    <!-- SOAL 4: tombol Tambah Data membuka halaman tambah data baru -->
    <a href="<?php echo $halaman; ?>?aksi=tambah" class="btn btn-tambah">Tambah Data</a>
</div>

<?php if ($pesan) { ?>
    <div class="alert <?php echo $pesan[0]; ?>"><?php echo htmlspecialchars($pesan[1]); ?></div>
<?php } ?>

<table>
    <tr>
        <th width="50">No</th>
        <th>Nama</th>
        <th>Telp</th>
        <th>Alamat</th>
        <th width="140">Tindakan</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($hasil)) {
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo htmlspecialchars($row['nama']); ?></td>
        <td><?php echo htmlspecialchars($row['telp']); ?></td>
        <td><?php echo htmlspecialchars($row['alamat']); ?></td>
        <td>
            <!-- SOAL 5: tombol Edit membuka halaman edit sesuai id supplier -->
            <a href="<?php echo $halaman; ?>?aksi=edit&amp;id=<?php echo (int)$row['id']; ?>" class="btn btn-edit">Edit</a>

            <!-- SOAL 6: tombol Hapus menampilkan popup konfirmasi sebelum data dihapus -->
            <form action="<?php echo $halaman; ?>?aksi=hapus" method="POST" class="inline"
                  onsubmit="return confirm('Anda yakin akan menghapus supplier ini?');">
                <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                <button type="submit" class="btn btn-hapus">Hapus</button>
            </form>
        </td>
    </tr>
    <?php } ?>
    <?php if ($no === 1) { ?>
    <tr>
        <td colspan="5">Belum ada data supplier.</td>
    </tr>
    <?php } ?>
</table>
<?php tampilFooter(); ?>
