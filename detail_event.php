<?php
// 1. BARIS INI UNTUK HUBUNGIN KE DATABASE MARIA (Project Manager)
// Baris ini sengaja dimatikan dulu (pakai tanda //) supaya halamanmu tidak error saat ditest sendirian.
// require_once '../config/database.php';


// 2. DATA EVENT (Sementara pakai data buatan dulu, nanti kalau database Maria sudah siap, bagian ini dihapus)
$event = [
    'id_event' => 1,
    'nama_event' => 'Seminar Informatika Kelompok 9',
    'tanggal' => '2026-08-25',
    'lokasi' => 'Aula Kampus Al Mahrusiyah',
    'deskripsi' => 'Ini adalah acara seru buat belajar bikin web dari nol. Jangan sampai kelewatan ya!',
    'poster' => null // Kita kosongkan dulu supaya pakai gambar default di bawah
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Detail Event - Tugas Baro</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; padding: 20px; margin: 0; }
        .kotak { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: 30px auto; box-shadow: 0px 0px 10px #ccc; }
        .tombol { display: block; text-align: center; background: green; color: white; padding: 10px; text-decoration: none; border-radius: 5px; margin-top: 20px; font-weight: bold; }
        .tombol:hover { background: #006400; }
        .kembali { display: inline-block; margin-bottom: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

    <div class="kotak">
        <a href="../index.php" class="kembali">&larr; Kembali ke Beranda</a>

        <?php 
        $gambar_poster = !empty($event['poster']) ? '../assets/images/' . $event['poster'] : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500';
        ?>
        <img src="<?= $gambar_poster; ?>" width="100%" style="border-radius: 5px;" alt="Poster">

        <h1><?= $event['nama_event']; ?></h1>

        <p><strong>📅 Tanggal:</strong> <?= date('d F Y', strtotime($event['tanggal'])); ?></p>
        <p><strong>📍 Lokasi:</strong> <?= $event['lokasi']; ?></p>
        <p><strong>📝 Deskripsi:</strong> <?= $event['deskripsi']; ?></p>

        <a href="../registration/register.php?id_event=<?= $event['id_event']; ?>" class="tombol">Daftar Event Sekarang</a>
    </div>

</body>
</html>