<?php
require 'dbConnect.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass = md5($pass);

    $sql = "select name,email,pass from users where email = '$email' AND pass = '$pass'";
    $op = mysqli_query($con, $sql);
    if (mysqli_num_rows($op) > 0) {
        $data = mysqli_fetch_assoc($op);
        $_SESSION['user'] = $data;
        header('Location: index.php');
    } else {
        echo 'Not Valid Email';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>login</h2>


    <form  action="<?php echo $_SERVER['PHP_SELF'];?>"   method="post">

        <div class="form-group">
            <label for="exampleInputEmail">Email address</label>
            <input type="email"   class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword">Password</label>
            <input type="password"   class="form-control" id="exampleInputPassword1" name="pass" placeholder="Password">
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <br>
    <p>If You Don't Have Email Go To <a href="register.php">SignUp</a></p>
</div>

</body>
</html>
