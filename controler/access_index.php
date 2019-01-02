<?php

include 'pattern/database_connection.php';

session_start();

if(!isset($_SESSION['user_id']))
{
  header('location:login.php');
}


?>
