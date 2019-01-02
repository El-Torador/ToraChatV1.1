<!-----------------------------Torador-Corporation--------------------------------------->
<?php
session_start();
  $message = '';
if(isset($_SESSION['user_id'])) // si il existe une session
{
  header('location:index.php'); // on le redirige vers la page index
}

  if(isset($_POST['pseudo']) && isset($_POST['pwd']))
  {
      include 'pattern/database_connection.php'; //connction à la BD
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
                      $sub_query = "INSERT INTO login_details (user_id) VALUES ('".$row['user_id']."')"; //requête pour inserer l'ID de l'utilisatuer dans la table login_details
                      $statement = $db->prepare($sub_query);
                      $statement->execute();
                      $_SESSION['login_details'] = $db->lastInsertId();

                          $query = "UPDATE login SET status = true WHERE user_id = '".$_SESSION['user_id']."'"; // Active le statut de l'utilsateur recemment connecté
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



<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="">
    <link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css">
    <link href="Bootstrap/fonts/glyphicons-halflings-regular.svg">
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="view/style/style.css">
    <title>Accueil</title>
</head>

<body>
    <header class="row">
        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="col-sm-2"><img src="Torador_logoV1.png" width="50" height="50" title="Torador-Corporation" onclick="alert('Torador-Corporation \n All rights reseved !');"></span>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li id="home"> <a href="login.php">Accueil</a> </li>
                    <li id="actu" title="Connectez-vous pour y acceder"> <a>Actualité</a> </li>
                    <li id="chat" title="Connectez-vous pour y acceder"> <a>Messagerie</a> </li>
                </ul>
                <button type="button" data-toggle="modal" data-backdrop="true" title="Register" href="#modale" class="btn btn-default btn-lg pull-right"><span class="glyphicon glyphicon-user"></span></button>
            </div>
        </nav>

    </header>


    <div class="modal fade" id="modale">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><span style="font-family:Agency-FB;">REGISTER</span>
                    <button data-dismiss="modal" class="close">x</button>
                </div>
                <div class="modal-body">
                    <form method="post" id="modalform">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username"  required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="validate" placeholder="Confirm password" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="email">
                        </div>
                        <div class="btn-group" data-toggle="buttons"  required>
                            <label class="btn btn-info">
                                <input type="checkbox" name="masculin" value="M">Masculin
                            </label>
                            <label class="btn btn-info">
                                <input type="checkbox" name="feminin" value="F">Féminin
                            </label>
                        </div><br><br>

                        <div class="form-group">
                            <span class="pull-right">
                                <button type="reset" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Annuler</button>
                            </span>

                            <span class="pull-right"><button type="submit" id="modalsubmit" onclick="verif();" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span>Envoyer</button></span>
                        </div>
                        <div class="form-group">
                            <div class="row"></div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <br><br><br><br><br><br><br><br>
        <div class="panel panel-default col-sm-offset-4 col-sm-4 col-sm-offset-4">
            <div class="panel-heading">
                CONNEXION
            </div>
            <div class="panel-body">
                <p class="text-danger">
                    <?php echo $message; ?>
                </p>
                <form method="post" >
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-user"></span></button></span>
                            <input type="text" class="form-control" name="pseudo" placeholder="Username" aria-describedby="basic-addon1" required>
                        </div>


                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon2"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-lock"></span></button></span>
                            <input type="password" class="form-control" name="pwd" placeholder="password" aria-describedby="basic-addon2" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-log-in"></span> Login</button>
                    </div>
                </form>
            </div>
        </div>

    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <script src="Bootstrap/jQuery/jquery.min.js"></script>
    <script src="Bootstrap/Js/bootstrap.min.js"></script>
    <script src="scirpt.js"></script>

    <?php include_once 'controler/inscription_post.php'; include 'view/footer.php'; ?>

</body>

</html>
