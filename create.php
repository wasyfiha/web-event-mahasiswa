<?php
include "../../config/database.php";

if(isset($_POST['simpan'])){

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];

    mysqli_query($conn,
    "INSERT INTO participants(nama,email,telepon)
    VALUES('$nama','$email','$telepon')");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peserta</title>
</head>
<body>

<h2>Tambah Peserta</h2>

<form method="POST">

    Nama <br>
    <input type="text" name="nama" required>
    <br><br>

    Email <br>
    <input type="email" name="email" required>
    <br><br>

    Telepon <br>
    <input type="text" name="telepon" required>
    <br><br>

    <button type="submit" name="simpan">
        Simpan
    </button>

</form>

<br>

<a href="index.php">Kembali</a>

</body>
</html>