<?php    

include '../pattern/database_connection.php';
session_start();

$query = " UPDATE login_details SET is_type = '".$_POST["is_type"]."' WHERE login_details_id = '".$_SESSION["login_details_id"]."'";

$statement = $db->prepare($query);
$statement->execute();

?>
