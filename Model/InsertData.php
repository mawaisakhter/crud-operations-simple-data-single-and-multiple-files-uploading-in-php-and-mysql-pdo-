<?php
    include_once('Connection.php');
    
    if(isset($_REQUEST['submit'])){
        $title = $_REQUEST['title'];
        $price = $_REQUEST['price'];
        $discount_price = $_REQUEST['discount_price'];
        $short_desc = $_REQUEST['short_desc'];
        $long_desc = $_REQUEST['long_desc'];    
        $file_name = $_FILES['fileToUpload']['name'];  // get name
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'file/'.$file_name);

        if (isset($_REQUEST['true'])) {
           $status = "1";
        }else {
            $status = "0";
        }

        $sql = "INSERT INTO products (title,price,discount_price,short_desc,long_desc,main_image,status) VALUES ('$title','$price','$discount_price','$short_desc','$long_desc','$file_name','$status')";
        $affected_row = $conn->exec($sql);
        
        // Calculate the remaining upload 
        $totalImages = count($_FILES['product_images']['tmp_name']);
        
        // $remaining_uploads = $upload_limit - $num_uploaded_images;
        if ($totalImages > 8) {
            echo "You can't upload more than 10 images.";
            exit;
        }

        $productId = $conn->lastInsertId();
        echo $productId;
        $uploadDir = '../Model/uploads/'; 
        foreach ($_FILES['product_images']['tmp_name'] as $key => $tmp_name) {
            $uploadFile = $uploadDir . basename($_FILES['product_images']['name'][$key]);
            move_uploaded_file($tmp_name, $uploadFile);
            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
            $stmt->execute([$productId, $uploadFile]);
        }
        echo '<script>alert("Your Prodcut add is successufully !!!")</script>';

        header('location: ../View/index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Summernote CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <title>Insert data </title>
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
                    <h3 class="text-center mt-3">Product</h3>
                    <div class="row mt-4">
                        <div class="form-group col">
                            <label for="title">Product Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter Product Tilte">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="price">Product Price</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="Enter the product Price">
                        </div>
                        <div class="form-group col">
                            <label for="discount_price">Discount</label>
                            <input type="number" class="form-control" name="discount_price" id="discount_price" placeholder="Enter discount on prodcut ">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="short_desc">Short Description</label>                            
                            <textarea class="form-control" name="short_desc" id="short_desc"cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="long_desc">Long Description</label>
                            <textarea id="summernote" name="long_desc"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="fileToUpload">Main Image</label>
                            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                    </div>
                    <img class='card-img-top mt-2' id="preview" style='width:24%;'/>

                    <div class="row mt-3">
                        <div class="form-group col">
                            <label for="product_images">Multiple Images:</label>
                            <input type="file"  class="form-control" name="product_images[]" id="product_images" multiple accept="image/*" >
                        </div>
                    </div>
                    <div class="row mt-5" id="image-preview-container"></div>
                    
                    <div class="row mt-3">
                        <div class="form-group col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="true" value="" id="status" />
                                <label class="form-check-label" for="status">Status</label>
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center mt-4 col">
                            <button type="submit" class="btn btn-primary w-50" name="submit">Add Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../JS/Summer.js"></script>
    <script src="../JS/Main_Preview.js"></script>
    <script src="../JS/Many_Preview.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>