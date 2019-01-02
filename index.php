<?php
 include 'controler/access_index.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width-device, initial-scale=1">
    <title>Messagerie</title>
    <link rel="stylesheet" href="Bootstrap/jQuery/jquery-ui-1.12.1.custom/jquery-ui.css">
    <link rel="stylesheet" href="view/style/styleBar.css">
    <script src="Bootstrap/jQuery/jquery.js"></script>
    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
    <script src="Bootstrap/jQuery/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <link rel="stylesheet" href="Bootstrap/css/bootstrap.css">
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="Bootstrap/fonts/glyphicon-halflings-regular.svg">
    <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
    <script type="text/javascript" src="mervick-emojionearea/dist/emojionearea.min.js"></script>
    <link rel="stylesheet" href="mervick-emojionearea/dist/emojionearea.min.css">

</head>

<body>
    <?php include 'view/header.php'; ?>
    <header class="row  navbar-default">
          <div id="MenuIcon">

            <div id="MenuLine">  </div>
            <div id="MainMenu">
                  <div id="logo"><img src="Torador_logoV1.png" width="75" height="75"></div>
                  <ul>
                      <li><a class="glyphicon glyphicon-camera btn-lg" style=" text-decoration:none;" title="Profil" href=""></a><div class="line"></div></li>
                      <li><a class="glyphicon glyphicon-envelope btn-lg" style=" text-decoration:none;" title="Messages" href=""></a><div class="line"></div></li>
                      <li><a class="glyphicon glyphicon-user btn-lg" style=" text-decoration:none;" title="Contacts" href=""></a><div class="line"></div></li>
                      <li><a class="glyphicon glyphicon-cog btn-lg" style=" text-decoration:none;" title="Settings" href=""></a><div class="line"></div></li>
                      <li><a class="glyphicon glyphicon-log-out btn-lg" style=" text-decoration:none;" title="logout" href="controler/logout.php"></a><div class="line"></div></li>
                  </ul>
                  <div id="close"> <img src="view/close2.png" alt="close" width="30px" height="30px"></div>
            </div>
          </div>
      </header>
    <!--<header class="row  navbar-default">
          <div id="toraIcon">
            <div id="toraLine">  </div>
            <div id="toraMenu">
                  <div id="logo"><img src="Torador_logoV1.png" width="75" height="75"> <br> <?php echo '<b class="text-info" style="font-size:24px;">'.$_SESSION['username'].' </b>'; ?></div>
                  <ul>
                      <li><a class="glyphicon glyphicon-camera btn-lg" style=" text-decoration:none;" title="Profil" href=""></a><div class="tora-line"></div></li>
                      <li><a class="glyphicon glyphicon-envelope btn-lg" style=" text-decoration:none;" title="Messages" href=""></a><div class="tora-line"></div></li>
                      <li><a class="glyphicon glyphicon-user btn-lg" style=" text-decoration:none;" title="Contacts" href=""></a><div class="tora-line"></div></li>
                      <li><a class="glyphicon glyphicon-cog btn-lg" style=" text-decoration:none;" title="Settings" href=""></a><div class="tora-line"></div></li>
                      <li><a class="glyphicon glyphicon-log-out btn-lg" style=" text-decoration:none;" title="logout" href="controler/logout.php"></a><div class="tora-line"></div></li>
                  </ul>
                  <div id="close"> <img src="view/close2.png" alt="close" title="close" width="30px" height="30px"></div>
            </div>
          </div>
      </header>-->


    <h1 style="text-align:center; font-family:Agency-FB;"><span class="glyphicon glyphicon-bullhorn"></span><br>MESSAGERIE</h1>
    <br><br><br>
    <div id="group_chat_dialog" title="Group Chat Windows">
      <div id="group_chat_history" style="height:400px; border: 1px solid #ccc; overflow-y:scroll; margin-bottom:24px; padding: 16px;">

      </div>
      <div class="form-group">
          <textarea name="group_chat_message" id="group_chat_message" class="form-control"></textarea>
      </div>
      <div class="form-group" align="right">
        <button type="button" name="send_group_chat" id="send_group_chat" title="send" class="btn btn-info"><span class="glyphicon glyphicon-send"></span></button>
      </div>
    </div>
    <div class="container">

        <div class="table-table-responsive">
            <h4 align="center">Outline<a class="glyphicon glyphicon-refresh btn-lg" style="color:green; text-decoration:none;" title="refresh" href="index.php"></a></h4>
            <p align="right"><input type="hidden" id="is_active_group_chat_window" value="no"><button type="button" name="group_chat" id="group_chat" class="btn btn-warning btn-md" title="customize your group chat">Group Chat</button> <span><br><br></span>

            <div class="user_details"></div>
            <div id="user_model_details" class="ui">

            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <script src="scirpt.js"></script>
    <script>
        $(document).ready(function() {

            fetch_user();

            setInterval(function() {
                update_last_activity();
                fetch_user();
                update_chat_history_data();
                fetch_group_chat_history();
            }, 1000);

            function fetch_user() {
                $.ajax({
                    url: "controler/fetch_user.php",
                    method: "POST",
                    success: function(data) {
                        $('.user_details').html(data);
                    }
                });
            }

            function update_last_activity() {
                $.ajax({
                    url: "controler/update_last_activity.php",
                    success: function() {

                    }
                });
            }

            function make_chat_dialog_box(to_user_id, to_user_name) {

                let modal_content = '<div id="user_dialog_' + to_user_id + '" class="user_dialog" title="You have chat with ' + to_user_name + '">';
                modal_content += '<div style="height:400px; border: 1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="' + to_user_id + '" id="chat_history' + to_user_id + '">';
                modal_content += fetch_user_chat_history(to_user_id);
                modal_content += '</div>';
                modal_content += '<div class="form-group"><div class="input-group" style="color:white;">';
                modal_content += '<textarea name="chat_message_' + to_user_id + '" aria-describedby="basic-addon1" placeholder="Type message..."  id="chat_message_' + to_user_id + '" class="form-control chat_message" ></textarea><span class="input-group-addon" id="basic-addon1"><button type="button" name="send_chat" id="' + to_user_id + '" class="btn btn-info btn-lg send_chat" style="border-radius:30px;" title="Send"><span class="glyphicon glyphicon-send"></span></button></span></div></div>';
                $('#user_model_details').hide();
                $('.ui').html(modal_content);
                $('#user_model_details').html(modal_content);
            }
            $(document).on('click', '#start_chat', function() {
                let to_user_id = $(this).data('tourserid');
                let to_user_name = $(this).data('tousername');
                make_chat_dialog_box(to_user_id, to_user_name);
                $("#user_dialog_" + to_user_id).dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true
                });
                $("#user_dialog_" + to_user_id).dialog('open');
                $('#chat_message_'+to_user_id).emojioneArea({
                  pickerPosition:"top",
                  toneStyle: "bullet"
                });

            });


            $(document).on('click', '.send_chat', function() {
                let to_user_id = $(this).attr('id');
                let chat_message = $('#chat_message_' + to_user_id).val();
                $.ajax({
                    url: "controler/insert_chat.php",
                    method: "POST",
                    data: {
                        to_user_id: to_user_id,
                        chat_message: chat_message
                    },
                    success: function(data) {
                        // $('#chat_message_' + to_user_id).val('');
                        let element = $('#chat_message_'+to_user_id).emojioneArea();
                        element[0].emojioneArea.setText('');
                        $('#chat_history' + to_user_id).html(data);
                    }
                });
            });

            function fetch_user_chat_history(to_user_id) {
                $.ajax({
                    url: "controler/fetch_user_chat_history.php",
                    method: "POST",
                    data: {
                        to_user_id: to_user_id
                    },
                    success: function(data) {
                        $('#chat_history' + to_user_id).html(data);
                    }
                });
            }

            function update_chat_history_data() {
                $('.chat_history').each(function() {
                    let to_user_id = $(this).data('touserid');
                    fetch_user_chat_history(to_user_id);
                });
            }
            $(document).on('click', '.ui-button-icon', function() {
                $('.user_dialog').dialog('destroy').remove();
            });

            $(document).on('focus', '.chat_message', function() {
                let is_type = 'yes';
                $.ajax({
                    url: "controler/update_is_type_status.php",
                    method: "POST",
                    data: {
                        is_type: is_type
                    },
                    success: function() {

                    }
                });
            });

            $(document).on('blur', '.chat_message', function() {
                let is_type = 'no';
                $.ajax({
                    url: "controler/update_is_type_status.php",
                    method: "POST",
                    data: {
                        is_type: is_type
                    },
                    success: function() {

                    }
                });
            });

           $('#group_chat_dialog').dialog({
              autoOpen: false,
              width: 400,
              modal: true
            });
            $('#group_chat').click(function(){
              $('#group_chat_dialog').dialog('open');
              $('is_active_group_chat_window').val('yes');
              fetch_group_chat_history();
            });

            $('#send_group_chat').click(function(){
              let chat_message = $('#group_chat_message').val();
              let action = 'insert_data';
              if(chat_message != '')
              {
                $.ajax({
                  url: "controler/group_chat.php",
                  method: "POST",
                  data:{chat_message:chat_message, action:action},
                  success:function(data){
                    $('#group_chat_message').val('');
                    $('#group_chat_history').html(data);
                  }
                });
              }
            });
            $('#group_chat_message').emojioneArea({
                pickerPosition:"top",
                toneStyle: "bullet"
              });

            function fetch_group_chat_history()
            {
              let group_chat_dialog_active = $('#is_active_group_chat_window').val();
              let action = "fetch_data";
              if(group_chat_dialog_active == 'yes')
              {
                $.ajax({
                  url: "controler/group_chat.php",
                  method: "POST",
                  data:{action:action},
                  success:function(data)
                  {
                    $('#group_chat_history').html(data);
                  }
                });
              }
            }

            $('#MenuIcon').on('click',function(){
                    $('#MainMenu').css('left', '0px');
                    function showMenu()
                    {
                        $('#MainMenu').css('-webkit-clip-path', 'polygon(0 0,100% 0,100% 100%, 0% 100%)');
                        $('#MainMenu').animate({right:'-100'}, 300);
                     }
                     setTimeout(showMenu,100);
                });

                $('#close').on('click',function(){
                    $('#MainMenu').css('-webkit-clip-path', 'polygon(0 0,0% 0,0% 100%, 0% 100%)');
                    function hideMenu()
                    {
                        $('#MainMenu').css('left', '-300px');
                        $('#MainMenu').animate({right:'50'}, 300);
                    }
                    setTimeout(hideMenu,300);
                });

        });

    </script>
    <?php /* include 'view/footer.php'; */ ?>
  </body>

  </html>
