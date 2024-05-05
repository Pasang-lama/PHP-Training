<?php
include("dbconnection.php");



// $listsql = "CREATE TABLE todo_list (
//     id INT PRIMARY KEY AUTO_INCREMENT,
//     title VARCHAR(100) NOT NULL,
//     description TEXT,
//     status VARCHAR(50) NOT NULL
// )";

function executeQuery ($connection, $sql , $message) {
     try{
        if(mysqli_query($connection,$sql)){
            echo $message;
        } 
     }catch(err){
         echo err;
     }
}
// executeQuery($connection, $listsql , "table create bayo" );
// print_r($_POST);
if(isset($_POST["Submited"]) && !isset($_GET["eid"])){
    $title = $_POST['title'];
    $des = $_POST['description'];
    $status = $_POST['status'];
    $insertsql = "INSERT INTO todo_list(title, description, status) VALUE('$title',   '$des' ,     '$status')";
    executeQuery($connection, $insertsql , "table ma data chereu" );
    header("Location: http://192.168.6.121/cnfrontend/pk/");
        exit();
    // mysqli_query($connection, $insertsql);
    // echo "data inserted";
} elseif (isset($_POST["Submited"]) && isset($_GET["eid"]))  {
    $eid = $_GET["eid"] ;
        $title = $_POST['title'];
        $des = $_POST['description'];
        $status = $_POST['status'];
        $udatesql = "UPDATE  todo_list
         SET title = '$title', description = '$des', status= '$status'
          WHERE id =  $eid " ;
        mysqli_query($connection, $udatesql);
      header("Location: http://192.168.6.121/cnfrontend/pk/");
      exit();
}
if(isset($_GET["did"])){
    $did =  $_GET["did"];
    $delete = "DELETE FROM todo_list WHERE id = $did  ";
    mysqli_query($connection, $delete);
}
if(isset($_GET["eid"])){
    $eid = $_GET["eid"] ;
    $fetcholddata = "SELECT * FROM todo_list WHERE id = $eid";
   $o_result =  mysqli_query($connection, $fetcholddata);
   $olddata = mysqli_fetch_assoc(   $o_result);
 
 }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo List</title>
</head>

<body>
    <form action="" method="post">
        <fieldset>
            <legend>
                Create TO TO List
            </legend>
            <label for="taskname">Title:</label> <br>
            <input type="text" name="title" id="taskname" placeholder="Enter Title"
                value="<?= (isset( $olddata['title'])? $olddata['title']: "")?>"> <br>
            <label for="description">Title:</label> <br>
            <textarea name="description" id="description" placeholder="Description" cols="30"
                rows="5"><?= (isset($olddata['description'])?$olddata['description'] : " " )?></textarea> <br>
            <label for="status">Title:</label> <br>
            <select name="status" id="status">
                <option value="Completed"
                    <?=(isset($olddata['status']) && $olddata['status'] == 'Completed') ? 'selected' : '' ?>>Completed
                </option>
                <option value="Pending"
                    <?=(isset($olddata['status']) && $olddata['status']  == 'Pending') ? 'selected' : '' ?>>Pending
                </option>
                <option value="Ongoing"
                    <?=(isset($olddata['status']) && $olddata['status'] == 'Ongoing') ? 'selected' : '' ?>>Ongoing
                </option>
            </select> <br>
            <button type="submit" name="Submited">Submit Now</button>
        </fieldset>
    </form>
    <table border="1" style="width:100%;">
        <tr>
            <th>S.N</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php 
        $todolistdata = "SELECT * FROM todo_list";
        $result = mysqli_query($connection, $todolistdata );
        while($data = mysqli_fetch_assoc( $result)){
        ?>
        <tr>
            <td> <?= $data["id"]?></td>
            <td><?= $data["title"]?></td>
            <td><?= $data["description"]?></td>
            <td><?= $data["status"]?></td>
            <td><a href="http://192.168.6.121/cnfrontend/pk/?did=<?= $data['id']?>">Delete</a>
                <a href="http://192.168.6.121/cnfrontend/pk/?eid=<?= $data['id']?>">edit</a>
            </td>
        </tr>

        <?php   }   ?>
    </table>
</body>

</html>