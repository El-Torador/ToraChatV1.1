<?php
    include '../pattern/database_connection.php';
session_start();
$statement = $db->prepare("UPDATE login SET status =false WHERE user_id = '".$_SESSION['user_id']."'");
$statement->execute();
session_destroy();
header('location:../login.php');
?>
