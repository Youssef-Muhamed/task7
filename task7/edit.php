<?php
session_start();
require 'dbConnect.php';
require 'helpers.php';

$id = $_GET['id'];

$sql = "select * from tasks where id = $id";
$op   = mysqli_query($con,$sql);

if(mysqli_num_rows($op) == 1){

    $data = mysqli_fetch_assoc($op);
}else{

    $_SESSION['Message'] = "Access Denied";
    header("Location: index.php");
}
if($_SERVER['REQUEST_METHOD'] == "POST"){

// CODE ......
    $title      = Clean($_POST['title']);
    $desc       = Clean($_POST['desc']);
    $sDate      = $_POST['sDate'];
    $eDate      = $_POST['eDate'];

# Validation ......
    $errors = [];

# Validate Name
    if(!validate($title,1)){
        $errors['Name'] = "Field Required";
    }


# Validate Desc
    if(!validate($desc,1)){
        $errors['Email'] = "Field Required";
    }
    # Validate Desc
    if(!validate($sDate,1)){
        $errors['Email'] = "Field Required";
    }
    # Validate Desc
    if(!validate($eDate,1)){
        $errors['Email'] = "Field Required";
    }
    # Validate image
    if(validate($_FILES['image']['name'],1)){

        $tmpPath    =  $_FILES['image']['tmp_name'];
        $imageName  =  $_FILES['image']['name'];
        $imageSize  =  $_FILES['image']['size'];
        $imageType  =  $_FILES['image']['type'];

        $exArray   = explode('.',$imageName);
        $extension = end($exArray);

        $FinalName = rand().time().'.'.$extension;

        $allowedExtension = ["png",'jpg'];

        if(!validate($extension,5)){
            $errors['Image'] = "Error In Extension";
        }

    }

    if(count($errors) > 0){
        foreach ($errors as $key => $value) {
            # code...
            echo '* '.$key.' : '.$value.'<br>';
        }
    }else{

        // db ..........

        // old Image
        $OldImage = $data['image'];


        if(validate($_FILES['image']['name'],1)){
            $desPath = 'uploads/'.$FinalName;

            if(move_uploaded_file($tmpPath,$desPath)){

                unlink('uploads/'.$OldImage);
            }
        }else{
            $FinalName = $OldImage;
        }


        $sql = "UPDATE `tasks` SET `title`='$title',`desc`='$desc',`sDate`='$sDate',`eDate`='$eDate',`image`='$FinalName' WHERE id = $id";
        $op  = mysqli_query($con,$sql);

        if($op){
            $message =  'Data Updated';
        }else{
            echo  'Error Try Again'.mysqli_error($con);

        }

    }

    $_SESSION['Message'] = $message;
    header("Location: index.php");


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>edit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Edit Item</h2>
    <form action="edit.php?id=<?php echo $data['id'];?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="exampleInputName">Title</label>
            <input type="text" class="form-control" id="exampleInputName" name="title" placeholder="Enter Name" value="<?php echo $data['title'] ?>">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Description</label>
            <textarea class="form-control" id="exampleInputEmail1" name="desc"><?php echo $data['title'] ?></textarea>
        </div

        <div class="form-group">
            <label for="exampleInputEmail">Start Date</label>
            <input type="date" class="form-control" id="exampleInputEmail1" name="sDate" value="<?php echo $data['sDate'] ?>">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">End Date</label>
            <input type="date" class="form-control" id="exampleInputEmail1" name="eDate" value="<?php echo $data['eDate'] ?>">
        </div>
        
        <div class="form-group">
            <label for="exampleInputEmail">Upload Image</label>
            <input type="file" id="exampleInputEmail1" name="image" >
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
