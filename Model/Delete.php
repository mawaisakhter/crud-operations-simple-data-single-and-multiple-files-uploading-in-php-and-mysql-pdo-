<?php
    include_once('Connection.php');

    if(isset($_GET['id'])){  
        $id = $_GET['id'];
        // echo $productId;

        $stmt = $conn->prepare("DELETE FROM product_images WHERE product_id = ?");
        $stmt->execute([$id]);

        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);

        echo "Product deleted successfully.";
    } else {
        echo "Invalid request.";
    }
   $conn = null;
   header('location: ../View/index.php');
?>