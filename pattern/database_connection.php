<!-------------------------------------------------------Torador-Corporation-------------------------------------------------------------------------------------------------------->

<?php
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=apps;charset=utf8mb4', 'root', '');
    }catch(Exception $e)
    {
        die('<script>alert("Erreur de connexion !")</script>'.$e->getMessage());
    }

   function activity($user_id, $_connect)
    {
        $query = "SELECT * FROM login_details WHERE user_id = '$user_id' ORDER BY last_activity DESC LIMIT 1"; // selectionne par ordre decroissant et limité à 1 tous les entrées dont l'ID de l'utilisateur courant = user_id.login_details
        $statement = $_connect->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll();

        foreach ($result as $row)
        {
            $_SESSION['login_details_id']=$row['login_details_id']; //affectation de login_details_id  de la requête precedente à la session du user recemment connecté
            return $row['last_activity'];
        }
    }

function fetch_user_chat_history($from_user_id, $to_user_id, $db)
{
    $query = "
        SELECT * FROM chat_message
        WHERE (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') OR (from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."') ORDER BY timestamp DESC
    ";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '<ul class="list-unstyled">';
    foreach($result as $row)
    {
        $user_name = '';
        if($row["from_user_id"]== $from_user_id)
        {
            $user_name = '<b class="text-success">You</b>';
        }
        else
        {
            $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $db).'</b>';
        }
        $output .= '
            <li style="border-bottom:1px dotted #ccc">
                <p>'.$user_name.' - '.$row["chat_message"].'
                    <div align="right">
                        - <small><em>'.$row["timestamp"].'</em></small>
                    </div>
                </p>
            </li>
        ';
    }
    $output .= '</ul>';
    $query = "UPDATE chat_message SET status = '0' WHERE from_user_id ='".$to_user_id."' AND to_user_id = '".$from_user_id."' AND status = '1' ";
    $statement = $db->prepare($query);
    $statement->execute();
    return $output;
}

function get_user_name($user_id, $db)
{
    $query = "SELECT username FROM login WHERE user_id = '$user_id' ";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach($result as $row)
    {
        return $row['username'];
    }
}

function count_unseen_message($from_user_id, $to_user_id, $db)
{
    $query = " SELECT * FROM chat_message WHERE from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."' AND status = '1' ";
    $statement = $db->prepare($query);
    $statement->execute();
    $count = $statement->rowCount();
    $result = $statement->fetchAll();
    foreach($result as $row){ $compte = $row['status'];}
    $output = '';
    if($count > 0 && $compte==1)
    {
        $output = '<span class="label label-success">'.$count.'</span>';
    }

    return $output;
}

function fetch_is_type_status($user_id, $db)
{
    if(isset($user_id)){
    $query = "SELECT is_type FROM login_d￼etails WHERE user_id = '".$user_id."' ORDER BY last_activity DESC LIMIT 1";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
      $output = '';
    foreach($result as $row)
    {
        if($row["is_type"] == 'yes')
        {
            $output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
        }
    }
    return $output;
    }
}

function fetch_group_chat_history($db)
{
  $query = "SELECT * FROM chat_message WHERE to_user_id = '0' ORDER BY timestamp DESC ";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '<ul class="list-unstyled">';
  foreach($result as $row)
  {
    $user_name = '';
    if($row["from_user_id"] == $_SESSION["user_id"])
    {
      $user_name = '<b class="text-success">You</b>';
    }
    else
    {
      $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $db).'</b>';
    }
    $output .= '
    <li style="border-bottom:1px dotted #ccc;">
      <p>'.$user_name.' - '.$row['chat_message'].'
        <div align="right">
          - <small><em>'.$row['timestamp'].'</em></small>
        </div>
      </p>
    </li>
    ';
  }
   $output .='</ul>';
   return $output;
}

/*function notification($from_user_id, $db)
{
   $query = "SELECT COUNT(status) as nbreDiscussion FROM chat_message WHERE status = 1 AND from_user_id = '".$from_user_id."'";
   $statement = $db->prepare($query);
   $result = $statement->fetch();
   $output = '';
   if(!empty($result))
   {
      $output = '<span class=""></span>';
   }


}*/
?>


<!---------------------------------------------------------Cordialement----------------------------------------------------------------------------------------->
