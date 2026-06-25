<?php
include "../../config/database.php";

$id = $_GET['id'];

mysqli_query(
$conn,
"DELETE FROM participants WHERE id='$id'"
);

header("Location:index.php");
?>