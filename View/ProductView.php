<?php
    include_once('../Model/Connection.php');
    $id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM products WHERE id='$id'");
	$stmt->execute();
	$users = $stmt->fetchAll();

    $stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id='$id'");
	$stmt->execute();
	$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    
<h2><a href="../View/index.php">Home Page</a></h2>

    <?php
    foreach($users as $user) {
       
        echo"<div class='container mt-3 border-primary'>";
            echo"<h2>Product View Page</h2>";
            echo"<div class='card' style='width:400px'>";
                echo"<img class='card-img-top' style='width:100%;' src='../Model/file/".$user['main_image']."'/>";
                echo"<div class='card-body'>";
                echo"<h4 class='card-title'>Product id: ".$user['id']."</h4>";
                    echo"<h4 class='card-title'>Product Name: ".$user['title']."</h4>";
                    echo"<p class='card-text'>Price: ".$user['price']."</p>";
                    echo"<p class='card-text'>Discount: ".$user['discount_price']."</p>";
                    echo"<p class='card-text'>".$user['short_desc']."</p>";
                    echo"<p class='card-text'>Details: ".$user['long_desc']."</p>";
                    echo"<p class='card-text'>Status: ".$user['status']."</p>";
                    echo"<p class='card-text'>Add Product time: ".$user['created_at']."</p>";
                    echo"<p class='card-text'>Update Last time:  ".$user['updated_at']."</p>";
            echo"</div>";
        echo"</div>";
    echo"</div>";
    }
    ?>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-4 row-cols-md-3">
            <?php foreach ($images as $user) {?>
                <div class="col py-2">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" onclick='<?="confirmDelete(\"{$user['id']}\")'"?>' class="close" data-dismiss="modal" aria-label="Close">
                                &times;
                            </button>
                        </div>
                        <!-- <div class="modal-body"> -->
                            <img style="height:160px;  margin-left: 25px; width:210px;"src="../Model/<?php echo $user['image_path'];?>" alt="Product Image">
                        <!-- </div> -->
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    

    <script src="../JS/Delete_image.js"></script>
</body>
</html>