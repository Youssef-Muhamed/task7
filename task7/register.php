<?php
require 'dbConnect.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name     = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $email    = $_POST['email'];
    $password = md5($_POST['pass']);

    $errors = [];

    # Validate Name
    if(empty($name)){
        $errors['Name']  = "Field Required...";
    }

    # Validate Email
    if(empty($email)){
        $errors['Email'] = "Field Required...";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['Email'] = "Inter Vaild Email Email Must Be Have a( . - @ ) Charcters...";
    }

    #Validate Password
    if(empty($password)){
        $errors['Password'] = "Field Required...";
    }

    if(strlen($password) < 6){
        $errors['Password']  = "Password Length must be > 6 Charcters... ";
    }


    # Check Forms
    echo '<div class="container">';
    if(count($errors) > 0){
        foreach ($errors as $key => $value) {
            echo '<div class="alert alert-danger"> '.$key.' : '.$value.'</div>';
        }
    }else{
        $sql = "insert into users (name,email,pass) values ('$name','$email','$password') ";
        $op  = mysqli_query($con,$sql);
        if($op){
            echo 'Congrats!!!';
            $_SESSION['user'] = $name;
            header('Location: index.php');
        }else {
            echo 'Error '.mysqli_error($con);
        }
    }
    echo '</div>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Register</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="form-group">
            <label for="exampleInputName">Name</label>
            <input type="text" class="form-control" id="exampleInputName" name="name" placeholder="Enter Name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Password</label>
            <input type="password" class="form-control" id="exampleInputEmail1" name="pass" placeholder="Enter Password">
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

</body>
</html>