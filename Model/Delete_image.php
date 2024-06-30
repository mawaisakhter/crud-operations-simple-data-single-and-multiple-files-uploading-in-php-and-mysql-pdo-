<?php
    include_once('Connection.php');
    
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM product_images WHERE id='$id'");
    $stmt->execute();
    $images = $stmt->fetch(PDO::FETCH_ASSOC);

    $pid = $images['product_id'];
   
    if(isset($_GET['id'])){  

        $sql = "DELETE FROM product_images WHERE id='$id'";
        $conn->exec($sql);        
   }
//    $conn = null;
   header("location: ../View/ProductView.php?id=$pid");

?>