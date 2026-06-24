<?php

include '../config/database.php';

/* cek apakah user melakukan pencarian */
if(isset($_GET['keyword'])){

    $keyword = $_GET['keyword'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM events WHERE nama_event LIKE '%$keyword%'"
    );

}else{

    $query = mysqli_query(
        $conn,
        "SELECT * FROM events"
    );

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Event</title>
     <style>

    body{
        font-family: Arial;
        margin: 40px;
    }

    .card{
        border: 1px solid gray;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 10px;
    }
    input{
        padding: 8px;
    }

    button{
        padding: 8px;
    }

    </style>
</head>

<body>

    <h2>Daftar Event</h2>
    <form method="GET">

    <input type="text"
           name="keyword"
           placeholder="Cari event">

    <button type="submit">Cari</button>

</form>

    <?php while($event = mysqli_fetch_assoc($query)){ ?>
    <div class="card">

        <h3><?php echo $event['NAMA_event']; ?></h3>

        <p>
             Tanggal :
            <?php echo $event['TANGGAL']; ?>
        </p>

        <p>
            Lokasi :
            <?php echo $event['Location']; ?>
        </p>

        <p>
            Deskripsi :
            <?php echo $event['Deskripsi']; ?>
        </p>
        

        <hr>

    <?php } ?>

</body>
</html>