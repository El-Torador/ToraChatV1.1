<!------------------------------------------Torador-Corporation---------------------------------------------->
<?php

if(isset($_POST['username']) AND isset($_POST['password']) AND isset($_POST['validate']) AND isset($_POST['email']))
{
        if(isset($_POST['masculin']))
        {
                $sexe = 'M';
                if($_POST['password'] == $_POST['validate'])
                {

                        include 'pattern/database_connection.php';
                        $hash_passwd = sha1($_POST['password']);
                        $req = "INSERT INTO login(user_id, username, password, email, sexe, date_register) VALUES('', :username, :password, :email, :sexe, NOW())";
                        $statement = $db->prepare($req);
                        $statement->execute(array(
                                ':username' => $_POST['username'],
                                ':password' => $hash_passwd,
                                ':email' => $_POST['email'],
                                ':sexe' => $sexe
                        ));


                        echo '<script>alert("Register Successful !"); document.location="login.php";</script>';
                }
                else
                {
                        echo '<script>alert("Not identical password"); document.location="login.php";</script>';
                }
        }
        else if(isset($_POST['feminin']))
        {
                $sexe = 'F';
                if($_POST['password'] == $_POST['validate'])
                {

                        include 'pattern/database_connection.php';
                        $hash_passwd = sha1($_POST['password']);
                        $req = "INSERT INTO login(user_id, username, password, email, sexe, date_register) VALUES('', :username, :password, :email, :sexe, NOW())";
                        $statement = $db->prepare($req);
                        $statement->execute(array(
                                ':username' => $_POST['username'],
                                ':password' => $hash_passwd,
                                ':email' => $_POST['email'],
                                ':sexe' => $sexe
                        ));


                        echo '<script>alert("Register Successful !"); document.location="login.php";</script>';


                }
                else
                {
                        echo '<script>alert("Not identical password"); document.location="login.php";</script>';

                }
        }
        else {
                echo '<script>alert("sexe is not checked !"); document.locaton="login.php";</script>';
        }

}

?>
