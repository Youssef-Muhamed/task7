<?php
require 'dbConnect.php';
if (!isset($_SESSION['user'])) {
    header("Location: inlog.php");
}