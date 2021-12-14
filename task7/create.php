<?php
session_start();
require 'dbConnect.php';
require 'chekLogin.php';

function Clean($input){
    return   strip_tags(trim($input));
}


if($_SERVER['REQUEST_METHOD'] == "POST"){

    $title      = Clean($_POST['title']);
    $desc       = Clean($_POST['desc']);
    $sDate      = $_POST['sDate'];
    $eDate      = $_POST['eDate'];


    $fileName   = $_FILES['image']['name'];
    $fileTmp    = $_FILES['image']['tmp_name'];

    $AllowExtention = array("jpg","png","jpeg");

    $tmp = explode('.',$fileName);
    $fileExtention = strtolower(end($tmp));

    $errors = [];

    # Validate Title
    if(empty($title)){
        $errors['title']  = "Field Required...";
    }

    # Validate Desc
    if(empty($desc)){
        $errors['Description'] = "Field Required...";
    }
    # Validate StartDate
    if(empty($sDate)){
        $errors['sDate'] = "Field Required...";
    }
    # Validate EndDate
    if(empty($eDate)){
        $errors['eDate'] = "Field Required...";
    }

    # Check Forms
    echo '<div class="container">';
    if(count($errors) > 0){
        foreach ($errors as $key => $value) {
            echo '<div class="alert alert-danger"> '.$key.' : '.$value.'</div>';
        }
    }else{
        if(in_array($fileExtention,$AllowExtention)) {
            $newFileName = rand().time(). '_' . $fileName;

            if(!move_uploaded_file($fileTmp,"./uploads/" . $newFileName)){
                 $newFileName = 'null';
            }

        }

        $sql = "INSERT INTO `tasks` ( `title`, `desc`, `sDate`, `eDate`, `image`) VALUES ('$title', '$desc', '$sDate', '$eDate', '$newFileName'); ";
        $op  = mysqli_query($con,$sql);
        if($op){
            echo 'Data Inserted';
        }else {
            echo 'Error '.mysqli_error($con);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Add Item</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="exampleInputName">Title</label>
            <input type="text" class="form-control" id="exampleInputName" name="title" placeholder="Enter Name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Description</label>
            <textarea class="form-control" id="exampleInputEmail1" name="desc"></textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Start Date</label>
            <input type="date" class="form-control" id="exampleInputEmail1" name="sDate">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">End Date</label>
            <input type="date" class="form-control" id="exampleInputEmail1" name="eDate">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Upload Image</label>
            <input type="file" id="exampleInputEmail1" name="image" >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
