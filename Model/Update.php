<?php
    include_once('Connection.php');

    // echo "<pre>";
    // print_r($_FILES['product_images']['name'][0]);
    // exit();
    $id = $_GET['id'];
    
    $stmt = $conn->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->execute(array(':id' => $id));
    $product = $stmt->fetch();

    $stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id='$id'");
	$stmt->execute();
	$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT COUNT(*) AS num_images FROM product_images WHERE product_id = '$id'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $num_uploaded_images = $row['num_images'];

    // $upload_limit = 8;

        // $totalImages = count($_FILES['product_images']['tmp_name']);
        
    if(isset($_REQUEST['submit'])){

        $title = $_REQUEST['title'];
        $price = $_REQUEST['price'];
        $discount_price = $_REQUEST['discount_price'];
        $short_desc = $_REQUEST['short_desc'];
        $long_desc = $_REQUEST['long_desc'];
        $current_date = date('Y-m-d H:i:sa');

        $file_name = $_FILES['fileToUpload']['name'];  // get name
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'file/'.$file_name);

        if (isset($_REQUEST['true'])) {
            $status = "1";
         }else {
             $status = "0";
         }

         if (!empty($_FILES['fileToUpload']['name'])) {
            $sql = "UPDATE products SET title='$title', price='$price', discount_price='$discount_price', short_desc='$short_desc', long_desc='$long_desc', main_image='$file_name', status='$status', updated_at='$current_date' WHERE id='$id'";
            $affected_row = $conn->exec($sql);
            // echo '<script>alert("Your Prodcut add is successufully !!!")</script>';
        } else {
            $sql = "UPDATE products SET title='$title', price='$price', discount_price='$discount_price', short_desc='$short_desc', long_desc='$long_desc',status='$status', updated_at='$current_date' WHERE id='$id'";
            $affected_row = $conn->exec($sql);
            // echo '<script>alert("Your Prodcut add is successufully !!!")</script>';
        }

            // $productId = $conn->lastInsertId();
            
            if ($_FILES['product_images']['name'][0] != '' || $_FILES['product_images']['name'][0] != NULL) {
                $uploadDir = 'uploads/'; 
                foreach ($_FILES['product_images']['tmp_name'] as $key => $tmp_name) {
                    $uploadFile = $uploadDir . basename($_FILES['product_images']['name'][$key]);
                    move_uploaded_file($tmp_name, $uploadFile);
                    $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$id, $uploadFile]);
                }
            }
       
         
        header('location: ../View/index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Summernote CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>


    <title>Update Product </title>
    <style>
        .h {
            margin-top: 20px;
            margin-left: 310px;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2><a href="../View/index.php">Home Page</a></h2>
        <div class="row">
            <div class="col-sm-6 border h p-4 ">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h3 class="text-center mt-3">Edit Product</h3>
                    <div class="row mt-4">
                        <div class="form-group col">
                            <label for="title">Product Title</label>
                            <input type="text" class="form-control" value="<?php echo $product['title'] ?>" name="title" id="title" placeholder="Enter Product Tilte">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="price">Product Price</label>
                            <input type="number" class="form-control" value="<?php echo $product['price'] ?>" name="price" id="price" placeholder="Enter the product Price">
                        </div>
                        <div class="form-group col">
                            <label for="discount_price">Discount</label>
                            <input type="number" class="form-control" value="<?php echo $product['discount_price'] ?>" name="discount_price" id="discount_price" placeholder="Enter discount on prodcut ">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="short_desc">Short Description</label>
                            <textarea class="form-control" name="short_desc" cols=40 rows=3> <?php echo $product['short_desc'] ; ?></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="long_desc">Long Description</label>
                            <textarea id="summernote" name="long_desc"><?php echo $product['long_desc']; ?></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="fileToUpload">Upload Image</label>
                            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                    </div>
                    <img class='card-img-top mt-2' id="preview" src="./file/<?php echo $product['main_image']; ?>" style='width:24%;'/>

                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="product_images">Multiple Images:</label>
                            <input type="file"  class="form-control" name="product_images[]" id="product_images" multiple accept="image/*" >
                        </div>
                    </div>                    
                    <div class="row mt-5" id="image-preview-container" ></div>
                    <div class="row mt-3">
                        <div class="container">
                            <div class="row row-cols-1 row-cols-sm-4 row-cols-md-6">
                                <?php foreach ($images as $user) {?>
                                    <div class="col py-2">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" onclick='<?="confirmDelete(\"{$user['id']}\")'"?>' class="close" data-dismiss="modal" aria-label="Close">&times;
                                                </button>
                                            </div>
                                        <!-- <div class="modal-body"> -->
                                                <img style="height:60px;  margin-le 20px; width:60px;"src="../Model/<?php echo $user['image_path'];?>" alt="Product Image">
                                        <!-- </div> -->
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <div class="form-check">
                                <input class="form-check-input"<?php if ($product['status'] == 1) {echo"checked";}?> type="checkbox" name="true" value="" id="" />
                                <label class="form-check-label" for=""> Status </label>
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center mt-4 col">
                            <button type="submit" class="btn btn-primary w-50" name="submit">Update Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../JS/Summer.js"></script>
    <script src="../JS/Main_Preview.js"></script>
    <script src="../JS/Many_Preview.js"></script>
    <script src="../JS/Delete_image2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>