<?php

include 'loader.php';
include 'theme/header.php';

$user = $db->select('users', ['id' => $_GET['id']]);

?>

<style>
    .onlineDot {
      display: inline-block;
      width: 6px;
      height: 6px;
      border-radius: 100%;
      vertical-align: top;
    }

    .greenDot {
      background-color: greenyellow;
    }

    .redDot {
      background: red;
    }


</style>

<header class="header">
  <a href="index.php"><img src="images/icon_left_arrow.png" class="back_arrow" /></a>
  <span class="show name"><?= $user[0]['first_name'] . ' ' . $user[0]['last_name']; ?></span>
  <span class="onlineDot greenDot <?php echo ($user[0]['status'] == '1') ? 'redDot' : 'greenDot'; ?>"></span>
  <span class="show title">
    <img src="images/icon_vertical_dots.png" class="three_dot" />
    <ul class="chat_menu">
      <li>Add to Friends</li>
      <li>Block</li>
    </ul>
  </span>
</header>

<div class="inbox">
  <div class="messages"></div>

  <div class="send_message">
    <div type="text" name="message" id="send_message_input" role="textbox" contenteditable></div>
    <img src="images/icon_send_message.png" class="send_message_icon" id="send_btn" />
  </div>
</div>
<!-- Inbox -->

<script>
  let three_dots = document.querySelector(".three_dot");
  let chat_menu = document.querySelector("ul.chat_menu");

  const send_message = document.querySelector('#send_message_input');
  const send_btn = document.querySelector('#send_btn');
  
  var messages = document.querySelector('.messages');

  three_dots.addEventListener("click", (e) => {
    e.stopPropagation();
    if (chat_menu.style.opacity == 0) {
      chat_menu.style.opacity = 1;
    } else {
      chat_menu.style.opacity = 0;
    }
  });

  chat_menu.addEventListener("click", (e) => {
    e.stopPropagation();
  });

  document.addEventListener("click", () => {
    chat_menu.style.opacity = 0;
  });

  get_messages();
  setInterval(get_messages,1000); //get messages every 1s

  function get_messages (response) {
    var formData = new FormData();
    formData.append('send_from', <?php echo $_SESSION['user_id']; ?>);
    formData.append('send_to', <?php echo $_GET['id']; ?>);
    fetch('/get_messages.php', {
      method: "POST",
      body: formData
    })
    .then(function(response) {
      return response.text();
    })
    .then(function(response) {
      messages.innerHTML = response;
      messages.scrollTo = messages.scrollHeight;
    })
    .catch(function(error){
      console.log(error);
    });
  }

  send_btn.addEventListener('click', () => {
    fetch('/send_messages.php', {
      method: "POST",
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        message_from: "<?php echo $_SESSION['user_id']; ?>",
        message_to: "<?php echo $_GET['id']; ?>",
        message: send_message.innerHTML,
      })
    })
    .then(function(response){
      return response.json();
    })
    .then(function(response){
      send_message.innerHTML = ""; //clear input text area after message send to server
    })
    .catch(function(error){
      console.log(error);
    });
  });



</script>