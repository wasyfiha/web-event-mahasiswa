<?php
include "../../config/database.php";

$data = mysqli_query($conn, "SELECT * FROM participants");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Peserta</title>
</head>
<body>

<h2>Data Peserta</h2>

<a href="create.php">Tambah Peserta</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Aksi</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['nama']; ?></td>
        <td><?= $row['email']; ?></td>
        <td><?= $row['telepon']; ?></td>
        <td>
            <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>
            |
            <a href="delete.php?id=<?= $row['id']; ?>"
               onclick="return confirm('Yakin hapus?')">
               Hapus
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>