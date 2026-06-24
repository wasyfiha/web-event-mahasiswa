<?php
include '../../config/database.php';

if(isset($_POST['submit'])){

    $nama_event = $_POST['nama_event'];
    $tanggal = $_POST['tanggal'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];

    $query = "INSERT INTO events
              (nama_event, tanggal, lokasi, deskripsi)
              VALUES
              ('$nama_event','$tanggal','$lokasi','$deskripsi')";

    mysqli_query($conn, $query);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Event</title>
</head>
<body>

<h2>Tambah Event</h2>

<form method="POST">
       Nama Event <br>
    <input type="text" name="nama_event" required>
    <br><br>

    Tanggal <br>
    <input type="date" name="tanggal" required>
    <br><br>

    Lokasi <br>
    <input type="text" name="lokasi" required>
    <br><br>

    Deskripsi <br>
    <textarea name="deskripsi"></textarea>
    <br><br>

    <button type="submit" name="submit">
        Simpan
    </button>

</form>

</body>
</html>