<?php

include '../pattern/database_connection.php'; //connection à la BD
session_start();


$query = "SELECT * FROM login WHERE user_id != '".$_SESSION['user_id']."'";

$statement = $db->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
        <table class="table table-table-bordered table-striped">
            <tr>
              <td>Username</td>
              <td>Status</td>
              <td>Action</td>
            </tr>
';

foreach($result as $row)
{
  $status = '';
  $current_timestamp = strtotime(date('Y-m-d H:i:s') . '-10 second'); //conversion du string en DATETIME
  $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
  $user_fetch_last_activity = activity($row['user_id'], $db);
  if($user_fetch_last_activity > $current_timestamp)
  {
    $status = '<span class="label label-success">Online</span>';
  }
  else
  {
    $status = '<span class="label label-danger">Offline</span>';
  }
  $output .= '
  <tr>
    <td>'.$row['username'].' '.count_unseen_message($row['user_id'], $_SESSION['user_id'],$db).' '.fetch_is_type_status($row['user_id'], $db).'</td>
    <td>'.$status.'</td>
    <td><button type="button" class="btn btn-info btn-sm " id="start_chat"
 title="Chat with '.$row['username'].'" data-tourserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start chat</button></td>
  </tr>
  ';
}

$output .= '</table>';
echo $output;

?>
