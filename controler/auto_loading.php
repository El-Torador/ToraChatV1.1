<? php 


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

?>
