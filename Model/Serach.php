<?php
$search_value = $_POST["search"];
// echo $search_value;
include_once('Connection.php');

    $stmt = $conn->prepare("SELECT * FROM products WHERE title LIKE '%{$search_value}%' OR id LIKE '%{$search_value}%' OR price LIKE '%{$search_value}%' ");
    $stmt->execute();
	$test = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($test) > 0 ){
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
            echo "<td><a href='ProductView.php?id=".$user['id']."' class='btn btn-secondary btn-sm'>View</a></td>";
            echo "<td><a href='../Model/Update.php?id=".$user['id']."' class='btn btn-success btn-sm'>Edit</a></td>";
            echo "<td><button onclick='confirmDelete(\"{$user['id']}\")' class='btn btn-danger btn-sm'>Delete</button></td>";
        echo"</tr>";
    }
}else{
    echo "<td colspan='8'>No Record Found.</td>";
}

?>
