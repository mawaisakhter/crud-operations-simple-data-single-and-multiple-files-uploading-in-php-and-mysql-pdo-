<?php
    include_once('Connection.php');

    if (isset($_GET['id'])){

    $id = $_GET['id'];
    $status = "0"; 
    $current_date = date('Y-m-d H:i:sa');
    
    $sql = "UPDATE products SET status='$status', updated_at='$current_date' WHERE id='$id'";
    $affected_row = $conn->exec($sql);

    }

    header('location: ../View/index.php');
?>