<?php
session_start();
  $message = '';
if(isset($_SESSION['user_id']))
{
  header('location:index.php');
}

  if(isset($_POST['pseudo']) && isset($_POST['pwd']))
  {
      include '../pattern/database_connection.php';
      $hash_pass = sha1($_POST['pwd']);
      $query = "SELECT * FROM login WHERE username = :username AND status = false";
      $statement =$db->prepare($query);
      $statement->execute(array(
          ':username' => $_POST['pseudo']
      ));

      $count = $statement->rowCount();
      if($count > 0)
      {
          $result = $statement->fetchAll();

          foreach($result as $row)
          {

                  if($hash_pass == $row['password'])
                  {
                      $_SESSION['user_id'] = $row['user_id'];
                      $_SESSION['username'] = $row['username'];
                      $_SESSION['status'] = $row['status'];
                      $sub_query = "INSERT INTO login_details (user_id) VALUES ('".$row['user_id']."')";
                      $statement = $db->prepare($sub_query);
                      $statement->execute();
                      $_SESSION['login_details'] = $db->lastInsertId();

                          $query = "UPDATE login SET status = true WHERE user_id = '".$_SESSION['user_id']."'";
                          $statement = $db->prepare($query);
                          $statement->execute();
                          header('location:index.php');
                      }

                  else
                  {
                      $message = '<label>Wrong Password !</label>';
                  }

          }
      }
      else
      {
          $message = '<label>Wrong Username or user is online ! please retry</label>';
      }
  }





 ?>
