<?php
    include_once('../Model/Connection.php');
  
    $stmt = $conn->prepare("SELECT * FROM products");
	$stmt->execute();
	$test = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($test);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Crud Operation</title>
</head>
<body>
    <h1>View Page</h1>
    <h2><a href="../Model/InsertData.php">Add Product</a></h2>
    
    <form method="post" action="">
        <label for="search">Search:</label>
        <input type="text" id="search" autocomplete="off">
        <!-- <input type="submit" value="Submit"> -->
    </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                    <th scope="col">Action</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
             <tbody id='table-data'>
                <?php
                    foreach($test as $user) {
                        $dt = ($user['status'] == 1) ? "<a href='../Model/Activate.php?id=".$user['id']."'><button type='button' 
                        class='btn btn-outline-success'>Enable</button></a>" : "<a href='../Model/Deactivate.php?id=".$user['id']."'><button type='button' 
                        class='btn btn-outline-danger'>Disable</button></a>" ;
                        echo"<tr >";
                            echo"<th>".$user['id']."</th>";
                            echo"<td>".$user['title']."</td>";
                            echo"<td>".$user['price']."</td>";
                            echo"<td>".$dt."</td>";
                            echo"<td>".'<img style="width:50px; height:50px" src="../Model/file/'.$user['main_image'].'"/>'."</td>";
                            echo "<td><a href='ProductView.php?id=".$user['id']."' class='btn btn-success btn-sm'>View</a></td>";
                            echo "<td><a href='../Model/Update.php?id=".$user['id']."' class='btn btn-primary btn-sm'>Edit</a></td>";
                            echo "<td><button onclick='confirmDelete(\"{$user['id']}\")' class='btn btn-danger btn-sm'>Delete</button></td>";
                        echo"</tr>";
                    }
                ?>      
            </tbody>
        </table>

    <script src="../JS/Delete.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../JS/jquery.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    // Live Search
     $("#search").on("keyup",function(){
       var search_term = $(this).val();

       $.ajax({
         url: "../Model/Serach.php",
         type: "POST",
         data : {search:search_term },
         success: function(data) {
           $("#table-data").html(data);
         }
       });
     });
  });

</script>
</body>
</html>