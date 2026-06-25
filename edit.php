<?php
include "../../config/database.php";

$id = $_GET['id'];

$data = mysqli_query(
$conn,
"SELECT * FROM participants WHERE id='$id'"
);

$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];

    mysqli_query($conn,
    "UPDATE participants
    SET
    nama='$nama',
    email='$email',
    telepon='$telepon'
    WHERE id='$id'");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Peserta</title>
</head>
<body>

<h2>Edit Peserta</h2>

<form method="POST">

    Nama <br>
    <input type="text"
           name="nama"
           value="<?= $row['nama']; ?>"
           required>

    <br><br>

    Email <br>
    <input type="email"
           name="email"
           value="<?= $row['email']; ?>"
           required>

    <br><br>

    Telepon <br>
    <input type="text"
           name="telepon"
           value="<?= $row['telepon']; ?>"
           required>

    <br><br>

    <button type="submit" name="update">
        Update
    </button>

</form>

<br>

<a href="index.php">Kembali</a>

</body>
</html>