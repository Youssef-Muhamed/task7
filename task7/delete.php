<?php
require 'dbConnect.php';
session_start();

$id = $_GET['id'];
$sql = "select * from tasks where id = $id";
$op = mysqli_query($con, $sql);
if (mysqli_num_rows($op) == 1) {

    $sql = "delete from tasks where id = $id ";
    $op = mysqli_query($con, $sql);

    if ($op) {
        $message = 'raw deleted';
    } else {
        $message = 'error Try Again !!!!!! ';
    }
} else {
    $message = 'Error In User Id ';
}
$_SESSION['Message'] = $message;

header("Location: index.php");