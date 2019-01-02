<?php
  include '../pattern/database_connection.php';
  session_start();

   if(isset($_POST["action"]))
   {
     if($_POST["action"] == "insert_data")
     {
       $data = array(
         ':from_user_id' => $_SESSION["user_id"],
         ':chat_message' => $_POST["chat_message"],
         ':status'       => '1'
       );
       $query = "INSERT INTO chat_message (from_user_id, chat_message, status) VALUES(:from_user_id, :chat_message, :status)";
       $statement = $db->prepare($query);
       if($statement->execute($data))
       {
         echo fetch_group_chat_history($db);
       }
     }
     if($_POST["action"] == "fetch_data")
     {
       echo fetch_group_chat_history($db);
     }
   }


?>
